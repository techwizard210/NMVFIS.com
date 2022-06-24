@extends('layouts.app', ['activePage' => 'invest_others', 'titlePage' => __('Invest For Others')])

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
                            <input id="otheruserid" class="form-group-control input-radius" type="text" value="" name="otheruserid" onchange="handleotheruserid()">
                            <p id="user_alert" style="margin: 0px; text-align:left; color:red;"></p>
                        </div>
                        <div class="wallet-div">
                            <label class="label_title_2">Select Package</label>
                            <select id="package" class="wallet-select" onchange="handlepackage_amount()">
                                <option disabled selected>Select Package</option>
                                <option value="50 to 9999">50 to 9999</option>
                            </select>
                        </div>
                    </div>
                    <div class="wallet-body">
                        <div class="wallet-div" style="padding: 0px;">
                            <label class="label_title_2">Amount</label>
                            <input id="amount" class="form-group-control input-radius" type="number" placeholder="Enter Amount" name="amount" onchange="handlepackage_amount()">
                            <p id="alert" style="margin: 0px; text-align:left; color:red;"></p>
                        </div>
                        <div class="wallet-div" style="padding: 0px;">
                        </div>
                    </div>
                    <div class="text-center">
                        <button id="button" type="button" class="btn w-md" style="width: 100%; margin: 20px 0px" onclick="makeInvestForOther()" disabled>Submit</button>
                        <p id="invest_alert" style="margin: 0px; text-align:left; color:red;"></p>
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


    // function handleStatusCheck() {
    //     $userId = `{{$userId}}`;
    //     $otheruserid = $("#otheruserid").val();
    //     $userIdList = <?php echo json_encode($userIdList); ?>;
    //     $userNameList = <?php echo json_encode($userNameList); ?>;
    //     $invest_status_lists = <?php echo json_encode($invest_status_lists); ?>;
    //     $temp = $userIdList.indexOf($otheruserid);
    //     $amount = $("#amount").val();
    //     $package = $("#package").val();
    //     if ($package) {
    //         $from_amount = $package.split("to")[0] * 1;
    //         $to_amount = $package.split("to")[1] * 1;
    //         if ($userId != $otheruserid && $otheruserid && $temp >= 0 && $package && $amount >= $from_amount && $amount <= $to_amount) {
    //             document.getElementById('alert').innerHTML = '';
    //             if ($invest_status_lists[$temp] == false) {
    //                 $alert_txt = "This member is already have an investment running!";
    //                 document.getElementById('invest_alert').innerHTML = $alert_txt;
    //             } else {
    //                 document.getElementById("button").disabled = false;
    //                 document.getElementById('user_alert').innerHTML = '';
    //                 document.getElementById('invest_alert').innerHTML = '';
    //                 document.getElementById("button").classList.add("btn-info");
    //             }
    //         } else {
    //             document.getElementById("button").disabled = true;
    //             document.getElementById("button").classList.remove("btn-info");
    //         }
    //     }
    // }

    function handleotheruserid() {
        $userId = `{{$userId}}`;
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
        } else {
            if ($userId == $otheruserid) {
                $alert_txt = "You can't invest for yourself!";
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
    }

    function handlepackage_amount() {
        $package = $("#package").val();
        $amount = $("#amount").val();
        if ($package) {
            $from_amount = $package.split("to")[0] * 1;
            $to_amount = $package.split("to")[1] * 1;
            if ($amount >= $from_amount && $amount <= $to_amount) {
                handleStatusCheck();
                document.getElementById('alert').innerHTML = '';
            } else {
                $alert_txt = 'Amount should be in the range from ' + $("#package").val();
                document.getElementById('alert').innerHTML = $alert_txt;
                handleStatusCheck();
            };
        } else {
            $alert_txt = 'Please Select Package';
            document.getElementById('alert').innerHTML = $alert_txt;
        }
    }

    function makeInvestForOther() {
        $otheruserid = $("#otheruserid").val();
        $amount = $("#amount").val();
        $package = $("#package").val();
        $balance = `{{$data->cash_balance}}` * 1;
        if ($amount > $balance) {
            notify('danger', 'You have insufficient balance in Cash Wallet', 'top', 'right');
        } else {
            document.getElementById("button").disabled = true;
            document.getElementById("button").classList.remove("btn-info");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: "invest_others/post",
                data: {
                    otheruserid: $otheruserid,
                    amount: $amount,
                    package: $package,
                },
                success: function(data) {
                    if (data.status == 200) {
                        notify('success', 'Thanks for your Investment', 'top', 'right');
                        location = "/invest_others";
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