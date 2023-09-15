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
                  <a href="{{ Route('setting') }}" class="nav-link active">
                    <i class="fe fe-user"></i> <span>Account Settings</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ Route('income_category.index') }}" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 32 32">
                      <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h6v6H4zm10 0h6v6h-6zM4 14h6v6H4zm10 3a3 3 0 1 0 6 0a3 3 0 1 0-6 0" />
                    </svg> <span>Kategori Pemasukan</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ Route('expenditure_category.index') }}" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 32 32">
                      <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h6v6H4zm10 0h6v6h-6zM4 14h6v6H4zm10 3a3 3 0 1 0 6 0a3 3 0 1 0-6 0" />
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
          <div class="content-page-header">
            <h5>Account Settings</h5>
          </div>
          <form id="update-profile-form" action="{{ Route('profile.update') }}">
            @csrf
            @method('PUT')
            <div class="row">
              <h5 class="mb-2">Ganti informasi pribadi</h5>

              <div class="profile-picture">
                <div class="upload-profile me-2">
                  <div class="profile-img">
                    <img id="blah" class="avatar" src="{{ asset('storage/profile/' . Auth::user()->image) }}" alt="User Photo">
                  </div>
                </div>
                <div class="img-upload">
                  <label class="btn btn-primary">
                    Ganti Profile <input type="file" name="image" id="fileInput" accept="image/*" style="display: none;" />
                  </label>
                </div>

                <p class="mt-1">
                  Profile minimal 5Mb
                </p>
              </div>

              <div class="col-lg-6 col-12">
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" class="form-control" placeholder="Enter Email Address" name="email" value="{{ Auth::user()->email }}" />
                </div>
              </div>

              <div class="col-lg-6 col-12">
                <div class="form-group mb-0">
                  <label>Gender</label>
                  <select name="gender" class="select">
                    <option value="none">Pilih Jeis Kelamain</option>
                    <option value="male" {{ Auth::user()->gender === 'male' ? 'selected' : '' }}>
                      Laki Laki</option>
                    <option value="female" {{ Auth::user()->gender === 'female' ? 'selected' : '' }}>Perempuan</option>
                    <!-- Menampilkan gender pengguna yang sedang masuk sebagai nilai default -->
                  </select>
                </div>
              </div>

              <div class="col-lg-6 col-12">
                <div class="form-group">
                  <label>Tanggal ulang tahun</label>

                  <input type="date" class="form-control" name="birthday" placeholder="Pilih tanggal" value="{{ Auth::user()->birthday }}" />

                </div>
              </div>
              <div class="col-lg-6 col-12 mt-4">
                <div class="btn-path">
                  <button type="submit" id="saveButton1" class="w-100 btn btn-primary paid-continue-btn">Simpan</button>
                  <div id="loadingIndicator" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>


          <form id="update-password-form" action="{{ Route('password.update') }}">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="col-lg-12">
                <div class="form-title">
                  <h5>Ganti Password</h5>
                </div>
              </div>

              <div class="col-lg-6 col-12">
                <div class="form-group">
                  <label>Masukkan passwrd lama</label>
                  <input type="Password" class="form-control" name="current_password" placeholder="Masuukan password lama" />
                </div>
              </div>

              <div class="col-lg-6 col-12">
                <div class="form-group">
                  <label>Masukkan Password</label>
                  <input type="Password" class="form-control" name="new_password" placeholder="Masukkan password baru" />
                </div>
              </div>


              <div class="col-lg-6 col-12">
                <div class="form-group">
                  <label>Masukkan Konfirmasi password</label>
                  <input type="Password" class="form-control" name="new_password_confirmation" placeholder="Konfirmasi password" />
                </div>
              </div>
              <div class="col-lg-6 col-12 mt-4">
                <div class="btn-path">
                  <button type="submit" id="saveButton" class="w-100 btn btn-primary paid-continue-btn">Simpan</button>
                  <div id="loadingIndicator" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script>
  $('#update-profile-form').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            $('#saveButton1').html('Loading...');
            $('#saveButton1').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success('Informasi pribadi berhasil diperbarui.', 'Sukses');
                        location.reload();
                    } else if (response.error) {
                        var errorMessage = response.error.replace(/^"(.*)"$/, '$1');
                        toastr.error(errorMessage, 'Kesalahan Validasi');
                        $('#saveButton1').html('Simpan');
                        $('#saveButton1').prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        var errorMessage = xhr.responseText.replace(/^"(.*)"$/, '$1');
                        toastr.error(errorMessage, 'Kesalahan Validasi');
                        $('#saveButton1').html('Simpan');
                        $('#saveButton1').prop('disabled', false);
                    } else {
                        toastr.error('Terjadi kesalahan: ' + error, 'Kesalahan');
                        $('#saveButton1').html('Simpan');
                        $('#saveButton1').prop('disabled', false);
                    }
                }
            });



        });

        $('#update-password-form').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            $('#saveButton').html('Loading...');
            $('#saveButton').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success('Password berhasil diperbarui.', 'Sukses');
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        var errorMessage = xhr.responseText.replace(/^"(.*)"$/, '$1');
                        toastr.error(errorMessage, 'Kesalahan Validasi');
                        $('#saveButton').html('Simpan');
                        $('#saveButton').prop('disabled', false);
                    } else {
                        toastr.error('Terjadi kesalahan: ' + error, 'Kesalahan');
                        $('#saveButton').html('Simpan');
                        $('#saveButton').prop('disabled', false);
                    }
                }
            });



        });


        const fileInput = document.getElementById('fileInput');
        const imagePreview = document.getElementById('blah');

        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                const selectedFile = fileInput.files[0];

                const objectURL = URL.createObjectURL(selectedFile);

                imagePreview.src = objectURL;
            }
        });
</script>
@endsection