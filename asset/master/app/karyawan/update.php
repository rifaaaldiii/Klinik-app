<?php
// Koneksi ke database
include("../../../../env/env.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $id = $_POST['id'];
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
        echo "<script>alert('Gagal memperbarui data karyawan: Semua field harus diisi.');</script>";
        echo "<script>window.history.back();</script>";
        exit();
    }

    $query = "UPDATE karyawan SET nama = '$nama', tanggal_lahir = '$tanggal_lahir', nip = '$nip', nik = '$nik', jenis_kelamin = '$jenis_kelamin', telpon = '$telpon', no_rek = '$no_rek', alamat = '$alamat', agama = '$agama', golongan_id = '$golongan_id' WHERE id = '$id'";
    mysqli_query($conn, $query);

    echo "<script>alert('Data berhasil diupdate');</script>";
    echo "<script>window.history.back();</script>";
    exit();
}
