-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 09, 2024 at 06:19 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testing`
--

-- --------------------------------------------------------

--
-- Table structure for table `ccq_locations`
--

CREATE TABLE `ccq_locations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `location_code` int(191) NOT NULL,
  `tax_rate` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ccq_locations`
--

INSERT INTO `ccq_locations` (`id`, `name`, `description`, `short_description`, `country`, `location_code`, `tax_rate`) VALUES
(19, 'delhi', 'agra', 'tajmahal', '', 0, 0),
(20, 'mumbaiu', 'testte', 'test', '', 0, 0),
(21, 'Ajith Kumar J', 'sd', 'sd', '', 0, 0),
(22, 'ds', 'sd', 'sd', '', 0, 0),
(23, 'Ajith Kumar', 'sd', 'cxc', '', 0, 0),
(24, 'Ajith Kumar J', 'aas', 'asas', '', 0, 0),
(25, 'ajith2', 'kdhj', 'jh', '', 0, 0),
(26, 'ajith6', 'jshdjh', 'jhsgc\r\n', '', 0, 0),
(27, 'sdsd', 'sdsd', 'sdsd', '', 0, 0),
(28, 'fdss', 'gsdfg', 'sfgsfg', '', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ccq_locations`
--
ALTER TABLE `ccq_locations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ccq_locations`
--
ALTER TABLE `ccq_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
