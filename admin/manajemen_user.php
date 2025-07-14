<?php 
// Definisikan variabel untuk header
$page_title = "Manajemen Akun";
$current_page = "akun";
include 'header.php'; 

// Hanya admin yang boleh mengakses halaman ini
if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak. Anda tidak memiliki wewenang untuk mengakses halaman ini.");
}

// Query untuk mengambil semua data pengguna, diurutkan berdasarkan ID terbaru
$query = "SELECT u.id, u.username, u.role, p.nama_lengkap 
          FROM users u 
          LEFT JOIN pegawai p ON u.id_pegawai = p.id 
          ORDER BY u.id ASC";
$result = mysqli_query($koneksi, $query);
?>

<h1>Manajemen Akun Pengguna</h1>
<p>Kelola akun login, peran, dan password untuk semua pengguna sistem.</p>
<hr>

<?php
if (isset($_SESSION['pesan'])) {
    echo "<div class='alert success'>" . htmlspecialchars($_SESSION['pesan']) . "</div>";
    unset($_SESSION['pesan']);
}
if (isset($_SESSION['error'])) {
    echo "<div class='alert error'>" . htmlspecialchars($_SESSION['error']) . "</div>";
    unset($_SESSION['error']);
}
?>

<table>
    <thead>
        <tr>
            <th>Username</th>
            <th>Nama Pegawai Terkait</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while($user = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($user['username']); ?></strong></td>
                    <td><?php echo htmlspecialchars($user['nama_lengkap'] ?: '<em>(Akun Sistem)</em>'); ?></td>
                    <td><?php echo strtoupper(htmlspecialchars($user['role'])); ?></td>
                    <td class="actions">
                        <?php
                        // Admin tidak bisa mengedit atau me-reset password admin lain untuk keamanan
                        if ($user['role'] != 'admin'): 
                        ?>
                            <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="edit">Edit Role</a>
                            <a href="reset_password_user.php?id=<?php echo $user['id']; ?>" class="delete" onclick="return confirm('Anda yakin ingin me-reset password pengguna ini menjadi default (123456)?');">Reset Password</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4" style="text-align:center;">Belum ada data pengguna.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>