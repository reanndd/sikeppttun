<?php
// Gunakan header.php untuk layout yang konsisten
$page_title = "Edit Golongan";
$current_page = "golongan"; // Agar menu 'Manajemen Golongan' tetap aktif
include 'header.php';

// Cek keamanan: Hanya admin yang boleh akses
if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak. Anda tidak memiliki wewenang untuk mengakses halaman ini.");
}

// Validasi ID dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: manajemen_golongan.php');
    exit();
}
$id = $_GET['id'];

// Ambil data golongan yang akan diedit dari database
$query_data = "SELECT * FROM golongan WHERE id = $id";
$result_data = mysqli_query($koneksi, $query_data);
$golongan = mysqli_fetch_assoc($result_data);

// Jika data dengan ID tersebut tidak ditemukan, kembali ke halaman manajemen
if (!$golongan) {
    header('Location: manajemen_golongan.php');
    exit();
}

// Proses form saat disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_golongan = mysqli_real_escape_string($koneksi, $_POST['nama_golongan']);

    if (!empty($nama_golongan)) {
        // Query untuk update data
        $query_update = "UPDATE golongan SET nama_golongan = '$nama_golongan' WHERE id = $id";
        
        if (mysqli_query($koneksi, $query_update)) {
            $_SESSION['pesan'] = "Data golongan berhasil diperbarui.";
            header('Location: manajemen_golongan.php');
            exit();
        } else {
            $error = "Gagal memperbarui data: " . mysqli_error($koneksi);
        }
    } else {
        $error = "Nama Golongan tidak boleh kosong.";
    }
}
?>

<h1>Edit Golongan</h1>
<p>Ubah nama Pangkat/Golongan.</p>
<hr>

<?php
if (isset($error)) {
    // Pastikan class .alert dan .error ada di file CSS Anda
    echo "<div class='alert error'>" . $error . "</div>";
}
?>

<form action="edit_golongan.php?id=<?php echo $id; ?>" method="POST">
    <div class="form-group">
        <label for="nama_golongan">Nama Golongan/Pangkat</label>
        <input type="text" id="nama_golongan" name="nama_golongan" value="<?php echo htmlspecialchars($golongan['nama_golongan']); ?>" required>
    </div>
    <div class="btn-group">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="manajemen_golongan.php" class="btn btn-secondary">Batal</a>
    </div>
</form>

<?php include 'footer.php'; ?>