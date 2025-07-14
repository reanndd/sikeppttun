<?php
session_start();
include '../koneksi.php';

// Admin dan Ketua bisa mengakses halaman ini
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'ketua')) {
    header('Location: ../manajemen_pegawai.php');
    exit();
}

// Validasi ID pegawai dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: manajemen_pegawai.php');
    exit();
}
$id = $_GET['id'];

// Query utama untuk mengambil semua data terkait pegawai
$query_pegawai = "SELECT p.*, j.nama_jabatan, g.nama_golongan, atasan.nama_lengkap as nama_atasan
                  FROM pegawai p 
                  LEFT JOIN jabatan j ON p.id_jabatan = j.id
                  LEFT JOIN golongan g ON p.id_golongan = g.id
                  LEFT JOIN pegawai atasan ON p.id_atasan = atasan.id
                  WHERE p.id = $id";

$result_pegawai = mysqli_query($koneksi, $query_pegawai);
$pegawai = mysqli_fetch_assoc($result_pegawai);

if (!$pegawai) {
    die("Data pegawai tidak ditemukan.");
}

// Data Riwayat Jabatan
$query_jabatan_hist = "SELECT * FROM riwayat_jabatan WHERE id_pegawai = $id ORDER BY tmt_jabatan DESC";
$result_jabatan_hist = mysqli_query($koneksi, $query_jabatan_hist);

// Data Riwayat Pendidikan
$query_pendidikan = "SELECT * FROM riwayat_pendidikan WHERE id_pegawai = $id ORDER BY tahun_lulus DESC";
$result_pendidikan = mysqli_query($koneksi, $query_pendidikan);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Pegawai - <?php echo htmlspecialchars($pegawai['nama_lengkap']); ?></title>
    <style>
        body { font-family: sans-serif; background-color: #f4f7f6; margin: 20px; }
        .container { max-width: 900px; margin: auto; background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        h1, h2 { border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .detail-grid { display: flex; gap: 30px; margin-top: 20px; }
        .photo-section { flex: 1; }
        .data-section { flex: 2; }
        .photo-placeholder { width: 100%; height: 250px; background-color: #e9ecef; border: 1px dashed #ccc; display: flex; justify-content: center; align-items: center; color: #6c757d; border-radius: 8px; font-size: 16px; overflow: hidden; }
        .data-table { width: 100%; }
        .data-table td { padding: 8px 0; border-bottom: 1px solid #eee; }
        .data-table td:first-child { font-weight: bold; color: #555; width: 30%; }
        .btn-back { display: inline-block; margin-top: 30px; padding: 10px 20px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 5px; }
        .btn-add { padding: 8px 12px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; float: right; }
        .history-section { margin-top: 40px; }
        .history-table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 14px; }
        .history-table th, .history-table td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        .history-table th { background-color: #f2f2f2; }
        .actions a { margin-right: 10px; text-decoration: none; }
        .actions a.edit { color: #28a745; }
        .actions a.delete { color: #dc3545; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Detail Data Pegawai</h1>
        <div class="detail-grid">
            <div class="photo-section">
                <div class="photo-placeholder">
                    <?php if (!empty($pegawai['foto']) && file_exists('../uploads/' . $pegawai['foto'])): ?>
                        <img src="../uploads/<?php echo htmlspecialchars($pegawai['foto']); ?>" alt="Foto Pegawai" style="width:100%; height:100%; object-fit:cover;">
                    <?php else: ?>
                        <span>Foto Belum Ada</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="data-section">
                <table class="data-table">
                    <tr><td>Nama Lengkap</td><td>: <?php echo htmlspecialchars($pegawai['nama_lengkap']); ?></td></tr>
                    <tr><td>NIP</td><td>: <?php echo htmlspecialchars($pegawai['nip']); ?></td></tr>
                    <tr><td>Jabatan</td><td>: <?php echo htmlspecialchars($pegawai['nama_jabatan']); ?></td></tr>
                    <tr><td>Pangkat/Gol</td><td>: <?php echo htmlspecialchars($pegawai['nama_golongan']); ?></td></tr>
                    <tr><td>Unit Kerja</td><td>: <?php echo htmlspecialchars($pegawai['unit_kerja']); ?></td></tr>
                    <tr><td>Tanggal Lahir</td><td>: <?php echo date('d F Y', strtotime($pegawai['tanggal_lahir'])); ?></td></tr>
                    <tr><td>Atasan Langsung</td><td>: <?php echo htmlspecialchars($pegawai['nama_atasan'] ? $pegawai['nama_atasan'] : '-'); ?></td></tr>
                </table>
            </div>
        </div>

        <div class="history-section">
            <h2>Riwayat Jabatan <a href="tambah_riwayat.php?id_pegawai=<?php echo $id; ?>" class="btn-add">Tambah Riwayat</a></h2>
            <table class="history-table">
                <thead><tr><th>TMT Jabatan</th><th>Nama Jabatan</th><th>Nomor SK</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php if (mysqli_num_rows($result_jabatan_hist) > 0): ?>
                        <?php while($riwayat = mysqli_fetch_assoc($result_jabatan_hist)): ?>
                            <tr>
                                <td><?php echo date('d M Y', strtotime($riwayat['tmt_jabatan'])); ?></td>
                                <td><?php echo htmlspecialchars($riwayat['jabatan']); ?></td>
                                <td><?php echo htmlspecialchars($riwayat['nomor_sk']); ?></td>
                                <td class='actions'>
                                    <a href='edit_riwayat.php?id=<?php echo $riwayat['id']; ?>&id_pegawai=<?php echo $id; ?>' class='edit'>Edit</a>
                                    <a href='hapus_riwayat.php?id=<?php echo $riwayat['id']; ?>&id_pegawai=<?php echo $id; ?>' class='delete' onclick='return confirm("Yakin?");'>Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; // ## PERBAIKAN: endwhile; YANG HILANG DITAMBAHKAN DI SINI ## ?>
                    <?php else: ?>
                        <tr><td colspan='4' style='text-align:center;'>Belum ada data riwayat jabatan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="history-section">
            <h2>Riwayat Pendidikan <a href="tambah_pendidikan.php?id_pegawai=<?php echo $id; ?>" class="btn-add">Tambah Riwayat</a></h2>
            <table class="history-table">
                <thead><tr><th>Tahun Lulus</th><th>Tingkat</th><th>Institusi</th><th>Jurusan</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php if (mysqli_num_rows($result_pendidikan) > 0): ?>
                        <?php while($pendidikan = mysqli_fetch_assoc($result_pendidikan)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($pendidikan['tahun_lulus']); ?></td>
                                <td><?php echo htmlspecialchars($pendidikan['tingkat_pendidikan']); ?></td>
                                <td><?php echo htmlspecialchars($pendidikan['nama_institusi']); ?></td>
                                <td><?php echo htmlspecialchars($pendidikan['jurusan']); ?></td>
                                <td class='actions'>
                                    <a href='edit_pendidikan.php?id=<?php echo $pendidikan['id']; ?>&id_pegawai=<?php echo $id; ?>' class='edit'>Edit</a>
                                    <a href='hapus_pendidikan.php?id=<?php echo $pendidikan['id']; ?>&id_pegawai=<?php echo $id; ?>' class='delete' onclick='return confirm("Yakin?");'>Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan='5' style='text-align:center;'>Belum ada data riwayat pendidikan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <a href="manajemen_pegawai.php" class="btn-back">Kembali ke Dashboard</a>
    </div>
</body>
</html>