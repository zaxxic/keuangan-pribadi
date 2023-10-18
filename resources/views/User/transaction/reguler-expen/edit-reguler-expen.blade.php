@extends('layouts1.app')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="content-page-header">
                <h5>Tambah Pemasukan Berencana</h5>
            </div>
            <form id="createIncomeForm">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-body">
                            <div class="form-group-item border-0 pb-0">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>Judul</label>
                                            <input type="text" value="{{ $transaction->title }}" name="title"
                                                class="form-control" placeholder="Masukkan judul pemasukan" />
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
                                            <input type="number" value="{{ $transaction->amount }}" name="amount"
                                                class="form-control" placeholder="Masukkan jumlah pemasukkan" />
                                            <span id="amount-error" class="text-danger"></span>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>Metode Pembeyaran</label>
                                            <select name="payment_method" class="select">
                                                <option value="">Pilih Metode Pembayaran</option>
                                                <option value="Debit" @if ($transaction->payment_method == 'Debit') selected @endif>
                                                    Debit</option>
                                                <option value="Cash" @if ($transaction->payment_method == 'Cash') selected @endif>
                                                    Cash</option>
                                                <option value="E-Wallet" @if ($transaction->payment_method == 'E-Wallet') selected @endif>
                                                    E-Wallet</option>
                                            </select>
                                            <span id="payment_method-error" class="text-danger"></span>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>Jenis metode</label>
                                            <select name="recurring" class="select">
                                                <option value="once" @if ($transaction->recurring == 'once') selected @endif>
                                                    Sekali</option>
                                                <option value="weakly" @if ($transaction->recurring == 'weakly') selected @endif>
                                                    Mingguan</option>
                                                <option value="monthly" @if ($transaction->recurring == 'montly') selected @endif>
                                                    Bulanan</option>
                                                <option value="yearly" @if ($transaction->recurring == 'yearly') selected @endif>
                                                    Tahunan</option>
                                            </select>
                                            <span id="recurring-error" class="text-danger"></span>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>Tanggal mulai transaksi</label>
                                            <input type="date" value="{{ $transaction->date }}" name="date"
                                                class="form-control" placeholder="Tanggal Mulai Pembayaran"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" />
                                            <span id="date-error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 description-box">
                                        <div class="form-group" id="summernote_container">
                                            <label class="form-control-label">Deskripsi</label>
                                            <textarea class="form-control" style="height: 180px" name="description" placeholder="Ketikan deskripsi">{{ $transaction->description }}</textarea>
                                            <span id="description-error" class="text-danger"></span>
                                            <span id="count-error" class="text-danger"></span>

                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>Total trnsaksi</label>
                                            <input type="number" value="{{ $transaction->count }}" name="count"
                                                class="form-control" placeholder="Masukkan judul pemasukan" />
                                            <span id="count-error" class="text-danger"></span>

                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="row">

                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>Lampiran</label>
                                            <div class="form-group service-upload mb-0">
                                                @if (!empty($transaction->attachment))
                                                    <img src="{{ asset('storage/reguler_expenditure_attachment/' . $transaction->attachment) }}"
                                                        alt="Lampiran Sebelumnya" />
                                                @else
                                                    <span><img src="{{ asset('assets/img/icons/drop-icon.svg') }}"
                                                            alt="upload" /></span>
                                                    <h6 class="drop-browse align-center">
                                                        Letakan file disini atau
                                                        <span class="text-primary ms-1">browse</span>
                                                    </h6>
                                                @endif
                                                <p class="text-muted">Ukuran maksimal: 50MB</p>
                                                <input type="file" name="attachment" multiple id="image_sign" />
                                                <div id="frames"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="text-end">
                                <a href="{{ Route('reguler-expenditure.index') }}"
                                    class="btn btn-primary cancel me-2">Batal</a>
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
                            <form id="createExpenditureCategoryForm">
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
                    url: "{{ route('reguler-expenditure.update', ['reguler_expenditure' => $transaction->id]) }}",
                    type: 'POST',
                    data: formData,
                    processData: false, // Hindari pemrosesan otomatis data
                    contentType: false, // Hindari pengaturan otomatis tipe konten
                    success: function(response) {

                        toastr.success(
                            'Data berhasil di tambah',
                            'Berhasil');
                        window.location.href = "{{ Route('reguler-expenditure.index') }}";

                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $('.text-danger').text('');
                            $.each(errors, function(field, messages) {
                                var errorMessage = messages[
                                    0]; // Ambil pesan kesalahan pertama
                                $('#' + field + '-error').text(errorMessage);
                            });
                        } else if (xhr.status === 424) {
                            toastr.error(xhr.responseJSON.error, 'Error');
                        }
                    }
                });
            });

            $('#createExpenditureCategoryForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('post-category') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: formData,
                    success: function(response) {
                        var expenditureCategory = response.expenditureCategory;
                        var selectElement = $('#kategori');
                        toastr.success(
                            'Data berhasil di tambah',
                            'Berhasil');

                        selectElement.append('<option value="' + expenditureCategory.id + '">' +
                            expenditureCategory
                            .name + '</option>');

                        $('#tambahModal').modal('hide');

                        $('#createExpenditureCategoryForm')[0].reset();

                        getExpenditureCategories();
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
                    url: "{{ route('get-category') }}",
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var incomeCategories = response.incomeCategories;
                        var selectElement = $('#kategori');

                        selectElement.empty(); // Kosongkan elemen <select>

                        // Tambahkan opsi "Pilih kategori" pertama
                        selectElement.append('<option value="">Pilih kategori</option>');

                        // Simpan nilai category_id dari transaksi dalam variabel
                        var transactionCategoryId = "{{ $transaction->category_id }}";

                        // Tambahkan opsi-opsi kategori pendapatan dari data yang diterima
                        $.each(incomeCategories, function(index, category) {
                            var option = '<option value="' + category.id + '">' +
                                category.name + '</option>';

                            // Jika category_id dari transaksi cocok dengan ID kategori saat ini, maka atur sebagai terpilih
                            if (category.id == transactionCategoryId) {
                                option = '<option value="' + category.id + '" selected>' +
                                    category.name + '</option>';
                            }

                            selectElement.append(option);
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
