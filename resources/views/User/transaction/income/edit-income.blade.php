@extends('layouts1.app')
@section('content')
<div class="page-wrapper">
  <div class="content container-fluid">
    <div class="content-page-header">
      <h5>Edit Pemasukan</h5>
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
                    <input value="{{ $transaction->title }}" type="text" name="title" class="form-control" placeholder="Masukkan judul pemasukan" />
                    <span id="title-error" class="text-danger"></span>

                  </div>
                  <div class="form-group">
                    <label>Jumlah </label>
                    <input value="{{ $transaction->amount }}" type="number" name="amount" class="form-control" placeholder="Masukkan jumlah pemasukkan" />
                    <span id="amount-error" class="text-danger"></span>

                  </div>
                  <div class="form-group">
                    <label>Tanggal</label>
                    <input value="{{ $transaction->date }}" type="date" name="date" class="form-control" placeholder="Tanggal Mulai Pembayaran" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" />
                    <span id="date-error" class="text-danger"></span>
                  </div>
                  <div class="form-group" id="summernote_container">
                    <label class="form-control-label">Deskripsi</label>
                    <textarea class="form-control" name="description" placeholder="Ketikan deskripsi">{{ $transaction->description }}</textarea>
                  </div>
                </div>

                <div class="col-lg-6 col-md-12 col-sm-12">
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
                        <button type="button" class="btn btn-secondary" data-bs-target="#tambahModal" data-bs-toggle="modal">
                          +
                        </button>
                      </div>
                    </div>
                  </div>
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
                  <div class="form-group">
                    <label>Lampiran</label>
                    <div class="form-group service-upload mb-0">
                      @if (!empty($transaction->attachment))
                      <img src="{{ asset('storage/income_attachment/' . $transaction->attachment) }}" alt="Lampiran Sebelumnya" />
                      @else
                      <span><img src="{{ asset('assets/img/icons/drop-icon.svg') }}" alt="upload" /></span>
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

              </div>
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
              <input autofocus placeholder="Masukan kategori yang di inginkan" class="form-control" type="text" name="name">
              <div class="d-flex mt-3">
                <div class="col-6 me-2">
                  @csrf
                  <button type="submit" class="w-100 btn btn-primary paid-continue-btn">Simpan</button>
                </div>
                <div class="col-6">
                  <button type="button" data-bs-dismiss="modal" class="w-100 btn btn-primary paid-cancel-btn">Batal</button>
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
                    url: "{{ route('income.update', ['income' => $transaction->id]) }}",
                    type: 'POST',
                    data: formData,
                    processData: false, // Hindari pemrosesan otomatis data
                    contentType: false, // Hindari pengaturan otomatis tipe konten
                    success: function(response) {

                        toastr.success(
                            'Data berhasil di tambah',
                            'Berhasil');
                        window.location.href = "{{ Route('income.index') }}";

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

            // Panggil fungsi "getIncomeCategories" pertama kali saat halaman dimuat
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
