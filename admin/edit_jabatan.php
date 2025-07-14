<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    die("Akses ditolak.");
}

$id = $_GET['id'];

// Ambil data jabatan yang akan diedit
$query_select = "SELECT * FROM jabatan WHERE id = $id";
$result_select = mysqli_query($koneksi, $query_select);
$jabatan = mysqli_fetch_assoc($result_select);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_jabatan = mysqli_real_escape_string($koneksi, $_POST['nama_jabatan']);
    
    if (!empty($nama_jabatan)) {
        $query_update = "UPDATE jabatan SET nama_jabatan = '$nama_jabatan' WHERE id = $id";
        if (mysqli_query($koneksi, $query_update)) {
            $_SESSION['pesan'] = "Data jabatan berhasil diperbarui.";
            header('Location: manajemen_jabatan.php');
            exit();
        } else {
            $error = "Gagal memperbarui data: " . mysqli_error($koneksi);
        }
    } else {
        $error = "Nama jabatan tidak boleh kosong.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Jabatan - SIKEP</title>
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
        <h1>Edit Jabatan</h1>
        <hr>
        <form action="" method="POST">
            <div class="form-group">
                <label for="nama_jabatan">Nama Jabatan</label>
                <input type="text" id="nama_jabatan" name="nama_jabatan" value="<?php echo htmlspecialchars($jabatan['nama_jabatan']); ?>" required>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="manajemen_jabatan.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>