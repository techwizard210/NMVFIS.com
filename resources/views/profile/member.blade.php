@extends('layouts.app', ['activePage' => 'memberprofile', 'titlePage' => __('Member Profile')])

@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary card-header-icon">
          <div class="card-icon">
            <i class="material-icons">group</i>
          </div>
          <h4 class="card-title">Member List</h4>
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
                        <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" style="width: 50px;" aria-label="No: activate to sort column ascending">No</th>
                        <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Name</th>
                        <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="UserId: activate to sort column ascending">User Id</th>
                        <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="UserId: activate to sort column ascending">E-mail</th>
                        <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Password: activate to sort column ascending">Password</th>
                        <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">Phone</th>
                        <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Wallet Address: activate to sort column ascending">Wallet Address</th>
                        <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Investment Wallet: activate to sort column ascending">Investment Wallet</th>
                        <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Withdrawal Wallet: activate to sort column ascending">Withdrawal Wallet</th>
                        <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Rank: activate to sort column ascending">Rank</th>
                        <th class="sorting_desc" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" aria-label="Password: activate to sort column ascending" aria-sort="descending">Action</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th class="text-left" rowspan="1" colspan="1">No</th>
                        <th rowspan="1" colspan="1">Name</th>
                        <th rowspan="1" colspan="1">User Id</th>
                        <th rowspan="1" colspan="1">E-mail</th>
                        <th rowspan="1" colspan="1">Password</th>
                        <th rowspan="1" colspan="1">Phone</th>
                        <th rowspan="1" colspan="1">Wallet Address</th>
                        <th rowspan="1" colspan="1">Investment Wallet</th>
                        <th rowspan="1" colspan="1">Withdrawal Wallet</th>
                        <th rowspan="1" colspan="1">Rank</th>
                        <th rowspan="1" colspan="1">Action</th>
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
                        <td>{{$data->name}}</td>
                        <td>{{$data->userId}}</td>
                        <td>{{$data->email}}</td>
                        <td>{{$data->pwd}}</td>
                        <td>{{$data->phone}}</td>
                        <td>{{$data->wallet_address}}</td>
                        <td>{{$data->cash_balance}}</td>
                        <td>{{$data->income_amount}}</td>
                        <td><span class="badge badge-default" style="background-color:#00bcd4">{{$data->rank}}</span></td>
                        <td>
                          <button type="button" rel="tooltip" class="btn btn-success btn-link" data-original-title="View Info" data-toggle="modal" data-target="#{{$data->id}}" style="margin:0px; padding:0px;">
                            <i class="material-icons">person</i>
                            <div class="ripple-container"></div>
                          </button>

                          <button type="button" rel="tooltip" class="btn btn-danger btn-link" data-original-title="Delete User" data-toggle="modal" data-target="#delete{{$data->id}}" title="" style="margin:0px; padding:0px;">
                            <i class="material-icons">close</i>
                            <div class="ripple-container"></div>
                          </button>

                          <div class="modal fade modal-mini modal-primary" id="delete{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-small">
                              <div class="modal-content" style="width: 400px;">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                                </div>
                                <div class="modal-body" style="display: flex; justify-content: space-evenly; color: red;">
                                  <i class="material-icons">add_alert</i>
                                  <p>Are you sure to delete "{{$data->name}}" member?</p>
                                </div>
                                <div class="modal-footer justify-content-center">
                                  <button type="button" class="btn btn-link" data-dismiss="modal">Never mind</button>
                                  <button type="button" class="btn btn-success btn-link" onclick="deleteUser('{{$data->userId}}')">Yes
                                    <div class="ripple-container"></div>
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>

                        </td>
                        <div class="modal fade" id="{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content member_user_info_modal">
                              <div class="modal-header">
                                <div class="modal-title" style="display: flex; justify-content:center; align-items:center; font-size:25px;">
                                  <i class="material-icons" style="font-size: 40px; color:#05c1d4;">person</i>
                                  &nbsp;&nbsp;{{$data->name}}
                                </div>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                  <i class="material-icons">clear</i>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div>
                                  <ul class="col-md-12 mb-2" style="list-style-type:none; display:flex; border-bottom: 1px solid; padding: 0px; font-size: 15px; margin-bottom:5px;">
                                    <li class="col-md-4"><span style="font-weight: bold;">User Id :</span><span style="color: blue;">&nbsp;&nbsp;{{$data->userId}}</span></li>
                                    <li class="col-md-4"><span style="font-weight: bold;">E-mail :</span><span style="color: blue;">&nbsp;&nbsp;{{$data->email}}</span></li>
                                    <li class="col-md-4"><span style="font-weight: bold;">Rank :</span>&nbsp;&nbsp;<span class="badge badge-default" style="background-color:#00bcd4">{{$data->rank}}</span></li>
                                  </ul>
                                  <ul class="col-md-12 mb-2" style="list-style-type:none; display:flex; border-bottom: 1px solid; padding: 0px; font-size: 15px; margin-bottom:5px;">
                                    <li class="col-md-4"><span style="font-weight: bold;">Phone :</span><span style="color: blue;">&nbsp;&nbsp;{{$data->phone}}</span></li>
                                    <li class="col-md-8"><span style="font-weight: bold;">Wallet Address :</span><span style="color: blue;">&nbsp;&nbsp;{{$data->wallet_address}}</span></li>
                                  </ul>
                                  <ul class="col-md-12 mb-2" style="list-style-type:none; display:flex; border-bottom: 1px solid; padding: 0px; font-size: 15px; margin-bottom:5px;">
                                    <li class="col-md-4"><span style="font-weight: bold;">SponsorId : </span><span style="color: blue;">&nbsp;&nbsp;{{$data->sponsorId}}</span></li>
                                    <li class="col-md-4"><span style="font-weight: bold;">PlacementId :</span><span style="color: blue;">&nbsp;&nbsp;{{$data->placementId}}</span></li>
                                    <li class="col-md-4"><span style="font-weight: bold;">Position : </span><span style="color: blue;">&nbsp;&nbsp;{{$data->position}}</span></li>
                                  </ul>
                                  <ul class="col-md-12" style="list-style-type:none; display:flex; border-bottom: 1px solid; padding: 0px; font-size: 15px; margin-bottom:5px;">
                                    <li class="col-md-8">
                                      <span style="font-weight: bold;" type="password">Password :</span>&nbsp;&nbsp;
                                      @if($data->pwd)
                                      <input value="{{$data->pwd}}" type="text" style="color: blue; border:0px;">
                                      @else
                                      <input value="{{$data->password}}" type="password" style="color: blue; border:0px;">
                                      @endif
                                      <button type="button" rel="tooltip" class="btn btn-danger btn-link" data-original-title="PWD Initialize" title="" style="margin:0px; padding:0px;" onclick="initializePWD('{{$data->userId}}')">
                                        <i class="material-icons">close</i>
                                        <div class="ripple-container"></div>
                                      </button>
                                    </li>
                                    <li class="col-md-4"><span style="font-weight: bold;">RegisterDate : </span><span style="color: blue;">&nbsp;&nbsp;{{$data->created_at}}</span></li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
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

  <script>
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

    function initializePWD(userId) {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        type: 'POST',
        url: "memberprofile/initializePWD",
        data: {
          userId: userId,
        },
        success: function(data) {
          if (data.status == 200) {
            notify('success', "The selected user's PWD has been initialized !", 'top', 'right');
            location = '/memberprofile';
            location.reload();
          } else if (data.status == 400) {
            notify('success', data.error, 'top', 'right');
            return;
          }
        }
      });
    }

    function deleteUser(userId) {
      console.log('@@@', userId)
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        type: 'POST',
        url: "memberprofile/delete",
        data: {
          userId: userId,
        },
        success: function(data) {
          if (data.status == 200) {
            notify('success', 'The selected user has been deleted !', 'top', 'right');
            location = '/memberprofile';
            location.reload();
          } else if (data.status == 400) {
            notify('success', data.error, 'top', 'right');
            return;
          }
        }
      });
    }
  </script>

  @endsection