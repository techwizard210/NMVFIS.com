@extends('layouts.app', ['activePage' => 'profile', 'titlePage' => __('User Profile')])

@section('content')
<div class="content">
  <div class="row">
    <div class="col-xl-6">
      <div class="card">
        <div class="card-header card-header-icon card-header-rose">
          <div class="card-icon">
            <i class="material-icons">perm_identity</i>
          </div>
          <h4 class="card-title">Your Profile</h4>
        </div>
        <div class="card-body">
          <form method="post" action="{{route('fileUpload')}}" enctype="multipart/form-data" autocomplete="on" class="form-horizontal">
            @csrf
            <div class="row" id="profile">
              <div class="col-sm-7">
                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                  <div class="fileinput-new thumbnail img-circle">
                    @if($userData->imgUrl)
                    <img src="{{ asset('avatar') }}/{{$userData->imgUrl}}" alt="avatar">
                    @else
                    <img src="{{ asset('avatar') }}/default.png" alt="avatar">
                    @endif
                  </div>
                  <div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
                  <div>
                    <span class="btn btn-rose btn-file">
                      <span class="fileinput-new">Select image</span>
                      <span class="fileinput-exists">Other image</span>
                      <input type="file" name="file" id="input-picture custom-file-input">
                    </span>
                    <button class="btn btn-primary " type="submit" name="submit"> <i class="fa fa-save"></i>&nbsp;Save</button>
                  </div>
                </div>
              </div>

              <div class="col-sm-5">
                <div class="mb-2" style="display: flex; align-items:center; font-size: 15px;">
                  <i class="material-icons" style="font-size: 25px;">perm_identity</i> &nbsp;&nbsp; {{$userData->name}}
                </div>
                <div class="mb-2" style="display: flex; align-items:center;">
                  <i class="material-icons" style="font-size: 25px;">perm_identity</i>&nbsp;&nbsp;
                  <span class="badge badge-default" style="background-color:#00bcd4; font-size: 10px;">{{$userData->rank}}</span>
                </div>
                <div style="display: flex; align-items:center; font-size: 15px;">
                  <i class="material-icons" style="font-size: 25px;">email</i>&nbsp;&nbsp;{{$userData->email}}
                </div>
              </div>
            </div>
          </form>





          <ul class="nav nav-pills nav-pills-warning" role="tablist">
            <li class="nav-item">
              <a class="nav-link active show" data-toggle="tab" href="#link1" role="tablist">
                General
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#link2" role="tablist">
                Change Password
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#link3" role="tablist">
                Currency Address
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="tab-content tab-space">
        <div class="tab-pane active show" id="link1">
          <div class="card">
            <div class="card-header card-header-icon card-header-rose">
              <div class="card-icon">
                <i class="material-icons">perm_identity</i>
              </div>
              <h4 class="card-title">About</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 col-sm-6">
                  <div class="mb-1">
                    <label class="input-group-text wallet-label">User Id</label>
                    <input id="userId" class="input-style" type="text" value='{{$userData->userId}}' name="userid" style="width: 100%;" disabled>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="mb-1">
                    <label class="input-group-text wallet-label">Name</label>
                    <input id="name" class="input-style" type="text" value='{{$userData->name}}' name="userid" style="width: 100%;">
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="mb-1">
                    <label class="input-group-text wallet-label">E-mail</label>
                    <input id="email" class="input-style" type="text" value='{{$userData->email}}' name="userid" style="width: 100%;">
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="mb-1">
                    <label class="input-group-text wallet-label">Mobile Number</label>
                    <input id="phone" class="input-style" type="text" value='{{$userData->phone}}' name="userid" style="width: 100%;">
                  </div>
                </div>
                <div class="col-12">
                  <button type="change_info_button" class="btn btn-primary mt-2 me-1 waves-effect waves-float waves-light" onclick="changeUserInfo()">Save changes</button>
                  <button type="reset" class="btn btn-outline-secondary mt-2 waves-effect" onclick="changeUserInfo_Cancel()">Cancel</button>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="tab-pane" id="link2">
          <div class="card">
            <div class="card-header card-header-icon card-header-rose">
              <div class="card-icon">
                <i class="material-icons">perm_identity</i>
              </div>
              <h4 class="card-title">Change Password</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 col-sm-6">
                  <div class="mb-1">
                    <label class="input-group-text wallet-label">Old Password</label>
                    <input id="old_pass" class="input-style" type="text" value='' name="old_pass" style="width: 100%;">
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="mb-1">
                    <label class="input-group-text wallet-label">New Password</label>
                    <input id="new_pass" class="input-style" type="text" value='' name="new_pass" style="width: 100%;">
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="mb-1">
                    <label class="input-group-text wallet-label">Retype New Password</label>
                    <input id="retype_pass" class="input-style" type="text" value='' name="retype_pass" style="width: 100%;">
                  </div>
                </div>
                <div class="col-12">
                  <button id="change_pwd_button" type="button" class="btn btn-primary mt-2 me-1 waves-effect waves-float waves-light" onclick="handlePwd()">Save changes</button>
                  <button type="reset" class="btn btn-outline-secondary mt-2 waves-effect" onclick="handlePwd_Cancel()">Cancel</button>
                </div>
              </div>
            </div>
          </div>
        </div>





        <div class="tab-pane" id="link3">
          <div class="card">
            <div class="card-header card-header-icon card-header-rose">
              <div class="card-icon">
                <i class="material-icons">perm_identity</i>
              </div>
              <h4 class="card-title">Currency Address</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 col-sm-6">
                  <div class="mb-1">
                    <label class="input-group-text wallet-label">USDT TRON20 Address</label>
                    <input id="wallet_address" class="input-style" type="text" value='' name="wallet_address" style="width: 100%;">
                  </div>
                </div>
                <div class="col-12">
                  <button id="change_wallet_button" type="button" class="btn btn-primary mt-2 me-1 waves-effect waves-float waves-light" onclick="handleWalletAddress()">Save changes</button>
                  <button id="change_wallet_cancel" type="reset" class="btn btn-outline-secondary mt-2 waves-effect" onclick="handleWallet_Cancel()">Cancel</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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

    function changeUserInfo() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        type: 'POST',
        url: "profile/changeUserInfo",
        data: {
          name: $("#name").val(),
          email: $("#email").val(),
          phone: $("#phone").val()
        },
        success: function(data) {
          if (data.status == 200) {
            notify('success', 'Your Info has been changed!', 'top', 'right');
            return;
          } else if (data.status == 400) {
            notify('success', data.error, 'top', 'right');
            return;
          }
        }
      });
    }

    function changeUserInfo_Cancel() {
      $name = `{{$userData->name}}`;
      $email = `{{$userData->email}}`;
      $phone = `{{$userData->phone}}`;
      document.getElementById('name').value = $name;
      document.getElementById('email').value = $email;
      document.getElementById('phone').value = $phone;
    }

    function handlePwd() {
      $new_pass = $("#new_pass").val();
      $retype_pass = $("#retype_pass").val();
      if ($new_pass == $retype_pass) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          type: 'POST',
          url: "profile/changePwd",
          data: {
            new_pass: $("#new_pass").val(),
            old_pass: $("#old_pass").val(),
          },
          success: function(data) {
            if (data.status == 200) {
              notify('success', 'Your Password has been changed!', 'top', 'right');
              return;
            } else if (data.status == 401) {
              notify('warning', 'Your old password is not correct!', 'top', 'right');
              return;
            } else if (data.status == 404) {
              notify('danger', data.error, 'top', 'right');
              return;
            }
          }
        });
      } else {
        notify('warning', 'Confirm retype password!', 'top', 'right');
        return;
      }
    }

    function handlePwd_Cancel() {
      document.getElementById('old_pass').value = '';
      document.getElementById('new_pass').value = '';
      document.getElementById('retype_pass').value = '';
    }

    function handleWalletAddress() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        type: 'POST',
        url: "profile/changeWalletAddress",
        data: {
          wallet_address: $("#wallet_address").val(),
        },
        success: function(data) {
          if (data.status == 200) {
            notify('success', 'Your Currency_address has been changed!', 'top', 'right');
            return;
          } else if (data.status == 400) {
            notify('success', data.error, 'top', 'right');
            return;
          }
        }
      });
    }

    function handleWallet_Cancel() {
      document.getElementById('wallet_address').value = '';
    }
  </script>
  @endsection