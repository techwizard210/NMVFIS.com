@extends('layouts.app', ['activePage' => 'wallet_r', 'titlePage' => __('Cash Wallet to Other member Cash Wallet Report')])

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
            <h4 class="card-title">Investment Wallet to Other Member Investment Wallet</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
            </div>
            <div class="material-datatables">
              <div id="datatables_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                  <div class="col-sm-12">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                      <thead>
                        <tr role="row">
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" style="width: 70px;" aria-label="Sr: activate to sort column ascending">Sr. No</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="To User Id: activate to sort column ascending">To User Id</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Amount: activate to sort column ascending">Amount</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Wallet Type: activate to sort column ascending">Wallet Type</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Transaction Type: activate to sort column ascending">Transaction Type</th>
                          <th class="sorting_desc" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" aria-sort="descending">Date</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th class="text-left" rowspan="1" colspan="1">Sr. No</th>
                          <th rowspan="1" colspan="1">To User Id</th>
                          <th rowspan="1" colspan="1">Amount</th>
                          <th rowspan="1" colspan="1">Wallet Type</th>
                          <th rowspan="1" colspan="1">Transaction Type</th>
                          <th rowspan="1" colspan="1">Date</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        @if($reports)
                        @foreach($reports as $key => $report)
                        @if($key%2 == 0)
                        <tr role="row" class="odd">
                          @else
                        <tr role="row" class="even">
                          @endif
                          <td class="" tabindex="0">{{$key +1}}</td>
                          <td>{{$report['otherUserId']}}</td>
                          <td>{{$report['amount']}}</td>
                          <td></td>
                          <td></td>
                          <td><?php echo date_format(date_create($report['created_at']), 'Y-m-d') ?></td>
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