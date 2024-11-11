<div class="tabular__wrapper">
    <div class="col-md-12 d-flex justify-content-end mb-4" style="gap: 1rem; align-items: center;">
        <div class="header__title text-sm" style="flex:1;">
            <h3 style="font-weight: 600; font-size: 1.2rem; margin-bottom: 0;">Transaksi Hari ini</h3>
        </div>

        <div class="input-group" style="width: 300px;">
            <input style="border-radius: 12px 0 0 12px; border-right: none;" type="text" name="search" class="form-control" placeholder="Cari transaksi ..." id="searchInput">
            <span class="input-group-text" id="basic-addon1" style="border-radius: 0 12px 12px 0; border-left: none;">
                <i class="fa fa-search" aria-hidden="true"></i>
            </span>
        </div>

        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#input">
                <i class="fa fa-plus"></i> Tambah transaksi
            </button>
        </div>
    </div>

    <div class="table__container">
        <div class="table__box" style="max-height: 510px; overflow-y: auto;">
            <table>
                <thead style="position: sticky; top: 0; z-index: 1;">
                    <tr>
                        <th>No</th>
                        <th>No Transaksi</th>
                        <th>tanggal</th>
                        <th>Dokter</th>
                        <th>Nama Klien</th>
                        <th>Total</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tbody id="transaksiTableBody">
                    <?php
                    $todays = date('Y-m-d');
                    $query_transaksi = "SELECT t.*, k.nama as nama_dokter FROM transaksi t
                    JOIN karyawan k ON t.dokter = k.id
                    WHERE DATE_FORMAT(t.tanggal, '%Y-%m-%d') = '$todays'";
                    $result_transaksi = mysqli_query($conn, $query_transaksi);
                    $no = 1;
                    if (mysqli_num_rows($result_transaksi) > 0) { // Cek apakah ada data
                        while ($transaksi_row = mysqli_fetch_assoc($result_transaksi)) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $transaksi_row['notrans'] ?></td>
                                <td><?= $todays ?></td>
                                <td><?= $transaksi_row['nama_dokter'] ?></td>
                                <td><?= $transaksi_row['nama_klien'] ?></td>
                                <td>Rp. <?= number_format($transaksi_row['total'], 0, ',', '.') ?></td>
                                <td>
                                    <?php if ($transaksi_row['status'] === 'off') { ?>
                                        <a href="index.php?page=view_detail&id=<?= $transaksi_row['notrans'] ?>" class="btn btn-sm btn-primary" style="text-align: center;">
                                            Detail
                                        </a>
                                    <?php } else { ?>
                                        <a href="index.php?page=detail&id=<?= $transaksi_row['notrans'] ?>" class="btn btn-sm btn-primary" style="text-align: center;">
                                            Detail
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada transaksi</td>
                        </tr>
                    <?php } ?>
                </tbody>

                <tfoot style="position: sticky; bottom: 0; z-index: 1;">
                    <tr>
                        <td colspan=" 11">Sub-Total: Rp. <?= number_format($grand_total, 0, ',', '.') ?>
                        </td>
                    </tr>
                </tfoot>

            </table>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="input" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Input Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-4" action="app/transaksi/input.php" method="post">

                        <div class="row d-flex justify-content-end mt-3">
                            <label class="col-md-2 col-form-label">Tanggal</label>
                            <div class="col-sm-3">
                                <input
                                    type="date"
                                    class="form-control"
                                    value="<?php echo date('Y-m-d'); ?>"
                                    name="tanggal"
                                    readonly />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">No. Transaksi</label>
                            <?php
                            // Ambil nilai terakhir dari database
                            $query = "SELECT notrans FROM transaksi ORDER BY id DESC LIMIT 1"; // Ganti 'id' dengan kolom yang sesuai
                            $result = mysqli_query($conn, $query);
                            $last_transaksi = mysqli_fetch_assoc($result);
                            $next_transaksi = isset($last_transaksi['notrans']) ? 'TN' . str_pad((int)substr($last_transaksi['notrans'], 2) + 1, 3, '0', STR_PAD_LEFT) : 'TN001';
                            ?>
                            <input type="text" name="notrans" class="form-control" value="<?= $next_transaksi ?>" required readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Nama Klien</label>
                            <input type="text" name="nama_klien" class="form-control" placeholder="Masukan Nama" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Dokter</label>
                            <select name="dokter" class="form-select" required>
                                <option value="">Pilih dokter</option>

                                <?php
                                $query_karyawan = "SELECT k.*, g.nama_golongan FROM karyawan k
                                JOIN golongan g ON k.golongan_id = g.id
                                WHERE g.nama_golongan = 'Dokter'";
                                $result_karyawan = mysqli_query($conn, $query_karyawan);
                                while ($karyawan = mysqli_fetch_assoc($result_karyawan)) { ?>
                                    <option value="<?= $karyawan['id'] ?>"><?= $karyawan['nama'] ?></option>
                                <?php } ?>
                            </select>
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
</div>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        var input = this.value.toLowerCase();
        var rows = document.querySelectorAll('#transaksiTableBody tr');
        var foundAny = false; // Variabel untuk mengecek apakah ada data yang ditemukan

        rows.forEach(function(row) {
            var cells = row.getElementsByTagName('td');
            var found = false;
            for (var i = 0; i < cells.length; i++) {
                if (cells[i].textContent.toLowerCase().indexOf(input) > -1) {
                    found = true;
                    break;
                }
            }
            row.style.display = found ? '' : 'none';
            if (found) foundAny = true; // Jika ditemukan, set foundAny ke true
        });

        // Jika tidak ada data yang ditemukan, tampilkan pesan
        if (!foundAny) {
            document.getElementById('noDataRow')?.remove(); // Hapus baris pesan jika ada
            var noDataRow = document.createElement('tr');
            noDataRow.id = 'noDataRow';
            noDataRow.innerHTML = '<td colspan="7" class="text-center">Data tidak tersedia</td>'; // Sesuaikan jumlah kolom
            document.getElementById('transaksiTableBody').appendChild(noDataRow);
        } else {
            // Jika ada data yang ditemukan, hapus pesan jika ada
            var noDataRow = document.getElementById('noDataRow');
            if (noDataRow) {
                noDataRow.remove();
            }
        }
    });
</script>