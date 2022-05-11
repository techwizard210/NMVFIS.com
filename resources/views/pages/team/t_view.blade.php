@extends('layouts.app', ['activePage' => 'tview', 'titlePage' => __('Team View')])

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
            <h4 class="card-title">Team View</h4>
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
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Name</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Sponsor Id: activate to sort column ascending">Sponsor Id</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Placement Id: activate to sort column ascending">Placement Id</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending">Position</th>
                          <!-- <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Amount: activate to sort column ascending">Amount</th> -->
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Registration Date: activate to sort column ascending">Registration Date</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th rowspan="1" colspan="1">Sr. No</th>
                          <th rowspan="1" colspan="1">User Id</th>
                          <th rowspan="1" colspan="1">Name</th>
                          <th rowspan="1" colspan="1">Sponsor Id</th>
                          <th rowspan="1" colspan="1">Placement Id</th>
                          <th rowspan="1" colspan="1">Position</th>
                          <!-- <th rowspan="1" colspan="1">Amount</th> -->
                          <th rowspan="1" colspan="1">Registration Date</th>
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
                          <td>{{$data['name']}}</td>
                          <td>{{$data['sponsorId']}}</td>
                          <td>{{$data['placementId']}}</td>
                          <td>{{$data['position']}}</td>
                          <td><?php echo date_format(date_create($data['created_at']), 'Y-m-d') ?></td>
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