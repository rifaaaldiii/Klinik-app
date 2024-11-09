<?php

require "../../env/env.php";

// loginnnnn
if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];


    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' OR email = '$username'");
    if (mysqli_num_rows($result) === 1) {


        session_start();
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        $_SESSION['password'] = $row['password'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['role'] = $row['role'];




        if (password_verify($password, $row["password"])) {
            if ($row['role'] == 'owner') {
                header("location:../../asset/index.php");
            } else {
                header("location:../../asset/admin/index.php");
            }
        } else {
            echo "<script>
			alert('Username or Password Salah!!!');
			window.history.back();
			</script>";
        }
    } else {
        echo "<script>
		alert('Username or Password Salah!!!');
		window.history.back();
		</script>";
    }
}
