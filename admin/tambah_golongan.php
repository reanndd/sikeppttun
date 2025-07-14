<?php
// Gunakan header.php untuk layout yang konsisten
$page_title = "Tambah Golongan";
$current_page = "golongan"; // Agar menu 'Manajemen Golongan' tetap aktif
include 'header.php';

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil dan bersihkan input
    $nama_golongan = mysqli_real_escape_string($koneksi, $_POST['nama_golongan']);

    // Pastikan input tidak kosong
    if (!empty($nama_golongan)) {
        // Query untuk memasukkan data baru
        $query = "INSERT INTO golongan (nama_golongan) VALUES ('$nama_golongan')";
        
        if (mysqli_query($koneksi, $query)) {
            // Jika berhasil, set pesan sukses dan redirect
            $_SESSION['pesan'] = "Golongan baru berhasil ditambahkan.";
            header('Location: manajemen_golongan.php');
            exit();
        } else {
            // Jika gagal, tampilkan error
            $error = "Gagal menambahkan data: " . mysqli_error($koneksi);
        }
    } else {
        $error = "Nama Golongan tidak boleh kosong.";
    }
}
?>

<h1>Tambah Golongan Baru</h1>
<p>Masukkan nama Pangkat/Golongan Ruang yang baru.</p>
<hr>

<?php
// Tampilkan pesan error jika ada
if (isset($error)) {
    echo "<div class='alert error'>" . $error . "</div>";
}
?>

<form action="tambah_golongan.php" method="POST">
    <div class="form-group">
        <label for="nama_golongan">Nama Golongan/Pangkat</label>
        <input type="text" id="nama_golongan" name="nama_golongan" required>
    </div>
    <div class="btn-group">
        <button type="submit" class="btn">Simpan</button>
        <a href="manajemen_golongan.php" class="btn btn-secondary">Batal</a>
    </div>
</form>

<?php include 'footer.php'; ?>