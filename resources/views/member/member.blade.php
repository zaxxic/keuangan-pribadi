@extends('layouts1.app')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="content-page-header ">
                    <h5>Member</h5>

                </div>
            </div>


            <div class="price-table-main">
                <div class="row">
                    @foreach ($packages as $key => $package)
                        <div class="col-lg-4 col-md-12">
                            @if ($key == 1)
                                <!-- Check if it's the second item -->
                                <div class="card price-selected">
                                    <div class="card-body plan-header-selected">
                                        <div class="d-flex">
                                            <div class="plan-header">
                                                <span class="plan-widget-icon">
                                                    <img src="assets/img/icons/plan-price-02.svg" alt>
                                                </span>
                                                <div class="plan-title">
                                                    <h6 class="text-white">{{ $package->title }}</h6>
                                                    <h4 class="plan-name text-white">{{ $package->bonus }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="description-content">
                                            <p>Dapatkan fitur premium untuk akses penuh </p>
                                        </div>
                                        <div class="price-dollar">
                                            <h1 class="d-flex align-items-center text-white">Rp 400.000<span
                                                    class="text-white ms-1">/Tahun</span></h1>
                                        </div>
                                        <div class="plan-description">
                                            <h6 class="text-white">Apa yang di dapatkan
                                            </h6>
                                            <ul>
                                                <li>
                                                    <span class="rounded-circle bg-white me-2"><i
                                                            class="text-primary fe fe-check"></i></span>
                                                    Pemasukan Berulang
                                                </li>
                                                <li>
                                                    <span class="rounded-circle bg-white me-2"><i
                                                            class="text-primary fe fe-check"></i></span>
                                                    Pengeluaran Berulang
                                                </li>
                                                <li>
                                                    <span class="rounded-circle bg-white me-2"><i
                                                            class="text-primary fe fe-check"></i></span>
                                                    Export transaksi ke excel
                                                </li>
                                                <li>
                                                    <span class="rounded-circle bg-white me-2"><i
                                                            class="text-primary fe fe-check"></i></span>
                                                    DLL...
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="plan-button">
                                            <a class="btn btn-white d-flex align-items-center justify-content-center"
                                                href="{{ route('subs', ['id' => $package->id]) }}">Mulai sekarang<span
                                                    class="ms-2"><i class="fe fe-arrow-right"></i></span></a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="card">
                                    <div class="card-body">
                                        <!-- Regular item content here -->
                                        <div class="plan-header">
                                            <span class="plan-widget-icon">
                                                <img src="assets/img/icons/plan-price-01.svg" alt>
                                            </span>
                                            <div class="plan-title">
                                                <h6>{{ $package->title }}</h6>
                                                <h4 class="plan-name">{{ $package->bonus }}</h4>
                                            </div>
                                        </div>
                                        <div class="description-content">
                                            <p>Dapatkan fitur premium untuk akses penuh</p>
                                        </div>
                                        <div class="price-dollar">
                                            <h1 class="d-flex align-items-center">Rp
                                                {{ number_format($package->amount, 0, ',', '.') }}
                                                <span class="ms-1">/bulan</span>
                                            </h1>
                                        </div>
                                        <div class="plan-description">
                                            <h6>Apa yang di dapatkan</h6>
                                            <ul>
                                                <li class="mt-2">
                                                    <span class="rounded-circle me-2"><i class="fe fe-check"></i></span>
                                                    Pemasukan Berulang
                                                </li>
                                                <li class="mt-2">
                                                    <span class="rounded-circle me-2"><i class="fe fe-check"></i></span>
                                                    Pengeluaran Berulang
                                                </li>
                                                <li class="mt-2">
                                                    <span class="rounded-circle me-2"><i class="fe fe-check"></i></span>
                                                    Export transaksi ke excel
                                                </li>
                                                <li class="mt-2">
                                                    <span class="rounded-circle me-2"><i class="fe fe-check"></i></span>
                                                    DLL...
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="plan-button">
                                            <a class="btn btn-primary d-flex align-items-center justify-content-center"
                                                href="{{ route('subs', ['id' => $package->id]) }}">Mulai sekarang<span
                                                    class="ms-2"><i class="fe fe-arrow-right"></i></a>

                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach


                    {{-- <div class="col-lg-4 col-md-12">
                        <div class="card price-selected">
                            <div class="card-body plan-header-selected">
                                <div class="d-flex">
                                    <div class="plan-header">
                                        <span class="plan-widget-icon">
                                            <img src="assets/img/icons/plan-price-02.svg" alt>
                                        </span>
                                        <div class="plan-title">
                                            <h6 class="text-white">Member 1 tahuan</h6>
                                            <h4 class="plan-name text-white">Gratis 4 Bulan pertama</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="description-content">
                                    <p>Dapatkan fitur premium untuk akses penuh </p>
                                </div>
                                <div class="price-dollar">
                                    <h1 class="d-flex align-items-center text-white">Rp 400.000<span
                                            class="text-white ms-1">/Tahun</span></h1>
                                </div>
                                <div class="plan-description">
                                    <h6 class="text-white">Apa yang di dapatkan
                                    </h6>
                                    <ul>
                                        <li>
                                            <span class="rounded-circle bg-white me-2"><i
                                                    class="text-primary fe fe-check"></i></span>
                                            Pemasukan Berulang
                                        </li>
                                        <li>
                                            <span class="rounded-circle bg-white me-2"><i
                                                    class="text-primary fe fe-check"></i></span>
                                            Pengeluaran Berulang
                                        </li>
                                        <li>
                                            <span class="rounded-circle bg-white me-2"><i
                                                    class="text-primary fe fe-check"></i></span>
                                            Export transaksi ke excel
                                        </li>
                                        <li>
                                            <span class="rounded-circle bg-white me-2"><i
                                                    class="text-primary fe fe-check"></i></span>
                                            DLL...
                                        </li>
                                    </ul>
                                </div>
                                <div class="plan-button">
                                    <a class="btn btn-white d-flex align-items-center justify-content-center"
                                        href="{{ Route('subs') }}">Get Started<span class="ms-2"><i
                                                class="fe fe-arrow-right"></i></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="plan-header">
                                    <span class="plan-widget-icon">
                                        <img src="assets/img/icons/plan-price-03.svg" alt>
                                    </span>
                                    <div class="plan-title">
                                        <h6>Member Bulanan</h6>
                                        <h4 class="plan-name">Gratis 2 Bulan</h4>
                                    </div>
                                </div>
                                <div class="description-content">
                                    <p>Dapatkan fitur premium untuk akses penuh</p>
                                </div>
                                <div class="price-dollar">
                                    <h1 class="d-flex align-items-center">Rp 200.000<span class="ms-1">/6 bulan</span>
                                    </h1>
                                </div>
                                <div class="plan-description">
                                    <h6>Apa yang di dapatkan</h6>
                                    <ul>
                                        <li class="mt-2">
                                            <span class="rounded-circle me-2"><i class="fe fe-check"></i></span>
                                            Pemasukan Berulang
                                        </li>
                                        <li class="mt-2">
                                            <span class="rounded-circle me-2"><i class="fe fe-check"></i></span>
                                            Pengeluaran Berulang
                                        </li>
                                        <li class="mt-2">
                                            <span class="rounded-circle me-2"><i class="fe fe-check"></i></span>
                                            Export transaksi ke excel
                                        </li>
                                        <li class="mt-2">
                                            <span class="rounded-circle me-2"><i class="fe fe-check"></i></span>
                                            DLL...
                                        </li>
                                    </ul>
                                </div>
                                <div class="plan-button">
                                    <a class="btn btn-primary d-flex align-items-center justify-content-center"
                                        href="{{ Route('subs') }}">Get Started<span class="ms-2"><i
                                                class="fe fe-arrow-right"></i></a>

                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>

        </div>
    </div>
@endsection
