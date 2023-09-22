<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin keungan</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/feather/feather.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">


    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">


    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-lite.min.css') }}" />

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

    @yield('style')

</head>



<body>

    <div class="main-wrapper">

        @include('layouts1.header')
        @include('layouts1.sidebar')


        @yield('content')
        <div class="modal fade" id="planModal" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        <div class="price-table-main">
                            <div class="card">
                                <div class="card-body">
                                    <div class="plan-header">
                                        <span class="plan-widget-icon">
                                            <img src="assets/img/icons/plan-price-01.svg" alt>
                                        </span>
                                        <div class="plan-title">
                                            <h6>Member Bulanan</h6>
                                            <h4 class="plan-name">Gratis 1 Bulan</h4>
                                        </div>
                                    </div>
                                    <div class="description-content">
                                        <p>Dapatkan fitur premium untuk akses penuh</p>
                                    </div>
                                    <div class="price-dollar">
                                        <h1 class="d-flex align-items-center">Rp 90.000,00<span
                                                class="ms-1">/bulan</span>
                                        </h1>
                                    </div>
                                    <div class="plan-description">
                                        <h6>Apa yang di dapatkan</h6>
                                        <ul>
                                            <li class="mt-2">
                                                <span class="rounded-circle me-2"><i class="fe fe-check"></i></span>
                                                Pemasukan Berulang
                                            </li>
                                            <li class="mt-2">
                                                <span class="rounded-circle me-2"><i class="fe fe-check"></i></span>
                                                Pengeluaran Berulang
                                            </li>
                                            <li class="mt-2">
                                                <span class="rounded-circle me-2"><i class="fe fe-check"></i></span>
                                                Export transaksi ke excel
                                            </li>
                                            <li class="mt-2">
                                                <span class="rounded-circle me-2"><i class="fe fe-check"></i></span>
                                                DLL...
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="plan-button">
                                        <a class="btn btn-primary d-flex align-items-center justify-content-center"
                                            href="#">Mulai Brlangganan<span class="ms-2"><i
                                                    class="fe fe-arrow-right"></i></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

    <script>
        // Fungsi untuk mengambil data notifikasi
        function fetchNotifications() {
            $.ajax({
                url: "{{Route('notif.index')}}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Bersihkan daftar notifikasi yang ada
                    $('.notification-list').empty();

                    // Iterasi melalui data notifikasi dan tambahkan ke dalam daftar
                    $.each(data, function(index, notification) {
                        var notificationItem = `
                    <li class="notification-message">
                        <a href="javascript:void(0);" style="cursor: default;">
                            <div class="media d-flex">
                                <div class="media-body">
                                    <p class="noti-time">
                                        <span class="notification-time">${notification.time}</span>
                                    </p>
                                    <p class="noti-details">
                                        <span class="noti-title">${notification.title}</span>
                                        ${notification.message}
                                    </p>
                                    <span class="noti-title">
                                        <button class="custom-btn edit-btn" onclick="editNotification()">Edit</button>
                                        <button class="custom-btn detail-btn" onclick="viewDetails()">Detail</button>
                                        <button class="custom-btn approve-btn" onclick="approveIncome()">Setuju</button>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </li>
                `;

                        $('.notification-list').append(notificationItem);
                    });
                },
                error: function() {
                    // Handle error jika terjadi kesalahan saat mengambil data notifikasi
                }
            });
        }

        // Panggil fungsi fetchNotifications untuk pertama kali
        fetchNotifications();

        // Selanjutnya, Anda dapat mengatur interval untuk mengambil data notifikasi secara berkala
        setInterval(fetchNotifications, 60000); // Contoh: mengambil data setiap 60 detik
    </script>

    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    @yield('script')

</body>



</html>
