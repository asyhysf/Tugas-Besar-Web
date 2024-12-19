<?php
session_start();
require 'koneksi.php'; // Koneksi ke database

if (!isset($_SESSION['username'])) {
    // Jika tidak login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Ambil username dari sesi
$username = $_SESSION['username'];

// Ambil data terbaru dari database
$query = "SELECT username, email, foto_profil FROM users WHERE username = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    // Jika data pengguna tidak ditemukan, logout untuk menghindari error
    session_destroy();
    header("Location: login.php");
    exit();
}

// Data pengguna dari database
$email = $user['email'];
$foto_profil = $user['foto_profil'] ?? 'assets/profile.png'; // Default foto profil jika kosong
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tampilan Profil</title>
    <link rel="stylesheet" href="assets/styleprofil.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="assets/pinisi1.png" alt="Logo">
            <span class="brand-name">TentangSulSel</span>
        </div>
        <a href="dashboard.php" class="menu-icon">&lt;</a>
    </nav>
    <div class="profil-container" id="profil-container">
        <div class="profil-card">
            <div class="profil-avatar">
                <img src="<?php echo htmlspecialchars($foto_profil); ?>" alt="user">
            </div>
            <h2 class="profil-username"><?php echo htmlspecialchars($username); ?></h2>
            <p class="profil-email"><?php echo htmlspecialchars($email); ?></p>
            <a href="setprofil.php" class="edit-button">Edit Profil</a>
            <a href="index.php" onclick="confirmLogout(event)" class="logout-link">Keluar</a>
        </div>
    </div>
</body>
<script>
    function confirmLogout(event) {
        const confirmAction = confirm("Apakah Anda yakin ingin keluar?");
        if (!confirmAction) {
            event.preventDefault(); // Mencegah navigasi jika pengguna memilih "Cancel"
        }
    }
</script>
</html>
