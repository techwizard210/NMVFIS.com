@extends('layouts.app', ['activePage' => 'balance', 'titlePage' => __('Withdrawal Wallet Balance')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-info">
                <h4 class="card-title">Withdrawal Wallet Balance</h4>
                <span class="bg-soft-success text-primary">$ {{$data->income_amount}}</span>
            </div>
            <div class="card-body" style="display: flex; justify-content: center;">
                <div class="col-lg-4 col-md-6">
                    <div class="">
                        <label class="input-group-text wallet-label">Enter Amount In (USD)</label>
                        <input id="amount" class="input-style input-radius" type="number" min="1" placeholder="Enter Amount" value="0" name="amount" onchange="handleCheck()">
                        <p id="alert_1" style="margin: 0px; text-align:left; color:red;"></p>
                        <p id="alert_2" style="margin: 0px; text-align:left; color:red;"></p>
                    </div>
                    <div id="originalInputDiv" class="mb-3">
                        <label class="input-group-text wallet-label">Original Wallet Address</label>
                        <input id="original_address" class="input-style input-radius" type="text" placeholder="Enter Wallet Address" value="{{$user_data->wallet_address}}" name="amount" onchange="handleCheck()" disabled>
                        <p id="alert_1" style="margin: 0px; text-align:left; color:red;"></p>
                        <p id="alert_2" style="margin: 0px; text-align:left; color:red;"></p>
                    </div>
                    <div id="otherInputDiv" class="mb-3" style="display: none;">
                        <label class="input-group-text wallet-label">Other Wallet Address</label>
                        <input id="other_address" class="input-style input-radius" type="text" placeholder="Enter Other Wallet Address" value="" name="amount" onchange="handleCheck()">
                        <p id="alert_1" style="margin: 0px; text-align:left; color:red;"></p>
                        <p id="alert_2" style="margin: 0px; text-align:left; color:red;"></p>
                    </div>
                    <input id="wallet_address" class="input-style input-radius" type="text" value="1" name="amount" hidden>
                    <div class="form-radio" style="display: flex; justify-content:space-around; align-items:flex-end;">
                        <label class="wallet-label">
                            <input id="original" class="form-radio-input" type="radio" checked value="" onclick="chooseWallet(1)">
                            &nbsp;Original
                        </label>
                        <label class="wallet-label">
                            <input id="otherWallet" class="form-radio-input" type="radio" value="" onclick="chooseWallet(2)">
                            &nbsp;Other Wallet
                        </label>
                    </div>
                    <div class="form-radio" style="display: flex; justify-content:space-between; align-items:flex-end;">
                        <div>
                            <label class="input-group-text wallet-label">Payment Mode</label>
                            <label class="wallet-label">
                                <input class="form-radio-input" type="radio" checked value="">
                                &nbspUSDT
                            </label>
                        </div>
                        <p style="margin: 0px 0px 0px 10px;">-5% Admin Fee Deduction</p>
                    </div>
                    <div class="text-center">
                        <p id="alarm" style="margin: 0px; text-align:left; color:blue;"></p>
                        <button id="button" type="button" class="btn w-md" style="width: 100%; margin: 20px 0px" onclick="makeWithdrawal()" disabled>Withdraw</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function notify(type, txt, from, align) {
        $.notify({
            icon: "add_alert",
            message: txt
        }, {
            type: type,
            timer: 3000,
            placement: {
                from: from,
                align: align
            }
        });
    }

    function chooseWallet(type) {
        if (type == 1) {
            document.getElementById("original").checked = true;
            document.getElementById("otherWallet").checked = false;
            document.getElementById("originalInputDiv").style.display = 'block';
            document.getElementById("otherInputDiv").style.display = 'none';

            document.getElementById("wallet_address").value = '1';
        } else {
            document.getElementById("original").checked = false;
            document.getElementById("otherWallet").checked = true;
            document.getElementById("originalInputDiv").style.display = 'none';
            document.getElementById("otherInputDiv").style.display = 'block';

            document.getElementById("wallet_address").value = '2';
        }
    }

    function handleCheck() {
        $amount = $("#amount").val();
        $balance = `{{$data->income_amount}}` * 1;
        $temp = $amount * 1 % 10;
        if ($amount * 1 < 50) {
            $alert_txt = "Amount must be 50 or more !";
            document.getElementById('alert_1').innerHTML = $alert_txt;
        } else {
            if ($amount > $balance) {
                $alert_txt = "Requested amount should not be bigger than wallet balance !";
                document.getElementById('alert_1').innerHTML = $alert_txt;
            } else {
                $alert_txt = "";
                document.getElementById('alert_1').innerHTML = $alert_txt;
            }
        }

        // if ($temp > 0) {
        //     $alert_txt = "Amount must be multiples of 10 !";
        //     document.getElementById('alert_2').innerHTML = $alert_txt;
        // } else {
        //     $alert_txt = "";
        //     document.getElementById('alert_2').innerHTML = $alert_txt;
        // }

        if ($amount * 1 >= 50 && $amount <= $balance) {
            document.getElementById("button").disabled = false;
            document.getElementById('alert_1').innerHTML = '';
            document.getElementById('alert_2').innerHTML = '';
            document.getElementById("button").classList.add("btn-info");

            $receivable_amount = Math.round($amount * 1 * 0.95);
            $alarm_txt = 'Receivable amount Less 5%: ' + $receivable_amount;
            document.getElementById('alarm').innerHTML = $alarm_txt;
        } else {
            $alarm_txt = '';
            document.getElementById('alarm').innerHTML = $alarm_txt;
            document.getElementById("button").disabled = true;
            document.getElementById("button").classList.remove("btn-info");
        }
    }


    function makeWithdrawal() {
        $amount = $("#amount").val();
        $type = document.getElementById("wallet_address").value;
        if ($type == 1) {
            $wallet_address = document.getElementById("original_address").value;
        } else {
            $wallet_address = document.getElementById("other_address").value;
        }
        if ($wallet_address) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: "withdrawal_balance/post",
                data: {
                    amount: $amount,
                    wallet_address: $wallet_address,
                },
                success: function(data) {
                    if (data.status == 200) {
                        notify('success', 'Request Success!', 'top', 'right');
                        location = "/withdrawal_balance";
                        location.reload();
                    } else if (data.status == 400) {
                        notify('danger', data.error, 'top', 'right');
                        return;
                    }
                }
            });
        }else{
            notify('warning', 'Please enter Wallet Address !', 'top', 'right');
        }
    }
</script>

@endsection