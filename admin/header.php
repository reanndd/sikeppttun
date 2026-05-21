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

// --- LOGIKA UNTUK MENGHITUNG NOTIFIKASI LONCENG ---
$notif_count = 0;
if ($_SESSION['role'] == 'ketua') {
    // Ketua menghitung pengajuan yang statusnya 'Disetujui Atasan'
    $query_notif = "SELECT COUNT(id) as total FROM pengajuan_cuti WHERE status = 'Disetujui Atasan'";
    $result_notif = mysqli_query($koneksi, $query_notif);
    if ($result_notif) {
        $notif_count = mysqli_fetch_assoc($result_notif)['total'];
    }
} elseif ($is_atasan && $_SESSION['role'] != 'admin') { // Atasan (tapi bukan admin) menghitung 'Diajukan'
    $id_atasan_session = $_SESSION['id_pegawai'];
    $query_notif = "SELECT COUNT(pc.id) as total FROM pengajuan_cuti pc JOIN pegawai p ON pc.id_pegawai = p.id WHERE p.id_atasan = '$id_atasan_session' AND pc.status = 'Diajukan'";
    $result_notif = mysqli_query($koneksi, $query_notif);
    if ($result_notif) {
        $notif_count = mysqli_fetch_assoc($result_notif)['total'];
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title><?php echo isset($page_title) ? $page_title : 'Dashboard'; ?> - SIKEP</title>
    <link rel="stylesheet" href="../assets/style_admin.css">
    <style>
        .sidebar-menu a.has-submenu::after {
            content: ' \25BC';
            font-size: 0.7em;
            float: right;
        }

        .sidebar-menu div a.submenu-item {
            background-color: #343a40;
            padding-left: 30px;
            font-size: 0.9em;
        }

        .sidebar-menu div a.submenu-item:hover {
            background-color: #5a6268;
        }

        .sidebar-menu div a.submenu-item.active {
            background-color: #495057;
            color: white;
        }

        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        #sidebar-toggle {
            position: static;
        }

        .notification-area {
            position: relative;
        }

        .notification-bell {
            font-size: 24px;
            color: #555;
            text-decoration: none;
            position: relative;
            display: inline-block;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 10px;
            font-weight: bold;
            border: 1px solid white;
        }
    </style>
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
                <hr style="border-color: #495057;">
                <a href="#" class="has-submenu <?php if (in_array($current_page, ['pegawai', 'jabatan', 'golongan'])) echo 'active'; ?>" id="data-master-menu">Data Pegawai</a>
                <div id="data-master-submenu" style="display: <?php echo in_array($current_page, ['pegawai', 'jabatan', 'golongan']) ? 'block' : 'none'; ?>;">
                    <a href="manajemen_pegawai.php" class="submenu-item <?php if ($current_page == 'pegawai') echo 'active'; ?>">Manajemen Pegawai</a>
                    <a href="manajemen_jabatan.php" class="submenu-item <?php if ($current_page == 'jabatan') echo 'active'; ?>">Manajemen Jabatan</a>
                    <a href="manajemen_golongan.php" class="submenu-item <?php if ($current_page == 'golongan') echo 'active'; ?>">Manajemen Golongan</a>
                </div>
                <a href="#" class="has-submenu <?php if (in_array($current_page, ['cuti', 'jatah_cuti', 'riwayat_cuti'])) echo 'active'; ?>" id="data-cuti-menu">Data Cuti</a>
                <div id="data-cuti-submenu" style="display: <?php echo in_array($current_page, ['cuti', 'jatah_cuti', 'riwayat_cuti']) ? 'block' : 'none'; ?>;">
                    <a href="manajemen_cuti.php" class="submenu-item <?php if ($current_page == 'cuti') echo 'active'; ?>">Persetujuan Cuti</a>
                    <?php if ($_SESSION['role'] == 'admin'): ?>
                        <a href="manajemen_jatah_cuti.php" class="submenu-item <?php if ($current_page == 'jatah_cuti') echo 'active'; ?>">Manajemen Jatah Cuti</a>
                    <?php endif; ?>
                    <a href="riwayat_cuti.php" class="submenu-item <?php if ($current_page == 'riwayat_cuti') echo 'active'; ?>">Riwayat Cuti</a>
                </div>
                <hr style="border-color: #495057;">
                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <a href="manajemen_pengumuman.php" class="<?php if ($current_page == 'pengumuman') echo 'active'; ?>">Manajemen Pengumuman</a>
                    <a href="manajemen_user.php" class="<?php if ($current_page == 'akun') echo 'active'; ?>">Manajemen Akun</a>
                <?php endif; ?>
            </nav>
            <div class="logout-link">
                <a href="../ganti_password.php">Ganti Password</a> | <a href="../logout.php">Logout</a>
            </div>
        </div>
        <div id="main-content" class="main-content">
            <div class="main-header">
                <button id="sidebar-toggle">&#9776;</button>
                <div class="notification-area">
                    <a href="manajemen_cuti.php" class="notification-bell">
                        &#128276; <?php if ($notif_count > 0): ?>
                            <span class="notification-badge"><?php echo $notif_count; ?></span>
                        <?php endif; ?>
                    </a>
                </div>
            </div>