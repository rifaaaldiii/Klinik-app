<div class="tabular__wrapper">
    <div class="col-md-12 d-flex justify-content-between mb-3" style="gap: 1rem; align-items: center;">
        <div class="header__title text-sm">
            <h3 style="font-weight: 600; font-size: 1.2rem; margin-bottom: 0; color: #000;">Grafik Penggajian</h3>
        </div>

        <div class="input-group justify-content-end" style="width: 300px; display: flex; align-items: center; gap: 10px;">
            <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: lightgreen; margin-right: 5px;"></span>
            <span style="font-weight: bold; font-size: 13px;">Tindakan</span>

            <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: lightcoral; margin: 0 5px;"></span>
            <span style="font-weight: bold; font-size: 13px;">Jasa Medis</span>
        </div>
    </div>

    <div class="target-vs-sales--container justify-content-center">
        <div class="target--vs--sales">
            <canvas id="tarsale"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn. jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script>
    const tarsaleChart = document.getElementById('tarsale').getContext('2d');
    const tarsale = new Chart(tarsaleChart, {
        type: 'line',
        data: {
            labels: ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'],
            datasets: [{
                data: [320, 210, 400, 220, 290, 360, 170, 280, 250, 380, 190, 250],
                borderColor: [
                    'rgb(59,197,154)'
                ],
                borderWidth: 2
            }, {
                data: [180, 250, 290, 310, 280, 330, 260, 270, 350, 160, 280, 300],
                borderColor: [
                    '#ff6666'
                ],
                borderWidth: 2
            }]

        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    })
</script>
<style>
    .target-vs-sales--container {
        margin-bottom: 20px;
        border-radius: 10px;
        padding: 15px;
        width: 99%;
        border: 1px solid #ccc;
        margin: 0 auto;
    }

    .sales--value {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .target,
    .current {
        display: flex;
        align-items: center;
        font-size: 1rem;
    }

    .target .circle {
        margin-right: 5px;
        color: #3bc59a;
    }

    .current .circle {
        margin-right: 5px;
        color: #ff6666;
    }

    .target--vs--sales {
        width: auto;
    }

    .target--vs--sales canvas {
        max-height: 400px;
    }
</style>

<!-- TABEL -->
<div class="tabular__wrapper">
    <div class="col-md-12 d-flex justify-content-end mb-4" style="gap: 1rem; align-items: center;">
        <div class="row" style="flex: 1;">
            <h3 class="main__title" style="font-weight: bold;">Tabel Penggajian</h3>
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

    <div class="table__container" id="penggajianTableContainer">
        <div class="table__box" style="max-height: 510px; overflow-y: auto;">
            <table>
                <thead style="position: sticky; top: 0; z-index: 1;">
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Golongan</th>
                        <th>Gaji Pokok</th>
                        <th>Jasa Asistensi</th>
                        <th>Total Gaji</th>
                        <th>Status</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tbody id="transaksiTableBody">
                    <?php
                    $query_penggajian = "SELECT p.*, k.nama, k.golongan_id, k.no_rek, k.nik, g.nama_golongan, g.gaji_pokok
                    FROM penggajian p 
                    JOIN karyawan k ON p.karyawan_id = k.id
                    JOIN golongan g ON k.golongan_id = g.id
                    WHERE MONTH(p.tanggal) = MONTH(CURRENT_DATE())
                    AND YEAR(p.tanggal) = YEAR(CURRENT_DATE())";
                    $result_penggajian = mysqli_query($conn, $query_penggajian);
                    $no = 1;
                    if (mysqli_num_rows($result_penggajian) > 0) { // Cek apakah ada data
                        while ($penggajian_row = mysqli_fetch_assoc($result_penggajian)) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $penggajian_row['nama'] ?></td>
                                <td><?= $penggajian_row['nama_golongan'] ?></td>
                                <td>Rp. <?= !empty($penggajian_row['gaji_pokok']) ? number_format((float)$penggajian_row['gaji_pokok'], 0, ',', '.') : 0 ?></td>
                                <td>Rp. <?= !empty($penggajian_row['asistensi']) ? number_format((float)$penggajian_row['asistensi'], 0, ',', '.') : 0 ?></td>
                                <td>Rp. <?= !empty($penggajian_row['total']) ? number_format((float)$penggajian_row['total'], 0, ',', '.') : 0 ?></td>
                                <td>
                                    <span class="<?= $penggajian_row['status'] == 'Pending' ? 'text-danger' : 'text-success' ?>">
                                        <?= $penggajian_row['status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#transfer<?= $penggajian_row['karyawan_id'] ?>">
                                        <i class="fa fa-exchange"></i> Transfer
                                    </button>
                                    <?php if ($penggajian_row['status'] == '' || $penggajian_row['status'] == 'Pending'): ?>
                                        <a class="btn btn-warning" href="index.php?page=detail_penggajian&id=<?= $penggajian_row['karyawan_id'] ?>&penggajian_id=<?= $penggajian_row['id'] ?>">
                                            <i class="fa fa-pencil"></i> Edit
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <!-- Modal Transfer -->
                            <div class="modal fade" id="transfer<?= $penggajian_row['karyawan_id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                                <div class="modal-dialog ">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Transfer Gaji</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="app/penggajian/transfer.php" method="post">
                                                <input type="hidden" name="id" class="form-control" value="<?= $penggajian_row['id'] ?>" readonly>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Nama Karyawan</label>
                                                        <input type="text" class="form-control" value="<?= $penggajian_row['nama'] ?>" readonly>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Total Gaji</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                                                            <input type="number" value="<?= $penggajian_row['total'] ?>" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="form-label">No. Rekening</label>
                                                        <input type="text" class="form-control" value="<?= $penggajian_row['no_rek'] ?>" readonly>
                                                    </div>
                                                </div>



                                                <div class="modal-footer">
                                                    <div class="col-md-12 d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah anda yakin sudah melakukan transfer?')">
                                                            Selesai
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data</td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="input" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Input Penggajian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-4" action="app/penggajian/input.php" method="post">

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

                        <div class="col-md-12">
                            <label class="form-label">Karyawan</label>
                            <div class="input-group mb-3">
                                <select name="karyawan" class="form-control" required onchange="updateKaryawanId()">
                                    <option value="" disabled selected>Pilih karyawan...</option>
                                    <?php
                                    $query_karyawan = "SELECT k.*, g.nama_golongan
                                                       FROM karyawan k 
                                                       JOIN golongan g ON k.golongan_id = g.id
                                                       WHERE NOT EXISTS (
                                                           SELECT 1 
                                                           FROM penggajian p 
                                                           WHERE p.karyawan_id = k.id 
                                                           AND MONTH(p.tanggal) = MONTH(CURRENT_DATE())
                                                           AND YEAR(p.tanggal) = YEAR(CURRENT_DATE())
                                                       )
                                                       AND g.nama_golongan != 'Dokter'";
                                    $result_karyawan = mysqli_query($conn, $query_karyawan);
                                    while ($karyawan = mysqli_fetch_assoc($result_karyawan)) { ?>
                                        <option value="<?= $karyawan['id'] ?>" data-id="<?= $karyawan['id'] ?>"><?= $karyawan['nama'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="karyawan_id" id="karyawan_id" value="" readonly>

                        <div class="modal-footer">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary ms-3">Simpan</button>
                            </div>
                        </div>

                        <script>
                            function updateKaryawanId() {
                                const select = document.querySelector('select[name="karyawan"]');
                                document.getElementById('karyawan_id').value = select.value; // Mengupdate ID karyawan
                            }
                        </script>
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