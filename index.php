<?php
include 'db.php'; 

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === TRUE) {
    header('Location: dashboard.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang! - App Ceria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-purple-light">
    
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-5 shadow-lg card-funky text-center" style="max-width: 600px; border-style: solid;">
            
            <h1 class="display-3 text-pink mb-4">✨ Aplikasi Ceria! ✨</h1>
            <p class="lead text-purple mb-5">
                Tempat terbaik untuk menyimpan file-file lucu dan ceria Anda. Ayo bergabung dan mulai berbagi kebahagiaan!
            </p>

            <div class="d-grid gap-3 col-8 mx-auto">
                <a href="login.php" class="btn btn-purple-funky btn-lg">
                    🔑 Masuk ke Dunia Ajaib!
                </a>
                <a href="register.php" class="btn btn-pink-funky btn-lg">
                    📝 Daftar Akun Baru!
                </a>
            </div>

            <hr class="my-4 border-pink-funky">

            <p class="text-muted small">
                Dibuat dengan semangat ceria dan penuh warna.
            </p>
        </div>
    </div>

</body>
</html>
