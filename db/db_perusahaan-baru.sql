-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 13, 2025 at 02:49 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_perusahaan`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `editAdmin`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `editAdmin` (IN `p_id` INT, IN `p_username` VARCHAR(255), IN `p_password` VARCHAR(255), IN `p_role` ENUM('admin','karyawan'))   BEGIN

UPDATE admin set admin.username = p_username, admin.password = p_password,
admin.role = p_role WHERE admin.id = p_id;

END$$

DROP PROCEDURE IF EXISTS `editJabatan`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `editJabatan` (IN `id_jabatan` INT, IN `nama_jabatan` VARCHAR(50), IN `gaji_pokok` DECIMAL)   BEGIN

UPDATE jabatan set jabatan.nama_jabatan = nama_jabatan,
jabatan.gaji_pokok = gaji_pokok
WHERE jabatan.id_jabatan = id_jabatan;

END$$

DROP PROCEDURE IF EXISTS `editKaryawan`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `editKaryawan` (IN `p_id` INT, IN `p_nama` VARCHAR(255), IN `p_alamat` TEXT, IN `p_nohp` VARCHAR(16), IN `p_jmlank` INT, IN `p_stsprkwn` ENUM('nikah','belum'), IN `p_jabatan` INT)   BEGIN		

UPDATE karyawan SET karyawan.nama = p_nama, karyawan.alamat = p_alamat,
karyawan.no_hp = p_nohp, karyawan.jumlah_anak = p_jmlank,karyawan.status_perkawinan = p_stsprkwn,
karyawan.id_jabatan = p_jabatan WHERE karyawan.id_karyawan = p_id;

END$$

DROP PROCEDURE IF EXISTS `getAbsen`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAbsen` ()   SELECT 
        a.id_absensi,
        k.nama,
        a.tanggal,
        a.jam_masuk,
        a.jam_keluar
    FROM absensi a
    JOIN karyawan k ON a.id_karyawan = k.id_karyawan$$

DROP PROCEDURE IF EXISTS `getAdmin`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAdmin` ()   BEGIN

SELECT*FROM admin;

END$$

DROP PROCEDURE IF EXISTS `getAdminId`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAdminId` (IN `p_id` INT)   BEGIN

SELECT*FROM admin WHERE admin.id = p_id;

END$$

DROP PROCEDURE IF EXISTS `getJabatan`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getJabatan` ()   BEGIN

SELECT*FROM jabatan;

END$$

DROP PROCEDURE IF EXISTS `getJabatanId`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getJabatanId` (IN `id_jabatan` INT)   BEGIN

SELECT*FROM jabatan where jabatan.id_jabatan = id_jabatan;

END$$

DROP PROCEDURE IF EXISTS `getkaryawan`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getkaryawan` ()   SELECT 
    a.id_karyawan,
    a.nama,
    a.alamat,
    a.no_hp,
    a.jumlah_anak,
    a.status_perkawinan,
    j.nama_jabatan,
    a.id_jabatan
FROM karyawan a
JOIN jabatan j ON a.id_jabatan = j.id_jabatan$$

DROP PROCEDURE IF EXISTS `getKaryawanId`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getKaryawanId` (IN `id_karyawan` INT(11))   BEGIN

SELECT*FROM karyawan WHERE karyawan.id_karyawan=id_karyawan;

END$$

DROP PROCEDURE IF EXISTS `getLoginKaryawan`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getLoginKaryawan` (IN `p_nama` VARCHAR(255), IN `p_password` VARCHAR(255))   SELECT * 
FROM karyawan
WHERE 
  CONVERT(nama USING utf8mb4) = p_nama AND 
  CONVERT(password USING utf8mb4) = p_password$$

DROP PROCEDURE IF EXISTS `getLoginPetugas`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getLoginPetugas` (IN `username` VARCHAR(255), IN `password` VARCHAR(255))   BEGIN

SELECT*FROM admin 
WHERE 
admin.username = username AND
admin.password = password;

END$$

DROP PROCEDURE IF EXISTS `getPenggajian`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getPenggajian` ()   SELECT
		a.id_gaji,
        j.nama,
        a.tanggal_gaji,
        a.total_gaji
    FROM penggajian a
    JOIN karyawan j ON a.id_karyawan = j.id_karyawan$$

DROP PROCEDURE IF EXISTS `hapusAdmin`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `hapusAdmin` (IN `p_id` INT)   BEGIN

DELETE FROM admin WHERE admin.id = p_id;

END$$

DROP PROCEDURE IF EXISTS `hapusGaji`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `hapusGaji` (IN `id_gaji` INT)   BEGIN

DELETE FROM penggajian WHERE penggajian.id_gaji = id_gaji;

END$$

DROP PROCEDURE IF EXISTS `hapusJabatan`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `hapusJabatan` (IN `id_jabatan` INT)   BEGIN

DELETE FROM jabatan WHERE jabatan.id_jabatan = id_jabatan;

END$$

DROP PROCEDURE IF EXISTS `hapusKaryawan`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `hapusKaryawan` (IN `id_karyawan` INT)   BEGIN

DELETE FROM karyawan WHERE karyawan.id_karyawan = id_karyawan;

END$$

DROP PROCEDURE IF EXISTS `tambahAdmin`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `tambahAdmin` (IN `p_username` VARCHAR(255), IN `p_password` VARCHAR(255), IN `p_role` ENUM('admin','karyawan'))   BEGIN

INSERT INTO admin (admin.username,admin.password,admin.role)
VALUES (p_username, p_password, p_role);

END$$

DROP PROCEDURE IF EXISTS `tambahGaji`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `tambahGaji` (IN `id_karyawan` INT, IN `tanggal_gaji` DATE, IN `total_gaji` DECIMAL)   BEGIN	

INSERT INTO penggajian (penggajian.id_karyawan, penggajian.tanggal_gaji, penggajian.total_gaji)
VALUES (id_karyawan, tanggal_gaji, total_gaji);

END$$

DROP PROCEDURE IF EXISTS `tambahJabatan`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `tambahJabatan` (IN `nama_jabatan` VARCHAR(50), IN `gaji_pokok` DECIMAL)   BEGIN

INSERT INTO jabatan (jabatan.nama_jabatan,jabatan.gaji_pokok)
VALUES (nama_jabatan,gaji_pokok);

END$$

DROP PROCEDURE IF EXISTS `tambahKaryawan`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `tambahKaryawan` (IN `nama` VARCHAR(100), IN `alamat` TEXT, IN `no_hp` VARCHAR(25), IN `jumlah_anak` INT, IN `status_perkawinan` ENUM('nikah','belum'), IN `id_jabatan` INT)   BEGIN

INSERT INTO karyawan (karyawan.nama, karyawan.alamat,karyawan.no_hp, karyawan.jumlah_anak,karyawan.status_perkawinan,karyawan.id_jabatan)
VALUES (nama, alamat, no_hp, jumlah_anak, status_perkawinan, id_jabatan);

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

DROP TABLE IF EXISTS `absensi`;
CREATE TABLE `absensi` (
  `id_absensi` int NOT NULL,
  `id_karyawan` int DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `id_karyawan`, `tanggal`, `jam_masuk`, `jam_keluar`) VALUES
(18, 6, '2025-06-13', '14:31:22', '14:31:25'),
(19, 1, '2025-06-13', '21:39:14', '21:39:17'),
(20, 8, '2025-06-13', '21:41:53', '21:41:57');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` enum('admin','karyawan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(3, 'atnan', '2001e7338c40af1c06cdc6d536e47744', 'karyawan'),
(4, 'damar', '25d55ad283aa400af464c76d713c07ad', 'karyawan');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

DROP TABLE IF EXISTS `jabatan`;
CREATE TABLE `jabatan` (
  `id_jabatan` int NOT NULL,
  `nama_jabatan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gaji_pokok` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `nama_jabatan`, `gaji_pokok`) VALUES
(1, 'Manager', '350000.00'),
(2, 'Staff', '200000.00'),
(3, 'Magang', '80000.00');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

DROP TABLE IF EXISTS `karyawan`;
CREATE TABLE `karyawan` (
  `id_karyawan` int NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `no_hp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jumlah_anak` int DEFAULT NULL,
  `status_perkawinan` enum('nikah','belum') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_jabatan` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nama`, `password`, `alamat`, `no_hp`, `jumlah_anak`, `status_perkawinan`, `id_jabatan`) VALUES
(1, 'Andi Saputra', 'ce0e5bf55e4f71749eade7a8b95c4e46', 'Jl. Merdeka No. 10', '081234567890', 1, 'nikah', 1),
(2, 'Budi Santoso', '00dfc53ee86af02e742515cdcf075ed3', 'Jl. Kenanga No. 20', '082345678901', 3, 'nikah', 2),
(3, 'Citra Lestari', 'e260eab6a7c45d139631f72b55d8506b', 'Jl. Melati No. 30', '083456789012', 0, 'belum', 3),
(6, 'ridho', '926a161c6419512d711089538c80ac70', 'bantul', '08598127837', 2, 'nikah', 1),
(7, 'dika', 'e9ce15bcebcedde2cb3cf9fe8f84fc0c', 'kuningan', '098764521', 3, 'belum', 2),
(8, 'Damar', 'dd28a856e0e04daf04cd11322a0835aa', 'godean', '08598127834', 5, 'nikah', 2),
(12, 'Atnan', '30a9817a75c15f627b2afd53ae1cec90', 'Brebes', '08080808080', 12, 'nikah', 1);

-- --------------------------------------------------------

--
-- Table structure for table `penggajian`
--

DROP TABLE IF EXISTS `penggajian`;
CREATE TABLE `penggajian` (
  `id_gaji` int NOT NULL,
  `id_karyawan` int DEFAULT NULL,
  `tanggal_gaji` date DEFAULT NULL,
  `total_gaji` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penggajian`
--

INSERT INTO `penggajian` (`id_gaji`, `id_karyawan`, `tanggal_gaji`, `total_gaji`) VALUES
(1, 1, '2025-06-02', '10000000.00'),
(3, 3, '2025-06-02', '2500000.00'),
(4, 2, '2025-07-02', '6000000.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- Indexes for table `penggajian`
--
ALTER TABLE `penggajian`
  ADD PRIMARY KEY (`id_gaji`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `penggajian`
--
ALTER TABLE `penggajian`
  MODIFY `id_gaji` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`);

--
-- Constraints for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `karyawan_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`);

--
-- Constraints for table `penggajian`
--
ALTER TABLE `penggajian`
  ADD CONSTRAINT `penggajian_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
