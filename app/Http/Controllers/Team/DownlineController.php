<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Member_referral_list;

class DownlineController extends Controller
{
    public function findChildUsers($userId)
    {
        global $teamUsersList;

        array_push($teamUsersList, $userId);
        $childUsers = User::where('placementId', $userId)->get();
        if ($childUsers) {
            foreach ($childUsers as $key => $childUser) {
                $this->findChildUsers($childUser->userId);
            }
        } else {
            return null;
        }
    }

    public function index()
    {
        global $teamUsersList;
        $teamUsersList = array();

        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;

        $this->findChildUsers($userId);

        // $dailyRoiTable = DB::table('member_roi_lists as a1')
        //     ->groupBy('a1.userId', 'a1.depositId')
        //     ->selectRaw('a1.userId, a1.depositId, sum(a1.roi_amount) as total_roi, sum(a1.percent) as total_percent')
        //     ->get();

        // $datas = DB::table('member_investment_lists as t1')
        //     ->leftJoin('users as t2', 't2.userId', '=', 't1.userId')
        //     ->leftJoin($dailyRoiTable, 't1.depositId', '=', 't3.depositId')
        //     ->whereIn('t1.userId', $teamUsersList)
        //     ->select('t1.*', 't3.total_roi')
        //     ->orderBy('t1.created_at', 'DESC')
        //     ->get();

        $datas = DB::table('member_investment_lists as t1')
            ->leftJoin('users as t2', 't2.userId', '=', 't1.userId')
            ->leftJoin(
                DB::raw('(SELECT userId, depositId, sum(roi_amount) as total_roi FROM `member_roi_lists` GROUP BY depositId) t3'),
                function ($join) {
                    $join->on('t1.depositId', '=', 't3.depositId');
                }
            )
            ->whereIn('t1.userId', $teamUsersList)
            ->select('t1.*', 't3.total_roi')
            ->orderBy('t1.created_at', 'DESC')
            ->get();

        return view('pages.team.downline')->with(['datas' => $datas]);
    }
}
