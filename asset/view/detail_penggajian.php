<?php
if (!isset($_SESSION["username"]) || !isset($_SESSION["id"])) {
    header("Location: ../../index.php");
    exit();
}

$id = isset($_GET['id']) ? $_GET['id'] : '';
$sid = isset($_GET['penggajian_id']) ? $_GET['penggajian_id'] : '';
$bulan_ini = date('Y-m');
$query_karyawan = "SELECT k.*, g.nama_golongan, g.gaji_pokok, g.tunjangan_makan, g.overtime, 
    g.tunjangan_pasien, g.ro1 as g1, g.ro2 as g2, g.ro3 as g3, p.id as penggajian_id,
    COALESCE(COUNT(DISTINCT a.notrans), 0) as jumlah_pasien
FROM karyawan k 
LEFT JOIN golongan g ON k.golongan_id = g.id 
LEFT JOIN penggajian p ON k.id = p.karyawan_id
LEFT JOIN asistens a ON k.id = a.id_karyawan
WHERE k.id = '$id'
GROUP BY k.id";
$result_karyawan = mysqli_query($conn, $query_karyawan);

if ($result_karyawan && mysqli_num_rows($result_karyawan) > 0) {
    $karyawan_row = mysqli_fetch_assoc($result_karyawan);
    $total = $karyawan_row['jumlah_pasien'] * $karyawan_row['tunjangan_pasien'];
} else {
    $karyawan_row = [];
}

?>

<div class="card__container mb-4">
    <div class="row">

        <div class="col-md-4">
            <label class="form-label">Nama Karyawan</label>
            <input type="text" name="nama_karyawan" class="form-control" required readonly value="<?= isset($karyawan_row['nama']) ? $karyawan_row['nama'] : 'Tidak Ditemukan' ?>">
        </div>

        <div class="col-md-4">
            <label class="form-label">Golongan</label>
            <input type="text" name="golongan" class="form-control" required readonly value="<?= isset($karyawan_row['nama_golongan']) ? $karyawan_row['nama_golongan'] : 'Tidak Ditemukan' ?>">
        </div>

        <div class="col-md-4">
            <label class="form-label">Gaji Pokok</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Rp.</span>
                <input type="number" name="gaji_pokok" value="<?= isset($karyawan_row['gaji_pokok']) ? $karyawan_row['gaji_pokok'] : 'Tidak Ditemukan' ?>" class="form-control" required readonly>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#input">
            <i class="fa fa-plus"></i> Input Penggajian
        </button>
    </div>

    <div class="modal fade" id="input" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Input Penggajian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form class="row g-4" action="app/penggajian/input_detail.php" method="post">
                        <input type="hidden" name="penggajian_id" value="<?= $sid ?>">
                        <input type="hidden" name="karyawan_id" value="<?= $karyawan_row['id'] ?>" readonly>

                        <?php
                        $id_karyawan = $_GET['id'];
                        $query_asistens = "SELECT 
                            SUM(ro1) as total_ro1,
                            SUM(ro2) as total_ro2,
                            SUM(ro3) as total_ro3
                            FROM asistens 
                            WHERE id_karyawan = '$id_karyawan'";
                        $result_asistens = mysqli_query($conn, $query_asistens);
                        $row_asistens = mysqli_fetch_assoc($result_asistens);
                        ?>

                        <input type="hidden" name="ro1" value="<?= $row_asistens['total_ro1'] * 7500 ?? '0' ?>">
                        <input type="hidden" name="ro2" value="<?= $row_asistens['total_ro2'] * 15000 ?? '0' ?>">
                        <input type="hidden" name="ro3" value="<?= $row_asistens['total_ro3'] * 30000 ?? '0' ?>">

                        <div id="overtime" class="section">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Bonus</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                        <input type="number" name="bonus" id="bonus" value="0" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Overtime</label>
                                    <div class="input-group mb-3">
                                        <input type="number" id="jumlah_overtime" value="" min="0" class="form-control" oninput="hitungTotal()" required>

                                        <div class="input-group-text ms-2 me-2">
                                            X
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" id="kali_overtime" value="<?= isset($karyawan_row['overtime']) ? $karyawan_row['overtime'] : '' ?>" class="form-control" readonly>
                                        </div>
                                        <div class="input-group-text ms-2 me-2">
                                            =
                                        </div>
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                        <input type="number" name="overtime" id="jumlahOvertime" value="0" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Tunjangan Makan</label>
                                    <div class="input-group mb-3">
                                        <input type="number" id="tunjangan_makan" value="" min="0" class="form-control" oninput="hitungTotal()" required>
                                        <div class="input-group-text ms-2 me-2">X</div>
                                        <div class="col-md-2">
                                            <input type="number" id="kali_tunjangan_makan" value="<?= isset($karyawan_row['tunjangan_makan']) ? $karyawan_row['tunjangan_makan'] : '0' ?>" class="form-control" readonly>
                                        </div>
                                        <div class="input-group-text ms-2 me-2">=</div>
                                        <span class="input-group-text">Rp.</span>
                                        <input type="number" name="tunjangan_makan" id="jumlahTunjanganMakan" value="0" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Jumlah Pasien</label>
                                    <div class="input-group mb-3">
                                        <input type="number" id="jumlah_pasien" class="form-control" value="<?= isset($karyawan_row['jumlah_pasien']) ? $karyawan_row['jumlah_pasien'] : '' ?>" readonly>

                                        <div class="input-group-text ms-2 me-2">
                                            X
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" value="<?= isset($karyawan_row['tunjangan_pasien']) ? $karyawan_row['tunjangan_pasien'] : '' ?>" class="form-control" readonly>
                                        </div>
                                        <div class="input-group-text ms-2 me-2">
                                            =
                                        </div>
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                        <input type="number" name="tunjangan_pasien" id="harga_pasien" value="<?= $total ?>" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                            <script>
                                function hitungTotal() {
                                    const jumlahOvertime = document.getElementById('jumlah_overtime').value;
                                    const kaliOvertime = document.getElementById('kali_overtime').value; // Mengubah id untuk menghindari konflik
                                    const tunjanganMakan = document.getElementById('tunjangan_makan').value;
                                    const kaliTunjanganMakan = document.getElementById('kali_tunjangan_makan').value;


                                    const totalOvertime = jumlahOvertime * kaliOvertime;
                                    const totalTunjanganMakan = tunjanganMakan * kaliTunjanganMakan;
                                    document.getElementById('jumlahOvertime').value = totalOvertime || 0; // Update total
                                    document.getElementById('jumlahTunjanganMakan').value = totalTunjanganMakan || 0; // Update total
                                    updateSubtotal(); // Memanggil fungsi untuk memperbarui subtotal
                                }
                            </script>
                        </div>

                        <div class="modal-footer">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary ms-3">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="table__container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Overtime</th>
                    <th>Jumlah Pasien</th>
                    <th>Tunjangan Makan</th>
                    <th>Ro 1</th>
                    <th>Ro 2</th>
                    <th>Ro 3</th>
                    <th>Bonus</th>
                    <th>Total</th>
                    <th>Tools</th>
                </tr>
            </thead>

            <tbody>
                <?php

                $no = 1;
                $query_detail = "SELECT *
                FROM detail_gaji dg
                WHERE penggajian_id = '$sid'";
                $result_detail = mysqli_query($conn, $query_detail);

                if (mysqli_num_rows($result_detail) > 0) {
                    while ($row_dg = mysqli_fetch_assoc($result_detail)) {
                        // Konversi semua nilai ke integer
                        $overtime = (int)$row_dg['overtime'];
                        $makan = (int)$row_dg['makan'];
                        $ro1 = (int)$row_dg['ro1'];
                        $ro2 = (int)$row_dg['ro2'];
                        $ro3 = (int)$row_dg['ro3'];
                        $bonus = (int)$row_dg['bonus'];

                        // Hitung total
                        $total = $overtime + $makan + $ro1 + $ro2 + $ro3 + $bonus;
                ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>Rp. <?= empty($overtime) ? '0' : number_format($overtime, 0, ',', '.') ?></td>
                            <td>Rp. <?= empty($row_dg['jumlah_pasien']) ? '0' : number_format($row_dg['jumlah_pasien'], 0, ',', '.') ?></td>
                            <td>Rp. <?= empty($makan) ? '0' : number_format($makan, 0, ',', '.') ?></td>
                            <td>Rp. <?= empty($ro1) ? '0' : number_format($ro1, 0, ',', '.') ?></td>
                            <td>Rp. <?= empty($ro2) ? '0' : number_format($ro2, 0, ',', '.') ?></td>
                            <td>Rp. <?= empty($ro3) ? '0' : number_format($ro3, 0, ',', '.') ?></td>
                            <td>Rp. <?= empty($bonus) ? '0' : number_format($bonus, 0, ',', '.') ?></td>
                            <td>Rp. <?= empty($total) ? '0' : number_format($total, 0, ',', '.') ?></td>
                            <td>
                                <a href="app/penggajian/delete.php?id=<?= $row_dg['id'] ?>&karyawan_id=<?= $id ?>&penggajian_id=<?= $sid ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada penambahan gaji</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <form action="app/penggajian/update.php" method="post">

        <?php
        $gaji_pokok = isset($karyawan_row['gaji_pokok']) ? (int)$karyawan_row['gaji_pokok'] : 0;
        $total = isset($total) ? (int)$total : 0;
        $total_gaji = $gaji_pokok + $total;
        ?>

        <div class="row g-3 align-items-center justify-content-end mt-4">
            <div class="col-auto">
                <label class="form-label mb-0" style="font-weight: bold;">Total Gaji</label>
            </div>
            <div class="col-auto hitung">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1" style="font-weight: bold;">Rp.</span>
                    <input class="form-control" type="text" value="<?= $total_gaji ?>" readonly style="background-color: transparent;">
                </div>
            </div>
        </div>



        <input type="hidden" name="asistensi" value="<?= $total ?>">
        <input type="hidden" name="total_gaji" value="<?= $total_gaji ?>">
        <input type="hidden" name="penggajian_id" value="<?= $sid ?>">

        <div class="col-md-12 mt-4 d-flex justify-content-end">
            <a class="btn btn-secondary" href="index.php?page=penggajian#penggajianTableContainer">Close</a>
            <button type="submit" class="btn btn-primary ms-3" onclick="return confirm('Apakah Anda yakin ingin menginput data ini?')">Simpan</button>
        </div>
    </form>
</div>