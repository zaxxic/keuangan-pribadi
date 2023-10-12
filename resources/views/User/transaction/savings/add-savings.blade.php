@extends('layouts1.app')
@section('content')
<script>
  function addInput() {
    var container = document.getElementById("inputContainer");
    var inputGroup = document.createElement("div");
    inputGroup.className = "input-group mb-3";

    var input = document.createElement("input");
    input.type = "email";
    input.className = "form-control";
    input.placeholder = "Masukkan email teman Anda";

    // Mengganti nama input dengan array yang dinamis
    var inputName = "inviteEmail[" + (container.children.length + 1) + "]";
    input.name = inputName;

    var inputGroupAppend = document.createElement("div");
    inputGroupAppend.className = "input-group-append";

    var removeButton = document.createElement("button");
    removeButton.type = "button";
    removeButton.className = "btn btn-danger btn-sm";
    removeButton.textContent = "Hapus";
    removeButton.addEventListener("click", function() {
        container.removeChild(inputGroup);
    });

    inputGroupAppend.appendChild(removeButton);
    inputGroup.appendChild(input);
    inputGroup.appendChild(inputGroupAppend);

    container.appendChild(inputGroup);
  }
</script>
<div class="page-wrapper">
  <div class="content container-fluid">
    <div class="page-header">
      <div class="content-page-header">
        <h5>Tambah Tabungan</h5>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <form id="createSavingForm">
          @csrf
          <div class="card-body">
            <h5 class="form-title">Pilih foto untuk card</h5>
            <div class=" d-flex">
              <div class="d-flex flex-column">
                <label for="photo1"><img src="{{ asset('assets/img/Savings1.png') }}" width="189px" alt="Photo 1"></label>
                <input checked type="radio" id="photo1" name="cover" value="Savings1.png">
              </div>

              <div class="d-flex flex-column">
                <label for="photo2"><img src="{{ asset('assets/img/savings2.png') }}" width="189px" alt="Photo 2"></label>
                <input type="radio" id="photo2" name="cover" value="savings2.png">
              </div>

              <div class="d-flex flex-column">
                <label for="photo3"><img src="{{ asset('assets/img/savings3.png') }}" width="189px" alt="Photo 3"></label>
                <input type="radio" id="photo3" name="cover" value="savings3.png">
              </div>

              <div class="d-flex flex-column">
                <label for="photo4"><img src="{{ asset('assets/img/savings4.png') }}" width="189px" alt="Photo 4"></label>
                <input type="radio" id="photo4" name="cover" value="savings4.png">
              </div>

              <div class="d-flex flex-column">
                <label for="photo5"><img src="{{ asset('assets/img/savings5.png') }}" width="189px" alt="Photo 5"></label>
                <input type="radio" id="photo5" name="cover" value="savings5.png">
              </div>
            </div>

            <div class="form-group-item">
              <div class="row">
                <div class="col-md-6">
                  <div class="billing-btn mb-2">
                    <h5 class="form-title">Data</h5>
                  </div>
                  <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="title" class="form-control" placeholder="Judul tabungan" />
                    <span id="title-error" class="text-danger"></span>
                  </div>
                  <div class="form-group">
                    <label>Target</label>
                    <input type="number" name="target_balance" class="form-control" placeholder="Target tabungan" />
                    <span id="target_balance-error" class="text-danger"></span>
                  </div>
                  <div class="form-group">
                    <label class="form-control-label">Deskripsi</label>
                    <textarea class="form-control" name="description" placeholder="Ketikan deskripsi"></textarea>
                    <span id="description-error" class="text-danger"></span>
                  </div>

                  <div class="form-group">
                    <label>Email yang anda ingin ajak ( opsional ) </label>
                    <div id="inputContainer">
                      <!-- Input dinamis akan ditambahkan di sini -->
                    </div>
                    <button type="button" class="btn btn-primary btn-sm" onclick="addInput()">Tambah
                      Input</button>
                  </div>

                </div>
                <div class="col-md-6">
                  <div class="billing-btn mb-2">
                    <h5 style="color: #f7f8f9" class="form-title">a</h5>
                  </div>
                  <div class="form-group">
                    <label>Tanggal mulai transaksi</label>
                    <input type="date" name="date" class="form-control" placeholder="Tanggal Mulai Pembayaran" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" />
                    <span id="date-error" class="text-danger"></span>
                  </div>
                  <div class="form-group">
                    <div class="form-group">
                      <label>Metode Pembayaran</label>
                      <select name="payment_method" class="select">
                        <option value="">Pilih Metode Pembayaran</option>
                        <option value="Debit">Debit</option>
                        <option value="Cash">Cash</option>
                        <option value="E-Wallet">E-Wallet</option>
                      </select>
                      <span id="payment_method-error" class="text-danger"></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-group">
                      <label>Jenis Metode</label>
                      <select name="recurring" class="select">
                        <option value="week">Mingguan</option>
                        <option value="month">Bulanan</option>
                        <option value="year">Tahunan</option>
                      </select>
                      <span id="recurring-error" class="text-danger"></span>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" name="amount" class="form-control" placeholder="Saldo yang diambil" />
                    <span id="amount-error" class="text-danger"></span>
                  </div>

                </div>
              </div>
            </div>

            <div class="add-customer-btns text-end">
              <a href="{{ route('savings.index') }}" class="btn customer-btn-cancel">Kembali</a>
              <button type="submit" class="btn customer-btn-save">Tambah</button>
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
    $('#createSavingForm').submit(function(e) {
      e.preventDefault(); // Mencegah pengiriman formulir biasa
      let button = e.target.querySelector("button[type=submit]");
      button.innerHTML = /*html*/ `<span class="spinner-border spinner-border-sm me-2"></span> Menyimpan...`
      button.setAttribute("disabled", "");

      let formData = new FormData(this);

      $.ajax({
        url: "{{ route('savings.store') }}",
        type: 'POST',
        data: formData,
        processData: false, // Hindari pemrosesan otomatis data
        contentType: false, // Hindari pengaturan otomatis tipe konten
        success: function(response) {
          console.log(response.responseJSON);
          toastr.success('Tabungan berhasil di tambah', 'Berhasil');
          window.location.href = "{{ route('savings.index') }}";
        },
        error: function(xhr) {
          if (xhr.status === 422) {
            if(xhr.responseJSON.message){
              toastr.error(xhr.responseJSON.message, 'Gagal');
            } else {
              let errors = xhr.responseJSON.errors;
              // Reset pesan kesalahan sebelum menambahkan yang baru
              $('.text-danger').text('');
              $.each(errors, function(field, messages) {
                let errorMessage = messages[0]; // Ambil pesan kesalahan pertama
                $('#' + field + '-error').text(errorMessage);
              });
            }
            button.innerHTML = /*html*/ `Tambah`
            button.removeAttribute("disabled");
          }
        }
      });
    });
  });
</script>
@endsection
