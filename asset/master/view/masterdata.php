<div class="card__container">
    <div class="card__wrapper" style="flex-wrap: wrap;">
        <a href="masterdata.php?page=tindakan" style="text-decoration: none; color: black;">
            <div class="payment__card-container light-red">
                <div class="card__header">
                    <div class="amount">
                        <span class="title"> Data Tindakan </span>
                        <span class="amount__value">
                            <?php
                            $query_tindakan = "SELECT * FROM tindakan";
                            $result_tindakan = mysqli_query($conn, $query_tindakan);
                            $total_tindakan = mysqli_num_rows($result_tindakan);
                            ?>
                            <span class="amount__value"><?= $total_tindakan ?> Tindakan </span>
                        </span>
                    </div>
                    <span class="fas fa-book icon dark-red"></span>
                </div>
            </div>
        </a>

        <a href="masterdata.php?page=karyawan" style="text-decoration: none; color: black;">
            <div class="payment__card-container light-yellow">
                <div class="card__header">
                    <div class="amount">
                        <span class="title"> Data Karyawan </span>
                        <span class="amount__value">
                            <?php
                            $query_dokter = "SELECT * FROM karyawan";
                            $result_dokter = mysqli_query($conn, $query_dokter);
                            $total_dokter = mysqli_num_rows($result_dokter);
                            ?>
                            <span class="amount__value"><?= $total_dokter ?> Karyawan </span>
                        </span>
                    </div>
                    <span class="fas fa-users icon dark-yellow"></span>
                </div>
            </div>
        </a>

        <a href="masterdata.php?page=JasaMedis" style="text-decoration: none; color: black;">
            <div class="payment__card-container light-green">
                <div class="card__header">
                    <div class="amount">
                        <span class="title"> Jasa Medis </span>
                        <span class="amount__value">
                            <?php
                            $query_transaksi = "SELECT t.notrans, dt.jm 
                                                FROM transaksi t
                                                JOIN detail_transaksi dt ON t.notrans = dt.notrans";
                            $result_transaksi = mysqli_query($conn, $query_transaksi);
                            $total_transaksi = 0;
                            while ($transaksi_row = mysqli_fetch_assoc($result_transaksi)) {
                                $total_transaksi += $transaksi_row['jm'];
                            }
                            ?>
                            <span class="amount__value">Rp.<?= number_format($total_transaksi, 0, ',', '.') ?></span>
                        </span>
                    </div>
                    <span class="fas fa-dollar-sign icon dark-green"></span>
                </div>
            </div>
        </a>

        <a href="masterdata.php?page=laporan" style="text-decoration: none; color: black;">
            <div class="payment__card-container light-blue">
                <div class="card__header">
                    <div class="amount">
                        <span class="title"> Download </span>
                        <span class="amount__value"> Laporan </span>
                    </div>
                    <span class="fas fa-file-pdf icon dark-blue"></span>
                </div>
            </div>
        </a>

        <a href="masterdata.php?page=golongan" style="text-decoration: none; color: black;">
            <div class="payment__card-container light-blue">
                <div class="card__header">
                    <div class="amount">
                        <span class="title"> Golongan </span>
                        <?php
                        $query_golongan = "SELECT * FROM golongan";
                        $result_golongan = mysqli_query($conn, $query_golongan);
                        $total_golongan = mysqli_num_rows($result_golongan);
                        ?>
                        <span class="amount__value"><?= $total_golongan ?> Golongan </span>
                    </div>
                    <span class="fas fa-list icon dark-blue"></span>
                </div>
            </div>
        </a>

        <a href="masterdata.php?page=user" style="text-decoration: none; color: black;">
            <div class="payment__card-container light-red">
                <div class="card__header">
                    <div class="amount">
                        <span class="title"> User </span>
                        <?php
                        $query_user = "SELECT * FROM user";
                        $result_user = mysqli_query($conn, $query_user);
                        $total_user = mysqli_num_rows($result_user);
                        ?>
                        <span class="amount__value"><?= $total_user ?> User </span>
                    </div>
                    <span class="fas fa-user icon dark-red"></span>
                </div>
            </div>
        </a>
    </div>

</div>

<style>
    .card__wrapper {
        flex-wrap: nowrap;
        display: flex;
        gap: 1rem;
        justify-content: space-between;
        overflow-x: auto;
    }

    .card__header {
        width: 100%;
        margin-bottom: 0;
    }

    .payment__card-container {
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 250px;
        border-radius: 10px;
        padding: 10px 25px;

    }

    .amount__value {
        font-size: 1.2rem;
        letter-spacing: 0;
    }
</style>