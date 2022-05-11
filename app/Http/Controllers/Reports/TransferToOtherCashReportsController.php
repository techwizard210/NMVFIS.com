<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Models\Member_transfer_list;
use App\Models\Transfer_to_cash_report;

class TransferToOtherCashReportsController extends Controller
{
    public function index()
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;

        $reports = Member_transfer_list::where('userId', $userId)->get()->toArray();
        return view('pages.reports.wallet_r')->with(['reports' => $reports]);
    }
}
