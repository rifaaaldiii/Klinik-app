<?php

include '../../env/env.php';

if (isset($_POST['Submit'])) {
    if ((empty($_POST['email'])) || (empty($_POST['user'])) ||
        (empty($_POST['pass'])) || (empty($_POST['pass2']))
    ) {
        header("Location:../../index.php");
    } else {
        if (req($_POST) > 0) {
            echo "<script>
        alert('Register Successfuly!');
        document.location.href = '../../index.php';
        </script>";
        } else {
            echo mysqli_error($conn);
        }
    }
}
function req($data)
{
    global $conn;

    $email = mysqli_real_escape_string($conn, $data["email"]);
    $user = mysqli_real_escape_string($conn, $data["user"]);
    $pass = $data["pass"];
    $pass2 = $data["pass2"];

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
        alert('Format email tidak valid!');
        document.location.href = '../../index.php';
        </script>";
        return false;
    }

    // Validasi panjang username
    if (strlen($user) < 4) {
        echo "<script>
        alert('Username minimal 4 karakter!');
        document.location.href = '../../index.php';
        </script>";
        return false;
    }

    // Prepared statement untuk mencegah SQL injection
    $stmt = $conn->prepare("SELECT username FROM user WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    $stmt = $conn->prepare("SELECT email FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result1 = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
        alert('Username sudah terdaftar!');
        document.location.href = '../../index.php';
        </script>";
        return false;
    }

    if ($result1->num_rows > 0) {
        echo "<script>
        alert('Email sudah terdaftar!');
        document.location.href = '../../index.php';
        </script>";
        return false;
    }

    // Validasi password
    if (strlen($pass) < 8) {
        echo "<script>
        alert('Password minimal 8 karakter!');
        document.location.href = '../../index.php';
        </script>";
        return false;
    }

    if ($pass !== $pass2) {
        echo "<script>
        alert('Password tidak sesuai!!!');
        document.location.href = '../../index.php';
        </script>";
        return false;
    }

    $pass = password_hash($pass, PASSWORD_DEFAULT);

    // Prepared statement untuk insert
    $stmt = $conn->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $email, $pass);
    $stmt->execute();

    return $stmt->affected_rows;
}
