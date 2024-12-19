<?php
include 'koneksi.php';

// Ambil semua data dari database
$result = mysqli_query($koneksi, "SELECT * FROM data_suku");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suku Makassar - Tentang SulSel</title>
    <link rel="stylesheet" href="assets/suku.css">
</head>
<body>
    <!-- Header / Navbar -->
    <header>
        <nav class="navbar">
        <a href="dashboard.php" class="menu-icon">&lt;</a>
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
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <h1 class="hero-title">Suku Makassar</h1>
        <img src="assets/sukumks.png" alt="Hero Image">
    </section>

    <!-- Kontainer Konten -->
    <main class="content-container">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="content-card">
                <img src="<?php echo $row['gambar']; ?>" alt="Gambar" class="card-image">
                <p class="card-description"><?php echo htmlspecialchars($row['deskripsi']); ?></p>
            </div>
        <?php endwhile; ?>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 TentangSulSel | All Rights Reserved</p>
    </footer>
    <script src="assets/script.js"></script>
</body>
</html>
