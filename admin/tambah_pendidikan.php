<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit();
}

$id_pegawai = $_GET['id_pegawai'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pegawai_form = $_POST['id_pegawai'];
    $tingkat = mysqli_real_escape_string($koneksi, $_POST['tingkat_pendidikan']);
    $institusi = mysqli_real_escape_string($koneksi, $_POST['nama_institusi']);
    $jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
    $tahun_lulus = mysqli_real_escape_string($koneksi, $_POST['tahun_lulus']);

    if (!empty($tingkat) && !empty($institusi) && !empty($tahun_lulus)) {
        $query = "INSERT INTO riwayat_pendidikan (id_pegawai, tingkat_pendidikan, nama_institusi, jurusan, tahun_lulus) 
                  VALUES ('$id_pegawai_form', '$tingkat', '$institusi', '$jurusan', '$tahun_lulus')";

        if (mysqli_query($koneksi, $query)) {
            $_SESSION['pesan'] = "Riwayat pendidikan baru berhasil ditambahkan.";
            header('Location: detail_pegawai.php?id=' . $id_pegawai_form);
            exit();
        } else {
            $error = "Gagal menyimpan data: " . mysqli_error($koneksi);
        }
    } else {
        $error = "Tingkat, Institusi, dan Tahun Lulus wajib diisi.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Riwayat Pendidikan - SIKEP</title>
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
        <h1>Tambah Riwayat Pendidikan</h1>
        <hr>
        <form action="" method="POST">
            <input type="hidden" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
            <div class="form-group">
                <label>Tingkat Pendidikan (Contoh: S1, SMA)</label>
                <input type="text" name="tingkat_pendidikan" required>
            </div>
            <div class="form-group">
                <label>Nama Institusi / Sekolah</label>
                <input type="text" name="nama_institusi" required>
            </div>
            <div class="form-group">
                <label>Jurusan</label>
                <input type="text" name="jurusan">
            </div>
            <div class="form-group">
                <label>Tahun Lulus</label>
                <input type="text" name="tahun_lulus" required>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Simpan Riwayat</button>
                <a href="detail_pegawai.php?id=<?php echo $id_pegawai; ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>