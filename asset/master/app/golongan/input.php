<?php
// Koneksi ke database
include("../../../../env/env.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi field tidak boleh kosong
    if (
        empty($_POST['nama_golongan'])
    ) {

        echo "<script>alert('Semua field harus diisi!');</script>";
        echo "<script>window.history.back();</script>";
        exit();
    }

    $nama_golongan = $_POST['nama_golongan'];
    $gaji_pokok = $_POST['gaji_pokok'];
    $tunjangan_makan = $_POST['tunjangan_makan'];
    $overtime = $_POST['overtime'];
    $tunjangan_pasien = $_POST['tunjangan_pasien'];
    $ro1 = $_POST['ro1'];
    $ro2 = $_POST['ro2'];
    $ro3 = $_POST['ro3'];

    $query = "INSERT INTO golongan (id, nama_golongan, gaji_pokok, tunjangan_makan, overtime, tunjangan_pasien, ro1, ro2, ro3) VALUES (NULL, '$nama_golongan', '$gaji_pokok', '$tunjangan_makan', '$overtime', '$tunjangan_pasien', '$ro1', '$ro2', '$ro3')";
    mysqli_query($conn, $query);

    echo "<script>alert('Data berhasil ditambahkan');</script>";
    echo "<script>window.history.back();</script>";
    exit();
}
