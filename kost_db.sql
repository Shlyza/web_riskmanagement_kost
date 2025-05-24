-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2025 at 12:19 AM
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
-- Database: `kost_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `keluhan`
--

CREATE TABLE `keluhan` (
  `id` int(11) NOT NULL,
  `keluhan` varchar(50) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('belum diproses','proses','selesai') DEFAULT 'belum diproses'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keluhan`
--

INSERT INTO `keluhan` (`id`, `keluhan`, `deskripsi`, `gambar`, `user_id`, `status`) VALUES
(1, 'bocor', NULL, NULL, 2, 'proses'),
(7, 'retak', 'cek', NULL, 2, 'proses'),
(12, 'mati lampu', 'mati', NULL, 2, 'proses'),
(16, 'pecah', 'hilang', NULL, 5, 'proses'),
(22, 'jebol', 'rewwel', NULL, 5, 'proses'),
(23, 'jebol', 'rewwel', NULL, 5, 'proses'),
(24, 'jebol', 'uhuy', NULL, 5, 'proses'),
(27, 'melenggik', 'dzaki sakit', NULL, 2, 'proses'),
(28, 'hp', 'baru', NULL, 2, 'belum diproses'),
(29, 'hp', 'baru', NULL, 2, 'belum diproses'),
(30, 'hp', 'baru', NULL, 2, 'belum diproses'),
(31, 'hp', 'lama', NULL, 2, 'proses'),
(32, 'hp', 'erwerewe', NULL, 2, 'belum diproses'),
(33, 'rusak', 'patah', NULL, 2, 'proses'),
(34, 'mati lampu', 'bohlam', NULL, 2, 'proses'),
(35, 'mati lampu', '', NULL, 2, 'belum diproses'),
(36, 'loop', '', NULL, 2, 'belum diproses'),
(37, 'eierth', '', NULL, 2, 'belum diproses'),
(38, 'reiuh', '', NULL, 2, 'proses'),
(39, 'mati lampu', '', '1748062502_img.jpg', 2, 'proses'),
(40, 'mati lampu', 'tolelet', '1748063588_sudo su meme.jpg', 2, 'proses'),
(41, 'Kasur Kempes', 'Minta tolong di ganti,dog!', '1748064736_Flowchart_Pendaki_Fix.png', 9, 'proses');

-- --------------------------------------------------------

--
-- Table structure for table `penghuni`
--

CREATE TABLE `penghuni` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `nomor_kamar` varchar(100) DEFAULT NULL,
  `durasi_sewa` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penghuni`
--

INSERT INTO `penghuni` (`id`, `nama`, `nomor_kamar`, `durasi_sewa`, `user_id`) VALUES
(1, 'server', '8', '3', NULL),
(2, 'server', '8', '3', NULL),
(3, 'server', '8', '3', NULL),
(4, 'Bagong', '2', '2', NULL),
(5, 'Dewo', '6', '2', NULL),
(6, 'Bagong', '2', '2', NULL),
(7, 'Dewo', '6', '2', NULL),
(8, 'Dewo', '6', '2', NULL),
(9, 'Luna', '4', '5', NULL),
(10, 'Riya', '3', '8', NULL),
(12, 'Hana', '21', '4', 5),
(13, 'ya', '29', '3', 9);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','penghuni') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin1', '25e4ee4e9229397b6b17776bfceaf8e7', 'admin'),
(2, 'penghuni1', 'a6cdfc3c4c6b0bb0da519a29d91b8138', 'penghuni'),
(3, 'Bagong', 'Bagong123', 'admin'),
(4, 'Luna', 'Luna123', 'penghuni'),
(5, 'hana', '946fd7874927f8aa8b0bc70082de84f8', 'penghuni'),
(6, 'rel', 'e01ca535d3f9c8914868ebfd20384611', 'admin'),
(7, 'ngga', 'fd5d5807c527c920fbc45555e1581f3c', 'penghuni'),
(8, 'dzaki', '83af6b604f8634b8fb7d63dda0715923', 'penghuni'),
(9, 'ya', 'edf568fc9d867f876154faafb5329202', 'penghuni');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keluhan`
--
ALTER TABLE `keluhan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penghuni`
--
ALTER TABLE `penghuni`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keluhan`
--
ALTER TABLE `keluhan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `penghuni`
--
ALTER TABLE `penghuni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
