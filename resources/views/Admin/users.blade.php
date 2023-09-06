@extends('Admin.layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="content-page-header d-flex justify-content-between">
                    <h5>Bukti Transaksi</h5>
                    <a class="btn btn-primary" href="add-customer.html"><i class="fe fe-printer" aria-hidden="true"></i>
                        Print</a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <div class="cal-icon cal-icon-info">
                            <input type="text" class="datetimepicker form-control" placeholder="Select Date">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>Tanggal Akhir</label>
                        <div class="cal-icon cal-icon-info">
                            <input type="text" class="datetimepicker form-control" placeholder="Select Date">
                        </div>
                    </div>
                </div>
                <div class="col">

                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-8">
                    <div class="card bg-white">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Balance </th>
                                            <th>Total Invoice </th>
                                            <th>Created</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html" class="avatar avatar-md me-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="assets/img/profiles/avatar-14.jpg" alt="User Image"></a>
                                                    <a href="profile.html">John Smith <span><span class="__cf_email__"
                                                                data-cfemail="0862676066486d70696578646d266b6765">[email&#160;protected]</span></span></a>
                                                </h2>
                                            </td>
                                            <td>+1 989-438-3131</td>
                                            <td>$4,220</td>
                                            <td>2</td>
                                            <td>19 Dec 2022, 06:12 PM</td>
                                            <td><span class="badge badge-pill bg-success-light">Active</span></td>
                                            <td class="d-flex align-items-center">
                                                <a href="add-invoice.html" class="btn btn-greys me-2"><i
                                                        class="fa fa-plus-circle me-1"></i> Invoice</a>
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class=" btn-action-icon " data-bs-toggle="dropdown"
                                                        aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul>
                                                            <li>
                                                                <a class="dropdown-item" href="edit-customer.html"><i
                                                                        class="far fa-edit me-2"></i>Edit</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0);"
                                                                    data-bs-toggle="modal" data-bs-target="#delete_modal"><i
                                                                        class="far fa-trash-alt me-2"></i>Delete</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="customer-details.html"><i
                                                                        class="far fa-eye me-2"></i>View</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="active-customers.html"><i
                                                                        class="fa-solid fa-power-off me-2"></i>Activate</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="deactive-customers.html"><i
                                                                        class="far fa-bell-slash me-2"></i>Deactivate</a>
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
@endsection
