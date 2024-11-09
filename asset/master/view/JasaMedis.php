<div class="tabular__wrapper">
    <div class="col-md-12 d-flex justify-content-end mb-4" style="gap: 1rem; align-items: center;">
        <div class="header__title text-sm" style="flex:1;">
            <h3 style="font-weight: 600; font-size: 1.2rem; margin-bottom: 0;">Data Jasa Medis</h3>
        </div>

        <div class="input-group" style="width: 300px;">
            <input style="border-radius: 12px 0 0 12px; border-right: none;" type="text" name="search" class="form-control" placeholder="Cari Dokter ..." id="searchInput">
            <span class="input-group-text" id="basic-addon1" style="border-radius: 0 12px 12px 0; border-left: none;">
                <i class="fa fa-search" aria-hidden="true"></i>
            </span>
        </div>
    </div>

    <div class="table__container" id="penggajianTableContainer">
        <div class="table__box" style="max-height: 500px; overflow-y: auto;">
            <table>
                <thead style="position: sticky; top: 0; z-index: 1;">
                    <tr>
                        <th>No</th>
                        <th>Dokter</th>
                        <th>Tindakan</th>
                        <th>Jasa Medis</th>
                        <th>Diskon</th>
                        <th>Modal</th>
                        <th>DP</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tbody id="transaksiTableBody">
                    <?php
                    $grand_total = 0;
                    $query_transaksi = "SELECT 
                    t.dokter,
                    k.nama,
                    GROUP_CONCAT(DISTINCT t.notrans) as notrans,
                    SUM(dt.jm) as total_jm,
                    SUM(dt.diskon) as total_diskon,
                    SUM(dt.harga) as total_harga,
                    SUM(dt.modal) as total_modal,
                    SUM(dt.dp) as total_dp
                FROM transaksi t
                JOIN karyawan k ON t.dokter = k.id
                JOIN detail_transaksi dt ON t.notrans = dt.notrans
                WHERE MONTH(t.tanggal) = MONTH(CURRENT_DATE())
                AND YEAR(t.tanggal) = YEAR(CURRENT_DATE())
                GROUP BY t.dokter, k.nama";
                    $result_transaksi = mysqli_query($conn, $query_transaksi);
                    $no = 1;
                    if (mysqli_num_rows($result_transaksi) > 0) {
                        while ($transaksi_row = mysqli_fetch_assoc($result_transaksi)) {
                            $grand_total += $transaksi_row['total_jm'];
                    ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $transaksi_row['nama'] ?></td>
                                <td>Rp. <?= empty($transaksi_row['total_harga']) ? '0' : number_format($transaksi_row['total_harga'], 0, ',', '.') ?></td>
                                <td>Rp. <?= empty($transaksi_row['total_jm']) ? '0' : number_format($transaksi_row['total_jm'], 0, ',', '.') ?></td>
                                <td><?= empty($transaksi_row['total_diskon']) ? '0' : number_format($transaksi_row['total_diskon'], 0, ',', '.') ?>%</td>
                                <td>Rp. <?= empty($transaksi_row['total_modal']) ? '0' : number_format($transaksi_row['total_modal'], 0, ',', '.') ?></td>
                                <td>Rp. <?= empty($transaksi_row['total_dp']) ? '0' : number_format($transaksi_row['total_dp'], 0, ',', '.') ?></td>
                                <td>
                                    <a href="pdf/jasamedis.php?dokter=<?= $transaksi_row['dokter'] ?>" class="btn btn-sm btn-success" target="_blank">
                                        <i class="fa fa-print"></i> Print
                                    </a>
                                </td>
                            </tr>

                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data</td>
                        </tr>
                    <?php } ?>
                </tbody>



                <tfoot>
                    <tr>
                        <th colspan="8">Total Jasa Medis : Rp. <?= number_format($grand_total, 0, ',', '.') ?></th>
                    </tr>
                </tfoot>

            </table>
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
            noDataRow.innerHTML = '<td colspan="11" class="text-center">Data tidak tersedia</td>'; // Sesuaikan jumlah kolom
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