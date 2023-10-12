@extends('Admin.layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/plugins/yearpicker/yearpicker.css') }}">
@endsection

@section('content')
<div class="page-wrapper">
  <div class="content container-fluid">
    <div class="row d-flex justify-content-evenly">
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-body">
            <div class="dash-widget-header">
              <span class="dash-widget-icon bg-2">
                <i class="fa-regular fa-user"></i>
              </span>
              <div class="dash-count">
                <div class="dash-title">Pengguna saat ini</div>
                <div class="dash-counts">
                  <p>{{ $usersCount }}</p>
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
                <i class="fa-solid fa-gear"></i>
              </span>
              <div class="dash-count">
                <div class="dash-title">Pengguna baru bulan ini</div>
                <div class="dash-counts">
                  <p>{{ $usersMonth }}</p>
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
              <span class="dash-widget-icon bg-3">
                <i class="fa-solid fa-gift"></i>
              </span>
              <div class="dash-count">
                <div class="dash-title">Pengguna Premium</div>
                <div class="dash-counts">
                  <p>{{ $usersPremium }}</p>
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
              <div>
                <input type="text" class="form-control w-100" id="tahunInput" readonly>
              </div>
            </div>
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-center flex-wrap flex-md-nowrap">
                <span class="spinner-border" role="status"></span>
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
                <a href="{{ route('paid-users') }}" class="btn-right btn btn-sm btn-outline-primary">
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
                    <th>#</th>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($last as $item)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->user->email }}</td>
                    <td>{{ $item->amount }}</td>
                    <td>{{ date('d M Y', strtotime($item->created_at)) }}</td>
                  </tr>
                  @endforeach
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

@section('script')
<script src="{{ asset('assets/plugins/yearpicker/yearpicker.js') }}"></script>
<script>
  const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
  const columnCtx = document.getElementById("admin_chart");
  let columnChart;
  let data = {
    labels: [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "Mei",
      "Jun",
      "Jul",
      "Agu",
      "Sep",
      "Okt",
      "Nov",
      "Des",
    ]
  };
  let columnConfig = {
    colors: ["#7638ff"],
    series: [
      {
        name: "Pendapatan",
        type: "column",
        data: [],
      },
    ],
    chart: {
      type: "bar",
      fontFamily: "Poppins, sans-serif",
      height: 350,
      toolbar: {
        show: false,
      },
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "60%",
        endingShape: "rounded",
      },
    },
    dataLabels: {
      enabled: false,
    },
    stroke: {
      show: true,
      width: 2,
      colors: ["transparent"],
    },
    xaxis: {
      categories: data.labels,
    },
    yaxis: {
      title: {
        text: "Rp (ribuan)",
      },
      labels: {
        formatter: function (value) {
          return "Rp " + value.toLocaleString("id-ID");
        },
      },
    },
    fill: {
      opacity: 1,
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return "Rp " + val.toLocaleString("id-ID");
        },
      },
    },
  };

  const today = new Date();
  $("#tahunInput").yearpicker({
    year: today.getFullYear(),
    onChange: async function (value) {
      if(columnChart){
        columnChart.destroy();
      }
      $(".spinner-border").show();
      let route = '{{ route("admin-data", ":year") }}';
      route = route.replace(':year', value);
      columnConfig.series[0].data = await fetch(route, {
        method: "post",
        headers: {
          'Content-Type': 'application/json',
          "X-CSRF-Token": csrfToken
        }
      }).then(response => response.json());
      columnChart = new ApexCharts(columnCtx, columnConfig);
      $(".spinner-border").hide();
      columnChart.render();
    }
  });
</script>
@endsection
