<div class="sidebar sidebar-two" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <a href="index.html">
                <img src="{{ asset('assets/img/logo-white.png') }}" class="img-fluid logo" alt>
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
                    <a class="{{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fe fe-home"></i><span>Dashboard</span></a>
                </li>
            </ul>

            <ul>
                <li class="menu-title"><span>Transaksi</span></li>

                <li class="submenu">
                    <a href="#"><i class="fe fe-trending-up"></i> <span> Pemasukan</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li> <a class="{{ in_array(Route::currentRouteName(), ['income.index', 'income.create', 'income.editing']) ? 'active' : '' }}"
                                href="{{ route('income.index') }}">
                                Pemasukan</a></li>
                        <li> <a class="{{ in_array(Route::currentRouteName(), ['reguler-income.index', 'reguler-income.create', 'reguler-income.edit']) ? 'active' : '' }}"
                                href="{{ route('reguler-income.index') }}">
                                Pemasukan Berencana</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fe fe-trending-down"></i> <span> Pengeluaran</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a class="{{ in_array(Route::currentRouteName(), ['expenditure.index', 'expenditure.create', 'expenditure.edit']) ? 'active' : '' }}"
                                href="{{ route('expenditure.index') }}">Pengeluaran</a></li>
                        <li><a class="{{ in_array(Route::currentRouteName(), ['reguler-expenditure.index', 'reguler-expenditure.create', 'reguler-expenditure.edit']) ? 'active' : '' }}"
                                href="{{ route('reguler-expenditure.index') }}">Pengeluaran Berencana</a></li>
                    </ul>
                </li>
                <li>
                    <a class="{{ in_array(Route::currentRouteName(), ['savings.index', 'savings.create', 'savings.show']) ? 'active' : '' }}"
                        href="{{ route('savings.index') }}"><i class="fe fe-save"></i><span>Tabungan</span></a>
                </li>
            </ul>
            <ul>
                <li class="menu-title"><span>Menu</span></li>
                <li>
                    <a class="{{ in_array(Route::currentRouteName(), ['subs.index', 'subs']) ? 'active' : '' }}"
                        href="{{ route('subs.index') }}">
                        <i class="fe fe-book"></i><span>Member</span></a>
                </li>

                <li>
                    <a class="{{ Route::currentRouteName() == 'pembelian' ? 'active' : '' }}"
                        href="{{ route('pembelian') }}">
                        <i class="fe fe-dollar-sign"></i><span>History Pembelian</span></a>
                </li>


                <li>
                    <a class="{{ Route::currentRouteName() == 'total' ? 'active' : '' }}"
                        href="{{ route('total') }}"><i class="fe fe-percent"></i><span>Total</span></a>
                </li>



                <li>
                    <a class="{{ in_array(Route::currentRouteName(), ['setting', 'income_category.index', 'expenditure_category.index']) ? 'active' : '' }}"
                        href="{{ route('setting') }}">
                        <i class="fe fe-settings"></i><span>Settings</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>
