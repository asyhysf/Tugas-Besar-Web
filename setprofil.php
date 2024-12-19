<?php
session_start();
require 'koneksi.php'; // Koneksi ke database

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username']; // Ambil username dari sesi

// Ambil data pengguna dari database
$query = "SELECT username, email, foto_profil FROM users WHERE username = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$email = $user['email'];
$foto_profil = $user['foto_profil'] ?? 'assets/profile.png'; // Default foto profil jika kosong

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_baru = $_POST['email'];
    $password_baru = $_POST['password'] ?? null; // Ambil password jika diisi
    $foto_profil_baru = $foto_profil; // Default ke foto sebelumnya jika tidak ada upload baru

    // Proses upload foto profil jika ada file baru
    if (!empty($_FILES['foto_profil']['name'])) {
        $target_dir = "uploads/"; // Folder tujuan
        if (!is_dir($target_dir)) mkdir($target_dir, 0755, true); // Buat folder jika belum ada

        $file_name = time() . '_' . basename($_FILES['foto_profil']['name']); // Rename file unik
        $target_file = $target_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $file_size = $_FILES['foto_profil']['size'];

        // Validasi file
        $valid_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($file_type, $valid_extensions)) {
            $error = "Format file tidak valid. Harus JPG, JPEG, PNG, atau GIF.";
        } elseif ($file_size > 2 * 1024 * 1024) { // Maksimum 2MB
            $error = "Ukuran file terlalu besar. Maksimum 2MB.";
        } elseif (!getimagesize($_FILES['foto_profil']['tmp_name'])) {
            $error = "File bukan gambar.";
        } else {
            // Hapus foto lama jika bukan default
            if ($foto_profil !== 'assets/profile.png' && file_exists($foto_profil)) {
                unlink($foto_profil);
            }
            // Pindahkan file yang diunggah
            if (move_uploaded_file($_FILES['foto_profil']['tmp_name'], $target_file)) {
                $foto_profil_baru = $target_file;
            } else {
                $error = "Gagal mengunggah file.";
            }
        }
    }

    // Jika tidak ada error, update data ke database
    if (!isset($error)) {
        if ($password_baru) {
            // Hash password baru
            $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
            $update_query = "UPDATE users SET email = ?, password = ?, foto_profil = ? WHERE username = ?";
            $stmt = $koneksi->prepare($update_query);
            $stmt->bind_param("ssss", $email_baru, $password_hash, $foto_profil_baru, $username);
        } else {
            // Update tanpa password
            $update_query = "UPDATE users SET email = ?, foto_profil = ? WHERE username = ?";
            $stmt = $koneksi->prepare($update_query);
            $stmt->bind_param("sss", $email_baru, $foto_profil_baru, $username);
        }

        if ($stmt->execute()) {
            $_SESSION['success'] = "Profil berhasil diperbarui!";
            header("Location: setprofil.php"); // Redirect ke halaman yang sama
            exit();
        } else {
            $error = "Gagal memperbarui profil.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link rel="stylesheet" href="assets/styleprofil.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="assets/pinisi1.png" alt="Logo">
            <span class="brand-name">TentangSulSel</span>
        </div>
        <div class="menu-icon" style="color: #ffffff">&lt;</div>
        </div>
    </nav>
    <div class="set-profil-container">
        <div class="set-profil-card">
            <h2>Edit Profil</h2>
            <!-- Tampilkan pesan error jika ada -->
            <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="profil-avatar">
                    <img src="<?php echo htmlspecialchars($foto_profil); ?>" alt="Foto Profil" style="width: 120px; height: 120px; border-radius: 50%;">
                    <label class="upload-button" for="upload-avatar">Ubah Foto</label>
                    <input type="file" name="foto_profil" id="upload-avatar" accept="image/*">
                </div>

                <label for="username">Username</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" readonly>

                <label for="email">Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

                <label for="password">Password Baru</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengganti password">

                <div class="button-group">
                    <a href="profil.php" class="cancel-button">Batal</a>
                    <button type="submit" class="save-button">Simpan</button>
                </div>
            </form>
            <!-- Tampilkan pesan sukses jika ada -->
            <?php if (isset($_SESSION['success'])): ?>
                <script>
                    alert("<?php echo $_SESSION['success']; ?>");
                </script>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
