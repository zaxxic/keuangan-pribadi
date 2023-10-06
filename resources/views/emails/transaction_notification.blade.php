<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #4caf50;
            color: #ffffff;
            padding: 10px 0;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            padding: 20px;
        }
        .footer {
            background-color: #4caf50;
            color: #ffffff;
            text-align: center;
            padding: 10px 0;
            border-radius: 0 0 10px 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Notifikasi Transaksi</h1>
        </div>
        <div class="content">
            <p>Halo, {{ $name }}!</p>
            <p>Anda memiliki notifikasi transaksi:</p>
            <p>
                @if ($content === 'expenditure')
                    Pengeluaran
                @elseif ($content === 'income')
                    Pemasukan
                @else
                    {{ $content }}
                @endif
            </p>
            <p>Jumlah Transaksi: Rp {{ number_format($amount, 0, ',', '.') }}</p>
            <p>Silakan konfirmasi transaksi ini dengan mengklik tautan di bawah:</p>
            <p><a href="{{ Route("home") }}">Konfirmasi Transaksi</a></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Nama Perusahaan. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
