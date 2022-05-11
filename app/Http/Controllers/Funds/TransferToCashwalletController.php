<?php

namespace App\Http\Controllers\Funds;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Models\Member_wallet_balance;
use App\Models\Transfer_to_cash_report;
use App\Models\Withdrawal_fee;

class TransferToCashwalletController extends Controller
{
    public function index()
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;

        $get_data = Member_wallet_balance::where('userId', $userId)->first();
        return view('pages.funds.withdrawal')->with(['data' => $get_data]);
    }

    public function transfertocash(Request $request)
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;
        $amount = $request->amount;
        try {
            //New withdrawal to cash wallet report
            $transfertocashreportModel = new Transfer_to_cash_report();
            $transfertocashreportModel->userId =  $userId;
            $transfertocashreportModel->amount =  $amount;
            $transfertocashreportModel->save();

            $user_cash_data = Member_wallet_balance::where('userId', $userId)->first();

            //Wallet amounts before transfering
            $user_withdrawal_wallet = $user_cash_data->income_amount;
            $user_cash_wallet = $user_cash_data->cash_balance;

            //Wallet amounts after transfering
            $new_user_withdrawal_wallet = $user_withdrawal_wallet * 1 - $amount * 1;
            $new_user_cash_wallet = $user_cash_wallet * 1 + $amount * 1;

            Member_wallet_balance::where('userId', $userId)
                ->update([
                    'income_amount' =>  $new_user_withdrawal_wallet,
                    'cash_balance' =>  $new_user_cash_wallet,
                ]);

            return response()->json(['status' => 200]);
        } catch (\Exception $e) {
            $error = 'Error: ' . $e->getMessage();
            return response()->json(['status' => 400, 'error' => $error]);
        }
    }
}
