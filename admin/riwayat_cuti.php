<?php
$page_title = "Riwayat Cuti";
$current_page = "riwayat_cuti";
include 'header.php';

// Query untuk mengambil semua data pengajuan cuti dari semua pegawai
$query = "SELECT pc.*, p.nama_lengkap, p.nip
          FROM pengajuan_cuti pc
          JOIN pegawai p ON pc.id_pegawai = p.id
          ORDER BY pc.tanggal_pengajuan DESC";

$result = mysqli_query($koneksi, $query);
?>

<h1>Arsip dan Riwayat Pengajuan Cuti</h1>
<p>Halaman ini berisi seluruh catatan pengajuan cuti dari semua pegawai.</p>
<hr>

<table>
    <thead>
        <tr>
            <th>Nama Pegawai</th>
            <th>Jenis Cuti</th>
            <th>Tanggal Diajukan</th>
            <th>Lama Cuti</th>
            <th>Status Final</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while($cuti = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($cuti['nama_lengkap']); ?></td>
                    <td><?php echo htmlspecialchars($cuti['jenis_cuti']); ?></td>
                    <td><?php echo date('d M Y', strtotime($cuti['tanggal_pengajuan'])); ?></td>
                    <td><?php echo date('d M Y', strtotime($cuti['tanggal_mulai'])) . " - " . date('d M Y', strtotime($cuti['tanggal_selesai'])); ?></td>
                    <td>
                        <?php
                        // Ganti spasi menjadi strip untuk nama class CSS
                        $status_class = str_replace(' ', '-', strtolower($cuti['status']));
                        ?>
                        <div class="status <?php echo $status_class; ?>">
                            <?php echo htmlspecialchars($cuti['status']); ?>
                        </div>
                    </td>
                    <td class="actions">
                        <?php if ($cuti['status'] == 'Disetujui Ketua'): ?>
                            <a href="cetak_cuti.php?id=<?php echo $cuti['id']; ?>" target="_blank" class="btn" style="background-color:#17a2b8;">Cetak</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6" style="text-align:center;">Belum ada data riwayat cuti.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>