<?php 
// Variabel ini digunakan oleh header.php untuk judul halaman dan menandai menu aktif
$page_title = "Manajemen Golongan";
$current_page = "golongan";
include 'header.php'; 

// Query untuk mengambil semua data golongan
$query = "SELECT * FROM golongan ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);
?>

<h1>Manajemen Data Master Golongan</h1>
<p>Halaman ini digunakan untuk mengelola data master Pangkat/Golongan Ruang.</p>

<hr>

<?php
// Tampilkan pesan sukses jika ada
if (isset($_SESSION['pesan'])) {
    echo "<div class='alert success'>" . $_SESSION['pesan'] . "</div>";
    unset($_SESSION['pesan']);
}
?>

<a href="tambah_golongan.php" class="btn">Tambah Golongan Baru</a>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Golongan/Pangkat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) > 0): $no = 1; ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($row['nama_golongan']); ?></td>
                    <td class="actions">
                        <a href="edit_golongan.php?id=<?php echo $row['id']; ?>" class="edit">Edit</a>
                        <a href="hapus_golongan.php?id=<?php echo $row['id']; ?>" class="delete" onclick="return confirm('Yakin ingin menghapus golongan ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="3" style="text-align:center;">Belum ada data golongan.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>