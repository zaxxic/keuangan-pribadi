@php
  use App\Models\HistorySaving;
  use App\Models\HistoryTransaction;
@endphp

@extends("layouts1.app")
@section("content")
  <div class="page-wrapper">
    <div class="content container-fluid">
      <div class="page-header">
        <div class="content-page-header">
          <h5>Tabungan</h5>
          <div class="list-btn">
            <ul class="filter-list">
              <li>
                <div class="input-group" style="max-width: 450px;">
                  <a class="btn btn-primary" href="{{ route("savings.create") }}"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Tambah Tabungan</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <form>
          <div class="input-group" style="max-width: 450px;">
            <input class="form-control" name="s" type="text" value="{{ request()->get("s") }}" placeholder="Tabungan">
            <button class="btn btn-primary"><i class="fa fa-search"></i></button>
          </div>
        </form>
      </div>

      <div class="row">
        @foreach ($savings as $saving)
          @php
            $income = HistorySaving::where("saving_id", $saving->id)
                ->whereHas("history", function ($q) {
                    $q->where("status", "paid")->where("content", "expenditure");
                })
                ->withSum("history", "amount")
                ->get();
            $expenditure = HistorySaving::where("saving_id", $saving->id)
                ->whereHas("history", function ($q) {
                    $q->where("status", "paid")->where("content", "income");
                })
                ->withSum("history", "amount")
                ->get();
            $now = $income->sum("history_sum_amount") - $expenditure->sum("history_sum_amount");
            $progress = ($now / $saving->target_balance) * 100;
            $progress = intval(round($progress));
          @endphp
          <div class="col-12 col-md-6 col-lg-3 datakuu">
            <div class="card flex-fill bg-white">
              <img class="card-img-top" src="assets/img/{{ $saving->cover }}" alt="Card Image">
              <div class="card-header">
                @if ($saving->status == false)
                  <span class="badge rounded-pill text-bg-danger">Terkunci</span>
                @endif
                <h5 class="card-title mb-0">{{ $saving->title }}</h5>
                <div class="progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $progress }}%"></div>
                </div>
                <div class="text-center mt-2">
                  <span>Rp. {{ number_format($now, 0, "", ".") }} / Rp. {{ number_format($saving->target_balance, 0, "", ".") }}</span>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex ">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                      <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0-18 0" />
                      <path d="M9 10a3 3 0 1 0 6 0a3 3 0 1 0-6 0m-2.832 8.849A4 4 0 0 1 10 16h4a4 4 0 0 1 3.834 2.855" />
                    </g>
                  </svg>
                  <span class="mt-1" style="font-size: 15px">{{ count($saving->members) + 1 }}</span>

                  <div class="icon-text-container ms-4 mt-1">
                    <div class="text-right">
                      <small>Tanggal: {{ date("d, M Y", strtotime($saving->created_at)) }}</small>
                    </div>
                  </div>
                </div>
                <p class="card-text mt-2" id="description">
                  {{ mb_strimwidth($saving->description, 0, 50, "...") }}
                </p>
                <div class="d-flex justify-content-between mt-1">
                  <a class="btn btn-primary" href="{{ route("savings.show", $saving->id) }}">Lihat</a>
                  @can("owner", $saving)
                    <a class="btn btn-success" href="{{ route("savings.edit", $saving->id) }}"><i class="fe fe-edit"></i></a>
                    <a class="btn btn-danger delete-saving" data-id="{{ $saving->id }}" data-route="{{ route("savings.destroy", $saving->id) }}" href="#"><i class="fe fe-trash"></i></a>
                  @endcan
                </div>
              </div>
            </div>
          </div>
        @endforeach

      </div>

      {{ $savings->links() }}

    </div>
  </div>
@endsection
@section("script")
  <script src="{{ asset("assets/plugins/sweetalert/sweetalert2.all.min.js") }}"></script>
  <script src="{{ asset("assets/plugins/sweetalert/sweetalerts.min.js") }}"></script>
  {{-- <script>
  $("#searchCategory").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".row .datakuu").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });
</script> --}}
  <script>
    $(document).on('click', '.delete-saving', function(e) {
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
              toastr.success(response.message, 'Sukses');
              location.reload();
            },
            error: function(error) {
              console.log(error);
              toastr.error(error.responseJSON.message, 'Error');
            }
          });
        }
      });
    });
  </script>
@endsection
