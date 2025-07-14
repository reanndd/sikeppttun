<?php
session_start();
include '../koneksi.php';

// Keamanan: Pastikan hanya pegawai yang bisa akses
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'pegawai') {
    header('Location: ../index.php');
    exit();
}

$id_pegawai = $_SESSION['id_pegawai'];

// Ambil data pegawai untuk ditampilkan di header
$query_pegawai_info = "SELECT nama_lengkap, foto FROM pegawai WHERE id = '$id_pegawai'";
$result_pegawai_info = mysqli_query($koneksi, $query_pegawai_info);
$pegawai_info = mysqli_fetch_assoc($result_pegawai_info);

// Cek apakah user ini adalah atasan
$query_cek_atasan = "SELECT COUNT(id) as jumlah_bawahan FROM pegawai WHERE id_atasan = '$id_pegawai'";
$result_cek_atasan = mysqli_query($koneksi, $query_cek_atasan);
$is_atasan = (mysqli_fetch_assoc($result_cek_atasan)['jumlah_bawahan'] > 0);
?>
<!DOCTYPE html>
<html>

<head>
    <title><?php echo isset($page_title) ? $page_title : 'Dasbor'; ?> - SIKEP</title>
    <link rel="stylesheet" href="../assets/style_pegawai.css">
</head>

<body>
    <div class="dashboard-container">
        <div id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <?php if (!empty($pegawai_info['foto']) && file_exists('../uploads/' . $pegawai_info['foto'])): ?>
                    <img src="../uploads/<?php echo htmlspecialchars($pegawai_info['foto']); ?>" alt="Foto Profil">
                <?php else: ?>
                    <img src="../assets/default-avatar.png" alt="Foto Profil">
                <?php endif; ?>
                <h3><?php echo htmlspecialchars($pegawai_info['nama_lengkap']); ?></h3>
            </div>
            <nav class="sidebar-menu">
                <a href="index.php" class="<?php if ($current_page == 'dashboard') echo 'active'; ?>">Dasbor Saya</a>
                <a href="ajukan_cuti.php" class="<?php if ($current_page == 'ajukan_cuti') echo 'active'; ?>">Buat Pengajuan Cuti</a>
                <?php if ($is_atasan): ?>
                    <a href="persetujuan_atasan.php" class="<?php if ($current_page == 'persetujuan') echo 'active'; ?>">Persetujuan Bawahan</a>
                <?php endif; ?>
            </nav>
            <div class="bottom-menu">
                <a href="../ganti_password.php">Ganti Password</a>
                <a href="../logout.php" class="logout">Logout</a>
            </div>
        </div>

        <div id="main-content" class="main-content">
            <button id="sidebar-toggle">&#9776;</button>