<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    die("Akses ditolak.");
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM pengumuman WHERE id = $id";

    if (mysqli_query($koneksi, $query)) {
        $_SESSION['pesan'] = "Pengumuman berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Gagal menghapus data.";
    }
}

header('Location: manajemen_pengumuman.php');
exit();
?>