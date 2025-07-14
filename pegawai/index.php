<?php 
// Definisikan variabel untuk header
$page_title = "Dashboard Pegawai";
$current_page = "dashboard";

// Panggil header (yang berisi layout sidebar dan CSS)
include 'header.php'; 

// Ambil riwayat pengajuan cuti untuk pegawai yang login
$query_cuti = "SELECT * FROM pengajuan_cuti WHERE id_pegawai = '{$_SESSION['id_pegawai']}' ORDER BY tanggal_pengajuan DESC";
$result_cuti = mysqli_query($koneksi, $query_cuti);

// Ambil sisa cuti tahunan untuk tahun ini
$tahun_sekarang = date('Y');
$sisa_cuti_tahunan = 0; // Default jika jatah belum di-generate
$query_sisa_cuti = "SELECT sisa_cuti FROM jatah_cuti WHERE id_pegawai = '$id_pegawai' AND tahun = '$tahun_sekarang'";
$result_sisa_cuti = mysqli_query($koneksi, $query_sisa_cuti);
if(mysqli_num_rows($result_sisa_cuti) > 0){
    $data_sisa_cuti = mysqli_fetch_assoc($result_sisa_cuti);
    $sisa_cuti_tahunan = $data_sisa_cuti['sisa_cuti'];
}

// Ambil 5 pengumuman terbaru
$query_pengumuman = "SELECT * FROM pengumuman ORDER BY tanggal_dibuat DESC LIMIT 5";
$result_pengumuman = mysqli_query($koneksi, $query_pengumuman);
?>

<h1>Dashboard Saya</h1>
<p>Selamat datang kembali di Sistem Informasi Kepegawaian.</p>

<?php 
// Tampilkan notifikasi pesan jika ada
if (isset($_SESSION['pesan'])) {
    // Pastikan class .alert ada di file CSS Anda
    echo "<div class='alert success'>" . htmlspecialchars($_SESSION['pesan']) . "</div>";
    unset($_SESSION['pesan']);
} 
?>

<hr>
<div class="stat-cards">
    <div class="stat-card">
        <h3>Sisa Cuti Tahunan <?php echo $tahun_sekarang; ?></h3>
        <p><?php echo $sisa_cuti_tahunan; ?> Hari</p>
    </div>
</div>

<div class="dashboard-panel">
    <div class="panel-header"><h3>Pengumuman Terbaru</h3></div>
    <div class="announcement-summary-container">
        <?php if(mysqli_num_rows($result_pengumuman) > 0): ?>
            <?php while($pengumuman = mysqli_fetch_assoc($result_pengumuman)): ?>
                <div class="announcement-card">
                    <?php if($pengumuman['gambar']): ?>
                        <img src="../uploads/pengumuman/<?php echo htmlspecialchars($pengumuman['gambar']); ?>" class="announcement-image">
                    <?php endif; ?>
                    <div class="announcement-content">
                        <h4><?php echo htmlspecialchars($pengumuman['judul']); ?></h4>
                        <p><?php echo substr(htmlspecialchars($pengumuman['isi']), 0, 100); ?>...</p>
                        <a href="detail_pengumuman.php?id=<?php echo $pengumuman['id']; ?>" class="read-more">Baca Selengkapnya &rarr;</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Tidak ada pengumuman terbaru.</p>
        <?php endif; ?>
    </div>
</div>

<h3>Riwayat Pengajuan Cuti Saya</h3>
<table>
    <thead>
        <tr>
            <th>Tanggal Pengajuan</th>
            <th>Jenis Cuti</th>
            <th>Tanggal Cuti</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result_cuti) > 0): ?>
            <?php while($cuti = mysqli_fetch_assoc($result_cuti)): ?>
                <tr>
                    <td><?php echo date('d M Y H:i', strtotime($cuti['tanggal_pengajuan'])); ?></td>
                    <td><?php echo htmlspecialchars($cuti['jenis_cuti']); ?></td>
                    <td><?php echo date('d M Y', strtotime($cuti['tanggal_mulai'])); ?> - <?php echo date('d M Y', strtotime($cuti['tanggal_selesai'])); ?></td>
                    <td>
                        <?php $status_class = str_replace(' ', '-', strtolower($cuti['status'])); ?>
                        <div class="status <?php echo $status_class; ?>">
                            <?php echo htmlspecialchars($cuti['status']); ?>
                        </div>
                    </td>
                    <td>
                        <?php if ($cuti['status'] == 'Disetujui Ketua'): ?>
                            <a href="../admin/cetak_cuti.php?id=<?php echo $cuti['id']; ?>" target="_blank" class="btn">Cetak</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5" style="text-align:center;">Anda belum pernah mengajukan cuti.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php 
include 'footer.php'; 
?>