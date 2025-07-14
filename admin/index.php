<?php
$page_title = "Dashboard";
$current_page = "dashboard";
include 'header.php';

// --- Query untuk Data Dashboard ---
$query_total_pegawai = "SELECT COUNT(id) as total FROM pegawai";
$result_total_pegawai = mysqli_query($koneksi, $query_total_pegawai);
$total_pegawai = mysqli_fetch_assoc($result_total_pegawai)['total'];

$query_total_cuti = "SELECT COUNT(id) as total FROM pengajuan_cuti WHERE status = 'Diajukan'";
$result_total_cuti = mysqli_query($koneksi, $query_total_cuti);
$total_cuti_diajukan = mysqli_fetch_assoc($result_total_cuti)['total'];

$query_aktivitas = "SELECT p.nama_lengkap, pc.jenis_cuti, pc.tanggal_pengajuan 
                    FROM pengajuan_cuti pc
                    JOIN pegawai p ON pc.id_pegawai = p.id
                    ORDER BY pc.tanggal_pengajuan DESC LIMIT 5";
$result_aktivitas = mysqli_query($koneksi, $query_aktivitas);
?>

<style>
    .stat-cards {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    /* PERUBAHAN: Style untuk link kartu */
    a.stat-card-link {
        text-decoration: none;
        color: inherit;
        flex: 1;
    }

    .stat-card {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        /* Animasi hover */
    }

    /* PERUBAHAN: Efek hover pada kartu */
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .stat-card h3 {
        margin-top: 0;
        font-size: 16px;
        color: #6c757d;
    }

    .stat-card p {
        margin: 0;
        font-size: 32px;
        font-weight: bold;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 20px;
    }

    .dashboard-panel {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .panel-header {
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }

    .panel-header h3 {
        margin: 0;
    }

    .quick-access-buttons a {
        display: block;
        padding: 12px;
        background-color: #f8f9fa;
        border-radius: 5px;
        text-decoration: none;
        color: #333;
        font-weight: bold;
        margin-bottom: 10px;
        transition: background-color 0.2s;
    }

    .quick-access-buttons a:hover {
        background-color: #e9ecef;
    }

    .activity-list ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .activity-list li {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }

    .activity-list li:last-child {
        border-bottom: none;
    }

    .activity-list .time {
        font-size: 0.8em;
        color: #6c757d;
    }
</style>

<h1>Dashboard</h1>
<p>Selamat datang kembali, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!</p>

<div class="stat-cards">
    <a href="manajemen_pegawai.php" class="stat-card-link">
        <div class="stat-card" style="border-left: 5px solid #007bff;">
            <h3>Total Pegawai</h3>
            <p><?php echo $total_pegawai; ?></p>
        </div>
    </a>
    <a href="manajemen_cuti.php" class="stat-card-link">
        <div class="stat-card" style="border-left: 5px solid #ffc107;">
            <h3>Cuti Perlu Persetujuan</h3>
            <p><?php echo $total_cuti_diajukan; ?></p>
        </div>
    </a>
</div>
<div class="dashboard-panel">
    <div class="panel-header">
        <h3>Aktivitas Cuti Terbaru</h3>
    </div>
    <div class="activity-list">
        <ul>
            <?php if (mysqli_num_rows($result_aktivitas) > 0): ?>
                <?php while ($aktivitas = mysqli_fetch_assoc($result_aktivitas)): ?>
                    <li>
                        <div>
                            <strong><?php echo htmlspecialchars($aktivitas['nama_lengkap']); ?></strong>
                            <br><small><?php echo htmlspecialchars($aktivitas['jenis_cuti']); ?></small>
                        </div>
                        <div class="time">
                            <?php echo date('d M Y', strtotime($aktivitas['tanggal_pengajuan'])); ?>
                        </div>
                    </li>
                <?php endwhile; ?>
            <?php else: ?>
                <li>Tidak ada aktivitas terbaru.</li>
            <?php endif; ?>
        </ul>
    </div>
</div>
</div>

<?php include 'footer.php'; ?>