<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        p {
            color: #555;
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        h2 {
            color: #007bff;
            font-size: 24px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Verifikasi Email</h1>
        <p>Terima kasih telah mendaftar di situs web kami. Untuk melakukan verifikasi alamat email Anda, gunakan kode berikut:</p>
        <h2>{{ $verificationCode }}</h2>
        <p>Jika Anda tidak meminta kode verifikasi ini, silakan abaikan email ini.</p>
    </div>
</body>
</html>
