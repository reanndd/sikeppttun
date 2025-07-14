<?php
session_start();
include 'koneksi.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // 1. Ambil data user hanya berdasarkan username
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    // 2. Cek apakah username ditemukan
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // 3. Verifikasi password yang di-input dengan hash di database
        if (password_verify($password, $user['password'])) {
            // Jika password cocok, buat session dan redirect
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['id_pegawai'] = $user['id_pegawai'];

            if ($user['role'] == 'admin' || $user['role'] == 'ketua') {
                header('Location: admin/index.php');
            } else {
                header('Location: pegawai/index.php');
            }
            exit();
        } else {
            // Jika password tidak cocok
            $error = 'Username atau Password salah!';
        }
    } else {
        // Jika username tidak ditemukan
        $error = 'Username atau Password salah!';
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login - SIKEP</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            width: 100%;
            max-width: 450px;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-top: 0;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-group {
            margin-top: 20px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            text-align: center;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .message.error {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-weight: bold;
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>LOGIN SIKEP</h1>
        <hr>
        <?php if (!empty($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
</body>

</html>