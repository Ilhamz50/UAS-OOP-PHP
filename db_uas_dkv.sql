-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_uas_dkv
CREATE DATABASE IF NOT EXISTS `db_uas_dkv` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_uas_dkv`;

-- Dumping structure for table db_uas_dkv.absensi
CREATE TABLE IF NOT EXISTS `absensi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nis` varchar(10) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nis` (`nis`),
  CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_uas_dkv.absensi: ~3 rows (approximately)
INSERT INTO `absensi` (`id`, `nis`, `tanggal`, `status`) VALUES
	(1, '12301', '2026-05-16', 'Alpha'),
	(2, '12302', '2026-05-16', 'Izin'),
	(3, '12303', '2026-05-16', 'Sakit');

-- Dumping structure for table db_uas_dkv.siswa
CREATE TABLE IF NOT EXISTS `siswa` (
  `nis` varchar(10) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`nis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_uas_dkv.siswa: ~2 rows (approximately)
INSERT INTO `siswa` (`nis`, `nama`, `jurusan`, `kelas`) VALUES
	('12301', 'Budi Sigi', 'DKV', '12'),
	('12302', 'Jokowi DODO', 'DKV', '12'),
	('12303', 'Heru Wijiyanto', 'DKV', '12');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
