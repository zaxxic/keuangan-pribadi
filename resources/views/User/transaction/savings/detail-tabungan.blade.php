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
$now = HistorySaving::where('saving_id', $saving->id)->withSum('history', 'amount')->get();
$progress = $now->sum('history_sum_amount') / $saving->target_balance * 100;
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
                  <a href="#" class="btn-right btn btn-sm btn-outline-success"> Edit </a>
                  <a href="#" class="btn-right btn btn-sm btn-outline-danger" id="keluar"> Keluar </a>
                  <a href="#" class="btn-right btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#inviteModal"> Invite </a>
                </div>
              </div>
              <div class="dash-widget-header mb-4">
                <span class="dash-widget-icon bg-1">
                  <i class="fas fa-dollar-sign"></i>
                </span>
                <div class="dash-count" style="width: 60%">
                  <div class="dash-counts">
                    <p>Rp {{ number_format($now->sum('history_sum_amount'), 0, '', '.') }} / Rp {{ number_format($saving->target_balance, 0, '', '.') }}</p>
                  </div>
                  <div class="progress progress-sm mt-3">
                    <div class="progress-bar bg-5" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a href="#deskripsi" data-bs-toggle="tab" aria-expanded="false" class="nav-link active"> Deskripsi </a>
                </li>
                <li class="nav-item">
                  <a href="#anggota" data-bs-toggle="tab" aria-expanded="true" class="nav-link"> Anggota </a>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane show active" id="deskripsi">
                  {{ $saving->description }}
                </div>
                <div class="tab-pane" id="anggota">
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
                                  <button class="btn btn-primary" data-bs-target="#modalImage" data-bs-toggle="modal" data-bs-image="{{ asset('storage/income_attachment/' . $history->attachment) }}">Lihat</button>
                                </td>
                                <td><span class="badge bg-success-light">{{ $history->status }}</span></td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                          <div class="d-flex justify-content-between">
                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target=".collapseExample{{ $loop->index }}" aria-expanded="false" aria-controls="collapseExample{{ $loop->index }}">Show more...</button>
                            <a href="#" class="btn btn-danger kick" data-id="{{ $member->id }}">Kick</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-4">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Pie Chart</div>
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
        <img id="attachmentImage" src="" alt="Attachment" data-filename="">
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
    $("#accordion").on("click", function(e){
      if($(e.target).hasClass("buttonRowCollapse")){
        if($(".tableRowCollapse").hasClass("show"));
        $(".tableRowCollapse").removeClass("show");
      }
    });
    $('#keluar').on('click', function () {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
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

    $('#anggota').on('click', '.kick', function (e) {
      const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
      let user_id = this.dataset.id;
      let member = e.target.parentElement.parentElement.parentElement.parentElement;
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
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
      var imageUrl = $(this).data('bs-image');
      // console.log(imageUrl);
      $('#attachmentImage').attr('src', imageUrl);
  });
  // Tampilkan ikon download saat gambar dihover
  $('#attachmentImage').hover(function() {
      $('#downloadIcon').show();
  }, function() {
      $('#downloadIcon').hide();
  });

  // Fungsi untuk mengunduh gambar saat gambar diklik
  $('#attachmentImage').click(function() {
      var imgSrc = $(this).attr('src');
      var fileName = $(this).data('filename'); // Ambil nama file dari atribut data
      var link = document.createElement('a');
      link.href = imgSrc;
      link.download = 'Attachment'; // Gunakan nama file dari atribut data
      link.click();
  });

  $('#inviteForm').submit(function(event) {
    event.preventDefault();
    var formData = $(this).serialize();
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
@endsection
