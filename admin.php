<?php
$koneksi = new mysqli("localhost", "root", "", "tentangsulsel");

// Fungsi Delete
if (isset($_GET['delete'])) {
    $id = $_GET['id'];
    $table = $_GET['table'];
    if (in_array($table, ['data_suku', 'suku_bugis', 'suku_toraja', 'senjata_tradisional', 'manuskrip'])) {
        $sql = "DELETE FROM $table WHERE id=?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: admin.php");
    }
}

// Fungsi Create
if (isset($_POST['submit'])) {
    $table = $_POST['table'];
    $deskripsi = $_POST['deskripsi'];

    // Upload Gambar
    $target_dir = "";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);

    if (in_array($table, ['data_suku', 'suku_bugis', 'suku_toraja', 'senjata_tradisional', 'manuskrip'])) {
        $sql = "INSERT INTO $table (gambar, deskripsi) VALUES (?, ?)";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("ss", $target_file, $deskripsi);
        $stmt->execute();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Halaman Admin</title>
    <style>
        body {
            font-family: 'Cambria', sans-serif; margin: 0; padding: 0;
            background-color: #C8B6A6; color: #333;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #ffffff;
            position: fixed;
            top: 0; /* Tempel di bagian atas */
            left: 0;
            right: 0;
            z-index: 1000; /* Pastikan navbar di atas elemen lain */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar .menu-icon {
            font-size: 1.8rem;
            cursor: pointer;
            color: #000000;
        }
        .navbar .logo {
            display: flex;
            align-items: center;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
        .navbar .logo img {
            width: 40px;
            margin-right: 10px;
        }
        .navbar .brand-name {
            font-size: 1.8rem;
            font-weight: bold;
            color: #000000;
            text-transform: capitalize;
        }
        .profile-icon {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
        }
        .profile-container {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }
        .profile-icon img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
        .dropdown-menu {
            display: none; /* Sembunyikan menu secara default */
            position: absolute;
            top: 50px;
            right: 0;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 150px;
            z-index: 1000;
        }
        .dropdown-menu a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
            font-size: 0.9rem;
        }
        .dropdown-menu a:hover {
            background-color: #f4f4f4;
        }
        .container {
            padding: 20px;
        }
        table {
            width: 100%; border-collapse: collapse; margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #999;
        }
        th, td {
            padding: 10px; text-align: center;
        }
        th {
            background-color: #444; color: #fff;
        }
        button {
            padding: 5px 10px; margin: 2px; cursor: pointer;
        }
        .btn-edit {
            background-color: #4CAF50; color: white; border: none;
        }
        .btn-delete {
            background-color: #E74C3C; color: white; border: none;
        }
        .form-container {
            background-color: #fff; padding: 15px; margin: 20px 0; border-radius: 8px;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
        <a href="dashboard.php" class="menu-icon"></a>
            <div class="logo">
                <img src="assets/pinisi1.png" alt="Logo">
                <span class="brand-name">TentangSulSel</span>
            </div>
            <div class="profile-container" id="profile-container">
            <div class="profile-icon">
                <img src="assets/profile.png" alt="Profile Icon">
            </div>

            <div class="dropdown-menu" id="dropdown-menu">
                <a href="index.php" onclick="confirmLogout(event)" class="logout-link">Keluar</a>
            </div>
        </nav>
    </header>

    <div class="container">
        <h2><br>Tambah Data</h2>
        <div class="form-container">
            <form name="dataForm" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                <label>Pilih Tabel:</label>
                <select name="table">
                    <option value="data_suku">Suku Makassar</option>
                    <option value="suku_bugis">Suku Bugis</option>
                    <option value="suku_toraja">Suku Toraja</option>
                    <option value="senjata_tradisional">Senjata Tradisional</option>
                    <option value="manuskrip">Manuskrip Kuno</option>
                </select>
                <br><br>
                <label>Gambar:</label>
                <input type="file" name="gambar" required><br><br>
                <label>Deskripsi:</label>
                <textarea name="deskripsi" rows="4" required></textarea><br><br>
                <button type="submit" name="submit">Simpan</button>
            </form>
        </div>

        <?php
        $tables = ['data_suku', 'suku_bugis', 'suku_toraja', 'senjata_tradisional', 'manuskrip'];
        foreach ($tables as $table) {
            echo "<h3>" . ucfirst(str_replace('_', ' ', $table)) . "</h3>";
            $result = $koneksi->query("SELECT * FROM $table");
            echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Gambar</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td><img src='{$row['gambar']}' width='100'></td>
                        <td>{$row['deskripsi']}</td>
                        <td>
                            <a href='edit.php?id={$row['id']}&table=$table'><button class='btn-edit'>Edit</button></a>
                            <a href='?delete&id={$row['id']}&table=$table' onclick='return confirmDelete();'>
                                <button class='btn-delete'>Hapus</button>
                            </a>
                        </td>
                      </tr>";
            }
            echo "</table>";
        }
        ?>
    </div>
</body>
    <script src="assets/script.js"></script>
</html>
