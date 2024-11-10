<?php

include '../../../env/env.php';
// Menambahkan kode untuk menyimpan detail transaksi

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $notrans = $_POST['notrans'];
    $nama_td = $_POST['namatd'];
    $harga = $_POST['totalharga'];
    $harga_jasa = $_POST['harga_jasa'];
    $modal = $_POST['modal'];
    $subtotal = $_POST['subtotal'];
    $tipe = $_POST['jm'];
    $diskon = $_POST['diskon'];
    $dp = $_POST['dp'];
    $catatan = $_POST['catatan'];

    // Validasi subtotal

    // Query untuk memasukkan data ke tabel detail_transaksi
    $query = "INSERT INTO detail_transaksi (id, notrans, tindakan, harga, jm, tipe_jm, modal, total, diskon, dp, catatan) VALUES (NULL, '$notrans', '$nama_td', '$harga', '$harga_jasa', '$tipe', '$modal', '$subtotal', '$diskon', '$dp', '$catatan')";
    mysqli_query($conn, $query);
    // Menambahkan alert sebelum redirect
    echo "<script>alert('Tindakan berhasil di input');</script>";
    echo "<script>window.location.href = '../../index.php?page=detail&id=$notrans';</script>";
    exit();
}
