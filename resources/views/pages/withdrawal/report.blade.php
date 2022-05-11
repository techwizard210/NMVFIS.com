@extends('layouts.app', ['activePage' => 'report', 'titlePage' => __('Withdrawal Report')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">Withdrawal Report</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
            <div class="material-datatables">
              <div id="datatables_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                  <div class="col-sm-12">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                      <thead>
                        <tr role="row">
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" style="width: 70px;" aria-label="No: activate to sort column ascending">Sr. No</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Request Amount: activate to sort column ascending">Request Amount</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Received Amount: activate to sort column ascending">Received Amount</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Fee: activate to sort column ascending">Fee</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Address: activate to sort column ascending">Address</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">Status</th>
                          <th class="sorting_desc" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" aria-sort="descending">Date</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th rowspan="1" colspan="1">Sr. No</th>
                          <th rowspan="1" colspan="1">Request Amount</th>
                          <th rowspan="1" colspan="1">Received Amount</th>
                          <th rowspan="1" colspan="1">Fee</th>
                          <th rowspan="1" colspan="1">Address</th>
                          <th rowspan="1" colspan="1">Status</th>
                          <th rowspan="1" colspan="1">Date</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        @if($withdrawal_datas)
                        @foreach($withdrawal_datas as $key => $withdrawal)
                        @if($key%2 == 0)
                        <tr role="row" class="odd">
                          @else
                        <tr role="row" class="even">
                          @endif
                          <td class="" tabindex="0">{{$key +1}}</td>
                          <td>{{$withdrawal['input_amount']}}</td>
                          <td>{{$withdrawal['withdrawal_amount']}}</td>
                          <td>{{$withdrawal['input_amount']-$withdrawal['withdrawal_amount']}}</td>
                          <td>{{$withdrawal['target_w_address']}}</td>
                          @if($withdrawal['status'] == 0)
                          <td><span class="badge badge-default" style="background-color:#03d400">Pending</span></td>
                          @elseif($withdrawal['status'] == 1)
                          <td><span class="badge badge-default" style="background-color:#00bcd4">Confirmed</span></td>
                          @else
                          <td><span class="badge badge-default" style="background-color:#f44336">Expired</span></td>
                          @endif
                          <td>{{$withdrawal['created_at']}}</td>
                        </tr>
                        @endforeach
                        @else
                        @endif
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end content-->
        </div>
        <!--  end card  -->
      </div>
      <!-- end col-md-12 -->
    </div>
  </div>
</div>
@endsection