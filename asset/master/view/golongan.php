<div class="tabular__wrapper">
    <div class="col-md-12 d-flex justify-content-end mb-4" style="gap: 1rem; align-items: center;">
        <div class="header__title text-sm" style="flex:1;">
            <h3 style="font-weight: 600; font-size: 1.2rem; margin-bottom: 0;">Tabel Golongan</h3>
        </div>

        <div class="input-group" style="width: 300px;">
            <input style="border-radius: 12px 0 0 12px; border-right: none;" type="text" name="search" class="form-control" placeholder="Cari golongan ..." id="searchInput">
            <span class="input-group-text" id="basic-addon1" style="border-radius: 0 12px 12px 0; border-left: none;">
                <i class="fa fa-search" aria-hidden="true"></i>
            </span>
        </div>

        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#input">
                <i class="fa fa-plus"></i> Tambah Data
            </button>
        </div>
    </div>

    <div class="table__container" style="max-height: 435px; overflow-y: auto;">
        <div class="table__box" style="max-height: 435px; overflow-y: auto;">
            <table>
                <thead style="position: sticky; top: 0; z-index: 1;">
                    <tr>
                        <th>No</th>
                        <th>Nama Golongan</th>
                        <th>Gaji Pokok</th>
                        <th>Tunjangan Makan</th>
                        <th>Overtime</th>
                        <th>Tunjangan Pasien</th>
                        <th>Ro 1</th>
                        <th>Ro 2</th>
                        <th>Ro 3</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tbody id="tindakanTableBody">
                    <?php
                    $query_golongan = "SELECT * FROM golongan";
                    $result_golongan = mysqli_query($conn, $query_golongan);
                    $no = 1;
                    if (mysqli_num_rows($result_golongan) > 0) { // Cek apakah ada data
                        while ($golongan_row = mysqli_fetch_assoc($result_golongan)) { ?>
                            <tr>
                                <td><?= $no++ ?>.</td>
                                <td><?= $golongan_row['nama_golongan'] ?></td>
                                <td>Rp. <?= empty($golongan_row['gaji_pokok']) ? '0' : number_format($golongan_row['gaji_pokok'], 0, ',', '.') ?></td>
                                <td>Rp. <?= empty($golongan_row['tunjangan_makan']) ? '0' : number_format($golongan_row['tunjangan_makan'], 0, ',', '.') ?></td>
                                <td>Rp. <?= empty($golongan_row['overtime']) ? '0' : number_format($golongan_row['overtime'], 0, ',', '.') ?></td>
                                <td>Rp. <?= empty($golongan_row['tunjangan_pasien']) ? '0' : number_format($golongan_row['tunjangan_pasien'], 0, ',', '.') ?></td>
                                <td>Rp. <?= empty($golongan_row['ro1']) ? '0' : number_format($golongan_row['ro1'], 0, ',', '.') ?></td>
                                <td>Rp. <?= empty($golongan_row['ro2']) ? '0' : number_format($golongan_row['ro2'], 0, ',', '.') ?></td>
                                <td>Rp. <?= empty($golongan_row['ro3']) ? '0' : number_format($golongan_row['ro3'], 0, ',', '.') ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $golongan_row['id'] ?>" style="box-shadow: none; font-size: 10px; padding: 5px 7px;">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <a href="app/golongan/delete.php?id=<?= $golongan_row['id'] ?>" class="btn btn-danger mt-2" style="box-shadow: none; font-size: 10px; padding: 5px 8px;" onclick="return confirmDelete('<?= $golongan_row['nama_golongan'] ?>')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>

                                <!-- MODAL EDIT -->
                                <div class="modal fade" id="edit<?= $golongan_row['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Edit Golongan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
                                            </div>

                                            <form class="row g-4 mt-2" action="app/golongan/update.php" method="post" onsubmit="return confirm('Apakah Anda yakin ingin mengubah data golongan?');">
                                                <div class="modal-body">

                                                    <input type="hidden" name="id" id="id" value="<?= $golongan_row['id'] ?>">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <label class="form-label">Nama Golongan</label>
                                                            <div class="input-group mb-3">
                                                                <select class="form-select" name="nama_golongan" id="nama_golongan" required>
                                                                    <option value="">Pilih Golongan</option>
                                                                    <option value="1" <?= ($golongan_row['nama_golongan'] == 'Karyawan') ? 'selected' : '' ?>>Karyawan</option>
                                                                    <option value="2" <?= ($golongan_row['nama_golongan'] == 'Dokter') ? 'selected' : '' ?>>Dokter</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Gaji Pokok</label>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text">Rp.</span>
                                                                <input type="number" class="form-control" name="gaji_pokok" id="gaji_pokok" value="<?= isset($golongan_row['gaji_pokok']) ? $golongan_row['gaji_pokok'] : '' ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label class="form-label">Tunjangan Makan</label>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text">Rp.</span>
                                                                <input type="number" class="form-control" name="tunjangan_makan" id="tunjangan_makan" value="<?= isset($golongan_row['tunjangan_makan']) ? $golongan_row['tunjangan_makan'] : '' ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Overtime</label>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text">Rp.</span>
                                                                <input type="number" class="form-control" name="overtime" id="overtime" value="<?= isset($golongan_row['overtime']) ? $golongan_row['overtime'] : '' ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Tunjangan Pasien</label>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text">Rp.</span>
                                                                <input type="number" class="form-control" name="tunjangan_pasien" id="tunjangan_pasien" value="<?= isset($golongan_row['tunjangan_pasien']) ? $golongan_row['tunjangan_pasien'] : '' ?>">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label class="form-label">Ro 1</label>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text">Rp.</span>
                                                                <input type="number" class="form-control" name="ro1" id="ro1" value="<?= isset($golongan_row['ro1']) ? $golongan_row['ro1'] : '' ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Ro 2</label>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text">Rp.</span>
                                                                <input type="number" class="form-control" name="ro2" id="ro2" value="<?= isset($golongan_row['ro2']) ? $golongan_row['ro2'] : '' ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Ro 3</label>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text">Rp.</span>
                                                                <input type="number" class="form-control" name="ro3" id="ro3" value="<?= isset($golongan_row['ro3']) ? $golongan_row['ro3'] : '' ?>">
                                                            </div>
                                                        </div>
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
                                <!-- END MODAL EDIT -->
                            </tr>


                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada karyawan</td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>

    </div>

    <div class="col-md-12 mt-4 d-flex justify-content-end">
        <a href="masterdata.php" type="submit" class="btn btn-primary">Kembali</a>
    </div>

    <!-- INPUT -->
    <div class="modal fade" id="input" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Golongan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
                </div>

                <div class="modal-body">
                    <form class="row g-4" action="app/golongan/input.php" method="post">

                        <div class="col-md-8">
                            <label class="form-label">Nama Golongan</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="nama_golongan" placeholder="Nama Golongan" autofocus required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Gaji Pokok</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Rp.</span>
                                <input type="number" class="form-control" name="gaji_pokok" placeholder="Gaji Pokok" autofocus required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Tunjangan Makan</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Rp.</span>
                                <input type="number" class="form-control" name="tunjangan_makan" placeholder="Tunjangan Makan" autofocus required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Overtime</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Rp.</span>
                                <input type="number" class="form-control" name="overtime" placeholder="Overtime" autofocus>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Tunjangan Pasien</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Rp.</span>
                                <input type="number" class="form-control" name="tunjangan_pasien" placeholder="Tunjangan Pasien" autofocus>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Ro 1</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Rp.</span>
                                <input type="number" class="form-control" name="ro1" placeholder="Ro 1" autofocus>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Ro 2</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Rp.</span>
                                <input type="number" class="form-control" name="ro2" placeholder="Ro 2" autofocus>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Ro 3</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Rp.</span>
                                <input type="number" class="form-control" name="ro3" placeholder="Ro 3" autofocus>
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
    <!-- END INPUT -->



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
                noDataRow.innerHTML = '<td colspan="10" class="text-center">Data tidak tersedia</td>'; // Sesuaikan jumlah kolom
                document.getElementById('tindakanTableBody').appendChild(noDataRow);
            } else {
                // Jika ada data yang ditemukan, hapus pesan jika ada
                var noDataRow = document.getElementById('noDataRow');
                if (noDataRow) {
                    noDataRow.remove();
                }
            }
        });

        function confirmDelete(nama) {
            // Menggunakan alert danger untuk konfirmasi penghapusan
            return confirm("Apakah Anda yakin ingin menghapus data Atas nama " + nama + " ?")
        }
    </script>

</div>