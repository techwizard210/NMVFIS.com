<?php

namespace App\Http\Controllers\Funds;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Member_investment_list;
use App\Models\Member_referral_list;
use App\Models\Users_affiliate_structure;
use App\Models\Member_binarybonus_list;
use App\Models\Member_wallet_balance;
use App\Models\Direct_Referral_Percentage;
use App\Models\Binary_Bonus_Percentage;
use App\Models\Admin_bb_list_from_member;
use App\Models\Admin_rb_list_from_member;

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

    public function findCurrentPosition($binaryUser, $userId, $placementId)
    {
        $findBinaryUserData = User::where('userId', $binaryUser)->first();
        $binaryUserOrder = $findBinaryUserData->order;

        $placementUser = User::where('userId', $placementId)->first();
        $placementUserOrder = $placementUser->order;

        $layer = $placementUserOrder * 1 - $binaryUserOrder * 1;

        $data = '';
        if ($layer == 1) {
            return $placementUser->position;
        } else {
            $data = $this->findCurrentPosition($binaryUser, $userId, $placementUser->placementId);
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

        // if ($userOrder == 1) {
        //     $netPosition = $position;
        // } else {
        //     $netPosition = $this->findCurrentPosition($userPlacementId);
        // }

        $getBinaryBonusPercentage = Binary_Bonus_Percentage::orderBy('created_at', 'DESC')->first();
        if ($getBinaryBonusPercentage) {
            $binaryBonusPercentage = $getBinaryBonusPercentage->percent * 1 / 100;
        } else {
            $binaryBonusPercentage = 0.1;
        }

        foreach ($binaryBonusUserLists as $key => $binaryUser) {
            if ($binaryUser == $userPlacementId) {
                $netPosition = $position;
            } else {
                $netPosition = $this->findCurrentPosition($binaryUser, $userId, $userPlacementId);
            }

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

                if (${$funds_othercolumn} == 0) {
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

                    $add_bonus = $pairing_funds * 1 * $binaryBonusPercentage; //Binary Bonus Amount
                    $new_binary_bonus = $binary_bonus * 1 + $add_bonus * 1;

                    Users_affiliate_structure::where('userId', $binaryUser)
                        ->update([
                            $funds_column =>  $new_column_funds,
                            $funds_othercolumn =>  $new_othercolumn_funds,
                            'binary_bonus' =>  $new_binary_bonus,
                        ]);


                    // Update BinaryUser's income_amount
                    $binaryUserInvestInfo = Member_investment_list::where('userId', $binaryUser)
                        ->where('invest_status', 0)
                        ->first();

                    $admin_wallet_balance = DB::table('member_wallet_balances as t1')
                        ->leftJoin('users as t2', 't2.userId', '=', 't1.userId')
                        ->where('t2.role', 'admin')
                        ->select('t1.*')
                        ->first();

                    if ($binaryUserInvestInfo) {
                        $investmentamount = $binaryUserInvestInfo->amount;
                        $binaryUserTargetIncome = $investmentamount * 1 * 4.5;

                        $new_income_amount = $binaryUserInvestInfo->income_amount * 1 + $add_bonus * 1;

                        $binaryUser_wallet_balance = Member_wallet_balance::where('userId', $binaryUser)->first();

                        if ($new_income_amount * 1 < $binaryUserTargetIncome * 1) {
                            //Update BinaryUse income_amount
                            $new_BinaryUserIncome = $binaryUser_wallet_balance->income_amount * 1 + $add_bonus * 1;
                            Member_wallet_balance::where('userId', $binaryUser)
                                ->update([
                                    'income_amount' =>  $new_BinaryUserIncome,
                                ]);

                            // Update sponsor's income_percent in Member_investment_lists table
                            $added_percent = $binaryUserInvestInfo->income_percent * 1 + $binaryBonusPercentage * 1 * 100;
                            Member_investment_list::where('userId', $binaryUser)
                                ->update([
                                    'income_amount' =>  $new_income_amount,
                                    'income_percent' =>  $added_percent,
                                ]);

                            // Add Binary Bonus History
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
                        } else {
                            $add_wallet_bonus = $binaryUserTargetIncome * 1 - $binaryUserInvestInfo->income_amount * 1;
                            $new_BinaryUserIncome = $binaryUser_wallet_balance->income_amount * 1 + $add_wallet_bonus * 1;

                            Member_wallet_balance::where('userId', $binaryUser)
                                ->update([
                                    'income_amount' =>  $new_BinaryUserIncome,
                                ]);

                            Member_investment_list::where('userId', $binaryUser)
                                ->where('id', $binaryUserInvestInfo->id)
                                ->update([
                                    'income_amount' =>  $binaryUserTargetIncome,
                                    'income_percent' =>  450,
                                    'invest_status' =>  1,
                                ]);

                            $binaryBonusModel = new Member_binarybonus_list();
                            $binaryBonusModel->userId =  $binaryUser;
                            $binaryBonusModel->bonus =  $add_wallet_bonus;
                            $binaryBonusModel->lap_amount =  $amount;
                            $binaryBonusModel->left_bv =  $new_leftside_funds;
                            $binaryBonusModel->right_bv =  $new_rightside_funds;
                            $binaryBonusModel->save();

                            $extraAmount = $new_income_amount * 1 - $binaryUserTargetIncome * 1;

                            $amount_for_admin = $admin_wallet_balance->income_amount * 1 + $extraAmount * 1;
                            $adminUserId = $admin_wallet_balance->userId;

                            Member_wallet_balance::where('userId', $adminUserId)
                                ->update([
                                    'income_amount' =>  $amount_for_admin,
                                ]);

                            $admin_bb_listModel = new Admin_bb_list_from_member();
                            $admin_bb_listModel->memberId =  $binaryUser;
                            $admin_bb_listModel->amount =  $extraAmount;
                            $admin_bb_listModel->investMember =  $userId;
                            $admin_bb_listModel->investAmount =  $amount;
                            $admin_bb_listModel->flag = 2;
                            $admin_bb_listModel->save();
                        }
                    } else {
                        $admin_bb_listModel = new Admin_bb_list_from_member();
                        $admin_bb_listModel->memberId =  $binaryUser;
                        $admin_bb_listModel->amount =  $add_bonus;
                        $admin_bb_listModel->investMember =  $userId;
                        $admin_bb_listModel->investAmount =  $amount;
                        $admin_bb_listModel->flag = 1;
                        $admin_bb_listModel->save();

                        $new_income_amount = $admin_wallet_balance->income_amount * 1 + $add_bonus * 1;
                        $adminUserId = $admin_wallet_balance->userId;
                        Member_wallet_balance::where('userId', $adminUserId)
                            ->update([
                                'income_amount' =>  $new_income_amount,
                            ]);
                    }


                    // Update BinaryUser's Rank
                    if ($new_binary_bonus > 50000 && $new_binary_bonus < 10000) {
                        $rank = "Team_Leader";
                    } else if ($new_binary_bonus > 100000 && $new_binary_bonus < 500000) {
                        $rank = "Manager";
                    } else if ($new_binary_bonus > 500000 && $new_binary_bonus < 1000000) {
                        $rank = "Regional_Manager";
                    } else if ($new_binary_bonus > 1000000 && $new_binary_bonus < 3000000) {
                        $rank = "Director";
                    } else if ($new_binary_bonus > 3000000) {
                        $rank = "Managing_Director";
                    } else {
                        $rank = "Member";
                    }

                    User::where('userId', $binaryUser)
                        ->update([
                            'rank' =>  $rank,
                        ]);
                    //-----------
                }
            }
        }
    }

    public function directIncome($userId, $sponsorId, $randomDepositId, $amount)
    {
        $getLatestDirectPercentage = Direct_Referral_Percentage::orderBy('created_at', 'DESC')->first();
        if ($getLatestDirectPercentage) {
            $directPercentage = $getLatestDirectPercentage->percent * 1 / 100;
        } else {
            $directPercentage = 0.1;
        }
        $referral_amount =  $amount * 1 * $directPercentage;

        // Update sponsor's income_amount
        $findSponsorInvestInfo = Member_investment_list::where('userId', $sponsorId)
            ->where('invest_status', 0)
            ->first();

        $admin_wallet_balance = DB::table('member_wallet_balances as t1')
            ->leftJoin('users as t2', 't2.userId', '=', 't1.userId')
            ->where('t2.role', 'admin')
            ->select('t1.*')
            ->first();

        if ($findSponsorInvestInfo) {
            $sponsorInvestment = $findSponsorInvestInfo->amount;
            $sponsorTargetIncome = $sponsorInvestment * 1 * 4.5;
            $new_income_amount = $findSponsorInvestInfo->income_amount * 1 + $referral_amount * 1;
            $new_income_percent = $findSponsorInvestInfo->income_percent * 1 + $directPercentage * 100;

            $sponsor_wallet_balance = Member_wallet_balance::where('userId', $sponsorId)->first();
            $new_sponsor_balance = $sponsor_wallet_balance->income_amount * 1 + $referral_amount * 1;

            if ($new_income_amount * 1 < $sponsorTargetIncome * 1) {
                Member_wallet_balance::where('userId', $sponsorId)
                    ->update([
                        'income_amount' =>  $new_sponsor_balance,
                    ]);

                Member_investment_list::where('userId', $sponsorId)
                    ->where('id', $findSponsorInvestInfo->id)
                    ->update([
                        'income_amount' =>  $new_income_amount,
                        'income_percent' =>  $new_income_percent,
                    ]);

                // Add Direct Referral to my sponsor
                $new_member_referral = new Member_referral_list;
                $new_member_referral->userId =  $userId;
                $new_member_referral->otherUserId =  $sponsorId;
                $new_member_referral->depositId =  $randomDepositId;
                $new_member_referral->amount =  $referral_amount;
                $new_member_referral->save();
            } else {
                $add_amount = $sponsorTargetIncome * 1 - $findSponsorInvestInfo->income_amount * 1;
                $new_wallet_income = $sponsor_wallet_balance->income_amount * 1 + $add_amount * 1;

                Member_wallet_balance::where('userId', $sponsorId)
                    ->update([
                        'income_amount' =>  $new_wallet_income,
                    ]);

                Member_investment_list::where('userId', $sponsorId)
                    ->where('id', $findSponsorInvestInfo->id)
                    ->update([
                        'income_amount' =>  $sponsorTargetIncome,
                        'income_percent' =>  450,
                        'invest_status' =>  1,
                    ]);

                $extraAmount = $new_income_amount * 1 - $sponsorTargetIncome * 1;
                $new_admin_income_amount = $admin_wallet_balance->income_amount * 1 + $extraAmount * 1;

                $adminUserId = $admin_wallet_balance->userId;
                Member_wallet_balance::where('userId', $adminUserId)
                    ->update([
                        'income_amount' =>  $new_admin_income_amount,
                    ]);

                // Add Direct Referral to my sponsor
                $new_member_referral = new Member_referral_list;
                $new_member_referral->userId =  $userId;
                $new_member_referral->otherUserId =  $sponsorId;
                $new_member_referral->depositId =  $randomDepositId;
                $new_member_referral->amount =  $add_amount;
                $new_member_referral->save();

                $admin_bb_listModel = new Admin_rb_list_from_member();
                $admin_bb_listModel->memberId =  $sponsorId;
                $admin_bb_listModel->amount =  $extraAmount;
                $admin_bb_listModel->investMember =  $userId;
                $admin_bb_listModel->investAmount =  $amount;
                $admin_bb_listModel->flag = 2;
                $admin_bb_listModel->save();
            }
        } else {
            $new_income_amount = $admin_wallet_balance->income_amount * 1 + $referral_amount * 1;
            $adminUserId = $admin_wallet_balance->userId;

            Member_wallet_balance::where('userId', $adminUserId)
                ->update([
                    'income_amount' =>  $new_income_amount,
                ]);

            $admin_bb_listModel = new Admin_rb_list_from_member();
            $admin_bb_listModel->memberId =  $sponsorId;
            $admin_bb_listModel->amount =  $referral_amount;
            $admin_bb_listModel->investMember =  $userId;
            $admin_bb_listModel->investAmount =  $amount;
            $admin_bb_listModel->flag = 1;
            $admin_bb_listModel->save();
        }
    }

    public function investment(Request $request)
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;
        $userData = User::where('userId', $userId)->first();

        $sponsorId = $userData->sponsorId;
        $position = $userData->position;
        $order = $userData->order;

        $amount = $request->amount;
        $package = $request->package;
        $referral_amount = $amount * 1 * 0.1;

        // The query either already exists or does not exist for the same date.
        $test = Member_investment_list::where('userId', $userId)
            ->where('amount', $amount)
            ->where('invest_status', 0)
            ->first();
            
        if ($test) {
            return response()->json(['status' => 400, 'msg' => 'The same query exists already!']);
        } else {
            try {
                $investmentModel = new Member_investment_list();
                $randomDepositId = uniqid();
                $investmentModel->depositId =  $randomDepositId;
                $investmentModel->userId =  $userId;
                $investmentModel->amount =  $amount;
                $investmentModel->package =  $package;
                $investmentModel->invest_status =  0;
                $investmentModel->save();

                $amount = $request['amount'];
                $package = $request['package'];

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
                    $this->directIncome($userId, $sponsorId, $randomDepositId, $amount);
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
}
