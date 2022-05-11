<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Http\API\src\CoinpaymentsAPI;
use App\Models\User;
use App\Models\Member_latest_txninfo;
use App\Models\Member_wallet_balance;
use App\Models\Member_roi_list;
use App\Models\Member_referral_list;
use App\Models\Member_binarybonus_list;
use App\Models\Users_affiliate_structure;
use App\Models\Member_investment_list;
use App\Models\Transaction;
use App\Models\Daily_ROI_Percentage;
use App\Models\Direct_Referral_Percentage;
use App\Models\Binary_Bonus_Percentage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboarddata()
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;

        $today = date("Y-m-d");
        // $roiModel = new Member_roi_list();
        $User_Info = User::where('userId', $userId)->first();

        $User_Referral_Members = User::where('sponsorId', $userId)->get()->toArray();

        $User_LeftReferral_Link = '';
        $User_RightReferral_Link = '';
        $User_LeftReferral_Link = 'http://localhost:8000/register/sponsorId=' . $userId . '&position=Left';
        // $User_LeftReferral_Link = 'https://www.nmvfis.com/register/sponsorId=' . $userId . '&position=Left';
        $User_RightReferral_Link = 'http://localhost:8000/register/sponsorId=' . $userId . '&position=Right';
        // $User_RightReferral_Link = 'https://www.nmvfis.com/register/sponsorId=' . $userId . '&position=Right';

        // $User_RightReferral_Link = 'http://localhost:8000/register/sponsorId=96618809L&amp;position=Right';
        // if ($User_Referral_Members) {
        //     foreach ($User_Referral_Members as $key => $member) {
        //         if ($member['position'] == "Left") {
        //             // $User_LeftReferral_Link = 'https://www.nmvfis.com/register/?sponsorId=' . $member['userId'] . '&position=' . $member['position'];
        //         } else if ($member['position'] == "Right") {
        //             // $User_RightReferral_Link = 'https://www.nmvfis.com/register/?sponsorId=' . $member['userId'] . '&position=' . $member['position'];
        //         }
        //     }
        // }
        $User_Wallet_Info = Member_wallet_balance::where('userId', $userId)->first();

        $Investment = Member_investment_list::where('userId', $userId)->where('invest_status', 0)->first();
        if ($Investment) {
            $Invest_DepositId = $Investment->depositId;
            $Invest_amount = $Investment->amount;
            $Total_ROI = Member_roi_list::where('userId', $userId)->where('depositId', $Invest_DepositId)->sum('roi_amount');
        } else {
            $Invest_amount = 0;
            $Total_ROI = 0;
        }


        // if ($Investment) {
        //     $latest_invest_date = $Investment->created_at;
        // } else {
        $latest_investments = Member_investment_list::where('userId', $userId)->where('invest_status', 1)->orderBy('created_at', 'DESC')->first();
        if ($latest_investments) {
            $latest_invest_date = $latest_investments->updated_at;
        } else {
            $latest_invest_date = date_format(date_create('0001-01-01 00:00:00'), 'Y-m-d');
        }
        // }

        $Total_Direct = Member_referral_list::where('otherUserId', $userId)->where('updated_at', '>', $latest_invest_date)->sum('amount');

        $Total_Binary = Member_binarybonus_list::where('userId', $userId)->where('updated_at', '>', $latest_invest_date)->sum('bonus');

        $BinarySide_info = Users_affiliate_structure::where('userId', $userId)->first();

        $AffiliateModel = new Users_affiliate_structure;
        $Get_All_BinarySide_info = $AffiliateModel->getAllUsersAffiliate()->toArray();
        $All_Member_BinarySide_info = json_encode($Get_All_BinarySide_info);
        $dashboard_data = array(
            'User_Info' => $User_Info,
            'User_Wallet_Info' => $User_Wallet_Info,
            'Total_ROI' => round($Total_ROI,2),
            'Total_Direct' => round($Total_Direct,2),
            'Total_Binary' => round($Total_Binary,2),
            'BinarySide_info' => $BinarySide_info,
            'Investment' => $Investment,
            'Invest_amount' => $Invest_amount,
            'All_Member_BinarySide_info' => $All_Member_BinarySide_info,
            'User_LeftReferral_Link' => $User_LeftReferral_Link,
            'User_RightReferral_Link' => $User_RightReferral_Link,
        );
        return $dashboard_data;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        require app_path('Http/API/src/keys.php');

        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;

        $cps_api = new CoinpaymentsAPI($private_key, $public_key, 'json');

        try {
            $all_txIds = '';
            $latest_txninfo = Member_latest_txninfo::where('userId', $userId)->first();
            if ($latest_txninfo) {
                $before_date = $latest_txninfo->date;
            } else {
                $before_date = date_format(date_create('0001-01-01 01:01:01'), 'Y-m-d H:i:s');
            }
            $query = Transaction::where('userId', $userId)->where('created_at', '>', $before_date);
            $new_last_date = $query->max('created_at');
            $txn_lists = $query->get()->toArray();



            //Update last pending data before last date
            $before_pending_datas = Transaction::where('userId', $userId)->where('created_at', '<=', $before_date)
                ->where('status', '=', 0)
                // ->where('status', '=', -1)
                ->get()
                ->toArray();
            $all_pending_txIds = '';
            foreach ($before_pending_datas as $key => $pending_data) {
                if ($key == 0) {
                    $all_pending_txIds .= $pending_data['txn_id'];
                } else {
                    $all_pending_txIds .= '|' . $pending_data['txn_id'];
                }
            }
            $pending_txInfos = $cps_api->GetTxInfoMulti($all_pending_txIds); // Limit of TxnIds : 25
            $pending_txInfos_results = $pending_txInfos['result'];

            $sum_pending_amount = 0; //sum_amount all pending data confirmed now.
            if ($pending_txInfos_results) {
                foreach ($pending_txInfos_results as $key => $pending_txInfo) {
                    if ($pending_txInfo['status'] == 100 || $pending_txInfo['status'] == 1) {
                        $sum_pending_amount += round($pending_txInfo['receivedf'] * 1);
                    }
                    Transaction::where('userId', $userId)
                        ->where('txn_id', $key)
                        ->update([
                            'status' =>  $pending_txInfo['status'],
                            'status_text' =>  $pending_txInfo['status_text'],
                            'type' =>  $pending_txInfo['type'],
                            'coin' =>  $pending_txInfo['coin'],
                            'amount' =>  $pending_txInfo['amount'],
                            'amountf' =>  $pending_txInfo['amountf'],
                            'received' =>  $pending_txInfo['received'],
                            'receivedf' =>  $pending_txInfo['receivedf'],
                            'recv_confirms' =>  $pending_txInfo['recv_confirms'],
                            'payment_address' =>  $pending_txInfo['payment_address']
                        ]);
                }
            }

            if ($sum_pending_amount * 1 > 0) {
                $getBeforeUserBalance = Member_wallet_balance::where('userId', $userId)->first();
                $beforeUserBalance = $getBeforeUserBalance->cash_balance;
                $new_balance_apb = $beforeUserBalance * 1 + $sum_pending_amount * 1;

                // Updating member's cash balance info in member_wallet_balances
                Member_wallet_balance::where('userId', $userId)
                    ->update([
                        'cash_balance' =>  $new_balance_apb,
                    ]);
            }


            // If there is new transaction, execute next step
            if ($txn_lists) {
                $new_last_txnid = Transaction::where('userId', $userId)->where('created_at', '=', $new_last_date)->first()->txn_id;

                foreach ($txn_lists as $key => $txn_list) {
                    if ($key == 0) {
                        $all_txIds .= $txn_list['txn_id'];
                    } else if ($key > 0 && $key % 3 == 0) {
                        $all_txIds .=  '&' . $txn_list['txn_id'];
                    } else {
                        $all_txIds .= '|' . $txn_list['txn_id'];
                    }
                }
                $explode_array = explode("&", $all_txIds);

                //Update transaction lists
                foreach ($explode_array as $i => $temp) {
                    $txInfoMultis = $cps_api->GetTxInfoMulti($temp); // Limit of TxnIds : 25
                    $txInfos_results = $txInfoMultis['result'];

                    foreach ($txInfos_results as $key => $info) {
                        Transaction::where('userId', $userId)
                            ->where('txn_id', $key)
                            ->update([
                                'status' =>  $info['status'],
                                'status_text' =>  $info['status_text'],
                                'type' =>  $info['type'],
                                'coin' =>  $info['coin'],
                                'amount' =>  $info['amount'],
                                'amountf' =>  $info['amountf'],
                                'received' =>  $info['received'],
                                'receivedf' =>  $info['receivedf'],
                                'recv_confirms' =>  $info['recv_confirms'],
                                'payment_address' =>  $info['payment_address']
                            ]);
                    }
                }



                // Counting sum of amountf to update last data
                $sum_amountf = Transaction::where('userId', $userId)->where('created_at', '>', $before_date)
                    // ->where(function ($query) {
                    //     $query->where('status', '=', 100)
                    //         ->orWhere('status', '=', 1);
                    // })
                    // ->where('status', '=', 100)
                    // ->sum('amountf');
                    ->sum('usd_amount');
                // Updating new last data
                if ($latest_txninfo) {
                    $latest_funds_amount = $latest_txninfo->funds_amount;
                    $new_funds_amount = $latest_funds_amount * 1 + $sum_amountf * 1;
                    Member_latest_txninfo::where('userId', $userId)
                        ->update([
                            'userId' =>  $userId,
                            'date' =>  $new_last_date,
                            'funds_amount' =>  $new_funds_amount,
                            'txn_id' =>  $new_last_txnid,
                        ]);
                } else {
                    $latest_txninfo = new Member_latest_txninfo;
                    $latest_txninfo->userId =  $userId;
                    $latest_txninfo->date =  $new_last_date;
                    $latest_txninfo->funds_amount =  $sum_amountf;
                    $latest_txninfo->txn_id =  $new_last_txnid;
                    $latest_txninfo->save();
                }

                $get_cash_balance = Member_wallet_balance::where('userId', $userId)->first();
                if ($get_cash_balance->cash_balance) {
                    $new_balance = $sum_amountf * 1 + $get_cash_balance->cash_balance * 1;
                } else {
                    $new_balance = $sum_amountf;
                }

                // Updating member's cash balance info in member_wallet_balances
                Member_wallet_balance::where('userId', $userId)
                    ->update([
                        'cash_balance' =>  $new_balance,
                    ]);
            }
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
            exit();
        }
        $data = $this->dashboarddata();

        //Get Today's Daily ROI Percentage
        $query_daily_roi_percentage = Daily_ROI_Percentage::where('created_at', date('Y-m-d'))->first();
        if ($query_daily_roi_percentage) {
            $today_daily_roi_percentage = $query_daily_roi_percentage->percent;
        } else {
            $today_daily_roi_percentage = null;
        }

        //Get Latest Direct_Referral Percentage
        $query_referral_percentage = Direct_Referral_Percentage::orderBy('created_at', 'DESC')->first();
        if ($query_referral_percentage) {
            $direct_referral_percentage = $query_referral_percentage->percent;
        } else {
            $direct_referral_percentage = null;
        }

        //Get Latest Binary Bonus Percentage
        $query_binary_percentage = Binary_Bonus_Percentage::orderBy('created_at', 'DESC')->first();
        if ($query_binary_percentage) {
            $binary_bonus_percentage = $query_binary_percentage->percent;
        } else {
            $binary_bonus_percentage = null;
        }

        return view('dashboard')->with([
            'User_Info' => $data['User_Info'],
            'User_Wallet_Info' => $data['User_Wallet_Info'],
            'Total_ROI' => $data['Total_ROI'],
            'Total_Direct' => $data['Total_Direct'],
            'Total_Binary' => $data['Total_Binary'],
            'BinarySide_info' => $data['BinarySide_info'],
            'Investment' => $data['Investment'],
            'Invest_amount' => $data['Invest_amount'],
            'All_Member_BinarySide_info' => $data['All_Member_BinarySide_info'],
            'User_LeftReferral_Link' => $data['User_LeftReferral_Link'],
            'User_RightReferral_Link' => $data['User_RightReferral_Link'],
            'today_daily_roi_percentage' => $today_daily_roi_percentage,
            'direct_referral_percentage' => $direct_referral_percentage,
            'binary_bonus_percentage' => $binary_bonus_percentage,
        ]);
    }
}
