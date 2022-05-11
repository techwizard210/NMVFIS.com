<?php

namespace App\Http\Controllers\Funds;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Member_latest_txninfo;
use App\Models\Member_investment_list;
use App\Models\Member_referral_list;
use App\Models\Users_affiliate_structure;
use App\Models\Member_binarybonus_list;
use App\Models\Member_wallet_balance;
use App\Models\Member_withdrawal_balance;

class InvestmentController extends Controller
{
    public function index()
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;
        // $get_balance = Member_latest_txninfo::where('userId', $userId)->first();
        $get_cash_balance = Member_wallet_balance::where('userId', $userId)->first();

        $get_invest = Member_investment_list::where('userId', $userId)->where('invest_status', 0)->first();
        if ($get_invest) {
            $invest_status = false;
        } else {
            $invest_status = true;
        }
        return view('pages.funds.investment')->with(['data' => $get_cash_balance, 'invest_status' => $invest_status]);
    }

    public function findBinaryBonusLists($networkId, $placementId, $lists)
    {
        $placementUser = User::where('userId', $placementId)
            ->where('networkid', $networkId)
            ->first();
        $data = '';
        if ($placementUser->order == 0) {
            array_push($lists, $placementUser->userId);
            return $lists;
        } else {
            array_push($lists, $placementId);
            $data = $this->findBinaryBonusLists($networkId, $placementUser->placementId, $lists);
        }
        return $data;
    }

    public function findCurrentPosition($placementId)
    {
        $placementUser = User::where('userId', $placementId)->first();
        $order = $placementUser->order;
        $data = '';
        if ($order == 1) {
            return $placementUser->position;
        } else {
            $data = $this->findCurrentPosition($placementUser->placementId);
        }
        return $data;
    }

    public function addBinaryBonus($userId, $amount)
    {
        $userData = User::where('userId', $userId)->first();
        $sponsorId = $userData->sponsorId;
        $position = $userData->position;
        $userNetworkId = $userData->networkId;
        $userOrder = $userData->order;
        $userPlacementId = $userData->placementId;

        $binaryBonusUserLists = $this->findBinaryBonusLists($userNetworkId, $userPlacementId, array());

        if ($userOrder == 1) {
            $netPosition = $position;
        } else {
            $netPosition = $this->findCurrentPosition($userPlacementId);
        }

        foreach ($binaryBonusUserLists as $key => $binaryUser) {
            if ($netPosition == 'Left') {
                $position_column = 'leftuserData';
                $funds_column = 'leftside_funds';
                $funds_othercolumn = 'rightside_funds';
            } else if ($netPosition == 'Right') {
                $position_column = 'rightUser';
                $funds_column = 'rightside_funds';
                $funds_othercolumn = 'leftside_funds';
            }
            $get_user_affiliate = Users_affiliate_structure::where('userId', $binaryUser)->first();
            if ($get_user_affiliate) {
                $binary_bonus = $get_user_affiliate->binary_bonus;
                $leftside_funds = $get_user_affiliate->leftside_funds;
                $rightside_funds = $get_user_affiliate->rightside_funds;

                if (${$funds_column} > 0) {
                    $new_column_funds = ${$funds_column} * 1 + $amount;
                    Users_affiliate_structure::where('userId', $binaryUser)
                        ->update([
                            $funds_column =>  $new_column_funds,
                        ]);
                } else {
                    if ($amount * 1 - ${$funds_othercolumn} * 1 > 0) {
                        $pairing_funds = ${$funds_othercolumn};
                        $new_column_funds = $amount * 1 - ${$funds_othercolumn} * 1;
                        $new_othercolumn_funds = 0;
                    } else {
                        $pairing_funds = $amount;
                        $new_column_funds = 0;
                        $new_othercolumn_funds = ${$funds_othercolumn} * 1 - $amount * 1;
                    }

                    $add_bonus = $pairing_funds * 1 * 0.1; //Binary Bonus Amount

                    //Update sponsor's income_amount(withdrawal_balance) in member_wallet_balances table (Give Sponsor Binary Bonus)
                    $sponsor_wallet_balance = Member_wallet_balance::where('userId', $binaryUser)->first();
                    $added_income = $sponsor_wallet_balance->income_amount * 1 + $add_bonus;

                    Member_wallet_balance::where('userId', $binaryUser)
                        ->update([
                            'income_amount' =>  $added_income,
                        ]);

                    $new_binary_bonus = $binary_bonus * 1 + $add_bonus * 1;

                    Users_affiliate_structure::where('userId', $binaryUser)
                        ->update([
                            $funds_column =>  $new_column_funds,
                            $funds_othercolumn =>  $new_othercolumn_funds,
                            'binary_bonus' =>  $new_binary_bonus,
                        ]);

                    // Update Sponsor's Rank
                    if ($new_binary_bonus < 50000 && $new_binary_bonus < 10000) {
                        $rank = "Team_Leader";
                    } else if ($new_binary_bonus > 100000 && $new_binary_bonus < 500000) {
                        $rank = "Manager";
                    } else if ($new_binary_bonus > 500000 && $new_binary_bonus < 1000000) {
                        $rank = "Regional_Manager";
                    } else if ($new_binary_bonus > 1000000 && $new_binary_bonus < 3000000) {
                        $rank = "Director";
                    } else if ($new_binary_bonus > 3000000) {
                        $rank = "Managing_Director";
                    }

                    User::where('userId', $binaryUser)
                        ->update([
                            'rank' =>  $rank,
                        ]);
                    //-----------

                    $get_new_affiliate = Users_affiliate_structure::where('userId', $binaryUser)->first();
                    $new_leftside_funds = $get_new_affiliate->leftside_funds;
                    $new_rightside_funds = $get_new_affiliate->rightside_funds;

                    $binaryBonusModel = new Member_binarybonus_list();
                    $binaryBonusModel->userId =  $binaryUser;
                    $binaryBonusModel->bonus =  $add_bonus;
                    $binaryBonusModel->lap_amount =  $amount;
                    $binaryBonusModel->left_bv =  $new_leftside_funds;
                    $binaryBonusModel->right_bv =  $new_rightside_funds;
                    $binaryBonusModel->save();

                    //Update sponsor's income_percent
                    $investmentModel = new Member_investment_list();
                    $getUserInvestData = $investmentModel->getUserInvestData($binaryUser);
                    if ($getUserInvestData->toArray()) {
                        $added_percent = $getUserInvestData->income_percent * 1 + 10;
                        $investmentModel->updateUserIncomePercent($binaryUser, $added_percent);
                    }
                }
            }
        }
    }

    public function investment(Request $request)
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;
        $sponsorId = $user->sponsorId;
        $position = $user->position;
        $order = $user->order;

        $amount = $request->amount;
        $package = $request->package;
        $referral_amount = $amount * 1 * 0.1;

        $investmentModel = new Member_investment_list();
        try {
            $randomDepositId = uniqid();
            $investmentModel->depositId =  $randomDepositId;
            $investmentModel->userId =  $userId;
            $investmentModel->amount =  $amount;
            $investmentModel->package =  $package;
            $investmentModel->invest_status =  0;
            $investmentModel->save();

            $amount = $request['amount'];
            $package = $request['package'];

            $randomDepositId = uniqid();

            // Update member's investment amount
            $last_investment_query = Member_wallet_balance::where('userId', $userId)->first();
            if ($last_investment_query) {
                $investment = $last_investment_query->investment * 1 + $amount * 1;
                $cash_balance = $last_investment_query->cash_balance * 1 - $amount * 1;

                Member_wallet_balance::where('userId', $userId)
                    ->update([
                        'investment' =>  $investment,
                        'cash_balance' =>  $cash_balance,
                    ]);
            }

            // Direct Income for sponsor
            if ($sponsorId) {
                // Add Direct Referral to my sponsor
                $new_member_referral = new Member_referral_list;
                // $new_member_referral->create($referral_amount);
                $new_member_referral->userId =  $userId;
                $new_member_referral->otherUserId =  $sponsorId;
                $new_member_referral->depositId =  $randomDepositId;
                $new_member_referral->amount =  $referral_amount;
                $new_member_referral->save();

                // Update sponsor's income_amount
                $sponsor_wallet_balance = Member_wallet_balance::where('userId', $sponsorId)->first();
                $new_income_amount = $sponsor_wallet_balance->income_amount * 1 + $referral_amount * 1;
                Member_wallet_balance::where('userId', $sponsorId)
                    ->update([
                        'income_amount' =>  $new_income_amount,
                    ]);
            }
            if ($order != 0) {
                $this->addBinaryBonus($userId, $amount);
            }

            return response()->json(['status' => 200]);
        } catch (\Exception $e) {
            $error = 'Error: ' . $e->getMessage();
            return response()->json(['status' => 400, 'error' => $error]);
        }
    }
}
