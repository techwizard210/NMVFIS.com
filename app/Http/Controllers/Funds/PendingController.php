<?php

namespace App\Http\Controllers\Funds;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Http\API\src\CoinpaymentsAPI;
use App\Models\Transaction;

// use PHPUnit\Framework\TestCase;

class PendingController extends Controller
{
    public function index()
    {
        require app_path('Http/API/src/keys.php');

        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;

        // Create a new API wrapper instance
        $cps_api = new CoinpaymentsAPI($private_key, $public_key, 'json');

        $transactionData = array();
        try {
            $transactions = Transaction::where('userId', $userId)->orderBy('updated_at', 'DESC')->get()->toArray();

            if ($transactions) {
                $all_txIds = '';
                foreach ($transactions as $key => $transaction) {
                    if ($key == 0) {
                        $all_txIds .= $transaction['txn_id'];
                    } else if ($key > 0 && $key % 24 == 0) {
                        $all_txIds .=  '&' . $transaction['txn_id'];
                    } else {
                        $all_txIds .= '|' . $transaction['txn_id'];
                    }
                }
                $explode_array = explode("&", $all_txIds);

                foreach ($explode_array as  $temp) {
                    $txInfoMultis = $cps_api->GetTxInfoMulti($temp); // Limit of TxnIds : 25
                    $txInfos_results = $txInfoMultis['result'];

                    foreach ($txInfos_results as $key => $info) {
                        if ($info['status'] == 0) {
                            $txInfo = Transaction::where('userId', $userId)->where('txn_id', $key)->first();
                            if ($txInfo) {
                                $singleInfoArray = $txInfo->toArray();
                            } else {
                                $singleInfoArray = array();
                            }
                            $temp = array(
                                "TxInfoMulti" => $info,
                                "TxInfo" =>  $singleInfoArray,
                            );
                            array_push($transactionData, $temp);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
            exit();
        }

        return view('pages.funds.pending')->with(['data' => $transactionData]);
    }
}
