<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Http\API\src\CoinpaymentsAPI;
use App\Models\User;
use App\Models\Member_latest_txninfo;
use App\Models\Member_wallet_balance;
use App\Models\Transaction;

class CalculatingFundsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function index($cps_api)
    // {
    //     $user = Session::get('user');   // Session User Data
    //     $userId = $user->userId;

    //     // $cps_api = new CoinpaymentsAPI($private_key, $public_key, 'json');

    //     try {
    //         $all_txIds = '';
    //         $latest_txninfo = Member_latest_txninfo::where('userId', $userId)->first();
    //         if ($latest_txninfo) {
    //             $before_date = $latest_txninfo->date;
    //         } else {
    //             $before_date = date_format(date_create('0001-01-01 01:01:01'), 'Y-m-d H:i:s');
    //         }
    //         $query = Transaction::where('userId', $userId)->where('created_at', '>', $before_date);
    //         $new_last_date = $query->max('created_at');
    //         $txn_lists = $query->get()->toArray();


    //         //Update last pending data before last date
    //         $before_pending_datas = Transaction::where('userId', $userId)->where('created_at', '<=', $before_date)
    //             ->where('status', '=', 0)
    //             // ->where('status', '=', -1)
    //             ->get()
    //             ->toArray();
    //         $all_pending_txIds = '';
    //         foreach ($before_pending_datas as $key => $pending_data) {
    //             if ($key == 0) {
    //                 $all_pending_txIds .= $pending_data['txn_id'];
    //             } else {
    //                 $all_pending_txIds .= '|' . $pending_data['txn_id'];
    //             }
    //         }
    //         $pending_txInfos = $cps_api->GetTxInfoMulti($all_pending_txIds); // Limit of TxnIds : 25
    //         $pending_txInfos_results = $pending_txInfos['result'];

    //         $sum_pending_amount = 0; //sum_amount all pending data confirmed now.
    //         if ($pending_txInfos_results) {
    //             foreach ($pending_txInfos_results as $key => $pending_txInfo) {
    //                 if ($pending_txInfo['status'] == 100 || $pending_txInfo['status'] == 1) {
    //                     $sum_pending_amount += round($pending_txInfo['receivedf'] * 1);
    //                 }
    //                 Transaction::where('userId', $userId)
    //                     ->where('txn_id', $key)
    //                     ->update([
    //                         'status' =>  $pending_txInfo['status'],
    //                         'status_text' =>  $pending_txInfo['status_text'],
    //                         'type' =>  $pending_txInfo['type'],
    //                         'coin' =>  $pending_txInfo['coin'],
    //                         'amount' =>  $pending_txInfo['amount'],
    //                         'amountf' =>  $pending_txInfo['amountf'],
    //                         'received' =>  $pending_txInfo['received'],
    //                         'receivedf' =>  $pending_txInfo['receivedf'],
    //                         'recv_confirms' =>  $pending_txInfo['recv_confirms'],
    //                         'payment_address' =>  $pending_txInfo['payment_address']
    //                     ]);
    //             }
    //         }
    //         if ($sum_pending_amount * 1 > 0) {
    //             $getBeforeUserBalance = Member_wallet_balance::where('userId', $userId)->first();
    //             $beforeUserBalance = $getBeforeUserBalance->cash_balance;
    //             $new_balance_apb = $beforeUserBalance * 1 + $sum_pending_amount * 1;

    //             // Updating member's cash balance info in member_wallet_balances
    //             Member_wallet_balance::where('userId', $userId)
    //                 ->update([
    //                     'cash_balance' =>  $new_balance_apb,
    //                 ]);
    //         }


    //         // If there is new transaction, execute next step
    //         if ($txn_lists) {
    //             $new_last_txnid = Transaction::where('userId', $userId)->where('created_at', '=', $new_last_date)->first()->txn_id;

    //             foreach ($txn_lists as $key => $txn_list) {
    //                 if ($key == 0) {
    //                     $all_txIds .= $txn_list['txn_id'];
    //                 } else if ($key > 0 && $key % 24 == 0) {
    //                     $all_txIds .=  '&' . $txn_list['txn_id'];
    //                 } else {
    //                     $all_txIds .= '|' . $txn_list['txn_id'];
    //                 }
    //             }
    //             $explode_array = explode("&", $all_txIds);

    //             //Update transaction lists
    //             foreach ($explode_array as $i => $temp) {
    //                 $txInfoMultis = $cps_api->GetTxInfoMulti($temp); // Limit of TxnIds : 25
    //                 $txInfos_results = $txInfoMultis['result'];

    //                 foreach ($txInfos_results as $key => $info) {
    //                     Transaction::where('userId', $userId)
    //                         ->where('txn_id', $key)
    //                         ->update([
    //                             'status' =>  $info['status'],
    //                             'status_text' =>  $info['status_text'],
    //                             'type' =>  $info['type'],
    //                             'coin' =>  $info['coin'],
    //                             'amount' =>  $info['amount'],
    //                             'amountf' =>  $info['amountf'],
    //                             'received' =>  $info['received'],
    //                             'receivedf' =>  $info['receivedf'],
    //                             'recv_confirms' =>  $info['recv_confirms'],
    //                             'payment_address' =>  $info['payment_address']
    //                         ]);
    //                 }
    //             }

    //             // //Update last pending data before last date
    //             // $before_pending_datas = Transaction::where('userId', $userId)->where('created_at', '<=', $before_date)
    //             //     // ->where('status', '=', 0)
    //             //     // ->where('status', '=', -1)
    //             //     ->get()
    //             //     ->toArray();
    //             // $all_pending_txIds = '';
    //             // foreach ($before_pending_datas as $key => $pending_data) {
    //             //     if ($key == 0) {
    //             //         $all_pending_txIds .= $pending_data['txn_id'];
    //             //     } else {
    //             //         $all_pending_txIds .= '|' . $pending_data['txn_id'];
    //             //     }
    //             // }
    //             // $pending_txInfos = $cps_api->GetTxInfoMulti($all_pending_txIds); // Limit of TxnIds : 25
    //             // $pending_txInfos_results = $pending_txInfos['result'];

    //             // if ($pending_txInfos_results) {
    //             //     foreach ($pending_txInfos_results as $key => $pending_txInfo) {
    //             //         Transaction::where('userId', $userId)
    //             //             ->where('txn_id', $key)
    //             //             ->update([
    //             //                 'status' =>  $pending_txInfo['status'],
    //             //                 'status_text' =>  $pending_txInfo['status_text'],
    //             //                 'type' =>  $pending_txInfo['type'],
    //             //                 'coin' =>  $pending_txInfo['coin'],
    //             //                 'amount' =>  $pending_txInfo['amount'],
    //             //                 'amountf' =>  $pending_txInfo['amountf'],
    //             //                 'received' =>  $pending_txInfo['received'],
    //             //                 'receivedf' =>  $pending_txInfo['receivedf'],
    //             //                 'recv_confirms' =>  $pending_txInfo['recv_confirms'],
    //             //                 'payment_address' =>  $pending_txInfo['payment_address']
    //             //             ]);
    //             //     }
    //             // }

    //             // Counting sum of amountf to update last data
    //             $sum_amountf = Transaction::where('userId', $userId)->where('created_at', '>', $before_date)
    //                 // ->where(function ($query) {
    //                 //     $query->where('status', '=', 100)
    //                 //         ->orWhere('status', '=', 1);
    //                 // })
    //                 // ->sum('amountf');
    //                 ->sum('usd_amount');
    //             // Updating new last data
    //             if ($latest_txninfo) {
    //                 $latest_funds_amount = $latest_txninfo->funds_amount;
    //                 $new_funds_amount = $latest_funds_amount * 1 + $sum_amountf * 1;
    //                 Member_latest_txninfo::where('userId', $userId)
    //                     ->update([
    //                         'userId' =>  $userId,
    //                         'date' =>  $new_last_date,
    //                         'funds_amount' =>  $new_funds_amount,
    //                         'txn_id' =>  $new_last_txnid,
    //                     ]);
    //             } else {
    //                 $latest_txninfo = new Member_latest_txninfo;
    //                 $latest_txninfo->userId =  $userId;
    //                 $latest_txninfo->date =  $new_last_date;
    //                 $latest_txninfo->funds_amount =  $sum_amountf;
    //                 $latest_txninfo->txn_id =  $new_last_txnid;
    //                 $latest_txninfo->save();
    //             }

    //             $get_cash_balance = Member_wallet_balance::where('userId', $userId)->first();
    //             if ($get_cash_balance->cash_balance) {
    //                 $new_balance = $sum_amountf * 1 + $get_cash_balance->cash_balance * 1;
    //             } else {
    //                 $new_balance = $sum_amountf;
    //             }

    //             // Updating member's cash balance info in member_wallet_balances
    //             Member_wallet_balance::where('userId', $userId)
    //                 ->update([
    //                     'cash_balance' =>  $new_balance,
    //                 ]);

    //             return null;
    //         }
    //     } catch (\Exception $e) {
    //         echo 'Error: ' . $e->getMessage();
    //         exit();
    //     }

    //     return null;
    // }
}
