<?php
include '../koneksi.php';
include 'header.php';

// Keamanan: Hanya pegawai yang bisa akses
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'pegawai') {
    header('Location: ../index.php');
    exit();
}

$id_atasan_session = $_SESSION['id_pegawai'];

// Query untuk mengambil pengajuan dari bawahan langsung yang masih berstatus "Diajukan"
$query = "SELECT pc.*, p.nama_lengkap, p.nip 
          FROM pengajuan_cuti pc 
          JOIN pegawai p ON pc.id_pegawai = p.id 
          WHERE p.id_atasan = '$id_atasan_session' AND pc.status = 'Diajukan'
          ORDER BY pc.tanggal_pengajuan DESC";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Persetujuan Cuti Bawahan - SIKEP</title>

<body>
    <div class="container">
        <h1>Persetujuan Cuti Bawahan</h1>
        <p>Daftar pengajuan cuti dari bawahan yang memerlukan persetujuan Anda.</p>
        <a href="index.php" class="btn btn-secondary" style="margin-bottom: 20px;">Kembali ke Dashboard</a>
        <hr>

        <?php
        if (isset($_SESSION['pesan'])) {
            echo "<div class='alert success'>" . $_SESSION['pesan'] . "</div>";
            unset($_SESSION['pesan']);
        }
        ?>

        <table>
            <thead>
                <tr>
                    <th>Nama Pemohon</th>
                    <th>NIP</th>
                    <th>Jenis Cuti</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($cuti = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cuti['nama_lengkap']); ?></td>
                            <td><?php echo htmlspecialchars($cuti['nip']); ?></td>
                            <td><?php echo htmlspecialchars($cuti['jenis_cuti']); ?></td>
                            <td><?php echo date('d M Y', strtotime($cuti['tanggal_mulai'])) . " - " . date('d M Y', strtotime($cuti['tanggal_selesai'])); ?></td>
                            <td>
                                <a href="aksi_persetujuan.php?id=<?php echo $cuti['id']; ?>" class="btn">Proses</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">Tidak ada pengajuan cuti yang perlu diproses.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
include 'footer.php';
?>