<?php
$page_title = "Edit Pengumuman";
$current_page = "pengumuman";
include 'header.php';

// Keamanan: Hanya admin yang bisa akses
if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak.");
}

// Validasi ID dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: manajemen_pengumuman.php');
    exit();
}
$id = $_GET['id'];

// Ambil data pengumuman yang akan diedit
$query_data = "SELECT * FROM pengumuman WHERE id = $id";
$result_data = mysqli_query($koneksi, $query_data);
$pengumuman = mysqli_fetch_assoc($result_data);

if (!$pengumuman) {
    header('Location: manajemen_pengumuman.php');
    exit();
}

// Proses form saat disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $isi = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $gambar_lama = $pengumuman['gambar']; // Simpan nama gambar lama

    if (!empty($judul) && !empty($isi)) {
        $nama_file_gambar = $gambar_lama; // Secara default gunakan gambar lama

        // Logika untuk upload gambar baru
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
            $target_dir = "../uploads/pengumuman/";
            $nama_file_baru = time() . "_" . basename($_FILES["gambar"]["name"]);
            $target_file = $target_dir . $nama_file_baru;

            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                // Jika upload berhasil, hapus gambar lama dari folder
                if ($gambar_lama && file_exists($target_dir . $gambar_lama)) {
                    unlink($target_dir . $gambar_lama);
                }
                $nama_file_gambar = $nama_file_baru; // Gunakan nama file baru
            } else {
                $error = "Gagal mengupload gambar baru.";
            }
        }

        // Jalankan query update hanya jika tidak ada error upload
        if (!isset($error)) {
            $query_update = "UPDATE pengumuman SET judul = '$judul', isi = '$isi', gambar = '$nama_file_gambar' WHERE id = $id";
            if (mysqli_query($koneksi, $query_update)) {
                $_SESSION['pesan'] = "Pengumuman berhasil diperbarui.";
                header('Location: manajemen_pengumuman.php');
                exit();
            } else {
                $error = "Gagal memperbarui data: " . mysqli_error($koneksi);
            }
        }
    } else {
        $error = "Judul dan Isi tidak boleh kosong.";
    }
}
?>

<h1>Edit Pengumuman</h1>
<hr>

<?php if (isset($error)): ?>
    <div class="alert error"><?php echo $error; ?></div>
<?php endif; ?>

<form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="judul">Judul Pengumuman</label>
        <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($pengumuman['judul']); ?>" required>
    </div>
    <div class="form-group">
        <label for="gambar">Gambar Header (Opsional)</label>
        <?php if ($pengumuman['gambar']): ?>
            <p>
                <img src="../uploads/pengumuman/<?php echo htmlspecialchars($pengumuman['gambar']); ?>" width="200" alt="Gambar Saat Ini">
                <br>
                <small>Gambar saat ini. Pilih file baru untuk menggantinya.</small>
            </p>
        <?php endif; ?>
        <input type="file" id="gambar" name="gambar" accept="image/jpeg, image/png">
        <small>Kosongkan jika tidak ingin mengubah gambar.</small>
    </div>
    <div class="form-group">
        <label for="isi">Isi Pengumuman</label>
        <textarea name="isi" id="isi" rows="10" required><?php echo htmlspecialchars($pengumuman['isi']); ?></textarea>
    </div>
    <div class="btn-group">
        <button type="submit" class="btn">Update Pengumuman</button>
        <a href="manajemen_pengumuman.php" class="btn btn-secondary">Batal</a>
    </div>
</form>

<?php include 'footer.php'; ?>