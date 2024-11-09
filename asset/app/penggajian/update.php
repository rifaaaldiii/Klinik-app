<?php

include '../../../env/env.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['penggajian_id'];
    $asistensi = $_POST['asistensi'];
    $total = $_POST['total_gaji'];
    $status = 'Pending';


    $query = "UPDATE penggajian SET asistensi = '$asistensi', total = '$total', status = '$status' WHERE id = '$id'";
    mysqli_query($conn, $query);

    echo "<script>alert('Data berhasil diinput.');</script>";
    echo "<script>window.location.href='../../index.php?page=penggajian#penggajianTableContainer';</script>";
}
