<?php
// Koneksi ke database
include("../../../../env/env.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $username = mysqli_real_escape_string($conn, $_POST['user']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['pass'];
    $password2 = $_POST['pass2'];
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Validasi username (minimal 3 karakter, hanya huruf dan angka)
    if (!preg_match("/^[a-zA-Z0-9]{3,}$/", $username)) {
        $_SESSION['error'] = "Username harus minimal 3 karakter dan hanya boleh mengandung huruf dan angka";
        header("Location: ../../masterdata.php?page=user");
        exit();
    }

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Format email tidak valid";
        header("Location: ../../masterdata.php?page=user");
        exit();
    }

    // Cek apakah username sudah ada
    $check_username = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if (mysqli_num_rows($check_username) > 0) {
        $_SESSION['error'] = "Username sudah digunakan";
        header("Location: ../../masterdata.php?page=user");
        exit();
    }

    // Cek apakah email sudah ada
    $check_email = mysqli_query($conn, "SELECT email FROM user WHERE email = '$email'");
    if (mysqli_num_rows($check_email) > 0) {
        $_SESSION['error'] = "Email sudah digunakan";
        header("Location: ../../masterdata.php?page=user");
        exit();
    }

    // Validasi password (minimal 5 karakter)
    if (strlen($password) < 5) {
        $_SESSION['error'] = "Password harus minimal 5 karakter";
        header("Location: ../../masterdata.php?page=user");
        exit();
    }

    // Validasi konfirmasi password
    if ($password !== $password2) {
        $_SESSION['error'] = "Konfirmasi password tidak cocok";
        header("Location: ../../masterdata.php?page=user");
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query insert
    $query = "INSERT INTO user (username, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashed_password, $role);

    // Eksekusi query
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "User berhasil ditambahkan";
    } else {
        $_SESSION['error'] = "Gagal menambahkan user: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    header("Location: ../../masterdata.php?page=user");
    exit();
}
