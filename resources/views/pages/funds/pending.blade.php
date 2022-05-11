@extends('layouts.app', ['activePage' => 'pending', 'titlePage' => __('Pending Transactions')])

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
            <h4 class="card-title">Pending Transactions</h4>
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
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" style="width: 70px;" aria-label="No: activate to sort column ascending">Sr. No</th>
                          <th class="sorting_desc" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="AmoDatent: activate to sort column ascending">Date</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Deposit Id: activate to sort column ascending">Deposit Id</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Package: activate to sort column ascending">Package</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Amount: activate to sort column ascending">Amount</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Address: activate to sort column ascending">Address</th>
                          <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Action</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th rowspan="1" colspan="1">Sr. No</th>
                          <th rowspan="1" colspan="1">Date</th>
                          <th rowspan="1" colspan="1">Deposit Id</th>
                          <th rowspan="1" colspan="1">Package</th>
                          <th rowspan="1" colspan="1">Amount</th>
                          <th rowspan="1" colspan="1">Address</th>
                          <th rowspan="1" colspan="1">Action</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        @if($data)
                        @foreach($data as $key => $temp)
                        @if($key%2 == 0)
                        <tr role="row" class="odd">
                          @else
                        <tr role="row" class="even">
                          @endif
                          <td>{{ $key+1 }}</td>
                          <td class="status-countdown">
                            @if($temp['TxInfo'])
                            <?php echo date_format(date_create($temp['TxInfo']['created_at']), "Y/m/d"); ?>
                            @else
                            @endif
                          </td>
                          <td>
                            @if($temp['TxInfo'])
                            {{ $temp['TxInfo']['depositId']}}
                            @else
                            @endif
                          </td>
                          <td><span></span></td>
                          <td>
                            @if($temp['TxInfo'])
                            <span>$ {{ $temp['TxInfo']['usd_amount']}}</span>
                            @else
                            @endif
                          </td>
                          <td>{{ $temp['TxInfoMulti']['payment_address'] }}</td>
                          <td>
                            @if($temp['TxInfo'])
                            <?php echo '<a href=' . $data[$key]['TxInfo']['checkout_url'] . ' target="_blank">Check </a>' ?>
                            @else
                            @endif
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