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
                                <input type="text" class="form-control" placeholder="Cari Pemasukan"
                                    id="searchCategory">
                                <a class="btn btn-primary" href="{{ Route('reguler_income.create') }}"><i
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
                            <table class="table table-stripped table-hover datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Judul</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah</th>
                                        <th>Transaksi</th>
                                        <th>Berulang</th>
                                        <th>Bukti</th>
                                        <th>Mode pembayaran</th>
                                        <th>Kategori</th>
                                        <th>Deskripsi</th>

                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach ($transactions as $transaction)

                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <a href="invoice-details.html"
                                                    class="invoice-link">{{ $transaction->title }}</a>

                                            </td>
                                            <td>{{ $transaction->date }}</td>
                                            <td>{{ $transaction->amount }}</td>
                                            <td>{{ $transaction->count }}</td>
                                            <td>{{ $transaction->recurring }}</td>
                                            <td>
                                                <button data-bs-target="#modalImage" data-bs-toggle="modal"
                                                    data-bs-image="{{ asset('storage/reguler_income_attachment/' . $transaction->attachment) }}"
                                                    class="btn btn-primary">Lihat</button>
                                            </td>
                                            <td>{{ $transaction->payment_method }}</td>
                                            <td>{{ $transaction->category->name }}</td>
                                            <td>
                                                @if (strlen($transaction->description) > 60)
                                                    <span
                                                        id="description{{ $loop->iteration }}">{{ substr($transaction->description, 0, 60) }}</span>
                                                    <a href="javascript:void(0);"
                                                        onclick="showDescription({{ $loop->iteration }})"
                                                        id="readMoreLink{{ $loop->iteration }}">Selengkapnya</a>
                                                    <span id="fullDescription{{ $loop->iteration }}"
                                                        style="display:none;">{{ $transaction->description }}</span>
                                                @else
                                                    {{ $transaction->description }}
                                                @endif
                                            </td>
                                            <td class="d-flex align-items-center">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="btn-action-icon" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <ul>
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('reguler_income.edit', $transaction->id) }}">
                                                                    <i class="far fa-edit me-2"></i>Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item delete-income" href="#"
                                                                    data-id="{{ $transaction->id }}"
                                                                    data-route="{{ route('reguler_income.destroy', $transaction->id) }}"
                                                                    data-toggle="modal"
                                                                    data-target="#deleteCategoryModal">
                                                                    <i class="far fa-trash-alt me-2"></i>Delete
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>




<div class="modal fade" id="modalImage" tabindex="-1" aria-labelledby="modalImageLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImageLabel">Gambar Attachment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($transactions->count() > 0)
                    @php
                        $transaction = $transactions->first();
                    @endphp
                    <img id="attachmentImage"
                        src="{{ asset('storage/reguler_income_attachment/' . $transaction->attachment) }}" alt="Attachment"
                        data-filename="{{ $transaction->attachment }}">
                @else
                    <!-- Tambahkan kode atau pesan yang ingin Anda tampilkan jika tidak ada transaksi -->
                    <p>Tidak ada transaksi yang tersedia.</p>
                @endif
                <i id="downloadIcon" class="fas fa-download"></i>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
<script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>
<script>
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

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak akan dapat mengembalikan ini!",
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
                            'Pemasukan berhasil hapus',
                            'Sukses');

                        location
                            .reload();

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
