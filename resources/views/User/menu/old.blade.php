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
            <div id="s-col"></div>
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
                <div class="dash-title">Total uang pemasukkan bulan ini</div>
                <div class="dash-counts">
                  <p id="pemasukan"></p>
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
                <div class="dash-title">Total uang Pengeluaran bulan ini</div>
                <div class="dash-counts">
                  <p id="pengeluaran"></p>
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
              <span class="dash-widget-icon bg-2">
                <span class="widget-percentage"><span id="persentase" class="h4" style="color: rgb(56, 56, 56)"></span> </span>
              </span>
              <div class="dash-count">
                <div class="dash-title">Total uang perbandingan dari bulan lalu</div>
                <div class="dash-counts">
                  <p class="h5" id="perbandingan"></p>
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

              <div class="table-responsive">
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
  let getData = function (month) {
    return fetch("{{ route('gethistory') }}", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-Token": csrfToken,
      },
      body: JSON.stringify({month})
    }).then(response => response.json());
  };

  $(async function () {
    let today = new Date();

    const input = document.getElementById("bulanTahunInput");
    input.value = today.getFullYear() + "-" + (today.getMonth() + 1).toString().padStart(2, '0');
    $("#exportMonthly").attr("href", `/export/${input.value}`);

    let data = await getData(input.value);


  });




  // $(async function(){
  //   var chart;

  //   function jalankanChart(data, bulan){
  //     if ($("#s-col").length > 0) {
  //       let sCol = {
  //         chart: {
  //           height: 350,
  //           type: "bar",
  //           toolbar: {
  //             show: false,
  //           },
  //         },
  //         plotOptions: {
  //           bar: {
  //             horizontal: false,
  //             columnWidth: "55%",
  //             endingShape: "rounded",
  //           },
  //         },
  //         // colors: ['#888ea8', '#4361ee'],
  //         dataLabels: {
  //           enabled: false,
  //         },
  //         stroke: {
  //           show: true,
  //           width: 2,
  //           colors: ["transparent"],
  //         },
  //         series: [
  //           {
  //             name: "Pemasukan",
  //             data: generatePemasukan(data, bulan),
  //           },
  //           {
  //             name: "Pengeluaran",
  //             data: generatePengeluaran(data, bulan),
  //           },
  //         ],
  //         xaxis: {
  //           categories: generateHari(bulan),
  //         },
  //         yaxis: {
  //           title: {
  //             text: "Rp",
  //           },
  //           labels: {
  //             formatter: function (value) {
  //               return "Rp " + value.toLocaleString("id-ID");
  //             },
  //           },
  //         },
  //         fill: {
  //           opacity: 1,
  //         },
  //         tooltip: {
  //           y: {
  //             formatter: function (val) {
  //               return "Rp " + val.toLocaleString("id-ID");
  //             },
  //           },
  //         },
  //       };
  //       if(chart){
  //         chart.destroy();
  //       }

  //       chart = new ApexCharts(document.querySelector("#s-col"), sCol);

  //       chart.render();
  //     }
  //   }

  //   function generateHari(bulan){
  //     let date = new Date(bulan);
  //     let days = [];
  //     while(date.toLocaleDateString("id-ID", {month: "numeric", year: "numeric"}) == bulan.toLocaleDateString("id-ID", {month: "numeric", year: "numeric"})){
  //       days.push(date.getDate().toString());
  //       date.setDate(date.getDate() + 1);
  //     }
  //     return days;
  //   }

  //   function generatePemasukan(data, bulan){
  //     let bulanIni = new Date(bulan);
  //     bulanIni.setDate(1);
  //     bulanIni.setHours(0,0,0,0);

  //     let hasil = [];

  //     while(bulanIni.toLocaleDateString("id-ID", {month: "numeric", year: "numeric"}) == bulan.toLocaleDateString("id-ID", {month: "numeric", year: "numeric"})){

  //       let pemasukan = data.filter(data => {
  //         let dataBulan = new Date(data.date);
  //         dataBulan.setHours(0,0,0,0);

  //         return dataBulan.toLocaleDateString("id-ID", {month: "numeric", year: "numeric", day: "numeric"}) == bulanIni.toLocaleDateString("id-ID", {month: "numeric", year: "numeric", day: "numeric"}) && data.content == 'income';
  //       });

  //       if(pemasukan.length > 0){
  //         if(pemasukan.length == 1){
  //           hasil.push(pemasukan[0].amount);
  //         } else if (pemasukan.length > 1){
  //           let value = pemasukan.map(val => val.amount);
  //           let total = value.reduce((a, c) => a + c);
  //           hasil.push(total);
  //         }
  //       } else {
  //         hasil.push(0);
  //       }

  //       bulanIni.setDate(bulanIni.getDate() + 1);
  //     }
  //     return hasil;

  //   }

  //   function generatePengeluaran(data, bulan){
  //     let bulanIni = new Date(bulan);
  //     bulanIni.setDate(1);
  //     bulanIni.setHours(0,0,0,0);

  //     let hasil = [];

  //     while(bulanIni.toLocaleDateString("id-ID", {month: "numeric", year: "numeric"}) == bulan.toLocaleDateString("id-ID", {month: "numeric", year: "numeric"})){

  //       let pengeluaran = data.filter(data => {
  //         let dataBulan = new Date(data.date);
  //         dataBulan.setHours(0,0,0,0);

  //         return dataBulan.toLocaleDateString("id-ID", {month: "numeric", year: "numeric", day: "numeric"}) == bulanIni.toLocaleDateString("id-ID", {month: "numeric", year: "numeric", day: "numeric"}) && data.content == 'expenditure';
  //       });

  //       if(pengeluaran.length > 0){
  //         if(pengeluaran.length == 1){
  //           hasil.push(pengeluaran[0].amount);
  //         } else if (pengeluaran.length > 1){
  //           let value = pengeluaran.map(val => val.amount);
  //           let total = value.reduce((a, c) => a + c);
  //           hasil.push(total);
  //         }
  //       } else {
  //         hasil.push(0);
  //       }

  //       bulanIni.setDate(bulanIni.getDate() + 1);
  //     }
  //     return hasil;
  //   }

  //   function generateTable(data, bulan){
  //     let date = new Date(bulan);

  //     let pemasukan = data.filter(data => {
  //       let dataBulan = new Date(data.date);
  //       dataBulan.setHours(0,0,0,0);

  //       return dataBulan.toLocaleDateString("id-ID", {month: "numeric", year: "numeric"}) == date.toLocaleDateString("id-ID", {month: "numeric", year: "numeric"}) && data.content == 'income';
  //     });

  //     let pengeluaran = data.filter(data => {
  //       let dataBulan = new Date(data.date);
  //       dataBulan.setHours(0,0,0,0);

  //       return dataBulan.toLocaleDateString("id-ID", {month: "numeric", year: "numeric"}) == date.toLocaleDateString("id-ID", {month: "numeric", year: "numeric"}) && data.content == 'expenditure';
  //     });


  //     let teksPemasukan = "";
  //     pemasukan.forEach(data => {
  //       let urlIncome = '{{ route("income.editing", ":id") }}'
  //       let urlDestroy = "{{ route('income.destroy', ':id') }}";
  //       urlIncome = urlIncome.replace(':id', data.id);
  //       urlDestroy = urlDestroy.replace(':id', data.id);
  //       teksPemasukan += /*html*/
  //       `
  //       <tr>
  //         <td>${data.title}</td>
  //         <td>${data.amount}</td>
  //         <td>${data.date}</td>
  //         <td>${data.payment_method}</td>
  //         <td class="d-flex align-items-center">
  //             <div class="dropdown dropdown-action">
  //                 <a href="#" class="btn-action-icon" data-bs-toggle="dropdown"
  //                     aria-expanded="false">
  //                     <i class="fas fa-ellipsis-v"></i>
  //                 </a>
  //                 <div class="dropdown-menu dropdown-menu-right">
  //                     <ul>
  //                         <li>
  //                             <a class="dropdown-item"
  //                                 href="${urlIncome}">
  //                                 <i class="far fa-edit me-2"></i>Edit
  //                             </a>
  //                         </li>
  //                         <li>
  //                             <a class="dropdown-item delete-income" href="#"
  //                                 data-id="${data.id}"
  //                                 data-route="${urlDestroy}"
  //                                 data-toggle="modal"
  //                                 data-target="#deleteCategoryModal">
  //                                 <i class="far fa-trash-alt me-2"></i>Delete
  //                             </a>
  //                         </li>
  //                     </ul>
  //                 </div>
  //             </div>
  //         </td>
  //       </tr>
  //       `;
  //     });

  //     let teksPengeluaran = "";
  //     pengeluaran.forEach(data => {
  //       let urlIncome = '{{ route("income.editing", ":id") }}'
  //       let urlDestroy = "{{ route('income.destroy', ':id') }}";
  //       urlIncome = urlIncome.replace(':id', data.id);
  //       urlDestroy = urlDestroy.replace(':id', data.id);
  //       teksPengeluaran += /*html*/
  //       `
  //       <tr>
  //         <td>${data.title}</td>
  //         <td>${data.amount}</td>
  //         <td>${data.date}</td>
  //         <td>${data.payment_method}</td>
  //         <td class="d-flex align-items-center">
  //             <div class="dropdown dropdown-action">
  //                 <a href="#" class="btn-action-icon" data-bs-toggle="dropdown"
  //                     aria-expanded="false">
  //                     <i class="fas fa-ellipsis-v"></i>
  //                 </a>
  //                 <div class="dropdown-menu dropdown-menu-right">
  //                     <ul>
  //                         <li>
  //                             <a class="dropdown-item"
  //                                 href="${urlIncome}">
  //                                 <i class="far fa-edit me-2"></i>Edit
  //                             </a>
  //                         </li>
  //                         <li>
  //                             <a class="dropdown-item delete-income" href="#"
  //                                 data-id="${data.id}"
  //                                 data-route="${urlDestroy}"
  //                                 data-toggle="modal"
  //                                 data-target="#deleteCategoryModal">
  //                                 <i class="far fa-trash-alt me-2"></i>Delete
  //                             </a>
  //                         </li>
  //                     </ul>
  //                 </div>
  //             </div>
  //         </td>
  //       </tr>
  //       `;
  //     });

  //     document.getElementById("body_pemasukan").innerHTML = teksPemasukan;
  //     document.getElementById("body_pengeluaran").innerHTML = teksPengeluaran;
  //   }


  //   jalankanChart(transactions, bulanIni);

  //   updateTulisan(chart, transactions, bulanIni);

  //   generateTable(transactions, bulanIni);

  //   $("#bulanTahunInput").on("change", function(e){
  //     let bulanIni = new Date(e.target.value);

  //     jalankanChart(transactions, bulanIni);

  //     updateTulisan(chart, transactions, bulanIni);

  //     generateTable(transactions, bulanIni);

  //     let month = e.target.value;

  //     $("#exportMonthly").attr("href", `/export/${month}`);
  //   });

  //   function updateTulisan(chart, transactions, bulan){
  //     let pemasukan = chart.opts.series[0].data.reduce((a,c) => a + c);
  //     let pengeluaran = chart.opts.series[1].data.reduce((a,c) => a + c);
  //     document.getElementById("pemasukan").innerHTML = rupiah(pemasukan);
  //     document.getElementById("pengeluaran").innerHTML = rupiah(pengeluaran);

  //     let date = new Date(bulan);
  //     date.setMonth(date.getMonth() - 1)

  //     let bulanLaluPemasukan = transactions.filter(data => {
  //       let tanggal = new Date(data.date);

  //       return tanggal.toLocaleDateString("id-ID", {month: "numeric", year: "numeric"}) == date.toLocaleDateString("id-ID", {month: "numeric", year: "numeric"}) && data.content == 'income';
  //     });

  //     let bulanLaluPengeluaran = transactions.filter(data => {
  //       let tanggal = new Date(data.date);

  //       return tanggal.toLocaleDateString("id-ID", {month: "numeric", year: "numeric"}) == date.toLocaleDateString("id-ID", {month: "numeric", year: "numeric"}) && data.content == 'expenditure';
  //     });

  //     let pemasukanLalu = bulanLaluPemasukan.map(data => data.amount).reduce((a,c) => a+c);
  //     let pengeluaranLalu = bulanLaluPengeluaran.map(data => data.amount).reduce((a,c) => a+c);

  //     let bulanLalu = pemasukanLalu - pengeluaranLalu;
  //     let sekarang = pemasukan - pengeluaran;

  //     document.getElementById("perbandingan").innerHTML = rupiah(sekarang) + " : " + rupiah(bulanLalu);

  //     let selisih = sekarang - bulanLalu;

  //     document.getElementById("persentase").innerHTML = Math.ceil(selisih / bulanLalu * 100) + "%";
  //   }
  // });
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
