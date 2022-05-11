<?php

namespace App\Http\Controllers\Funds;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Member_latest_txninfo;
use App\Models\Member_investment_list;
use App\Models\Member_investforother_list;
use App\Models\Member_wallet_balance;

use App\Http\Controllers\Funds\InvestmentController;

class InvestForOtherController extends Controller
{
    public function index()
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;

        $get_balance = Member_wallet_balance::where('userId', $userId)->first();
        $userdata = User::where('role', 'user')->get()->toarray();
        $userIdList = array();
        $userNameList = array();
        $invest_status_lists = array();
        foreach ($userdata as $key => $user) {
            array_push($userIdList, $user['userId']);
            array_push($userNameList, $user['name']);
            $get_invest = Member_investment_list::where('userId', $user['userId'])->where('invest_status', 0)->first();
            if ($get_invest) {
                $invest_status = false;
            } else {
                $invest_status = true;
            }
            array_push($invest_status_lists, $invest_status);
        }

        return view('pages.funds.invest_others')
            ->with([
                'userId' => $userId,
                'data' => $get_balance,
                'userIdList' => $userIdList,
                'userNameList' => $userNameList,
                'invest_status_lists' => $invest_status_lists
            ]);
    }

    public function investforother(Request $request)
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;
        $otheruserid = $request->otheruserid;
        $amount = $request->amount;
        $package = $request->package;

        try {
            //Create Member's New Investforother List
            $new_member_investforother = new Member_investforother_list;
            $new_member_investforother->userId =  $userId;
            $new_member_investforother->otheruserid =  $otheruserid;
            $new_member_investforother->amount =  $amount;
            $new_member_investforother->package =  $package;
            $new_member_investforother->save();

            // Update member's investforother amount
            $last_investforother_query = Member_wallet_balance::where('userId', $userId)->first();
            if ($last_investforother_query) {
                $investforother = $last_investforother_query->investforother * 1 + $amount * 1;
                $cash_balance = $last_investforother_query->cash_balance * 1 - $amount * 1;
                Member_wallet_balance::where('userId', $userId)
                    ->update([
                        'investforother' =>  $investforother,
                        'cash_balance' =>  $cash_balance,
                    ]);
            }

            //Create new investment list by otherUserId
            $otherUser_New_investmentlist = new Member_investment_list;
            $randomDepositId = uniqid();
            $otherUser_New_investmentlist->depositId =  $randomDepositId;
            $otherUser_New_investmentlist->userId =  $otheruserid;
            $otherUser_New_investmentlist->amount =  $amount;
            $otherUser_New_investmentlist->package =  $package;
            $otherUser_New_investmentlist->invest_status =  0;
            $otherUser_New_investmentlist->save();

            // Update other member's balance
            $update_othermember_balance = Member_wallet_balance::where('userId', $otheruserid)->first();
            if ($update_othermember_balance) {
                $update_investment = $update_othermember_balance->investment * 1 + $amount * 1;
                Member_wallet_balance::where('userId', $otheruserid)
                    ->update([
                        'investment' =>  $update_investment,
                    ]);
            }

            $investment_controller = new InvestmentController;
            $otherUserInfo = User::where('userId', $otheruserid)->first();
            $otheruser_order = $otherUserInfo->order;
            $otheruser_sponsorId = $otherUserInfo->sponsorId;
            $referral_amount = $amount * 1 * 0.1;
            $randomDepositId = uniqid();
            if ($otheruser_order != 0) {
                $investment_controller->addBinaryBonus($otheruserid, $amount);
            }
            if ($otheruser_sponsorId) {
                $investment_controller->directIncome($otheruserid, $otheruser_sponsorId, $randomDepositId, $amount);
            }

            return response()->json(['status' => 200]);
        } catch (\Exception $e) {
            $error = 'Error: ' . $e->getMessage();
            return response()->json(['status' => 400, 'error' => $error]);
        }
    }
}
