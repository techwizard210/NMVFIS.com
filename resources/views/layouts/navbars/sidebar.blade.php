<div class="sidebar" data-color="green" data-background-color="black" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="/dashboard" class="simple-text logo-normal">
      <img src="{{ asset('material') }}/img/logo.png" alt="" height="150">
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
          <i class="material-icons">house</i>
          <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="nav-item{{ ($activePage == 'funds' || $activePage == 'pending' || $activePage == 'confirmed' || $activePage == 'expired' || $activePage == 'investment' || $activePage == 'invest_others' || $activePage == 'transfer' || $activePage == 'withdrawal') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#add-funds" aria-expanded="true">
          <i class="material-icons">price_change</i>
          <p>{{ __('Add Funds') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="add-funds">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'funds' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('add_funds') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal">{{ __('Add Funds') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'pending' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('pending_transactions') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal"> {{ __('Pending Transactions') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'confirmed' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('confirmed_transactions') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal"> {{ __('Confirmed Transactions') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'expired' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('expired_transactions') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal"> {{ __('Expired Transactions') }} </span>
              </a>
            </li>
            @if(Session::get('user')->role == 'admin')
            <li class="nav-item{{ $activePage == 'investment' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('make_investment') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal"> {{ __('Make an Investment') }} </span>
              </a>
            </li>
            @else
            @endif
            
            @if(Session::get('user')->role == 'admin')
            <li class="nav-item{{ $activePage == 'invest_others' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('invest_others') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal"> {{ __('Invest For Others') }} </span>
              </a>
            </li>
            @else
            @endif
            
            <li class="nav-item{{ $activePage == 'transfer' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('wallet_transfer') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal"> {{ __('Investment Wallet Transfer') }} </span>
              </a>
            </li>

          </ul>
        </div>
      </li>
      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#account" aria-expanded="true">
          <i class="material-icons">manage_accounts</i>
          <p>{{ __('Account') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="account">
          <ul class="nav">
            @if(Session::get('user')->role == 'admin')
            <li class="nav-item{{ $activePage == 'memberprofile' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('profile.member') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal">{{ __('Member Profile')  }}</span>
              </a>
            </li>
            @else
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('profile.edit') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal">{{ __('Profile') }} </span>
              </a>
            </li>
            @endif
          </ul>
        </div>
      </li>
      <!-- <li class="nav-item{{ ($activePage == 'affiliate' || $activePage == 'presentation' || $activePage == 'promotional') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#affiliate-c" aria-expanded="true">
          <i class="material-icons">campaign</i>
          <p>{{ __('Affiliate') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="affiliate-c">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'promotional' ? ' active' : '' }}">
              <a class="nav-link" href="#">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal">{{ __('Promotional') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'presentation' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('affiliate_presentaion') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal">{{ __('Company Presentation') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li> -->
      <li class="nav-item{{ ($activePage == 'genealogy' || $activePage == 'dreferral' || $activePage == 'tview' || $activePage == 'downline') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#team-c" aria-expanded="true">
          <i class="material-icons">groups</i>
          <p>{{ __('Team') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="team-c">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'genealogy' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('genealogy_tree') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal">{{ __('Genealogy Tree') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'dreferral' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('direct_referral') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal">{{ __('Direct Referral') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'tview' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('team_view') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal">{{ __('Team View') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'downline' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('downline_investment') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal">{{ __('Downline investment') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item{{ ($activePage == 'direct' || $activePage == 'roi' || $activePage == 'binary' || $activePage == 'coordinator' || $activePage == 'elite') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#income-c" aria-expanded="true">
          <i class="material-icons">attach_money</i>
          <p>{{ __('Income') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="income-c">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'direct' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('direct_income') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal">{{ __('Direct Income') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'roi' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('roi_income') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal">{{ __('ROI Income') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'binary' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('binary_income') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal">{{ __('Binary Income') }} </span>
              </a>
            </li>
            <!-- <li class="nav-item{{ $activePage == 'coordinator' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('coordinator_income') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal">{{ __('Coordinator Income') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'elite' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('elite_income') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal">{{ __('Elite Income') }} </span>
              </a>
            </li> -->
          </ul>
        </div>
      </li>
      <li class="nav-item{{ ($activePage == 'balance' || $activePage == 'report') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#withdrawal-c" aria-expanded="true">
          <i class="material-icons">account_balance_wallet</i>
          <p>{{ __('Withdrawal Wallet') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="withdrawal-c">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'withdrawal' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('wallet_withdrawal') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal"> {{ __('Withdrawal to Investment Wallet') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'balance' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('withdrawal_balance') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal">{{ __('Withdrawal To USDT') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'report' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('withdrawal_report') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal">{{ __('Withdrawal Report') }} </span>
              </a>
            </li>

          </ul>
        </div>
      </li>
      <li class="nav-item{{ ($activePage == 'inv_r' || $activePage == 'transfer_r' || $activePage == 'wallet_r') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#report-c" aria-expanded="true">
          <i class="material-icons">description</i>
          <p>{{ __('Reports') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="report-c">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'inv_r' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('inv_r') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal">{{ __('Investment Report') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'inv_other' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('inv_other') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal">{{ __('InvestForOthers Report') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'transfer_r' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('transfer_r') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal">{{ __('From Withdrawal to Cash Report') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'wallet_r' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('wallet_r') }}">
                <span class="sidebar-mini">&nbsp</span>
                <span class="sidebar-normal">{{ __('Investment Wallet Transfer Report') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item{{ $activePage == 'logout' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
          <i class="material-icons">logout</i>
          <p>{{ __('Logout') }}</p>
        </a>
      </li>
    </ul>
  </div>
  <!-- <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
          <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>
          <p>{{ __('Laravel Examples') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="laravelExample">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('profile.edit') }}">
                <span class="sidebar-mini"> UP </span>
                <span class="sidebar-normal">{{ __('User profile') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user.index') }}">
                <span class="sidebar-mini"> UM </span>
                <span class="sidebar-normal"> {{ __('User Management') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item{{ $activePage == 'table' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('table') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Table List') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'typography' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('typography') }}">
          <i class="material-icons">library_books</i>
            <p>{{ __('Typography') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'icons' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('icons') }}">
          <i class="material-icons">bubble_chart</i>
          <p>{{ __('Icons') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'map' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('map') }}">
          <i class="material-icons">location_ons</i>
            <p>{{ __('Maps') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'notifications' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('notifications') }}">
          <i class="material-icons">notifications</i>
          <p>{{ __('Notifications') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('language') }}">
          <i class="material-icons">language</i>
          <p>{{ __('RTL Support') }}</p>
        </a>
      </li>
      <li class="nav-item active-pro{{ $activePage == 'upgrade' ? ' active' : '' }}">
        <a class="nav-link text-white bg-danger" href="{{ route('upgrade') }}">
          <i class="material-icons text-white">unarchive</i>
          <p>{{ __('Upgrade to PRO') }}</p>
        </a>
      </li>
    </ul>
  </div> -->
</div>