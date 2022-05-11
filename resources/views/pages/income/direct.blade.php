@extends('layouts.app', ['activePage' => 'direct', 'titlePage' => __('Direct Income')])

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
            <h4 class="card-title">Direct Income</h4>
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
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="User Id: activate to sort column ascending">User Id</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending">Date</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Amount: activate to sort column ascending">Amount</th>
                          <!-- <th class="sorting_desc" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" aria-sort="descending">Status</th> -->
                          <!-- <th class="disabled-sorting text-right sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" style="width: 227px;" aria-label="Actions: activate to sort column ascending">Actions</th> -->
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th rowspan="1" colspan="1">Sr. No</th>
                          <th rowspan="1" colspan="1">User Id</th>
                          <th rowspan="1" colspan="1">Date</th>
                          <th rowspan="1" colspan="1">Amount</th>
                          <!-- <th rowspan="1" colspan="1">Status</th> -->
                          <!-- <th class="text-right" rowspan="1" colspan="1">Actions</th> -->
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
                          <td>{{$data['userId']}}</td>
                          <td><?php echo date_format(date_create($data['created_at']), 'Y-m-d') ?></td>
                          <td>{{$data['amount']}}</td>
                        
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