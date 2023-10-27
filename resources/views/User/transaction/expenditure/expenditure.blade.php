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
                <h5>Pengeluaran</h5>
                <div class="list-btn">
                    <ul class="filter-list">
                        <li>
                            <div class="input-group" style="max-width: 450px;">

                                <a class="btn btn-primary" href="{{ Route('expenditure.create') }}"><i
                                        class="fa fa-plus-circle me-2" aria-hidden="true"></i>Tambah Pengeluaran</a>
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
                            <table class="table table-stripped table-hover data-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Judul</th>
                                        <th>Tangal</th>
                                        <th>Amount</th>
                                        <th>lampiran</th>
                                        <th>Kategori</th>
                                        <th>Metode pembayaran</th>
                                        <th>Deskripsi</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($transactions as $transaction)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <a href="invoice-details.html"
                                                    class="invoice-link">{{ $transaction->title }}</a>

                                            </td>
                                            <td>{{ $transaction->date }}</td>
                                            <td>{{ $transaction->amount }}</td>
                                            <td>
                                                <button data-bs-target="#modalImage" data-bs-toggle="modal"
                                                    data-bs-image="{{ asset(
                                                        'storage/' .
                                                            ($transaction->source === 'reguler'
                                                                ? 'reguler_expenditure_attachment/'
                                                                : ($transaction->source === 'tabungan'
                                                                    ? 'reguler_expenditure_attachment/'
                                                                    : 'expenditure_attachment/')) .
                                                            $transaction->attachment,
                                                    ) }}"
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
                                                                    href="{{ route('expenditure.edit', $transaction->id) }}">
                                                                    <i class="far fa-edit me-2"></i>Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item delete-income" href="#"
                                                                    data-id="{{ $transaction->id }}"
                                                                    data-route="{{ route('expenditure.destroy', $transaction->id) }}"
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
                                    @endforeach --}}
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
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('expenditure.index') }}",
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
                    data: 'attachment',
                    name: 'attachment',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return data;
                    }
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
        $('#attachmentImage').attr('src', imageUrl);
    });
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
</script>
<script>
    $(document).on('click', '.delete-expenditure', function(e) {
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
                            'Pengeluaran berhasil hapus',
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
