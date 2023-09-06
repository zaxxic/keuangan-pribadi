@extends('Admin.layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="row d-flex justify-content-center">
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon bg-1">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                                <div class="dash-count">
                                    <div class="dash-title">Amount Due</div>
                                    <div class="dash-counts">
                                        <p>1,642</p>
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
                                    <div class="dash-title">Amount Due</div>
                                    <div class="dash-counts">
                                        <p>1,642</p>
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
                                    <div class="dash-title">Amount Due</div>
                                    <div class="dash-counts">
                                        <p>1,642</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 d-flex">
                    <div class="card flex-fill">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Analisa keungan</h5>

                                <div class="dropdown main">
                                    <label for="chart_period_select">Periode:</label>
                                    <select id="chart_period_select">
                                        <option value="daily" id="option_daily">Harian</option>
                                        <option value="weekly" id="option_weekly">Mingguan</option>
                                        <option value="monthly" id="option_monthly">Bulanan</option>
                                        <option value="yearly" id="option_yearly">Tahunan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between flex-wrap flex-md-nowrap">
                                    <div class="w-md-100 d-flex align-items-center mb-3 flex-wrap flex-md-nowrap">

                                    </div>
                                </div>

                                <div id="admin_chart"></div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-center">
                                <div class="col">
                                    <h5 class="card-title">Berlangganan Terakhir</h5>
                                </div>
                                <div class="col-auto">
                                    <a href="invoice-details.html" class="btn-right btn btn-sm btn-outline-primary">
                                        Lihat semua
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Judul</th>
                                            <th>Tanggal</th>
                                            <th>Jumlah</th>
                                            <th>Kategori</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html"> Dapat sangu</a>
                                                </h2>
                                            </td>
                                            <td>5 Nov 2020</td>
                                            <td>Rp 50.000</td>
                                            <td>Bonus</td>
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                                            class="fas fa-ellipsis-h"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="edit-invoice.html"><i
                                                                class="far fa-edit me-2"></i>Edit</a>
                                                        <a class="dropdown-item" href="invoice-details.html"><i
                                                                class="far fa-eye me-2"></i>View</a>
                                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                                class="far fa-trash-alt me-2"></i>Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection
