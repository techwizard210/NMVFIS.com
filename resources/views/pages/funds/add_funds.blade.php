<!-- @extends('layouts.app', ['activePage' => 'funds', 'titlePage' => __('Add Funds')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div id="paycard" class="card">
      <div class="card-header card-header-info">
        <h4 class="card-title">Pay Amount</h4>
      </div>
      <div class="card-body">
        <div>
          <div class="pay-div amount_input">
            <div class="mb-3 col-md-4 m-auto">
              <label class="input-group-text">Enter Amount In (USD)</label>
              <input id="amount" class="form-group-control input-radius" type="number" name="amount" min="1" step="1" onkeypress="" title="Numbers only" placeholder="" aria-required="true" aria-invalid="false">
            </div>
          </div>
          <div class="form-group mb-3 m-auto pay-div col-md-4">
            <label class="input-group-text">Payment Mode</label>
            <select id="paymentMode" class="form-select">
              <option disabled selected>Select Payment Method</option>
              @if($coins)
              @foreach($coins as $key => $coin)
              <?php echo '<option value=' . $coin['key'] . '>' . $coin['rate']['name'] . '</option>' ?>
              @endforeach
              @else
              @endif

              <option value="USDT.TRC20">Tether USD (Tron/TRC20)</option>
              <!-- <option value="BTC">Bitcoin</option>
              <option value="ETH">Ethereum</option>
              <option value="DOGE">Dogecoin</option>
              <option value="TRX">Tron</option>
              <option value="LTC">Litecoin</option>
              <option value="SHIB">SHIBA INU (ERC20)</option>
              <option value="SOL">Solana</option> -->
            </select>
          </div>
          <div class="text-center">
            <button id="handlePayment" type="button" class="btn btn-info w-md handlePayment" onclick="handlePayment()">Make Payment</button>
          </div>
        </div>
      </div>
    </div>

    <div id="payinfo" class="card card-nav-tabs text-center" style="display: none;">
      <div class="card-header card-header-primary" style="display:flex; justify-content: center; align-items: center;">
        Payment Information
        <i id="cancelIcon" class="material-icons" style="position: absolute; right: 10px; font-size: 30px; cursor: pointer; z-index: 1;">close</i>
      </div>
      <div id="payinfotable" class="card-body">
      </div>
    </div>
  </div>
</div>

<script>
  var payStatus = false;
  var payInfoData = [];

  $(document).on('click', '#cancelIcon', function(e) {
    payStatus = true;
    $("#paycard").show();
    $("#payinfo").hide();
    location = "/add_funds";
    location.reload();
  });

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

  function handlePayment() {
    $userRole = `{{$userData->role}}`;
    $payAmount = $("#amount").val();
    $paymentMode = $("#paymentMode").val();

    if ($payAmount > 0 && $paymentMode) {
      document.getElementById("handlePayment").disabled = true;
      document.getElementById("handlePayment").classList.remove("btn-info");

      if (payStatus === false) {
        payStatus = true;

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        if ($userRole == 'admin') {
          $.ajax({
            type: 'POST',
            url: 'add_funds/payment/admin',
            data: {
              payAmount: $("#amount").val(),
              paymentMode: $("#paymentMode").val()
            },
            success: function(data) {
              if (data.status == 200) {
                notify('success', 'Add Funds Successful !', 'top', 'right');
                location = "/add_funds";
                location.reload();
              } else if (data.status == 400) {
                console.log(data.error);
                return;
              }
            }
          });
        } else {
          $.ajax({
            type: 'POST',
            url: 'add_funds/payment',
            data: {
              payAmount: $("#amount").val(),
              paymentMode: $("#paymentMode").val()
            },
            success: function(data) {
              console.log('data', data)
              if (data.status == 200) {
                $('#payinfotable').append(data.xml);
                payInfoData = data;
                $("#paycard").css("display", "none")
                $("#payinfo").css("display", "block")
              } else if (data.status == 400) {
                console.log(data.error);
                return;
              }
            }
          });
        }
      } else {
        if ($userRole == 'user') {
          $("#paycard").css("display", "none")
          $("#payinfo").css("display", "block")
        }
      }
    } else {
      notify('warning', 'You should enter Amount and Payment Mode field !', 'top', 'right');
      return;
    }
  }
</script>

@endsection -->