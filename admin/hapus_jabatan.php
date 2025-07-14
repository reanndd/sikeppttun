<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    die("Akses ditolak.");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM jabatan WHERE id = $id";
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['pesan'] = "Jabatan berhasil dihapus.";
    } else {
        $_SESSION['pesan_error'] = "Gagal menghapus jabatan.";
    }
}
header('Location: manajemen_jabatan.php');
exit();
?>