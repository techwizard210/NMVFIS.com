@extends('layouts.app', ['activePage' => 'downline', 'titlePage' => __('Downline Investment')])

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
            <h4 class="card-title">Downline Investment</h4>
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
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" style="width: 70px;" aria-label="No: activate to sort column ascending"> No</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="User Id: activate to sort column ascending">User Id</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Deposit Id: activate to sort column ascending">Deposit Id</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Amount: activate to sort column ascending">Amount</th>
                          <!-- <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Topup by: activate to sort column ascending">Topup by</th> -->
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Daily ROI Amount: activate to sort column ascending">Daily ROI Amount</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="startDate: activate to sort column ascending">Start Date Of Investment</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="endDate Date: activate to sort column ascending">End Date of Investment</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th rowspan="1" colspan="1">No</th>
                          <th rowspan="1" colspan="1">User Id</th>
                          <th rowspan="1" colspan="1">Deposit Id</th>
                          <th rowspan="1" colspan="1">Amount</th>
                          <!-- <th rowspan="1" colspan="1">Topup by</th> -->
                          <th rowspan="1" colspan="1">Daily ROI Amount</th>
                          <th rowspan="1" colspan="1">Start Date of Investment</th>
                          <th rowspan="1" colspan="1">End Date of Investment</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        @if($datas)
                        @foreach($datas as $key => $data)
                        @if($key%2 == 0)
                        <tr role="row" class="odd">
                          @else
                        <tr role="row" class="even">
                          @endif
                          <td class="" tabindex="0">{{$key +1}}</td>
                          <td>{{$data->userId}}</td>
                          <td>{{$data->depositId}}</td>
                          <td>{{$data->amount}}</td>
                          <!-- <td></td> -->
                          <td>{{$data->total_roi}}</td>
                          <td>{{$data->created_at}}</td>
                          @if($data->invest_status == 1)
                          <td>{{$data->updated_at}}</td>
                          @else
                          <td>-</td>
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