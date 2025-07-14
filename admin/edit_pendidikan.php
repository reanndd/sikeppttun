<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit();
}

$id_pendidikan = $_GET['id'];
$id_pegawai = $_GET['id_pegawai'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tingkat = mysqli_real_escape_string($koneksi, $_POST['tingkat_pendidikan']);
    $institusi = mysqli_real_escape_string($koneksi, $_POST['nama_institusi']);
    $jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
    $tahun_lulus = mysqli_real_escape_string($koneksi, $_POST['tahun_lulus']);

    $query_update = "UPDATE riwayat_pendidikan SET 
                        tingkat_pendidikan = '$tingkat', nama_institusi = '$institusi', 
                        jurusan = '$jurusan', tahun_lulus = '$tahun_lulus' 
                    WHERE id = $id_pendidikan";

    if (mysqli_query($koneksi, $query_update)) {
        $_SESSION['pesan'] = "Riwayat pendidikan berhasil diperbarui.";
        header('Location: detail_pegawai.php?id=' . $id_pegawai);
        exit();
    } else {
        $error = "Gagal memperbarui riwayat: " . mysqli_error($koneksi);
    }
}

$query_select = "SELECT * FROM riwayat_pendidikan WHERE id = $id_pendidikan";
$result_select = mysqli_query($koneksi, $query_select);
$pendidikan = mysqli_fetch_assoc($result_select);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Riwayat Pendidikan - SIKEP</title>
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
        <h1>Edit Riwayat Pendidikan</h1>
        <hr>
        <form action="" method="POST">
            <div class="form-group">
                <label>Tingkat Pendidikan</label>
                <input type="text" name="tingkat_pendidikan" value="<?php echo htmlspecialchars($pendidikan['tingkat_pendidikan']); ?>" required>
            </div>
            <div class="form-group">
                <label>Nama Institusi / Sekolah</label>
                <input type="text" name="nama_institusi" value="<?php echo htmlspecialchars($pendidikan['nama_institusi']); ?>" required>
            </div>
            <div class="form-group">
                <label>Jurusan</label>
                <input type="text" name="jurusan" value="<?php echo htmlspecialchars($pendidikan['jurusan']); ?>">
            </div>
            <div class="form-group">
                <label>Tahun Lulus</label>
                <input type="text" name="tahun_lulus" value="<?php echo htmlspecialchars($pendidikan['tahun_lulus']); ?>" required>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Update Riwayat</button>
                <a href="detail_pegawai.php?id=<?php echo $id_pegawai; ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>