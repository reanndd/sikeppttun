<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    die("Akses ditolak.");
}

$query_jabatan = "SELECT * FROM jabatan ORDER BY id ASC";
$result_jabatan = mysqli_query($koneksi, $query_jabatan);

$query_golongan = "SELECT * FROM golongan ORDER BY id DESC";
$result_golongan = mysqli_query($koneksi, $query_golongan);

$query_semua_pegawai = "SELECT id, nama_lengkap FROM pegawai ORDER BY nama_lengkap ASC";
$result_semua_pegawai = mysqli_query($koneksi, $query_semua_pegawai);

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $nip = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $id_jabatan = mysqli_real_escape_string($koneksi, $_POST['id_jabatan']);

    $id_golongan = !empty($_POST['id_golongan']) ? "'" . mysqli_real_escape_string($koneksi, $_POST['id_golongan']) . "'" : "NULL";
    $id_atasan = !empty($_POST['id_atasan']) ? "'" . mysqli_real_escape_string($koneksi, $_POST['id_atasan']) . "'" : "NULL";

    if (!empty($nama_lengkap) && !empty($nip)) {
        $query_cek_nip = "SELECT nip FROM pegawai WHERE nip = '$nip'";
        $hasil_cek = mysqli_query($koneksi, $query_cek_nip);

        if (mysqli_num_rows($hasil_cek) > 0) {
            $error = "NIP sudah terdaftar.";
        } else {
            $query_insert_pegawai = "INSERT INTO pegawai (nama_lengkap, nip, id_jabatan, id_golongan, id_atasan) 
                                     VALUES ('$nama_lengkap', '$nip', '$id_jabatan', $id_golongan, $id_atasan)";

            if (mysqli_query($koneksi, $query_insert_pegawai)) {
                $id_pegawai_baru = mysqli_insert_id($koneksi);
                $username_baru = $nip;
                $password_default = "123456";
                $role_pegawai = "pegawai";
                $password_hashed = password_hash($password_default, PASSWORD_DEFAULT);
                $query_insert_user = "INSERT INTO users (username, password, role, id_pegawai, nama) 
                                    VALUES ('$username_baru', '$password_hashed', '$role_pegawai', '$id_pegawai_baru', '$nama_lengkap')";
                if (mysqli_query($koneksi, $query_insert_user)) {
                    // Jika berhasil, siapkan pesan sukses dan redirect
                    $_SESSION['pesan'] = "Data pegawai baru & akun login berhasil dibuat.";
                    header('Location: manajemen_pegawai.php');
                    exit();
                } else {
                    // Jika gagal, siapkan pesan error
                    $error = "Data pegawai berhasil disimpan, tapi gagal membuat akun user.";
                }
            } else {
                $error = "Gagal menyimpan data pegawai: " . mysqli_error($koneksi);
            }
        }
    } else {
        $error = "Nama Lengkap dan NIP wajib diisi!";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Tambah Pegawai - SIKEP</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f4f7f6;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
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
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Tambah Data Pegawai Baru</h1>
        <hr>
        <?php if (!empty($error)) {
            echo "<div class='message error'>$error</div>";
        } ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" required>
            </div>
            <div class="form-group">
                <label for="nip">NIP</label>
                <input type="text" id="nip" name="nip" required>
            </div>
            <div class="form-group">
                <label for="id_jabatan">Jabatan</label>
                <select name="id_jabatan" id="id_jabatan" required>
                    <option value="">-- Pilih Jabatan --</option>
                    <?php while ($jabatan = mysqli_fetch_assoc($result_jabatan)): ?>
                        <option value="<?php echo $jabatan['id']; ?>"><?php echo htmlspecialchars($jabatan['nama_jabatan']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_golongan">Pangkat / Gol. Ruang</label>
                <select name="id_golongan" id="id_golongan">
                    <option value="">-- Pilih Golongan --</option>
                    <?php while ($golongan = mysqli_fetch_assoc($result_golongan)): ?>
                        <option value="<?php echo $golongan['id']; ?>"><?php echo htmlspecialchars($golongan['nama_golongan']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_atasan">Atasan Langsung</label>
                <select name="id_atasan" id="id_atasan">
                    <option value="">-- Tidak Ada Atasan --</option>
                    <?php while ($atasan = mysqli_fetch_assoc($result_semua_pegawai)): ?>
                        <option value="<?php echo $atasan['id']; ?>"><?php echo htmlspecialchars($atasan['nama_lengkap']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Simpan Data</button>
                <a href="manajemen_pegawai.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>

</html>