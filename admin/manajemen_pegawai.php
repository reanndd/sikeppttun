<?php 
// 1. Definisikan variabel untuk judul halaman dan menu aktif
$page_title = "Manajemen Pegawai";
$current_page = "pegawai";

// 2. Panggil file header.php (yang berisi semua CSS)
include 'header.php'; 

// 3. Query untuk mengambil data pegawai
$query_pegawai_list = "SELECT p.id, p.nama_lengkap, p.nip, j.nama_jabatan, g.nama_golongan 
                       FROM pegawai p 
                       LEFT JOIN jabatan j ON p.id_jabatan = j.id
                       LEFT JOIN golongan g ON p.id_golongan = g.id";
if (isset($_GET['cari']) && $_GET['cari'] != '') {
    $cari = mysqli_real_escape_string($koneksi, $_GET['cari']);
    $query_pegawai_list .= " WHERE p.nama_lengkap LIKE '%$cari%' OR p.nip LIKE '%$cari%'";
}
$query_pegawai_list .= " ORDER BY p.id_jabatan ASC, p.nama_lengkap ASC";
$result_pegawai_list = mysqli_query($koneksi, $query_pegawai_list);
?>

<h1>Manajemen Pegawai</h1>
<p>Halaman ini digunakan untuk mengelola data seluruh pegawai.</p>
<hr>

<?php
if (isset($_SESSION['pesan'])) {
    // Pastikan class .alert dan .success ada di CSS header.php
    echo "<div class='alert success'>" . $_SESSION['pesan'] . "</div>";
    unset($_SESSION['pesan']);
}
?>

<a href="tambah_pegawai.php" class="btn">Tambah Pegawai Baru</a>

<h3>Daftar Pegawai</h3>
<div class="search-form">
    <form action="" method="GET" style="display: contents;">
        <input type="text" name="cari" placeholder="Cari nama atau NIP..." value="<?php echo isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>">
        <button type="submit">Cari</button>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Lengkap</th>
            <th>NIP</th>
            <th>Jabatan</th>
            <th>Pangkat/Gol</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1;
        if (mysqli_num_rows($result_pegawai_list) > 0) {
            while ($data = mysqli_fetch_assoc($result_pegawai_list)) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td><a href='detail_pegawai.php?id=" . $data['id'] . "'>" . htmlspecialchars($data['nama_lengkap']) . "</a></td>";
                echo "<td>" . htmlspecialchars($data['nip']) . "</td>";
                echo "<td>" . htmlspecialchars($data['nama_jabatan']) . "</td>";
                echo "<td>" . htmlspecialchars($data['nama_golongan']) . "</td>";
                echo "<td class='actions'>";
                if ($_SESSION['role'] == 'admin') {
                    echo "<a href='edit_pegawai.php?id=" . $data['id'] . "' class='edit'>Edit</a>";
                    echo "<a href='hapus_pegawai.php?id=" . $data['id'] . "' class='delete' onclick='return confirm(\"Yakin?\");'>Hapus</a>";
                } else {
                    echo "-";
                }
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6' style='text-align:center;'>Data tidak ditemukan.</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php 
// 4. Panggil file footer.php
include 'footer.php'; 
?>