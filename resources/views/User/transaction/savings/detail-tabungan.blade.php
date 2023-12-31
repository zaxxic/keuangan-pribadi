@extends('layouts1.app')

@section('style')
<style>
  #attachmentImage {
    transition: filter 0.3s;
  }

  #attachmentImage:hover {
    filter: brightness(70%);
    /* Mengurangi kecerahan gambar ketika dihover */
    cursor: pointer;
    /* Mengubah kursor menjadi pointer */
  }

  #downloadIcon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 24px;
    color: white;
    display: none;
    /* Sembunyikan ikon download secara default */
  }
</style>
@endsection

@php
use App\Models\HistorySaving;
use App\Models\HistoryTransaction;
$income = HistorySaving::where('saving_id', $saving->id)->whereHas('history', function ($q) {
$q->where('status', 'paid')->where('content', 'expenditure');
})->withSum('history', 'amount')->get();
$expenditure = HistorySaving::where('saving_id', $saving->id)->whereHas('history', function ($q) {
$q->where('status', 'paid')->where('content', 'income');
})->withSum('history', 'amount')->get();
$now = $income->sum('history_sum_amount') - $expenditure->sum('history_sum_amount');
$progress = $now / $saving->target_balance * 100;
$progress = intval(round($progress));
@endphp

@section('content')
<div class="page-wrapper">
  <div class="content container-fluid">

    <div class="page-header">
      <div class="row">
        <div class="col-md-8 col-sm-8">
          <div class="card">
            <div class="card-body">
              <div class="row align-center mb-4">
                <div class="col">
                  <h5 class="card-title">{{ $saving->title }}</h5>
                </div>
                <div class="col-auto">
                  @can('owner', $saving)
                  <a href="{{ route('savings.edit', $saving->id) }}" class="btn-right btn btn-sm btn-outline-success"> Edit </a>
                  <button href="javascript:void(0)" class="btn-right btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#inviteModal" {{ ($saving->status == false) ? "disabled" : '' }}> Undang</button>
                  @endcan
                  @cannot('owner', $saving)
                  <a href="javascript:void(0)" class="btn-right btn btn-sm btn-outline-danger" id="keluar"> Keluar </a>
                  @endcannot
                </div>
              </div>
              <div class="dash-widget-header mb-4">
                <span class="dash-widget-icon bg-2">
                  <i class="fas fa-dollar-sign"></i>
                </span>
                <div class="dash-count" style="width: 60%">
                  <div class="dash-counts">
                    <p>Rp {{ number_format($now, 0, '', '.') }} / Rp {{ number_format($saving->target_balance, 0, '', '.') }}</p>
                  </div>
                  <div class="progress progress-sm mt-3">
                    <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a href="#deskripsi" data-bs-toggle="tab" aria-expanded="false" class="nav-link active"> Deskripsi </a>
                </li>
                <li class="nav-item">
                  <a href="#history" data-bs-toggle="tab" aria-expanded="true" class="nav-link"> History </a>
                </li>
                <li class="nav-item">
                  <a href="#tambah" data-bs-toggle="tab" aria-expanded="true" class="nav-link"> Tambah </a>
                </li>
                @if (!count($saving->members))
                <li class="nav-item">
                  <a href="#tarik" data-bs-toggle="tab" aria-expanded="true" class="nav-link"> Tarik </a>
                </li>
                @endif
              </ul>
              <div class="tab-content">
                <div class="tab-pane show active" id="deskripsi">
                  {{ $saving->description }}
                </div>
                <div class="tab-pane" id="history">
                  <div id="accordion">
                    @foreach ($members as $member)
                    <div class="mb-4">
                      <div id="heading{{ $loop->index }}">
                        <h6 class="accordion-faq m-0">
                          <div class="d-flex justify-content-between">
                            <a class="text-dark buttonRowCollapse" data-bs-toggle="collapse" href="#collapse{{ $loop->index }}" aria-expanded="true">
                              <img class="avatar avatar-sm me-2 avatar-img rounded-circle" src="{{ asset('storage/profile') }}/{{ $member->image }}" alt="User Image" />
                              {{ $member->name }}
                            </a>
                            @php
                            $histories = $allHistories->filter(function ($item) use ($member){
                            return $item->user_id == $member->id;
                            });
                            @endphp
                            <p class="text-muted text-small">
                              Rp. {{ number_format($histories->sum('amount'), 0, '', '.') }}
                            </p>
                          </div>
                        </h6>
                      </div>
                      <div id="collapse{{ $loop->index }}" class="collapse {{ ($loop->index == 0) ? " show" : '' }}" aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#accordion">
                        <div class="card-body">
                          <table class="table table-stripped table-hover mb-3">
                            <thead class="thead-light">
                              <tr>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Bukti</th>
                                <th>Status</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($histories as $history)
                              <tr class="{{ ($loop->index > 2) ? " collapse collapseExample{$loop->parent->index} tableRowCollapse" : '' }}">
                                <td>{{ date("d Y M", strtotime($history->date)) }}</td>
                                <td>Rp {{ number_format($history->amount, 0, '', '.') }}</td>
                                <td>
                                  <button class="btn btn-primary" data-bs-target="#modalImage" data-bs-toggle="modal" data-avaible="{{ $history->attachment }}" data-bs-image="{{ asset('storage/expenditure_attachment/' . $history->attachment) }}">Lihat</button>
                                </td>
                                <td><span class="badge bg-{{ ($history->status == 'paid') ? 'success' : 'danger' }}-light">{{ $history->status }}</span></td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                          <div class="d-flex justify-content-between">
                            @if (count($histories) > 3)
                            <button class="btn btn-primary inCollapse" type="button" data-bs-toggle="collapse" data-bs-target=".collapseExample{{ $loop->index }}" aria-expanded="false" aria-controls="collapseExample{{ $loop->index }}">Selengkapnya...</button>
                            @endif
                            @can('owner', $saving)
                            @can('notSame', $member->id)
                            <button href="#" class="btn btn-danger kick" data-id="{{ $member->id }}" {{ ($saving->status == false) ? "disabled" : '' }}>Keluarkan</button>
                            @endcan
                            @endcan
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                    @if (count($pengeluaran))
                    <div class="mb-4">
                      <div id="headingPengeluaran">
                        <h6 class="accordion-faq m-0">
                          <div class="d-flex justify-content-between">
                            <a class="text-dark buttonRowCollapse" data-bs-toggle="collapse" href="#collapsePengeluaran" aria-expanded="true">
                              Pengeluaran
                            </a>
                            <p class="text-muted text-small">
                              Rp. {{ number_format($pengeluaran->sum('amount'), 0, '', '.') }}
                            </p>
                          </div>
                        </h6>
                      </div>
                      <div id="collapsePengeluaran" class="collapse" aria-labelledby="headingPengeluaran" data-bs-parent="#accordion">
                        <div class="card-body">
                          <table class="table table-stripped table-hover mb-3">
                            <thead class="thead-light">
                              <tr>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($pengeluaran as $keluar)
                              <tr class="{{ ($loop->index > 2) ? " collapse collapseExamplePengeluaran tableRowCollapse" : '' }}">
                                <td>Rp {{ number_format($keluar->amount, 0, '', '.') }}</td>
                                <td>{{ date("d Y M", strtotime($keluar->date)) }}</td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                          <div class="d-flex justify-content-between">
                            @if (count($pengeluaran) > 3)
                            <button class="btn btn-primary inCollapse" type="button" data-bs-toggle="collapse" data-bs-target=".collapseExampleLainnya" aria-expanded="false" aria-controls="collapseExampleLainnya">Selengkapnya...</button>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                    @endif
                    @if (count($lainnya))
                    <div class="mb-4">
                      <div id="headingLainnya">
                        <h6 class="accordion-faq m-0">
                          <div class="d-flex justify-content-between">
                            <a class="text-dark buttonRowCollapse" data-bs-toggle="collapse" href="#collapseLainnya" aria-expanded="true">
                              Lainnya
                            </a>
                            <p class="text-muted text-small">
                              Rp. {{ number_format($lainnya->sum('amount'), 0, '', '.') }}
                            </p>
                          </div>
                        </h6>
                      </div>
                      <div id="collapseLainnya" class="collapse" aria-labelledby="headingLainnya" data-bs-parent="#accordion">
                        <div class="card-body">
                          <table class="table table-stripped table-hover mb-3">
                            <thead class="thead-light">
                              <tr>
                                <th>Nama</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($lainnya as $lain)
                              <tr class="{{ ($loop->index > 2) ? " collapse collapseExampleLainnya tableRowCollapse" : '' }}">
                                <td>{{ $lain->name }}</td>
                                <td>Rp {{ number_format($lain->amount, 0, '', '.') }}</td>
                                <td>{{ date("d Y M", strtotime($lain->date)) }}</td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                          <div class="d-flex justify-content-between">
                            @if (count($lainnya) > 3)
                            <button class="btn btn-primary inCollapse" type="button" data-bs-toggle="collapse" data-bs-target=".collapseExampleLainnya" aria-expanded="false" aria-controls="collapseExampleLainnya">Selengkapnya...</button>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                    @endif
                  </div>
                </div>
                <div class="tab-pane show" id="tambah">
                  <form class="prosesForm" action="{{ route('setor') }}">
                    @csrf
                    <input type="hidden" name="saving_id" value="{{ $saving->id }}">
                    <div class="mb-3">
                      <label for="setortitle" class="form-label">Judul</label>
                      <input type="text" class="form-control" id="setortitle" name="title" value="{{ $saving->title }}">
                      <span class="text-danger title-error"></span>
                    </div>
                    <div class="mb-3">
                      <label for="setoramount" class="form-label">Jumlah</label>
                      <input type="number" class="form-control" id="setoramount" name="amount">
                      <span class="text-danger amount-error"></span>
                    </div>
                    <div class="mb-3">
                      <label for="setordescription" class="form-label">Deskripsi</label>
                      <textarea class="form-control" id="setordescription" name="description" rows="3">{{ $saving->description }}</textarea>
                      <span class="text-danger description-error"></span>
                    </div>
                    <div class="mb-3">
                      <div class="form-group">
                        <label>Gambar</label>
                        <div class="form-group service-upload mb-0">
                          <span><img src="{{ asset('assets/img/icons/drop-icon.svg') }}" alt="upload" /></span>
                          <h6 class="drop-browse align-center">
                            Letakan file disini atau
                            <span class="text-primary ms-1">browse</span>
                          </h6>
                          <p class="text-muted">Ukuran maksimal: 5MB</p>
                          <input type="file" name="attachment" id="image_sign" />
                          <div id="frames"></div>
                        </div>
                      </div>
                      <span class="text-danger attachment-error"></span>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                  </form>
                </div>
                <div class="tab-pane show" id="tarik">
                  <form class="prosesForm" action="{{ route('tarik') }}">
                    @csrf
                    <input type="hidden" name="saving_id" value="{{ $saving->id }}">
                    <div class="mb-3">
                      <label for="tariktitle" class="form-label">Judul</label>
                      <input type="text" class="form-control" id="tariktitle" name="title" value="{{ $saving->title }}">
                      <span class="text-danger title-error"></span>
                    </div>
                    <div class="mb-3">
                      <label for="tarikamount" class="form-label">Jumlah</label>
                      <input type="number" class="form-control" id="tarikamount" name="amount">
                      <span class="text-danger amount-error"></span>
                    </div>
                    <div class="mb-3">
                      <label for="tarikdescription" class="form-label">Deskripsi</label>
                      <textarea class="form-control" id="tarikdescription" name="description" rows="3">{{ $saving->description }}</textarea>
                      <span class="text-danger description-error"></span>
                    </div>
                    <button type="submit" class="btn btn-primary">Tarik</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-4">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Kontribusi</div>
            </div>
            <div class="card-body">
              <div class="chartjs-wrapper-demo">
                <canvas id="chartSaving" class="h-300"></canvas>
              </div>
            </div>
          </div>
          <div>
            <a href="{{ route('savings.index') }}" class="btn btn-primary" style="width: 100%">Kembali</a>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="modalImage" tabindex="-1" aria-labelledby="modalImageLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalImageLabel">Gambar Attachment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Tidak ada gambar</p>
        <img id="attachmentImage" src="" data-filename="">
        <i id="downloadIcon" class="fas fa-download"></i>
      </div>
    </div>
  </div>
</div>

<div class="modal custom-modal fade" id="inviteModal" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="modal-body">
        <div class="form-header">
          <h3>Undang Pengguna</h3>
          <p>Masukkan email yang ingin anda undang </p>
        </div>
        <div class="modal-btn delete-action">
          <div class="row">
            <form id="inviteForm">
              @csrf
              <input type="hidden" name="saving" value="{{ $saving->id }}">
              <input autofocus placeholder="example@mail.com" class="form-control" type="text" name="email" id="email">
              <div class="d-flex mt-3">
                <div class="col-6 me-2">
                  @csrf
                  <button type="submit" class="w-100 btn btn-primary paid-continue-btn">Undang</button>
                </div>
                <div class="col-6">
                  <button type="button" data-bs-dismiss="modal" class="w-100 btn btn-primary paid-cancel-btn">Batal</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@section('script')
<script src="{{ asset('assets/plugins/chartjs/chart.min.js') }}"></script>
<script src="{{ asset('assets/plugins/chartjs/chart-data.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
<script>
  $(function(){
    $(document).on("click", ".inCollapse", function(e){
      if(!e.target.value){
        e.target.value = "show";
        e.target.innerHTML = "Tutup..."
      } else {
        e.target.value = "";
        e.target.innerHTML = "Selengkapnya..."
      }
    });
    $("#accordion").on("click", function(e){
      if($(e.target).hasClass("buttonRowCollapse")){
        if($(".tableRowCollapse").hasClass("show"));
        $(".tableRowCollapse").removeClass("show");
        $(".inCollapse").val("");
        $(".inCollapse").html("Selengkapnya...")
      }
    });
    $('#keluar').on('click', function () {
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Anda tidak dapat mengembalikan aksi ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch("{{ route('out', $saving->id) }}")
          .then(async function(response){
            let json = await response.json();
            if(!response.ok){
              return Promise.reject(json);
            }
            return json;
          })
          .then(response => {
            toastr.success(response.message, 'Sukses');
            location.href = "{{ route('savings.index') }}";
          })
          .catch(error => {
            toastr.error(error.message, 'Error');
          });
        }
      })
    });

    $('#history').on('click', '.kick', function (e) {
      const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
      let user_id = this.dataset.id;
      let member = e.target.parentElement.parentElement.parentElement.parentElement;
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Anda tidak dapat mengembalikan aksi ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch("{{ route('kick') }}", {
            method: "post",
            headers:{
              'Content-Type': 'application/json',
              "X-CSRF-Token": csrfToken,
            },
            body: JSON.stringify({
              'saving_id': "{{ $saving->id }}",
              'user_id': user_id
            })
          })
          .then(async function(response){
            let json = await response.json();
            if(!response.ok){
              return Promise.reject(json);
            }
            return json;
          })
          .then(response => {
            toastr.success(response.message, 'Sukses');
            member.style.display = "none";
          })
          .catch(error => {
            toastr.error(error.message, 'Error');
          });
        }
      })
    });
  });
  $(document).on('click', 'button[data-bs-target="#modalImage"]', function() {
      let imageUrl = $(this).data('bs-image');
      let avaible = $(this).data('avaible');
      let img = document.getElementById("attachmentImage");
      $('#attachmentImage').attr('src', imageUrl);
      if(!avaible){
        img.previousElementSibling.style.display = "block";
        img.style.display = "none";
      } else {
        img.previousElementSibling.style.display = "none";
        img.style.display = "block";
      }
  });
  // Tampilkan ikon download saat gambar dihover
  $('#attachmentImage').hover(function() {
      $('#downloadIcon').show();
  }, function() {
      $('#downloadIcon').hide();
  });

  // Fungsi untuk mengunduh gambar saat gambar diklik
  $('#attachmentImage').click(function() {
      let imgSrc = $(this).attr('src');
      let fileName = $(this).data('filename'); // Ambil nama file dari atribut data
      let link = document.createElement('a');
      link.href = imgSrc;
      link.download = 'Attachment.jpg'; // Gunakan nama file dari atribut data
      link.click();
  });

  $('#inviteForm').submit(function(event) {
    event.preventDefault();
    let button = event.target.querySelector("button[type=submit]");
    button.innerHTML = /*html*/ `<span class="spinner-border spinner-border-sm me-2"></span> Mengundang...`
    button.setAttribute("disabled", "");
    let formData = $(this).serialize();
    $.ajax({
      url: "{{ route('invite') }}",
      method: 'POST',
      dataType: 'json',
      data: formData,
      success: function(response) {
        toastr.success(response.message, 'Sukses');
        $('#inviteModal').modal('hide');
        $('#email').val('')
      },
      error: function(error) {
        toastr.error(error.responseJSON.message.email[0], 'Error');
        button.innerHTML = /*html*/ `Undang`
        button.removeAttribute("disabled");
      }
    });
});
</script>
<script>
  let chartData = @json($chartData);
  let datapie = {
    labels: chartData.labels,
    datasets: [
      {
        data: chartData.data,
        backgroundColor: chartData.backgroundColor,
      },
    ],
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

  const ctx7 = document.getElementById("chartSaving");
  let myPieChart7 = new Chart(ctx7, {
    type: "pie",
    data: datapie,
    options: optionpie,
  });
</script>
<script>
  $('.prosesForm').submit(function(e) {
  e.preventDefault();
  let button = e.target.querySelector("button[type=submit]");
  button.innerHTML = /*html*/ `<span class="spinner-border spinner-border-sm me-2"></span> Memproses...`
  button.setAttribute("disabled", "");

  let formData = new FormData(this);
  let uri = e.target.getAttribute("action");

  $.ajax({
    url: uri,
    type: 'POST',
    data: formData,
    processData: false, // Hindari pemrosesan otomatis data
    contentType: false, // Hindari pengaturan otomatis tipe konten
    success: function(response) {
      toastr.success(response.message, 'Berhasil');
      location.reload();
    },
    error: function(xhr) {
      if (xhr.status === 422) {
        if(xhr.responseJSON.message){
          toastr.error(xhr.responseJSON.message, 'Gagal');
        } else {
          let errors = xhr.responseJSON.errors;
          // Reset pesan kesalahan sebelum menambahkan yang baru
          $('.text-danger').text('');
          $.each(errors, function(field, messages) {
            let errorMessage = messages[0]; // Ambil pesan kesalahan pertama
            e.target.querySelector("." + field + "-error").textContent = errorMessage;
          });
        }
        button.innerHTML = /*html*/ `Proses`;
        button.removeAttribute("disabled");
      }
    }
  });
});
</script>
@endsection
