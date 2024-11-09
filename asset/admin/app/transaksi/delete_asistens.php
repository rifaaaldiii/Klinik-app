<?php
include("../../../../env/env.php");
session_start();

if (!isset($_SESSION["username"]) || !isset($_SESSION["id"])) {
    header("Location: ../../../index.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['notrans'])) {
    $id = $_GET['id'];
    $notrans = $_GET['notrans'];

    $query = "DELETE FROM asistens WHERE id = '$id'";
    mysqli_query($conn, $query);

    echo "<script>alert('Data berhasil dihapus');</script>";
    echo "<script>window.location.href = '../../index.php?page=detail&id=$notrans';</script>";
    exit();
}
