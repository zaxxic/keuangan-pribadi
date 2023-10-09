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
          <a href="#" id="exportMonthly" class="btn btn-primary w-100">
            Export <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24">
              <path fill="currentColor" d="M21.17 3.25q.33 0 .59.25q.24.24.24.58v15.84q0 .34-.24.58q-.26.25-.59.25H7.83q-.33 0-.59-.25q-.24-.24-.24-.58V17H2.83q-.33 0-.59-.24Q2 16.5 2 16.17V7.83q0-.33.24-.59Q2.5 7 2.83 7H7V4.08q0-.34.24-.58q.26-.25.59-.25M7 13.06l1.18 2.22h1.79L8 12.06l1.93-3.17H8.22L7.13 10.9l-.04.06l-.03.07q-.26-.53-.56-1.07q-.25-.53-.53-1.07H4.16l1.89 3.19L4 15.28h1.78m8.1 4.22V17H8.25v2.5m5.63-3.75v-3.12H12v3.12m1.88-4.37V8.25H12v3.13M13.88 7V4.5H8.25V7m12.5 12.5V17h-5.62v2.5m5.62-3.75v-3.12h-5.62v3.12m5.62-4.37V8.25h-5.62v3.13M20.75 7V4.5h-5.62V7Z" />
            </svg>
          </a>
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
            <div id="s-col" class="d-flex justify-content-center">
              <span class="spinner-border" role="status"></span>
            </div>
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
                <div class="dash-title">Pemasukkan bulan ini</div>
                <div class="dash-counts">
                  <span class="spinner-border spinner-border-sm" role="status"></span>
                  <p id="pemasukan">
                  </p>
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
                <div class="dash-title">Pengeluaran bulan ini</div>
                <div class="dash-counts">
                  <span class="spinner-border spinner-border-sm" role="status"></span>
                  <p id="pengeluaran">
                  </p>
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
              <span class="dash-widget-icon bg-2 w-25">
                <span class="widget-percentage"><span id="persentase" class="h4" style="color: rgb(56, 56, 56)"></span></span>
              </span>
              <div class="dash-count">
                <div class="dash-title">Selisih dari bulan lalu</div>
                <div class="dash-counts">
                  <span class="spinner-border spinner-border-sm" role="status"></span>
                  <p class="h5" id="perbandingan">
                  </p>
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
                  <h5 class="card-title">Pemasukan Bulan ini</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive" style="max-height: 500px; overflow: auto;">
                <table class="table table-stripped table-hover">
                  <thead class="thead-light">
                    <tr>
                      <th>Judul</th>
                      <th>Jumlah</th>
                      <th>Tanggal</th>
                      <th>Metode Pembayaran</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody id="body_pemasukan">

                  </tbody>
                </table>
                <span class="spinner-border spinner-border-sm mt-2" role="status"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="card">
            <div class="card-header">
              <div class="row align-center">
                <div class="col">
                  <h5 class="card-title">Pengeluaran Bulan ini</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive" style="max-height: 500px; overflow: auto;">
                <table class="table table-hover">
                  <thead class="thead-light">
                    <tr>
                      <th>Judul</th>
                      <th>Jumlah</th>
                      <th>Tanggal</th>
                      <th>Metode Pembayaran</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody id="body_pengeluaran">

                  </tbody>
                </table>
                <span class="spinner-border spinner-border-sm mt-2" role="status"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
<script>
  const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
  let today = new Date();
  const input = document.getElementById("bulanTahunInput");
  input.value = today.getFullYear() + "-" + (today.getMonth() + 1).toString().padStart(2, '0');

  let ctx = document.querySelector("#s-col");
  let chart;
  let data = @json($filtered);
  let sCol = {
    chart: {
      height: 350,
      type: "bar",
      toolbar: {
        show: false,
      },
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "55%",
        endingShape: "rounded",
      },
    },
    colors: ['#888ea8', '#4361ee'],
    dataLabels: {
      enabled: false,
    },
    stroke: {
      show: true,
      width: 2,
      colors: ["transparent"],
    },
    series: [
      {
        name: "Pemasukan",
        data: data.chart.pemasukan,
      },
      {
        name: "Pengeluaran",
        data: data.chart.pengeluaran,
      },
    ],
    xaxis: {
      categories: data.chart.days,
    },
    yaxis: {
      title: {
        text: "Rp",
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

  let setMonth = () => {
    $("#exportMonthly").attr("href", `/export/${input.value}`);
  };

  let deleteChart = () => {
    if(chart){
      chart.destroy();
      ctx.innerHTML = '<span class="spinner-border" role="status"></span>';
    }
  };

  let setData = () => {
    sCol.series[0].data = data.chart.pemasukan;
    sCol.series[1].data = data.chart.pengeluaran;
    sCol.xaxis.categories = data.chart.days;
  };

  let runChart = () => {
    chart = new ApexCharts(ctx, sCol);

    chart.render();
  };

  let generateTable = () => {
    let teksPemasukan = "";
    Object.entries(data.incomes).forEach(([key, value]) => {
      let urlIncome = '{{ route("income.editing", ":id") }}'
      let urlDestroy = "{{ route('income.destroy', ':id') }}";
      urlIncome = urlIncome.replace(':id', value.id);
      urlDestroy = urlDestroy.replace(':id', value.id);
      teksPemasukan += /*html*/
      `
      <tr>
        <td>${value.title}</td>
        <td>${value.amount}</td>
        <td>${value.date}</td>
        <td>${value.payment_method}</td>
        <td class="d-flex align-items-center">
          <div class="dropdown dropdown-action">
            <a href="#" class="btn-action-icon" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <ul>
                <li>
                  <a class="dropdown-item"
                      href="${urlIncome}">
                      <i class="far fa-edit me-2"></i>Edit
                  </a>
                </li>
                <li>
                  <a class="dropdown-item delete-income" href="#"
                      data-id="${value.id}"
                      data-route="${urlDestroy}"
                      data-toggle="modal"
                      data-target="#deleteCategoryModal">
                      <i class="far fa-trash-alt me-2"></i>Delete
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </td>
      </tr>
      `;
    });

    let teksPengeluaran = "";
    Object.entries(data.expenditures).forEach(([key, value]) => {
      let urlExpenditure = '{{ route("expenditure.edit", ":id") }}'
      let urlDestroy = "{{ route('expenditure.edit', ':id') }}";
      urlExpenditure = urlExpenditure.replace(':id', value.id);
      urlDestroy = urlDestroy.replace(':id', value.id);
      teksPengeluaran += /*html*/
      `
      <tr>
        <td>${value.title}</td>
        <td>${value.amount}</td>
        <td>${value.date}</td>
        <td>${value.payment_method}</td>
        <td class="d-flex align-items-center">
          <div class="dropdown dropdown-action">
            <a href="#" class="btn-action-icon" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <ul>
                <li>
                  <a class="dropdown-item"
                      href="${urlExpenditure}">
                      <i class="far fa-edit me-2"></i>Edit
                  </a>
                </li>
                <li>
                  <a class="dropdown-item delete-income" href="#"
                      data-id="${value.id}"
                      data-route="${urlDestroy}"
                      data-toggle="modal"
                      data-target="#deleteCategoryModal">
                      <i class="far fa-trash-alt me-2"></i>Delete
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </td>
      </tr>
      `;
    });

    if(data.incomes.length == 0){
      teksPemasukan = "<tr><td colspan='5'>Tidak ada data</td></tr>";
    }

    if(data.expenditures.length == 0){
      teksPengeluaran = "<tr><td colspan='5'>Tidak ada data</td></tr>";
    }

    document.getElementById("body_pemasukan").innerHTML = teksPemasukan;
    document.getElementById("body_pengeluaran").innerHTML = teksPengeluaran;
  };

  let updateTulisan = () => {
    document.getElementById("pemasukan").innerHTML = "Rp " + data.tulisan.pemasukan.toLocaleString("id-ID");
    document.getElementById("pengeluaran").innerHTML = "Rp " + data.tulisan.pengeluaran.toLocaleString("id-ID");

    let selisih = (data.tulisan.pemasukan - data.tulisan.pengeluaran) - data.tulisan.before;

    document.getElementById("perbandingan").innerHTML = "Rp " + selisih.toLocaleString("id-ID");

    if(data.tulisan.pemasukan === 0 && data.tulisan.pengeluaran === 0 && data.tulisan.before === 0){
      document.getElementById("persentase").innerHTML = "0%";
    } else if (data.tulisan.before === 0){
      document.getElementById("persentase").innerHTML = "100%";
    } else {
      document.getElementById("persentase").innerHTML = Math.ceil(selisih / data.tulisan.before * 100) + "%";
    }
  };

  let deleteTulisan = () => {
    document.getElementById("pemasukan").innerHTML = "";
    document.getElementById("pengeluaran").innerHTML = "";
    document.getElementById("perbandingan").innerHTML = "";
    document.getElementById("persentase").innerHTML = "";

    document.getElementById("body_pemasukan").innerHTML = "";
    document.getElementById("body_pengeluaran").innerHTML = "";
  }

  $(".spinner-border").hide();

  setMonth()
  runChart();
  generateTable();
  updateTulisan();

  $("#bulanTahunInput").on("change", async () => {
    deleteChart();
    deleteTulisan();
    $(".spinner-border").show();
    let route = '{{ route("filterTotal", ":month") }}';
    route = route.replace(':month', input.value);
    data = await fetch(route, {
      method: "post",
      headers: {
        'Content-Type': 'application/json',
        "X-CSRF-Token": csrfToken
      }
    }).then(response => response.json());
    setData();
    setMonth();
    runChart();
    generateTable();
    updateTulisan();
    $(".spinner-border").hide();
  });
</script>
<script>
  $(document).on('click', '.delete-income', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var route = $(this).data('route');

    Swal.fire({
      title: 'Apakah Anda yakin?',
      text: "Anda tidak akan dapat mengembalikan ini!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: route,
          type: 'DELETE',
          data: {
            "_token": "{{ csrf_token() }}"
          },
          success: function(response) {
            // Tutup modal
            toastr.success('Pemasukan berhasil hapus','Sukses');
            location.reload();
          },
          error: function(error) {
            if (error.status === 403) {
              toastr.error('Anda tidak memiliki izin untuk menghapus kategori ini', 'Error');
            } else {
              toastr.error('Terjadi kesalahan saat menghapus kategori', 'Error');
            }
          }
        });
      }
    });
  });
</script>
@endsection