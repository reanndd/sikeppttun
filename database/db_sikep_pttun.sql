-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2025 at 06:59 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sikep_pttun`
--

-- --------------------------------------------------------

--
-- Table structure for table `golongan`
--

CREATE TABLE `golongan` (
  `id` int(11) NOT NULL,
  `nama_golongan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `golongan`
--

INSERT INTO `golongan` (`id`, `nama_golongan`) VALUES
(13, 'II/a'),
(12, 'II/b'),
(11, 'II/c'),
(10, 'II/d'),
(9, 'III/a'),
(8, 'III/b'),
(7, 'III/c'),
(6, 'III/d'),
(5, 'IV/a'),
(4, 'IV/b'),
(3, 'IV/c'),
(2, 'IV/d'),
(1, 'IV/e');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id` int(11) NOT NULL,
  `nama_jabatan` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id`, `nama_jabatan`) VALUES
(18, 'ANALIS - ANALIS PERKARA PERADILAN, PANITERA MUDA HUKUM'),
(19, 'ANALIS - ANALIS PERKARA PERADILAN, PANITERA MUDA PERKARA'),
(16, 'ANALIS PENGELOLAAN KEUANGAN APBN AHLI MADYA, BAGIAN UMUM DAN KEUANGAN'),
(23, 'ARSIPARIS TERAMPIL, SEKRETARIS'),
(3, 'HAKIM TINGGI'),
(11, 'JURUSITA PENGGANTI'),
(6, 'KEPALA BAGIAN PERENCANAAN DAN KEPEGAWAIAN'),
(8, 'KEPALA BAGIAN UMUM DAN KEUANGAN'),
(12, 'KEPALA SUBBAGIAN, SUBBAGIAN KEPEGAWAIAN DAN TEKNOLOGI INFORMASI'),
(14, 'KEPALA SUBBAGIAN, SUBBAGIAN KEUANGAN DAN PELAPORAN'),
(15, 'KEPALA SUBBAGIAN, SUBBAGIAN RENCANA PROGRAM DAN ANGGARAN'),
(13, 'KEPALA SUBBAGIAN, SUBBAGIAN TATA USAHA DAN RUMAH TANGGA'),
(1, 'KETUA'),
(26, 'MAGANG'),
(17, 'OPERATOR - PENATA LAPORAN OPERASIONAL, SUBBAGIAN KEPEGAWAIAN DAN TEKNOLOGI INFORMASI'),
(4, 'PANITERA'),
(7, 'PANITERA MUDA BANDING TIPE B, PANITERA MUDA PERKARA'),
(9, 'PANITERA MUDA HUKUM'),
(10, 'PANITERA PENGGANTI'),
(21, 'PENYAJI - PENYAJIAN DATA DAN INFORMASI, SUBBAGIAN KEPEGAWAIAN DAN TEKNOLOGI INFORMASI'),
(22, 'PRANATA KEARSIPAN APBN TERAMPIL, SEKRETARIS'),
(20, 'PRANATA KOMPUTER TERAMPIL, SEKRETARIS'),
(5, 'SEKRETARIS'),
(24, 'STAF PPNPN'),
(2, 'WAKIL KETUA');

-- --------------------------------------------------------

--
-- Table structure for table `jatah_cuti`
--

CREATE TABLE `jatah_cuti` (
  `id` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `tahun` int(4) NOT NULL,
  `jatah_awal` int(3) NOT NULL,
  `sisa_dibawa` int(3) NOT NULL DEFAULT 0 COMMENT 'Sisa cuti dari tahun lalu yang dibawa',
  `cuti_diambil` int(3) NOT NULL DEFAULT 0,
  `sisa_cuti` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `jatah_cuti`
--

INSERT INTO `jatah_cuti` (`id`, `id_pegawai`, `tahun`, `jatah_awal`, `sisa_dibawa`, `cuti_diambil`, `sisa_cuti`) VALUES
(1, 1, 2025, 12, 0, 0, 12),
(2, 2, 2025, 12, 0, 0, 12),
(3, 3, 2025, 12, 0, 0, 12),
(4, 4, 2025, 12, 0, 0, 12),
(5, 5, 2025, 12, 0, 0, 12),
(6, 6, 2025, 12, 0, 0, 12),
(7, 7, 2025, 12, 0, 0, 12),
(8, 8, 2025, 12, 0, 0, 12),
(9, 9, 2025, 12, 0, 0, 12),
(10, 10, 2025, 12, 0, 0, 12),
(11, 11, 2025, 12, 0, 0, 12),
(12, 12, 2025, 12, 0, 0, 12),
(13, 13, 2025, 12, 0, 0, 12),
(14, 14, 2025, 12, 0, 0, 12),
(15, 15, 2025, 12, 0, 0, 12),
(16, 16, 2025, 12, 0, 0, 12),
(17, 17, 2025, 12, 0, 0, 12),
(18, 18, 2025, 12, 0, 0, 12),
(19, 19, 2025, 12, 0, 0, 12),
(20, 20, 2025, 12, 0, 0, 12),
(21, 21, 2025, 12, 0, 0, 12),
(22, 22, 2025, 12, 0, 0, 12),
(23, 23, 2025, 12, 0, 0, 12),
(24, 24, 2025, 12, 0, 0, 12),
(25, 25, 2025, 12, 0, 0, 12),
(26, 26, 2025, 12, 0, 0, 12),
(27, 27, 2025, 12, 0, 0, 12),
(28, 28, 2025, 12, 0, 0, 12),
(29, 29, 2025, 12, 0, 0, 12),
(30, 30, 2025, 12, 0, 0, 12),
(31, 31, 2025, 12, 0, 0, 12),
(32, 32, 2025, 12, 0, 0, 12),
(33, 39, 2025, 12, 0, 0, 12),
(34, 33, 2025, 12, 0, 0, 12),
(35, 34, 2025, 12, 0, 0, 12),
(36, 35, 2025, 12, 0, 0, 12),
(37, 36, 2025, 12, 0, 0, 12),
(38, 37, 2025, 12, 0, 0, 12),
(39, 38, 2025, 12, 0, 0, 12),
(40, 40, 2025, 12, 0, 0, 12),
(41, 41, 2025, 12, 0, 0, 12),
(42, 42, 2025, 12, 0, 0, 12),
(43, 43, 2025, 12, 0, 0, 12),
(44, 44, 2025, 12, 0, 0, 12),
(45, 45, 2025, 12, 0, 0, 12),
(46, 46, 2025, 12, 0, 0, 12),
(47, 47, 2025, 12, 0, 0, 12),
(48, 48, 2025, 12, 0, 0, 12),
(49, 49, 2025, 12, 0, 3, 9);

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `id_jabatan` int(11) DEFAULT NULL,
  `id_golongan` int(11) DEFAULT NULL,
  `unit_kerja` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `id_atasan` int(11) DEFAULT NULL,
  `ttd_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `nama_lengkap`, `nip`, `id_jabatan`, `id_golongan`, `unit_kerja`, `tanggal_lahir`, `foto`, `id_atasan`, `ttd_image`) VALUES
(1, 'A. SYAIFULLAH, S.H.', '196108191986121001', 1, 1, NULL, NULL, 'foto_196108191986121001.jpg', NULL, 'ttd_196108191986121001.png'),
(2, 'AR. SETIYONO, S.H., M.H.', '196204121988031003', 2, 1, NULL, NULL, NULL, 1, NULL),
(3, 'Irhamto, S.H., M.H.', '196502231998031004', 3, 1, NULL, NULL, NULL, 2, NULL),
(4, 'Simon Pangaribuan Sarapa, S.H.', '196508301989031006', 3, 2, NULL, NULL, NULL, 2, NULL),
(5, 'Bonnyarti Kala Lande, S.H., M.H.', '196803251994032001', 3, 2, NULL, NULL, NULL, 2, NULL),
(6, 'Irna, S.H., M.H.', '197104011992032001', 3, 2, NULL, NULL, NULL, 2, NULL),
(7, 'Susilowati Siahaan, S.H., M.H.', '196609241988032001', 3, 3, NULL, NULL, NULL, 2, NULL),
(8, 'Hadhma Kurnia Fan, S.H., M.H.', '197508021998032002', 4, 4, NULL, NULL, NULL, 1, NULL),
(9, 'Ishak Rizal, S.T.', '198106012003121001', 5, 5, NULL, NULL, NULL, 1, NULL),
(10, 'Yurista Sukmah, S.Sos.', '198512062009042003', 6, 5, NULL, NULL, NULL, 9, NULL),
(11, 'Alkodar, S.H., M.H.', '196712281991031006', 7, 5, NULL, NULL, NULL, 8, NULL),
(12, 'Ressy Mirliana Sari, S.H., M.H.', '19680831200042001', 8, 5, NULL, NULL, NULL, 9, NULL),
(13, 'Indra Mufti, S.H.', '196902121991031006', 9, 5, NULL, NULL, NULL, 8, NULL),
(14, 'Sulami, S.H., M.H.', '196508121989032001', 10, 6, NULL, NULL, NULL, 11, NULL),
(15, 'Hj. Deo Yufanti, S.H.', '196508311991032003', 10, 6, NULL, NULL, NULL, 11, NULL),
(16, 'Isnaini, S.H., M.H.', '196809071990032003', 10, 6, NULL, NULL, NULL, 11, NULL),
(17, 'Sri Wulan Luciyanti, S.H.', '196408191994032002', 10, 6, NULL, NULL, NULL, 11, NULL),
(18, 'Rina Zaleha, S.H.', '196503111991032004', 10, 6, NULL, NULL, NULL, 11, NULL),
(19, 'Darul Kutni, S.H.', '197009021991031004', 10, 6, NULL, NULL, NULL, 11, NULL),
(20, 'Maryani Ub, S.H.', '197305151994032005', 10, 6, NULL, NULL, NULL, 11, NULL),
(21, 'Jembril, S.H.', '197001081989031001', 10, 6, NULL, NULL, NULL, 11, NULL),
(22, 'Dwi Indah Rosalina, S.H., M.H.', '198003132009041001', 11, 6, NULL, NULL, NULL, 11, NULL),
(23, 'Mirza Kurniawan, S.E.', '198404102020121003', 11, 7, NULL, NULL, NULL, 11, NULL),
(24, 'M. Alviandi Pratama Putra, A.Md', '199402032019031007', 11, 11, NULL, NULL, NULL, 11, NULL),
(25, 'Liona Anggraini Oktaviana, A.Md', '199710032019032009', 11, 11, NULL, NULL, NULL, 11, NULL),
(26, 'Muhammad Abdullah, A.Md', '197412132000031006', 12, 6, NULL, NULL, '', 10, 'ttd_197412132000031006.png'),
(27, 'Novalia Simanjuntak, S.H.', '198011112011122001', 13, 6, NULL, NULL, NULL, 12, NULL),
(28, 'Debby Corazona Pratiwi, S.E.', '198801102009042005', 14, 7, NULL, NULL, NULL, 12, NULL),
(29, 'Nora Agustina, S.Kom.', '198808292012122005', 15, 7, NULL, NULL, NULL, 10, NULL),
(30, 'Medi Darmawansyah, S.H., M.H.', '198605112009041003', 16, 6, NULL, NULL, NULL, NULL, NULL),
(31, 'Koriyanto, S.E.', '198304012012121002', 17, 9, NULL, NULL, NULL, NULL, NULL),
(32, 'Firdaus Amin, S.E., M.M.', '1984042419031006', 17, 8, NULL, NULL, NULL, NULL, NULL),
(33, 'Nathia Claudia Elsivia, S.H.', '199003022024052001', 18, 9, NULL, NULL, NULL, NULL, NULL),
(34, 'Fhareza Muhammad Gahar, S.H.', '199004122024051001', 19, 9, NULL, NULL, NULL, NULL, NULL),
(35, 'Hary Yuliansyah, A.Md.', '199507082020121009', 20, 11, NULL, NULL, 'foto_199507082020121009.jpg', 9, ''),
(36, 'Akbar Winda Nata, A.Md.', '199304042020121009', 21, 11, NULL, NULL, NULL, NULL, NULL),
(37, 'Tiara Antonisa Wielna, A.Md.A.B.', '199604202020122002', 22, 11, NULL, NULL, NULL, NULL, NULL),
(38, 'Aprilia Berlianda, A.Md.Ak.', '199804232021122002', 23, 11, NULL, NULL, NULL, NULL, NULL),
(39, 'Feven Ridho Yabie, S.Kom.', 'PPNPN10', 17, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 'Basuki', 'PPNPN01', 24, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 'M. Febrianto, S.A.', 'PPNPN02', 24, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 'Muhaimin Syakib', 'PPNPN03', 24, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 'Zainuddin, S.Kom', 'PPNPN04', 24, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 'R.M. Iqbal Tawakal, Amd', 'PPNPN05', 24, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 'Yusuf Al-Qardhawi, S.T.', 'PPNPN06', 24, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 'Berilla Ramadanti, S.H.', 'PPNPN07', 24, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 'Yunny Ramadhani', 'PPNPN08', 24, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 'Renna Syafira', 'PPNPN09', 24, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 'Herwin Nurian Apriansyah', '062140832933', 26, 12, NULL, NULL, 'foto_062140832933.png', 26, 'ttd_062140832933.png');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_cuti`
--

CREATE TABLE `pengajuan_cuti` (
  `id` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `jenis_cuti` varchar(100) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `alamat_cuti` text DEFAULT NULL,
  `no_telp_cuti` varchar(20) DEFAULT NULL,
  `status` enum('Diajukan','Disetujui Atasan','Ditolak Atasan','Disetujui Ketua','Ditolak Ketua') NOT NULL DEFAULT 'Diajukan',
  `catatan_atasan` text DEFAULT NULL,
  `catatan_ketua` text DEFAULT NULL,
  `disetujui_oleh_atasan_id` int(11) DEFAULT NULL,
  `tanggal_disetujui_atasan` datetime DEFAULT NULL,
  `disetujui_oleh_ketua_id` int(11) DEFAULT NULL,
  `tanggal_disetujui_ketua` datetime DEFAULT NULL,
  `tanggal_pengajuan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pengajuan_cuti`
--

INSERT INTO `pengajuan_cuti` (`id`, `id_pegawai`, `jenis_cuti`, `tanggal_mulai`, `tanggal_selesai`, `keterangan`, `alamat_cuti`, `no_telp_cuti`, `status`, `catatan_atasan`, `catatan_ketua`, `disetujui_oleh_atasan_id`, `tanggal_disetujui_atasan`, `disetujui_oleh_ketua_id`, `tanggal_disetujui_ketua`, `tanggal_pengajuan`) VALUES
(1, 49, 'Cuti Sakit', '2025-07-13', '2025-07-17', 'Test Form Cuti', 'Test Alamat Untuk Form Cuti', 'Test No. Telepon unt', 'Disetujui Ketua', 'ACC untuk Test Form Cuti', 'acc untuk test form cuti', 26, '2025-07-13 16:43:38', 1, '2025-07-13 16:44:39', '2025-07-13 09:42:09'),
(2, 49, 'Cuti di Luar Tanggungan Negara', '2025-07-14', '2025-07-17', 'test ketika cuti berhenti di atasan', '-', '-', 'Disetujui Ketua', '', '', 26, '2025-07-14 12:06:12', 1, '2025-07-16 13:49:58', '2025-07-14 05:01:43'),
(3, 49, 'Cuti Karena Alasan Penting', '2025-07-16', '2025-07-19', 'B', 'Alamat', '-', 'Disetujui Ketua', '', '', 26, '2025-07-16 14:02:01', 1, '2025-07-16 14:02:59', '2025-07-16 06:26:44'),
(4, 49, 'Cuti di Luar Tanggungan Negara', '2025-07-20', '2025-07-27', 'ABC', 'cxvb', '-', 'Disetujui Ketua', '', '', 26, '2025-07-16 14:02:07', 1, '2025-07-16 14:03:05', '2025-07-16 06:35:04'),
(5, 49, 'Cuti Karena Alasan Penting', '2025-07-18', '2025-07-27', 'Reeee', 'alamat', '0865', 'Disetujui Ketua', '', '', 26, '2025-07-16 14:02:13', 1, '2025-07-16 14:03:11', '2025-07-16 06:44:44'),
(6, 49, 'Cuti Melahirkan', '2025-07-27', '2025-07-31', 'Melahirkan', 'Alamat Cuti', '-', 'Disetujui Ketua', '', '', 26, '2025-07-16 14:02:20', 1, '2025-07-16 14:03:15', '2025-07-16 07:01:28'),
(7, 49, 'Cuti Sakit', '2025-07-16', '2025-07-16', 'sakit', 'fghjkl', '-', 'Disetujui Ketua', 'catatan', '', 26, '2025-07-16 14:09:52', 1, '2025-07-16 14:11:14', '2025-07-16 07:09:25'),
(8, 49, 'Cuti Tahunan', '2025-07-16', '2025-07-18', 'Test Jatah Cuti', 'Test Alamat menambahkan fitur cuti tahunan', '-', 'Disetujui Ketua', 'Catatan mengetes jatah cuti', 'Catatan Final', 26, '2025-07-16 14:15:42', 1, '2025-07-16 14:17:09', '2025-07-16 07:13:50'),
(9, 49, 'Cuti Tahunan', '2025-07-18', '2025-07-23', 'Cuti untuk menikah', 'Jalan jalan', '0893', 'Diajukan', NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-18 07:57:07');

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `judul`, `isi`, `gambar`, `tanggal_dibuat`) VALUES
(1, 'Test Pengumuman', 'Tercatat Tanggal 12 Juli Malam Fitur ini ditambahkan.', NULL, '2025-07-12 15:47:20'),
(2, 'Apel Pagi', 'Seluruh Hakim Tinggi, Pegawai, dan PPNPN Pada Pengadilan Tinggi Tata Usaha Negara Palembang Melaksanakan Apel Pagi Rutin di depan gedung PTTUN Palembang, Bapak Simon Pangondian Sinaga, S.H. selaku Pembina Apel Pagi hari ini menyampaikan pesan untuk mengawali kegiatan minggu ini dengan bekerja sesuai dengan Tupoksi dan mengacu pada SOP, dan juga diperlukan koordinasi antara bagian kesekretariatan dan bagian kepaniteraan agar tercipta lingkungan kerja yang baik, Kegiatan ini diakhiri dengan pembacaan doa yang dipimpin oleh Komandan Apel yaitu saudara Tunky Ramadhan', '1752517611_517596045_760939323538235_5946409134915326128_n.jpg', '2025-07-14 04:26:51');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_jabatan`
--

CREATE TABLE `riwayat_jabatan` (
  `id` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `jabatan` varchar(150) NOT NULL,
  `unit_kerja` varchar(150) DEFAULT NULL,
  `nomor_sk` varchar(100) DEFAULT NULL,
  `tanggal_sk` date DEFAULT NULL,
  `tmt_jabatan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_pendidikan`
--

CREATE TABLE `riwayat_pendidikan` (
  `id` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `tingkat_pendidikan` varchar(50) NOT NULL,
  `nama_institusi` varchar(150) NOT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  `tahun_lulus` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `riwayat_pendidikan`
--

INSERT INTO `riwayat_pendidikan` (`id`, `id_pegawai`, `tingkat_pendidikan`, `nama_institusi`, `jurusan`, `tahun_lulus`) VALUES
(1, 49, 'SMK', 'SMK Muhammadiyah 1', 'TKJ - Teknik Komputer Jaringan', '2020');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `id_pegawai` int(11) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pegawai','ketua') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `id_pegawai`, `nama`, `username`, `password`, `role`) VALUES
(1, NULL, 'Administrator Sistem', 'admin', '$2a$12$SoffD5w6bRA1cjG8BNbL7uz3J1YRW4z8b5QO.zR73521K2133wKia', 'admin'),
(2, 1, 'A. SYAKRULLAH, S.H.', '196108191986121001', '$2y$10$DII/d0bNiPkIZS3eME5XL.JbmdCGh6KJWOhr6bkEyO68lmAZPBmDq', 'ketua'),
(3, 2, 'AR. SETIYONO, S.H., M.H.', '196204121988031003', '$2y$10$8zzAH4Kek14GaJ6faTHeheQu/cdzwA1LzdKPhoo1R66o5O0bshWve', 'pegawai'),
(4, 3, 'Irhamto, S.H., M.H.', '196502231998031004', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(5, 4, 'Simon Pangaribuan Sarapa, S.H.', '196508301989031006', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(6, 5, 'Bonnyarti Kala Lande, S.H., M.H.', '196803251994032001', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(7, 6, 'Irna, S.H., M.H.', '197104011992032001', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(8, 7, 'Susilowati Siahaan, S.H., M.H.', '196609241988032001', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(9, 8, 'Hadhma Kurnia Fan, S.H., M.H.', '197508021998032002', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(10, 9, 'Ishak Rizal, S.T.', '198106012003121001', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(11, 10, 'Yurista Sukmah, S.Sos.', '198512062009042003', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(12, 11, 'Alkodar, S.H., M.H.', '196712281991031006', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(13, 12, 'Ressy Mirliana Sari, S.H., M.H.', '19680831200042001', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(14, 13, 'Indra Mufti, S.H.', '196902121991031006', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(15, 14, 'Sulami, S.H., M.H.', '196508121989032001', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(16, 15, 'Hj. Deo Yufanti, S.H.', '196508311991032003', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(17, 16, 'Isnaini, S.H., M.H.', '196809071990032003', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(18, 17, 'Sri Wulan Luciyanti, S.H.', '196408191994032002', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(19, 18, 'Rina Zaleha, S.H.', '196503111991032004', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(20, 19, 'Darul Kutni, S.H.', '197009021991031004', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(21, 20, 'Maryani Ub, S.H.', '197305151994032005', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(22, 21, 'Jembril, S.H.', '197001081989031001', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(23, 22, 'Dwi Indah Rosalina, S.H., M.H.', '198003132009041001', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(24, 23, 'Mirza Kurniawan, S.E.', '198404102020121003', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(25, 24, 'M. Alviandi Pratama Putra, A.Md', '199402032019031007', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(26, 25, 'Liona Anggraini Oktaviana, A.Md', '199710032019032009', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(27, 26, 'Muhammad Abdullah, A.Md', '197412132000031006', '$2y$10$qVJY8c2aq3bhYokY1wVHIeZawRKgDsy1Ylw7uJeyBU7PgR7j8T5iS', 'pegawai'),
(28, 27, 'Novalia Simanjuntak, S.H.', '198011112011122001', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(29, 28, 'Debby Corazona Pratiwi, S.E.', '198801102009042005', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(30, 29, 'Nora Agustina, S.Kom.', '198808292012122005', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(31, 30, 'Medi Darmawansyah, S.H., M.H.', '198605112009041003', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(32, 31, 'Koriyanto, S.E.', '198304012012121002', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(33, 32, 'Firdaus Amin, S.E., M.M.', '1984042419031006', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(34, 33, 'Nathia Claudia Elsivia, S.H.', '199003022024052001', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(35, 34, 'Fhareza Muhammad Gahar, S.H.', '199004122024051001', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(36, 35, 'Hary Yuliansyah, A.Md.', '199507082020121009', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(37, 36, 'Akbar Winda Nata, A.Md.', '199304042020121009', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(38, 37, 'Tiara Antonisa Wielna, A.Md.A.B.', '199604202020122002', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(39, 38, 'Aprilia Berlianda, A.Md.Ak.', '199804232021122002', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(40, 39, 'Feven Ridho Yabie, S.Kom.', 'PPNPN10', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(41, 40, 'Basuki', 'PPNPN01', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(42, 41, 'M. Febrianto, S.A.', 'PPNPN02', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(43, 42, 'Muhaimin Syakib', 'PPNPN03', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(44, 43, 'Zainuddin, S.Kom', 'PPNPN04', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(45, 44, 'R.M. Iqbal Tawakal, Amd', 'PPNPN05', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(46, 45, 'Yusuf Al-Qardhawi, S.T.', 'PPNPN06', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(47, 46, 'Berilla Ramadanti, S.H.', 'PPNPN07', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(48, 47, 'Yunny Ramadhani', 'PPNPN08', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(49, 48, 'Renna Syafira', 'PPNPN09', '$2y$10$9sZ.N2.q9X/VqJ8u.L4k2.m6yQ5U.x2D.g2n6U3V.e7F8sE9hJ.eC', 'pegawai'),
(50, 49, 'Herwin Nurian Apriansyah', '062140832933', '$2y$10$KSP762LQKBk5O71pjlqJzO4//qEwEmRbBRP/zCQr6uUsZsGu9e9Yy', 'pegawai');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `golongan`
--
ALTER TABLE `golongan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_golongan` (`nama_golongan`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_jabatan` (`nama_jabatan`);

--
-- Indexes for table `jatah_cuti`
--
ALTER TABLE `jatah_cuti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unik_pegawai_tahun` (`id_pegawai`,`tahun`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `id_jabatan` (`id_jabatan`),
  ADD KEY `id_golongan` (`id_golongan`),
  ADD KEY `id_atasan` (`id_atasan`);

--
-- Indexes for table `pengajuan_cuti`
--
ALTER TABLE `pengajuan_cuti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat_jabatan`
--
ALTER TABLE `riwayat_jabatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indexes for table `riwayat_pendidikan`
--
ALTER TABLE `riwayat_pendidikan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `golongan`
--
ALTER TABLE `golongan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `jatah_cuti`
--
ALTER TABLE `jatah_cuti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `pengajuan_cuti`
--
ALTER TABLE `pengajuan_cuti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `riwayat_jabatan`
--
ALTER TABLE `riwayat_jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `riwayat_pendidikan`
--
ALTER TABLE `riwayat_pendidikan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jatah_cuti`
--
ALTER TABLE `jatah_cuti`
  ADD CONSTRAINT `jatah_cuti_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pegawai_ibfk_2` FOREIGN KEY (`id_golongan`) REFERENCES `golongan` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pegawai_ibfk_3` FOREIGN KEY (`id_atasan`) REFERENCES `pegawai` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pengajuan_cuti`
--
ALTER TABLE `pengajuan_cuti`
  ADD CONSTRAINT `pengajuan_cuti_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `riwayat_jabatan`
--
ALTER TABLE `riwayat_jabatan`
  ADD CONSTRAINT `riwayat_jabatan_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `riwayat_pendidikan`
--
ALTER TABLE `riwayat_pendidikan`
  ADD CONSTRAINT `riwayat_pendidikan_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
