<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TentangSulSel</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <!-- Header Section -->
    <header class="hero-section">
        <nav class="navbar">
            <div class="menu-icon"></div>
            <div class="logo">
                <img src="assets/pinisi1.png" alt="Logo">
                <span class="brand-name">TentangSulSel</span>
            </div>
            <div class="profile-container" id="profile-container">
            <div class="profile-icon">
                <img src="assets/profile.png" alt="Profile Icon">
            </div>

            <div class="dropdown-menu" id="dropdown-menu">
                <a href="profil.php">Lihat Profil</a>
                <a href="index.php" onclick="confirmLogout(event)" class="logout-link">Keluar</a>
            </div>
        </nav>
        <div class="hero-content">
            <div class="welcome-text" id="welcome-text">
                Selamat Datang,<br> <?php echo htmlspecialchars($username); ?>!
            </div>
            <p>Sulawesi Selatan dikenal sebagai wilayah<br>dengan kekayaan budaya yang luar biasa,<br>yang mencerminkan keunikan tradisi dan<br>kehidupan masyarakatnya. Kebudayaan di<br>Sulawesi Selatan sangat erat kaitannya<br>dengan tiga suku utama: Bugis, Makassar,<br>dan Toraja, yang masing-masing memiliki<br>identitas khas dalam adat istiadat,<br>bahasa, seni, dan tradisi.</p>
            <img src="assets/dash.png" alt="Dashboard Image">
        </div>
    </header>
    <!-- About Us -->
    <section class="about-us">
        <h1>About Us</h1>
        <p>
        Platform ini dirancang untuk memperkenalkan dan melestarikan kekayaan budaya Sulawesi Selatan. Website ini menyajikan informasi komprehensif tentang warisan budaya yang meliputi suku-suku tradisional, pakaian adat, rumah adat, makanan khas, manuskrip kuno, tempat bersejarah, bahasa daerah, seni, tradisi, dan kearifan lokal lainnya.
        </p>
    </section>

    <!-- Suku -->
    <section class="suku">
        <h1>Suku</h1>
        <div class="card-container">
            <a href="suku_mks.php" class="card">
                <img src="assets/patonro.png" alt="Makassar">
                <p>Makassar</p>
            </a>
            <a href="suku_bugis.php" class="card">
                <img src="assets/recca.png" alt="Bugis">
                <p>Bugis</p>
            </a>
            <a href="suku_toraja.php" class="card">
                <img src="assets/tongkonan.png" alt="Toraja">
                <p>Toraja</p>
            </a>
        </div>
    </section>

    <!-- Tempat Bersejarah -->
    <section class="tempat">
        <h1>Tempat Bersejarah</h1>
        <div class="image-grid">
            <div class="image-item">
                <img src="assets/rotterdam.jpg" alt="Fort Rotterdam">
                <div class="image-overlay">Fort Rotterdam, Makassar</div>
            </div>
            <div class="image-item">
                <img src="assets/villayuliana.jpg" alt="Villa Yuliana">
                <div class="image-overlay">Villa Yuliana, Soppeng</div>
            </div>
            <div class="image-item">
                <img src="assets/palawa.jpg" alt="Desa Adat Palawa">
                <div class="image-overlay">Desa Adat Palawa, Tana Toraja</div>
            </div>
            <div class="image-item">
                <img src="assets/paotere.jpg" alt="Pelabuhan Paotere">
                <div class="image-overlay">Pelabuhan Paotere, Makassar</div>
            </div>
            <div class="image-item">
                <img src="assets/tuguperjuangan.jpg" alt="Tugu Perjuangan">
                <div class="image-overlay">Tugu Perjuangan, Palopo</div>
            </div>
            <div class="image-item">
                <img src="assets/sombaopu.jpg" alt="Benteng Somba Opu">
                <div class="image-overlay">Benteng Somba Opu, Makassar</div>
            </div>
        </div>
    </section>

    <!-- Senjata Tradisional -->
    <section class="senjata">
        <h1>Senjata Tradisional</h1>
        <div class="card-container">
            <a href="senjata.php" class="card">
                <img src="assets/badik.png" alt="Badik">
                <p>Badik</p>
            </a>
            <a href="senjata.php" class="card">
                <img src="assets/kanna.png" alt="Kanna">
                <p>Kanna</p>
            </a>
            <a href="senjata.php" class="card">
                <img src="assets/alamang.png" alt="Alamang">
                <p>Alamang</p>
            </a>
            <a href="senjata.php" class="card">
                <img src="assets/labo.png" alt="ALa'bo">
                <p>La'bo</p>
            </a>
        </div>
    </section>

    <!-- Manuskrip Kuno -->
    <section class="manuskrip">
        <h1>Manuskrip Kuno</h1>
        <div class="card-container">
            <a href="manuskrip.php" class="card">
                <img src="assets/rumahlagaligo.jpg" alt="Manuskrip I La Galigo">
                <p>Manuskrip<br>I La Galigo</p>
            </a>
            <a href="manuskrip.php" class="card">
                <img src="assets/naskah.png" alt="Naskah Kuno Akbarul Qiyamati">
                <p>Naskah Kuno Akbarul Qiyamati</p>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 TentangSulSel | All Rights Reserved</p>
    </footer>
    <script src="assets/script.js"></script>
</body>
</html>
