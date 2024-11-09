<?php

include '../../../env/env.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $notrans = $_POST['notrans'];
    $cash = $_POST['cash'];
    $transfer = $_POST['transfer'];
    $catatan = $_POST['catatan'];
    $total = $_POST['total'];
    $bayar = $cash + $transfer;
    $metode_pembayaran = ($cash == 0) ? 'transfer' : (($transfer == 0) ? 'cash' : 'cash + transfer');

    // Validasi jika cash + transfer tidak sama dengan total
    if (($cash + $transfer) != $total) {
        echo "<script>alert('Jumlah Cash dan Transfer tidak sesuai dengan Total Harga.');</script>";
        echo "<script>window.history.back();</script>";
        exit();
    }

    $query = "UPDATE detail_transaksi SET metode = '$metode_pembayaran', bayar = '$bayar' WHERE notrans = '$notrans'";
    mysqli_query($conn, $query);

    $query_detail = "UPDATE transaksi SET status = 'off', total = '$total', catatan = '$catatan' WHERE notrans = '$notrans'";
    mysqli_query($conn, $query_detail);

    echo "<script>alert('Transaksi berhasil di input');</script>";
    echo "<script>window.location.href = '../../index.php?page=transaksi';</script>";
    exit();
}
