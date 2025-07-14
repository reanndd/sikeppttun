<?php
session_start();
include '../koneksi.php';

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
    <style>
        body { font-family: sans-serif; margin: 20px; background-color: #f4f7f6; }
        .container { max-width: 1000px; margin: auto; background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        .btn { display: inline-block; padding: 10px 15px; text-decoration: none; border-radius: 5px; color: white; background-color: #007bff; }
        .btn-secondary { background-color: #6c757d; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; color: white; font-weight: bold; }
        .alert.success { background-color: #28a745; }
    </style>
</head>
<body>
<div class="container">
    <h1>Persetujuan Cuti Bawahan</h1>
    <p>Daftar pengajuan cuti dari bawahan yang memerlukan persetujuan Anda.</p>
    <a href="index.php" class="btn btn-secondary" style="margin-bottom: 20px;">Kembali ke Dasbor</a>
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
                <?php while($cuti = mysqli_fetch_assoc($result)): ?>
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
                <tr><td colspan="5" style="text-align:center;">Tidak ada pengajuan cuti yang perlu diproses.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>