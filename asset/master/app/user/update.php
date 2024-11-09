<?php
// Koneksi ke database
include("../../../../env/env.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $username = $_POST['user'];
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $password_confirm = $_POST['pass2'];
    $role = $_POST['role'];

    // Validasi password
    if ($password !== $password_confirm) {
        echo "<script>
                alert('Password dan konfirmasi password tidak cocok!');
                window.history.back();
              </script>";
        exit();
    }

    // Hash password menggunakan password_hash()
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query update
    $query = "UPDATE user SET 
              username = ?, 
              email = ?, 
              password = ?, 
              role = ? 
              WHERE id = ?";

    // Prepare statement
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameter
    mysqli_stmt_bind_param($stmt, "ssssi", $username, $email, $hashed_password, $role, $id);

    // Eksekusi query
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Data user berhasil diupdate!');
                window.location.href = '../../masterdata.php?page=user';
              </script>";
    } else {
        echo "<script>
                alert('Gagal mengupdate data user: " . mysqli_error($conn) . "');
                window.history.back();
              </script>";
    }

    // Tutup statement
    mysqli_stmt_close($stmt);
} else {
    // Jika bukan method POST, redirect ke halaman user
    header("Location: ../../masterdata.php?page=user");
}

// Tutup koneksi
mysqli_close($conn);
