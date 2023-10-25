<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Save Your Money</title>

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
        .notification-message.no-notification {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            height: 100px;
            /* Adjust the height as needed */
        }

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

        /* CSS untuk layar dengan lebar lebih besar dari 425px */
        .saldo1 {
            display: block;
         }

        .saldo2 {
            display: none;
        }

        @media (max-width: 425px) {
            .saldo1 {
                display: none;
            }

            .saldo2 {
                display: block;
            }
        }
    </style>

    @yield('style')

</head>



<body>

    <div class="main-wrapper">

        @include('layouts1.header')
        @include('layouts1.sidebar')


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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function fetchNotifications() {
            $.ajax({
                url: "{{ Route('notif.index') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Bersihkan daftar notifikasi yang ada
                    $('.notification-list').empty();

                    // Dapatkan data notifikasi dari properti 'notif'
                    var notifications = data.notif;

                    // Fungsi untuk mengubah format tanggal
                    function formatDate(dateString) {
                        var options = {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        };
                        return new Date(dateString).toLocaleDateString('id-ID', options);
                    }

                    // Check if there are no notifications
                    if (notifications.length === 0) {
                        // If no notifications, display a message
                        var noNotificationMessage = `
                        <li class="notification-message no-notification">
                            <p class="noti-title">Tidak ada notifikasi</p>
                        </li>
                        `;
                        $('.notification-list').append(noNotificationMessage);
                    } else {
                        // Iterasi melalui data notifikasi dan tambahkan ke dalam daftar
                        $.each(notifications, function(index, notification) {
                            var content = notification.history_transaction.content;
                            var dataContent = content === 'expenditure' ? 'Pengeluaran' : content ===
                                'income' ? 'Pemasukan' : content;
                            var attachment = notification.history_transaction.attachment ? notification
                                .history_transaction.attachment : 'default.png';

                            var notificationItem = `
                                <li class="notification-message">
                                <a style="cursor: default;">
                                    <div class="media d-flex">
                                    <div class="media-body">
                                        <p class="noti-time">
                                        <span class="notification-time">${formatDate(notification.created_at)}</span>
                                        </p>
                                        <p class="noti-details">
                                        <span class="noti-title">${dataContent}</span>
                                        Dari ${notification.history_transaction.title} 
                                        </p>
                                        <span class="noti-title">
                                        <button class="custom-btn edit-btn"  onclick="showEditModal(this)"
                                            data-toggle="modal"
                                            data-target="#myModalEdit"
                                            data-foto="${attachment}"
                                            data-amount="${notification.history_transaction.amount}"
                                            data-title="${notification.history_transaction.title}"
                                            data-id-transaction="${notification.id}"
                                            data-content="${notification.history_transaction.content}"
                                            data-description="${notification.history_transaction.description}" 
                                            data-category="${notification.history_transaction.category.name}"
                                            data-payment_method="${notification.history_transaction.payment_method}" >Edit</button>
                                            
                                        <button class="custom-btn detail-btn" type="button" id="detail" onclick="showDetailModal(this)"
                                            data-toggle="modal"
                                            data-target="#myModal"
                                            data-foto="${attachment}"
                                            data-amount="${notification.history_transaction.amount}"
                                            data-title="${notification.history_transaction.title}"
                                            data-id-transaction="${notification.id}"
                                            data-content="${notification.history_transaction.content}"
                                            data-description="${notification.history_transaction.description}" 
                                            data-category="${notification.history_transaction.category.name}"
                                            data-payment_method="${notification.history_transaction.payment_method}">
                                            Detail
                                        </button>
                                        <button class="custom-btn approve-btn" id="btn-approve" data-notification-id="${notification.id}" onclick="approveIncome(${notification.id})">Setuju</button>
                                        </span>
                                    </div>
                                    </div>
                                </a>
                                </li>
                            `;

                            // Tambahkan notifikasi ke dalam daftar
                            $('.notification-list').append(notificationItem);
                        });
                    }
                },


                error: function() {}
            });
        }

        fetchNotifications();


        function showDetailModal(button) {
            const foto = button.getAttribute('data-foto');
            const amount = button.getAttribute('data-amount');
            const title = button.getAttribute('data-title');
            const description = button.getAttribute('data-description');
            const category = button.getAttribute('data-category');
            const content = button.getAttribute('data-content');
            const paymentMethod = button.getAttribute('data-payment_method');
            const notificationId = button.getAttribute('data-id-transaction');

            // Determine the base URL based on the content
            let baseUrl = '';
            if (content === 'expenditure') {
                baseUrl = '/storage/reguler_expenditure_attachment/';
            } else {
                baseUrl = '/storage/reguler_income_attachment/';
            }

            // Construct the full URL for the image
            const imageUrl = baseUrl + foto;

            // Populate the modal with data
            const modal = document.getElementById('myModal');
            const modalFoto = modal.querySelector('#modal-foto');
            const modalAmount = modal.querySelector('#modal-amount');
            const modalTitle = modal.querySelector('#modal-title');
            const modalDescription = modal.querySelector('#modal-description');
            const modalCategory = modal.querySelector('#modal-category');
            const modalPaymentMethod = modal.querySelector('#modal-payment-method');


            // Set data ID notifikasi ke dalam tombol "Setuju"
            const btnApprove = modal.querySelector('#btn-approve');
            btnApprove.setAttribute('data-notification-id', notificationId);

            modalFoto.src = imageUrl; // Set the image source
            modalAmount.textContent = amount;
            modalTitle.textContent = title;
            modalDescription.textContent = description;
            modalCategory.textContent = category;
            modalPaymentMethod.textContent = paymentMethod;

            // Show the modal
            $(modal).modal('show');
        }
        $('#btn-approve').on('click', function() {
            var notificationId = $(this).data('notification-id');

            $.ajax({
                url: '/accept/' + notificationId,
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    toastr.success(
                        'Data berhasil update');
                    $('#myModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        toastr.error('Saldo tidak cukup untuk melakukan trnasaksi ini', 'Error');
                    }
                }
            });
        });

        function approveIncome(notificationId) {
            $.ajax({
                url: '/accept/' + notificationId,
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    toastr.success(
                        'Data berhasil di update');
                    $('#myModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        toastr.error('Saldo tidak cukup untuk melakukan trnasaksi ini', 'Error');
                    }
                }
            });
        }

        function showEditModal(button) {
            const foto = button.getAttribute('data-foto');
            const amount = button.getAttribute('data-amount');
            const title = button.getAttribute('data-title');
            const content = button.getAttribute('data-content');
            const description = button.getAttribute('data-description');
            const category = button.getAttribute('data-category');
            const paymentMethod = button.getAttribute('data-payment_method');
            const transactionID = button.getAttribute('data-id-transaction');

            // Isi nilai modal dengan data yang diberikan
            const modal = document.getElementById('editCategoryModal');
            const editCategoryId = modal.querySelector('#editCategoryId');
            const editCategoryUserId = modal.querySelector('#editCategoryUserId');
            const modalTitle = modal.querySelector('#modal-judul');
            const modalTransactionID = modal.querySelector('#modal-transaction-id');
            const modalAmount = modal.querySelector('#modal-amount');
            const modalDescription = modal.querySelector('#modal-description');
            const modalCategory = modal.querySelector('#modal-category');
            const modalPaymentMethod = modal.querySelector('#modal-payment-method');
            const modalFoto = modal.querySelector('#modal-foto');





            let baseUrl = '';
            if (content === 'expenditure') {
                baseUrl = '/storage/reguler_expenditure_attachment/';
            } else {
                baseUrl = '/storage/reguler_income_attachment/';
            }

            // Construct the full URL for the image
            const imageUrl = baseUrl + foto;

            modalTitle.textContent = title;
            modalTransactionID.textContent = transactionID;
            modalAmount.textContent = amount;
            modalDescription.textContent = description;
            modalCategory.textContent = category;
            modalPaymentMethod.textContent = paymentMethod;
            modalFoto.src = imageUrl;



            // Menampilkan modal
            $(modal).modal('show');
        }



        $('#updateNotification').submit(function(event) {
            event.preventDefault();
            var attachment = $('input[name="attachment"]').val();
            console.log('File Attachment: ' + attachment);
            var formData = new FormData(this);
            var id = document.getElementById("modal-transaction-id").textContent;
            console.log(id);


            $.ajax({
                url: '/update/notif/' + id,
                method: 'POST',
                data: formData,
                processData: false, // Jangan memproses data (FormData akan menangani semua)
                contentType: false, //
                beforeSend: function() {
                    $('#loadingIndicator').show();
                },
                success: function(response) {
                    $('#loadingIndicator').hide();
                    toastr.success(
                        'Data berhasil update');
                    location.reload();
                    $('#editCategoryModal').modal('hide');
                },
                error: function(error) {
                    $('#loadingIndicator').hide();
                    if (error.status === 422) {
                        toastr.error('Saldo tidak cukup untuk melakukan transaksi ini', 'Error');
                    } else {
                        alert('Terjadi kesalahan saat menyimpan data.');
                        console.error(error);
                    }
                }
            });
        });


        // $('#updateNotification').submit(function(event) {
        //     event.preventDefault(); // Prevent the default form submission behavior

        //     // Your AJAX code here
        //     const formData = $(this).serialize();
        //     const modalTransactionIdElement = document.getElementById('modal-transaction-id');
        //     const transactionId = modalTransactionIdElement.value;
        //     console.log(formData);

        //     // $.ajax({
        //     //     url: '/update/notif/' + notificationId, // Adjust the URL according to your needs
        //     //     method: 'POST',
        //     //     data: formData,
        //     //     beforeSend: function() {
        //     //         $('#loadingIndicator').show();
        //     //     },
        //     //     success: function(response) {
        //     //         $('#loadingIndicator').hide();
        //     //         alert(response.message);
        //     //         $('#editCategoryModal').modal('hide');
        //     //     },
        //     //     error: function(error) {
        //     //         $('#loadingIndicator').hide();
        //     //         alert('Terjadi kesalahan saat menyimpan data.');
        //     //         console.error(error);
        //     //     }
        //     // });
        // });
    </script>


    <script src="{{ asset('assets/js/script.js') }}"></script>

    @yield('script')

</body>



</html>
