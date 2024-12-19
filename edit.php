<?php
$koneksi = new mysqli("localhost", "root", "", "tentangsulsel");

// Ambil Data Berdasarkan ID
if (isset($_GET['id']) && isset($_GET['table'])) {
    $id = $_GET['id'];
    $table = $_GET['table'];

    if (in_array($table, ['data_suku', 'suku_bugis', 'suku_toraja', 'senjata_tradisional', 'manuskrip'])) {
        $sql = "SELECT * FROM $table WHERE id=?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
    } else {
        die("Tabel tidak valid!");
    }
}

// Proses Update Data
if (isset($_POST['submit'])) {
    $deskripsi = $_POST['deskripsi'];
    $gambar_lama = $_POST['gambar_lama'];
    $id = $_POST['id'];
    $table = $_POST['table'];

    // Upload Gambar Baru (Jika Ada)
    if ($_FILES['gambar']['name']) {
        $target_dir = "";
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
    } else {
        $target_file = $gambar_lama; // Gunakan gambar lama jika tidak ada yang diunggah
    }

    // Update Data
    $sql = "UPDATE $table SET gambar=?, deskripsi=? WHERE id=?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("ssi", $target_file, $deskripsi, $id);
    $stmt->execute();

    echo "<script>
            alert('Data berhasil diubah!');
            window.location.href='admin.php';
          </script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data</title>
    <style>
        body {
            font-family: 'Cambria', sans-serif; margin: 0; padding: 0;
            background-color: #f3e5d8; color: #333;
        }
        .navbar {
            background-color: #fff; padding: 10px 20px; color: #000;
            display: flex; align-items: center; justify-content: space-between;
            border-bottom: 1px solid #ccc;
        }
        .navbar .brand {
            display: flex; align-items: center;
        }
        .navbar img {
            height: 30px; margin-right: 10px;
        }
        .container {
            padding: 20px;
        }
        .form-container {
            background-color: #fff; padding: 20px; margin-top: 20px; border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        label {
            display: block; margin: 10px 0 5px;
        }
        input, textarea {
            width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;
        }
        button {
            background-color: #4CAF50; color: white; border: none; padding: 10px 15px;
            border-radius: 5px; cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="brand">
            <img src="assets/pinisi1.png" alt="Logo">
            <span>TentangSulSel - Edit Data</span>
        </div>
    </div>

    <div class="container">
        <h2>Edit Data</h2>
        <div class="form-container">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                <input type="hidden" name="table" value="<?= $table ?>">
                <input type="hidden" name="gambar_lama" value="<?= $data['gambar'] ?>">

                <label>Gambar:</label>
                <input type="file" name="gambar">
                <img src="<?= $data['gambar'] ?>" width="150" alt="Gambar Lama"><br>

                <label>Deskripsi:</label>
                <textarea name="deskripsi" rows="4" required><?= $data['deskripsi'] ?></textarea>

                <button type="submit" name="submit">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</body>
</html>
