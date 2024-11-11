<?php
// Koneksi ke database
include("../../../../env/env.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $id = $_POST['id'];
    $nama_tindakan = $_POST['nama_tindakan'];
    $jm = $_POST['jm'];
    $harga = $_POST['harga'];

    // Validasi jika ada data yang kosong
    if (empty($id) || empty($nama_tindakan)) {
        echo "<script>alert('Semua field harus diisi');</script>";
        echo "<script>window.history.back();</script>";
        exit();
    }

    $query = "UPDATE tindakan SET nama_tindakan = '$nama_tindakan', jm = '$jm', harga = '$harga' WHERE id = '$id'";
    mysqli_query($conn, $query);

    echo "<script>alert('Data berhasil diupdate');</script>";
    echo "<script>window.history.back();</script>";
    exit();
}
