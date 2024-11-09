<?php
require("tcpdf/tcpdf.php");
include "../../../env/env.php";

if (isset($_GET['tanggal'])) {
    $bulan = $_GET['tanggal'];

    // Ambil data transaksi
    $query = mysqli_query($conn, "SELECT 
        p.*,
        k.nama,
        g.gaji_pokok
        FROM penggajian p
        JOIN karyawan k ON p.karyawan_id = k.id
        JOIN golongan g ON k.golongan_id = g.id
        WHERE DATE_FORMAT(p.tanggal, '%Y-%m') = '$bulan'");


    // Buat objek PDF
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    $pdf->AddPage();

    // Header
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 15, 'PT. Klinik Sejahtera', 0, 1, 'C');
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 5, 'Mari Jaga Kesehatan Gigi Anda', 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 5, 'JL. Tidak diketahui,Km.100 LA - LS, Input Kode Pos 42263, Telpon: 08123445556,', 0, 1, 'C');
    $pdf->Cell(0, 5, 'E-Mail: kliniksejahtera@gmail.com', 0, 1, 'C');
    $pdf->Line(10, 45, 200, 45);
    $pdf->Line(10, 46, 200, 46);

    // Judul Laporan
    $pdf->Ln(15);
    $pdf->SetFont('helvetica', 'B', 13);
    $pdf->Cell(0, 5, 'Rekapitulasi Penggajian', 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 5, 'Periode : ' . date('F Y', strtotime($bulan)), 0, 1, 'C');
    $pdf->Ln(5);

    // Tabel
    $pdf->SetFont('helvetica', 'B', 10);
    $header = array('No.', 'Tanggal', 'Nama Karyawan', 'Gaji Pokok', 'Jasa Asistensi', 'Total');
    $w = array(10, 32, 37, 37, 37, 37);

    // Header Tabel
    for ($i = 0; $i < count($header); $i++) {
        $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
    }
    $pdf->Ln();

    // Isi Tabel
    $pdf->SetFont('helvetica', '', 10);
    $no = 1;

    while ($row = mysqli_fetch_assoc($query)) {
        $pdf->Cell($w[0], 7, $no++, 1, 0, 'C');
        $pdf->Cell($w[1], 7, $row['tanggal'], 1, 0, 'C');
        $pdf->Cell($w[2], 7, $row['nama'], 1, 0, 'C');
        $pdf->Cell($w[3], 7, 'Rp. ' . number_format($row['gaji_pokok']), 1, 0, 'L');
        $pdf->Cell($w[4], 7, 'Rp. ' . number_format($row['asistensi']), 1, 0, 'L');
        $pdf->Cell($w[5], 7, 'Rp. ' . number_format($row['total']), 1, 0, 'L');
        $pdf->Ln(7);
    }

    // Sebelum output PDF, hitung total
    $query_total = mysqli_query($conn, "SELECT 
        SUM(p.total) as total
        FROM penggajian p
        WHERE DATE_FORMAT(p.tanggal, '%Y-%m') = '$bulan'");
    $total_data = mysqli_fetch_assoc($query_total);

    // Hitung total
    $total = $total_data['total'];

    $pdf->SetFont('helvetica', 'B', 10);
    // Tampilkan total
    $pdf->Cell(array_sum($w) - 37, 7, 'GRAND TOTAL', 1, 0, 'C');
    $pdf->Cell(37, 7, 'Rp. ' . number_format($total), 1, 1, 'L');
    $pdf->Ln(18);


    // TTD
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 5, 'Serang, ....................... ' . date('Y'), 0, 1, 'R');
    $pdf->Ln(18);
    $pdf->Cell(0, 5, 'Kepala Klinik                         ', 0, 1, 'R');
    // Output PDF
    $pdf->Output('Rekapitulasi_Penggajian_' . $bulan . '.pdf', 'I');
}

function hariIndo($tanggal)
{
    $namaHari = date('l', strtotime($tanggal));
    switch ($namaHari) {
        case 'Sunday':
            return 'Minggu';
        case 'Monday':
            return 'Senin';
        case 'Tuesday':
            return 'Selasa';
        case 'Wednesday':
            return 'Rabu';
        case 'Thursday':
            return 'Kamis';
        case 'Friday':
            return 'Jumat';
        case 'Saturday':
            return 'Sabtu';
        default:
            return 'Tidak diketahui';
    }
}
