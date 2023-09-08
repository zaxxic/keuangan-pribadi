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
                                        <a href="{{ Route('expenditure.category') }}" class="nav-link active">
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
                            <a class="btn btn-primary" href="add-expenses.html">
                                <i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Tambah Pemasukan
                            </a>
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
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <a href="invoice-details.html" class="invoice-link">Kebutuhan
                                                        sehari-hari</a>
                                                </td>


                                                <td>21-05-2005</td>


                                                <td class="d-flex align-items-center">

                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="btn-action-icon" data-bs-toggle="dropdown"
                                                            aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <ul>
                                                                <li>
                                                                    <a class="dropdown-item" href="edit-expenses.html"><i
                                                                            class="far fa-edit me-2"></i>Edit</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#delete_modal"><i
                                                                            class="far fa-trash-alt me-2"></i>Delete</a>
                                                                </li>
                                                            </ul>
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
        </div>
    </div>
@endsection
