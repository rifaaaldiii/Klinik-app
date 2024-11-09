<?php

include '../../../env/env.php';
session_start();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $karyawan_id = $_GET['karyawan_id'];


    $query = "DELETE FROM detail_gaji WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Data berhasil dihapus.');</script>";
    echo "<script>window.location.href='../../index.php?page=detail_penggajian&id=$karyawan_id';</script>";
}
