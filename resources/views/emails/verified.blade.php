<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
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
            <h1>Verifikasi Email</h1>
        </div>
        <div class="content">
            <p>Terima kasih telah mendaftar di situs web kami. Untuk melakukan verifikasi alamat email Anda, gunakan
                kode berikut:</p>
            <h2>{{ $verificationCode }}</h2>
            <p>Jika Anda tidak meminta kode verifikasi ini, silakan abaikan email ini.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Nama Perusahaan. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
