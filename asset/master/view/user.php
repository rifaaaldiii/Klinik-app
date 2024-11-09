<div class="tabular__wrapper">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']) ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success']) ?>
    <?php endif; ?>

    <div class="col-md-12 d-flex justify-content-end mb-4" style="gap: 1rem; align-items: center;">
        <div class="header__title text-sm" style="flex:1;">
            <h3 style="font-weight: 600; font-size: 1.2rem; margin-bottom: 0;">Tabel User</h3>
        </div>

        <div class="input-group" style="width: 300px;">
            <input style="border-radius: 12px 0 0 12px; border-right: none;" type="text" name="search" class="form-control" placeholder="Cari user ..." id="searchInput">
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
                        <th>Username</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tbody id="tindakanTableBody">
                    <?php
                    $query_user = "SELECT * FROM user";
                    $result_user = mysqli_query($conn, $query_user);
                    $no = 1;
                    if (mysqli_num_rows($result_user) > 0) { // Cek apakah ada data
                        while ($user_row = mysqli_fetch_assoc($result_user)) { ?>
                            <tr>
                                <td><?= $no++ ?>.</td>
                                <td><?= $user_row['username'] ?></td>
                                <td><?= $user_row['email'] ?></td>
                                <td>
                                    <?php
                                    // Tampilkan indikator bahwa password ter-hash (lebih aman)
                                    echo "[Encrypted]";
                                    // Atau tampilkan hash-nya (tidak direkomendasikan)
                                    // echo $user_row['password'];
                                    ?>
                                </td>
                                <td><?= $user_row['role'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $user_row['id'] ?>" style="box-shadow: none; font-size: 10px; padding: 5px 7px;">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <a href="app/user/delete.php?id=<?= $user_row['id'] ?>" class="btn btn-danger" style="box-shadow: none; font-size: 10px; padding: 5px 8px;" onclick="return confirmDelete('<?= $user_row['username'] ?>')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>

                                <!-- MODAL EDIT -->
                                <div class="modal fade" id="edit<?= $user_row['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Edit User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
                                            </div>

                                            <form class="row g-4 mt-2" action="app/user/update.php" method="post" onsubmit="return confirm('Apakah Anda yakin ingin mengubah data user?');">
                                                <div class="modal-body">

                                                    <input type="hidden" name="id" id="id" value="<?= $user_row['id'] ?>">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <label class="form-label">Username</label>
                                                            <div class="input-group mb-3">
                                                                <input type="text" class="form-control" name="user" id="username" value="<?= $user_row['username'] ?>" required>
                                                                </input>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Email</label>
                                                            <div class="input-group mb-3">
                                                                <input type="email" class="form-control" name="email" id="email" value="<?= $user_row['email'] ?>" required>
                                                                </input>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label class="form-label">Password</label>
                                                            <div class="input-group mb-3">
                                                                <input type="password" class="form-control" name="pass" id="password" value="<?= $user_row['password'] ?>" required>
                                                                </input>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Verifikasi Password</label>
                                                            <div class="input-group mb-3">
                                                                <input type="password" class="form-control" name="pass2" id="password_confirm" value="<?= $user_row['password'] ?>" required>
                                                                </input>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Role</label>
                                                            <div class="input-group mb-3">
                                                                <select class="form-select" name="role" id="role" required>
                                                                    <option value="">Pilih Role</option>
                                                                    <option value="owner" <?= ($user_row['role'] == 'owner') ? 'selected' : '' ?>>Owner</option>
                                                                    <option value="admin" <?= ($user_row['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
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
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
                </div>

                <div class="modal-body">
                    <form class="row g-4" action="app/user/input.php" method="post">

                        <div class="col-md-6">
                            <label class="form-label">Username</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="user" placeholder="Username" autofocus required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" name="email" placeholder="Email" autofocus required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Password</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" name="pass" placeholder="Password" autofocus required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Verifikasi Password</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" name="pass2" placeholder="Verifikasi Password" autofocus required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Role</label>
                            <div class="input-group mb-3">
                                <select class="form-select" name="role" id="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="owner">Owner</option>
                                    <option value="admin">Admin</option>
                                </select>
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