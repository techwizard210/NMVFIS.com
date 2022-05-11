@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
<div class="content">
  <div id="container-fluid" class="container-fluid">
    <div class="row">
      <div class="col-md-3 mb-3" style="min-height: 100%;">
        <div class="card card-chart" style="height: 100%;">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-12">
                <span class="text-muted mb-3 lh-1 d-block text-truncate">ROI Income</span>
                @if($Total_ROI)
                <h4 class="mb-3">${{ number_format($Total_ROI,0) }}</h4>
                @else
                <h4 class="mb-3">$ 0</h4>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3" style="min-height: 100%;">
        <div class="card card-chart" style="height: 100%;">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-12">
                <span class="text-muted mb-3 lh-1 d-block text-truncate">Direct Income</span>
                @if($Total_Direct)
                <h4 class="mb-3">${{ number_format($Total_Direct,0) }}</h4>
                @else
                <h4 class="mb-3">$ 0</h4>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3" style="min-height: 100%;">
        <div class="card card-chart" style="height: 100%;">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-12">
                <span class="text-muted mb-3 lh-1 d-block text-truncate">Binary Income</span>
                @if($Total_Binary)
                <h4 class="mb-3">${{ number_format($Total_Binary,0) }}</h4>
                @else
                <h4 class="mb-3">$ 0</h4>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3" style="min-height: 100%;">
        <div class="card card-chart" style="height: 100%;">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-12">
                <span class="text-muted mb-3 lh-1 d-block text-truncate">Binary Left Points</span>
                @if($BinarySide_info)
                <h4 class="mb-3">${{ number_format($BinarySide_info->leftside_funds,0) }}</h4>
                @else
                <h4 class="mb-3">$ 0</h4>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 mb-3" style="min-height: 100%;">
        <div class="card card-chart" style="height: 100%;">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-12">
                <span class="text-muted mb-3 lh-1 d-block text-truncate">Binary Right Points</span>
                @if($BinarySide_info)
                <h4 class="mb-3">${{ number_format($BinarySide_info->rightside_funds,0) }}</h4>
                @else
                <h4 class="mb-3">$ 0</h4>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3" style="min-height: 100%;">
        <div class="card card-chart" style="height: 100%;">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-12">
                <span class="text-muted mb-3 lh-1 d-block text-truncate">USDT TRON TRC20 Wallet Address</span>
                @if($User_Wallet_Info)
                <div class="mb-3">{{$User_Info->wallet_address}}</div>
                @else
                <div class="mb-3"></div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3" style="min-height: 100%;">
        <div class="card card-chart" style="height: 100%;">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-12">
                <span class="text-muted mb-3 lh-1 d-block text-truncate">Investment Wallet Balance</span>
                @if($User_Wallet_Info)
                <h4 class="mb-3">${{ number_format($User_Wallet_Info->cash_balance,0) }}</h4>
                @else
                <h4 class="mb-3">$ 0</h4>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3" style="min-height: 100%;">
        <div class="card card-chart" style="height: 100%;">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-12">
                <span class="text-muted mb-3 lh-1 d-block text-truncate">Withdrawal Wallet Balance</span>
                @if($User_Wallet_Info)
                <h4 class="mb-3">${{ number_format($User_Wallet_Info->income_amount,0) }}</h4>
                @else
                <h4 class="mb-3">$ 0</h4>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xl-5">
        <div class="card card-h-100">
          <div class="card-body">
            <div class="d-flex flex-wrap align-items-center">
              <h5 class="u-card-title me-2">Total Income</h5>
            </div>
            <div class="row align-items-center" style="height: 100%;">
              <div class="col-sm" style="padding: 0px;">
                @if($Investment)
                <div id="Total_Income_PieChart" class="resize-triggers" style="display: flex; justify-content: center;"></div>
                @else
                <h6 class="mb-3" style="text-align: center;">You need to make a new investment!</h6>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-5">
        <div class="card card-h-100 myc">
          <div class="card-body">
            <div class="d-flex flex-wrap align-items-center">
              <h5 class="u-card-title me-2">Investment Overview</h5>
            </div>
            <div class="row align-items-center">
              <div class="col-sm" style="padding: 0px;">
                @if($Investment)
                <div id="Invest_Overview_Chart" style="display: flex; justify-content: center;"></div>
                @else
                <h6 class="mb-3" style="text-align: center;">You need to make a new investment!</h6>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-2">
        <div class="card bg-info text-white shadow-primary card-h-100">
          <div class="card-body p-0">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <div class="text-center p-4 coin-block">
                  <i class="material-icons widget-box-1-icon">currency_bitcoin</i>
                  <div class="avatar-md m-auto">
                    <span class="avatar-title rounded-circle bg-soft-light text-white font-size-24 ">
                      <a data-bs-toggle="modal" data-bs-target="#success" class="text-white" style="cursor: pointer;">
                        <i class="fa fa-copy" onclick="copyleftlink()"></i>
                      </a></span>
                  </div>
                  <small>Click to Copy</small>
                  <input type="text" value="Your Left Link Copied" id="leftInput" style="height: 0px !important; display: none;">
                  <a data-bs-toggle="modal" data-bs-target="#success" class="bb1">
                    <h5 class="mt-1 lh-base fw-normal text-white">Left Referral Link</h5>
                  </a>
                  <hr>
                  <i class="material-icons widget-box-1-icon">currency_bitcoin</i>
                  <div class="avatar-md m-auto">
                    <span class="avatar-title rounded-circle bg-soft-light text-white font-size-24 ">
                      <a data-bs-toggle="modal" data-bs-target="#success1" class="text-white" style="cursor: pointer;">
                        <i class="fa fa-copy" onclick="copyrightlink()"></i>
                      </a></span>
                  </div>
                  <small>Click to Copy</small>
                  <input type="text" value="Your Right Link Copied" id="myInput1" style="height: 0px !important; display: none;">
                  <a data-bs-toggle="modal" data-bs-target="#success1" class="bb1">
                    <h5 class="mt-1 lh-base fw-normal text-white">Right Referral Link</h5>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xl-8">
        <div class="card">
          <div class="card-body">
            <h5 class="u-card-title me-2">Rank Achievers</h5>
            <div class="row ms-auto">
              <div class="col-xl-8 col-md-8" id="Rank_Achiever_Chart"></div>
              <div class="col-xl-4 col-md-4" id="Rank_Achiever_Lists">
                <div style="height: 280px; overflow:auto;">
                  <div class="d-flex align-items-center" style="justify-content: space-evenly;">
                    <span class="notification" style="width:20px; height:20px; border-radius: 10px; background-color: #9a9aae; text-align:center;">1</span>
                    <span class="font-size-16" style="width: 70%;">Team Leader</span>
                    <span id="Team_Leader_Nums" style="width:20px; height:20px; border-radius: 10px; background-color: #c9ecde; text-align:center;"></span>
                  </div>
                  <div id="Team_Leader_Lists" style="padding-left: 30px;"></div>
                  <div class="d-flex align-items-center mt-2" style="justify-content: space-evenly;">
                    <span class="notification" style="width:20px; height:20px; border-radius: 10px; background-color: #9a9aae; text-align:center;">2</span>
                    <span class="font-size-16" style="width: 70%;">Manager</span>
                    <span id="Manager_Nums" style="width:20px; height:20px; border-radius: 10px; background-color: #c9ecde; text-align:center;"></span>
                  </div>
                  <div id="Manager_Lists" style="padding-left: 30px;"></div>
                  <div class="d-flex align-items-center mt-2" style="justify-content: space-evenly;">
                    <span class="notification" style="width:20px; height:20px; border-radius: 10px; background-color: #9a9aae; text-align:center;">3</span>
                    <span class="font-size-16" style="width: 70%;">Regional Manager</span>
                    <span id="Regional_Manger_Nums" style="width:20px; height:20px; border-radius: 10px; background-color: #c9ecde; text-align:center;"></span>
                  </div>
                  <div id="Regional_Manager_Lists" style="padding-left: 30px;"></div>
                  <div class="d-flex align-items-center mt-2" style="justify-content: space-evenly;">
                    <span class="notification" style="width:20px; height:20px; border-radius: 10px; background-color: #9a9aae; text-align:center;">4</span>
                    <span class="font-size-16" style="width: 70%;">Director</span>
                    <span id="Director_Nums" style="width:20px; height:20px; border-radius: 10px; background-color: #c9ecde; text-align:center;"></span>
                  </div>
                  <div id="Director_Lists" style="padding-left: 30px;"></div>
                  <div class="d-flex align-items-center mt-2" style="justify-content: space-evenly;">
                    <span class="notification" style="width:20px; height:20px; border-radius: 10px; background-color: #9a9aae; text-align:center;">5</span>
                    <span class="font-size-16" style="width: 70%;">Managing Director</span>
                    <span id="Managing_Director_Nums" style="width:20px; height:20px; border-radius: 10px; background-color: #c9ecde; text-align:center;"></span>
                  </div>
                  <div id="Managing_Director_Lists" style="padding-left: 30px;"></div>
                  <!---->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @if($User_Info->role == 'admin')
      <div class="col-xl-4">
        @if($today_daily_roi_percentage)
        <div class="card" style="min-height: 340px; box-shadow:4px 4px 20px rgb(4 135 228);">
          @else
          <div class="card" style="min-height: 340px; box-shadow:4px 4px 20px rgb(228 4 4);">
            @endif
            <div class="u-card-header align-items-center d-flex">
              <h4 class="u-card-title mb-0 flex-grow-1">Settings</h4>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div id="buy-tab" role="tabpanel" class="tab-pane active">
                  <div>
                    <div class="amount_input">
                      <div class="input-group">
                        <label class="label_title" style="width: 55%;">Daily ROI Percentage :</label>
                        <input id="daily_roi_percentage" class="form-group-control" style="width: 30%;" value='{{$today_daily_roi_percentage}}' type="number" name="amount" min="1" step="1" onkeypress="" title="Numbers only" placeholder="" aria-required="true" aria-invalid="false">
                        <label class="input-group-text">%</label>
                      </div>
                    </div>
                    @if($today_daily_roi_percentage)
                    <div class="text-center mb-2" style="display: flex; justify-content:flex-end;">
                      <label class="setting_label" style="color:blue;">&nbsp;&nbsp;Today's Daily ROI Percent is {{$today_daily_roi_percentage}}%</label>
                    </div>
                    @else
                    <div class="text-center mb-2" style="display: flex; justify-content:space-between; align-items:center;">
                      <label class="setting_label" style="color:red;">&nbsp;&nbsp;Please set Today's ROI Percentage!</label>
                      <button type="button" class="btn btn-success w-md" onclick="handleROISetting()">Save</button>
                    </div>
                    @endif
                    <div class="amount_input">
                      <div class="input-group">
                        <label class="label_title" style="width: 55%;">Direct Referral Percentage :</label>
                        <input id="direct_referral_percentage" class="form-group-control" style="width: 30%;" value='{{$direct_referral_percentage}}' type="number" name="amount" min="1" step="1" onkeypress="" title="Numbers only" placeholder="" aria-required="true" aria-invalid="false">
                        <label class="input-group-text">%</label>
                      </div>
                    </div>
                    @if($direct_referral_percentage)
                    <div class="text-center mb-2" style="display: flex; justify-content:space-between;">
                      <label class="setting_label" style="color:blue;">&nbsp;Current Direct Referral Percent is {{$direct_referral_percentage}}%</label>
                      <button type="button" class="btn btn-success w-md" onclick="handleDirectSetting()">Save</button>
                    </div>
                    @else
                    <div class="text-center mb-2" style="display: flex; justify-content:space-between; align-items:center;">
                      <label class="setting_label" style="color:red;">&nbsp;&nbsp;Default Direct Referral Percentage is 10%</label>
                      <button type="button" class="btn btn-success w-md" onclick="handleDirectSetting()">Save</button>
                    </div>
                    @endif

                    <div class="amount_input">
                      <div class="input-group">
                        <label class="label_title" style="width: 55%;">Binary Bonus Percentage :</label>
                        <input id="binary_bonus_percentage" class="form-group-control" style="width: 30%;" value='{{$binary_bonus_percentage}}' type="number" name="amount" min="1" step="1" onkeypress="" title="Numbers only" placeholder="" aria-required="true" aria-invalid="false">
                        <label class="input-group-text">%</label>
                      </div>
                    </div>
                    @if($binary_bonus_percentage)
                    <div class="text-center mb-2" style="display: flex; justify-content:space-between;">
                      <label class="setting_label" style="color:blue;">&nbsp;Current Binary Bonus Percent is {{$binary_bonus_percentage}}%</label>
                      <button type="button" class="btn btn-success w-md" onclick="handleBinarySetting()">Save</button>
                    </div>
                    @else
                    <div class="text-center mb-2" style="display: flex; justify-content:space-between; align-items:center;">
                      <label class="setting_label" style="color:red;">&nbsp;&nbsp;Default Binary Bonus Percentage is 10%</label>
                      <button type="button" class="btn btn-success w-md" onclick="handleBinarySetting()">Save</button>
                    </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @else
        @endif
      </div>

      <div class="row dtw">
        <div class="col-xl-4">
          <div class="card" style="height: 300px;">
            <div class="u-card-header align-items-center d-flex">
              <h4 class="u-card-title mb-0 flex-grow-1">Add Funds</h4>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div id="buy-tab" role="tabpanel" class="tab-pane active">
                  <div class="float-end ms-2">
                    <h5 class="font-size-14 abalance">
                      <i class="material-icons ab-wallet">account_balance_wallet</i>&nbsp
                      <a href="#!" class="text-reset text-decoration-underline" style="color: #000!important; font-weight: 500; text-decoration: underline!important;">$ {{$User_Wallet_Info->cash_balance}}</a>
                    </h5>
                  </div>
                  <h5 class="font-size-14 mb-4">Available Balance</h5>
                  <div>
                    <div class="amount_input">
                      <div class="input-group mb-3">
                        <label class="input-group-text">Amount</label>
                        <input id="add_funds_amount" class="form-group-control" value="0" type="number" name="amount" min="1" step="1" onkeypress="" title="Numbers only" placeholder="" aria-required="true" aria-invalid="false">
                        <label class="input-group-text">$</label>
                      </div>
                    </div>
                    <div class="form-group mb-3">
                      <label>Payment method :</label>
                      <select id="paymentMode" class="form-select">
                        <option disabled selected>Select Payment Method</option>
                        <option value="USDT.TRC20">Tether USD (Tron/TRC20)</option>
                      </select>
                    </div>
                    <div class="text-center">
                      <button type="button" class="btn btn-success w-md" onclick="handlePayment()">Deposit</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4">
          <div class="card" style="height: 300px;">
            <div class="u-card-header align-items-center d-flex">
              <h4 class="u-card-title mb-0 flex-grow-1">Income</h4>
              <div class="flex-shrink-0">
                <a data-bs-toggle="tab" href="#transactions-all-tab" role="tab" class="card-nav-link active">
                  All
                </a>
              </div>
            </div>
            <div class="card-body px-0">
              <div class="tab-content">
                <div id="transactions-all-tab" role="tabpanel" class="tab-pane active">
                  <div class="simplebar-content" style="padding: 0px 16px;">
                    <table class="table align-middle table-nowrap table-borderless">
                      <tbody>
                        <tr>
                          <td style="width: 50px;">
                            <div class="font-size-22 text-success">
                              <span class="material-icons-outlined">
                                south
                              </span>
                            </div>
                          </td>
                          <td>
                            <div>
                              <h5 class="font-size-14 mb-1">ROI Income</h5>
                              <p class="text-muted mb-0 font-size-12">
                                Details
                              </p>
                            </div>
                          </td>
                          <td>
                            <div class="text-end">
                              <h5 class="font-size-14 text-muted mb-0 text-right ">$ {{$Total_ROI}}</h5>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td style="width: 50px;">
                            <div class="font-size-22 text-success">
                              <span class="material-icons-outlined">
                                south
                              </span>
                            </div>
                          </td>
                          <td>
                            <div>
                              <h5 class="font-size-14 mb-1">Direct Income</h5>
                              <p class="text-muted mb-0 font-size-12">
                                Details
                              </p>
                            </div>
                          </td>
                          <td>
                            <div class="text-end">
                              <h5 class="font-size-14 text-muted mb-0 text-right ">$ {{$Total_Direct}}</h5>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td style="width: 50px;">
                            <div class="font-size-22 text-success">
                              <span class="material-icons-outlined">
                                south
                              </span>
                            </div>
                          </td>
                          <td>
                            <div>
                              <h5 class="font-size-14 mb-1">Binary Income</h5>
                              <p class="text-muted mb-0 font-size-12">
                                Details
                              </p>
                            </div>
                          </td>
                          <td>
                            <div class="text-end">
                              <h5 class="font-size-14 text-muted mb-0 text-right ">$ {{$Total_Binary}}</h5>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4">
          <div class="card" style="height: 300px;">
            <div class="u-card-header align-items-center d-flex">
              <h4 class="u-card-title mb-0 flex-grow-1">Withdraw To Investment</h4>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div id="buy-tab" role="tabpanel" class="tab-pane active">
                  <div class="float-end ms-2">
                    <h5 class="font-size-14 abalance">
                      <i class="material-icons ab-wallet">account_balance_wallet</i>&nbsp
                      <a href="#!" class="text-reset text-decoration-underline" style="color: #000!important; font-weight: 500; text-decoration: underline!important;">$ {{$User_Wallet_Info->income_amount}}</a>
                    </h5>
                  </div>
                  <h5 class="font-size-14 mb-4">Withdraw Wallet Balance</h5>
                  <div>
                    <div class="amount_input">
                      <div class="input-group mb-3">
                        <label class="input-group-text">Amount</label>
                        <input id="withdraw_amount" class="form-group-control" value="0" type="number" name="amount" min="1" step="1" onkeypress="" title="Numbers only" placeholder="" aria-required="true" aria-invalid="false" onchange="handleCheck()">
                        <label class="input-group-text">$</label>
                      </div>
                      <p id="alert_1" style="margin: 0px; text-align:left; color:red;"></p>
                      <p id="alert_2" style="margin: 0px; text-align:left; color:red;"></p>
                    </div>
                    <div class="text-center">
                      <button id="withdraw_button" type="button" disabled class="btn w-md" onclick="makeWithdrawal()" disabled>
                        Withdraw
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="payinfo" class="card card-nav-tabs text-center" style="display: none;">
      <div class="card-header card-header-primary" style="display:flex; justify-content: center; align-items: center;">
        Payment Information
        <i id="cancelIcon" class="material-icons" style="position: absolute; right: 10px; font-size: 30px; cursor: pointer; z-index: 1;">close</i>
      </div>
      <div id="payinfotable" class="card-body">
      </div>
    </div>
  </div>


  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <!-- Chart Script -->
  <script>
    var User_Info = `{{$User_Info}}`;
    var User_Wallet_Info = `{{$User_Wallet_Info}}`;
    var Total_ROI = `{{$Total_ROI}}` * 1;
    var Total_Direct = `{{$Total_Direct}}` * 1;
    var Total_Binary = `{{$Total_Binary}}` * 1;
    var BinarySide_info = `{{$BinarySide_info}}`;
    var Investment = `{{$Investment}}`;
    var Invest_amount = `{{$Invest_amount}}`;
    var All_Member_BinarySide_info = `{{$All_Member_BinarySide_info}}`;

    var total_income_ChartData = [
      ["Income_Type", "Number"],
      ['ROI', Total_ROI],
      ['Direct', Total_Direct],
      ['Binary', Total_Binary],
    ];

    var Total_Income = Invest_amount * 1 * 4.5;
    var ROI_Created = Total_ROI + Total_Direct + Total_Binary;
    var ROI_Remaining = Total_Income - ROI_Created;

    if (ROI_Remaining > 0) {
      var invest_overview_ChartData = [
        ["Type", "Number"],
        ['ROI CREATED', ROI_Created],
        ['ROI REMAINING', ROI_Remaining],
      ];
    } else {
      var invest_overview_ChartData = [
        ["Type", "Number"],
        ['ROI CREATED', 0],
        ['ROI REMAINING', 0],
      ];
    }


    var BinarySide_infos = {{Js::from($All_Member_BinarySide_info)}};
    var BinarySides = eval(BinarySide_infos);

    var Team_Leader_Num = 0;
    var Team_Leader_Lists = '';
    var Manager_Num = 0;
    var Manager_Lists = '';
    var Regional_Manager_Num = 0;
    var Regional_Manager_Lists = '';
    var Director_Num = 0;
    var Director_Lists = '';
    var Managing_Director_Num = 0;
    var Managing_Director_Lists = '';

    for (let i = 0; i < BinarySides.length; i++) {
      const element = BinarySides[i];
      if (element.rank == 'Team_Leader') {
        ++Team_Leader_Num;
        Team_Leader_Lists += '<span>' + element.name + '</span> <br />';
      } else if (element.rank == 'Manager') {
        ++Manager_Num;
        Manager_Lists += '<span>' + element.name + '</span> <br />';
      } else if (element.rank == 'Regional_Manager') {
        ++Regional_Manager_Num;
        Regional_Manager_Lists += '<span>' + element.name + '</span> <br />';
      } else if (element.rank == 'Director') {
        ++Director_Num;
        Director_Lists += '<span>' + element.name + '</span> <br />';
      } else if (element.rank == 'Managing_Director') {
        ++Managing_Director_Num;
        Managing_Director_Lists += '<span>' + element.name + '</span> <br />';
      }
    }

    $('#Team_Leader_Lists').append(Team_Leader_Lists);
    document.getElementById('Team_Leader_Nums').innerHTML = Team_Leader_Num;
    $('#Manager_Lists').append(Manager_Lists);
    document.getElementById('Manager_Nums').innerHTML = Manager_Num;
    $('#Regional_Manager_Lists').append(Regional_Manager_Lists);
    document.getElementById('Regional_Manger_Nums').innerHTML = Regional_Manager_Num;
    $('#Director_Lists').append(Director_Lists);
    document.getElementById('Director_Nums').innerHTML = Director_Num;
    $('#Managing_Director_Lists').append(Managing_Director_Lists);
    document.getElementById('Managing_Director_Nums').innerHTML = Managing_Director_Num;


    google.charts.load('current', {
      packages: ['corechart'],
      callback: drawChart
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density", {
          role: "style"
        }],
        ["Team Leader", Team_Leader_Num, "#3366cc"],
        ["Manager", Manager_Num, "#3366cc"],
        ["Regional Manger", Regional_Manager_Num, "#3366cc"],
        ["Director", Director_Num, "#3366cc"],
        ["Managing Director", Managing_Director_Num, "color: #3366cc"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
        {
          calc: "stringify",
          sourceColumn: 1,
          type: "string",
          role: "annotation"
        },
        2
      ]);
      var options = {
        title: "",
        width: '100%',
        height: 280,
        bar: {
          groupWidth: "95%"
        },
        legend: {
          position: "none"
        },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("Rank_Achiever_Chart"));
      chart.draw(view, options);

      if (Investment) {
        //Total Income Chart
        var total_income_data = google.visualization.arrayToDataTable(total_income_ChartData);
        var total_income_title = 'ROI: $' + Total_ROI + ', Diret: $' + Total_Direct + ', Binary: $' + Total_Binary;
        var total_income_options = {
          'is3D': true,
          title: total_income_title,
          'width': '100%',
          'height': 300,
          pieSliceText: 'label',
          legend: {
            position: 'bottom',
          },
        };
        var total_income_chart = new google.visualization.PieChart(document.getElementById('Total_Income_PieChart'));
        total_income_chart.draw(total_income_data, total_income_options);

        //Investment Overview Chart
        var invest_overview_data = google.visualization.arrayToDataTable(invest_overview_ChartData);
        var invest_overview_title = 'Investment: $' + Invest_amount + ', ROI CREATED: $' + ROI_Created + ', ROI REMAINING: $' + ROI_Remaining;
      
        var overChat_parentDiv_width = document.getElementById("Invest_Overview_Chart").offsetWidth; //317
        var overChat_width = overChat_parentDiv_width*1-30;
        var invest_overview_options = {
          // 'is3D': true,
          title: invest_overview_title,
          'width': overChat_width,
          'height': 300,
          pieHole: 0.4,
          legend: {
            position: 'bottom',
          },
          colors: ['#3366cc', '#f4f4f4']
        };
        var invset_overview_chart = new google.visualization.PieChart(document.getElementById('Invest_Overview_Chart'));
        invset_overview_chart.draw(invest_overview_data, invest_overview_options);
      }
    }
  </script>

  <!-- Add funds Action -->
  <script>
    var payStatus = false;
    var payInfoData = [];

    $(document).on('click', '#cancelIcon', function(e) {
      payStatus = true;
      $("#container-fluid").show();
      $("#payinfo").hide();
      location = "/dashboard";
      location.reload();
    });

    function handlePayment() {
      if (payStatus === false) {
        payStatus = true;

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          type: 'POST',
          url: "add_funds/payment",
          data: {
            payAmount: $("#add_funds_amount").val(),
            paymentMode: $("#paymentMode").val()
          },
          success: function(data) {
            console.log('data', data)
            if (data.status == 200) {
              $('#payinfotable').append(data.xml);
              payInfoData = data;
              $("#container-fluid").css("display", "none")
              $("#payinfo").css("display", "block")
            } else if (data.status == 400) {
              console.log(data.error);
              return;
            }
          }
        });
      } else {
        $("#container-fluid").css("display", "none")
        $("#payinfo").css("display", "block")
      }
    }
  </script>

  <!-- withdrawal action -->
  <script type="text/javascript">
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

    function handleCheck() {
      $amount = $("#withdraw_amount").val();
      $balance = `{{$User_Wallet_Info->income_amount}}` * 1;
      $temp = $amount * 1 % 10;
      if ($amount * 1 < 50) {
        $alert_txt = "Amount must be 50 or more !";
        document.getElementById('alert_1').innerHTML = $alert_txt;
      } else {
        if ($amount > $balance) {
          $alert_txt = "Requested amount should not be greater than wallet balance !";
          document.getElementById('alert_1').innerHTML = $alert_txt;
        } else {
          $alert_txt = "";
          document.getElementById('alert_1').innerHTML = $alert_txt;
        }
      }

      if ($temp > 0) {
        $alert_txt = "Amount must be multiples of 10 !";
        document.getElementById('alert_2').innerHTML = $alert_txt;
      } else {
        $alert_txt = "";
        document.getElementById('alert_2').innerHTML = $alert_txt;
      }

      if ($amount * 1 >= 50 && $amount <= $balance && $temp == 0) {
        document.getElementById("withdraw_button").disabled = false;
        document.getElementById('alert_1').innerHTML = '';
        document.getElementById('alert_2').innerHTML = '';
        document.getElementById("withdraw_button").classList.add("btn-info");
      }
    }


    function makeWithdrawal() {
      $amount = $("#withdraw_amount").val();

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        type: 'POST',
        url: "wallet_withdrawal/post",
        data: {
          amount: $amount,
        },
        success: function(data) {
          console.log('data', data)
          if (data.status == 200) {
            notify('success', 'Request Success!', 'top', 'right');
            location = "/dashboard";
            location.reload();
          } else if (data.status == 400) {
            notify('danger', data.error, 'top', 'right');
            return;
          }
        }
      });
    }
  </script>

  <!-- Copy links Action -->
  <script>
    function copyleftlink() {
      var leftlink = `{{$User_LeftReferral_Link}}`;
      if (leftlink) {
        navigator.clipboard.writeText(leftlink);
        var alert_txt = "Copied the Left Link";
        notify('success', alert_txt, 'top', 'right');
      } else {
        notify('danger', 'There is No Left_Referral Link!', 'top', 'right');
      }
    }

    function copyrightlink() {
      var rightlink = `{{$User_RightReferral_Link}}`;
      if (rightlink) {
        navigator.clipboard.writeText(rightlink);
        var alert_txt = "Copied the Right Link";
        notify('success', alert_txt, 'top', 'right');
      } else {
        notify('danger', 'There is No Right_Referral Link!', 'top', 'right');
      }
    }
  </script>

  <!-- Daily ROI and Direct Referral Percentage Setting Action -->
  <script>
    function handleROISetting() {
      $roiPercent = $("#daily_roi_percentage").val();
      if ($roiPercent == 0) {
        notify('warning', 'Set Daily ROI Percentage!', 'top', 'right');
      } else {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          type: 'POST',
          url: "roi_income/post",
          data: {
            percent: $roiPercent,
          },
          success: function(data) {
            if (data.status == 200) {
              notify('success', "Today's Daily ROI has been set exactly!", 'top', 'right');
              location = "/dashboard";
              location.reload();
            } else if (data.status == 400) {
              notify('danger', data.error, 'top', 'right');
              return;
            }
          }
        });
      }
    }

    function handleDirectSetting() {
      $directPercent = $("#direct_referral_percentage").val();
      if ($directPercent == 0) {
        notify('warning', 'Set Direct Referral Percentage!', 'top', 'right');
      } else {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          type: 'POST',
          url: "direct_referral/setNewPercentage",
          data: {
            percent: $directPercent,
          },
          success: function(data) {
            if (data.status == 200) {
              notify('success', "New Direct Referral Percentage has been set exactly!", 'top', 'right');
              location = "/dashboard";
              location.reload();
            } else if (data.status == 400) {
              notify('danger', data.error, 'top', 'right');
              return;
            }
          }
        });
      }
    }

    function handleBinarySetting() {
      $binaryPercent = $("#binary_bonus_percentage").val();
      if ($binaryPercent == 0) {
        notify('warning', 'Set Direct Referral Percentage!', 'top', 'right');
      } else {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          type: 'POST',
          url: "binary_income/setNewPercentage",
          data: {
            percent: $binaryPercent,
          },
          success: function(data) {
            if (data.status == 200) {
              notify('success', "New Binary Bonus Percentage has been set exactly!", 'top', 'right');
              location = "/dashboard";
              location.reload();
            } else if (data.status == 400) {
              notify('danger', data.error, 'top', 'right');
              return;
            }
          }
        });
      }
    }
  </script>
  @endsection

  @push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>
  @endpush