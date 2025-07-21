<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | Baroon Reptile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #2d5a27 0%, #4a7c59 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-container {
            text-align: center;
            color: white;
            max-width: 600px;
            padding: 2rem;
        }
        .error-code {
            font-size: 8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .error-message {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        .btn-home {
            background: #ffffff;
            color: #2d5a27;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .btn-home:hover {
            background: #f8f9fa;
            color: #2d5a27;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .reptile-icon {
            font-size: 4rem;
            margin-bottom: 2rem;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="reptile-icon">
            <i class="fas fa-dragon"></i>
        </div>
        <div class="error-code">404</div>
        <div class="error-message">
            Oops! Halaman yang Anda cari tidak ditemukan.
        </div>
        <p class="mb-4">Halaman mungkin telah dipindahkan, dihapus, atau URL yang Anda masukkan salah.</p>
        <a href="/baroonreptil/" class="btn-home">
            <i class="fas fa-home me-2"></i>Kembali ke Beranda
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>