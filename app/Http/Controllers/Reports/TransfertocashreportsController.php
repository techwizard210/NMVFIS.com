<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Member_latest_txninfo;
use App\Models\Member_binarybonus_list;
use App\Models\Member_withdrawal_balance;
use App\Models\Member_investment_list;
use App\Models\Transfer_to_cash_report;
use App\Models\Withdrawal_fee;

class TransfertocashreportsController extends Controller
{
    public function index()
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;
        $user_data = User::where('userId', $userId)->first();
        $user_role = $user_data->role;

        if ($user_role == 'admin') {
            $today = date("Y-m-d");
            $feeModel = new Withdrawal_fee();
            $datas = $feeModel->getAdminTransferReport($today)->toArray();
            $fee_reports = json_decode(json_encode($datas), true);

            return view('pages.reports.admin_transfer_r')->with([
                'fee_reports' => $fee_reports,
            ]);
        } else if ($user_role == 'user') {
            $reports = Transfer_to_cash_report::where('userId', $userId)->get()->toArray();
            return view('pages.reports.transfer_r')->with(['reports' => $reports]);
        }
    }
}
