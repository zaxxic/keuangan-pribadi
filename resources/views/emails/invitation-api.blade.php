<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan</title>
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

        .btn-primary {
            background-color: #4caf50;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Undangan Tabungan Bersama</h1>
        </div>
        <div class="content">
            <p class="h3 text-center">Anda telah diundang oleh {{ $name }} untuk masuk ke dalam Tabungan Bersama.
            </p>
            <p class="text-center">Klik link di bawah untuk bergabung:</p>
            <p class="text-center"><a href="{{ route('join.api') }}?id={{ $id }}&key={{ $key }}"
                    class="btn btn-primary">Gabung</a></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Nama Perusahaan. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
