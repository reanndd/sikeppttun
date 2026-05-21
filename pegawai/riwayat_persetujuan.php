<?php
// 1. Definisikan variabel untuk header
$page_title = "Riwayat Persetujuan Cuti";
$current_page = "riwayat_persetujuan"; // Halaman aktif baru

// 2. Panggil header
include 'header.php';

// Keamanan: Pastikan yang mengakses adalah atasan
if (!$is_atasan) {
    die("Akses ditolak. Halaman ini hanya untuk atasan.");
}

// 3. Ambil data pengajuan yang pernah diproses oleh atasan ini
$id_atasan_session = $_SESSION['id_pegawai'];
$query = "SELECT pc.*, p.nama_lengkap, p.nip 
          FROM pengajuan_cuti pc 
          JOIN pegawai p ON pc.id_pegawai = p.id 
          WHERE pc.disetujui_oleh_atasan_id = '$id_atasan_session'
          ORDER BY pc.tanggal_disetujui_atasan DESC";
$result = mysqli_query($koneksi, $query);
?>

<h1>Riwayat Persetujuan Cuti</h1>
<p>Halaman ini berisi arsip dari semua pengajuan cuti yang telah Anda proses.</p>
<hr>

<table>
    <thead>
        <tr>
            <th>Nama Pemohon</th>
            <th>Jenis Cuti</th>
            <th>Tanggal Cuti</th>
            <th>Keputusan Anda</th>
            <th>Status Final</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($cuti = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($cuti['nama_lengkap']); ?></td>
                    <td><?php echo htmlspecialchars($cuti['jenis_cuti']); ?></td>
                    <td><?php echo date('d M Y', strtotime($cuti['tanggal_mulai'])) . " - " . date('d M Y', strtotime($cuti['tanggal_selesai'])); ?></td>
                    <td>
                        <?php
                        // Menampilkan status persetujuan dari atasan
                        $keputusan_atasan = (strpos($cuti['status'], 'Ditolak') !== false && $cuti['status'] == 'Ditolak Atasan') ? 'Ditolak' : 'Disetujui';
                        $status_class_atasan = ($keputusan_atasan == 'Ditolak') ? 'ditolak' : 'disetujui';
                        ?>
                        <div class="status <?php echo $status_class_atasan; ?>"><?php echo $keputusan_atasan; ?></div>
                    </td>
                    <td>
                        <?php $status_class_final = str_replace(' ', '-', strtolower($cuti['status'])); ?>
                        <div class="status <?php echo $status_class_final; ?>"><?php echo htmlspecialchars($cuti['status']); ?></div>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" style="text-align:center;">Anda belum pernah memproses pengajuan cuti.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php
// 4. Panggil footer
include 'footer.php';
?>