<?php 
// Variabel ini digunakan oleh header.php untuk judul halaman dan menandai menu aktif
$page_title = "Manajemen Jabatan";
$current_page = "jabatan";
include 'header.php'; 

// Query untuk mengambil semua data jabatan
$query = "SELECT * FROM jabatan ORDER BY id ASC";
$result = mysqli_query($koneksi, $query);
?>

<h1>Manajemen Data Master Jabatan</h1>
<p>Halaman ini digunakan untuk mengelola data master jabatan yang tersedia di sistem.</p>

<hr>

<?php
// Tampilkan pesan sukses jika ada
if (isset($_SESSION['pesan'])) {
    echo "<div class='alert success'>" . htmlspecialchars($_SESSION['pesan']) . "</div>";
    unset($_SESSION['pesan']);
}
?>

<a href="tambah_jabatan.php" class="btn">Tambah Jabatan Baru</a>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Jabatan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) > 0): $no = 1; ?>
            <?php while($jabatan = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($jabatan['nama_jabatan']); ?></td>
                    <td class="actions">
                        <a href="edit_jabatan.php?id=<?php echo $jabatan['id']; ?>" class="edit">Edit</a>
                        <a href="hapus_jabatan.php?id=<?php echo $jabatan['id']; ?>" class="delete" onclick="return confirm('Yakin ingin menghapus jabatan ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="3" style="text-align:center;">Belum ada data jabatan.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>