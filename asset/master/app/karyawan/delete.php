<?php
include("../../../../env/env.php");
session_start();

$id = $_GET['id'];
$nik = $_GET['nik'];

// Hapus file QR code
$qr_path = "../../../img/qr-code/" . $nik . ".png";
if (file_exists($qr_path)) {
    unlink($qr_path);
}

// Hapus data dari database
$query = "DELETE FROM karyawan WHERE id = '$id'";
mysqli_query($conn, $query);

// Menggunakan window.history untuk kembali ke halaman sebelumnya
echo "<script>alert('Data berhasil dihapus');</script>";
echo "<script>window.history.back();</script>";
