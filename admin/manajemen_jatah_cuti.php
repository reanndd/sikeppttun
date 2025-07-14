<?php
$page_title = "Manajemen Jatah Cuti";
$current_page = "jatah_cuti";
include 'header.php';

if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak.");
}

// Proses form saat tombol Generate ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['generate_cuti'])) {
    $tahun_target = (int)$_POST['tahun'];
    $tahun_sebelumnya = $tahun_target - 1;
    $jatah_default = 12;

    $query_pegawai = "SELECT id FROM pegawai";
    $result_pegawai = mysqli_query($koneksi, $query_pegawai);

    $berhasil = 0;
    $gagal = 0;

    while ($pegawai = mysqli_fetch_assoc($result_pegawai)) {
        $id_pegawai = $pegawai['id'];
        $sisa_dibawa = 0;

        // 1. Cek sisa cuti tahun sebelumnya
        $query_sisa_lalu = "SELECT sisa_cuti FROM jatah_cuti WHERE id_pegawai = '$id_pegawai' AND tahun = '$tahun_sebelumnya'";
        $result_sisa_lalu = mysqli_query($koneksi, $query_sisa_lalu);

        if (mysqli_num_rows($result_sisa_lalu) > 0) {
            $data_sisa_lalu = mysqli_fetch_assoc($result_sisa_lalu);
            // Aturan: Maksimal 6 hari yang bisa dibawa
            $sisa_dibawa = min($data_sisa_lalu['sisa_cuti'], 6);
        }

        // 2. Hitung total jatah untuk tahun target
        $jatah_baru = $jatah_default + $sisa_dibawa;

        // 3. Masukkan atau perbarui data jatah cuti untuk tahun target
        $query_insert = "INSERT INTO jatah_cuti (id_pegawai, tahun, jatah_awal, sisa_dibawa, sisa_cuti) 
                         VALUES ('$id_pegawai', '$tahun_target', '$jatah_baru', '$sisa_dibawa', '$jatah_baru') 
                         ON DUPLICATE KEY UPDATE 
                         jatah_awal = VALUES(jatah_awal), 
                         sisa_dibawa = VALUES(sisa_dibawa), 
                         sisa_cuti = VALUES(sisa_cuti)";

        if (mysqli_query($koneksi, $query_insert)) {
            $berhasil++;
        } else {
            $gagal++;
        }
    }
    $_SESSION['pesan'] = "Proses generate selesai. Berhasil: $berhasil, Gagal: $gagal.";
    header('Location: manajemen_jatah_cuti.php');
    exit();
}

// Ambil data jatah cuti yang sudah ada untuk ditampilkan
$query = "SELECT jc.*, p.nama_lengkap 
          FROM jatah_cuti jc
          JOIN pegawai p ON jc.id_pegawai = p.id
          ORDER BY jc.tahun DESC, p.nama_lengkap ASC";
$result = mysqli_query($koneksi, $query);
?>

<h1>Manajemen Jatah Cuti Tahunan</h1>
<p>Gunakan halaman ini untuk memberikan jatah cuti tahunan kepada semua pegawai. Sistem akan otomatis membawa sisa cuti tahun lalu (maksimal 6 hari).</p>
<hr>

<?php
if (isset($_SESSION['pesan'])) {
    echo "<div class='alert success'>" . htmlspecialchars($_SESSION['pesan']) . "</div>";
    unset($_SESSION['pesan']);
}
?>

<div class="form-container">
    <form action="" method="POST">
        <div class="form-group">
            <label for="tahun">Pilih Tahun:</label>
            <input type="number" name="tahun" value="<?php echo date('Y'); ?>" min="2020" max="2099" required>
        </div>
        <button type="submit" name="generate_cuti" class="btn" onclick="return confirm('Anda yakin ingin men-generate jatah cuti untuk semua pegawai di tahun yang dipilih?');">Generate Jatah Cuti</button>
    </form>
</div>

<h3>Data Jatah Cuti yang Sudah Dibuat</h3>
<table>
    <thead>
        <tr>
            <th>Tahun</th>
            <th>Nama Pegawai</th>
            <th>Jatah Awal</th>
            <th>Sisa Dibawa (Tahun Lalu)</th>
            <th>Cuti Diambil</th>
            <th>Sisa Total</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['tahun']; ?></td>
                    <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                    <td><?php echo $row['jatah_awal']; ?> hari</td>
                    <td><?php echo $row['sisa_dibawa']; ?> hari</td>
                    <td><?php echo $row['cuti_diambil']; ?> hari</td>
                    <td><strong><?php echo $row['sisa_cuti']; ?> hari</strong></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="text-align:center;">Belum ada data jatah cuti yang di-generate.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>