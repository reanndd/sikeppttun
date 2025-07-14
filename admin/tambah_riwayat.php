<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit();
}

// Ambil ID Pegawai dari URL, ini penting untuk link kembali dan insert data
if (!isset($_GET['id_pegawai']) || !is_numeric($_GET['id_pegawai'])) {
    header('Location: index.php'); // Kembali ke dashboard jika tidak ada ID
    exit();
}
$id_pegawai = $_GET['id_pegawai'];

$error = '';

// Proses form saat disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pegawai_form = $_POST['id_pegawai'];
    $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $unit_kerja = mysqli_real_escape_string($koneksi, $_POST['unit_kerja']);
    $nomor_sk = mysqli_real_escape_string($koneksi, $_POST['nomor_sk']);
    $tanggal_sk = mysqli_real_escape_string($koneksi, $_POST['tanggal_sk']);
    $tmt_jabatan = mysqli_real_escape_string($koneksi, $_POST['tmt_jabatan']);

    // Validasi dasar
    if (!empty($jabatan) && !empty($tmt_jabatan)) {
        // Query INSERT ke tabel riwayat_jabatan
        $query = "INSERT INTO riwayat_jabatan (id_pegawai, jabatan, unit_kerja, nomor_sk, tanggal_sk, tmt_jabatan) 
                  VALUES ('$id_pegawai_form', '$jabatan', '$unit_kerja', '$nomor_sk', '$tanggal_sk', '$tmt_jabatan')";

        if (mysqli_query($koneksi, $query)) {
            $_SESSION['pesan'] = "Riwayat jabatan baru berhasil ditambahkan.";
            // Kembali ke halaman detail pegawai yang bersangkutan
            header('Location: detail_pegawai.php?id=' . $id_pegawai_form);
            exit();
        } else {
            $error = "Gagal menyimpan data riwayat! " . mysqli_error($koneksi);
        }
    } else {
        $error = "Nama Jabatan dan TMT Jabatan wajib diisi.";
    }
}

// Ambil nama pegawai untuk ditampilkan di judul
$query_pegawai_nama = "SELECT nama_lengkap FROM pegawai WHERE id = $id_pegawai";
$result_pegawai_nama = mysqli_query($koneksi, $query_pegawai_nama);
$pegawai_data = mysqli_fetch_assoc($result_pegawai_nama);
$nama_pegawai = $pegawai_data['nama_lengkap'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Riwayat Jabatan - SIKEP</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f7f6; }
        .container { width: 80%; margin: 20px auto; background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        .sub-header { color: #555; margin-top: -15px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .btn-group { margin-top: 20px; }
        .btn { padding: 10px 15px; text-decoration: none; border-radius: 5px; border: none; cursor: pointer; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .message { padding: 10px; margin-bottom: 15px; border-radius: 5px; }
        .error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Riwayat Jabatan</h1>
        <p class="sub-header">Untuk Pegawai: <strong><?php echo htmlspecialchars($nama_pegawai); ?></strong></p>
        <hr>

        <?php if (!empty($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <input type="hidden" name="id_pegawai" value="<?php echo $id_pegawai; ?>">

            <div class="form-group">
                <label for="jabatan">Nama Jabatan</label>
                <input type="text" id="jabatan" name="jabatan" required>
            </div>
            <div class="form-group">
                <label for="unit_kerja">Unit Kerja</label>
                <input type="text" id="unit_kerja" name="unit_kerja">
            </div>
            <div class="form-group">
                <label for="nomor_sk">Nomor SK</label>
                <input type="text" id="nomor_sk" name="nomor_sk">
            </div>
            <div class="form-group">
                <label for="tanggal_sk">Tanggal SK</label>
                <input type="date" id="tanggal_sk" name="tanggal_sk">
            </div>
            <div class="form-group">
                <label for="tmt_jabatan">TMT Jabatan</label>
                <input type="date" id="tmt_jabatan" name="tmt_jabatan" required>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Simpan Riwayat</button>
                <a href="detail_pegawai.php?id=<?php echo $id_pegawai; ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>