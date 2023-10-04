@extends('Admin.layouts.app')

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
                  <p>113</p>
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
                  <p>5</p>
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
                  <p>12</p>
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
                <input type="month" class="form-control w-100" id="bulanTahunInput" value="">
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
@endsection

@section('script')
<script>
  const today = new Date();

  let tahun = today.getFullYear();
  let bulan = (today.getMonth() + 1).toString().padStart(2, '0');
  let bulanTahun = tahun + "-" + bulan

  document.getElementById("bulanTahunInput").value = bulanTahun;


</script>
<script>
  if ($("#admin_chart").length > 0) {
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
      ],
      received: [70, 150, 80, 180, 150, 175, 201, 60, 200, 120, 190, 160],
    };

    let columnConfig = {
      colors: ["#7638ff"],
      series: [
        {
          name: "Pendapatan",
          type: "column",
          data: data.received,
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
            return "Rp " + val.toLocaleString("id-ID") + " ribu";
          },
        },
      },
    };

    let updateChart = async function (bulanTahun) {
      // let received = await fetch(`{{ route('admin-data') }}?bulan=${bulanTahun}`);

      if (columnChart) {
        columnChart.destroy();
      }

      columnChart = new ApexCharts(columnCtx, columnConfig);
      columnChart.render();
    };

    updateChart(bulanTahun);

    $("#bulanTahunInput").on("change", function () {
      bulanTahun = $(this).val();
      updateChart(bulanTahun);
    });
  }
</script>
@endsection
