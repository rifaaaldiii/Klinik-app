<?php

include '../../../env/env.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $status = 'Completed';

    $query = "UPDATE penggajian SET status = '$status' WHERE id = '$id'";
    mysqli_query($conn, $query);

    echo "<script>window.location.href='../../index.php?page=penggajian#penggajianTableContainer';</script>";
}
