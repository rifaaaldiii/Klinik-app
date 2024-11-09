<div class="card__container mb-4">
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">No Transaksi</label>
            <input type="text" name="notrans" class="form-control" required readonly value="<?= $detail_row['notrans'] ?>">
        </div>

        <div class="col-md-4">
            <label class="form-label">Dokter</label>
            <input type="text" name="nama_dokter" class="form-control" required readonly value="<?= $detail_row['nama_dokter'] ?>">
        </div>

        <div class="col-md-4">
            <label class="form-label">Nama Klien</label>
            <input type="text" name="nama_klien" class="form-control" required readonly value="<?= $detail_row['nama_klien'] ?>">
        </div>
    </div>

    <div class="table__container mt-4">
        <div class="row">
            <h3 class="main__title" style="color: #000; font-weight: bold;">Tabel Tindakan</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Transaksi</th>
                    <th>Tindakan</th>
                    <th>Harga</th>
                    <th>Jasa Medis</th>
                    <th>Modal</th>
                    <th>Diskon</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $query_detail = "SELECT * FROM detail_transaksi WHERE notrans = '$id'";
                    $result_detail = mysqli_query($conn, $query_detail);
                }

                $no = 1;
                while ($detail_row = mysqli_fetch_assoc($result_detail)) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $detail_row['notrans'] ?></td>
                        <td><?= $detail_row['tindakan'] ?></td>
                        <td>Rp. <?= number_format($detail_row['harga'], 0, ',', '.') ?></td>
                        <td>Rp. <?= number_format($detail_row['jm'], 0, ',', '.') ?></td>
                        <td>Rp. <?= number_format($detail_row['modal'], 0, ',', '.') ?></td>
                        <td><?= $detail_row['diskon'] ?>%</td>
                        <td>Rp. <?= number_format($detail_row['total'], 0, ',', '.') ?></td>
                    </tr>
                <?php } ?>
            </tbody>

            <tfoot>
                <?php
                $grand_total = 0;
                $id = isset($_GET['id']) ? $_GET['id'] : '';
                $catatan = '';
                if ($result_detail) {
                    $result = mysqli_query($conn, "SELECT SUM(total) AS total, catatan FROM detail_transaksi WHERE notrans = '$id'");
                    $row = mysqli_fetch_assoc($result);
                    $grand_total = $row['total'];
                    $catatan = $row['catatan'];
                }
                ?>

                <tr>
                    <td colspan="11">Sub-Total: Rp. <?= number_format($grand_total, 0, ',', '.') ?>
                    </td>
                </tr>
            </tfoot>
        </table>

        <div class="row mt-5">
            <h3 class="main__title" style="color: #000; font-weight: bold;">Tabel Asistens</h3>
        </div>
        <table>

            <?php

            ?>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Asistens</th>
                    <th>Regio 1</th>
                    <th>Regio 2</th>
                    <th>Regio 3</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $no_transaksi = isset($_GET['id']) ? $_GET['id'] : '';
                $query_asistens = "SELECT a.*, k.nama 
                FROM asistens a 
                JOIN karyawan k ON a.id_karyawan = k.id 
                WHERE notrans = '$no_transaksi'";
                $result_asistens = mysqli_query($conn, $query_asistens);

                $no = 1;
                while ($asistens_row = mysqli_fetch_assoc($result_asistens)) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $asistens_row['nama'] ?></td>
                        <td><?= $asistens_row['ro1'] ?></td>
                        <td><?= $asistens_row['ro2'] ?></td>
                        <td><?= $asistens_row['ro3'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="col-md-12 mt-5">
            <label class="form-label">Catatan</label>
            <textarea class="form-control" required readonly><?= $catatan ?></textarea>
        </div>

        <div class="col-md-12 mt-4 d-flex justify-content-end">
            <a href="index.php?page=transaksi" type="button" class="btn btn-primary ms-3">Close</a>
        </div>
    </div>

</div>

<style>
    textarea {
        height: 100px;
        resize: none;
    }
</style>