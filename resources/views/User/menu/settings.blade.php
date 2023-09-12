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
                        <div class="content-page-header">
                            <h5>Account Settings</h5>
                        </div>
                        <div class="row">
                            <div class="profile-picture">
                                <div class="upload-profile me-2">
                                    <div class="profile-img">
                                        <img id="blah" class="avatar" src="assets/img/profiles/avatar-10.jpg" alt />
                                    </div>
                                </div>
                                <div class="img-upload">
                                    <label class="btn btn-primary">
                                        Ganti Profile <input type="file" />
                                    </label>

                                    <p class="mt-1">
                                        Profile minnimal 5Mb
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-title">
                                    <h5>Ganti Password</h5>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label>Masukkan passwrd lama</label>
                                    <input type="text" class="form-control" placeholder="Masuukan password lama" />
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label>Masukkan Password</label>
                                    <input type="text" class="form-control" placeholder="Masukkan password baru" />
                                </div>
                            </div>


                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label>Masukkan Konfirmasi password</label>
                                    <input type="text" class="form-control" placeholder="Konfirmasi password" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 mt-4">
                                <div class="btn-path">
                                    <a href="javascript:void(0);" class="btn btn-primary">Simpan</a>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-title">
                                    <h5>Ganti informasi pribadi</h5>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" placeholder="Enter Email Address" />
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-0">
                                    <label>Gender</label>
                                    <select class="select">
                                        <option>Select Gender</option>
                                        <option>Laki Laki</option>
                                        <option>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label>Tanggal ulang tahun</label>
                                    <div class="cal-icon cal-icon-info">
                                        <input type="text" class="datetimepicker form-control"
                                            placeholder="Pilih tanggal" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 mt-4">
                                <div class="btn-path">
                                    <a href="javascript:void(0);" class="btn btn-primary">Save Changes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
