<?php
include 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $sql = "SELECT id, username, password FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            
            header('Location: dashboard.php');
            exit;
        } else {
            $message = "❌ Password salah! Coba lagi.";
        }
    } else {
        $message = "😥 Username tidak ditemukan.";
    }
}

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
    <title>Login Lucu Abis!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-pink-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4 shadow-lg card-funky">
            <h2 class="text-center mb-4 text-purple">🔑 Masuk ke Dunia Ajaib! 🔑</h2>
            <?php if ($message): ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label for="username" class="form-label text-purple">Nama Pengguna:</label>
                    <input type="text" class="form-control input-funky" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-purple">Kata Sandi:</label>
                    <input type="password" class="form-control input-funky" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-purple-funky w-100 mt-3">Gas Login! 💨</button>
            </form>
            <p class="mt-3 text-center">Belum punya akun? <a href="register.php" class="text-pink">Daftar di sini!</a></p>
        </div>
    </div>
</body>
</html>
