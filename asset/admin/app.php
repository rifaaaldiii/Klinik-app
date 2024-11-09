<?php
include '../../env/env.php';
session_start();
if (!isset($_SESSION["username"]) || !isset($_SESSION["id"])) {
    header("Location: ../index.php");
    exit();
}
// Mengambil tanggal hari ini dengan format yang benar
$todays = date('Y-m-d');
date_default_timezone_set('Asia/Jakarta');

$grand_total = 0;
// Query untuk mengambil total dari kolom total
$query_total = "SELECT SUM(total) as grand_total FROM transaksi WHERE tanggal = '$todays'";
$result_total = mysqli_query($conn, $query_total);

if ($result_total) {
    $total_row = mysqli_fetch_assoc($result_total);
    $grand_total = $total_row['grand_total'] ?? 0; // Ambil grand_total dari hasil query
}

$query_transaksi = "SELECT t.*, k.nama as nama_dokter 
    FROM transaksi t
    JOIN karyawan k ON t.dokter = k.id
    WHERE tanggal = '$todays'";
$result_transaksi = mysqli_query($conn, $query_transaksi);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query_detail = "SELECT t.*, k.nama as nama_dokter
    FROM transaksi t 
    JOIN karyawan k ON t.dokter = k.id 
    WHERE t.notrans = '$id'
    ORDER BY t.id DESC";

    $result_detail = mysqli_query($conn, $query_detail);
    if ($result_detail) {
        $detail_row = mysqli_fetch_assoc($result_detail);
    }
}

$query_tindakan = "SELECT * FROM tindakan";
$result_tindakan = mysqli_query($conn, $query_tindakan);

$query_karyawan = "SELECT * FROM karyawan ";
$result_karyawan = mysqli_query($conn, $query_karyawan);

$query_detail = "SELECT * FROM detail_transaksi";
$result_detail = mysqli_query($conn, $query_detail);
