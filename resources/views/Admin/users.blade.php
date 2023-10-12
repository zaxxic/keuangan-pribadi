@extends('Admin.layouts.app')

@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
@endsection

@section('content')
<div class="page-wrapper">
  <div class="content container-fluid">

    <div class="page-header">
      <div class="content-page-header d-flex justify-content-between">
        <h5>Pengguna Langganan</h5>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="card bg-white">
          <div class="card-body">
            <table id="tbl_subscribers" class="table table-center table-hover w-100">
              <thead class="thead-light">
                <tr>
                  <th>#</th>
                  <th>Nama Pengguna</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Jumlah</th>
                  <th>Tanggal Pembelian</th>
                  <th>Tanggal Selesai</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
  $(document).ready(function(){
    $('#tbl_subscribers').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ajax: '{{ url()->current() }}',
      columns: [
        {
          data: 'DT_RowIndex',
          name: 'DT_RowIndex',
          searchable: false,
          orderable: false,
        },
        {
          data: 'name',
          name: 'name'
        },
        {
          data: 'email',
          name: 'email'
        },
        {
          data: 'status',
          name: 'status'
        },
        {
          data: 'amount',
          name: 'amount'
        },
        {
          data: 'created',
          name: 'created'
        },
        {
          data: 'expire_date',
          name: 'expire_date'
        },
      ],
      columnDefs: [
        {
          "width": "25px",
          "targets": 0
        },
      ],
    });
  });
</script>
@endsection
