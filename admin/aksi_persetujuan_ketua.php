<?php
$page_title = "Proses Persetujuan Final Cuti";
$current_page = "cuti";
include 'header.php';

// Keamanan: Hanya Ketua yang bisa akses
if ($_SESSION['role'] != 'ketua') {
    die("Akses ditolak. Hanya Ketua yang dapat memproses halaman ini.");
}

// Validasi ID dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: manajemen_cuti.php');
    exit();
}
$id_cuti = $_GET['id'];

// Proses form saat tombol "Setujui" atau "Tolak" ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status_baru = $_POST['status'];
    $catatan = mysqli_real_escape_string($koneksi, $_POST['catatan_ketua']);
    $id_ketua_session = $_SESSION['id_pegawai'];

    $query_update = null;

    if ($status_baru == 'Disetujui Ketua') {
        // Jika disetujui, simpan ID Ketua dan tanggal persetujuan
        $query_update = "UPDATE pengajuan_cuti SET 
                            status = '$status_baru', 
                            catatan_ketua = '$catatan',
                            disetujui_oleh_ketua_id = '$id_ketua_session',
                            tanggal_disetujui_ketua = NOW()
                         WHERE id = '$id_cuti'";
    } elseif ($status_baru == 'Ditolak Ketua') {
        // Jika ditolak, cukup update status dan catatan
        $query_update = "UPDATE pengajuan_cuti SET 
                            status = '$status_baru', 
                            catatan_ketua = '$catatan'
                         WHERE id = '$id_cuti'";
    }

    if ($query_update && mysqli_query($koneksi, $query_update)) {
        $_SESSION['pesan'] = "Persetujuan final cuti berhasil diproses.";
        header('Location: manajemen_cuti.php');
        exit();
    } else {
        $error = "Aksi tidak valid atau gagal memperbarui data.";
    }
}

// Ambil data cuti untuk ditampilkan di halaman
$query = "SELECT pc.*, p.nama_lengkap, p.nip, j.nama_jabatan 
          FROM pengajuan_cuti pc 
          JOIN pegawai p ON pc.id_pegawai = p.id
          LEFT JOIN jabatan j ON p.id_jabatan = j.id
          WHERE pc.id = '$id_cuti' AND pc.status = 'Disetujui Atasan'";
$result = mysqli_query($koneksi, $query);
$cuti = mysqli_fetch_assoc($result);

if (!$cuti) {
    die("Data tidak ditemukan atau sudah diproses.");
}
?>

<h1>Proses Persetujuan Final Cuti</h1>
<a href="manajemen_cuti.php" class="btn btn-secondary">Kembali</a>
<hr>

<h3>Detail Pengajuan</h3>
<table>
    <tr>
        <td width="30%"><strong>Nama Pemohon</strong></td>
        <td><?php echo htmlspecialchars($cuti['nama_lengkap']); ?></td>
    </tr>
    <tr>
        <td><strong>Jenis Cuti</strong></td>
        <td><?php echo htmlspecialchars($cuti['jenis_cuti']); ?></td>
    </tr>
    <tr>
        <td><strong>Tanggal Cuti</strong></td>
        <td><?php echo date('d M Y', strtotime($cuti['tanggal_mulai'])) . " s/d " . date('d M Y', strtotime($cuti['tanggal_selesai'])); ?></td>
    </tr>
    <tr>
        <td><strong>Alasan</strong></td>
        <td><?php echo nl2br(htmlspecialchars($cuti['keterangan'])); ?></td>
    </tr>
    <tr>
        <td><strong>Catatan Atasan</strong></td>
        <td><?php echo nl2br(htmlspecialchars($cuti['catatan_atasan'])) ?: '-'; ?></td>
    </tr>
</table>

<hr>
<h3>Formulir Keputusan Final</h3>
<?php if (isset($error)) {
    echo "<div class='alert error'>$error</div>";
} ?>
<form action="" method="POST">
    <div class="form-group">
        <label for="catatan_ketua">Catatan / Alasan Persetujuan Final (Opsional)</label>
        <textarea name="catatan_ketua" id="catatan_ketua" rows="4" placeholder="Berikan catatan jika ada..."></textarea>
    </div>
    <div class="btn-group">
        <button type="submit" name="status" value="Disetujui Ketua" class="btn btn-success" onclick="return confirm('Anda yakin ingin MENYETUJUI pengajuan ini?');">Setujui (Final)</button>
        <button type="submit" name="status" value="Ditolak Ketua" class="btn btn-danger" onclick="return confirm('Anda yakin ingin MENOLAK pengajuan ini?');">Tolak (Final)</button>
    </div>
</form>

<?php include 'footer.php'; ?>