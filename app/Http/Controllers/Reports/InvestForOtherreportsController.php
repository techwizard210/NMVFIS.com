<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Models\Member_investforother_list;

class InvestForOtherreportsController extends Controller
{
    public function index()
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;

        $datas = DB::table('member_investforother_lists as t1')->where('t1.userId',$userId)
                    ->leftJoin('users as t2', 't2.userId', '=', 't1.otherUserid')
                    ->select('t1.*','t2.name')
                    ->orderBy('t1.created_at','DESC')
                    ->get()
                    ->toArray();
        // $investmentModel = new Member_investforother_list();
        // $getWithdrawalReports = $investmentModel->getInvestmentReports($userId)->toArray();
        // $reports = json_decode(json_encode($getWithdrawalReports), true);
        return view('pages.reports.investforother')->with(['reports' => $datas]);
    }
}
