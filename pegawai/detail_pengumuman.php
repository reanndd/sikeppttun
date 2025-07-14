<?php 
$page_title = "Detail Pengumuman";
$current_page = ""; // Tidak perlu menu aktif
include 'header.php'; 

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit();
}
$id = $_GET['id'];

$query = "SELECT * FROM pengumuman WHERE id = $id";
$result = mysqli_query($koneksi, $query);
$pengumuman = mysqli_fetch_assoc($result);

if(!$pengumuman) {
    echo "<h1>Pengumuman tidak ditemukan.</h1>";
    include 'footer.php';
    exit();
}
?>

<style>
    .post-header-image { width: 100%; max-height: 400px; object-fit: cover; border-radius: 8px; margin-bottom: 20px; }
    .post-meta { color: #6c757d; margin-bottom: 20px; }
    .post-content { line-height: 1.6; }
</style>

<div class="post-container">
    <?php if($pengumuman['gambar']): ?>
        <img src="../uploads/pengumuman/<?php echo htmlspecialchars($pengumuman['gambar']); ?>" alt="Gambar Pengumuman" class="post-header-image">
    <?php endif; ?>

    <h1><?php echo htmlspecialchars($pengumuman['judul']); ?></h1>
    <div class="post-meta">
        Diterbitkan pada: <?php echo date('d F Y', strtotime($pengumuman['tanggal_dibuat'])); ?>
    </div>
    <hr>
    <div class="post-content">
        <?php echo nl2br(htmlspecialchars($pengumuman['isi'])); ?>
    </div>
    <br>
    <a href="index.php" class="btn btn-secondary">Kembali ke Dasbor</a>
</div>


<?php include 'footer.php'; ?>