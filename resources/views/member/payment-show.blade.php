<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembayaran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .payment-details {
            max-width: 600px;
            margin: 0 auto;
            margin-top: 50px;
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card {
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .card-text {
            font-size: 16px;
            color: #555;
        }

        .card-text strong {
            font-weight: bold;
        }

        .text-success {
            color: #28a745;
        }

        .card-header button {
            font-size: 16px;
            color: #333;
            width: 100%;
            text-align: left;
            padding: 0;
        }

        .card-header button:hover {
            text-decoration: underline;
        }

        .card-body img {
            display: block;
            margin: 10px auto;
            max-width: 200px;
        }

        .list-group-item {
            font-size: 14px;
            color: #555;
            padding: 8px;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container payment-details">
        <h2 class="mb-4">Detail Pembayaran</h2>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Informasi Paket</h5>
                <p class="card-text"><strong>Harga:</strong> Rp. {{ number_format($transaction->amount) }}</p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Status Pembayaran</h5>
                <p class="card-text"><strong>Status:</strong>
                    <span class="{{ $transaction->status === 'PAID' ? 'badge badge-success' : 'badge badge-danger' }}">
                        {{ $transaction->status }}
                    </span>
                </p>
                <p class="card-text"><strong>Referensi transaksi:</strong> {{ $detail->reference }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Instruksi Pembayaran</h5>
                <div id="accordion">
                    <div class="card">
                        @if (isset($detail->qr_url))
                            <p class="card-text text-center">Scan untuk membayar</p>

                            <img src="{{ $detail->qr_url }}" alt="QR Code" width="200px"
                                class="img-fluid mx-auto d-block mb-3">
                        @else
                        @endif
                        @foreach ($detail->instructions as $index => $transaction)
                            <div class="card-header" id="heading{{ $index }}">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" style="text-decoration: none"
                                        data-target="#collapse{{ $index }}" aria-expanded="false"
                                        aria-controls="collapse{{ $index }}">
                                        {{ $transaction->title }}
                                    </button>
                                </h5>
                            </div>

                            <div id="collapse{{ $index }}" class="collapse"
                                aria-labelledby="heading{{ $index }}" data-parent="#accordion">
                                <div class="card-body">

                                    {{-- <img src="{{ $transaction->qr_url }}" alt=""> --}}
                                    <ul class="list-group list-group-flush">
                                        @foreach ($transaction->steps as $step)
                                            <li class="list-group-item">
                                                {{ $loop->iteration }}. {!! $step !!}
                                            </li>
                                        @endforeach
                                    </ul>

                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>
