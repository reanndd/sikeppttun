<?php 
$page_title = "Edit Role Pengguna";
$current_page = "akun";
include 'header.php'; 

// Hanya admin yang bisa akses
if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak.");
}

// Validasi ID user dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: manajemen_user.php');
    exit();
}
$id_user = $_GET['id'];

// Ambil data user yang akan diedit
$query_data = "SELECT id, username, role, nama FROM users WHERE id = $id_user";
$result_data = mysqli_query($koneksi, $query_data);
$user = mysqli_fetch_assoc($result_data);

// Jika user tidak ditemukan, kembali ke halaman manajemen
if (!$user) {
    header('Location: manajemen_user.php');
    exit();
}

// Proses form saat disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_role = mysqli_real_escape_string($koneksi, $_POST['role']);
    
    // Pastikan role yang dipilih valid
    if (in_array($new_role, ['admin', 'ketua', 'pegawai'])) {
        $query_update = "UPDATE users SET role = '$new_role' WHERE id = $id_user";
        if (mysqli_query($koneksi, $query_update)) {
            $_SESSION['pesan'] = "Role untuk pengguna " . htmlspecialchars($user['username']) . " berhasil diperbarui.";
            header('Location: manajemen_user.php');
            exit();
        } else {
            $error = "Gagal memperbarui role.";
        }
    } else {
        $error = "Role yang dipilih tidak valid.";
    }
}
?>

<h1>Edit Role Pengguna</h1>
<p>Mengubah wewenang untuk pengguna: <strong><?php echo htmlspecialchars($user['username']); ?></strong></p>
<hr>

<?php if (isset($error)) { echo "<div class='alert error'>$error</div>"; } ?>

<form action="" method="POST">
    <div class="form-group">
        <label>Username</label>
        <input type="text" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
    </div>
    <div class="form-group">
        <label>Nama Pegawai Terkait</label>
        <input type="text" value="<?php echo htmlspecialchars($user['nama'] ?: '-'); ?>" disabled>
    </div>
    <div class="form-group">
        <label for="role">Peran (Role)</label>
        <select name="role" id="role" required>
            <option value="pegawai" <?php if($user['role'] == 'pegawai') echo 'selected'; ?>>Pegawai</option>
            <option value="ketua" <?php if($user['role'] == 'ketua') echo 'selected'; ?>>Ketua</option>
        </select>
    </div>
    <div class="btn-group">
        <button type="submit" class="btn">Update Role</button>
        <a href="manajemen_user.php" class="btn btn-secondary">Batal</a>
    </div>
</form>

<?php include 'footer.php'; ?>