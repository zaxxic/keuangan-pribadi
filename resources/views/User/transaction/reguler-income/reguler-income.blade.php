@extends('layouts1.app')
@section('content')
@section('style')
    <style>
        #attachmentImage {
            transition: filter 0.3s;
        }

        #attachmentImage:hover {
            filter: brightness(70%);
            /* Mengurangi kecerahan gambar ketika dihover */
            cursor: pointer;
            /* Mengubah kursor menjadi pointer */
        }

        #downloadIcon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 24px;
            color: white;
            display: none;
            /* Sembunyikan ikon download secara default */
        }
    </style>
@endsection
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="content-page-header">
                <h5>Pemasukan Berencana</h5>
                <div class="list-btn">
                    <ul class="filter-list">
                        <li>
                            <div class="input-group" style="max-width: 450px;">

                                <a class="btn btn-primary" href="{{ Route('reguler-income.create') }}"><i
                                        class="fa fa-plus-circle me-2" aria-hidden="true"></i>Tambah Pemasukan</a>
                            </div>
                        </li>


                    </ul>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-sm-12">
                <div class="card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-stripped table-hover dataTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Judul</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah</th>
                                        <th>Transaksi</th>
                                        <th>Berulang</th>
                                        <th>Mode pembayaran</th>
                                        <th>Kategori</th>
                                        <th>Deskripsi</th>

                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="modalImageEmptyAttachment" tabindex="-1" aria-labelledby="modalImageEmptyAttachmentLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImageEmptyAttachmentLabel">Gambar Lampiran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tidak ada gambar di lampiran ini.
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalImage" tabindex="-1" aria-labelledby="modalImageLabel" aria-hidden="true">
    <div class="modal-dialog d-flex align-items-center">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImageEmptyAttachmentLabel">Gambar Lampiran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="attachmentImage" class="img-fluid">
            </div>
            <div class="modal-footer">
                <a id="downloadLink" href="#" class="btn btn-primary" download>Download</a>
            </div>
        </div>
    </div>
</div>




@endsection
@section('script')
<script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
<script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('reguler-income.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'date',
                    name: 'date',
                 },
                {
                    data: 'amount',
                    name: 'amount',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'transaction_count',
                    name: 'transaction_count',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'recurring',
                    name: 'recurring',
                    searchable: false,
                },

                {
                    data: 'payment_method',
                    name: 'payment_method',
                    searchable: false,
                },
                {
                    data: 'category.name',
                    name: 'category.name'
                },
                {
                    data: 'description',
                    name: 'description',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-end'
                },
            ],
            "columnDefs": [{
                    "width": "15%",
                    "targets": 1
                }, // Judul
                {
                    "width": "10%",
                    "targets": 2
                }, // Tanggal
                {
                    "width": "10%",
                    "targets": 3
                }, // Jumlah
                {
                    "width": "15%",
                    "targets": 4
                }, // Bukti
                {
                    "width": "10%",
                    "targets": 5
                }, // Mode pembayaran
                {
                    "width": "10%",
                    "targets": 6
                }, // Kategori
                {
                    "width": "15%",
                    "targets": 7
                }, // Deskripsi
                {
                    "width": "10%",
                    "targets": 8
                } // Action
            ],
            "order": [
                [0, 'desc']
            ] // Order by ID column in descending order by default
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.data-table').on('click', '.show-more-link', function() {
            var descriptionContainer = $(this).closest('.description-container');
            var descriptionText = descriptionContainer.find('.description-text');
            var descriptionFull = descriptionContainer.find('.description-full');

            if (descriptionFull.is(':hidden')) {
                descriptionText.hide();
                descriptionFull.show();
                $(this).text('Tutup');
            } else {
                descriptionFull.hide();
                descriptionText.show();
                $(this).text('Selengkapnya');
            }
        });
    });
    $(document).on('click', 'button[data-bs-target="#modalImage"]', function() {
        var imageUrl = $(this).data('bs-image');
        console.log(imageUrl);
        $('#attachmentImage').attr('src', imageUrl);
    });
    // Tampilkan ikon download saat gambar dihover
    $('#attachmentImage').hover(function() {
        $('#downloadIcon').show();
    }, function() {
        $('#downloadIcon').hide();
    });

    // Fungsi untuk mengunduh gambar saat gambar diklik
    $('#attachmentImage').click(function() {
        var imgSrc = $(this).attr('src');
        var fileName = $(this).data('filename'); // Ambil nama file dari atribut data
        var link = document.createElement('a');
        link.href = imgSrc;
        link.download = 'Attachment'; // Gunakan nama file dari atribut data
        link.click();
    });

    function showDescription(iteration) {
        var description = document.getElementById('description' + iteration);
        var fullDescription = document.getElementById('fullDescription' + iteration);
        var readMoreLink = document.getElementById('readMoreLink' + iteration);

        if (description.style.display === 'none') {
            description.style.display = 'inline';
            fullDescription.style.display = 'none';
            readMoreLink.innerHTML = 'Selangkapnya';
        } else {
            description.style.display = 'none';
            fullDescription.style.display = 'inline';
            readMoreLink.innerHTML = 'Tutup';
        }
    }

    // search by all
    // $("#searchCategory").on("keyup", function() {
    //     var value = $(this).val().toLowerCase();
    //     $("table tbody tr").filter(function() {
    //         $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    //     });
    // });

    $("#searchCategory").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("table tbody tr").filter(function() {
            // Mengambil teks dari kolom dengan class "invoice-link"
            var title = $(this).find(".invoice-link").text().toLowerCase();
            // Memeriksa apakah teks dalam kolom mengandung nilai pencarian
            $(this).toggle(title.indexOf(value) > -1);
        });
    });
</script>

<script>
    $(document).on('click', '.delete-income', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var route = $(this).data('route');
        var count = $(this).data('count'); // Mendapatkan nilai count dari elemen HTML

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: count > 0 ? 'Transaksi masih ada. Apakah Anda yakin ingin menghapusnya?' :
                'Anda tidak akan dapat mengembalikan ini!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: route,
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // Tutup modal
                        toastr.success(
                            'Pemasukan berhasil dihapus',
                            'Sukses');

                        location.reload();

                    },
                    error: function(error) {
                        if (error.status === 403) {
                            toastr.error(
                                'Anda tidak memiliki izin untuk menghapus kategori ini',
                                'Error');
                        } else {
                            toastr.error('Terjadi kesalahan saat menghapus kategori',
                                'Error');
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
