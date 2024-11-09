<?php
include("../../../../env/env.php");
session_start();

$id = $_GET['id'];
$query = "DELETE FROM tindakan WHERE id = '$id'";
mysqli_query($conn, $query);

// Menggunakan window.history untuk kembali ke halaman sebelumnya
echo "<script>alert('Data berhasil dihapus');</script>";
echo "<script>window.history.back();</script>";
