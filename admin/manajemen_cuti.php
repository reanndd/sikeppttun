<?php 
$page_title = "Manajemen Cuti";
$current_page = "cuti"; // Dulu 'persetujuan', sekarang kita satukan
include 'header.php'; 

// Logika query disesuaikan berdasarkan peran
if ($_SESSION['role'] == 'ketua') {
    // Ketua hanya melihat pengajuan yang sudah disetujui atasan
    $query = "SELECT pc.*, p.nama_lengkap, p.nip 
              FROM pengajuan_cuti pc 
              JOIN pegawai p ON pc.id_pegawai = p.id 
              WHERE pc.status = 'Disetujui Atasan'
              ORDER BY pc.tanggal_pengajuan DESC";
} else { // Admin melihat semua
    $query = "SELECT pc.*, p.nama_lengkap, p.nip 
              FROM pengajuan_cuti pc 
              JOIN pegawai p ON pc.id_pegawai = p.id 
              ORDER BY 
                CASE 
                  WHEN pc.status = 'Disetujui Atasan' THEN 1
                  WHEN pc.status = 'Diajukan' THEN 2
                  ELSE 3
                END, 
                pc.tanggal_pengajuan DESC";
}

$result = mysqli_query($koneksi, $query);
?>

<h1>Manajemen & Persetujuan Cuti</h1>
<p>Halaman ini digunakan untuk memproses dan memonitor pengajuan cuti dari pegawai.</p>
<hr>

<?php
if (isset($_SESSION['pesan'])) {
    echo "<div class='alert success'>" . htmlspecialchars($_SESSION['pesan']) . "</div>";
    unset($_SESSION['pesan']);
}
?>

<table>
    <thead>
        <tr>
            <th>Nama Pegawai</th>
            <th>Jenis Cuti</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while($cuti = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($cuti['nama_lengkap']); ?></td>
                    <td><?php echo htmlspecialchars($cuti['jenis_cuti']); ?></td>
                    <td><?php echo date('d M Y', strtotime($cuti['tanggal_mulai'])) . " - " . date('d M Y', strtotime($cuti['tanggal_selesai'])); ?></td>
                    <td>
                        <?php $status_class = str_replace(' ', '-', strtolower($cuti['status'])); ?>
                        <div class="status <?php echo $status_class; ?>">
                            <?php echo htmlspecialchars($cuti['status']); ?>
                        </div>
                    </td>
                    <td class="actions">
                        <?php if ($cuti['status'] == 'Disetujui Atasan' && $_SESSION['role'] == 'ketua'): ?>
                            <a href="aksi_persetujuan_ketua.php?id=<?php echo $cuti['id']; ?>" class="btn">Proses</a>
                        <?php elseif ($cuti['status'] == 'Disetujui Ketua'): ?>
                            <a href="cetak_cuti.php?id=<?php echo $cuti['id']; ?>" target="_blank" class="btn" style="background-color:#17a2b8;">Cetak</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5" style="text-align:center;">
                <?php echo ($_SESSION['role'] == 'ketua') ? 'Tidak ada pengajuan untuk diproses.' : 'Belum ada data cuti.'; ?>
            </td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>