<div class="material-datatables">
    <div id="datatables_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <div class="row">
            <div id="table" class="col-sm-12">
                <table id="datatables" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                    <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" style="width: 70px;" aria-label="No: activate to sort column ascending">No</th>
                            <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Name</th>
                            <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Request Amount: activate to sort column ascending">Request Amount</th>
                            <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Amount: activate to sort column ascending">Amount</th>
                            <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Fee: activate to sort column ascending">Fee</th>
                            <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Address: activate to sort column ascending">Address</th>
                            <th class="sorting_desc" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" aria-sort="descending">Date</th>
                            <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" style="width: 30%;" aria-label="Status: activate to sort column ascending">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th rowspan="1" colspan="1">No</th>
                            <th rowspan="1" colspan="1">Name</th>
                            <th rowspan="1" colspan="1">Request Amount</th>
                            <th rowspan="1" colspan="1">Amount</th>
                            <th rowspan="1" colspan="1">Fee</th>
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
                            <td>{{$withdrawal['input_amount']}}</td>
                            <td>{{$withdrawal['withdrawal_amount']}}</td>
                            <td>{{$withdrawal['input_amount']-$withdrawal['withdrawal_amount']}}</td>
                            <td>{{$withdrawal['target_w_address']}}</td>
                            <td>{{$withdrawal['created_at']}}</td>
                            @if($withdrawal['status'] == 0 )
                            <td>
                                <div style="display: flex; justify-content: space-evenly; width: 100%;">
                                    <button id="confirm_button" type="button" class="btn btn-info w-md handlePayment" value="{{$withdrawal['id']}}" onclick="confirm({{$withdrawal['id']}})">Confirm</button>
                                    <button id="cancel_button" type="button" class="btn btn-danger w-md handlePayment" value="{{$withdrawal['id']}}" onclick="cancel({{$withdrawal['id']}})">Cancel</button>
                                </div>
                            </td>
                            @else
                            @if($withdrawal['status'] == 1)
                            <td><span class="badge badge-default" style="background-color:#00bcd4">Confirmed</span></td>
                            @else
                            <td><span class="badge badge-default" style="background-color:#f44336">Expired</span></td>
                            @endif
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