<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran SPP</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f3f4f6;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        .header {
            padding: 20px;
            background-color: #4caf50;
            color: #fff;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        h1 {
            margin-top: 0;
            font-weight: 700;
        }
        .content {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .btn {
            display: inline-block;
            background-color: #4caf50;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-right: 10px;
        }
        .btn:last-child {
            margin-right: 0;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .footer {
            margin-top: 50px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Sistem Pembayaran SPP</h1>
            <p>Bayar SPP dengan mudah dan cepat</p>
        </div>
        <div class="content">
            <h2>Selamat datang di Sistem Pembayaran SPP!</h2>
            <p>Silakan masuk atau daftar untuk mengakses layanan pembayaran SPP.</p>
            <a href="{{ route('login') }}" class="btn">Masuk</a>
            <a href="{{ route('register') }}" class="btn">Daftar</a>
        </div>
        <div class="footer">
            
        </div>
    </div>
</body>
</html>
