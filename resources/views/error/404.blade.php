<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:300');

    body {
        background: #3498DB;
        color: #fff;
        font-family: 'Montserrat', sans-serif;
        font-size: 16px;
    }

    h1 {
        font-size: 20vh;
    }

    h2 span {
        font-size: 4rem;
        font-weight: 600;
    }

    a:link,
    a:visited {
        text-decoration: none;
        color: #fff;
    }

    h3 a:hover {
        text-decoration: none;
        background: #fff;
        color: #3498DB;
        cursor: pointer;
    }
</style>

<body>
    <div class="container">
        <h1>:(</h1><br>
        <h2>A <span>404</span>  Halaman yang dicoba diakses tidak ditemukan.</h2><br>
        <h3><a href="{{Route("home")}}">Kembali ke halaman utama</a>&nbsp;|&nbsp;<a href="javascript:history.back()">Kembali</a></h3>
    </div>
</body>

</html>
