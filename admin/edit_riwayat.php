<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit();
}

// Ambil ID Riwayat dan ID Pegawai dari URL
$id_riwayat = $_GET['id'];
$id_pegawai = $_GET['id_pegawai'];

// Proses form saat disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $unit_kerja = mysqli_real_escape_string($koneksi, $_POST['unit_kerja']);
    $nomor_sk = mysqli_real_escape_string($koneksi, $_POST['nomor_sk']);
    $tanggal_sk = mysqli_real_escape_string($koneksi, $_POST['tanggal_sk']);
    $tmt_jabatan = mysqli_real_escape_string($koneksi, $_POST['tmt_jabatan']);

    $query_update = "UPDATE riwayat_jabatan SET 
                        jabatan = '$jabatan', unit_kerja = '$unit_kerja', nomor_sk = '$nomor_sk', 
                        tanggal_sk = '$tanggal_sk', tmt_jabatan = '$tmt_jabatan' 
                    WHERE id = $id_riwayat";

    if (mysqli_query($koneksi, $query_update)) {
        $_SESSION['pesan'] = "Riwayat jabatan berhasil diperbarui.";
        header('Location: detail_pegawai.php?id=' . $id_pegawai);
        exit();
    } else {
        $error = "Gagal memperbarui riwayat: " . mysqli_error($koneksi);
    }
}

// Ambil data riwayat yang akan diedit
$query_select = "SELECT * FROM riwayat_jabatan WHERE id = $id_riwayat";
$result_select = mysqli_query($koneksi, $query_select);
$riwayat = mysqli_fetch_assoc($result_select);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Riwayat Jabatan - SIKEP</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f7f6; }
        .container { width: 80%; margin: 20px auto; background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .btn-group { margin-top: 20px; }
        .btn { padding: 10px 15px; text-decoration: none; border-radius: 5px; border: none; cursor: pointer; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Riwayat Jabatan</h1>
        <hr>
        <form action="" method="POST">
            <div class="form-group">
                <label>Nama Jabatan</label>
                <input type="text" name="jabatan" value="<?php echo htmlspecialchars($riwayat['jabatan']); ?>" required>
            </div>
            <div class="form-group">
                <label>Unit Kerja</label>
                <input type="text" name="unit_kerja" value="<?php echo htmlspecialchars($riwayat['unit_kerja']); ?>">
            </div>
            <div class="form-group">
                <label>Nomor SK</label>
                <input type="text" name="nomor_sk" value="<?php echo htmlspecialchars($riwayat['nomor_sk']); ?>">
            </div>
            <div class="form-group">
                <label>Tanggal SK</label>
                <input type="date" name="tanggal_sk" value="<?php echo htmlspecialchars($riwayat['tanggal_sk']); ?>">
            </div>
            <div class="form-group">
                <label>TMT Jabatan</label>
                <input type="date" name="tmt_jabatan" value="<?php echo htmlspecialchars($riwayat['tmt_jabatan']); ?>" required>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Update Riwayat</button>
                <a href="detail_pegawai.php?id=<?php echo $id_pegawai; ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>