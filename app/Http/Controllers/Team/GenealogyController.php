<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Member_investment_list;

class GenealogyController extends Controller
{
    public function addLeftReferralUserIds($userId, $key)
    {
        global $left_referral_userIds;
        if ($key == 0) {
            $leftReferralUser = User::where('placementId', $userId)
                ->where('position', 'Left')
                ->first();
            if ($leftReferralUser) {
                array_push($left_referral_userIds, $leftReferralUser->userId);
                $this->addLeftReferralUserIds($leftReferralUser->userId, $key + 1);
            }
        } else {
            $leftReferralUser = User::where('placementId', $userId)
                ->get();
            if ($leftReferralUser) {
                foreach ($leftReferralUser as $key => $element) {
                    array_push($left_referral_userIds, $element->userId);
                    $this->addLeftReferralUserIds($element->userId, $key + 1);
                }
            }
        }
    }

    public function addRightReferralUserIds($userId, $key)
    {
        global $right_referral_userIds;
        if ($key == 0) {
            $rightReferralUser = User::where('placementId', $userId)
                ->where('position', 'Right')
                ->first();
            if ($rightReferralUser) {
                array_push($right_referral_userIds, $rightReferralUser->userId);
                $this->addRightReferralUserIds($rightReferralUser->userId, $key + 1);
            }
        } else {
            $rightReferralUser = User::where('placementId', $userId)
                ->get();
            if ($rightReferralUser) {
                foreach ($rightReferralUser as $key => $element) {
                    array_push($right_referral_userIds, $element->userId);
                    $this->addRightReferralUserIds($element->userId, $key + 1);
                }
            }
        }
    }

    public function addLeftDirectUserIds($userId)
    {
        global $left_direct_userIds;
        $leftDirectUser = User::where('sponsorId', $userId)
            ->where('position', 'Left')
            // ->first()
            ->get()
            ->toArray();
        $left_direct_userIds = $leftDirectUser;
        // if ($leftDirectUser) {
        //     array_push($left_direct_userIds, $leftDirectUser->userId);
        //     $this->addLeftDirectUserIds($leftDirectUser->userId);
        // }
    }

    public function addRightDirectUserIds($userId)
    {
        global $right_direct_userIds;
        $rightDirectUser = User::where('sponsorId', $userId)
            ->where('position', 'Right')
            // ->first()
            ->get()
            ->toArray();
        $right_direct_userIds = $rightDirectUser;
        // if ($rightDirectUser) {
        //     array_push($right_direct_userIds, $rightDirectUser->userId);
        //     $this->addRightDirectUserIds($rightDirectUser->userId);
        // }
    }

    public function findCurrentPosition($placementId)
    {
        $placementUser = User::where('userId', $placementId)->first();
        if ($placementUser) {
            $data = '';
            $order = $placementUser->order;
            if ($order == 1) {
                return $placementUser->position;
            } else {
                $data = $this->findCurrentPosition($placementUser->placementId);
            }
            return $data;
        }
    }

    public function index($id = null)
    {
        global $left_referral_userIds;
        $left_referral_userIds = array();
        global $right_referral_userIds;
        $right_referral_userIds = array();

        global $left_direct_userIds;
        $left_direct_userIds = array();
        global $right_direct_userIds;
        $right_direct_userIds = array();

        if ($id) {
            $find_id_data = User::where('users.id', $id)
                ->first();
            $userId = $find_id_data->userId;
        } else {
            $user = Session::get('user');   // Session User Data
            $userId = $user->userId;
        }

        $user_data = User::where('users.userId', $userId)
            ->leftJoin('users_affiliate_structures as t2', 'users.userId', '=', 't2.userId')
            ->select('users.*', 't2.leftside_funds', 't2.rightside_funds')
            ->first();
        $userNetworkId =  $user_data->networkId;
        $userOrder = $user_data->order;

        $this->addLeftReferralUserIds($userId, 0);
        $this->addRightReferralUserIds($userId, 0);

        $leftTotal = sizeof($left_referral_userIds);
        $rightTotal = sizeof($right_referral_userIds);

        $this->addLeftDirectUserIds($userId, 0);
        $this->addRightDirectUserIds($userId, 0);

        $leftDirectTotal = sizeof($left_direct_userIds);
        $rightDirectTotal = sizeof($right_direct_userIds);

        $totalLeftInvestment =  Member_investment_list::whereIn('userId', $left_referral_userIds)
            ->sum('amount');
        $totalRightInvestment =  Member_investment_list::whereIn('userId', $right_referral_userIds)
            ->sum('amount');

        $detailDiv = '
            <div id="detailDiv_' . $user_data->id . '" class="detailDiv" style="position:absolute; width:630px; top:75px; background:white; z-index:10; border: 5px solid black; border-radius:5px; box-shadow:4px 4px 20px rgb(0 0 0); padding:10px;">
                <ul class="col-md-12" style="list-style-type:none; display:flex; border-bottom: 1px solid; padding: 0px; font-size: 11px; margin-bottom:5px;">
                    <li class="col-md-4"><span style="font-weight: bold;">Username :</span><span style="color: blue;">' . $user_data->name . '</span></li>
                    <li class="col-md-4"><span style="font-weight: bold;">Registration Date :</span><span style="color: blue;">' . date_format(date_create($user_data->created_at), 'Y-m-d') . '</span></li>
                    <li class="col-md-4"><span style="font-weight: bold;">Date Activated :</span><span style="color: blue;"></span></li>
                </ul>
                <ul class="col-md-12" style="list-style-type:none; display:flex; border-bottom: 1px solid; padding: 0px; font-size: 11px; margin-bottom:5px;">
                    <li class="col-md-4"><span style="font-weight: bold;">User ID :</span><span style="color: blue;">' . $user_data->userId . '</span></li>
                    <li class="col-md-4"><span style="font-weight: bold;">Rank :</span><span style="color: blue;">' . $user_data->rank . '</span></li>
                    <li class="col-md-4"><span style="font-weight: bold;">Sponsored By :</span><span style="color: blue;">' . $user_data->sponsorId . '</span></li>
                </ul>
                <ul class="col-md-12" style="list-style-type:none; display:flex; border-bottom: 1px solid; padding: 0px; font-size: 11px; margin-bottom:5px;">
                    <li class="col-md-4"><span style="font-weight: bold;">Left Team : </span><span style="color: blue;">' . $leftTotal . '</span></li>
                    <li class="col-md-4"><span style="font-weight: bold;">Right Team :</span><span style="color: blue;">' . $rightTotal . '</span></li>
                    <li class="col-md-4"><span style="font-weight: bold;">Total Left Investment : </span><span style="color: blue;">' . $totalLeftInvestment . '</span></li>
                </ul>
                <ul class="col-md-12" style="list-style-type:none; display:flex; border-bottom: 1px solid; padding: 0px; font-size: 11px; margin-bottom:5px;">
                    <li class="col-md-4"><span style="font-weight: bold;">Total Right Investment :</span><span style="color: blue;">' . $totalRightInvestment . '</span></li>
                    <li class="col-md-4"><span style="font-weight: bold;">Left Binary Balance : </span><span style="color: blue;">' . $user_data->leftside_funds . '</span></li>
                    <li class="col-md-4"><span style="font-weight: bold;">Right Binary Balance :</span><span style="color: blue;">' . $user_data->rightside_funds . '</span></li>
                </ul>
                    <ul class="col-md-12" style="list-style-type:none; display:flex; border-bottom: 1px solid; padding: 0px; font-size: 11px; margin-bottom:5px;">
                    <li class="col-md-4"><span style="font-weight: bold;">Self Topup :</span><span style="color: blue;">0</span></li>
                </ul>
            </div>
        ';

        $xml = '
                    <ul style="list-style-type:none; padding: 0px;">
                        <li style="display:flex; justify-content:center;">
                            <div class="gene_first_user" style="display:flex; flex-direction:column; align-items:center; position:absolute; width:100%;">
                                <div onclick="chooseUser(' . $user_data->id . ')" onmouseover="mouseOver(' . $user_data->id . ')" onmouseout="mouseOut(' . $user_data->id . ')"  style="display:flex; flex-direction:column; align-items:center; position:relative; cursor:pointer;">
                                    <i class="material-icons" style="font-size: 50px;">account_circle</i>
                                    <div style="border: 1px; border-color: #5558bf; border-style: solid; border-radius: 4px; color: #5558bf; padding: 0px 5px;">' . $user_data->userId . '</div>
                            ';
        $xml .= $detailDiv . '</div>';
        $check = $this->checkIfChild($user_data);
        if ($check == true) {
            $xml .= '
                    <div style="position: relative; border-left:1px solid #5558bf; height: 20px; "></div>
                    <div style="position: relative; border-top:1px solid #5558bf; width:50%; "></div>
                ';
        }

        $tree_datas = $this->referralUser($user_data, '', 0);

        $xml .= $tree_datas . '
                </div>
            </li>
        </ul>
        ';



        $findLeftDirects = DB::table('member_referral_lists')
            ->where('otherUserId', $userId)
            ->whereIn('userId', $left_referral_userIds)
            ->where('created_at', date('Y-m-d'))
            ->get()
            ->toArray();
        $leftDirectsNum = sizeof($findLeftDirects);

        $findRightDirects = DB::table('member_referral_lists')
            ->where('otherUserId', $userId)
            ->whereIn('userId', $right_referral_userIds)
            ->where('created_at', date('Y-m-d'))
            ->get()
            ->toArray();
        $rightDirectsNum = sizeof($findRightDirects);
        $networkUserList = User::where('networkId',$userNetworkId)->get()->toArray();
        if ($id) {
            return response()->json(['status' => 200, 'xml' => $xml]);
        } else {
            return view('pages.team.genealogy')
                ->with([
                    'xml' => $xml,
                    'leftTotal' => $leftTotal,
                    'rightTotal' => $rightTotal,
                    'leftDirectTotal' => $leftDirectTotal,
                    'rightDirectTotal' => $rightDirectTotal,
                    'totalLeftInvestment' => $totalLeftInvestment,
                    'totalRightInvestment' => $totalRightInvestment,
                    'leftDirectsNum' => $leftDirectsNum,
                    'rightDirectsNum' => $rightDirectsNum,
                    'networkUserList' => $networkUserList,
                    'firstUserId' => $user_data->id,
                ]);
        }
    }

    public function checkIfChild($user_data)
    {
        $referralUsers = User::where('placementId', $user_data['userId'])
            ->where('networkId', $user_data['networkId'])
            ->orderBy('p_num', 'ASC')->get()->toArray();
        if (sizeof($referralUsers) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function referralUser($user_data, $xml, $flag)
    {
        if ($flag < 3) {
            global $left_referral_userIds;
            $left_referral_userIds = array();
            global $right_referral_userIds;
            $right_referral_userIds = array();

            $userId = $user_data['userId'];
            $referralUsers = User::where('placementId', $userId)
                ->leftJoin('users_affiliate_structures as t2', 'users.userId', '=', 't2.userId')
                ->where('networkId', $user_data['networkId'])
                ->select('users.*', 't2.leftside_funds', 't2.rightside_funds')
                ->orderBy('p_num', 'ASC')
                ->get()
                ->toArray();
            if (sizeof($referralUsers) == 2) {
                foreach ($referralUsers as $key => $referral_user) {
                    $netPosition = $this->findCurrentPosition($referral_user['placementId']);
                    if ($netPosition == 'Left') {
                        $left_right_style = 'left:0px;';
                    } else if ($netPosition == 'Right') {
                        $left_right_style = 'right:0px;';
                    } else {
                        $left_right_style = '';
                    }
                    $this->addLeftReferralUserIds($referral_user['userId'], 0);
                    $this->addRightReferralUserIds($referral_user['userId'], 0);

                    $leftTotal = sizeof($left_referral_userIds);
                    $rightTotal = sizeof($right_referral_userIds);

                    $totalLeftInvestment =  Member_investment_list::whereIn('userId', $left_referral_userIds)
                        ->sum('amount');
                    $totalRightInvestment =  Member_investment_list::whereIn('userId', $right_referral_userIds)
                        ->sum('amount');
                    $detailDiv = '
                        <div id="detailDiv_' . $referral_user['id'] . '" class="detailDiv" style="position:absolute; width:630px; top:75px;' . $left_right_style . ' background:white; z-index:10; border: 5px solid black; border-radius:5px; box-shadow:4px 4px 20px rgb(0 0 0); padding:10px;">
                            <ul class="col-md-12" style="list-style-type:none; display:flex; border-bottom: 1px solid; padding: 0px; font-size: 11px; margin-bottom:5px;">
                                <li class="col-md-4"><span style="font-weight: bold;">Username : </span><span style="color: blue;">' . $referral_user['name'] . '</span></li>
                                <li class="col-md-4"><span style="font-weight: bold;">Registration Date : </span><span style="color: blue;">' . date_format(date_create($referral_user['created_at']), 'Y-m-d') . '</span></li>
                                <li class="col-md-4"><span style="font-weight: bold;">Date Activated : </span><span style="color: blue;"></span></li>
                            </ul>
                            <ul class="col-md-12" style="list-style-type:none; display:flex; border-bottom: 1px solid; padding: 0px; font-size: 11px; margin-bottom:5px;">
                                <li class="col-md-4"><span style="font-weight: bold;">User ID : </span><span style="color: blue;">' . $referral_user['userId'] . '</span></li>
                                <li class="col-md-4"><span style="font-weight: bold;">Rank : </span><span style="color: blue;">' . $referral_user['rank'] . '</span></li>
                                <li class="col-md-4"><span style="font-weight: bold;">Sponsored By : </span><span style="color: blue;">' . $referral_user['sponsorId'] . '</span></li>
                            </ul>
                            <ul class="col-md-12" style="list-style-type:none; display:flex; border-bottom: 1px solid; padding: 0px; font-size: 11px; margin-bottom:5px;">
                                <li class="col-md-4"><span style="font-weight: bold;">Left Team : </span><span style="color: blue;">' . $leftTotal . '</span></li>
                                <li class="col-md-4"><span style="font-weight: bold;">Right Team : </span><span style="color: blue;">' . $rightTotal . '</span></li>
                                <li class="col-md-4"><span style="font-weight: bold;">Total Left Investment : </span><span style="color: blue;">' . $totalLeftInvestment . '</span></li>
                            </ul>
                            <ul class="col-md-12" style="list-style-type:none; display:flex; border-bottom: 1px solid; padding: 0px; font-size: 11px; margin-bottom:5px;">
                                <li class="col-md-4"><span style="font-weight: bold;">Total Right Investment :</span><span style="color: blue;">' . $totalRightInvestment . '</span></li>
                                <li class="col-md-4"><span style="font-weight: bold;">Left Binary Balance : </span><span style="color: blue;">' . $referral_user['leftside_funds'] . '</span></li>
                                <li class="col-md-4"><span style="font-weight: bold;">Right Binary Balance :</span><span style="color: blue;">' . $referral_user['rightside_funds'] . '</span></li>
                            </ul>
                                <ul class="col-md-12" style="list-style-type:none; display:flex; border-bottom: 1px solid; padding: 0px; font-size: 11px; margin-bottom:5px;">
                                <li class="col-md-4"><span style="font-weight: bold;">Self Topup :</span><span style="color: blue;">0</span></li>
                            </ul>
                        </div>
                    ';
                    if ($key == 0) {
                        $xml .= '
                            <ul style="list-style-type:none; padding: 0px; display: flex; justify-content: space-around; width: 100%;">
                        ';
                    }
                    $xml .= ' 
                        <li style="width: 50%;">
                            <div style="display:flex; flex-direction:column; align-items:center;">
                                <div style="position: relative; border-left:1px solid #5558bf; height: 20px; "></div>
                                    <div onclick="chooseUser(' . $referral_user['id'] . ')" onmouseover="mouseOver(' . $referral_user['id'] . ')" onmouseout="mouseOut(' . $referral_user['id'] . ')"  style="display:flex; flex-direction:column; align-items:center; position:relative; cursor:pointer;">
                                        <i class="material-icons" style="font-size: 50px;">account_circle</i>
                                        <div style="border: 1px; border-color: #5558bf; border-style: solid; border-radius: 4px; color: #5558bf; padding: 0px 5px;">' . $referral_user['userId'] . '</div>
                                
                    ';
                    $xml .= $detailDiv . '</div>';
                    $check = $this->checkIfChild($referral_user);
                    if ($flag + 1 < 3 && $check == true) {
                        $xml .= '
                            <div style="position: relative; border-left:1px solid #5558bf; height: 20px; "></div>
                            <div style="position: relative; border-top:1px solid #5558bf; width:50%; "></div>
                        </div>
                    ';
                        $xml .= $this->referralUser($referral_user, '', $flag + 1);
                    } else {
                        $xml .= '</div>';
                    }
                }
                $xml .= '</ul>';
            } else if (sizeof($referralUsers) == 1) {
                $netPosition = $this->findCurrentPosition($referralUsers[0]['placementId']);
                if ($netPosition == 'Left') {
                    $left_right_style = 'left:0px;';
                } else if ($netPosition == 'Right') {
                    $left_right_style = 'right:0px;';
                } else {
                    $left_right_style = '';
                }
                $this->addLeftReferralUserIds($referralUsers[0]['userId'], 0);
                $this->addRightReferralUserIds($referralUsers[0]['userId'], 0);

                $leftTotal = sizeof($left_referral_userIds);
                $rightTotal = sizeof($right_referral_userIds);

                $totalLeftInvestment =  Member_investment_list::whereIn('userId', $left_referral_userIds)
                    ->sum('amount');
                $totalRightInvestment =  Member_investment_list::whereIn('userId', $right_referral_userIds)
                    ->sum('amount');

                $detailDiv = '
                    <div id="detailDiv_' . $referralUsers[0]['id'] . '" class="detailDiv" style="position:absolute; width:630px; top:75px; ' . $left_right_style . ' background:white; z-index:10; border: 5px solid black; border-radius:5px; box-shadow:4px 4px 20px rgb(0 0 0); padding:10px;">
                        <ul class="col-md-12" style="list-style-type:none; display:flex; border-bottom: 1px solid; padding: 0px; font-size: 11px; margin-bottom:5px;">
                            <li class="col-md-4"><span style="font-weight: bold;">Username :</span><span style="color: blue;">' . $referralUsers[0]['name'] . '</span></li>
                            <li class="col-md-4"><span style="font-weight: bold;">Registration Date :</span><span style="color: blue;">' . date_format(date_create($referralUsers[0]['created_at']), 'Y-m-d') . '</span></li>
                            <li class="col-md-4"><span style="font-weight: bold;">Date Activated :</span><span style="color: blue;"></span></li>
                        </ul>
                        <ul class="col-md-12" style="list-style-type:none; display:flex; border-bottom: 1px solid; padding: 0px; font-size: 11px; margin-bottom:5px;">
                            <li class="col-md-4"><span style="font-weight: bold;">User ID : </span><span style="color: blue;">' . $referralUsers[0]['userId'] . '</span></li>
                            <li class="col-md-4"><span style="font-weight: bold;">Rank : </span><span style="color: blue;">' . $referralUsers[0]['rank'] . '</span></li>
                            <li class="col-md-4"><span style="font-weight: bold;">Sponsored By : </span><span style="color: blue;">' . $referralUsers[0]['sponsorId'] . '</span></li>
                        </ul>
                        <ul class="col-md-12" style="list-style-type:none; display:flex; border-bottom: 1px solid; padding: 0px; font-size: 11px; margin-bottom:5px;">
                            <li class="col-md-4"><span style="font-weight: bold;">Left Team : </span><span style="color: blue;">' . $leftTotal . '</span></li>
                            <li class="col-md-4"><span style="font-weight: bold;">Right Team : </span><span style="color: blue;">' . $rightTotal . '</span></li>
                            <li class="col-md-4"><span style="font-weight: bold;">Total Left Investment : </span><span style="color: blue;">' . $totalLeftInvestment . '</span></li>
                        </ul>
                        <ul class="col-md-12" style="list-style-type:none; display:flex; border-bottom: 1px solid; padding: 0px; font-size: 11px; margin-bottom:5px;">
                            <li class="col-md-4"><span style="font-weight: bold;">Total Right Investment :</span><span style="color: blue;">' . $totalRightInvestment . '</span></li>
                            <li class="col-md-4"><span style="font-weight: bold;">Left Binary Balance : </span><span style="color: blue;">' . $referralUsers[0]['leftside_funds'] . '</span></li>
                            <li class="col-md-4"><span style="font-weight: bold;">Right Binary Balance :</span><span style="color: blue;">' . $referralUsers[0]['rightside_funds'] . '</span></li>
                        </ul>
                            <ul class="col-md-12" style="list-style-type:none; display:flex; border-bottom: 1px solid; padding: 0px; font-size: 11px; margin-bottom:5px;">
                            <li class="col-md-4"><span style="font-weight: bold;">Self Topup :</span><span style="color: blue;">0</span></li>
                        </ul>
                    </div>
                ';
                $position = $referralUsers[0]['position'];
                if ($position == 'Right') {
                    $xml .= '<ul style="list-style-type:none; padding: 0px; display: flex; justify-content: space-around; width: 100%;">
                            <li style="width: 50%;">
                                <div style="display:flex; flex-direction:column; align-items:center;">
                                    <div style="position: relative; border-left:1px solid #5558bf; height: 20px; "></div>
                                            <i class="material-icons" style="font-size: 50px; color: yellow;">account_circle</i>
                                            <div style="border: 1px; border-color: #5558bf; border-style: solid; border-radius: 4px; color: #5558bf; padding: 0px 5px;">No Record</div>
                                    </div>
                                </li>';
                    $xml .= '
                        <li style="width: 50%;">
                            <div style="display:flex; flex-direction:column; align-items:center;">
                                <div style="position: relative; border-left:1px solid #5558bf; height: 20px; "></div>
                                    <div onclick="chooseUser(' . $referralUsers[0]['id'] . ')" onmouseover="mouseOver(' . $referralUsers[0]['id'] . ')" onmouseout="mouseOut(' . $referralUsers[0]['id'] . ')"  style="display:flex; flex-direction:column; align-items:center; position:relative; cursor:pointer;">
                                        <i class="material-icons" style="font-size: 50px;">account_circle</i>
                                        <div style="border: 1px; border-color: #5558bf; border-style: solid; border-radius: 4px; color: #5558bf; padding: 0px 5px;">' . $referralUsers[0]['userId'] . '</div>
                            
                    ';
                    $xml .= $detailDiv . '</div>';
                    $check = $this->checkIfChild($referralUsers[0]);
                    if ($flag + 1 < 3 && $check == true) {
                        $xml .= '
                        <div style="position: relative; border-left:1px solid #5558bf; height: 20px; "></div>
                        <div style="position: relative; border-top:1px solid #5558bf; width:50%; "></div>
                    ';
                    }
                    $xml .= '</div>
                ';
                    $xml .= $this->referralUser($referralUsers[0],  '', $flag + 1);
                    $xml .= '</ul>';
                } else if ($position == 'Left') {
                    $xml .= '
                        <ul style="list-style-type:none; padding: 0px; display: flex; justify-content: space-around; width: 100%;">
                            <li style="width: 50%;">
                                <div style="display:flex; flex-direction:column; align-items:center;">
                                    <div style="position: relative; border-left:1px solid #5558bf; height: 20px; "></div>
                                        <div onclick="chooseUser(' . $referralUsers[0]['id'] . ')" onmouseover="mouseOver(' . $referralUsers[0]['id'] . ')" onmouseout="mouseOut(' . $referralUsers[0]['id'] . ')"  style="display:flex; flex-direction:column; align-items:center; position:relative; cursor:pointer;">
                                            <i class="material-icons" style="font-size: 50px;">account_circle</i>
                                            <div style="border: 1px; border-color: #5558bf; border-style: solid; border-radius: 4px; color: #5558bf; padding: 0px 5px;">' . $referralUsers[0]['userId'] . '</div>
                            ';
                    $xml .= $detailDiv . '</div>';
                    $check = $this->checkIfChild($referralUsers[0]);
                    if ($flag + 1 < 3 && $check == true) {
                        $xml .= '
                        <div style="position: relative; border-left:1px solid #5558bf; height: 20px; "></div>
                        <div style="position: relative; border-top:1px solid #5558bf; width:50%; "></div>
                    ';
                    }
                    $xml .= '</div>';
                    $xml .= $this->referralUser($referralUsers[0],  '', $flag + 1);
                    $xml .= '<li style="width: 50%;">
                            <div style="display:flex; flex-direction:column; align-items:center;">
                                <div style="position: relative; border-left:1px solid #5558bf; height: 20px; "></div>
                                <i class="material-icons" style="font-size: 50px; color: yellow;">account_circle</i>
                                <div style="border: 1px; border-color: #5558bf; border-style: solid; border-radius: 4px; color: #5558bf; padding: 0px 5px;">No Record</div>
                            </div>
                        </li>';
                    $xml .= '</li>
                </ul>';
                }
            } else if (sizeof($referralUsers) == 0) {
                return '</li>';
            }
        }
        return $xml;
    }
}
