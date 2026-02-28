-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2026 at 03:05 AM
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
-- Database: `lhs_dts`
--

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `student_id_fk` int(11) DEFAULT NULL,
  `tracking_number` varchar(50) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `doc_type` varchar(50) NOT NULL,
  `student_name` varchar(50) NOT NULL,
  `grade_section` varchar(50) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `from_school` varchar(100) NOT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL,
  `current_location` varchar(100) DEFAULT 'Registrar',
  `document_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `student_id_fk`, `tracking_number`, `student_id`, `doc_type`, `student_name`, `grade_section`, `contact`, `from_school`, `date_created`, `status`, `current_location`, `document_file`) VALUES
(1, NULL, 'DOC-6909494e115b7', NULL, 'Enrollment Records', 'Biboy', '12-Ritchie', '09164416096', 'San Agustin Elementary School', '2025-11-04 00:00:00', 'Outgoing', 'Registrar', NULL),
(24, NULL, 'LHS_089f36cd', 123234, 'Birth Certificate', 'testerrrrrr', '12 - Ritchie', '123452', 'LHS', '2026-02-27 00:00:00', 'Out Going', 'Registrar', '1772213291_Gemini_Generated_Image_qne5wiqne5wiqne5 (1).png'),
(25, NULL, 'LHS_7e061302', 1232345, 'Birth Certificate', 'test', '12 - Ritchie', '123452', 'LHS', '2026-02-27 00:00:00', 'Rejected', 'Registrar', '1772213650_Gemini_Generated_Image_qne5wiqne5wiqne5.png'),
(26, NULL, 'LHS_a47cf4ec', 1232345, 'Birth Certificate', 'cris', '12 - Ritchie', '123452', 'LHS', '2026-02-27 00:00:00', 'Completed', 'Registrar', '1772213834_1772205191_pc.jpg'),
(27, NULL, 'LHS_76b313cb', 2147483647, 'Birth Certificate', 'Avila', '12 - Ritchie', '123452', 'LHS', '2026-02-28 00:00:00', 'Completed', 'Registrar', '1772236855_Gemini_Generated_Image_qne5wiqne5wiqne5.png'),
(28, NULL, 'LHS_86713084', 1336678, 'Birth Certificate', 'Abad Ali', '12 - Ritchie', '09123', 'LHS', '2026-02-28 00:00:00', 'Pending', 'Registrar', '1772237869_pc.jpg'),
(29, NULL, 'LHS_3e3dcf72', 2147483647, 'Form 137', 'Avila', '12 - Ritchie', '12331', 'LHS', '2026-02-28 02:13:19', 'Pending', 'Registrar', '1772241199_Gemini_Generated_Image_qne5wiqne5wiqne5.png'),
(30, NULL, 'LHS_aceeb9ce', 2147483647, 'Birth Certificate', 'Avila', '12 - Ritchie', '12331', 'LHS', '2026-02-28 02:13:42', 'Pending', 'Registrar', '1772241222_R.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `password_requests`
--

CREATE TABLE `password_requests` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','resolved') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_requests`
--

INSERT INTO `password_requests` (`id`, `username`, `request_date`, `status`) VALUES
(1, 'test', '2026-02-25 21:27:59', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `middle_initial` varchar(5) NOT NULL,
  `age` int(11) NOT NULL,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `firstname`, `lastname`, `middle_initial`, `age`, `date_created`) VALUES
(123234, 'testerrrrrr', '', '', 0, '2026-02-28 09:42:00'),
(1232345, 'test', '', '', 0, '2026-02-28 09:42:00'),
(1336678, 'Abad', 'Ali', '', 0, '2026-02-28 09:42:00'),
(2147483647, 'Avila', '', '', 0, '2026-02-28 09:42:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('admin','staff') NOT NULL DEFAULT 'staff',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `email`, `role`, `status`, `created_at`, `profile_image`) VALUES
(7, 'tester', '$2y$10$pxNKB00nFxjCz2xNEPTRQua9NK.McYsyFLf6Nh9LIUb.emBxATCsi', 'Christopher Llorca', NULL, 'admin', 'active', '2026-02-25 19:09:58', NULL),
(8, 'Test', '$2y$10$Gae1TrNzJzSGqCn.VKTHueU9DBoWOFR/Lo7PG6ZEJQ/ZjCNEWiy2S', 'Christian', NULL, 'staff', 'active', '2026-02-25 19:28:18', 'profile_pics/user_8_1772240235.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tracking_number` (`tracking_number`),
  ADD KEY `fk_student_record` (`student_id_fk`);

--
-- Indexes for table `password_requests`
--
ALTER TABLE `password_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `password_requests`
--
ALTER TABLE `password_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483648;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `fk_student_record` FOREIGN KEY (`student_id_fk`) REFERENCES `students` (`student_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
