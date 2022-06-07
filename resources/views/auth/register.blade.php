@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'register', 'title' => __('NMVFIS')])

@section('content')

<div class="row auth-height">
  <div class="col-lg-5 col-md-6 col-sm-8" style="padding: 0px!important;">
    <form class="form" method="POST" action="{{ route('register') }}" onsubmit="return submit_check()">
      @csrf
      <div class="card card-login card-hidden mb-3" style=" margin: 0px!important">
        <div class="card-header text-center">
          <img src="{{ asset('material') }}/img/logo.png" alt="" height="150">
        </div>
        <div style="width: 70%; margin: 0px auto 10px; border-bottom: 1px solid #5156be9e"></div>
        <div class="card-body" style="padding: 10px 40px!important">
          <div style="text-align: center;">
            <h4><strong>Register Account</strong></h4>
          </div>
          <div class="row">
            <div class="bmd-form-group{{ $errors->has('userId') ? ' has-danger' : '' }} m-b-15 col-md-6 i-p-10">
              <div class="">
                <label class="wallet-label">User Id</label>
                <input class="form-group-control input-radius" type="text" name="userId" placeholder={{$userId}} value={{$userId}} style="background-color: #e9e9ef" readonly>
              </div>
              @if ($errors->has('userId'))
              <div id="userId-error" class="error text-danger pl-3" for="userId" style="display: block;">
                <strong>{{ $errors->first('userId') }}</strong>
              </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('name') ? ' has-danger' : '' }} m-b-15  col-md-6 i-p-10">
              <div class="">
                <label class="wallet-label">Full Name</label>
                <input class="form-group-control input-radius" type="text" name="name" placeholder="{{ __('Full Name') }}" value="{{ old('name') }}" required>
              </div>
              @if ($errors->has('name'))
              <div id="name-error" class="error text-danger pl-3" for="name" style="display: block;">
                <strong>{{ $errors->first('name') }}</strong>
              </div>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="bmd-form-group{{ $errors->has('phone') ? ' has-danger' : '' }} m-b-15 col-md-6 i-p-10">
              <div class="">
                <label class="wallet-label">Mobile Number</label>
                <input class="form-group-control input-radius" type="tel" id="phone" name="phone" placeholder="{{ __('Mobile Number') }}" value="{{ old('phone') }}">
              </div>
              @if ($errors->has('phone'))
              <div id="phone-error" class="error text-danger pl-3" for="phone" style="display: block;">
                <strong>{{ $errors->first('phone') }}</strong>
              </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }} m-b-15  col-md-6 i-p-10">
              <div class="">
                <label class="wallet-label">Email</label>
                <input class="form-group-control input-radius" type="email" name="email" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required>
              </div>
              @if ($errors->has('email'))
              <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                <strong>{{ $errors->first('email') }}</strong>
              </div>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="bmd-form-group{{ $errors->has('sponsorId') ? ' has-danger' : '' }} m-b-15  col-md-6 i-p-10">
              <div class="">
                <label class="wallet-label">Sponsor's Id</label>
                @if ($referralStatus == true)
                <input id="sponsorId" class="form-group-control input-radius" type="text" name="sponsorId" placeholder={{$sponsorId}} value={{$sponsorId}} style="background-color: #e9e9ef" readonly>
                @else
                <input id="sponsorId" class="form-group-control input-radius" type="text" name="sponsorId" placeholder="{{ __('Sponsor`s Id') }}" value="{{ old('sponsorId') }}">
                @endif
              </div>
              @if ($errors->has('sponsorId'))
              <div id="sponsorId-error" class="error text-danger pl-3" for="name" style="display: block;">
                <strong>{{ $errors->first('sponsorId') }}</strong>
              </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('position') ? ' has-danger' : '' }} m-b-15 col-md-6 i-p-10">
              <div class="">
                <label class="wallet-label">Position</label>
                @if ($referralStatus == true)
                <input id="position" class="form-group-control input-radius" type="text" name="position" placeholder={{$position}} value={{$position}} style="background-color: #e9e9ef" readonly>
                @else
                <select id="position" class="form-select" name="position">
                  <option value="none" selected>None</option>
                  <option value="Left">Left</option>
                  <option value="Right">Right</option>
                </select>
                @endif
              </div>
              @if ($errors->has('position'))
              <div id="position-error" class="error text-danger pl-3" for="position" style="display: block;">
                <strong>{{ $errors->first('position') }}</strong>
              </div>
              @endif
            </div>
          </div>

          <div class="row">
            <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} m-b-15 col-md-6 i-p-10">
              <div class="">
                <label class="wallet-label">Password</label>
                <div style="display: flex">
                  <input id="password" class="form-group-control input-radius" type="password" name="password" id="password" placeholder="{{ __('Enter Password') }}">
                  <label class="input-group-text"><i class="fa fa-eye-slash" id="pwd-show" style="margin-left: -30px; cursor: pointer;"></i></label>
                </div>
              </div>
              @if ($errors->has('password'))
              <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                <strong>{{ $errors->first('password') }}</strong>
              </div>
              @endif
            </div>

            <div class="bmd-form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }} m-b-15 col-md-6 i-p-10">
              <div class="">
                <label class="wallet-label">Confirm Password</label>
                <div style="display: flex">
                  <input id="password_confirmation" class="form-group-control input-radius" type="password" name="password_confirmation" id="password_confirmation" placeholder="{{ __('Enter Password') }}" required>
                  <label class="input-group-text"><i class="fa fa-eye-slash" id="pwd-c-show" style="margin-left: -30px; cursor: pointer;"></i></label>
                </div>
              </div>
              @if ($errors->has('password_confirmation'))
              <div id="password_confirmation-error" class="error text-danger pl-3" for="password_confirmation" style="display: block;">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
              </div>
              @endif
            </div>
          </div>

          <div class="row">
            <div class="bmd-form-group{{ $errors->has('wallet_address') ? ' has-danger' : '' }} m-b-15  col-md-12 i-p-10">
              <div class="">
                <label class="wallet-label">Wallet_Address</label>
                <input class="form-group-control input-radius" type="text" name="wallet_address" placeholder="{{ __('Wallet_Address') }}" value="{{ old('wallet_address') }}" required>
              </div>
              @if ($errors->has('wallet_address'))
              <div id="wallet_address-error" class="error text-danger pl-3" for="name" style="display: block;">
                <strong>{{ $errors->first('wallet_address') }}</strong>
              </div>
              @endif
            </div>
          </div>
          <div class="form-check mr-auto mt-3" style="margin: 0px">
            <label class="form-check-label">
              <input class="form-check-input" type="checkbox" id="policy" name="policy" {{ old('policy', 1) ? 'checked' : '' }}>
              <span class="form-check-sign">
                <span class="check"></span>
              </span>
              {{ __('I agree with the NMVFIS') }} <a href="#">{{ __('Terms of Use') }}</a>
            </label>
          </div>
          <div class="justify-content-center" style="margin: 5px 0px 5px 0px">
            @if ($referralStatus == true)
            <button type="submit" class="btn" style="width: 100%; font-size: 14px; background-color: #5156be">{{ __('Create account') }}</button>
            @else
            <button class="btn" style="width: 100%; font-size: 14px; background-color: #5156be" disabled>{{ __('Create account') }}</button>
            @endif
          </div>
        </div>
        <div style="text-align: center;">
          <p class="card-description text-center">Already have an account ?
            <strong><a href="{{ route('login') }}">{{ __('Login') }}</a></strong>
          </p>
        </div>
      </div>
    </form>
  </div>
  <div class="col-lg-7 col-md-6 col-sm-4 page-header login-page  header-filter" filter-color="black" style="background-image: url('{{ asset('material') }}/img/background.jpg'); background-size: cover; background-position: top center; padding: 0px!important" data-color="purple">
  </div>
</div>

<script>
  var url = window.location.href;
  console.log('url', url)

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

  function submit_check() {
    $password = $("#password").val();
    $password_confirmation = $("#password_confirmation").val();
    if ($password == $password_confirmation) {
      return true; // submit the form
    } else {
      notify("danger", "Password_Confirmation field should be same with Password field !", "top", "right");
      return false; // don't submit the form
    }
  }
</script>
@endsection