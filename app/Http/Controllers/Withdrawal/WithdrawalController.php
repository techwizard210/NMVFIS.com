<?php

namespace App\Http\Controllers\Withdrawal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Withdrawal_fee;
use App\Models\Member_withdrawal_balance;
use App\Models\Member_wallet_balance;

class WithdrawalController extends Controller
{
    public function index()
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;
        $user_data = User::where('userId', $userId)->first();

        $data = Member_wallet_balance::where('userId', $userId)->first();

        return view('pages.withdrawal.balance')->with(['data' => $data, 'user_data' => $user_data]);
    }

    public function withdrawal(Request $request)
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;
        $input_amount = $request->amount;
        $wallet_address = $request->wallet_address;
        $amount = round($input_amount * 1 * 0.95);
        $fee = $input_amount * 1 - $amount * 1;
        try {
            $randomDepositId = uniqid();

            //add withdrawal fee report
            $feeModel = new Withdrawal_fee();
            $feeModel->userId =  $userId;
            $feeModel->depositId =  $randomDepositId;
            $feeModel->amount =  $input_amount;
            $feeModel->fee =  $fee;
            $feeModel->status =  0;
            $feeModel->save();

            $withdrawal_balance = new Member_withdrawal_balance;
            $withdrawal_balance->userId =  $userId;
            $withdrawal_balance->target_w_address =  $wallet_address;
            $withdrawal_balance->depositId =  $randomDepositId;
            $withdrawal_balance->withdrawal_amount =  $amount;
            $withdrawal_balance->input_amount =  $input_amount;
            $withdrawal_balance->status =  0;
            $withdrawal_balance->save();

            //Minus withdrawal amount from member's income_amount in member_wallet_balance table
            $wallet_balance = Member_wallet_balance::where('userId', $userId)->first();
            $minus_income = $wallet_balance->income_amount * 1 - $input_amount * 1;

            Member_wallet_balance::where('userId', $userId)
                ->update([
                    'income_amount' =>  $minus_income,
                ]);

            return response()->json(['status' => 200]);
        } catch (\Exception $e) {
            $error = 'Error: ' . $e->getMessage();
            return response()->json(['status' => 400, 'error' => $error]);
        }
    }
}
