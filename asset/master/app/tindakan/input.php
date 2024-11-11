<?php
// Koneksi ke database
include("../../../../env/env.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama_tindakan = $_POST['nama_tindakan'];
    $jm = $_POST['jm'];
    $harga = $_POST['harga'];

    // Validasi jika ada data yang kosong
    if (empty($nama_tindakan)) {
        echo "<script>alert('Semua field harus diisi');</script>";
        echo "<script>window.history.back();</script>";
        exit();
    }

    // Validasi $harga untuk menghapus . atau ,
    $harga = str_replace(['.', ','], '', $harga);

    $query = "INSERT INTO tindakan (nama_tindakan, jm, harga) VALUES ('$nama_tindakan', '$jm', '$harga')";
    mysqli_query($conn, $query);

    echo "<script>alert('Data berhasil ditambahkan');</script>";
    echo "<script>window.location.href = '../../masterdata.php?page=tindakan';</script>";
    exit();
}
