-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2024 at 04:31 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klinik_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `ID_Appointment` int(11) NOT NULL,
  `ID_Pasien` int(11) DEFAULT NULL,
  `ID_Dokter` int(11) DEFAULT NULL,
  `Tanggal_Perjanjian` date DEFAULT NULL,
  `Jam_Perjanjian` time DEFAULT NULL,
  `Keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`ID_Appointment`, `ID_Pasien`, `ID_Dokter`, `Tanggal_Perjanjian`, `Jam_Perjanjian`, `Keterangan`) VALUES
(1, 3, 3, '2024-04-27', '14:00:00', 'Operasi bisul.'),
(2, 2, 2, '2024-04-28', '11:30:00', 'Pemasangan behel.'),
(3, 3, 3, '2024-04-29', '14:00:00', 'Operasi katarak.'),
(4, 4, 1, '2024-08-10', '21:00:00', 'Pemeriksaan kehamilan.'),
(5, 1, 1, '2024-05-01', '15:30:00', 'Konsultasi mengenai penyakit kronis');

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `ID_Dokter` int(11) NOT NULL,
  `Nama_Dokter` varchar(255) DEFAULT NULL,
  `Photo` varchar(255) DEFAULT NULL,
  `Spesialisasi` varchar(100) DEFAULT NULL,
  `Nomor_Telepon` varchar(15) DEFAULT NULL,
  `Alamat` varchar(255) DEFAULT NULL,
  `Jadwal_Praktek` varchar(255) DEFAULT NULL,
  `Informasi_Lain` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`ID_Dokter`, `Nama_Dokter`, `Photo`, `Spesialisasi`, `Nomor_Telepon`, `Alamat`, `Jadwal_Praktek`, `Informasi_Lain`) VALUES
(1, 'Dr. Steven Adams', 'Dr. Steven Adams.png', 'Dokter Umum', '0811111111113', 'RS ABC, Jl. Gatot Subroto No. 123', 'Senin-Jumat, 08:00-16:00', 'Pengalaman lebih dari 10 tahun dalam praktik umum.'),
(2, 'Dr. Lisa Anderso', 'Dr. Lisa Anderson.jpg', 'Dokter Gigi', '082222222', 'Klinik Gusi Smile, Jl. Thamrin No. 45', 'Senin-Sabtu, 09:00-17:00', 'Spesialisasi dalam perawatan gigi anak.'),
(3, 'Dr. Kevin Martinez', 'Dr. Kevin Martinez.jpg', 'Dokter Spesialis Bedah', '083333333333', 'RS XYZ, Jl. Sudirman No. 789', 'Selasa-Kamis, 10:00-18:00', 'Memiliki sertifikasi dalam bedah laparoskopik.'),
(4, 'Dr. Emma Taylor', 'Taylor.jpg', 'Dokter Kandungan', '084444444444', 'RS DEF, Jl. Kebon Sirih No. 567', 'Senin-Jumat, 08:00-16:00', 'Berfokus pada perawatan ibu hamil dengan komplikasi.'),
(5, 'Dr. Daniel Clark', 'Dr. Daniel Clark.jpg', 'Dokter Spesialis Penyakit Dalam', '085555555555', 'RS GHI, Jl. Menteng No. 789', 'Senin-Jumat, 15:00-17:00', 'Menyediakan perawatan bagi pasien dengan kondisi kronis.');

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `ID_Pasien` int(11) NOT NULL,
  `Nama` varchar(255) DEFAULT NULL,
  `Alamat` varchar(255) DEFAULT NULL,
  `Nomor_Telepon` varchar(15) DEFAULT NULL,
  `Tanggal_Lahir` date DEFAULT NULL,
  `Jenis_Kelamin` enum('Laki-laki','Perempuan','Lainnya') DEFAULT NULL,
  `Informasi_Lain` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`ID_Pasien`, `Nama`, `Alamat`, `Nomor_Telepon`, `Tanggal_Lahir`, `Jenis_Kelamin`, `Informasi_Lain`) VALUES
(1, 'John Doe', 'Jl. Menteng No. 123', '081234567890', '1999-05-15', 'Laki-laki', 'Riwayat alergi makanan.'),
(2, 'Jane Smith', 'Jl. Kebon Sirih No. 45', '085678901234', '1985-09-20', 'Perempuan', 'Tidak ada informasi tambahan..'),
(3, 'Michael Jeanab', 'Jl. Sudirman No. 789', '082345678901', '1978-12-10', 'Perempuan', 'Riwayat penyakit jantung.'),
(4, 'Emily Brown', 'Jl. Thamrin No. 567', '087654321098', '1995-03-25', 'Laki-laki', 'Tidak ada informasi tambahan.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`ID_Appointment`),
  ADD KEY `ID_Pasien` (`ID_Pasien`),
  ADD KEY `ID_Dokter` (`ID_Dokter`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`ID_Dokter`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`ID_Pasien`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `ID_Appointment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `ID_Dokter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `ID_Pasien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`ID_Pasien`) REFERENCES `pasien` (`ID_Pasien`),
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`ID_Dokter`) REFERENCES `dokter` (`ID_Dokter`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
