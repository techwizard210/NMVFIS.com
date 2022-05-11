@extends('layouts.app', ['activePage' => 'withdrawal', 'titlePage' => __('Withdrawal Wallet to Cash Wallet transfer')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-info">
                <h4 class="card-title">Withdrawal Wallet To Investment Wallet</h4>
                <span class="bg-soft-success text-primary">$ {{$data->income_amount}}</span>
            </div>
            <div class="card-body" style="display: flex; justify-content: center;">
                <div class="col-lg-4 col-md-6">
                    <div class="">
                        <label class="label_title_2">Enter User Id</label>
                        <input id="userId" class="form-group-control input-radius" type="text" placeholder="User Id" value='{{$data->userId}}' name="userid" disabled>
                    </div>
                    <div class="">
                        <label class="label_title_2">Amount</label>
                        <div style="display: flex; align-items: center;">
                            <input id="amount" class="form-group-control input-radius" type="number" min="1" placeholder="Enter Amount" name="amount" onchange="handleAmount()">
                        </div>
                    </div>
                    <div class="text-center">
                        <button id="button" type="button" class="btn w-md" style="width: 100%; margin: 20px 0px" onclick="transfer()" disabled>Submit</button>
                        <p id="alert" style="margin: 0px; text-align:left; color:red;"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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

    function handleAmount() {
        $withdrawal_balance = `{{$data->income_amount}}` * 1;
        $amount = $("#amount").val() * 1;
        if ($amount >= 50) {
            if ($amount >= $withdrawal_balance) {
                $alert_txt = 'Amount should be smaller than Withdrawal Wallet Balance !';
                document.getElementById('alert').innerHTML = $alert_txt;
                document.getElementById("button").disabled = true;
                document.getElementById("button").classList.remove("btn-info");
            } else {
                $alert_txt = '';
                document.getElementById('alert').innerHTML = $alert_txt;
                document.getElementById("button").disabled = false;
                document.getElementById("button").classList.add("btn-info");
            }
        } else {
            $alert_txt = 'Amount should be bigger than 50 !';
            document.getElementById('alert').innerHTML = $alert_txt;
            document.getElementById("button").disabled = true;
            document.getElementById("button").classList.remove("btn-info");
        }
    }

    function transfer() {
        $amount = $("#amount").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: "wallet_withdrawal/post",
            data: {
                amount: $amount,
            },
            success: function(data) {
                console.log('data', data)
                if (data.status == 200) {
                    notify('success', 'Transfer Success!', 'top', 'right');
                    location = "/wallet_withdrawal";
                    location.reload();
                } else if (data.status == 400) {
                    notify('danger', data.error, 'top', 'right');
                    return;
                }
            }
        });
    }
</script>
@endsection