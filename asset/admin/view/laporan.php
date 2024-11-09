<div class="tabular__wrapper">
    <div class="col-md-12 d-flex justify-content-end mb-4" style="gap: 1rem; align-items: center;">
        <div class="header__title text-sm" style="flex:1;">
            <h3 style="font-weight: 600; font-size: 1.2rem; margin-bottom: 0;">Laporan</h3>
        </div>

        <div class="input-group" style="width: 300px;">
            <input style="border-radius: 12px 0 0 12px; border-right: none;" type="text" name="search" class="form-control" placeholder="Cari data spesifik" id="searchInput">
            <span class="input-group-text" id="basic-addon1" style="border-radius: 0 12px 12px 0; border-left: none;">
                <i class="fa fa-search" aria-hidden="true"></i>
            </span>
        </div>
    </div>

    <div class="row g-3 mt-2">
        <div class="row">
            <div class="col-md-12 tombol">
                <button type="button" class="btn btn-sm" id="btnTransaksi" style="border-bottom: var(--main-color) solid 2px; background-color: transparent; box-shadow: none;" onclick="showSection('transaksi', this)">
                    <p style="font-weight: 600;">Transaksi</p>
                </button>
            </div>
        </div>

        <script>
            function showSection(sectionId, button, isEdit = false) {
                // Sembunyikan semua section
                document.querySelectorAll('.section').forEach(function(section) {
                    section.style.display = 'none';
                });
                // Tampilkan section yang dipilih
                document.getElementById(sectionId).style.display = 'block';

                // Reset border bottom untuk semua tombol
                document.querySelectorAll('.tombol button').forEach(function(btn) {
                    btn.style.borderBottom = 'none';
                });

                // Set border bottom untuk tombol yang aktif
                button.style.borderBottom = 'var(--main-color) solid 2px';
            }
        </script>
    </div>

    <div class="row g-3 mt-2">

        <div id="transaksi" class="section">
            <form action="../master/pdf/rekap_transaksi.php" method="get">
                <div class="header__title text-sm mb-4" style="flex:1;">
                    <h3 style="font-weight: 600; font-size: 1.2rem; margin-bottom: 0;">Tabel Transaksi</h3>
                    <div class="d-flex justify-content-end mb-4 mt-0" style="gap: 1rem;">
                        <div class="input-group" style="width: 200px;">
                            <input style="border-radius: 12px;" type="month" name="bulan" id="tanggalFilterTransaksi" class="form-control" placeholder="Bulan & Tahun">
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-file-pdf"></i> Download PDF
                        </button>
                    </div>
                </div>
            </form>

            <div style="overflow-y: auto; max-height: 340px;">
                <table>
                    <thead style="position: sticky; top: 0; z-index: 1;">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Dokter</th>
                            <th>Nama Klien</th>
                            <th>Total</th>
                            <th>Tools</th>
                        </tr>
                    </thead>
                    <tbody id="transaksiTableBody">
                        <?php
                        $no = 1;
                        $bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
                        $tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

                        $query_transaksi = mysqli_query($conn, "SELECT t.*, k.nama AS nama_dokter FROM transaksi t
                        LEFT JOIN karyawan k ON t.dokter = k.id
                        WHERE t.status = 'off'");
                        if (mysqli_num_rows($query_transaksi) > 0) {
                            while ($transaksi_row = mysqli_fetch_assoc($query_transaksi)) {
                        ?>
                                <tr>
                                    <td><?= $no++ ?>.</td>
                                    <td><?= $transaksi_row['tanggal'] ?></td>
                                    <td><?= $transaksi_row['nama_dokter'] ?></td>
                                    <td><?= $transaksi_row['nama_klien'] ?></td>
                                    <td>Rp. <?= number_format($transaksi_row['total'], 0, ',', '.') ?></td>
                                    <td>
                                        <a href="../master/pdf/transaksi.php?notrans=<?= $transaksi_row['notrans'] ?>" class="btn btn-sm btn-success" target="_blank">
                                            <i class="fa fa-print"></i> Print
                                        </a>
                                    </td>
                                </tr>
                            <?php }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data</td>
                            </tr>
                        <?php } ?>
                    </tbody>

                    <script>

                    </script>

                    <tfoot style="position: sticky; bottom: 0; z-index: 1;">
                        <tr>
                            <td colspan="6">Note : Filter dengan bulan dan tahun</td>
                        </tr>
                    </tfoot>

                </table>
            </div>


        </div>
    </div>
</div>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        var input = this.value.toLowerCase();
        var rows = document.querySelectorAll('#transaksiTableBody tr');
        var foundAny = false;

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
            if (found) foundAny = true;
        });

        handleNoDataMessage('transaksiTableBody', 'noDataRow', foundAny, 6);
    });

    function handleNoDataMessage(tableId, noDataRowId, foundAny, colspan) {
        if (!foundAny) {
            document.getElementById(noDataRowId)?.remove();
            var noDataRow = document.createElement('tr');
            noDataRow.id = noDataRowId;
            noDataRow.innerHTML = `<td colspan="${colspan}" class="text-center">Data tidak tersedia</td>`;
            document.getElementById(tableId).appendChild(noDataRow);
        } else {
            var noDataRow = document.getElementById(noDataRowId);
            if (noDataRow) {
                noDataRow.remove();
            }
        }
    }

    document.getElementById('tanggalFilterTransaksi').addEventListener('change', function() {
        filterByDate('transaksiTableBody', this.value, 6);
    });

    function filterByDate(tableId, tanggal, colspan) {
        var tbody = document.getElementById(tableId);
        var rows = tbody.getElementsByTagName('tr');
        var foundAny = false;

        var existingNoDataRow = tbody.querySelector('.no-data-row');
        if (existingNoDataRow) {
            existingNoDataRow.remove();
        }

        for (var i = 0; i < rows.length; i++) {
            var tanggalCell = rows[i].getElementsByTagName('td')[1];
            if (tanggalCell) {
                var tanggalData = tanggalCell.textContent.trim();
                var tanggalDataYM = tanggalData.substring(0, 7);
                if (tanggal === '' || tanggalDataYM === tanggal) {
                    rows[i].style.display = '';
                    foundAny = true;
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }

        if (!foundAny) {
            var noDataRow = document.createElement('tr');
            noDataRow.className = 'no-data-row';
            noDataRow.innerHTML = `<td colspan="${colspan}" class="text-center">Data tidak tersedia</td>`;
            tbody.appendChild(noDataRow);
        }
        document.getElementById('searchInput').value = '';
    }

    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');

    document.getElementById('tanggalFilterTransaksi').value = `${year}-${month}`;
</script>