<?php
include 'db.php'; 

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];
$upload_message = '';
$upload_message_type = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file_upload'])) {
    $target_dir = "uploads/";
    
    if (!is_dir($target_dir)) {
        
        if (!mkdir($target_dir, 0777, true)) {
            $upload_message = "❌ Gagal membuat folder uploads. Mohon buat manual dan atur izinnya.";
            $upload_message_type = 'danger';
            goto end_upload_logic; 
        }
    }
    
    
    $file_extension = pathinfo($_FILES["file_upload"]["name"], PATHINFO_EXTENSION);
    $new_file_name = $_SESSION['id'] . '_' . time() . '.' . strtolower($file_extension);
    $target_file = $target_dir . $new_file_name;
    
    $uploadOk = 1;
    $fileType = strtolower($file_extension);

    
    if ($_FILES["file_upload"]["size"] > 5000000) {
        $upload_message = "Ukuran file terlalu besar. Maksimal 5MB.";
        $uploadOk = 0;
    }

    
    $allowed_types = array("jpg", "png", "jpeg", "gif", "pdf");
    if (!in_array($fileType, $allowed_types)) {
        $upload_message = "Hanya file JPG, JPEG, PNG, GIF, & PDF yang diizinkan.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        $upload_message_type = 'danger';
        $upload_message = "❌ Upload Gagal: " . $upload_message;

    } else {
        
        if (!is_writable($target_dir)) {
             $upload_message = "❌ Folder 'uploads/' tidak memiliki izin tulis (permissions) yang benar. Silakan cek izinnya!";
             $upload_message_type = 'danger';
        } elseif (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $target_file)) {
            $upload_message = "✅ File **" . htmlspecialchars($new_file_name) . "** berhasil diunggah!";
            $upload_message_type = 'success';
        } else {
            $upload_message = "❌ Terjadi kesalahan saat memindahkan file. (Kemungkinan izin folder salah atau file terlalu besar)";
            $upload_message_type = 'danger';
        }
    }
}
end_upload_logic: 


?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Ceria!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-purple-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-purple-funky shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">🌈 Dashboard Ceria!</a>
            <span class="navbar-text text-white">
                Halo, **<?php echo htmlspecialchars($username); ?>**!
            </span>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="btn btn-pink-funky" href="logout.php">Keluar 🚪</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        
        <div class="jumbotron bg-pink-funky text-center p-5 rounded-3 shadow-lg mb-5">
            <h1 class="display-4 text-white">🥳 Selamat Datang di Dashboard!</h1>
            <p class="lead text-white">Anda berhasil login sebagai **<?php echo htmlspecialchars($username); ?>**.</p>
            <hr class="my-4 border-white-50">
            <p class="text-white">Ini adalah area rahasia, jaga baik-baik datamu ya!</p>
        </div>
        
        <div class="card p-4 shadow-lg mb-5 card-funky-upload">
            <h4 class="text-purple mb-4">⬆️ Unggah File Lucu Anda:</h4>
            
            <?php if ($upload_message): ?>
                <div class="alert alert-<?php echo $upload_message_type; ?>" role="alert">
                    <?php echo $upload_message; ?>
                </div>
            <?php endif; ?>

            <form action="dashboard.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <input class="form-control input-funky" type="file" id="file_upload" name="file_upload" required>
                </div>
                <button type="submit" class="btn btn-purple-funky w-100">Upload Sekarang! 🎁</button>
            </form>
        </div>

        <hr>

        <div class="card p-3 mt-4 shadow-sm mb-5">
            <h4 class="text-purple">📂 Daftar File Uploads Anda:</h4>
            <ul class="list-group">
            <?php
            $upload_dir = 'uploads/';
            

            $files_raw = @scandir($upload_dir);
        
            if ($files_raw === false) {
                echo '<li class="list-group-item bg-warning text-dark">
                        Folder **uploads** tidak ditemukan. Silakan buat folder uploads/ di direktori PemwebPrak.
                      </li>';
            } else {
                $files = array_diff($files_raw, array('.', '..'));
                
                if (empty($files)) {
                    echo '<li class="list-group-item">Belum ada file yang diunggah.</li>';
                } else {
                    $found_user_files = false;
                    foreach ($files as $file) {
                        if (strpos($file, $_SESSION['id'] . '_') === 0) {
                            $file_url = 'http://localhost/PemwebPrak/uploads/' . urlencode($file); 
                            echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                            echo '<span class="text-muted small">' . htmlspecialchars($file) . '</span>';
                            echo '<a href="' . htmlspecialchars($file_url) . '" target="_blank" class="btn btn-sm btn-outline-pink">Lihat</a>';
                            echo '</li>';
                            $found_user_files = true;
                        }
                    }
                    if (!$found_user_files) {
                        echo '<li class="list-group-item">Anda belum mengunggah file apa pun.</li>';
                    }
                }
            }
            ?>
            </ul>
        </div>
        </div>
</body>
</html>
