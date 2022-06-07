@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'login', 'title' => __('NMVFIS')])

@section('content')

<div class="row auth-height">
  <div class="col-xxl-4 col-lg-4 col-md-5" style="padding: 0px!important;">
    <form class="form" method="POST" action="{{ route('login') }}">
      @csrf
      <div class="card card-login card-hidden mb-3" style="height: 100%!important; margin: 0px!important">
        <div class="card-header text-center">
          <img src="{{ asset('material') }}/img/logo.png" alt="" height="150">
          <!-- <h2 class="card-title"><strong><a href="/" style="color: #5156be">{{ __('NMVFIS') }}</a></strong></h2> -->
        </div>
        <div style="width: 70%; margin: 0px auto 10px; border-bottom: 1px solid #5156be9e"></div>
        <div class="card-body" style="padding: 20px 60px!important">
          <div style="text-align: center; margin-bottom: 30px">
            <h4><strong>Welcome Back!</strong></h4>
            <p class="card-description text-center">Sign in to continue to NMVFIS.</p>
          </div>
          <div class="bmd-form-group{{ $errors->has('userId') ? ' has-danger' : '' }}">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" style="padding: 0px 15px 0px 0px">
                  <i class="material-icons">person</i>
                </span>
              </div>
              <input type="userId" name="userId" class="form-control" placeholder="{{ __('UserId...') }}" value="" required>
            </div>
            @if ($errors->has('userId'))
            <div id="userId-error" class="error text-danger pl-3" for="userId" style="display: block;">
              <strong>{{ $errors->first('userId') }}</strong>
            </div>
            @endif
          </div>
          <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} " style="margin-top: 30px">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" style="padding: 0px 15px 0px 0px">
                  <i class="material-icons">lock_outline</i>
                </span>
              </div>
              <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password...') }}" value="" required>
            </div>
            @if ($errors->has('password'))
            <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
              <strong>{{ $errors->first('password') }}</strong>
            </div>
            @endif
          </div>
          <div class="justify-content-center" style="margin: 35px 0px 5px 0px">
            <button type="submit" class="btn" style="width: 100%; font-size: 14px; background-color: #5156be">{{ __('Log In') }}</button>
          </div>
          <div style="text-align: right; margin-right: 20px; margin-bottom: 20px">
            <p class="card-description" style="text-align: right">
              <strong><a href="{{ route('register') }}" style="color: grey!important">{{ __('Forgot password ?') }}</a></strong>
            </p>
          </div>
          <div style="text-align: center; margin-bottom: 30px">
            <p class="card-description text-center">Don't have an account ?
              <strong><a href="{{ route('register') }}">{{ __('Signup now') }}</a></strong>
            </p>
          </div>

        </div>
        <div style="text-align: center; margin-bottom: 30px">
          <p>~ NMVFIS . Crafted with <i class="material-icons" style="font-size: 14px; color: #fd625e">favorite</i> by NMVFIS ~</p>
        </div>
      </div>
    </form>
  </div>
  <div class="page-header login-page  header-filter col-xxl-8 col-lg-8 col-md-7" filter-color="black" style="height: 100%; background-image: url('{{ asset('material') }}/img/background.jpg'); background-size: cover; background-position: top center; padding: 0px!important" data-color="purple">
  </div>
</div>
@endsection