<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Models\User;
// use App\Models\Member_latest_txninfo;
// use App\Models\Member_transfer_list;
use App\Models\Member_referral_list;

class TeamviewController extends Controller
{
    public function getData($userId)
    {
        global $user_list;

        array_push($user_list, $userId);
        $childUsers = User::where('placementId', $userId)->get();
        if ($childUsers) {
            foreach ($childUsers as $key => $childUser) {
                $this->getData($childUser->userId);
            }
        } else {
            return null;
        }
    }

    public function index()
    {
        global $user_list;
        $user_list = array();

        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;

        $this->getData($userId);

        $teamUsersData = User::whereIn('userId', $user_list)
            ->orderBy('order', 'DESC')
            ->get();
        return view('pages.team.t_view')->with(['datas' => $teamUsersData]);
    }
}
