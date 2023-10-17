@extends('layouts1.app')
@section('style')
<style>
  .dropdown.main {
    display: inline-block;
    position: relative;
  }

  .dropdown.main select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-color: #fff;
    border: 1px solid #ccc;
    padding: 8px 16px;
    font-size: 14px;
    cursor: pointer;
    width: 200px;
    max-width: 100%;
  }

  .dropdown.main select:focus {
    outline: none;
    border-color: #888;
  }

  .dropdown.main select option {
    background-color: #fff;
    color: #333;
  }

  .dropdown.main label {
    margin-right: 8px;
    font-size: 14px;
    font-weight: bold;
  }
</style>
@endsection
@section('content')
<div class="page-wrapper">
  <div class="content container-fluid">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-body">
            <div class="dash-widget-header">
              <span class="dash-widget-icon bg-2">
                <i class="fas fa-dollar-sign"></i>
              </span>
              <div class="dash-count">
                <div class="dash-title">Total uang pemasukkan</div>
                <div class="dash-counts">
                  {{-- <p>Rp {{ number_format($incomes->filter(fn ($item) => $item->status === 'paid')->sum('amount'), 0, '', '.') }}</p> --}}
                  <p>Rp {{ number_format($inAmount, 0, '', '.') }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-body">
            <div class="dash-widget-header">
              <span class="dash-widget-icon bg-1">
                <i class="fas fa-dollar-sign"></i>
              </span>
              <div class="dash-count">
                <div class="dash-title">Total uang Pengeluaran</div>
                <div class="dash-counts">
                  {{-- <p>Rp {{ number_format($expenditures->filter(fn ($item) => $item->status === 'paid')->sum('amount'), 0, '', '.') }}</p> --}}
                  <p>Rp {{ number_format($exAmount, 0, '', '.') }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-body">
            <div class="dash-widget-header">
              <span class="dash-widget-icon bg-3">
                <i class="fas fa-file-alt"></i>
              </span>
              <div class="dash-count">
                <div class="dash-title">Total Pemasukan</div>
                <div class="dash-counts">
                  {{-- <p>{{ count($incomes) }}</p> --}}
                  <p>{{ $inCount }}</p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-body">
            <div class="dash-widget-header">
              <span class="dash-widget-icon bg-4">
                <i class="far fa-file"></i>
              </span>
              <div class="dash-count">
                <div class="dash-title">Total Pengeluaran</div>
                <div class="dash-counts">
                  {{-- <p>{{ count($expenditures) }}</p> --}}
                  <p>{{ $exCount }}</p>
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
                  <div>
                    <span></span>
                    <p class="h3 text-primary me-5" id="periode_pemasukan"></p>
                  </div>
                  <div>
                    <span></span>
                    <p class="h3 text-warning me-5" id="periode_pengeluaran"></p>
                  </div>
                  <div>
                    <span></span>
                    <p class="h3 text-success me-5" id="persentase"></p>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-center" id="sales_chart">
                <div class="spinner-border" role="status"></div>
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>
    <div class="row">
      <div class="col-md-6 col-sm-6">
        <div class="card">
          <div class="card-header">
            <div class="row align-center">
              <div class="col">
                <h5 class="card-title">Pemasukan Terakhir</h5>
              </div>
              <div class="col-auto">
                <a href="{{Route('income.index')}}" class="btn-right btn btn-sm btn-outline-primary">
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
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($incomes as $income)
                  <tr>
                    <td>
                      {{ $income['title'] }}
                    </td>
                    <td>Rp {{ number_format($income['amount'], 0, '', '.') }}</td>
                    <td>{{ date('d M Y', strtotime($income['date'])) }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-sm-6">
        <div class="card">
          <div class="card-header">
            <div class="row align-center">
              <div class="col">
                <h5 class="card-title">Pengeluaran terakhir</h5>
              </div>
              <div class="col-auto">
                <a href="{{Route('expenditure.index')}}" class="btn-right btn btn-sm btn-outline-primary">
                  Lihat semua
                </a>
              </div>
            </div>
          </div>
          <div class="card-body">

            <div class="table-responsive">
              <table class="table table-stripped table-hover">
                <thead class="thead-light">
                  <tr>
                    <th>Judul</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($expenditures as $expenditure)
                  <tr>
                    <td>
                      {{ $expenditure['title'] }}
                    </td>
                    <td>Rp {{ number_format($expenditure['amount'], 0, '', '.') }}</td>
                    <td>{{ date('d M Y', strtotime($expenditure['date'])) }}</td>
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
<script>
  if ($("#sales_chart").length > 0) {
  const columnCtx = document.getElementById("sales_chart");
  const pemasukan = document.getElementById("periode_pemasukan");
  const pengeluaran = document.getElementById("periode_pengeluaran");
  const persentase = document.getElementById("persentase");
  let columnChart;

  let data = @json($chartData);

  let columnConfig = {
    colors: ["#7638ff", "#fda600"],
    series: [
      {
        name: "Pemasukan",
        type: "column",
        data: []
      },
      {
        name: "Pengeluaran",
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
      categories: [],
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

  let total = (array = []) => array.reduce((a,c) => a+c);

  let updateChart = (jenis) => {
    let dataTerpilih = data[jenis];

    if (columnChart) {
      columnChart.destroy();
    }

    columnConfig.series[0].data = dataTerpilih.received;
    columnConfig.series[1].data = dataTerpilih.pending;
    columnConfig.xaxis.categories = dataTerpilih.labels;

    let income = total(columnConfig.series[0].data);
    let expenditure = total(columnConfig.series[1].data);

    pemasukan.innerHTML = "Rp " + total(dataTerpilih.received).toLocaleString("id-ID");
    pengeluaran.innerHTML = "Rp " + total(dataTerpilih.pending).toLocaleString("id-ID");

    let persen = income - expenditure;

    if( persen > 0 ){
      persentase.className = "h3 text-success me-5";
      persen = `+${parseInt(persen / income * 100)}%`;
    } else if(persen < 0){
      persentase.className = "h3 text-danger me-5";
      persen = `${parseInt(persen / expenditure * 100)}%`;
    } else {
      persentase.className = "h3 text-secondary me-5";
      persen = `0%`;
    }

    persentase.innerHTML = persen;

    columnChart = new ApexCharts(columnCtx, columnConfig);
    columnChart.render();
  };

  $(".spinner-border").hide();

  updateChart("daily");
  pemasukan.previousElementSibling.innerHTML = "Pemasukan";
  pengeluaran.previousElementSibling.innerHTML = "Pengeluaran";
  persentase.previousElementSibling.innerHTML = "Persentase";

  $("#chart_period_select").on("change", function () {
    let jenisTerpilih = $(this).val();
    updateChart(jenisTerpilih);
  });
}
</script>
@endsection
