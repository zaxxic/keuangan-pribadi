<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Kanakku - Bootstrap Admin HTML Template</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/feather/feather.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-lite.min.css') }}" />

</head>

<style>
    .custom-btn {
        display: inline-block;
        font-size: 12px;
        padding: 5px 8px;
        border-radius: 4px;
        border: none;
        color: #fff;
        background-color: #007bff;
        cursor: pointer;
        margin-top: 5px;
    }

    .custom-btn:hover {
        background-color: #0069d9;
    }

    .edit-btn {
        background-color: #ffc107;
    }

    .edit-btn:hover {
        background-color: #e0a800;
    }

    .detail-btn {
        background-color: #6c757d;
    }

    .detail-btn:hover {
        background-color: #5a6268;
    }

    .approve-btn {
        background-color: #28a745;
    }

    .approve-btn:hover {
        background-color: #218838;
    }
</style>

<body>

    <div class="main-wrapper">

        <div class="header header-one">

            <a href="javascript:void(0);" id="toggle_btn">
                <span class="toggle-bars">
                    <span class="bar-icons"></span>
                    <span class="bar-icons"></span>
                    <span class="bar-icons"></span>
                    <span class="bar-icons"></span>
                </span>
            </a>





            <a class="mobile_btn" id="mobile_btn">
                <i class="fas fa-bars"></i>
            </a>


            <ul class="nav nav-tabs user-menu">


                <li class="nav-item dropdown  flag-nav dropdown-heads">
                    <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button">
                        <i class="fe fe-bell"></i> <span class="badge rounded-pill"></span>
                    </a>
                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span class="notification-title">Notifications</span>
                            <a href="javascript:void(0)" class="clear-noti"> Clear All</a>
                        </div>
                        <div class="noti-content">
                            <ul class="notification-list">
                                <li class="notification-message">
                                    <a href="javascript:void(0);" style="cursor: default;">
                                        <div class="media d-flex">
                                            <div class="media-body">
                                                <p class="noti-time">
                                                    <span class="notification-time">4 mins ago</span>
                                                </p>
                                                <p class="noti-details">
                                                    <span class="noti-title">Pemasukan</span>
                                                    Gajian bulanan dari kantor A
                                                </p>
                                                <span class="noti-title">
                                                    <button class="custom-btn edit-btn"
                                                        onclick="editNotification()">Edit</button>
                                                    <button class="custom-btn detail-btn"
                                                        onclick="viewDetails()">Detail</button>
                                                    <button class="custom-btn approve-btn"
                                                        onclick="approveIncome()">Setuju</button>
                                                </span>

                                            </div>
                                        </div>
                                    </a>
                                </li>

                                <li class="notification-message">
                                    <a href="javascript:void(0);" style="cursor: default;">
                                        <div class="media d-flex">
                                            <div class="media-body">
                                                <p class="noti-time">
                                                    <span class="notification-time">40 mins ago</span>
                                                </p>
                                                <p class="noti-details">
                                                    <span class="noti-title">Pemasukan</span>
                                                    Gajian bulanan dari kantor HummaTech

                                                </p>
                                                <span class="noti-title">
                                                    <button class="custom-btn edit-btn"
                                                        onclick="editNotification()">Edit</button>
                                                    <button class="custom-btn detail-btn"
                                                        onclick="viewDetails()">Detail</button>
                                                    <button class="custom-btn approve-btn"
                                                        onclick="approveIncome()">Setuju</button>
                                                </span>

                                            </div>
                                        </div>
                                    </a>
                                </li>

                                <li class="notification-message">
                                    <a href="javascript:void(0);" style="cursor: default;">
                                        <div class="media d-flex">
                                            <div class="media-body">
                                                <p class="noti-time">
                                                    <span class="notification-time">90 mins ago</span>
                                                </p>
                                                <p class="noti-details">
                                                    <span class="noti-title">Pemasukan</span>
                                                    Gajian bulanan dari kantor Laaa
                                                </p>
                                                <span class="noti-title">
                                                    <button class="custom-btn edit-btn"
                                                        onclick="editNotification()">Edit</button>
                                                    <button class="custom-btn detail-btn"
                                                        onclick="viewDetails()">Detail</button>
                                                    <button class="custom-btn approve-btn"
                                                        onclick="approveIncome()">Setuju</button>
                                                </span>

                                            </div>
                                        </div>
                                    </a>
                                </li>

                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="notifications.html">View all Notifications</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item  has-arrow dropdown-heads ">
                    <a href="javascript:void(0);" class="win-maximize">
                        <i class="fe fe-maximize"></i>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="user-link  nav-link" data-bs-toggle="dropdown">
                        <span class="user-img">
                            <img src="assets/img/profiles/avatar-07.jpg" alt="img" class="profilesidebar">
                            <span class="animate-circle"></span>
                        </span>
                        <span class="user-content">
                            <span class="user-details">Admin</span>
                            <span class="user-name">John Smith</span>
                        </span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilemenu">
                            <div class="subscription-menu">
                                <ul>
                                    <li>
                                        <a class="dropdown-item" href="profile.html">Profile</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="settings.html">Settings</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="subscription-logout">
                                <ul>
                                    <li class="pb-0">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                              document.getElementById('logout-form').submit();">Log
                                            Out</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

            </ul>

        </div>

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
                                <i
                                    class="fe fe-home"></i><span>Dashboard</span></a>
                        </li>
                    </ul>

                    <ul>
                        <li class="menu-title"><span>Transaksi</span></li>
                        <li class="submenu">
                            <a href="#"><i class="fe fe-trending-up"></i> <span> Pemasukan</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li>        <a class="{{ Route::currentRouteName() == 'income' ? 'active' : '' }}" href="{{ route('income') }}">
                                    Pemasukan</a></li>
                                <li>        <a class="{{ Route::currentRouteName() == 'income-recurring' ? 'active' : '' }}" href="{{ route('income-recurring') }}">
                                    Pemasukan Berulang</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fe fe-trending-down"></i> <span> Pengeluaran</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a class="{{ Route::currentRouteName() == 'expenditure' ? 'active' : '' }}" href="{{ route('expenditure') }}">Pengeluaran</a></li>
                                <li><a href="">Pengeluaran Berulang</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul>
                        <li class="menu-title"><span>Menu</span></li>

                        <li>
                            <a href="customers.html"><i class="fe fe-calendar"></i><span>Kalender</span></a>
                        </li>

                        <li>
                            <a href="customers.html"><i class="fe fe-percent"></i><span>Total</span></a>
                        </li>
                        <li>
                            <a href="customers.html"><i class="fe fe-settings"></i><span>Settings</span></a>
                        </li>
                    </ul>



                </div>
            </div>
        </div>
        @yield('content')
    </div>

    <script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}"></script>

    <script src="{{ asset('assets/plugins/summernote/summernote-lite.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>



</html>
