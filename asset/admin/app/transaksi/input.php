<?php
// Koneksi ke database
include '../../../../env/env.php'; // Pastikan Anda memiliki file koneksi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $tanggal = $_POST['tanggal'];
    $notrans = $_POST['notrans'];
    $nama_klien = $_POST['nama_klien'];
    $dokter = $_POST['dokter'];
    $total = 0;
    $status = 'on';

    // Menyiapkan query untuk menyimpan data transaksi
    $query = "INSERT INTO transaksi (tanggal, notrans, dokter, nama_klien, total, status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssss", $tanggal, $notrans, $dokter, $nama_klien, $total, $status);

    // Menjalankan query dan memeriksa hasilnya
    if ($stmt->execute()) {
        echo "<script>alert('Transaksi berhasil disimpan.');</script>"; // Mengubah echo untuk menggunakan alert
        echo "<script>window.location.href='../../index.php?page=detail&id=$notrans';</script>"; // Menambahkan redirect setelah berhasil
    } else {
        echo "Error: " . $stmt->error;
    }

    // Menutup statement dan koneksi
    $stmt->close();
    $conn->close();
}
