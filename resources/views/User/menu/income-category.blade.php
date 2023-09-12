@extends('layouts1.app')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="row">
                <div class="col-xl-3 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="content-page-header">
                                    <h5>Settings</h5>
                                </div>
                            </div>

                            <div class="widget settings-menu mb-0">
                                <ul>
                                    <li class="nav-item">
                                        <a href="{{ Route('setting') }}" class="nav-link">
                                            <i class="fe fe-user"></i> <span>Account Settings</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ Route('income_category.index') }}" class="nav-link active">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                                viewBox="0 0 32 32">
                                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4h6v6H4zm10 0h6v6h-6zM4 14h6v6H4zm10 3a3 3 0 1 0 6 0a3 3 0 1 0-6 0" />
                                            </svg> <span>Kategori Pemasukan</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ Route('expenditure_category.index') }}" class="nav-link">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                                viewBox="0 0 32 32">
                                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4h6v6H4zm10 0h6v6h-6zM4 14h6v6H4zm10 3a3 3 0 1 0 6 0a3 3 0 1 0-6 0" />
                                            </svg> <span>Kategori Pengeluaran</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-md-8">
                    <div class="content w-100 pt-0">
                        <div class="d-flex justify-content-between mb-3">
                            <h5>Pemasukan kategori</h5>
                            <button class="btn btn-primary" data-bs-target="#tambahModal" data-bs-toggle="modal"><i
                                    class="fa fa-plus-circle me-2" aria-hidden="true"></i> Tambah
                                Kategori </button>

                        </div>
                        <div class="card-table">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-stripped table-hover datatable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>Tanggal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($incomeCategories as $index => $category)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $category->name }}</td>
                                                    <td>{{ $category->created_at->toDateString() }}</td>
                                                    <td class="d-flex align-items-center">
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="btn-action-icon"
                                                                data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                    class="fas fa-ellipsis-v"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <ul>
                                                                    <li><a class="dropdown-item edit-category-modal"
                                                                            href="#" data-id="{{ $category->id }}"
                                                                            data-name="{{ $category->name }}"
                                                                            data-route="{{ route('income_category.update', $category->id) }}"
                                                                            data-user-id="{{ $category->user_id }}"><i
                                                                                class="far fa-edit me-2 btn-action-icon"></i>Edit</a>
                                                                    </li>

                                                                    <li> <a class="dropdown-item delete-category"
                                                                            href="#" data-id="{{ $category->id }}"
                                                                            data-route="{{ route('income_category.destroy', $category->id) }}"
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
    </div>


    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Kategori Pendapatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm">
                        <input type="hidden" id="editCategoryId" name="id">
                        <input type="hidden" id="editCategoryUserId" name="user_id">

                        <div class="mb-3">
                            <label for="editCategoryName" class="form-label">Nama Kategori:</label>
                            <input type="text" class="form-control" id="editCategoryName" name="name">
                        </div>

                        <div class="d-flex mt-3">
                            <div class="col-6 me-2">
                                <button id="updateCategoryBtn"
                                    class="w-100 btn btn-primary paid-continue-btn">Simpan</button>
                                <div id="loadingIndicator" style="display: none;">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <button type="button" data-bs-dismiss="modal"
                                    class="w-100 btn btn-primary paid-cancel-btn">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- <button type="button" class="btn btn-primary paid-cancel-btn me-3" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" id="updateCategoryBtn">Simpan Perubahan</button> --}}

    <div class="modal custom-modal fade" id="tambahModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Tambah Kategori</h3>
                        <p>Masukan kategori yang di inginkan </p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <form id="addIncomeCategoryForm">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" id="deleteCategoryRoute" name="route">
                                <input name="name" autofocus placeholder="Masukan kategori yang di iginkan"
                                    class="form-control" type="text">
                                <div class="d-flex mt-3">
                                    <div class="col-6 me-2">
                                        <button type="submit" id="saveButton"
                                            class="w-100 btn btn-primary paid-continue-btn">Simpan</button>
                                        <div id="loadingIndicator" style="display: none;">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" data-bs-dismiss="modal"
                                            class="w-100 btn btn-primary paid-cancel-btn">Batal</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
    <script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>
    <script>
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        $('.edit-category-modal').click(function() {
            var categoryId = $(this).data('id');
            var categoryName = $(this).data('name');
            var userId = $(this).data('user-id');
            var route = $(this).data('route');

            // Isi nilai dalam modal
            $('#editCategoryId').val(categoryId);
            $('#editCategoryName').val(categoryName);
            $('#editCategoryUserId').val(userId);
            $('#deleteCategoryRoute').val(route);
            // Tampilkan modal
            $('#editCategoryModal').modal('show');
        });

        $('#updateCategoryBtn').click(function() {
            var categoryId = $('#editCategoryId').val();
            var categoryName = $('#editCategoryName').val();
            var userId = $('#editCategoryUserId').val();
            var route = $('#deleteCategoryRoute').val(); // Ambil route dari input tersembunyi

            $('#updateCategoryBtn').html('Loading...');
            $('#updateCategoryBtn').prop('disabled', true);
            // Kirim permintaan ajax untuk mengupdate data kategori
            $.ajax({
                url: route, // Gunakan route yang diambil dari input tersembunyi
                type: 'PUT', // Gunakan metode PUT
                data: {
                    id: categoryId,
                    name: categoryName,
                    user_id: userId,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    // Tutup modal
                    $('#editCategoryModal').modal('hide');
                    toastr.success(
                        'Kategori pendapatan berhasil dihapus',
                        'Sukses');

                    location
                        .reload();

                    // Refresh halaman atau lakukan tindakan lain yang diperlukan
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });



        $('#addIncomeCategoryForm').submit(function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $('#saveButton').html('Loading...');
            $('#saveButton').prop('disabled', true);

            $.ajax({
                type: 'POST',
                url: "{{ route('income_category.store') }}",
                data: formData,
                success: function(response) {
                    $('#tambahModal').modal('hide');
                    toastr.success(
                        'Data berhasil ditambahkan');
                    location.reload();
                },
                error: function(error) {
                    toastr.error('Permintaan gagal');
                    console.log(error.responseText);
                },
                complete: function() {
                    $('#saveButton').html('Simpan');
                    $('#saveButton').prop('disabled', false);

                    $('#loadingIndicator').hide();
                }
            });
        });

        $('.delete-category').on('click', function(e) {
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
                            if (response.success) {
                                toastr.success(
                                    'Kategori pendapatan berhasil dihapus',
                                    'Sukses');

                                location
                                    .reload(); // Reload halaman setelah penghapusan
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
