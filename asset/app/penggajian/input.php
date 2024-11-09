<?php

include '../../../env/env.php';
session_start();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $karyawan = $_POST['karyawan_id'];

    $status = 'Pending';

    $query = "INSERT INTO penggajian (tanggal, karyawan_id, status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $tanggal, $karyawan, $status);

    // Menambahkan pengecekan untuk error
    if (!$stmt->execute()) {
        echo "<script>alert('Error: " . $stmt->error . "');</script>"; // Menampilkan error jika ada
    } else {
        // Mengambil penggajian_id yang baru saja diinsert
        $penggajian_id = $conn->insert_id;

        // Update status karyawan menjadi 'on'
        $updateQuery = "UPDATE karyawan SET status = 'on' WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("s", $karyawan);
        $updateStmt->execute();
        $updateStmt->close();

        echo "<script>alert('Data berhasil disimpan, silahkan input data gaji.');</script>"; // Mengubah echo untuk menggunakan alert
        echo "<script>window.location.href='../../index.php?page=detail_penggajian&id=$karyawan&penggajian_id=$penggajian_id';</script>"; // Menambahkan redirect setelah berhasil
    }
    $stmt->close();
}
