<?php
session_start();
include '../koneksi.php';
// ... (logika validasi sesi & ID tetap sama) ...
$id = $_GET['id'];
$error = '';
$pegawai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pegawai WHERE id = $id"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ... (logika untuk data teks tetap sama) ...
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $nip = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $id_jabatan = mysqli_real_escape_string($koneksi, $_POST['id_jabatan']);
    $id_golongan = !empty($_POST['id_golongan']) ? "'" . mysqli_real_escape_string($koneksi, $_POST['id_golongan']) . "'" : "NULL";
    $id_atasan = !empty($_POST['id_atasan']) ? "'" . mysqli_real_escape_string($koneksi, $_POST['id_atasan']) . "'" : "NULL";

    $nama_file_foto = $pegawai['foto'];
    $nama_file_ttd = $pegawai['ttd_image']; // Ambil nama ttd lama

    // Logika upload foto profil
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $target_dir_foto = "../uploads/";
        $ext_foto = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        $nama_file_foto_baru = "foto_".$nip.".".$ext_foto;
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir_foto . $nama_file_foto_baru)) {
            $nama_file_foto = $nama_file_foto_baru;
        }
    }

    // BARU: Logika upload gambar tanda tangan
    if (isset($_FILES['ttd']) && $_FILES['ttd']['error'] == 0) {
        $target_dir_ttd = "../uploads/ttd/";
        $ext_ttd = strtolower(pathinfo($_FILES["ttd"]["name"], PATHINFO_EXTENSION));
        $nama_file_ttd_baru = "ttd_".$nip.".".$ext_ttd;
        if (move_uploaded_file($_FILES["ttd"]["tmp_name"], $target_dir_ttd . $nama_file_ttd_baru)) {
            $nama_file_ttd = $nama_file_ttd_baru;
        }
    }

    // Query update dengan kolom baru
    $query_update = "UPDATE pegawai SET 
                        nama_lengkap = '$nama_lengkap', nip = '$nip', id_jabatan = '$id_jabatan', 
                        id_golongan = $id_golongan, id_atasan = $id_atasan, 
                        foto = '$nama_file_foto', ttd_image = '$nama_file_ttd'
                    WHERE id = $id";

    if (mysqli_query($koneksi, $query_update)) {
        $_SESSION['pesan'] = "Data pegawai berhasil diperbarui.";
        header('Location: manajemen_pegawai.php');
        exit();
    } else {
        $error = "Gagal mengupdate data: " . mysqli_error($koneksi);
    }
}

// Ambil data untuk dropdown (tetap sama)
$query_semua_pegawai = "SELECT id, nama_lengkap FROM pegawai WHERE id != $id ORDER BY nama_lengkap ASC";
$result_semua_pegawai = mysqli_query($koneksi, $query_semua_pegawai);
$query_jabatan = "SELECT * FROM jabatan ORDER BY id ASC";
$result_jabatan = mysqli_query($koneksi, $query_jabatan);
$query_golongan = "SELECT * FROM golongan ORDER BY id DESC";
$result_golongan = mysqli_query($koneksi, $query_golongan);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Pegawai - SIKEP</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f7f6; }
        .container { width: 80%; margin: 20px auto; background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, .form-group select { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .btn-group { margin-top: 20px; }
        .btn { padding: 10px 15px; text-decoration: none; border-radius: 5px; border: none; cursor: pointer; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .message.error { padding: 10px; margin-bottom: 15px; border-radius: 5px; background-color: #f8d7da; color: #721c24; }
    </style>
</head></head>
<body>
    <div class="container">
        <h1>Edit Data Pegawai</h1>
        <hr>
        <?php if (!empty($error)) { echo "<div class='message error'>$error</div>"; } ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($pegawai['nama_lengkap']); ?>" required>
            </div>
            <div class="form-group">
                <label for="nip">NIP</label>
                <input type="text" id="nip" name="nip" value="<?php echo htmlspecialchars($pegawai['nip']); ?>" required>
            </div>
            <div class="form-group">
                <label for="id_jabatan">Jabatan</label>
                <select name="id_jabatan" id="id_jabatan" required>
                    <option value="">-- Pilih Jabatan --</option>
                    <?php while($jabatan = mysqli_fetch_assoc($result_jabatan)): ?>
                        <option value="<?php echo $jabatan['id']; ?>" <?php if($pegawai['id_jabatan'] == $jabatan['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($jabatan['nama_jabatan']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_golongan">Pangkat / Gol. Ruang</label>
                <select name="id_golongan" id="id_golongan">
                    <option value="">-- Pilih Golongan --</option>
                    <?php while($golongan = mysqli_fetch_assoc($result_golongan)): ?>
                        <option value="<?php echo $golongan['id']; ?>" <?php if($pegawai['id_golongan'] == $golongan['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($golongan['nama_golongan']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="foto">Foto Pegawai</label>
                <?php if ($pegawai['foto']): ?>
                    <p><img src="../uploads/<?php echo htmlspecialchars($pegawai['foto']); ?>" width="100" alt="Foto"></p>
                <?php endif; ?>
                <input type="file" id="foto" name="foto">
                <small>Kosongkan jika tidak ingin mengubah foto.</small>
            </div>
            <div class="form-group">
                <label for="ttd">Gambar Tanda Tangan (PNG)</label>
                <?php if ($pegawai['ttd_image']): ?>
                    <p><img src="../uploads/ttd/<?php echo htmlspecialchars($pegawai['ttd_image']); ?>" width="150" alt="Tanda Tangan"></p>
                <?php endif; ?>
                <input type="file" id="ttd" name="ttd" accept="image/png">
                <small>Kosongkan jika tidak ingin mengubah TTD. Disarankan file .PNG dengan background transparan.</small>
            </div>
            <div class="form-group">
                <label for="id_atasan">Atasan Langsung</label>
                <select name="id_atasan" id="id_atasan">
                    <option value="">-- Tidak Ada Atasan --</option>
                    <?php while($atasan = mysqli_fetch_assoc($result_semua_pegawai)): ?>
                        <option value="<?php echo $atasan['id']; ?>" <?php if($pegawai['id_atasan'] == $atasan['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($atasan['nama_lengkap']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Update Data</button>
                <a href="manajemen_pegawai.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>