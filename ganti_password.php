<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

$username = $_SESSION['username'];
$error = '';
$sukses = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password_lama = mysqli_real_escape_string($koneksi, $_POST['password_lama']);
    $password_baru = mysqli_real_escape_string($koneksi, $_POST['password_baru']);
    $konfirmasi_password = mysqli_real_escape_string($koneksi, $_POST['konfirmasi_password']);

    if (empty($password_lama) || empty($password_baru) || empty($konfirmasi_password)) {
        $error = "Semua kolom wajib diisi.";
    } elseif ($password_baru != $konfirmasi_password) {
        $error = "Konfirmasi password baru tidak cocok.";
    } else {
        $query_cek = "SELECT password FROM users WHERE username = '$username'";
        $result_cek = mysqli_query($koneksi, $query_cek);
        $user_data = mysqli_fetch_assoc($result_cek);

        if ($user_data && password_verify($password_lama, $user_data['password'])) {
            $password_baru_hashed = password_hash($password_baru, PASSWORD_DEFAULT);
            $query_update = "UPDATE users SET password = '$password_baru_hashed' WHERE username = '$username'";
        if (mysqli_query($koneksi, $query_update)) {
            $_SESSION['pesan'] = "Password Anda berhasil diperbarui.";
            $redirect_url = ($_SESSION['role'] == 'pegawai') ? 'pegawai/index.php' : 'admin/index.php';
            header('Location: ' . $redirect_url);
            exit();
            
        } else {
            $error = "Terjadi kesalahan saat memperbarui password.";
        }
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ganti Password - SIKEP</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .container { width: 100%; max-width: 450px; background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #333; margin-top: 0; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .btn-group { margin-top: 20px; display: flex; gap: 10px; }
        .btn { flex: 1; padding: 12px; text-decoration: none; border-radius: 5px; border: none; cursor: pointer; text-align: center; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .message { padding: 10px; margin-bottom: 15px; border-radius: 5px; font-weight: bold; }
        .message.error { background-color: #f8d7da; color: #721c24; }
        .message.success { background-color: #d4edda; color: #155724; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ganti Password</h1>
        <hr>

        <?php if (!empty($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="ganti_password.php" method="POST">
            <div class="form-group">
                <label for="password_lama">Password Lama</label>
                <input type="password" id="password_lama" name="password_lama" required>
            </div>
            <div class="form-group">
                <label for="password_baru">Password Baru</label>
                <input type="password" id="password_baru" name="password_baru" required>
            </div>
            <div class="form-group">
                <label for="konfirmasi_password">Konfirmasi Password Baru</label>
                <input type="password" id="konfirmasi_password" name="konfirmasi_password" required>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?php echo ($_SESSION['role'] == 'pegawai') ? 'pegawai/index.php' : 'admin/index.php'; ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>