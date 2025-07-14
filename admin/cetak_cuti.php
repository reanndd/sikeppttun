<?php
session_start();
include '../koneksi.php';
require_once __DIR__ . '/../fpdf/fpdf.php';

// Validasi akses dan ID Cuti
if (!isset($_SESSION['username']) || !in_array($_SESSION['role'], ['admin', 'ketua', 'pegawai'])) {
    die("Akses ditolak.");
}
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID Pengajuan Cuti tidak valid.");
}
$id_cuti = $_GET['id'];

// Ambil data utama cuti
$query_data_cuti = "SELECT * FROM pengajuan_cuti WHERE id = $id_cuti";
$result_data_cuti = mysqli_query($koneksi, $query_data_cuti);
$data = mysqli_fetch_assoc($result_data_cuti);
if (!$data) {
    die("Data pengajuan cuti tidak ditemukan.");
}

// Validasi Keamanan Final
$is_allowed = false;
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'ketua') {
        $is_allowed = true;
    }
    if ($_SESSION['role'] == 'pegawai' && $_SESSION['id_pegawai'] == $data['id_pegawai']) {
        $is_allowed = true;
    }
}
if (!$is_allowed) {
    die("Akses ditolak.");
}

// Ambil detail pemohon, atasan, dan ketua
$pemohon = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT p.*, j.nama_jabatan, g.nama_golongan FROM pegawai p LEFT JOIN jabatan j ON p.id_jabatan=j.id LEFT JOIN golongan g ON p.id_golongan=g.id WHERE p.id=" . $data['id_pegawai']));
$atasan_langsung = $data['disetujui_oleh_atasan_id'] ? mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT p.nama_lengkap, p.nip, p.ttd_image, j.nama_jabatan FROM pegawai p LEFT JOIN jabatan j ON p.id_jabatan=j.id WHERE p.id=" . $data['disetujui_oleh_atasan_id'])) : null;
$ketua = $data['disetujui_oleh_ketua_id'] ? mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT p.nama_lengkap, p.nip, p.ttd_image, j.nama_jabatan FROM pegawai p LEFT JOIN jabatan j ON p.id_jabatan=j.id WHERE p.id=" . $data['disetujui_oleh_ketua_id'])) : null;


// =================================================================================
// MEMBUAT PDF
// =================================================================================

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetMargins(10, 10, 10);
$pdf->SetFont('Arial', '', 10);

// --- HEADER ---
$pdf->Cell(190, 5, 'Palembang, ' . date('d F Y', strtotime($data['tanggal_pengajuan'])), 0, 1, 'R');
$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(190, 5, 'Yth. Ketua Pengadilan Tinggi Tata Usaha Negara Palembang', 0, 1, 'R');
$pdf->Cell(190, 5, 'Di Palembang', 0, 1, 'R');
$pdf->Ln(5);

// --- JUDUL ---
$pdf->SetFont('Arial', 'BU', 12);
$pdf->Cell(0, 5, 'FORMULIR PERMINTAAN DAN PEMBERIAN CUTI', 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, 'Nomor: .................................', 0, 1, 'C');
$pdf->Ln(3);

// --- BAGIAN I: DATA PEGAWAI ---
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(190, 6, 'I. DATA PEGAWAI', 1, 1, 'L');
$pdf->SetFont('Arial', '', 9);
// PERBAIKAN: Gunakan variabel $pemohon
$pdf->Cell(35, 6, 'NAMA', 'L', 0);
$pdf->Cell(95, 6, ': ' . $pemohon['nama_lengkap'], 0, 0);
$pdf->Cell(20, 6, 'NIP', 'L', 0);
$pdf->Cell(40, 6, ': ' . $pemohon['nip'], 'R', 1);
$pdf->Cell(35, 6, 'JABATAN', 'L', 0);
$pdf->Cell(95, 6, ': ' . $pemohon['nama_jabatan'], 0, 0);
$pdf->Cell(20, 6, 'GOL/RUANG', 'L', 0);
$pdf->Cell(40, 6, ': ' . $pemohon['nama_golongan'], 'R', 1);
$pdf->Cell(35, 6, 'UNIT KERJA', 'LB', 0);
$pdf->Cell(95, 6, ': ' . ($pemohon['unit_kerja'] ?: 'Pengadilan Tinggi Tata Usaha Negara Palembang'), 'B', 0);
$pdf->Cell(20, 6, 'MASA KERJA', 'LB', 0);
$pdf->Cell(40, 6, ': ', 'RB', 1);
$pdf->Ln(5);

// --- BAGIAN II: JENIS CUTI ---
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(190, 6, 'II. JENIS CUTI YANG DIAMBIL**', 1, 1, 'L');
$pdf->SetFont('Arial', '', 9);
$jenis_cuti = $data['jenis_cuti'];
$cuti_list = ["Cuti Tahunan", "Cuti Besar", "Cuti Sakit", "Cuti Melahirkan", "Cuti Karena Alasan Penting", "Cuti di Luar Tanggungan Negara"];
$pdf->Cell(95, 6, '1. ' . $cuti_list[0] . ($jenis_cuti == $cuti_list[0] ? ' [v]' : ' [  ]'), 'LR', 0);
$pdf->Cell(95, 6, '2. ' . $cuti_list[1] . ($jenis_cuti == $cuti_list[1] ? ' [v]' : ' [  ]'), 'R', 1);
$pdf->Cell(95, 6, '3. ' . $cuti_list[2] . ($jenis_cuti == $cuti_list[2] ? ' [v]' : ' [  ]'), 'LR', 0);
$pdf->Cell(95, 6, '4. ' . $cuti_list[3] . ($jenis_cuti == $cuti_list[3] ? ' [v]' : ' [  ]'), 'R', 1);
$pdf->Cell(95, 6, '5. ' . $cuti_list[4] . ($jenis_cuti == $cuti_list[4] ? ' [v]' : ' [  ]'), 'LRB', 0);
$pdf->Cell(95, 6, '6. ' . $cuti_list[5] . ($jenis_cuti == $cuti_list[5] ? ' [v]' : ' [  ]'), 'RB', 1);
$pdf->Ln(5);

// --- BAGIAN III, IV, V ---
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(190, 6, 'III. ALASAN CUTI', 1, 1, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(190, 5, $data['keterangan'], 'LRB', 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(190, 6, 'IV. LAMANYA CUTI', 1, 1, 'L');
$pdf->SetFont('Arial', '', 9);
$tgl_mulai = date('d-m-Y', strtotime($data['tanggal_mulai']));
$tgl_selesai = date('d-m-Y', strtotime($data['tanggal_selesai']));
$start = new DateTime($data['tanggal_mulai']);
$end = new DateTime($data['tanggal_selesai']);
$diff = $end->diff($start)->format("%a") + 1;
$pdf->Cell(20, 6, 'Selama', 'L', 0);
$pdf->Cell(45, 6, ': ' . $diff . ' Hari', 0, 0);
$pdf->Cell(30, 6, 'Mulai Tanggal', 0, 0);
$pdf->Cell(35, 6, ': ' . $tgl_mulai, 0, 0);
$pdf->Cell(10, 6, 's/d', 0, 0, 'C');
$pdf->Cell(50, 6, $tgl_selesai, 'R', 1);
$pdf->Cell(190, 0, '', 'T', 1);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(190, 6, 'V. CATATAN CUTI***', 1, 1, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(190, 15, '', 'LRB', 1);
$pdf->Ln(5);

// --- BAGIAN VI ---
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(190, 6, 'VI. ALAMAT SELAMA MENJALANKAN CUTI', 1, 1, 'L');
$pdf->SetFont('Arial', '', 9);
$y_pos = $pdf->GetY();
$pdf->Cell(120, 25, '', 'LRB', 0);
$pdf->Cell(70, 25, '', 'RB', 1);
$pdf->SetXY(11, $y_pos + 1);
$pdf->MultiCell(118, 4.5, $data['alamat_cuti'], 0, 'L');
$pdf->SetXY(130, $y_pos + 1);
$pdf->Cell(70, 5, 'Telp/Hp : ' . $data['no_telp_cuti'], 0, 1, 'L');
$pdf->SetXY(130, $y_pos + 7);
$pdf->Cell(70, 5, 'Hormat Saya,', 0, 1, 'C');
// PERBAIKAN: Gunakan variabel $pemohon
$ttd_pemohon_path = '../uploads/ttd/' . ($pemohon['ttd_image'] ?? '');
if (!empty($pemohon['ttd_image']) && file_exists($ttd_pemohon_path)) {
    $pdf->Image($ttd_pemohon_path, 145, $y_pos + 11, 40, 15);
}
$pdf->SetXY(130, $y_pos + 20);
$pdf->SetFont('Arial', 'U', 9);
$pdf->Cell(70, 5, $pemohon['nama_lengkap'], 0, 1, 'C');
$pdf->SetXY(130, $y_pos + 25);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(70, 5, 'NIP. ' . $pemohon['nip'], 0, 1, 'C');
$pdf->Ln(5);

// --- BAGIAN VII & VIII ---
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(95, 6, 'VII. PERTIMBANGAN ATASAN LANGSUNG**', 1, 0, 'C');
$pdf->Cell(95, 6, 'VIII. KEPUTUSAN PEJABAT BERWENANG**', 1, 1, 'C');
$y_pos_ttd = $pdf->GetY();
$pdf->Cell(95, 35, '', 'LRB', 0);
$pdf->Cell(95, 35, '', 'RB', 1);

$is_approved_final = ($data['status'] == 'Disetujui Ketua');
$is_processed_by_atasan = in_array($data['status'], ['Disetujui Atasan', 'Ditolak Atasan', 'Disetujui Ketua', 'Ditolak Ketua']);

// TTD Atasan Langsung
if ($is_processed_by_atasan && $atasan_langsung) {
    $pdf->SetXY(10, $y_pos_ttd + 2);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(95, 5, $atasan_langsung['nama_jabatan'], 0, 1, 'C');
    $ttd_atasan_path = '../uploads/ttd/' . ($atasan_langsung['ttd_image'] ?? '');
    if ($is_approved_final && !empty($atasan_langsung['ttd_image']) && file_exists($ttd_atasan_path)) {
        $pdf->Image($ttd_atasan_path, 32.5, $y_pos_ttd + 7, 40, 15);
    } elseif ($is_approved_final || $data['status'] == 'Disetujui Atasan') {
        $pdf->SetXY(10, $y_pos_ttd + 15);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(95, 5, '(Disetujui secara elektronik)', 0, 1, 'C');
    }
    $pdf->SetXY(10, $y_pos_ttd + 25);
    $pdf->SetFont('Arial', 'U', 9);
    $pdf->Cell(95, 5, $atasan_langsung['nama_lengkap'], 0, 1, 'C');
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetX(10);
    $pdf->Cell(95, 5, 'NIP. ' . $atasan_langsung['nip'], 0, 1, 'C');
}

// TTD Ketua
if ($is_approved_final && $ketua) {
    $pdf->SetXY(105, $y_pos_ttd + 2);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(95, 5, $ketua['nama_jabatan'], 0, 1, 'C');
    $ttd_ketua_path = '../uploads/ttd/' . ($ketua['ttd_image'] ?? '');
    if (!empty($ketua['ttd_image']) && file_exists($ttd_ketua_path)) {
        $pdf->Image($ttd_ketua_path, 127.5, $y_pos_ttd + 7, 40, 15);
    } else {
        $pdf->SetXY(105, $y_pos_ttd + 15);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(95, 5, '(Disetujui secara elektronik)', 0, 1, 'C');
    }
    $pdf->SetXY(105, $y_pos_ttd + 25);
    $pdf->SetFont('Arial', 'U', 9);
    $pdf->Cell(95, 5, $ketua['nama_lengkap'], 0, 1, 'C');
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetX(105);
    $pdf->Cell(95, 5, 'NIP. ' . $ketua['nip'], 0, 1, 'C');
}

// PERBAIKAN: Gunakan variabel $pemohon untuk nama file
$pdf->Output('I', 'Formulir_Cuti_Final_' . str_replace(' ', '_', $pemohon['nama_lengkap']) . '.pdf');
