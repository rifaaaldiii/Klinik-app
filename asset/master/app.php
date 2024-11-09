<?php
include '../../env/env.php';
session_start();
if (!isset($_SESSION["username"]) || !isset($_SESSION["id"])) {
    header("Location: ../../index.php");
    exit();
}
// Mengambil tanggal hari ini dengan format yang benar
$todays = date('Y-m-d');
date_default_timezone_set('Asia/Jakarta');

$query_tindakan = "SELECT * FROM tindakan ORDER BY id DESC";
$result_tindakan = mysqli_query($conn, $query_tindakan);

$query_karyawan = "SELECT * FROM karyawan ORDER BY id DESC";
$result_karyawan = mysqli_query($conn, $query_karyawan);
