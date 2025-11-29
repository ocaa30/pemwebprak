<?php
include 'db.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$hashed_password', '$email')";

    if (mysqli_query($koneksi, $sql)) {
        $message = "🎉 Pendaftaran berhasil! Silakan Login.";
        $message_type = 'success';
    } else {
        if (mysqli_errno($koneksi) == 1062) {
            $message = "😢 Gagal mendaftar. Username sudah terdaftar.";
            $message_type = 'danger';
        } else {
            $message = "😭 Error: " . mysqli_error($koneksi);
            $message_type = 'danger';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-pink-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4 shadow-lg card-funky">
            <h2 class="text-center mb-4 text-purple">⭐ Ayo Daftar Akun! ⭐</h2>
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> text-center" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="register.php">
                <div class="mb-3">
                    <label for="username" class="form-label text-purple">Nama Pengguna:</label>
                    <input type="text" class="form-control input-funky" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label text-purple">Email:</label>
                    <input type="email" class="form-control input-funky" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-purple">Kata Sandi:</label>
                    <input type="password" class="form-control input-funky" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-purple-funky w-100 mt-3">Daftar Sekarang! 🚀</button>
            </form>
            <p class="mt-3 text-center">Sudah punya akun? <a href="login.php" class="text-pink">Ayo Login!</a></p>
        </div>
    </div>
</body>
</html>
