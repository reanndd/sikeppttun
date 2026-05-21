<?php
session_start();
include '../koneksi.php';

// Keamanan: Cek sesi dan peran admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    die("Akses ditolak.");
}

// Validasi ID dari URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data
    $query = "DELETE FROM golongan WHERE id = $id";

    if (mysqli_query($koneksi, $query)) {
        // Jika berhasil, siapkan pesan sukses
        $_SESSION['pesan'] = "Data golongan berhasil dihapus.";
    } else {
        // Jika terjadi error (kemungkinan besar karena masih digunakan oleh pegawai), set pesan error
        $_SESSION['error'] = "Gagal menghapus data. Pastikan tidak ada pegawai yang masih menggunakan golongan ini.";
    }
}

// Redirect (arahkan) kembali ke halaman manajemen golongan
header('Location: manajemen_golongan.php');
exit();
?>