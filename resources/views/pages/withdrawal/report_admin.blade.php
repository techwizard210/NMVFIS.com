@extends('layouts.app', ['activePage' => 'report', 'titlePage' => __('Withdrawal Report')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon" style="display: flex; align-items:center;">
              <i class="material-icons" onclick="handleChangeDate()" style="cursor: pointer;">today</i>
              <div class="form-group bmd-form-group is-filled">
                <input id="calendar" type="text" class="form-control datepicker" value="<?php echo date("d/m/Y"); ?>" style="width: 100px; color: white;">
              </div>
            </div>
            <h4 class="card-title">Withdrawal Report</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
            @include('pages.withdrawal.report_admin_table');
            <!-- <div class="material-datatables">
              <div id="datatables_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                  <div id="table" class="col-sm-12">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                      <thead>
                        <tr role="row">
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" style="width: 70px;" aria-label="No: activate to sort column ascending">No</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Name</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Amount: activate to sort column ascending">Amount</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Address: activate to sort column ascending">Address</th>
                          <th class="sorting_desc" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" aria-sort="descending">Date</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" style="width: 30%;" aria-label="Status: activate to sort column ascending">Action</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th rowspan="1" colspan="1">No</th>
                          <th rowspan="1" colspan="1">Name</th>
                          <th rowspan="1" colspan="1">Amount</th>
                          <th rowspan="1" colspan="1">Address</th>
                          <th rowspan="1" colspan="1">Date</th>
                          <th rowspan="1" colspan="1">Action</th>
                        </tr>
                      </tfoot>
                      <tbody id="tbody">
                        @if($withdrawal_datas)
                        @foreach($withdrawal_datas as $key => $withdrawal)
                        @if($key%2 == 0)
                        <tr role="row" class="odd">
                          @else
                        <tr role="row" class="even">
                          @endif
                          <td class="" tabindex="0">{{$key +1}}</td>
                          <td>{{$withdrawal['name']}}</td>
                          <td>{{$withdrawal['withdrawal_amount']}}</td>
                          <td>{{$withdrawal['wallet_address']}}</td>
                          <td>{{$withdrawal['created_at']}}</td>
                          <td>
                            <div style="display: flex; justify-content: space-evenly; width: 100%;">
                              <button id="confirm_button" type="button" class="btn btn-info w-md handlePayment" value="{{$withdrawal['userId']}}" onclick="confirm()">Confirm</button>
                              <button id="cancel_button" type="button" class="btn btn-danger w-md handlePayment" value="{{$withdrawal['userId']}}" onclick="cancel()">Cancel</button>
                            </div>
                          </td>
                        </tr>
                        @endforeach
                        @else
                        @endif
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div> -->
          </div>
          <!-- end content-->
        </div>
        <!--  end card  -->
      </div>
      <!-- end col-md-12 -->
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    // initialise Datetimepicker and Sliders
    md.initFormExtendedDatetimepickers();
    if ($('.slider').length != 0) {
      md.initSliders();
    }
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

  function handleChangeDate() {
    $date = $("#calendar").val();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      type: 'POST',
      url: "withdrawal_report_admin/date",
      data: {
        date: $date,
      },
      success: function(data) {
        if (data.status == 200) {
          $('div.card-body').fadeOut();
          $('div.card-body').load('withdrawal_report_admin/table/' + data.today, function() {
            $('div.card-body').fadeIn();
          });
        } else if (data.status == 400) {
          console.log('danger', data.error, 'top', 'right');
          return;
        }
      }
    });


  }

  function confirm($id) {
    $date = $("#calendar").val();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      type: 'POST',
      url: "withdrawal_report_admin/confirm",
      data: {
        date: $date,
        id: $id,
      },
      success: function(data) {
        if (data.status == 200) {
          notify('success', 'Confirmed!', 'top', 'right');
          location = 'withdrawal_report_admin/table/' + data.date;
          location.reload();
        } else if (data.status == 400) {
          console.log('danger', data.error, 'top', 'right');
          return;
        }
      }
    });
  }

  function cancel($id) {
    $date = $("#calendar").val();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      type: 'POST',
      url: "withdrawal_report_admin/cancel",
      data: {
        date: $date,
        id: $id,
      },
      success: function(data) {
        if (data.status == 200) {
          notify('warning', 'Canceled!', 'top', 'right');
          location = 'withdrawal_report_admin/table/' + data.date;
          location.reload();
        } else if (data.status == 400) {
          console.log('danger', data.error, 'top', 'right');
          return;
        }
      }
    });
  }
</script>
@endsection