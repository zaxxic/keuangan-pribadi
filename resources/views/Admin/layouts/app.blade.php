<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kanakku - Bootstrap Admin HTML Template</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">


    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/feather/feather.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-lite.min.css') }}" />

    @yield('style')

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


                {{-- <li class="nav-item dropdown  flag-nav dropdown-heads">
                    <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button">
                        <i class="fe fe-bell"></i> <span class="badge rounded-pill"></span>
                    </a>
                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span class="notification-title">Notifications</span>
                            <a href="javascript:void(0)" class="clear-noti"> </a>
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
                </li> --}}
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
                                        <a class="dropdown-item" href="#" data-bs-target="#ganti"
                                            data-bs-toggle="modal">Ganti Password</a>
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

        <div class="modal custom-modal fade" id="ganti" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body">

                        <div class="modal-btn delete-action">
                            <div class="row">
                                <form id="update-password-form" action="{{ Route('prof') }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-title">
                                                <h5>Ganti Password</h5>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label>Masukkan Password lama</label>
                                                <input type="Password" class="form-control" name="current_password"
                                                    placeholder="Masuukan password lama" />
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label>Masukkan Password</label>
                                                <input type="Password" class="form-control" name="new_password"
                                                    placeholder="Masukkan password baru" />
                                            </div>
                                        </div>


                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label>Masukkan Konfirmasi Password</label>
                                                <input type="Password" class="form-control"
                                                    name="new_password_confirmation"
                                                    placeholder="Konfirmasi password" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12 mt-4">
                                            <div class="btn-path">
                                                <button type="submit" id="saveButton"
                                                    class="w-100 btn btn-primary paid-continue-btn">Simpan</button>
                                                <div id="loadingIndicator" style="display: none;">
                                                    <div class="spinner-border text-primary" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar sidebar-two" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <a href="index.html">
                        <h3 class="logo" style="color: aliceblue">Tabungan<span style="color: #6434db">Ku</span>
                        </h3>
                    </a>
                    <a href="index.html">
                        <h3 class="logo-small" style="color: aliceblue">T<span style="color: #6434db">K</span></h3>
                    </a>
                </div>
            </div>
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu sidebar-menu-two">
                    <ul>
                        <li class="menu-title"><span>Dashboard</span></li>
                        <li>
                            <a class="{{ Route::currentRouteName() == 'admin' ? 'active' : '' }}"
                                href="{{ route('admin') }}">
                                <i class="fe fe-home"></i><span>Dashboard</span></a>
                        </li>
                        <li>
                            <a class="{{ in_array(Route::currentRouteName(), ['income-admin.index', 'expenditure-admin.index']) ? 'active' : '' }}"
                                href="{{ route('income-admin.index') }}">
                                <i class="fa fa-th-large"></i><span>Category</span></a>
                        </li>



                    </ul>

                    <ul>
                        <li class="menu-title"><span>Langganan</span></li>
                        <li>
                            <a class="{{ Route::currentRouteName() == 'paid-users' ? 'active' : '' }}"
                                href="{{ route('paid-users') }}">
                                <i class="fa fa-user-circle"></i><span>Users</span></a>
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



    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <script>
        $('#update-password-form').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            $('#saveButton').html('Loading...');
            $('#saveButton').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success('Password berhasil diperbarui.', 'Sukses');
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        var errorMessage = xhr.responseText.replace(/^"(.*)"$/, '$1');
                        toastr.error(errorMessage, 'Kesalahan Validasi');
                        $('#saveButton').html('Simpan');
                        $('#saveButton').prop('disabled', false);
                    } else {
                        toastr.error('Terjadi kesalahan: ' + error, 'Kesalahan');
                        $('#saveButton').html('Simpan');
                        $('#saveButton').prop('disabled', false);
                    }
                }
            });



        });
    </script>

    @yield('script')
</body>



</html>
