<?php
header('Content-Type: application/json');
include '../koneksi.php';

// Siapkan array untuk 12 bulan terakhir
$labels = [];
$values = [];
$date = new DateTime();
$date->modify('-11 months'); // Mulai dari 11 bulan yang lalu

for ($i = 0; $i < 12; $i++) {
    $year = $date->format('Y');
    $month = $date->format('m');
    $labels[] = $date->format('M Y'); // Contoh: Jul 2025

    // Query untuk menghitung jumlah pengajuan cuti pada bulan dan tahun tertentu
    $query = "SELECT COUNT(id) as total FROM pengajuan_cuti WHERE YEAR(tanggal_pengajuan) = '$year' AND MONTH(tanggal_pengajuan) = '$month'";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);
    
    $values[] = $row['total'] ? (int)$row['total'] : 0;
    
    $date->modify('+1 month'); // Pindah ke bulan berikutnya
}

// Kembalikan data dalam format JSON
echo json_encode([
    'labels' => $labels,
    'values' => $values
]);
?>