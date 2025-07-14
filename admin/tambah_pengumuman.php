<?php 
$page_title = "Tambah Pengumuman";
$current_page = "pengumuman";
include 'header.php'; 

if ($_SESSION['role'] != 'admin') { die("Akses ditolak."); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $isi = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $nama_file_gambar = null;

    if (!empty($judul) && !empty($isi)) {
        // Logika untuk upload gambar
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
            $target_dir = "../uploads/pengumuman/";
            // Buat folder jika belum ada
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }
            $nama_file_baru = time() . "_" . basename($_FILES["gambar"]["name"]);
            $target_file = $target_dir . $nama_file_baru;

            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                $nama_file_gambar = $nama_file_baru;
            }
        }

        // Query INSERT dengan kolom gambar
        $query = "INSERT INTO pengumuman (judul, isi, gambar) VALUES ('$judul', '$isi', '$nama_file_gambar')";
        if (mysqli_query($koneksi, $query)) {
            $_SESSION['pesan'] = "Pengumuman baru berhasil diterbitkan.";
            header('Location: manajemen_pengumuman.php');
            exit();
        } else {
            $error = "Gagal menyimpan: " . mysqli_error($koneksi);
        }
    } else {
        $error = "Judul dan Isi tidak boleh kosong.";
    }
}
?>

<h1>Buat Pengumuman Baru</h1>
<hr>
<?php if (isset($error)) { echo "<div class='alert error'>$error</div>"; } ?>

<form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="judul">Judul Pengumuman</label>
        <input type="text" id="judul" name="judul" required>
    </div>
    <div class="form-group">
    <label for="gambar">Gambar Header (Opsional)</label>
    <input type="file" id="gambar" name="gambar" accept="image/jpeg, image/png">
    <small>Pilih gambar jika ingin menampilkan header pada pengumuman.</small>
    </div>
    <div class="form-group">
        <label for="isi">Isi Pengumuman</label>
        <textarea name="isi" id="isi" rows="10" required></textarea>
    </div>
    <div class="btn-group">
        <button type="submit" class="btn">Terbitkan</button>
        <a href="manajemen_pengumuman.php" class="btn btn-secondary">Batal</a>
    </div>
</form>

<?php include 'footer.php'; ?>