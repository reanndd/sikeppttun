<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // Sesuaikan dengan password XAMPP Anda
$db   = 'db_sikep_pttun';

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
