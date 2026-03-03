-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2026 at 08:00 PM
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
  `student_id` varchar(50) DEFAULT NULL,
  `doc_type` varchar(50) NOT NULL,
  `student_name` varchar(50) NOT NULL,
  `grade_section` varchar(50) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `from_school` varchar(100) NOT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL,
  `current_location` varchar(100) DEFAULT 'Registrar',
  `file_path` varchar(255) DEFAULT NULL,
  `document_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `student_id_fk`, `tracking_number`, `student_id`, `doc_type`, `student_name`, `grade_section`, `contact`, `from_school`, `date_created`, `status`, `current_location`, `file_path`, `document_file`) VALUES
(1, NULL, 'DOC-6909494e115b7', NULL, 'Enrollment Records', 'Biboy', '12-Ritchie', '09164416096', 'San Agustin Elementary School', '2025-11-04 00:00:00', 'Outgoing', 'Registrar', NULL, NULL),
(47, NULL, 'LHS_389F7FD4', '123456789101', 'Birth Certificate', 'Christopher Llorca', '12 - Ritchie', '091234567890', 'LHS', '2026-03-03 19:31:25', 'Pending', 'Registrar', '1772562685_R.jpg', NULL),
(48, NULL, 'LHS_AF4A09D8', '123456789', 'Form 137', 'Chris', '12 - Ritchie', '122', 'N/A', '2026-03-03 19:32:58', 'Pending', 'Registrar', '1772562778_pc.jpg', NULL),
(49, NULL, 'LHS_679F0D77', '123456789', 'Report Card', 'Chris', '12 - Ritchie', '122', 'N/A', '2026-03-03 19:35:33', 'Pending', 'Registrar', '1772562933_R.jpg', NULL),
(50, NULL, 'LHS_DD1BD1C9', '123456789', 'Form 137', 'Chris', '12 - Ritchie', '122', 'N/A', '2026-03-03 19:36:20', 'Pending', 'Registrar', '1772562980_IMG_1604.JPG', NULL),
(51, NULL, 'LHS_9EF251BD', '1', 'Birth Certificate', 'Art Mubarak', '12 - Ritchie', '09123', 'ninja', '2026-03-03 19:38:20', 'Pending', 'Registrar', '1772563100_63-IMG_5119.jpg', NULL);

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

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` varchar(50) NOT NULL,
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
('1', 'Art', 'Mubarak', '', 0, '2026-03-04 02:38:20'),
('123456789', 'Chris', 'N/A', '', 0, '2026-03-04 02:32:58'),
('123456789101', 'Christopher', 'Llorca', '', 0, '2026-03-04 02:31:25');

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
  `role` varchar(50) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `email`, `role`, `status`, `created_at`, `profile_image`) VALUES
(19, 'admin_chris', '$2y$10$KmiAHLidTowK8prKzMyBVe72ZPPNxzEKlJHfjwN2t5ws.95f2jT46', 'Christopher Llorca', NULL, 'admin', 'active', '2026-02-28 02:50:20', 'profile_pics/user_19_1772559138.jpg'),
(21, 'forgot', '$2y$10$uej2QYTAvxqG/Mkpx75ScePGJRWn35iRYIVSay0yQRGdk8F.zANWe', 'Christopher Llorca', NULL, 'staff', 'inactive', '2026-02-28 02:59:51', NULL),
(22, 'staff_chris', '$2y$10$vxYoTivZ7AbmXgGHrEFwL.jDa6gU3TuYrKZ/ayrT8qLYtzLLQHL96', 'Christopher Llorca', NULL, 'admin', 'active', '2026-02-28 03:01:16', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `password_requests`
--
ALTER TABLE `password_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
