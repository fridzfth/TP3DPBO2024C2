/*
 Navicat Premium Data Transfer

 Source Server         : koneksi01
 Source Server Type    : MySQL
 Source Server Version : 100427 (10.4.27-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : klinik_database

 Target Server Type    : MySQL
 Target Server Version : 100427 (10.4.27-MariaDB)
 File Encoding         : 65001

 Date: 01/05/2024 12:32:43
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for appointment
-- ----------------------------
DROP TABLE IF EXISTS `appointment`;
CREATE TABLE `appointment`  (
  `ID_Appointment` int NOT NULL AUTO_INCREMENT,
  `ID_Pasien` int NULL DEFAULT NULL,
  `ID_Dokter` int NULL DEFAULT NULL,
  `Tanggal_Perjanjian` date NULL DEFAULT NULL,
  `Jam_Perjanjian` time NULL DEFAULT NULL,
  `Keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`ID_Appointment`) USING BTREE,
  INDEX `ID_Pasien`(`ID_Pasien` ASC) USING BTREE,
  INDEX `ID_Dokter`(`ID_Dokter` ASC) USING BTREE,
  CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`ID_Pasien`) REFERENCES `pasien` (`ID_Pasien`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`ID_Dokter`) REFERENCES `dokter` (`ID_Dokter`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of appointment
-- ----------------------------
INSERT INTO `appointment` VALUES (1, 3, 3, '2024-07-27', '14:00:00', 'Operasi bisul.');
INSERT INTO `appointment` VALUES (2, 2, 2, '2024-04-28', '11:30:00', 'Pemasangan behel.');
INSERT INTO `appointment` VALUES (3, 3, 3, '2024-04-29', '14:00:00', 'Operasi katarak.');
INSERT INTO `appointment` VALUES (4, 4, 1, '2024-08-10', '21:00:00', 'Pemeriksaan kehamilan.');
INSERT INTO `appointment` VALUES (5, 1, 1, '2024-05-01', '15:30:00', 'Konsultasi mengenai penyakit kronis');

-- ----------------------------
-- Table structure for dokter
-- ----------------------------
DROP TABLE IF EXISTS `dokter`;
CREATE TABLE `dokter`  (
  `ID_Dokter` int NOT NULL AUTO_INCREMENT,
  `Nama_Dokter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Spesialisasi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Nomor_Telepon` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Jadwal_Praktek` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Informasi_Lain` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`ID_Dokter`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 55 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dokter
-- ----------------------------
INSERT INTO `dokter` VALUES (1, 'Dr. Steven Adams', 'Dr. Steven Adams.png', 'Umum', '0811111111113', 'RS ABC, Jl. Gatot Subroto No. 123', 'Senin-Jumat, 08:00-16:00', 'Pengalaman lebih dari 10 tahun dalam praktik umum.');
INSERT INTO `dokter` VALUES (2, 'Dr. Lisa Anderso', 'Dr. Lisa Anderson.jpg', 'Gigi', '082222222', 'Klinik Gusi Smile, Jl. Thamrin No. 45', 'Senin-Sabtu, 09:00-17:00', 'Spesialisasi dalam perawatan gigi anak.');
INSERT INTO `dokter` VALUES (3, 'Dr. Kevin Martinez', 'Dr. Kevin Martinez.jpg', 'Bedah', '083333333333', 'RS XYZ, Jl. Sudirman No. 789', 'Selasa-Kamis, 10:00-18:00', 'Memiliki sertifikasi dalam bedah laparoskopik.');
INSERT INTO `dokter` VALUES (4, 'Default', 'default.jpeg', 'Default', 'Default', 'Default', 'Default', 'Default');
INSERT INTO `dokter` VALUES (6, 'Dr. Emma Taylor', 'Taylor.jpg', 'Kandungan', '084444444444', 'RS DEF, Jl. Kebon Sirih No. 567', 'Senin-Jumat, 08:00-16:00', 'Berfokus pada perawatan ibu hamil dengan komplikasi.');

-- ----------------------------
-- Table structure for pasien
-- ----------------------------
DROP TABLE IF EXISTS `pasien`;
CREATE TABLE `pasien`  (
  `ID_Pasien` int NOT NULL AUTO_INCREMENT,
  `Nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Nomor_Telepon` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Tanggal_Lahir` date NULL DEFAULT NULL,
  `Jenis_Kelamin` enum('Laki-laki','Perempuan','Lainnya') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Informasi_Lain` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`ID_Pasien`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pasien
-- ----------------------------
INSERT INTO `pasien` VALUES (1, 'John Doe', 'Jl. Menteng No. 123', '081234567890', '1999-05-15', 'Laki-laki', 'Riwayat alergi makanan.');
INSERT INTO `pasien` VALUES (2, 'Jane Smithhhh', 'Jl. Kebon Sirih No. 45', '085678901234', '1985-09-20', 'Perempuan', 'Tidak ada informasi tambahan..');
INSERT INTO `pasien` VALUES (3, 'Michael Jeanab', 'Jl. Sudirman No. 789', '082345678901', '1978-12-10', 'Perempuan', 'Riwayat penyakit jantung.');
INSERT INTO `pasien` VALUES (4, 'Emily Brown', 'Jl. Thamrin No. 567', '087654321098', '1995-03-25', 'Laki-laki', 'Tidak ada informasi tambahan.');

SET FOREIGN_KEY_CHECKS = 1;
