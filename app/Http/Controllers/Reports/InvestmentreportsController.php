<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Models\Member_latest_txninfo;
use App\Models\Member_binarybonus_list;
use App\Models\Member_withdrawal_balance;
use App\Models\Member_investment_list;

class InvestmentreportsController extends Controller
{
    public function index()
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;

        // $reports = Member_investment_list::where('userId', $userId)->get();

        $investmentModel = new Member_investment_list();
        $getWithdrawalReports = $investmentModel->getInvestmentReports($userId)->toArray();
        $reports = json_decode(json_encode($getWithdrawalReports), true);
        return view('pages.reports.investment_r')->with(['reports' => $reports]);
    }
}
