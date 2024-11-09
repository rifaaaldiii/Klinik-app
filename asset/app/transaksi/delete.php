<?php
include '../../../env/env.php';
session_start();

if (isset($_GET['id'])) {
    $notrans = $_GET['id'];

    // Hapus data transaksi
    $query = "DELETE FROM transaksi WHERE notrans = '$notrans'";

    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Data berhasil dihapus!');
                window.history.back();
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data!');
                window.history.back();
              </script>";
    }
}
