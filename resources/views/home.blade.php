<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <h1>Selamat Datang di POS System</h1>
    <ul>
        <li><a href="{{ route('user.show', ['id' => 1, 'name' => 'AtaBiki']) }}">Halaman User</a></li>
        <li><a href="{{ url('/category') }}">Halaman Produk</a></li>
        <li><a href="{{ route('sales.index') }}">Halaman Penjualan</a></li>
    </ul>
</body>

</html>