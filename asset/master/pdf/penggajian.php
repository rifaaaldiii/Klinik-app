<?php
require("tcpdf/tcpdf.php");
include "../../../env/env.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data penggajian, joint detail_gaji
    $query = mysqli_query($conn, "SELECT 
        p.*,
        k.nip,
        g.nama_golongan,
        g.gaji_pokok,
        dt.overtime,
        dt.jumlah_pasien,
        dt.makan,
        dt.ro1,
        dt.ro2,
        dt.ro3,
        k.nama as nama_karyawan
        FROM penggajian p
        JOIN karyawan k ON p.karyawan_id = k.id
        JOIN golongan g ON k.golongan_id = g.id
        LEFT JOIN detail_gaji dt ON p.id = dt.penggajian_id
        WHERE p.id = '$id'");
    $data = mysqli_fetch_assoc($query);



    // Buat objek PDF
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    $pdf->AddPage();

    // Atur opacity terlebih dahulu sebelum menambahkan gambar
    $pdf->setAlpha(0.3); // Membuat lebih transparan (nilai 0.1 lebih transparan dari 0.2)
    $pdf->Image('../../../asset/img/logo.jpg', 70, 50, 70, 70, 'JPG', '', 'C', false, 300, '', false, false, 0, false, false, false);
    $pdf->setAlpha(1); // Kembalikan opacity ke normal untuk teks

    // Header   
    $pdf->setAlpha(1); // Mengembalikan opacity ke normal untuk teks
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, 'KLINIK GIGI LUV YOUR TEETH', 0, 1, 'C');
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 5, 'Making People Smile Is Our Business', 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 5, 'Jl. Sayabulu No.2, Kel.Serang, Kec. Serang, Serang-Banten 42116 Indonesia,', 0, 1, 'C');
    $pdf->Cell(0, 5, 'Telp: 081310680640, E-mail: doktergigilyt@gmail.com', 0, 1, 'C');
    $pdf->Line(10, 45, 200, 45);
    $pdf->Line(10, 46, 200, 46);

    // Judul Laporan
    $pdf->Ln(15);
    $pdf->SetFont('helvetica', 'B', 13);
    $pdf->Cell(0, 5, 'Laporan Penggajian', 0, 1, 'C');
    $pdf->Ln(10);

    // Informasi Transaksi
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(40, 5, 'NIP', 0, 0);
    $pdf->Cell(5, 5, ':', 0, 0);
    $pdf->Cell(0, 5, $data['nip'], 0, 1);

    $pdf->Cell(40, 5, 'Nama', 0, 0);
    $pdf->Cell(5, 5, ':', 0, 0);
    $pdf->Cell(0, 5, $data['nama_karyawan'], 0, 1);

    $pdf->Cell(40, 5, 'Jabatan', 0, 0);
    $pdf->Cell(5, 5, ':', 0, 0);
    $pdf->Cell(0, 5, $data['nama_golongan'], 0, 1);

    $pdf->Cell(40, 5, 'Periode', 0, 0);
    $pdf->Cell(5, 5, ':', 0, 0);
    $pdf->Cell(0, 5, date('F Y', strtotime($data['tanggal'])), 0, 1);
    $pdf->Ln(10);

    // Tabel
    $pdf->SetFont('helvetica', 'B', 10);
    $header = array('Gaji Pokok', 'Overtime', 'Jumlah Pasien', 'Tunjangan Makan',  'Ro 1', 'Ro 2', 'Ro 3');
    $w = array(28, 27, 31, 31, 24, 24, 24);

    // Header Tabel
    for ($i = 0; $i < count($header); $i++) {
        $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
    }
    $pdf->Ln();

    // Isi Tabel
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell($w[0], 7, 'Rp. ' . number_format($data['gaji_pokok']), 1, 0, 'L');
    $pdf->Cell($w[1], 7, 'Rp. ' . number_format($data['overtime']), 1, 0, 'L');
    $pdf->Cell($w[2], 7, 'Rp. ' . number_format($data['jumlah_pasien']), 1, 0, 'L');
    $pdf->Cell($w[3], 7, 'Rp. ' . number_format($data['makan']), 1, 0, 'L');
    $pdf->Cell($w[4], 7, 'Rp. ' . number_format($data['ro1']), 1, 0, 'L');
    $pdf->Cell($w[5], 7, 'Rp. ' . number_format($data['ro2']), 1, 0, 'L');
    $pdf->Cell($w[6], 7, 'Rp. ' . number_format($data['ro3']), 1, 1, 'L');

    // Grand Total di baris baru
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(array_sum($w) - 48, 7, 'GRAND TOTAL', 1, 0, 'C');
    $pdf->Cell(48, 7, 'Rp. ' . number_format($data['total']), 1, 1, 'R');


    // TTD
    $pdf->Ln(18);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 5, 'Serang, ' . date('d F Y'), 0, 1, 'R');
    $pdf->Ln(18);
    $pdf->Cell(0, 5, 'Kepala Klinik                        ', 0, 1, 'R');

    // Output PDF
    $pdf->Output('Slip_Gaji_' . $data['nip'] . '.pdf', 'I');
}
