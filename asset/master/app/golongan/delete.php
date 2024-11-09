<?php
// Koneksi ke database
include("../../../../env/env.php");
session_start();

$id = $_GET['id'];
$query = "DELETE FROM golongan WHERE id = $id";

mysqli_query($conn, $query);

echo "<script>alert('Data berhasil dihapus');</script>";
echo "<script>window.history.back();</script>";

exit();
