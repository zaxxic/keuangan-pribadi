@extends('layouts1.app')
@section('content')
@section('style')
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 40px;
        }

        .card {
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 14px;
            color: #6c757d;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }
    </style>
@endsection
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="content-page-header">
                <h5>Pilih metode pembayaran</h5>
                <a href="{{ route('subs.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>

        <div class="price-table-main">
            <div class="row">
                <div class="container">
                    <div class="row">
                        @foreach ($channels as $channel)
                            <div class="col-md-3 mb-4">
                                <div class="card">
                                    <img src="{{ $channel->icon_url }}" class="card-img-top" alt="Channel Icon">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $channel->name }}</h5>
                                        <form action="{{ route('transaction.store') }}" method="POST" target="_blank">
                                            @csrf
                                            <input type="hidden" name="package_id" value="{{ $package->id }}">
                                            <input type="hidden" name="method" value="{{ $channel->code }}">
                                            <button class="btn btn-primary" type="submit">Bayar Sekarang</button>
                                        </form>
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
@endsection
