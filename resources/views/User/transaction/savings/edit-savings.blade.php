@extends('layouts1.app')
@section('content')
<div class="page-wrapper">
  <div class="content container-fluid">
    <div class="page-header">
      <div class="content-page-header">
        <h5>Edit Tabungan</h5>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <form id="editSavingForm">
          @csrf
          @method('PUT')
          <div class="card-body">
            <div class="form-group-item">
              <h5 class="form-title">Pilih foto untuk card</h5>
              <label for="photo1"><img src="{{ asset('assets/img/Savings1.png') }}" width="189px" alt="Photo 1"></label>
              <input type="radio" id="photo1" name="cover" value="Savings1.png" {{ ($saving->cover == 'Savings1.png') ? 'checked' : '' }}>

              <label for="photo2"><img src="{{ asset('assets/img/savings2.png') }}" width="189px" alt="Photo 2"></label>
              <input type="radio" id="photo2" name="cover" value="savings2.png" {{ ($saving->cover == 'savings2.png') ? 'checked' : '' }}>

              <label for="photo3"><img src="{{ asset('assets/img/savings3.png') }}" width="189px" alt="Photo 3"></label>
              <input type="radio" id="photo3" name="cover" value="savings3.png" {{ ($saving->cover == 'savings3.png') ? 'checked' : '' }}>

              <label for="photo4"><img src="{{ asset('assets/img/savings4.png') }}" width="189px" alt="Photo 4"></label>
              <input type="radio" id="photo4" name="cover" value="savings4.png" {{ ($saving->cover == 'savings4.png') ? 'checked' : '' }}>

              <label for="photo5"><img src="{{ asset('assets/img/savings5.png') }}" width="189px" alt="Photo 5"></label>
              <input type="radio" id="photo5" name="cover" value="savings5.png" {{ ($saving->cover == 'savings5.png') ? 'checked' : '' }}>
            </div>

            <div class="form-group-item">
              <div class="row">
                <div class="col-md-6">
                  <div class="billing-btn mb-2">
                    <h5 class="form-title">Data</h5>
                  </div>
                  <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="title" class="form-control" placeholder="Judul tabungan" value="{{ $saving->title }}" />
                    <span id="title-error" class="text-danger"></span>
                  </div>
                  <div class="form-group">
                    <label>Target</label>
                    <input type="number" name="target_balance" class="form-control" placeholder="Target tabungan" value="{{ $saving->target_balance }}" />
                    <span id="target_balance-error" class="text-danger"></span>
                  </div>
                  <div class="form-group">
                    <label class="form-control-label">Deskripsi</label>
                    <textarea class="form-control" name="description" placeholder="Ketikan deskripsi">{{ $saving->description }}</textarea>
                    <span id="description-error" class="text-danger"></span>
                  </div>

                </div>
                <div class="col-md-6">
                  <div class="billing-btn mb-2">
                    <h5 style="color: #f7f8f9" class="form-title">a</h5>
                  </div>
                  <div class="form-group">
                    <label>Tanggal mulai transaksi</label>
                    <input type="date" name="date" class="form-control" placeholder="Tanggal Mulai Pembayaran" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $saving->regular->date }}" />
                    <span id="date-error" class="text-danger"></span>
                  </div>
                  <div class="form-group">
                    <div class="form-group">
                      <label>Metode Pembayaran</label>
                      <select name="payment_method" class="select">
                        <option value="">Pilih Metode Pembayaran</option>
                        <option value="Debit" {{ ($saving->regular->payment_method == 'Debit') ? 'selected' : '' }}>Debit</option>
                        <option value="Cash" {{ ($saving->regular->payment_method == 'Cash') ? 'selected' : '' }}>Cash</option>
                        <option value="E-Wallet" {{ ($saving->regular->payment_method == 'E-Wallet') ? 'selected' : '' }}>E-Wallet</option>
                      </select>
                      <span id="payment_method-error" class="text-danger"></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-group">
                      <label>Jenis Metode</label>
                      <select name="recurring" class="select">
                        <option value="week"{{ ($saving->regular->recurring == 'week') ? 'selected' : '' }}>Mingguan</option>
                        <option value="month">{{ ($saving->regular->recurring == 'month') ? 'selected' : '' }}Bulanan</option>
                        <option value="year"{{ ($saving->regular->recurring == 'year') ? 'selected' : '' }}>Tahunan</option>
                      </select>
                      <span id="recurring-error" class="text-danger"></span>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" name="amount" class="form-control" placeholder="Saldo yang diambil" value="{{ $saving->regular->amount }}" />
                    <span id="amount-error" class="text-danger"></span>
                  </div>

                </div>
              </div>
            </div>

            <div class="add-customer-btns text-end">
              <a href="{{ route('savings.index') }}" class="btn customer-btn-cancel">Kembali</a>
              <button type="submit" class="btn customer-btn-save">Ubah</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
  $(function(){
    $('#editSavingForm').submit(function(e) {
      e.preventDefault(); // Mencegah pengiriman formulir biasa

      let formData = new FormData(this);

      $.ajax({
        url: "{{ route('savings.update', $saving->id) }}",
        type: 'POST',
        data: formData,
        processData: false, // Hindari pemrosesan otomatis data
        contentType: false, // Hindari pengaturan otomatis tipe konten
        success: function(response) {
          console.log(response.responseJSON);
          toastr.success('Tabungan berhasil di ubah', 'Berhasil');
          window.location.href = "{{ route('savings.index') }}";
        },
        error: function(xhr) {
          if (xhr.status === 422) {
            let errors = xhr.responseJSON.errors;
            // Reset pesan kesalahan sebelum menambahkan yang baru
            $('.text-danger').text('');
            $.each(errors, function(field, messages) {
              let errorMessage = messages[0]; // Ambil pesan kesalahan pertama
              $('#' + field + '-error').text(errorMessage);
            });
          }
        }
      });
    });
  });
</script>
@endsection
