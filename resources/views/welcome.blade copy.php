@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'dashboard', 'title' => __('Material Dashboard')])

@section('content')
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top text-white">
  <div class="container">
    <div class="navbar-wrapper">
      <a class="navbar-brand" href="{{ route('dashboard') }}"><h3 style="margin: 0px">N M V F I S</h3></a>
    </div>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="{{ route('register') }}" class="nav-link">
            <i class="material-icons">person_add</i> {{ __('Register') }}
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('login') }}" class="nav-link">
            <i class="material-icons">fingerprint</i> {{ __('Login') }}
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="wrapper wrapper-full-page">
  <div class="page-header login-page header-filter" filter-color="black" style="background-image: url('{{ asset('material') }}/img/cover.jpg'); background-size: cover; background-position: top center; padding: 0px!important" data-color="purple">
    <div class="container" style="height: auto;">
      <div class="row justify-content-center">
          <div class="col-lg-7 col-md-8">
              <h1 class="text-white text-center">{{ __('Welcome To Our Website') }}</h1>
              
          </div>
      </div>
    </div>
</div>
</div>
@endsection
