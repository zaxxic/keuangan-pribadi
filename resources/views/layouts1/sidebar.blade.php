<div class="sidebar sidebar-two" id="sidebar">
  <div class="sidebar-header">
    <div class="sidebar-logo">
      <a href="index.html">
        <img src="assets/img/logo-white.png" class="img-fluid logo" alt>
      </a>
      <a href="index.html">
        <img src="assets/img/logo-small.png" class="img-fluid logo-small" alt>
      </a>
    </div>
  </div>
  <div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu sidebar-menu-two">
      <ul>
        <li class="menu-title"><span>Dashboard</span></li>
        <li>
          <a class="{{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="fe fe-home"></i><span>Dashboard</span></a>
        </li>
      </ul>

      <ul>
        <li class="menu-title"><span>Transaksi</span></li>
        <li class="submenu">
          <a href="#"><i class="fe fe-trending-up"></i> <span> Pemasukan</span> <span class="menu-arrow"></span></a>
          <ul>
            <li> <a class="{{ in_array(Route::currentRouteName(), ['income.index', 'income.create', 'income.edit']) ? 'active' : '' }}" href="{{ route('income.index') }}">
                Pemasukan</a></li>
            <li> <a class="{{ Route::currentRouteName() == 'income-recurring' ? 'active' : '' }}" href="{{ route('income-recurring') }}">
                Pemasukan Berulang</a></li>
          </ul>
        </li>
        <li class="submenu">
          <a href="#"><i class="fe fe-trending-down"></i> <span> Pengeluaran</span> <span class="menu-arrow"></span></a>
          <ul>
            <li><a class="{{ Route::currentRouteName() == 'expenditure' ? 'active' : '' }}" href="">Pengeluaran</a></li>
            <li><a href="">Pengeluaran Berulang</a></li>
          </ul>
        </li>
      </ul>
      <ul>
        <li class="menu-title"><span>Menu</span></li>

        <li>
          <a class="{{ Route::currentRouteName() == 'calendar' ? 'active' : '' }}" href="{{ route('calendar') }}"><i class="fe fe-calendar"></i><span>Kalender</span></a>
        </li>

        <li>
          <a class="{{ Route::currentRouteName() == 'total' ? 'active' : '' }}" href="{{ route('total') }}"><i class="fe fe-percent"></i><span>Total</span></a>
        </li>
        <li>
          <a class="{{ in_array(Route::currentRouteName(), ['setting', 'income_category.index', 'expenditure_category.index']) ? 'active' : '' }}" href="{{ route('setting') }}">
            <i class="fe fe-settings"></i><span>Settings</span></a>
        </li>
      </ul>



    </div>
  </div>
</div>