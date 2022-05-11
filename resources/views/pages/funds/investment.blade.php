@extends('layouts.app', ['activePage' => 'investment', 'titlePage' => __('Make an Investment')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-info">
                <h4 class="card-title">Cash Wallet Balance</h4>
                <span class="bg-soft-success text-primary">$ {{$data->cash_balance}}</span>
            </div>
            <div class="card-body" style="display: flex; justify-content: center;">
                <div class="col-lg-6">
                    <div class="wallet-body">
                        <div class="wallet-div">
                            <label class="label_title_2">Enter User Id</label>
                            <input id="userId" class="form-group-control input-radius" type="text" value='{{$data->userId}}' name="userid" disabled>
                        </div>
                        <div class="wallet-div">
                            <label class="label_title_2">Select Package</label>
                            <select id="package" class="wallet-select" onchange="handlepackage()">
                                <option disabled selected>Select Package</option>
                                <option value="50 to 9999">50 to 9999</option>
                            </select>
                        </div>
                    </div>
                    <div class="wallet-body">
                        <div class="wallet-div" style="padding: 0px;">
                            <label class="label_title_2">Amount</label>
                            <input id="amount" class="form-group-control input-radius" type="number" placeholder="Enter Amount" name="amount" onchange="handleAmount()">
                            <p id="alert" style="margin: 0px; text-align:left; color:red;"></p>
                        </div>
                        <div class="wallet-div" style="padding: 0px;">
                        </div>
                    </div>
                    <div class="text-center">
                        <button id="button" type="button" class="btn w-md" style="width: 100%; margin: 20px 0px" onclick="makeInvestment()" disabled>Submit</button>
                        <p id="invest_alert" style="margin: 0px; text-align:left; color:red;"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // $(document).ready(function() {
    //     document.getElementById("button").classList.remove("btn-info");
    // });

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

    function handleStatusCheck() {
        $invest_status = `{{$invest_status}}`;
        $package = $("#package").val();
        $amount = $("#amount").val();
        if (!$package) {
            $alert_txt = 'Please Select Package';
            document.getElementById('alert').innerHTML = $alert_txt;
        } else {
            $from_amount = $package.split("to")[0] * 1;
            $to_amount = $package.split("to")[1] * 1;
            if ($amount >= $from_amount && $amount <= $to_amount) {
                document.getElementById('alert').innerHTML = '';
                if ($invest_status == false) {
                    $alert_txt = "You can't invest because your last investment isn't over yet!";
                    document.getElementById('invest_alert').innerHTML = $alert_txt;
                } else {
                    document.getElementById("button").disabled = false;
                    document.getElementById('invest_alert').innerHTML = '';
                    document.getElementById("button").classList.add("btn-info");
                }
            } else {
                $alert_txt = 'Amount should be in the range from ' + $("#package").val();
                document.getElementById("button").disabled = true;
                document.getElementById('alert').innerHTML = $alert_txt;
                document.getElementById("button").classList.remove("btn-info");
            };
        }
    }

    function handlepackage() {
        $alert_txt = 'Amount should be in the range from ' + $("#package").val();
        document.getElementById('alert').innerHTML = $alert_txt;
        handleStatusCheck();
    }

    function handleAmount() {
        $package = $("#package").val();
        $amount = $("#amount").val();
        if (!$package) {
            $alert_txt = 'Please Select Package';
            document.getElementById('alert').innerHTML = $alert_txt;
        } else {
            handleStatusCheck();
        }
    }

    function makeInvestment() {
        $amount = $("#amount").val();
        $package = $("#package").val();
        $balance = `{{$data->cash_balance}}` * 1;
        if ($amount > $balance) {
            notify('danger', 'You have insufficient balance in Cash Wallet', 'top', 'right');
        } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: "make_investment/post",
                data: {
                    amount: $amount,
                    package: $package,
                },
                success: function(data) {
                    console.log('data', data)
                    if (data.status == 200) {
                        notify('success', 'Thanks for your Investment', 'top', 'right');
                        location = "/make_investment";
                        location.reload();
                    } else if (data.status == 400) {
                        notify('danger', data.error, 'top', 'right');
                        return;
                    }
                }
            });
        }
    }
</script>
@endsection