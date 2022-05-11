@extends('layouts.app', ['activePage' => 'inv_r', 'titlePage' => __('Investment Report')])

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
            <h4 class="card-title">Investment Report</h4>
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
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Deposit Id: activate to sort column ascending">Deposit Id</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Amount: activate to sort column ascending">Amount</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Topup: activate to sort column ascending">Topup By</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Daily ROI: activate to sort column ascending">Daily ROI Amount</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Start Date: activate to sort column ascending">Start Date of Investment</th>
                          <th class="sorting_desc" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="End Date: activate to sort column ascending" aria-sort="descending">End Date of Investment</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th class="text-right" rowspan="1" colspan="1">Sr. No</th>
                          <th rowspan="1" colspan="1">Deposit Id</th>
                          <th rowspan="1" colspan="1">Amount</th>
                          <th rowspan="1" colspan="1">Topup By</th>
                          <th rowspan="1" colspan="1">Daily ROI Amount</th>
                          <th rowspan="1" colspan="1">Start Date of Investment</th>
                          <th rowspan="1" colspan="1">End Date of Investment</th>
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
                          <td>{{$report['depositId']}}</td>
                          <td>{{$report['amount']}}</td>
                          <td>{{$report['name']}}</td>
                          <td>{{$report['total_roi']}}</td>
                          <td>{{$report['created_at']}}</td>
                          @if($report['invest_status'] == 0)
                          <td class="sorting_1"><span class="badge badge-default" style="background-color:#00bcd4">Present</span></td>
                          @else
                          <td class="sorting_1">{{$report['updated_at']}}</td>
                          @endif
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