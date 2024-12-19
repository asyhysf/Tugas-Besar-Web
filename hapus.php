<?php
include 'koneksi.php';

$id = $_GET['id'];
$query = "DELETE FROM data_suku WHERE id = $id";
mysqli_query($koneksi, $query);

header("Location: admin_mks.php");
?>
