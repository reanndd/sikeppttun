<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit();
}

// Ambil ID Riwayat dan ID Pegawai
$id_riwayat = $_GET['id'];
$id_pegawai = $_GET['id_pegawai'];

if (isset($id_riwayat)) {
    $query = "DELETE FROM riwayat_jabatan WHERE id = $id_riwayat";
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['pesan'] = "Riwayat jabatan berhasil dihapus.";
    } else {
        $_SESSION['pesan_error'] = "Gagal menghapus riwayat.";
    }
}
// Redirect kembali ke halaman detail pegawai
header('Location: detail_pegawai.php?id=' . $id_pegawai);
exit();
?>