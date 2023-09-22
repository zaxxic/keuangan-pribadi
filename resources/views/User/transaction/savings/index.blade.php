@php
use App\Models\HistorySaving;
@endphp

@extends('layouts1.app')
@section('content')
<div class="page-wrapper">
  <div class="content container-fluid">

    <div class="page-header">
      <div class="content-page-header">
        <h5>Tabungan</h5>
        <div class="list-btn">
          <ul class="filter-list">
            <li>
              <div class="input-group" style="max-width: 450px;">
                <input type="text" class="form-control" placeholder="Cari Pemasukan" id="searchCategory">
                <a class="btn btn-primary" href="{{ route('savings.create') }}"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Tambah Tabungan</a>
              </div>
            </li>


          </ul>
        </div>
      </div>

    </div>
    <div class="row">
      @foreach ($savings as $saving)
      @php
      $now = HistorySaving::where('saving_id', $saving->id)->withSum('history', 'amount')->get()->sum('history_sum_amount');
      $progress = $now / $saving->target_balance * 100;
      $progress = intval(round($progress));
      @endphp
      <div class="col-12 col-md-6 col-lg-3 datakuu">
        <div class="card flex-fill bg-white">
          <img alt="Card Image" src="assets/img/{{ $saving->cover }}" class="card-img-top">
          <div class="card-header">
            <h5 class="card-title mb-0">{{ $saving->title }}</h5>
            <div class="progress">
              <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="text-center mt-2">
              <span>Rp. {{ number_format($now, 0, '', '.') }} / Rp. {{ number_format($saving->target_balance, 0, '', '.') }}</span>
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
                  <small>Tanggal: {{ date("d-m-Y", strtotime($saving->created_at)) }}</small>
                </div>
              </div>
            </div>
            <p id="description{{ $loop->iteration }}" class="card-text mt-2" id="description">
              {{ mb_strimwidth($saving->description, 0, 50, '...') }}
            </p>
            <a href="javascript:void(0);" onclick="showDescription({{ $loop->iteration }})" id="readMoreLink{{ $loop->iteration }}">Selengkapnya</a>
            <p id="fullDescription{{ $loop->iteration }}" style="display:none;">{{ $saving->description }}</p>
            <div class="d-flex justify-content-between mt-1">
              <a class="btn btn-primary" href="{{ route('savings.show', $saving->id) }}">Lihat</a>
              <button class="btn btn-success"><i class="fe fe-edit"></i></button>
              <button class="btn btn-danger"><i class="fe fe-trash"></i></button>
            </div>
          </div>
        </div>
      </div>

      @endforeach

    </div>

  </div>
</div>
@endsection
@section('script')
<script>
  $("#searchCategory").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".row .datakuu").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });
  function showDescription(iteration) {
    var description = document.getElementById('description' + iteration);
    var fullDescription = document.getElementById('fullDescription' + iteration);
    var readMoreLink = document.getElementById('readMoreLink' + iteration);

    if (description.style.display === 'none') {
      description.style.display = 'inline-block';
      fullDescription.style.display = 'none';
      readMoreLink.innerHTML = 'Selangkapnya';
    } else {
      description.style.display = 'none';
      fullDescription.style.display = 'inline-block';
      readMoreLink.innerHTML = 'Tutup';
    }
  }
</script>
{{-- <script>
  var isDescriptionExpanded = false;

    function toggleDescription() {
        var descriptionElement = document.getElementById("description");
        var readMoreLink = document.getElementById("readMoreLink");

        if (isDescriptionExpanded) {
            descriptionElement.innerHTML = descriptionElement.innerHTML.substring(0, 60) + '...';
            readMoreLink.textContent = "Read More";
        } else {
            descriptionElement.innerHTML =
                "Some quick example text to build on the card title and make up the bulk of the card's content.";
            readMoreLink.textContent = "Read Less";
        }

        isDescriptionExpanded = !isDescriptionExpanded;
    }
</script> --}}
@endsection
