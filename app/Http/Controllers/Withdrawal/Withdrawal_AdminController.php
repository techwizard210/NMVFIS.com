<?php

namespace App\Http\Controllers\Withdrawal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Models\Member_latest_txninfo;
use App\Models\Member_binarybonus_list;
use App\Models\Member_withdrawal_balance;
use App\Models\Member_wallet_balance;

class Withdrawal_AdminController extends Controller
{
    public function index()
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;

        $data = Member_wallet_balance::where('userId', $userId)->first();

        return view('pages.income.elite')->with(['data' => $data]);
    }

    // public function withdrawal(Request $request)
    // {
    //     $user = Session::get('user');   // Session User Data
    //     $userId = $user->userId;
    //     $amount = $request->amount;

    //     try {
    //         $withdrawal_balance = new Member_withdrawal_balance;
    //         $withdrawal_balance->userId =  $userId;
    //         $withdrawal_balance->withdrawal_amount =  $amount;
    //         $withdrawal_balance->status =  0;
    //         $withdrawal_balance->save();

    //         //Minus withdrawal amount from member's income_amount in member_latest_txninfos
    //         $latest_txnInfo = Member_wallet_balance::where('userId', $userId)->first();
    //         $minus_income = $latest_txnInfo->income_amount * 1 - $amount * 1;

    //         Member_wallet_balance::where('userId', $userId)
    //             ->update([
    //                 'income_amount' =>  $minus_income,
    //             ]);

    //         return response()->json(['status' => 200]);
    //     } catch (\Exception $e) {
    //         $error = 'Error: ' . $e->getMessage();
    //         return response()->json(['status' => 400, 'error' => $error]);
    //     }
    // }
}
