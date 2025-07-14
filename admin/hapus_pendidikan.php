<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit();
}

$id_pendidikan = $_GET['id'];
$id_pegawai = $_GET['id_pegawai'];

if (isset($id_pendidikan)) {
    $query = "DELETE FROM riwayat_pendidikan WHERE id = $id_pendidikan";
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['pesan'] = "Riwayat pendidikan berhasil dihapus.";
    } else {
        $_SESSION['pesan_error'] = "Gagal menghapus riwayat.";
    }
}

header('Location: detail_pegawai.php?id=' . $id_pegawai);
exit();
?>