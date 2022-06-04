<?php

namespace App\Http\Controllers\Funds;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Http\API\src\CoinpaymentsAPI;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Member_wallet_balance;

use App\Http\Controllers\CalculatingFundsController;

class Add_FundsController extends Controller
{
    public function index()
    {
        require app_path('Http/API/src/keys.php');

        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;
        $userData = User::where('userId', $userId)->first();

        // Create a new API wrapper instance
        $cps_api = new CoinpaymentsAPI($private_key, $public_key, 'json');

        $coins = array();

        try {
            $ratesWithAccepted = $cps_api->GetRatesWithAccepted();
            dump($ratesWithAccepted); exit;
            foreach ($ratesWithAccepted['result'] as $key => $rate) {
                if ($rate['accepted'] == 1) {
                    $temp = array(
                        "key" => $key,
                        "rate" =>  $rate,
                    );
                    array_push($coins, $temp);
                }
            }
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
            exit();
        }

        return view('pages.funds.add_funds')->with(['userData' => $userData, 'coins' => $coins]);
    }

    public function payment(Request $request)
    {
        // include app_path('Http/API/src/CoinpaymentsAPI.php');
        // dump(app_path('Http/API/src/CoinpaymentsAPI.php'));exit;
        require dirname(__FILE__) . '/../../API/src/keys.php';

        $user = Session::get('user');   // Session User Data

        // Create a new API wrapper instance
        $cps_api = new CoinpaymentsAPI($private_key, $public_key, 'json');

        // $ipn_api = new Ipn();
        // dump($ipn_api);

        // Enter amount for the transaction
        $amount = $request->payAmount;

        // Litecoin Testnet is a no value currency for testing
        $currency = $request->paymentMode;

        // Enter buyer email below
        $buyer_email = $user->email;

        // Make call to API to create the transaction
        try {
            $transaction_response = $cps_api->CreateSimpleTransaction($amount, $currency, $buyer_email, $ipn_url);
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
            exit();
        }

        if ($transaction_response['error'] == 'ok') {
            $timeout = $transaction_response['result']['timeout'];
            $transaction_id = $transaction_response['result']['txn_id'];

            //simpleTransactionInfo
            $txInfoSingle = $cps_api->GetTxInfoSingle($transaction_id);
            $recv_confirms = $txInfoSingle['result']['recv_confirms'] == 0 ? '(unconfirmed)' : '';

            //Public Information
            $basicInfo = $cps_api->GetBasicInfo();

            if ($txInfoSingle['error'] == 'ok') {
                $xml = '
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td align="right" style="padding: 10px;">Status:</td>
                                <td align="left"  style="padding: 10px;">' . $txInfoSingle['result']['status_text'] . '</td>
                            </tr>
                            <tr>
                                <td align="right" style="padding: 10px;">Total Amount To Send:</td>
                                <td align="left"  style="padding: 10px;"><strong>' . $txInfoSingle['result']['amountf'] . $txInfoSingle['result']['coin'] . '</strong> (total confirms needed: ' . $txInfoSingle['result']['recv_confirms'] . ')</td>
                            </tr>
                            <tr>
                                <td align="right" style="padding: 10px;">Received So Far:</td>
                                <td align="left"  style="padding: 10px;">' . $txInfoSingle['result']['receivedf'] . $txInfoSingle['result']['coin'] . $recv_confirms . '</td>
                            </tr>
                            <tr>
                                <td align="right" style="vertical-align: top; padding: 10px;">Balance Remaining:</td>
                                <td align="left"  style="padding: 10px;">
                                    <a href="' . $currency . ':' . $txInfoSingle['result']['payment_address'] . '?amount=' . $txInfoSingle['result']['amount'] . '">' . $txInfoSingle['result']['amount'] . $txInfoSingle['result']['coin'] . '</a> <br>
                                    <img src="' . $transaction_response['result']['qrcode_url'] . '" border="0" data-xblocker="passed" style="visibility: visible;">
                                </td>
                            </tr>
                            <tr>
                                <td align="right" style="padding: 10px;">Send To Address:</td>
                                <td align="left"  style="padding: 10px;">' . $txInfoSingle['result']['payment_address'] . '</td>
                            </tr>
                            <tr>
                                <td align="right" style="padding: 10px;">Time Left For Us to Confirm Funds:</td>
                                <td align="left"  style="padding: 10px;"><b><span class="status-countdown"></span></b></td>

                                <script type="text/javascript">
                                    var left = ' . $timeout . ';

                                    function duration2(secs) {
                                        if (secs <= 0) {
                                            return "Too Late";
                                        }
                                        var vDay = Math.floor(secs / 86400);
                                        secs -= (vDay * 86400);
                                        var vHour = Math.floor(secs / 3600);
                                        secs -= (vHour * 3600);
                                        var vMin = Math.floor(secs / 60);
                                        secs -= (vMin * 60);

                                        var sout = "";
                                        if (vDay > 0) {
                                            sout = sout + vDay + "d ";
                                        }
                                        if (vHour > 0) {
                                            sout = sout + vHour + "h ";
                                        }
                                        if (vMin > 0) {
                                            sout = sout + vMin + "m ";
                                        }
                                        if (secs > 0) {
                                            sout = sout + secs + "s";
                                        }
                                        return sout.trim();
                                    }

                                    function updCountdown() {
                                        var el = document.getElementsByClassName("status-countdown");
                                        var i = 0;
                                        for (i = 0; i < el.length; i++) {
                                            el[i].innerHTML = duration2(left);
                                        }
                                        left--;
                                    }
                                    setInterval(updCountdown, 1000);
                                </script>
                            </tr>
                            <tr>
                                <td align="right" style="padding: 10px;">Seller:</td>
                                <td align="left"  style="padding: 10px;">' . $basicInfo['result']['public_name'] . '</td>
                            </tr>
                            <tr>
                                <td align="right" style="padding: 10px;">Seller Email:</td>
                                <td align="left"  style="padding: 10px;"><a href="' . $basicInfo['result']['email'] . '">support@nmvfis.com</a><br></td>
                            </tr>
                            <tr>
                                <td align="right" style="padding: 10px;">Leave Feedback:</td>
                                <td align="left"  style="padding: 10px;">You will be able to leave feedback once this transaction is completed.</td>
                            </tr>
                            <tr>
                                <td align="right" style="padding: 10px;">Payment ID:</td>
                                <td align="left"  style="padding: 10px;">' . $transaction_response['result']['txn_id'] . '<br>(have this handy if you need any support related to this transaction)</td>
                            </tr>
                        </tbody>
                    </table>
                ';

                // Insert Transaction Data into Database
                $transaction = new Transaction;
                $transaction->userId =  $user->userId;
                $transaction->txn_id =  $transaction_response['result']['txn_id'];
                $transaction->address =  $transaction_response['result']['address'];
                $transaction->usd_amount =  $amount;       // This is USD Amount
                $randomDepositId = uniqid();
                $transaction->depositId =  $randomDepositId;
                $transaction->timeout =  $transaction_response['result']['timeout'];
                $transaction->confirms_needed =  $transaction_response['result']['confirms_needed'];
                $transaction->checkout_url =  $transaction_response['result']['checkout_url'];
                $transaction->status_url =  $transaction_response['result']['status_url'];
                $transaction->qrcode_url =  $transaction_response['result']['qrcode_url'];
                $transaction->save();

                $calculatingFunds_Controller = new CalculatingFundsController;
                $calculatingFunds_Controller->index($cps_api);

                return response()->json(['status' => 200, 'xml' => $xml]);
            } else {
                $error = 'Error: ' . $txInfoSingle['error'];
                return response()->json(['status' => 400, 'error' => $error]);
            }
        } else {
            $error = 'Error: ' . $transaction_response['error'];
            return response()->json(['status' => 400, 'error' => $error]);
        }
    }

    public function admin_payment(Request $request)
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;
        $amount = $request->payAmount;

        try {
            $getAdminCashData = Member_wallet_balance::where('userId', $userId)->first();
            $current_cash = $getAdminCashData->cash_balance;
            $new_cash = $current_cash * 1 + $amount * 1;
            Member_wallet_balance::where('userId', $userId)
                ->update([
                    'cash_balance' =>  $new_cash,
                ]);

            return response()->json(['status' => 200]);
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
            exit();
        }
    }
}
