<?php
// Koneksi ke database
include("../../../../env/env.php");
session_start();

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $id = $_POST['id'];
    $nama_golongan = $_POST['nama_golongan'] == '1' ? 'Karyawan' : 'Dokter';
    $gaji_pokok = !empty($_POST['gaji_pokok']) ? $_POST['gaji_pokok'] : 0;
    $tunjangan_makan = !empty($_POST['tunjangan_makan']) ? $_POST['tunjangan_makan'] : 0;
    $overtime = !empty($_POST['overtime']) ? $_POST['overtime'] : 0;
    $tunjangan_pasien = !empty($_POST['tunjangan_pasien']) ? $_POST['tunjangan_pasien'] : 0;
    $ro1 = !empty($_POST['ro1']) ? $_POST['ro1'] : 0;
    $ro2 = !empty($_POST['ro2']) ? $_POST['ro2'] : 0;
    $ro3 = !empty($_POST['ro3']) ? $_POST['ro3'] : 0;

    // Query update
    $query = "UPDATE golongan SET 
              nama_golongan = ?,
              gaji_pokok = ?,
              tunjangan_makan = ?,
              overtime = ?,
              tunjangan_pasien = ?,
              ro1 = ?,
              ro2 = ?,
              ro3 = ?
              WHERE id = ?";

    // Siapkan statement
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameter
    mysqli_stmt_bind_param(
        $stmt,
        "siiiiiiii",
        $nama_golongan,
        $gaji_pokok,
        $tunjangan_makan,
        $overtime,
        $tunjangan_pasien,
        $ro1,
        $ro2,
        $ro3,
        $id
    );

    // Eksekusi query
    if (mysqli_stmt_execute($stmt)) {
        // Jika berhasil, redirect dengan pesan sukses
        echo "<script>
                alert('Data golongan berhasil diupdate!');
                window.history.back();
              </script>";
    } else {
        // Jika gagal, redirect dengan pesan error
        echo "<script>
                alert('Gagal mengupdate data golongan!');
                window.history.back();
              </script>";
    }

    // Tutup statement
    mysqli_stmt_close($stmt);
} else {
    // Jika bukan method POST, redirect ke halaman golongan
    header("window.history.back();");
}

// Tutup koneksi
mysqli_close($conn);
