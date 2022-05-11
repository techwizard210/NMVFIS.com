<?php

namespace App\Http\Controllers\Withdrawal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Member_latest_txninfo;
use App\Models\Member_binarybonus_list;
use App\Models\Member_withdrawal_balance;
use App\Models\Member_wallet_balance;
use App\Models\Withdrawal_fee;

class WithdrawalReportController extends Controller
{
    public function index()
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;
        $user_data = User::where('userId', $userId)->first();
        $user_role = $user_data->role;

        $withdrawalModel = new Member_withdrawal_balance();

        if ($user_role == 'admin') {
            $today = date("Y-m-d");
            $getWithdrawalReports = $withdrawalModel->getWithdrawalReports_Admin($today)->toArray();
            $datas = json_decode(json_encode($getWithdrawalReports), true);
            return view('pages.withdrawal.report_admin')->with([
                'withdrawal_datas' => $datas,
                'today' =>  date("d/m/Y"),
            ]);
        } else if ($user_role == 'user') {
            $getWithdrawalReports = $withdrawalModel->getWithdrawalReports($userId)->toArray();
            $datas = json_decode(json_encode($getWithdrawalReports), true);
            return view('pages.withdrawal.report')->with([
                'withdrawal_datas' => $datas,
            ]);
        }
    }

    public function table($date)
    {
        $today = date("Y-m-d");
        $format_date = date_format(date_create($today), "Y-m-d");
        $withdrawalModel = new Member_withdrawal_balance();
        $getWithdrawalReports = $withdrawalModel->getWithdrawalReports_Admin($date)->toArray();
        $datas = json_decode(json_encode($getWithdrawalReports), true);

        return view('pages.withdrawal.report_admin_table')->with([
            'withdrawal_datas' => $datas,
            'today' =>  date("d/m/Y"),
        ]);
    }

    public function changeDate(Request $request)
    {
        $date = $request->date;
        $format_date = date_format(date_create($date), "Y-m-d");
        $withdrawalModel = new Member_withdrawal_balance();
        $getWithdrawalReports = $withdrawalModel->getWithdrawalReports_Admin($format_date)->toArray();
        $datas = json_decode(json_encode($getWithdrawalReports), true);

        view('pages.withdrawal.report_admin_table', $datas);

        return response()->json([
            'status' => 200,
            'withdrawal_datas' => $datas,
            'today' => $format_date,
        ]);
    }
    public function confirm(Request $request)
    {
        try {
            $date = $request->date;
            $dateYMDArray = explode('/', $date);
            // $changedDate = $dateYMDArray[2] . '-' . $dateYMDArray[1] . '-' . $dateYMDArray[0];
            // $format_date = date_format(date_create($changedDate), "Y-m-d");
            $changedDate = $dateYMDArray[1] . '-' . $dateYMDArray[0] . '-' . $dateYMDArray[2];
            $format_date = date("Y-m-d", strtotime($changedDate));
            $id = $request->id;

            //Change Status of Withdrawal Request
            Member_withdrawal_balance::where('created_at', $format_date)
                ->where('id', $id)
                ->update([
                    'status' =>  1,
                ]);

            $findConfirmedInfo = Member_withdrawal_balance::where('created_at', $format_date)
                ->where('id', $id)
                ->first();
            $userId = $findConfirmedInfo->userId;
            $depositId = $findConfirmedInfo->depositId;


            //Change Fee Status
            $findConfirmedFeeInfo =  Withdrawal_fee::where('userId', $userId)
                ->where('depositId', $depositId)
                ->first();

            Withdrawal_fee::where('userId', $userId)
                ->where('depositId', $depositId)
                ->update([
                    'status' =>  1,
                ]);
            
            //Add fee to admin wallet
            $fee = $findConfirmedFeeInfo->fee;

            $admin_wallet_balance = DB::table('member_wallet_balances as t1')
                ->leftJoin('users as t2', 't2.userId', '=', 't1.userId')
                ->where('t2.role', 'admin')
                ->select('t1.*')
                ->first();
            
            $adminUserId = $admin_wallet_balance->userId;
            $new_income_amount = $admin_wallet_balance->income_amount * 1 + $fee * 1;

            Member_wallet_balance::where('userId', $adminUserId)
                ->update([
                    'income_amount' =>  $new_income_amount,
                ]);
            //--------------

            return response()->json(['status' => 200, 'date' => $date,]);
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
            exit();
        }
    }

    public function cancel(Request $request)
    {
        try {
            $date = $request->date;
            $format_date = date_format(date_create($date), "Y-m-d");
            $id = $request->id;

            $findCanceledData = Member_withdrawal_balance::where('id', $id)->first();
            $userId = $findCanceledData->userId;
            $amount = $findCanceledData->input_amount;
            $depositId = $findCanceledData->depositId;
           
            $user_wallet_info = Member_wallet_balance::where('userId', $userId)->first();
            $plus_income = $user_wallet_info->income_amount * 1 + $amount * 1;

            // Plus canceled amount
            Member_wallet_balance::where('userId', $userId)
                ->update([
                    'income_amount' =>  $plus_income,
                ]);

            // Change Status of Withdrawal Request
            Member_withdrawal_balance::where('depositId', $depositId)
                ->update([
                    'status' =>  2,
                ]);

            //Change Fee Status
            Withdrawal_fee::where('userId', $userId)
                ->where('depositId', $depositId)
                ->update([
                    'status' =>  2,
                ]);

            return response()->json(['status' => 200, 'date' => $date,]);
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
            exit();
        }
    }
}
