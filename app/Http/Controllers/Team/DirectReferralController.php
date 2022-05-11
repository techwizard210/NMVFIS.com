<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Models\User;
// use App\Models\Member_latest_txninfo;
use App\Models\Direct_Referral_Percentage;

class DirectReferralController extends Controller
{

    public function addLeftReferralUserIds($userId)
    {
        global $left_referral_userIds;
        $leftReferralUser = User::where('placementId', $userId)
            ->where('position', 'Left')
            ->first();
        if ($leftReferralUser) {
            array_push($left_referral_userIds, $leftReferralUser->userId);
            $this->addLeftReferralUserIds($leftReferralUser->userId);
        }
    }

    public function addRightReferralUserIds($userId)
    {
        global $right_referral_userIds;
        $rightReferralUser = User::where('placementId', $userId)
            ->where('position', 'Right')
            ->first();
        if ($rightReferralUser) {
            array_push($right_referral_userIds, $rightReferralUser->userId);
            $this->addRightReferralUserIds($rightReferralUser->userId);
        }
    }


    public function index()
    {
        global $left_referral_userIds;
        $left_referral_userIds = array();
        global $right_referral_userIds;
        $right_referral_userIds = array();

        global $findReferralUser;
        $findReferralUser = array();

        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;

        $this->addLeftReferralUserIds($userId);
        $this->addRightReferralUserIds($userId);

        $all_team_members = array();
        if ($left_referral_userIds) {
            foreach ($left_referral_userIds as $key => $element) {
                array_push($all_team_members, $element);
            }
        }
        if ($right_referral_userIds) {
            foreach ($right_referral_userIds as $key => $element) {
                array_push($all_team_members, $element);
            }
        }

        $datas = DB::table('member_referral_lists as t1')
            ->leftJoin('users as t2', 't2.userId', '=', 't1.userId')
            ->whereIn('t1.userId', $all_team_members)
            ->select('t1.amount','t1.created_at as date', 't2.*')
            ->orderBy('t1.created_at', 'DESC')
            ->get();
        return view('pages.team.referral')->with(['datas' => $datas]);
    }

    public function setNewPercentage(Request $request)
    {
        $percent = $request->percent;

        try {
            $check = Direct_Referral_Percentage::where('created_at', date('Y-m-d'))->first();
            if ($check) {
                Direct_Referral_Percentage::where('created_at', date('Y-m-d'))
                    ->update([
                        'percent' =>  $percent,
                    ]);
            } else {
                $directReferralModel = new Direct_Referral_Percentage();
                $directReferralModel->percent =  $percent;
                $directReferralModel->save();
            }
            return response()->json(['status' => 200]);
        } catch (\Exception $e) {
            $error = 'Error: ' . $e->getMessage();
            return response()->json(['status' => 400, 'error' => $error]);
        }
    }
}
