    <?php

    include '../../../env/env.php';
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $karyawan_id = $_POST['karyawan_id'];
        $penggajian_id = $_POST['penggajian_id'];
        $bonus = $_POST['bonus'];
        $overtime = $_POST['overtime'];
        $makan = $_POST['tunjangan_makan'];
        $jumlah_pasien = $_POST['tunjangan_pasien'];
        $ro1 = $_POST['ro1'];
        $ro2 = $_POST['ro2'];
        $ro3 = $_POST['ro3'];


        $query = "INSERT INTO detail_gaji (penggajian_id, karyawan_id, bonus, overtime, jumlah_pasien, makan, ro1, ro2, ro3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssss", $penggajian_id, $karyawan_id, $bonus, $overtime, $jumlah_pasien, $makan, $ro1, $ro2, $ro3);
        $stmt->execute();
        $stmt->close();

        echo "<script>alert('Data berhasil disimpan.');</script>";
        echo "<script>window.location.href='../../index.php?page=detail_penggajian&id=$karyawan_id&penggajian_id=$penggajian_id';</script>";
    }
