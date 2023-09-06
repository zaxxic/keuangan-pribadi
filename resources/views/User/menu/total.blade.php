@extends('layouts1.app')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="content-page-header">
                <h5>Total</h5>
            </div>
            <div class="container">
                <div class="row justify-content-end">
                    <div class="col-12 col-md-2 mb-2 mb-md-0">
                        <button class="btn btn-primary w-100">
                            Export <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M21.17 3.25q.33 0 .59.25q.24.24.24.58v15.84q0 .34-.24.58q-.26.25-.59.25H7.83q-.33 0-.59-.25q-.24-.24-.24-.58V17H2.83q-.33 0-.59-.24Q2 16.5 2 16.17V7.83q0-.33.24-.59Q2.5 7 2.83 7H7V4.08q0-.34.24-.58q.26-.25.59-.25M7 13.06l1.18 2.22h1.79L8 12.06l1.93-3.17H8.22L7.13 10.9l-.04.06l-.03.07q-.26-.53-.56-1.07q-.25-.53-.53-1.07H4.16l1.89 3.19L4 15.28h1.78m8.1 4.22V17H8.25v2.5m5.63-3.75v-3.12H12v3.12m1.88-4.37V8.25H12v3.13M13.88 7V4.5H8.25V7m12.5 12.5V17h-5.62v2.5m5.62-3.75v-3.12h-5.62v3.12m5.62-4.37V8.25h-5.62v3.13M20.75 7V4.5h-5.62V7Z" />
                            </svg>
                        </button>
                    </div>
                    <div class="col-12 col-md-4">
                        <input type="month" class="form-control w-100" id="bulanTahunInput">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between flex-wrap flex-md-nowrap">
                    <div class="w-md-100 d-flex align-items-center mb-3 flex-wrap flex-md-nowrap">

                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Data bulanan</h5>
                        </div>
                        <div class="card-body">
                            <div id="s-col"></div>
                        </div>
                    </div>
                </div>


            </div>


            <div class="row">
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon bg-2">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                                <div class="dash-count">
                                    <div class="dash-title">Total uang pemasukkan</div>
                                    <div class="dash-counts">
                                        <p>Rp2.000.000</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon bg-1">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                                <div class="dash-count">
                                    <div class="dash-title">Total uang Pengeluaran</div>
                                    <div class="dash-counts">
                                        <p>Rp 1.000.000</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-6 col-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon bg-2">
                                    <span class="widget-percentage"><span class="h4"
                                            style="color: rgb(56, 56, 56)">+90%</span> </span>
                                </span>
                                <div class="dash-count">
                                    <div class="dash-title">Total uang perbandingan dari bulan</div>
                                    <div class="dash-counts">
                                        <p class="h5">Rp2.000.000</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Judul</th>
                                    <th>Jumlah</th>
                                    <th>Jenis</th>
                                    <th>Tanggal</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="profile.html">Beli burgur</a>
                                        </h2>
                                    </td>
                                    <td>Rp 20.000.000</td>
                                    <td>Pengeluaran</td>
                                    <td>23 Nov 2020</td>
                                    <td>
                                        <button class="btn btn-success">Lihat</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="profile.html">Beli ikan</a>
                                        </h2>
                                    </td>
                                    <td>Rp 20.000</td>
                                    <td>Pengeluaran</td>
                                    <td>18 Nov 2020</td>
                                    <td>
                                        <button class="btn btn-success">Lihat</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="profile.html">Beli uang</a>
                                        </h2>
                                    </td>
                                    <td>Rp 45.000</td>
                                    <td>Pendapatan</td>
                                    <td>10 Nov 2020</td>
                                    <td>
                                        <button class="btn btn-success">Lihat</button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>






        </div>
    </div>
@endsection
@section('script')
    <script>
        // Mendapatkan tanggal saat ini
        var today = new Date();

        // Mengambil tahun saat ini dalam format YYYY-MM
        var tahun = today.getFullYear();
        var bulan = (today.getMonth() + 1).toString().padStart(2, '0'); // Menambahkan 0 di depan jika bulan kurang dari 10

        // Mengatur nilai input bulan
        document.getElementById("bulanTahunInput").value = tahun + "-" + bulan;
    </script>

    {{-- <script src="{{ asset('assets/plugins/chartjs/chart.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/chartjs/chart-data.js') }}"></script> --}}
    {{-- // <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script> --}}
@endsection
