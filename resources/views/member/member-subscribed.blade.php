@extends('layouts1.app')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="content-page-header ">
                    <h5>Member yang sudah di pilih</h5>
                </div>
            </div>
            <div class="price-table-main">
                <div class="row">
                    <div class="col-lg-4 col-md-12 mx-auto">
                        <div class="card price-selected">
                            <div class="card-body plan-header-selected">
                                <div class="d-flex">
                                    <div class="plan-header">
                                        <span class="plan-widget-icon">
                                            <img src="assets/img/icons/plan-price-02.svg" alt>
                                        </span>
                                        <div class="plan-title">
                                            <h6 class="text-white">{{ $subscribe->title }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="description-content">
                                    <p class="text-white">Dapatkan fitur premium untuk akses penuh </p>
                                </div>
                                <div class="price-dollar">
                                    <h1 class="d-flex align-items-center text-white">
                                        {{ number_format($subscribe->amount, 0, ',', '.') }}<span class="text-white ms-1">
                                        </span></h1>
                                </div>
                                <div class="plan-description">
                                    <h6 class="text-white">Apa yang di dapatkan
                                    </h6>
                                    <ul>
                                        <li class="text-white">
                                            <span class="rounded-circle bg-white me-2"><i
                                                    class="text-primary fe fe-check"></i></span>
                                            Pemasukan Berulang
                                        </li>
                                        <li class="text-white">
                                            <span class="rounded-circle bg-white me-2"><i
                                                    class="text-primary fe fe-check"></i></span>
                                            Pengeluaran Berulang
                                        </li>
                                        <li class="text-white">
                                            <span class="rounded-circle bg-white me-2"><i
                                                    class="text-primary fe fe-check"></i></span>
                                            Export transaksi ke excel
                                        </li>
                                        <li class="text-white">
                                            <span class="rounded-circle bg-white me-2"><i
                                                    class="text-primary fe fe-check"></i></span>
                                            DLL...
                                        </li>
                                    </ul>
                                </div>
                                <div class="plan-button">
                                    <a id="countdown" class="btn btn-white d-flex align-items-center justify-content-center"
                                        style="cursor: default;"></a>


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
    <script>
        // Tanggal expire dari backend
        var expireDate = new Date("{{ $subscribe->expire_date }}").getTime();

        // Update hitungan mundur setiap 1 detik
        var countdownInterval = setInterval(function() {
            var now = new Date().getTime();
            var distance = expireDate - now;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            var countdownText = days + "H " + hours + "J " + minutes + "M " + seconds + "D ";

            document.getElementById("countdown").innerText = countdownText;

            // Jika waktu expire telah tercapai
            if (distance < 0) {
                clearInterval(countdownInterval);
                document.getElementById("countdown").innerText = "Waktu telah habis";
            }
        }, 1000);
    </script>
@endsection
