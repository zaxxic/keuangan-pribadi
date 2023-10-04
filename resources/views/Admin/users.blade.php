@extends('Admin.layouts.app')

@section('content')
<div class="page-wrapper">
  <div class="content container-fluid">

    <div class="page-header">
      <div class="content-page-header d-flex justify-content-between">
        <h5>History Pengguna Premium</h5>
        {{-- <a class="btn btn-primary" href="add-customer.html"><i class="fe fe-printer" aria-hidden="true"></i>
          Print</a> --}}
      </div>
    </div>

    <div class="row justify-content-end mb-4">
        <div class="input-group" style="max-width: 450px;">
          <input type="text" class="form-control" placeholder="Cari Pemasukan" id="searchCategory">
          <a class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></a>
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
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Bulan</th>
                    <th>Metode Pembayaran</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Surya Ramadhani</td>
                    <td>suryaramadhani@mail.com</td>
                    <td>September 2023</td>
                    <td>GoPay</td>
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
