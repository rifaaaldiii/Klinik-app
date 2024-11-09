<div class="tabular__wrapper">
    <div class="col-md-12 d-flex justify-content-end mb-4" style="gap: 1rem; align-items: center;">
        <div class="header__title text-sm" style="flex:1;">
            <h3 style="font-weight: 600; font-size: 1.2rem; margin-bottom: 0;">Tabel Karyawan</h3>
        </div>

        <div class="input-group" style="width: 300px;">
            <input style="border-radius: 12px 0 0 12px; border-right: none;" type="text" name="search" class="form-control" placeholder="Cari karyawan ..." id="searchInput">
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
                        <th>Nama Karyawan</th>
                        <th>Jenis Kelamin</th>
                        <th>No. HP</th>
                        <th>Role</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tbody id="tindakanTableBody">
                    <?php
                    $query_karyawan = "SELECT k.*, g.nama_golongan 
                    FROM karyawan k 
                    LEFT JOIN golongan g ON k.golongan_id = g.id
                    ORDER BY k.id DESC";
                    $result_karyawan = mysqli_query($conn, $query_karyawan);

                    $no = 1;
                    if (mysqli_num_rows($result_karyawan) > 0) { // Cek apakah ada data
                        while ($karyawan_row = mysqli_fetch_assoc($result_karyawan)) { ?>
                            <tr>
                                <td><?= $no++ ?>.</td>
                                <td><?= $karyawan_row['nama'] ?></td>
                                <td><?= $karyawan_row['jenis_kelamin'] ?></td>
                                <td><?= $karyawan_row['telpon'] ?></td>
                                <td><?= $karyawan_row['nama_golongan'] ?></td>
                                <td>

                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#info<?= $karyawan_row['id'] ?>" style="box-shadow: none;">
                                        <i class="fa fa-eye"></i>
                                    </button>

                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $karyawan_row['id'] ?>" style="box-shadow: none;">
                                        <i class="fa fa-pencil"></i>
                                    </button>

                                    <a href="app/karyawan/delete.php?id=<?= $karyawan_row['id'] ?>&nik=<?= $karyawan_row['nik'] ?>" class="btn btn-sm btn-danger" style="box-shadow: none;" onclick="return confirmDelete('<?= $karyawan_row['nama'] ?>')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>

                                <!-- MODAL INFO -->
                                <div class="modal fade" id="info<?= $karyawan_row['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Detail Karyawan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
                                            </div>

                                            <div class="modal-body" style="padding: 1rem;">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label class="form-label">Nama Karyawan</label>
                                                        <div class="input-group mb-3">
                                                            <input type="text" class="form-control" name="nama" id="nama" value="<?= isset($karyawan_row['nama']) ? $karyawan_row['nama'] : '' ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label">Tanggal Lahir</label>
                                                        <div class="input-group mb-3">
                                                            <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="<?= isset($karyawan_row['tanggal_lahir']) ? $karyawan_row['tanggal_lahir'] : '' ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="form-label">NIP</label>
                                                        <div class="input-group mb-3">
                                                            <input type="text" class="form-control" name="nip" id="nip" value="<?= isset($karyawan_row['nip']) ? $karyawan_row['nip'] : '' ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label">NIK</label>
                                                        <div class="input-group mb-3">
                                                            <input type="text" class="form-control" name="nik" id="nik" value="<?= isset($karyawan_row['nik']) ? $karyawan_row['nik'] : '' ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label">Jenis Kelamin</label>
                                                        <div class="input-group mb-3">
                                                            <input type="text" class="form-control" name="jenis_kelamin" id="jenis_kelamin" value="<?= isset($karyawan_row['jenis_kelamin']) ? $karyawan_row['jenis_kelamin'] : '' ?>" readonly>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label">No. HP</label>
                                                        <div class="input-group mb-3">
                                                            <input type="text" class="form-control" name="telpon" id="telpon" value="<?= isset($karyawan_row['telpon']) ? $karyawan_row['telpon'] : '' ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">No. Rekening</label>
                                                        <div class="input-group mb-3">
                                                            <input type="text" class="form-control" name="no_rek" id="no_rek" value="<?= isset($karyawan_row['no_rek']) ? $karyawan_row['no_rek'] : '' ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="form-label">Alamat</label>
                                                        <div class="input-group mb-3">
                                                            <textarea class="form-control" name="alamat" id="alamat" readonly style="height: 150px;"><?= isset($karyawan_row['alamat']) ? $karyawan_row['alamat'] : '' ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Agama</label>
                                                        <div class="input-group mb-3">
                                                            <input type="text" class="form-control" name="agama" id="agama" value="<?= isset($karyawan_row['agama']) ? $karyawan_row['agama'] : '' ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label">Golongan</label>
                                                        <div class="input-group mb-3">
                                                            <input type="text" class="form-control" name="golongan_id" id="golongan_id" value="<?= isset($karyawan_row['golongan_id']) ? $karyawan_row['golongan_id'] : '' ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label">Role</label>
                                                        <div class="input-group mb-3">
                                                            <input type="text" class="form-control" name="role" id="role" value="<?= isset($karyawan_row['nama_golongan']) ? $karyawan_row['nama_golongan'] : '' ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModal()">Close</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- END MODAL INFO -->

                                <!-- MODAL EDIT -->
                                <div class="modal fade" id="edit<?= $karyawan_row['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Edit Karyawan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
                                            </div>

                                            <form class="row g-4 mt-2" action="app/karyawan/update.php" method="post" onsubmit="return confirm('Apakah Anda yakin ingin mengubah data karyawan?');">
                                                <div class="modal-body">

                                                    <input type="hidden" name="id" id="id" value="<?= $karyawan_row['id'] ?>">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <label class="form-label">Nama Karyawan</label>
                                                            <div class="input-group mb-3">
                                                                <input type="text" class="form-control" name="nama" id="nama" value="<?= isset($karyawan_row['nama']) ? $karyawan_row['nama'] : '' ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Tanggal Lahir</label>
                                                            <div class="input-group mb-3">
                                                                <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="<?= isset($karyawan_row['tanggal_lahir']) ? $karyawan_row['tanggal_lahir'] : '' ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label class="form-label">NIP</label>
                                                            <div class="input-group mb-3">
                                                                <input type="text" class="form-control" name="nip" id="nip" value="<?= isset($karyawan_row['nip']) ? $karyawan_row['nip'] : '' ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">NIK</label>
                                                            <div class="input-group mb-3">
                                                                <input type="text" class="form-control" name="nik" id="nik" value="<?= isset($karyawan_row['nik']) ? $karyawan_row['nik'] : '' ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Jenis Kelamin</label>
                                                            <div class="input-group mb-3">
                                                                <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" required>
                                                                    <option value="Laki-laki" <?= (isset($karyawan_row['jenis_kelamin']) && $karyawan_row['jenis_kelamin'] == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                                                                    <option value="Perempuan" <?= (isset($karyawan_row['jenis_kelamin']) && $karyawan_row['jenis_kelamin'] == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="form-label">No. HP</label>
                                                            <div class="input-group mb-3">
                                                                <input type="text" class="form-control" name="telpon" id="telpon" value="<?= isset($karyawan_row['telpon']) ? $karyawan_row['telpon'] : '' ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label">No. Rekening</label>
                                                            <div class="input-group mb-3">
                                                                <input type="text" class="form-control" name="no_rek" id="no_rek" value="<?= isset($karyawan_row['no_rek']) ? $karyawan_row['no_rek'] : '' ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label class="form-label">Alamat</label>
                                                            <div class="input-group mb-3">
                                                                <textarea class="form-control" name="alamat" id="alamat" style="height: 130px;"><?= isset($karyawan_row['alamat']) ? $karyawan_row['alamat'] : '' ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Agama</label>
                                                            <div class="input-group mb-3">
                                                                <select class="form-select" name="agama" id="agama" required>
                                                                    <option value="">Pilih Agama</option>
                                                                    <option value="Islam" <?= (isset($karyawan_row['agama']) && $karyawan_row['agama'] == 'Islam') ? 'selected' : '' ?>>Islam</option>
                                                                    <option value="Kristen" <?= (isset($karyawan_row['agama']) && $karyawan_row['agama'] == 'Kristen') ? 'selected' : '' ?>>Kristen</option>
                                                                    <option value="Katolik" <?= (isset($karyawan_row['agama']) && $karyawan_row['agama'] == 'Katolik') ? 'selected' : '' ?>>Katolik</option>
                                                                    <option value="Hindu" <?= (isset($karyawan_row['agama']) && $karyawan_row['agama'] == 'Hindu') ? 'selected' : '' ?>>Hindu</option>
                                                                    <option value="Buddha" <?= (isset($karyawan_row['agama']) && $karyawan_row['agama'] == 'Buddha') ? 'selected' : '' ?>>Buddha</option>
                                                                    <option value="Konghucu" <?= (isset($karyawan_row['agama']) && $karyawan_row['agama'] == 'Konghucu') ? 'selected' : '' ?>>Konghucu</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label">Golongan</label>
                                                            <div class="input-group mb-3">
                                                                <select class="form-select" name="golongan_id" id="golongan_id" required>
                                                                    <option value="<?= isset($karyawan_row['golongan_id']) ? $karyawan_row['golongan_id'] : '' ?>">
                                                                        <?= isset($karyawan_row['nama_golongan']) ? $karyawan_row['nama_golongan'] : 'Pilih Golongan' ?>
                                                                    </option>
                                                                    <?php
                                                                    $query = "SELECT * FROM golongan WHERE id != " . $karyawan_row['golongan_id'];
                                                                    $result = mysqli_query($conn, $query);
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                    ?>
                                                                        <option value="<?= $row['id'] ?>"><?= $row['nama_golongan'] ?></option>
                                                                    <?php } ?>
                                                                </select>
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
                            <td colspan="6" class="text-center">Tidak ada karyawan</td>
                        </tr>
                    <?php } ?>
                </tbody>

                <tfoot style="position: sticky; bottom: 0; z-index: 1;">
                    <tr>
                        <td colspan="6">Note : Golongan 1 = Karyawan, Golongan 2 = Dokter</td>
                    </tr>
                </tfoot>

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
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
                </div>

                <div class="modal-body">
                    <form class="row g-4" action="app/karyawan/input.php" method="post">

                        <div class="col-md-4">
                            <label class="form-label">NIP</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" name="nip" placeholder="NIP" autofocus required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">NIK</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" name="nik" placeholder="NIK" autofocus required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Nama Karyawan</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="nama" placeholder="Nama Karyawan" autofocus required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Jenis Kelamin</label>
                            <div class="input-group mb-3">
                                <select class="form-select" name="jenis_kelamin" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki - Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Tanggal Lahir</label>
                            <div class="input-group mb-3">
                                <input type="date" class="form-control" name="tanggal_lahir" placeholder="Tanggal Lahir" autofocus required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">No. HP</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" name="telpon" placeholder="No. HP" autofocus required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">No. Rekening</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" name="no_rek" placeholder="No. Rekening" autofocus required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Agama</label>
                            <div class="input-group mb-3">
                                <select class="form-select" name="agama" required>
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Budha">Budha</option>
                                    <option value="Hindu">Hindu</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Golongan</label>
                            <div class="input-group mb-3">
                                <select class="form-select" name="golongan_id" required>
                                    <?php
                                    $query = "SELECT * FROM golongan";
                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <option value="<?= $row['id'] ?>"><?= $row['nama_golongan'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Alamat</label>
                            <div class="input-group mb-3">
                                <textarea class="form-control" name="alamat" placeholder="Alamat" style="height: 100px;" required></textarea>
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
                noDataRow.innerHTML = '<td colspan="7" class="text-center">Data tidak tersedia</td>'; // Sesuaikan jumlah kolom
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