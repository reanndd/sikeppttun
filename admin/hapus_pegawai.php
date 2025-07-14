<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../manajemen_pegawai.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM pegawai WHERE id = $id";

    if (mysqli_query($koneksi, $query)) {
        // PENAMBAHAN: Gunakan session untuk pesan sukses
        $_SESSION['pesan'] = "Data pegawai berhasil dihapus.";
        header('Location: manajemen_pegawai.php');
        exit();
    } else {
        // Bisa juga buat pesan gagal jika perlu
        $_SESSION['pesan_error'] = "Gagal menghapus data.";
        header('Location: manajemen_pegawai.php');
        exit();
    }
} else {
    header('Location: manajemen_pegawai.php');
    exit();
}
?>