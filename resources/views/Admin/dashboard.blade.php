@extends("Admin.layouts.app")

@section("style")
  <link href="{{ asset("assets/plugins/yearpicker/yearpicker.css") }}" rel="stylesheet">
@endsection

@section("content")
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
                <h5 class="card-title">Analisa keuangan</h5>
                <div>
                  <input class="form-control w-100" id="tahunInput" type="text" readonly>
                </div>
              </div>
              <div class="card-body">
                <div class="w-md-100 d-flex align-items-center mb-3 flex-wrap flex-md-nowrap">
                  <div>
                    <span></span>
                    <p class="h3 text-primary me-5" id="omset"></p>
                  </div>
                </div>
                <div class="d-flex align-items-center justify-content-center flex-wrap flex-md-nowrap">
                  <span class="spinner-border" role="status"></span>
                </div>
                <div id="admin_chart"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="page-header">
        <div class="content-page-header">
          <h5 class="card-title">Paket</h5>
        </div>

      </div>
      <div class="row">
        <div class="col-md-8 col-sm-8">
          <div class="d-flex flex-column">
            @php
              $chart = [
                  "labels" => [],
                  "data" => [],
                  "backgroundColor" => []
              ];
            @endphp
            @foreach ($packages as $package)
              @php
                array_push($chart["labels"], $package->title);
                array_push($chart["data"], $package->history->sum("amount"));
                array_push($chart["backgroundColor"], '#' . dechex(mt_rand(0, 16777215)));
              @endphp
              <div class="card" style="border-left: solid blue 5px">
                <div class="card-body">
                  <p><span class="text-dark" style="font-style: bold;">{{ $package->title }}</span> telah dibeli sebanyak <span class="text-dark" style="font-style: bold;">{{ number_format(count($package->history), 0, ',', '.') }}</span> kali</p>
                </div>
              </div>
            @endforeach
          </div>
        </div>
        <div class="col-md-4 col-sm-4">
          <div class="card">
            <div class="card-body">
              <div class="chartjs-wrapper-demo">
                <canvas id="chartKu"></canvas>
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
                  <a class="btn-right btn btn-sm btn-outline-primary" href="{{ route("paid-users") }}">
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
                        <td>{{ date("d M Y", strtotime($item->created_at)) }}</td>
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

@section("script")
  <script src="{{ asset("assets/plugins/chartjs/chart.min.js") }}"></script>
  <script src="{{ asset("assets/plugins/chartjs/chart-data.js") }}"></script>
  <script src="{{ asset("assets/plugins/yearpicker/yearpicker.js") }}"></script>
  <script>
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    const columnCtx = document.getElementById("admin_chart");
    const omset = document.getElementById("omset");
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
      series: [{
        name: "Pendapatan",
        type: "column",
        data: [],
      }, ],
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
          formatter: function(value) {
            return "Rp " + value.toLocaleString("id-ID");
          },
        },
      },
      fill: {
        opacity: 1,
      },
      tooltip: {
        y: {
          formatter: function(val) {
            return "Rp " + val.toLocaleString("id-ID");
          },
        },
      },
    };

    let total = (array = []) => array.reduce((a,c) => a+c);

    omset.previousElementSibling.innerHTML = "Omset";

    const today = new Date();
    $("#tahunInput").yearpicker({
      year: today.getFullYear(),
      onChange: async function(value) {
        if (columnChart) {
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
          }).then(response => response.json())
          .then(response => response.data);
        columnChart = new ApexCharts(columnCtx, columnConfig);
        omset.innerHTML = "Rp " + total(columnConfig.series[0].data).toLocaleString("id-ID");
        $(".spinner-border").hide();
        columnChart.render();
      }
    });
  </script>
  <script>
    let chartData = @json($chart);
    let datapie = {
      labels: chartData.labels,
      datasets: [{
        data: chartData.data,
        backgroundColor: chartData.backgroundColor,
      }, ],
    };
    let optionpie = {
      maintainAspectRatio: false,
      responsive: true,
      legend: {
        display: false,
      },
      animation: {
        animateScale: true,
        animateRotate: true,
      },
    };

    const ctx7 = document.getElementById("chartKu");
    let myPieChart7 = new Chart(ctx7, {
      type: "pie",
      data: datapie,
      options: optionpie,
    });
  </script>
@endsection
