<?php

namespace App\Http\Controllers\Funds;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Member_latest_txninfo;
use App\Models\Member_transfer_list;
use App\Models\Member_wallet_balance;

class WalletTransferController extends Controller
{
    public function index()
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;

        $get_balance = Member_wallet_balance::where('userId', $userId)->first();
        $userdata = User::where('role', '!=', 'admin')->get()->toarray();
        $userIdList = array();
        $userNameList = array();
        foreach ($userdata as $key => $user) {
            array_push($userIdList, $user['userId']);
            array_push($userNameList, $user['name']);
        }
        return view('pages.funds.transfer')->with(['data' => $get_balance, 'userIdList' => $userIdList, 'userNameList' => $userNameList]);
    }

    public function transfer(Request $request)
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;
        $otheruserid = $request->otheruserid;
        $amount = $request->amount;

        try {
            $new_member_transfer = new Member_transfer_list;
            $new_member_transfer->userId =  $userId;
            $new_member_transfer->otheruserid =  $otheruserid;
            $new_member_transfer->amount =  $amount;
            $new_member_transfer->save();
            // minus from his cash wallet
            $last_transfertoother_query = Member_wallet_balance::where('userId', $userId)->first();
            if ($last_transfertoother_query) {
                $transfertoother = $last_transfertoother_query->transfertoother * 1 + $amount * 1;
                $cash_balance = $last_transfertoother_query->cash_balance * 1 - $amount * 1;

                Member_wallet_balance::where('userId', $userId)
                    ->update([
                        'transfertoother' =>  $transfertoother,
                        'cash_balance' =>  $cash_balance,
                    ]);

                // plus otheruserid cash wallet
                $last_otheruser_query = Member_wallet_balance::where('userId', $otheruserid)->first();
                $plused_balance = $last_otheruser_query->cash_balance * 1 + $amount * 1;

                Member_wallet_balance::where('userId', $otheruserid)
                    ->update([
                        'cash_balance' =>  $plused_balance,
                    ]);

                return response()->json(['status' => 200]);
            }
        } catch (\Exception $e) {
            $error = 'Error: ' . $e->getMessage();
            return response()->json(['status' => 400, 'error' => $error]);
        }
    }
}
