<?php
include '../koneksi.php';
include 'header.php';

// Keamanan: Hanya pegawai yang bisa akses
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'pegawai') {
    header('Location: ../index.php');
    exit();
}

// Validasi ID dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: persetujuan_atasan.php');
    exit();
}
$id_cuti = $_GET['id'];
$id_atasan_session = $_SESSION['id_pegawai'];

// Proses form saat tombol persetujuan/penolakan ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status_baru = $_POST['status'];
    $catatan = mysqli_real_escape_string($koneksi, $_POST['catatan_atasan']);

    // Pastikan status yang di-submit valid
    if ($status_baru == 'Disetujui Atasan' || $status_baru == 'Ditolak Atasan') {
        $query_update = "UPDATE pengajuan_cuti SET 
                    status = '$status_baru', 
                    catatan_atasan = '$catatan', 
                    disetujui_oleh_atasan_id = '$id_atasan_session',
                    tanggal_disetujui_atasan = NOW() 
                 WHERE id = '$id_cuti'";
        if (mysqli_query($koneksi, $query_update)) {
            $_SESSION['pesan'] = "Persetujuan cuti berhasil diproses.";
            header('Location: persetujuan_atasan.php');
            exit();
        } else {
            $error = "Gagal memproses data.";
        }
    } else {
        $error = "Aksi tidak valid.";
    }
}

// Ambil data cuti untuk ditampilkan
$query = "SELECT pc.*, p.nama_lengkap, p.nip, j.nama_jabatan 
          FROM pengajuan_cuti pc 
          JOIN pegawai p ON pc.id_pegawai = p.id
          LEFT JOIN jabatan j ON p.id_jabatan = j.id
          WHERE pc.id = '$id_cuti' AND p.id_atasan = '$id_atasan_session' AND pc.status = 'Diajukan'";
$result = mysqli_query($koneksi, $query);
$cuti = mysqli_fetch_assoc($result);

if (!$cuti) {
    die("Data tidak ditemukan atau Anda tidak memiliki wewenang untuk memproses pengajuan ini.");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Proses Persetujuan Cuti - SIKEP</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f4f7f6;
            margin: 20px;
        }

        .container {
            width: 80%;
            margin: auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1,
        h3 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        td:first-child {
            font-weight: bold;
            width: 30%;
            background-color: #f9f9f9;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            min-height: 100px;
        }

        .btn-group {
            margin-top: 20px;
        }

        .btn {
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            color: white;
            margin-right: 10px;
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .message.error {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Proses Persetujuan Cuti</h1>
        <a href="persetujuan_atasan.php" class="btn btn-secondary">Kembali</a>
        <hr>

        <h3>Detail Pengajuan</h3>
        <table>
            <tr>
                <td><strong>Nama Pemohon</strong></td>
                <td><?php echo htmlspecialchars($cuti['nama_lengkap']); ?></td>
            </tr>
            <tr>
                <td><strong>NIP</strong></td>
                <td><?php echo htmlspecialchars($cuti['nip']); ?></td>
            </tr>
            <tr>
                <td><strong>Jabatan</strong></td>
                <td><?php echo htmlspecialchars($cuti['nama_jabatan']); ?></td>
            </tr>
            <tr>
                <td><strong>Jenis Cuti</strong></td>
                <td><?php echo htmlspecialchars($cuti['jenis_cuti']); ?></td>
            </tr>
            <tr>
                <td><strong>Tanggal Cuti</strong></td>
                <td><?php echo date('d M Y', strtotime($cuti['tanggal_mulai'])) . " s/d " . date('d M Y', strtotime($cuti['tanggal_selesai'])); ?></td>
            </tr>
            <tr>
                <td><strong>Alasan</strong></td>
                <td><?php echo nl2br(htmlspecialchars($cuti['keterangan'])); ?></td>
            </tr>
        </table>

        <hr>
        <h3>Formulir Keputusan</h3>
        <?php if (isset($error)) {
            echo "<div class='message error'>$error</div>";
        } ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="catatan_atasan">Catatan / Alasan (Opsional)</label>
                <textarea name="catatan_atasan" id="catatan_atasan" rows="4" placeholder="Berikan catatan jika ada..."></textarea>
            </div>
            <div class="btn-group">
                <button type="submit" name="status" value="Disetujui Atasan" class="btn btn-success" onclick="return confirm('Anda yakin ingin MENYETUJUI pengajuan ini?');">Setujui</button>
                <button type="submit" name="status" value="Ditolak Atasan" class="btn btn-danger" onclick="return confirm('Anda yakin ingin MENOLAK pengajuan ini?');">Tolak</button>
            </div>
        </form>
    </div>
</body>

</html>

<?php
include 'footer.php';
?>