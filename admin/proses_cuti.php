<?php
session_start();
include '../koneksi.php';

// ## PERBAIKAN LOGIKA ADA DI SINI ##
// Sekarang, hanya 'ketua' yang bisa memproses aksi ini.
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'ketua') {
    // Jika bukan ketua, redirect ke halaman login atau halaman lain
    header('Location: ../index.php');
    exit();
}

// Pastikan ada ID dan Aksi yang dikirim
if (isset($_GET['id']) && isset($_GET['aksi'])) {
    $id_cuti = $_GET['id'];
    $aksi = $_GET['aksi'];
    $status_baru = '';

    // Tentukan status baru berdasarkan aksi
    if ($aksi == 'setujui') {
        $status_baru = 'Disetujui';
    } elseif ($aksi == 'tolak') {
        $status_baru = 'Ditolak';
    }

    if ($status_baru != '') {
        // Query untuk update status
        $query = "UPDATE pengajuan_cuti SET status = '$status_baru' WHERE id = '$id_cuti'";
        if (mysqli_query($koneksi, $query)) {
            $_SESSION['pesan'] = "Status pengajuan cuti berhasil diperbarui.";
        } else {
            $_SESSION['pesan_error'] = "Gagal memperbarui status.";
        }
    }
}

// Redirect kembali ke halaman manajemen cuti
header('Location: manajemen_cuti.php');
exit();
?>