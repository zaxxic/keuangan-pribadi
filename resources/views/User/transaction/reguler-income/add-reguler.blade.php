@extends('layouts1.app')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="content-page-header">
                <h5>Tambah Pemasukan Berencana</h5>
            </div>
            <form id="createIncomeForm">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-body">
                            <div class="form-group-item border-0 pb-0">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>Judul</label>
                                            <input type="text" name="title" class="form-control"
                                                placeholder="Masukkan judul pemasukan" />
                                            <span id="title-error" class="text-danger"></span>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <label for="kategori">Kategori</label>
                                                <div class="row">
                                                    <div class="col-10">
                                                        <select name="category_id" class="select" id="kategori">
                                                            <option>Pilih kategori</option>
                                                        </select>
                                                        <span id="category_id-error" class="text-danger"></span>

                                                    </div>
                                                    <div class="col-2">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-target="#tambahModal" data-bs-toggle="modal">
                                                            +
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>Jumlah </label>
                                            <input type="number" name="amount" class="form-control"
                                                placeholder="Masukkan jumlah pemasukkan" />
                                            <span id="amount-error" class="text-danger"></span>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>Metode Pembeyaran</label>
                                            <select name="payment_method" class="select">
                                                <option value="">Pilih Metode Pembayaran</option>
                                                <option value="Debit">Debit</option>
                                                <option value="Cash">Cash</option>
                                                <option value="E-Wallet">E-Wallet</option>
                                            </select>
                                            <span id="payment_method-error" class="text-danger"></span>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>Jenis metode berencana</label>
                                            <select name="recurring" class="select">
                                                <option value="once">Sekali</option>
                                                <option value="daily">Harian</option>
                                                <option value="weekly">Mingguan</option>
                                                <option value="monthly">Bulanan</option>
                                                <option value="yearly">Tahunan</option>
                                            </select>
                                            <span id="recurring-error" class="text-danger"></span>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>Tanggal mulai transaksi</label>
                                            <input type="date" name="date" class="form-control"
                                                placeholder="Tanggal Mulai Pembayaran"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" />
                                            <span id="date-error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 description-box">
                                        <div class="form-group">
                                            <label class="form-control-label">Deskripsi</label>
                                            <textarea class="form-control" name="description" placeholder="Ketikan deskripsi"></textarea>
                                            <span id="description-error" class="text-danger"></span>

                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>Total trnsaksi</label>
                                            <input type="number" name="count" class="form-control"
                                                placeholder="masukan berapa kali trnsaksi ingin di lakukan" />
                                            <span id="count-error" class="text-danger"></span>

                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="row">

                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label>Lampiran</label>
                                        <div class="form-group service-upload mb-0">
                                            <span><img src="{{ asset('assets/img/icons/drop-icon.svg') }}"
                                                    alt="upload" /></span>
                                            <h6 class="drop-browse align-center">
                                                Letakan photo bukti trnasksi 
                                                <span class="text-primary ms-1">disini</span>
                                            </h6>
                                            <p class="text-muted">Ukuran maksimal: 5MB</p>
                                            <input type="file" name="attachment" multiple id="image_sign" />
                                            <div id="frames"></div>
                                        </div>
                                    </div>
                                </div>
                                </div> --}}
                            </div>
                            <div class="text-end">
                                <a href="{{ Route('income.index') }}" class="btn btn-primary cancel me-2">Batal</a>
                                <button type="submit" class="btn btn-primary" id="buttonSave">Simpan</button>
                                <div id="loadingIndicator" style="display: none;">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

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
                            <form id="createIncomeCategoryForm">
                                <input autofocus placeholder="Masukan kategori yang di inginkan" class="form-control"
                                    type="text" name="name">
                                <div class="d-flex mt-3">
                                    <div class="col-6 me-2">
                                        @csrf
                                        <button type="submit"
                                            class="w-100 btn btn-primary paid-continue-btn">Simpan</button>
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
    <script>
        $(document).ready(function() {

            $('#createIncomeForm').submit(function(e) {
                e.preventDefault(); // Mencegah pengiriman formulir biasa

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('reguler-income.store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false, // Hindari pemrosesan otomatis data
                    contentType: false, // Hindari pengaturan otomatis tipe konten
                    success: function(response) {

                        toastr.success(
                            'Data berhasil di tambah',
                            'Berhasil');
                        window.location.href = "{{ Route('reguler-income.index') }}";

                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            // Reset pesan kesalahan sebelum menambahkan yang baru
                            $('.text-danger').text('');
                            $.each(errors, function(field, messages) {
                                var errorMessage = messages[
                                    0]; // Ambil pesan kesalahan pertama
                                $('#' + field + '-error').text(errorMessage);
                            });
                        } else if (xhr.status === 421) {
                            toastr.error(xhr.responseJSON.error, 'Error');
                        } else {
                            toastr.error('Terjadi kesalahan. Silakan coba lagi nanti.',
                                'Error');
                        }
                    }
                });
            });

            $('#createIncomeCategoryForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('store-category') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: formData,
                    success: function(response) {
                        var incomeCategory = response.incomeCategory;
                        var selectElement = $('#kategori');
                        toastr.success(
                            'Data berhasil di tambah',
                            'Berhasil');

                        selectElement.append('<option value="' + incomeCategory.id + '">' +
                            incomeCategory
                            .name + '</option>');

                        $('#tambahModal').modal('hide');

                        $('#createIncomeCategoryForm')[0].reset();

                        getIncomeCategories();
                    },
                    error: function(error) {
                        toastr.error(
                            'Anda tidak memiliki izin untuk mengubah kategori ini',
                            'Error');
                        console.error(error);
                    }
                });
            });

            // Fungsi untuk mengambil kategori pendapatan
            function getIncomeCategories() {
                $.ajax({
                    url: "{{ route('in-category') }}",
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var incomeCategories = response.incomeCategories;
                        var selectElement = $('#kategori');

                        selectElement.empty(); // Kosongkan elemen <select>

                        // Tambahkan opsi "Pilih kategori" pertama
                        selectElement.append('<option value="">Pilih kategori</option>');

                        // Tambahkan opsi-opsi kategori pendapatan dari data yang diterima
                        $.each(incomeCategories, function(index, category) {
                            selectElement.append('<option value="' + category.id + '">' +
                                category
                                .name + '</option>');
                        });
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }

            // Panggil fungsi "get" pertama kali saat halaman dimuat
            getIncomeCategories();
        });



        $(function() {
            $('#stopcheck').on('change', function(e) {

                if (e.target.checked) {
                    $('#tanggalakhir').removeAttr('disabled');
                } else {
                    $('#tanggalakhir').attr('disabled', '');
                    $('#tanggalakhir').val('');
                }
            })
        })
    </script>
@endsection
