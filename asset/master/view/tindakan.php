<div class="tabular__wrapper" id="tindakan" disabled>
    <div class="col-md-12 d-flex justify-content-end mb-4" style="gap: 1rem; align-items: center;">
        <div class="header__title text-sm" style="flex:1;">
            <h3 style="font-weight: 600; font-size: 1.2rem; margin-bottom: 0;">Tabel Tindakan</h3>
        </div>

        <div class="input-group" style="width: 300px;">
            <input style="border-radius: 12px 0 0 12px; border-right: none;" type="text" name="search" class="form-control" placeholder="Cari tindakan ..." id="searchInput">
            <span class="input-group-text" id="basic-addon1" style="border-radius: 0 12px 12px 0; border-left: none;">
                <i class="fa fa-search" aria-hidden="true"></i>
            </span>
        </div>

        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#input">
                <i class="fa fa-plus"></i> Tambah Tindakan
            </button>
        </div>
    </div>

    <div class="table__container" id="tindakanTable">
        <div class="table__box" style="max-height: 435px; overflow-y: auto;">
            <table>
                <thead style="position: sticky; top: 0; z-index: 1;">
                    <tr>
                        <th>No</th>
                        <th>Nama Tindakan</th>
                        <th>Type Jasa Medis</th>
                        <th>Harga</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tbody id="tindakanTableBody">
                    <?php
                    $no = 1;
                    if (mysqli_num_rows($result_tindakan) > 0) { // Cek apakah ada data
                        while ($tindakan_row = mysqli_fetch_assoc($result_tindakan)) { ?>
                            <tr>
                                <td><?= $no++ ?>.</td>
                                <td><?= $tindakan_row['nama_tindakan'] ?></td>
                                <td><?= $tindakan_row['jm'] ?></td>
                                <td>Rp. <?= number_format($tindakan_row['harga'], 0, ',', '.') ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#update" onclick="setUpdateData(<?= $tindakan_row['id'] ?>, '<?= $tindakan_row['nama_tindakan'] ?>', <?= $tindakan_row['jm'] ?>, <?= $tindakan_row['harga'] ?>)">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                    <a href="app/tindakan/delete.php?id=<?= $tindakan_row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete('<?= $tindakan_row['nama_tindakan'] ?>')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada tindakan</td>
                        </tr>
                    <?php } ?>
                </tbody>

                <tfoot style="position: sticky; bottom: 0; z-index: 1;">
                    <tr>
                        <td colspan="5">Note Type Jasa Medis :
                            [ 0 = harga x 50%,

                            1 = harga,

                            2 harga - 20000,

                            3 harga x 65%,

                            4 (harga - modal) x 50% ]
                        </td>
                    </tr>
                </tfoot>

            </table>
        </div>

    </div>

    <div class="col-md-12 mt-4 d-flex justify-content-end">
        <a href="masterdata.php" type="submit" class="btn btn-primary">Kembali</a>
    </div>

    <!-- Modal -->

    <!-- UPDATE -->
    <div class="modal fade" id="update" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update Tindakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-4" action="app/tindakan/update.php" method="post">

                        <input type="hidden" name="id" id="id">
                        <div class="col-md-4">
                            <label class="form-label">Nama Tindakan</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="nama_tindakan" value="<?= isset($tindakan_row['nama_tindakan']) ? $tindakan_row['nama_tindakan'] : '' ?>">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Type Jasa Medis</label>
                            <div class="input-group mb-3">
                                <select class="form-select" name="jm">
                                    <option value="0">0 harga x 50%</option>
                                    <option value="1">1 harga</option>
                                    <option value="2">2 harga - 20000</option>
                                    <option value="3">3 harga x 65%</option>
                                    <option value="4">4 (harga - modal) x 50%</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Harga Tindakan</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <input type="number" name="harga" class="form-control" value="<?= isset($tindakan_row['harga']) ? $tindakan_row['harga'] : '' ?>">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModal()">Close</button>
                                <button type="submit" class="btn btn-primary ms-3">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- INPUT -->
    <div class="modal fade" id="input" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Input Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-4" action="app/tindakan/input.php" method="post">
                        <div class="col-md-4">
                            <label class="form-label">Nama Tindakan</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="nama_tindakan" value="" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Type Jasa Medis</label>
                            <div class="input-group mb-3">
                                <select class="form-select" name="jm" required>
                                    <option value="0">0 harga x 50%</option>
                                    <option value="1">1 harga</option>
                                    <option value="2">2 harga - 20000</option>
                                    <option value="3">3 harga x 65%</option>
                                    <option value="4">4 (harga - modal) x 50%</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Harga Tindakan</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <input type="number" name="harga" class="form-control" value="" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModal()">Close</button>
                                <button type="submit" class="btn btn-primary ms-3">Simpan</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            var input = this.value.toLowerCase();
            var rows = document.querySelectorAll('#tindakanTableBody tr');
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
                noDataRow.innerHTML = '<td colspan="5" class="text-center">Data tidak tersedia</td>'; // Sesuaikan jumlah kolom
                document.getElementById('tindakanTableBody').appendChild(noDataRow);
            } else {
                // Jika ada data yang ditemukan, hapus pesan jika ada
                var noDataRow = document.getElementById('noDataRow');
                if (noDataRow) {
                    noDataRow.remove();
                }
            }
        });

        function setUpdateData(id, namaTindakan, jm, harga) {
            document.getElementById('id').value = id;
            document.querySelector('input[name="nama_tindakan"]').value = namaTindakan;
            document.querySelector('select[name="jm"]').value = jm;
            document.querySelector('input[name="harga"]').value = harga;
        }

        function confirmDelete(namaTindakan) {
            return confirm("Apakah Anda yakin ingin menghapus data tindakan " + namaTindakan + " ?");
        }
    </script>

</div>