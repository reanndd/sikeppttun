<?php
session_start();
include '../koneksi.php';

// Keamanan: Cek sesi dan peran
if (!isset($_SESSION['username']) || !in_array($_SESSION['role'], ['admin', 'ketua'])) {
    die("Akses ditolak.");
}

// Cek apakah user ini adalah atasan
$is_atasan = false;
if (isset($_SESSION['id_pegawai'])) {
    $id_user_pegawai = $_SESSION['id_pegawai'];
    $query_cek_atasan = "SELECT COUNT(id) as jumlah_bawahan FROM pegawai WHERE id_atasan = '$id_user_pegawai'";
    $result_cek_atasan = mysqli_query($koneksi, $query_cek_atasan);
    if ($result_cek_atasan) {
        $data_bawahan = mysqli_fetch_assoc($result_cek_atasan);
        if ($data_bawahan['jumlah_bawahan'] > 0) {
            $is_atasan = true;
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title><?php echo isset($page_title) ? $page_title : 'Dahboard'; ?> - SIKEP</title>
    <link rel="stylesheet" href="../assets/style_admin.css">
</head>

<body>
    <div class="dashboard-container">
        <div id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <h2>SIKEP</h2>
                <p>Dashboard Admin</p>
            </div>
            <nav class="sidebar-menu">
                <a href="index.php" class="<?php if ($current_page == 'dashboard') echo 'active'; ?>">Dashboard</a>
                <a href="laporan.php" class="<?php if ($current_page == 'laporan') echo 'active'; ?>">Laporan Grafik</a>

                <?php if ($is_atasan || $_SESSION['role'] == 'admin' || $_SESSION['role'] == 'ketua'): ?>
                    <a href="manajemen_cuti.php" class="<?php if ($current_page == 'cuti') echo 'active'; ?>">Persetujuan Cuti</a>
                <?php endif; ?>

                <a href="riwayat_cuti.php" class="<?php if ($current_page == 'riwayat_cuti') echo 'active'; ?>">Riwayat Cuti</a>

                <hr style="border-color: #495057;"> <a href="manajemen_pegawai.php" class="<?php if ($current_page == 'pegawai') echo 'active'; ?>">Manajemen Pegawai</a>
                <a href="manajemen_jabatan.php" class="<?php if ($current_page == 'jabatan') echo 'active'; ?>">Manajemen Jabatan</a>
                <a href="manajemen_golongan.php" class="<?php if ($current_page == 'golongan') echo 'active'; ?>">Manajemen Golongan</a>

                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <a href="manajemen_pengumuman.php" class="<?php if ($current_page == 'pengumuman') echo 'active'; ?>">Manajemen Pengumuman</a>
                    <a href="manajemen_user.php" class="<?php if ($current_page == 'akun') echo 'active'; ?>">Manajemen Akun</a>
                <?php endif; ?>
            </nav>
            <div class="logout-link">
                <a href="../ganti_password.php">Ganti Password</a> |
                <a href="../logout.php">Logout</a>
            </div>
        </div>
        <div id="main-content" class="main-content">
            <button id="sidebar-toggle">&#9776;</button>