<!DOCTYPE html>
<html>

<head>
    <title>Notifikasi Transaksi </title>
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
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            color: #333;
        }

        p {
            font-size: 16px;
            color: #555;
            line-height: 1.5;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Halo, {{ $name }}!</h1>
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
        <p><a href="">Konfirmasi Transaksi</a></p>
    </div>
</body>

</html>
