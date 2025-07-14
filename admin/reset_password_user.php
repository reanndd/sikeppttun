<?php
session_start();
include '../koneksi.php';

// Keamanan: Cek sesi dan peran
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    die("Akses ditolak.");
}

// Validasi ID dari URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_user = $_GET['id'];
    $password_default = "123456";

    // Hash password default sebelum disimpan
    $password_hashed = password_hash($password_default, PASSWORD_DEFAULT);

    // Query untuk mengubah password pengguna berdasarkan ID
    $query = "UPDATE users SET password = '$password_hashed' WHERE id = $id_user";

    if (mysqli_query($koneksi, $query)) {
        // Jika berhasil, siapkan pesan sukses
        $_SESSION['pesan'] = "Password pengguna berhasil di-reset ke default ('123456').";
    } else {
        // Jika gagal, siapkan pesan error
        $_SESSION['error'] = "Gagal me-reset password.";
    }
}

// Arahkan kembali ke halaman manajemen akun
header('Location: manajemen_user.php');
exit();
