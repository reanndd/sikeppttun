<?php 
$page_title = "Manajemen Pengumuman";
$current_page = "pengumuman";
include 'header.php'; 

if ($_SESSION['role'] != 'admin') { die("Akses ditolak."); }

$query = "SELECT * FROM pengumuman ORDER BY tanggal_dibuat DESC";
$result = mysqli_query($koneksi, $query);
?>

<h1>Manajemen Pengumuman</h1>
<p>Halaman ini untuk menambah atau mengelola pengumuman yang akan tampil di dasbor pegawai.</p>
<hr>

<a href="tambah_pengumuman.php" class="btn">Buat Pengumuman Baru</a>

<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Judul</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td width="20%"><?php echo date('d M Y H:i', strtotime($row['tanggal_dibuat'])); ?></td>
                    <td><?php echo htmlspecialchars($row['judul']); ?></td>
                    <td class="actions" width="15%">
                        <a href="edit_pengumuman.php?id=<?php echo $row['id']; ?>" class="edit">Edit</a>
                        <a href="hapus_pengumuman.php?id=<?php echo $row['id']; ?>" class="delete" onclick="return confirm('Anda yakin ingin menghapus pengumuman ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="3" style="text-align:center;">Belum ada pengumuman.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>