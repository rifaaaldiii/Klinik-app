<?php
// Koneksi ke database
include("../../../../env/env.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $nip = $_POST['nip'];
    $nik = $_POST['nik'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $telpon = $_POST['telpon'];
    $no_rek = $_POST['no_rek'];
    $alamat = $_POST['alamat'];
    $agama = $_POST['agama'];
    $golongan_id = $_POST['golongan_id'];

    // Validasi jika ada post yang kosong
    if (empty($nama) || empty($tanggal_lahir) || empty($nip) || empty($nik) || empty($jenis_kelamin) || empty($telpon) || empty($no_rek) || empty($alamat) || empty($agama) || empty($golongan_id)) {
        echo "<script>alert('Gagal menambahkan data karyawan: Semua field harus diisi.');</script>";
        echo "<script>window.history.back();</script>";
        exit();
    }
    $query = "INSERT INTO karyawan (id, nama, tanggal_lahir, nip, nik, jenis_kelamin, telpon, no_rek, alamat, agama, golongan_id) VALUES (NULL, '$nama', '$tanggal_lahir', '$nip', '$nik', '$jenis_kelamin', '$telpon', '$no_rek', '$alamat', '$agama', '$golongan_id')";
    mysqli_query($conn, $query);

    echo "<script>alert('Data berhasil ditambahkan');</script>";
    echo "<script>window.location.href = '../../masterdata.php?page=karyawan';</script>";
    exit();
}
