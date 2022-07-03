@extends('layouts.app', ['activePage' => 'transfer', 'titlePage' => __('Cash Wallet To Other Member Cash Wallet Transfer')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-info">
                <h4 class="card-title">Transfer Investment Wallet To Other Member Investment Wallet</h4>
                <span class="bg-soft-success text-primary">$ {{$data->cash_balance}}</span>
            </div>
            <div class="card-body col-lg-4 col-md-4 col-sm-6" style="margin: auto;">
                <div class="">
                    <label class="label_title_2">Enter User Id</label>
                    <input id="otheruserid" class="form-group-control input-radius" type="text" placeholder="Enter User Id" value="" name="userid" onchange="handleotheruserid()">
                    <p id="user_alert" style="margin: 0px; text-align:left; color:red;"></p>
                </div>
                <div class="">
                    <label class="label_title_2">Amount</label>
                    <input id="amount" class="form-group-control input-radius" type="number" placeholder="Enter Amount" value="" name="amount" onchange="handleAmount()">
                    <p id="amount_alert" style="margin: 0px; text-align:left; color:red;"></p>
                </div>
                <div class="text-center">
                    <button id="button" type="button" class="btn w-md" style="width: 100%; margin: 20px 0px" onclick="maketransfer()" disabled>Submit</button>
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


    function handleStatusCheck() {
        $userId = `{{$data->userId}}`;
        $otheruserid = $("#otheruserid").val();
        $userIdList = <?php echo json_encode($userIdList); ?>;
        $userNameList = <?php echo json_encode($userNameList); ?>;
        $temp = $userIdList.indexOf($otheruserid);

        $amount = $("#amount").val() * 1;
        $balance = `{{$data->cash_balance}}` * 1;
        if ($userId !== $otheruserid && $otheruserid && $temp >= 0 && $amount > 0 && $amount <= $balance) {
            document.getElementById("button").disabled = false;
            document.getElementById("button").classList.add("btn-info");
        } else {
            document.getElementById("button").disabled = true;
            document.getElementById("button").classList.remove("btn-info");
        };
    }

    function handleotheruserid() {
        $userId = `{{$data->userId}}`;
        $otheruserid = $("#otheruserid").val();
        $userIdList = <?php echo json_encode($userIdList); ?>;
        $userNameList = <?php echo json_encode($userNameList); ?>;
        $temp = $userIdList.indexOf($otheruserid);
        if ($temp == -1) {
            $alert_txt = 'Not Available UserId';
            document.getElementById('user_alert').innerHTML = $alert_txt;
            $('#user_alert').css({
                'color': 'red'
            });
            handleStatusCheck();
        } else if ($userId == $otheruserid) {
            $alert_txt = 'You can not transfer fund to self account';
            document.getElementById('user_alert').innerHTML = $alert_txt;
            $('#user_alert').css({
                'color': 'red'
            });
            handleStatusCheck();
        } else {
            $searchname = $userNameList[$temp];
            $alert_txt = 'Available <br />' + $otheruserid + '( ' + $searchname + ' )';
            document.getElementById('user_alert').innerHTML = $alert_txt;
            $('#user_alert').css({
                'color': '#19e428'
            });
            handleStatusCheck();
        }
    }

    function handleAmount() {
        $amount = $("#amount").val() * 1;
        $balance = `{{$data->cash_balance}}` * 1;
        if ($amount > $balance) {
            $alert_txt = 'Amount should be smaller than Wallet Balance!';
            document.getElementById('amount_alert').innerHTML = $alert_txt;
            handleStatusCheck();
        } else {
            document.getElementById('amount_alert').innerHTML = '';
            handleStatusCheck();
        }
    }

    function maketransfer() {
        $otheruserid = $("#otheruserid").val();
        $amount = $("#amount").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: "wallet_transfer/post",
            data: {
                otheruserid: $otheruserid,
                amount: $amount,
            },
            success: function(data) {
                console.log('data', data)
                if (data.status == 200) {
                    notify('success', 'Transfer Success!', 'top', 'right');
                    location = "/wallet_transfer";
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