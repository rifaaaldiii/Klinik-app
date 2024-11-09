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
</div>



<div class="tabular__wrapper">
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#input">
            <i class="fa fa-plus"></i> Tambah Tindakan
        </button>
    </div>

    <div class="modal fade" id="input" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Input Tindakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-4" action="app/transaksi/input_detail.php" method="post">

                        <input
                            type="hidden"
                            class="form-control"
                            value="<?php echo date('Y-m-d'); ?>"
                            name="tanggal"
                            readonly />
                        <input type="hidden" name="notrans" value="<?= $detail_row['notrans'] ?>">
                        <input type="hidden" name="jm" id="jm" readonly>
                        <input type="hidden" name="hargaJasa" id="hargaJasa" readonly>
                        <input type="hidden" name="totalharga" id="totalharga" readonly>
                        <input type="hidden" name="namatd" id="namatd" readonly>

                        <div class="col-md-8">
                            <label class="form-label">Tindakan</label>
                            <div class="input-group mb-3">
                                <input list="tindakan" name="tindakan" class="form-control" placeholder="Cari tindakan..." onchange="updateAndCalculate(this)" autofocus required>
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa fa-search"></i>
                                </span>
                                <datalist id="tindakan">
                                    <?php while ($tindakan = mysqli_fetch_assoc($result_tindakan)) { ?>
                                        <option data-jm="<?= $tindakan['jm'] ?>" nama-td="<?= $tindakan['nama_tindakan'] ?>" value="<?= $tindakan['nama_tindakan'] ?>" data-harga="<?= $tindakan['harga'] ?>"><?= $tindakan['nama_tindakan'] ?></option>
                                    <?php } ?>
                                </datalist>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Harga Tindakan</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <input type="number" name="harga" value="0" class="form-control" required readonly id="hargaTindakan">
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label class="form-label">Harga Tambahan/Range Harga</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <input type="number" name="harga_tambahan" class="form-control" min="0" id="hargaTambahan" oninput="hitungJumlah()">

                                <div class="input-group-text ms-2 me-2">
                                    X
                                </div>
                                <div class="col-md-1">
                                    <input type="number" name="kali" value="0" class="form-control" min="0" id="kali" oninput="hitungJumlah()">
                                </div>
                                <div class="input-group-text ms-2 me-2">
                                    =
                                </div>
                                <div class="col-md-5">
                                    <input type="number" name="jumlah" class="form-control" readonly id="jumlah">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label class="form-label">Modal</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <input type="number" name="modal" id="modal" value="0" min="0" class="form-control" oninput="hitungJumlah()">
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label class="form-label">Diskon</label>
                            <div class="input-group mb-6">
                                <input type="number" name="diskon" id="diskon" value="0" min="0" class="form-control" oninput="hitungJumlah()">
                                <span class="input-group-text" id="basic-addon1">%</span>
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label class="form-label">Jasa Medis</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <input type="number" name="harga_jasa" id="jasaharga" value="0" class="form-control" required readonly>
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label class="form-label">DP</label>
                            <div class="input-group mb-6">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <input type="number" name="dp" id="dp" value="0" min="0" class="form-control" oninput="hitungJumlah()">
                            </div>
                        </div>

                        <div class="col-md-8 mt-3">
                            <label class="form-label">Keterangan</label>
                            <div class="input-group mb-6">
                                <textarea
                                    name="catatan"
                                    class="form-control"
                                    placeholder="Masukan Keterangan..."
                                    style="height: 70px;"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4 ">
                            <div class="input-group col-md-12 d-flex justify-content-end">
                                <label class="col-md-2 col-form-label">Sub-Total</label>
                                <span class="input-group-text " id="basic-addon1">Rp.</span>
                                <div class="col-sm-4">
                                    <input
                                        type="text"
                                        id="subtotal"
                                        class="form-control"
                                        name="subtotal"
                                        readonly
                                        required />
                                </div>
                            </div>
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
                    <th>No Transaksi</th>
                    <th>Tindakan</th>
                    <th>Harga</th>
                    <th>Jasa Medis</th>
                    <th>Modal</th>
                    <th>Diskon</th>
                    <th>DP</th>
                    <th>Total</th>
                    <th>Tools</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $id = isset($_GET['id']) ? $_GET['id'] : '';
                $query_detail = "SELECT * FROM detail_transaksi WHERE notrans = '$id'";
                $result_detail = mysqli_query($conn, $query_detail);
                $no = 1;
                if (mysqli_num_rows($result_detail) > 0) {
                    while ($detail_row = mysqli_fetch_assoc($result_detail)) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $detail_row['notrans'] ?></td>
                            <td><?= $detail_row['tindakan'] ?></td>
                            <td>Rp. <?= empty($detail_row['harga']) ? 0 : number_format($detail_row['harga'], 0, ',', '.') ?></td>
                            <td>Rp. <?= empty($detail_row['jm']) ? 0 : number_format($detail_row['jm'], 0, ',', '.') ?></td>
                            <td>Rp. <?= empty($detail_row['modal']) ? 0 : number_format($detail_row['modal'], 0, ',', '.') ?></td>
                            <td><?= empty($detail_row['diskon']) ? 0 : $detail_row['diskon'] ?>%</td>
                            <td>Rp. <?= empty($detail_row['dp']) ? 0 : number_format($detail_row['dp'], 0, ',', '.') ?></td>
                            <td>Rp. <?= empty($detail_row['total']) ? 0 : number_format($detail_row['total'], 0, ',', '.') ?></td>
                            <td>
                                <a href="app/transaksi/delete_detail.php?notrans=<?= $detail_row['notrans'] ?>&id=<?= $detail_row['id'] ?>" class="btn btn-sm btn-danger" style="text-align: center;">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada tindakan</td>
                    </tr>
                <?php } ?>
            </tbody>

            <tfoot>
                <?php
                $grand_total = 0;
                $id = isset($_GET['id']) ? $_GET['id'] : '';
                if ($result_detail) {
                    $result = mysqli_query($conn, "SELECT SUM(total) AS total FROM detail_transaksi WHERE notrans = '$id'");
                    $row = mysqli_fetch_assoc($result);
                    $grand_total = $row['total'];
                }
                ?>

                <tr>
                    <td colspan="11">Sub-Total: Rp. <?= number_format($grand_total, 0, ',', '.') ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<div class="tabular__wrapper">
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#inputasistens">
            <i class="fa fa-plus"></i> Tambah Asistens
        </button>
    </div>

    <div class="modal fade" id="inputasistens" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Input Asistens</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-4" action="app/transaksi/input_asistens.php" method="post">
                        <?php
                        $id_transaksi = isset($_GET['id']) ? $_GET['id'] : '';
                        ?>

                        <input type="hidden" name="notrans" value="<?= $id_transaksi ?>">

                        <div class="col-md-8">
                            <label class="form-label">Asistens</label>
                            <select name="id_karyawan" id="id_karyawan" class="form-control" required>
                                <option value="">Pilih Asistens</option>
                                <?php
                                $query_karyawan = "SELECT * FROM karyawan WHERE golongan_id = '1'";
                                $result_karyawan = mysqli_query($conn, $query_karyawan);
                                while ($karyawan = mysqli_fetch_assoc($result_karyawan)) { ?>
                                    <option value="<?= $karyawan['id'] ?>"><?= $karyawan['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Tipe Regio</label>
                            <select name="tipe_regio" id="tipe_regio" class="form-control" required>
                                <option value="">Pilih Tipe Regio</option>
                                <option value="4">Non - Regio</option>
                                <option value="1">Regio 1</option>
                                <option value="2">Regio 2</option>
                                <option value="3">Regio 3</option>
                            </select>
                        </div>

                        <input type="hidden" name="jumlah_regio" id="jumlah_regio" value="1" required>
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
                    <th>Nama Asistens</th>
                    <th>Regio 1</th>
                    <th>Regio 2</th>
                    <th>Regio 3</th>
                    <th>Non Regio</th>
                    <th>Tools</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $id = isset($_GET['id']) ? $_GET['id'] : '';
                $query_asistens = "SELECT a.*, k.nama FROM asistens a LEFT JOIN karyawan k ON a.id_karyawan = k.id WHERE notrans = '$id'";
                $result_asistens = mysqli_query($conn, $query_asistens);
                $no = 1;
                if (mysqli_num_rows($result_asistens) > 0) {
                    while ($asistens_row = mysqli_fetch_assoc($result_asistens)) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $asistens_row['nama'] ?></td>
                            <td><?= $asistens_row['ro1'] ?></td>
                            <td><?= $asistens_row['ro2'] ?></td>
                            <td><?= $asistens_row['ro3'] ?></td>
                            <td><?= $asistens_row['non_regio'] ?></td>
                            <td>
                                <a href="app/transaksi/delete_asistens.php?notrans=<?= $id_transaksi ?>&id=<?= $asistens_row['id'] ?>" class="btn btn-sm btn-danger" style="text-align: center;">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada asistens</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<form action="app/transaksi/input_transaksi.php" method="post" onsubmit="return confirmSubmit()">
    <div class="card__container mt-4">
        <div class="row">
            <?php
            $id = isset($_GET['id']) ? $_GET['id'] : '';
            $query_detail = "SELECT * FROM detail_transaksi WHERE notrans = '$id'";
            $result_detail = mysqli_query($conn, $query_detail);
            $detail_row = mysqli_fetch_assoc($result_detail);
            ?>
            <input type="hidden" name="notrans" value="<?= $detail_row['notrans'] ?>">

            <?php
            $bayar = $detail_row['bayar'];
            $metode = $detail_row['metode'];
            ?>
            <div class="col-md-4">
                <label class="form-label">Cash</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Rp.</span>
                    <input type="number" name="cash" id="cash" value="<?= $metode == 'cash' ? $bayar : 0 ?>" min="0" class="form-control" required>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Transfer</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Rp.</span>
                    <input type="number" name="transfer" id="transfer" value="<?= $metode == 'transfer' ? $bayar : 0 ?>" min="0" class="form-control" required>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Catatan</label>
                <input type="text" name="catatan" class="form-control">
            </div>

            <div class="row g-3 align-items-center justify-content-end">
                <div class="col-auto">
                    <label class="form-label mb-0" style="font-weight: bold;">Total Harga</label>
                </div>
                <div class="col-auto hitung">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1" style="font-weight: bold;">Rp.</span>
                        <input class="form-control" type="text" name="total" value="<?= $grand_total ?>" readonly style="background-color: transparent;">
                    </div>
                </div>
            </div>

            <style>
                .hitung {
                    font-size: 16px;
                }

                .hitung input {
                    width: 100px;
                    font-weight: bold;
                }
            </style>

        </div>
        <div class="col-md-12 mt-3 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary ms-3">Simpan</button>
        </div>
    </div>
</form>

<script>
    function updateAndCalculate(input) {
        // Simpan nilai sebelum reset
        const selectedOption = document.querySelector(`datalist#tindakan option[value="${input.value}"]`);
        let harga, datajm, namatd;

        if (selectedOption) {
            harga = selectedOption.getAttribute('data-harga');
            datajm = selectedOption.getAttribute('data-jm');
            namatd = selectedOption.getAttribute('nama-td');
        }

        // Reset semua input menjadi 0 jika tidak ada opsi yang dipilih
        document.getElementById('jm').value = 0;
        document.getElementById('hargaJasa').value = 0;
        document.getElementById('hargaTindakan').value = 0;
        document.getElementById('subtotal').value = 0;
        document.getElementById('totalharga').value = 0;
        document.getElementById('namatd').value = '';
        document.getElementById('hargaTambahan').value = 0; // Reset harga tambahan
        document.getElementById('kali').value = 0; // Reset kali
        document.getElementById('jumlah').value = 0; // Reset jumlah
        document.getElementById('modal').value = 0; // Reset modal
        document.getElementById('diskon').value = 0; // Reset diskon
        document.getElementById('dp').value = 0; // Reset dp

        if (selectedOption) {
            // Tambahkan pengecekan untuk harga
            if (harga == 0) {
                alert("Masukkan harga tambahan/range harga");
                document.getElementById('hargaTambahan').focus(); // Autofocus pada harga tambahan
                // Kembalikan nilai yang disimpan
                document.getElementById('jm').value = datajm;
                document.getElementById('namatd').value = namatd;
                return; // Hentikan eksekusi lebih lanjut
            }

            document.getElementById('subtotal').value = harga;
            document.getElementById('hargaTindakan').value = harga;
            document.getElementById('jm').value = datajm;
            document.getElementById('hargaJasa').value = harga;
            document.getElementById('totalharga').value = harga;
            document.getElementById('namatd').value = namatd;
            // Hitung jumlah
            hitungJumlah();
        } else {
            // Opsi tidak valid, tidak perlu melakukan reset di sini
            console.log("Opsi tidak valid, mereset input.");
        }
    }

    function hitungJumlah() {
        const hargaTambahan = document.getElementById('hargaTambahan').value;
        const kali = document.getElementById('kali').value;
        const jumlah = hargaTambahan * kali;

        document.getElementById('jumlah').value = jumlah;
        document.getElementById('kali').value = 1;

        // Hitung totalharga
        const hargaJasa = document.getElementById('hargaJasa').value;
        const totalharga = parseFloat(hargaJasa) + parseFloat(jumlah);
        const modal = document.getElementById('modal').value;
        const jasaharga = document.getElementById('jasaharga');
        const jasamedis = document.getElementById('jm').value;
        const diskon = document.getElementById('diskon').value;
        const dp = document.getElementById('dp').value;

        document.getElementById('totalharga').value = totalharga;
        const totalDp = totalharga - dp;
        document.getElementById('subtotal').value = totalharga - modal - (diskon / 100 * totalharga);

        if (jasamedis == 0) {
            jasaharga.value = totalDp * 0.5;
        } else if (jasamedis == 1) {
            jasaharga.value = 0;
        } else if (jasamedis == 2) {
            jasaharga.value = 20000 * (1 + parseInt(kali));
        } else if (jasamedis == 3) {
            jasaharga.value = totalDp * 0.65;
        } else if (jasamedis == 4) {
            jasaharga.value = (totalDp - modal) * 0.5;
        }
    }
</script>