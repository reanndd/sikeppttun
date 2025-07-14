<?php
// 1. Definisikan variabel untuk header
$page_title = "Ajukan Cuti";
$current_page = "ajukan_cuti";

// 2. Panggil header (yang berisi layout sidebar dan CSS)
include 'header.php';

// Ambil sisa cuti tahunan
$tahun_sekarang = date('Y');
$sisa_cuti_tahunan = 0;
$query_sisa_cuti = "SELECT sisa_cuti FROM jatah_cuti WHERE id_pegawai = '{$_SESSION['id_pegawai']}' AND tahun = '$tahun_sekarang'";
$result_sisa_cuti = mysqli_query($koneksi, $query_sisa_cuti);
if (mysqli_num_rows($result_sisa_cuti) > 0) {
    $sisa_cuti_tahunan = mysqli_fetch_assoc($result_sisa_cuti)['sisa_cuti'];
}

$error = '';
// Proses form saat disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jenis_cuti = mysqli_real_escape_string($koneksi, $_POST['jenis_cuti']);
    $tanggal_mulai = mysqli_real_escape_string($koneksi, $_POST['tanggal_mulai']);
    $tanggal_selesai = mysqli_real_escape_string($koneksi, $_POST['tanggal_selesai']);
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    $alamat_cuti = mysqli_real_escape_string($koneksi, $_POST['alamat_cuti']);
    $no_telp_cuti = mysqli_real_escape_string($koneksi, $_POST['no_telp_cuti']);

    // Validasi tanggal
    if (strtotime($tanggal_selesai) < strtotime($tanggal_mulai)) {
        $error = "Error: Tanggal selesai tidak boleh sebelum tanggal mulai.";
    } else {
        $valid = true;
        if ($jenis_cuti == 'Cuti Tahunan') {
            $start = new DateTime($tanggal_mulai);
            $end = new DateTime($tanggal_selesai);
            $diff = $end->diff($start)->format("%a") + 1;
            if ($diff > $sisa_cuti_tahunan) {
                $error = "Jatah cuti tahunan Anda tidak mencukupi. Sisa cuti Anda: " . $sisa_cuti_tahunan . " hari.";
                $valid = false;
            }
        }

        if ($valid) {
            $id_pegawai = $_SESSION['id_pegawai'];
            $query_insert = "INSERT INTO pengajuan_cuti (id_pegawai, jenis_cuti, tanggal_mulai, tanggal_selesai, keterangan, alamat_cuti, no_telp_cuti, status) 
                             VALUES ('$id_pegawai', '$jenis_cuti', '$tanggal_mulai', '$tanggal_selesai', '$keterangan', '$alamat_cuti', '$no_telp_cuti', 'Diajukan')";
            if (mysqli_query($koneksi, $query_insert)) {
                $_SESSION['pesan'] = "Pengajuan cuti Anda berhasil dikirim.";
                header('Location: index.php');
                exit();
            } else {
                $error = "Gagal mengirim pengajuan: " . mysqli_error($koneksi);
            }
        }
    }
}
?>

<h1>Formulir Pengajuan Cuti</h1>
<p>Silakan isi formulir di bawah ini untuk mengajukan cuti.</p>
<hr>

<?php if (!empty($error)): ?>
    <div class="alert error"><?php echo $error; ?></div>
<?php endif; ?>

<form action="" method="POST" onsubmit="return validateDates()">
    <div class="info-cuti">
        Sisa Jatah Cuti Tahunan Anda untuk tahun <?php echo $tahun_sekarang; ?>: <strong><?php echo $sisa_cuti_tahunan; ?> Hari</strong>
    </div>

    <div class="form-group">
        <label for="jenis_cuti">Jenis Cuti Yang Diambil *</label>
        <select name="jenis_cuti" id="jenis_cuti" required>
            <option value="">-- Pilih Jenis Cuti --</option>
            <option value="Cuti Tahunan">Cuti Tahunan</option>
            <option value="Cuti Besar">Cuti Besar</option>
            <option value="Cuti Sakit">Cuti Sakit</option>
            <option value="Cuti Melahirkan">Cuti Melahirkan</option>
            <option value="Cuti Karena Alasan Penting">Cuti Karena Alasan Penting</option>
            <option value="Cuti di Luar Tanggungan Negara">Cuti di Luar Tanggungan Negara</option>
        </select>
    </div>

    <div class="form-group">
        <label for="keterangan">Alasan Cuti *</label>
        <textarea name="keterangan" id="keterangan" placeholder="Tuliskan alasan lengkap Anda..." rows="4" required></textarea>
    </div>

    <div class="form-group">
        <label for="tanggal_mulai">Mulai Tanggal *</label>
        <input type="date" id="tanggal_mulai" name="tanggal_mulai" required>
    </div>
    <div class="form-group">
        <label for="tanggal_selesai">Sampai Tanggal *</label>
        <input type="date" id="tanggal_selesai" name="tanggal_selesai" required>
    </div>

    <div class="form-group">
        <label for="alamat_cuti">Alamat Selama Cuti *</label>
        <textarea id="alamat_cuti" name="alamat_cuti" rows="3" required></textarea>
    </div>
    <div class="form-group">
        <label for="no_telp_cuti">No. Telepon / HP *</label>
        <input type="tel" id="no_telp_cuti" name="no_telp_cuti" required>
    </div>

    <div class="btn-group">
        <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </div>
</form>

<script>
    function validateDates() {
        const startDate = document.getElementById('tanggal_mulai').value;
        const endDate = document.getElementById('tanggal_selesai').value;
        if (startDate && endDate && new Date(endDate) < new Date(startDate)) {
            alert('Error: Tanggal selesai tidak boleh sebelum tanggal mulai.');
            return false;
        }
        return true;
    }
</script>
<?php
// 3. Panggil footer
include 'footer.php';
?>