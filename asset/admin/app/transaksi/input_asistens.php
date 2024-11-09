<?php
include '../../../../env/env.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $notrans = $_POST['notrans'];
    $id_karyawan = $_POST['id_karyawan'];
    $tipe_regio = $_POST['tipe_regio'];
    $jumlah_regio = $_POST['jumlah_regio'];

    // Menentukan kolom RO berdasarkan tipe_regio
    $ro1 = ($tipe_regio == 1) ? $jumlah_regio : 0;
    $ro2 = ($tipe_regio == 2) ? $jumlah_regio : 0;
    $ro3 = ($tipe_regio == 3) ? $jumlah_regio : 0;
    $non_regio = ($tipe_regio == 4) ? $jumlah_regio : 0;

    $query = "INSERT INTO asistens (id, notrans, id_karyawan, ro1, ro2, ro3, non_regio) 
              VALUES (NULL, '$notrans', '$id_karyawan', '$ro1', '$ro2', '$ro3', '$non_regio')";
    mysqli_query($conn, $query);
    echo "<script>alert('Asistens berhasil di input');</script>";
    echo "<script>window.location.href = '../../index.php?page=detail&id=$notrans';</script>";
    exit();
}
