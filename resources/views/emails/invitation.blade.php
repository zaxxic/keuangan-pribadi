<!DOCTYPE html>
<html>
<head>
  <title>Undangan</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
</head>
<body>
  <main class="d-flex flex-column">
    <p class="h3 text-center">Anda telah diundang oleh {{ $name }} untuk masuk ke dalam Tabungan Bersama.</p>
    <p class="text-center">Klik link dibawah untuk bergabung</p>
    <a href="{{ route('join') }}?id={{ $id }}&key={{ $key }}" class="btn btn-primary">Gabung</a>
  </main>
</body>
</html>
