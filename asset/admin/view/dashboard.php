<div class="card__container">
    <h3 class="main__title">Data Bulan Ini</h3>
    <div class="card__wrapper">
        <div class="payment__card-container light-red">
            <div class="card__header">
                <div class="amount">
                    <span class="title"> Total Tindakan </span>
                    <span class="amount__value">
                        <?php
                        $bulan_ini = date('Y-m');
                        $query_tindakan = "SELECT SUM(harga) as total_tindakan 
                                         FROM detail_transaksi dt 
                                         JOIN transaksi t ON dt.notrans = t.notrans 
                                         WHERE t.tanggal LIKE '$bulan_ini%' 
                                         AND t.status = 'off'";
                        $result_tindakan = mysqli_query($conn, $query_tindakan);
                        $row_tindakan = mysqli_fetch_assoc($result_tindakan);
                        $total_tindakan = $row_tindakan['total_tindakan'] ?? 0;
                        ?>
                        Rp. <?= number_format($total_tindakan, 0, ',', '.') ?>
                    </span>
                </div>
                <span class="fas fa-dollar-sign icon dark-red"></span>
            </div>
        </div>

        <div class="payment__card-container light-yellow">
            <div class="card__header">
                <div class="amount">
                    <span class="title"> Total User </span>
                    <span class="amount__value">
                        <?php
                        $query_user = "SELECT COUNT(*) as total_user FROM user";
                        $result_user = mysqli_query($conn, $query_user);
                        $row_user = mysqli_fetch_assoc($result_user);
                        $total_user = $row_user['total_user'] ?? 0;
                        ?>
                        <?= $total_user ?>
                    </span>
                </div>
                <span class="fas fa-user icon dark-yellow"></span>
            </div>
        </div>

        <div class="payment__card-container light-green">
            <div class="card__header">
                <div class="amount">
                    <span class="title"> Jasa Medis </span>
                    <span class="amount__value">
                        <?php
                        $bulan_ini = date('Y-m');
                        $query_jasa_medis = "SELECT SUM(dt.jm) as total_jm 
                                             FROM transaksi t 
                                             JOIN detail_transaksi dt ON t.notrans = dt.notrans 
                                             WHERE t.tanggal LIKE '$bulan_ini%' 
                                             AND t.status = 'off'";
                        $result_jasa_medis = mysqli_query($conn, $query_jasa_medis);
                        $row_jasa_medis = mysqli_fetch_assoc($result_jasa_medis);
                        $total_jasa_medis = $row_jasa_medis['total_jm'] ?? 0;
                        ?>
                        Rp. <?= number_format($total_jasa_medis, 0, ',', '.') ?>
                    </span>
                </div>
                <span class="fas fa-users icon dark-green"></span>
            </div>
        </div>

        <div class="payment__card-container light-blue">
            <div class="card__header">
                <div class="amount">
                    <span class="title"> Total Income </span>
                    <span class="amount__value">
                        <?php
                        $bulan_ini = date('Y-m');
                        $query_transaksi = "SELECT * FROM transaksi WHERE tanggal LIKE '$bulan_ini%' AND status = 'off'";
                        $result_transaksi = mysqli_query($conn, $query_transaksi);
                        $total_transaksi = mysqli_num_rows($result_transaksi);
                        $total_transaksi = 0;
                        while ($transaksi_row = mysqli_fetch_assoc($result_transaksi)) {
                            $total_transaksi += $transaksi_row['total'];
                        }
                        $pemasukan = $total_transaksi - $total_jasa_medis;
                        ?>
                        Rp. <?= number_format($pemasukan, 0, ',', '.') ?>
                    </span>
                </div>
                <span class="fas fa-check icon dark-blue"></span>
            </div>
        </div>
    </div>
</div>

<div class="tabular__wrapper">
    <div class="col-md-12 d-flex justify-content-between mb-3" style="gap: 1rem; align-items: center;">
        <div class="header__title text-sm">
            <h3 style="font-weight: 600; font-size: 1.2rem; margin-bottom: 0; color: #000;">Grafik Pemasukan</h3>
        </div>

        <div class="input-group justify-content-end" style="width: 300px; display: flex; align-items: center; gap: 10px;">
            <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: lightgreen; margin-right: 5px;"></span>
            <span style="font-weight: bold; font-size: 13px;">Target Sales</span>

            <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: lightcoral; margin: 0 5px;"></span>
            <span style="font-weight: bold; font-size: 13px;">Current Sales</span>
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