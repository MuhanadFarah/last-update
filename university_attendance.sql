-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 11, 2025 at 03:01 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `university_attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password_hash`) VALUES
(1, 'Muhanad Farah Abdi', '$2y$10$5LN96OXz2gqe2NEfZ9M1R.raq/yzsobF3c9exNo5MVkRPs2BSVcKe');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `faculty` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `student_name`, `faculty`, `date`, `created_at`, `teacher_id`) VALUES
(2, '8601', 'Asha Guled', 'Civil Engineering', '2025-07-03', '2025-07-03 10:08:00', 1),
(3, '8602', 'Ayaan Ahmed', 'Electrical Engineering', '2025-07-03', '2025-07-03 10:18:08', 1),
(4, '8603', 'Ifrah Abshir', 'Information Technology', '2025-07-03', '2025-07-03 10:37:10', 1),
(5, '8604', 'Ahmed Dirie', 'Electrical Engineering', '2025-07-03', '2025-07-03 10:45:42', 1),
(7, '6897', 'Muhanad Farah', 'Information Tecgnology', '2025-07-03', '2025-07-03 13:08:20', 2),
(8, '6777', 'Nasteexo Ahmed', 'Information Technology', '2025-07-03', '2025-07-03 14:04:28', 3),
(9, '6700', 'Muhanad FARAH', 'IT', '2025-07-03', '2025-07-03 14:31:58', 4),
(10, '8655', 'Hassan Osman', 'Nursing', '2025-07-03', '2025-07-03 14:43:00', 1),
(11, '7000', 'Sacdiyo Ahmed', 'Information Technology', '2025-07-03', '2025-07-03 15:58:45', 5),
(12, '8659', 'Omar Guled', 'Agriculture', '2025-07-04', '2025-07-04 10:37:17', 6),
(13, '6456', 'Yahye', 'IT', '2025-07-04', '2025-07-04 10:38:09', 6),
(14, '8601', 'Asha Guled', 'Civil Engineering', '2025-07-04', '2025-07-04 10:57:06', 1),
(15, '8600', 'Sahra Muse', 'Nursing', '2025-07-05', '2025-07-05 17:30:55', 7);

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `faculty` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_id`, `name`, `faculty`) VALUES
(1, '8600', 'Sahra Muse', 'Nursing'),
(2, '8601', 'Asha Guled', 'Civil Engineering'),
(3, '8602', 'Ayaan Ahmed', 'Electrical Engineering'),
(4, '8603', 'Ifrah Abshir', 'Information Technology'),
(5, '8604', 'Ahmed Dirie', 'Electrical Engineering'),
(6, '8605', 'Mohamed Guled', 'Nursing'),
(7, '8606', 'Ahmed Ahmed', 'Business Administration'),
(8, '8607', 'Fatima Farah', 'Public Administration'),
(9, '8608', 'Zahra Mohamud', 'Agriculture'),
(10, '8609', 'Ifrah Ali', 'Medicine'),
(11, '8610', 'Omar Ali', 'Nursing'),
(12, '8611', 'Asha Mohamed', 'Civil Engineering'),
(13, '8612', 'Sahra Abshir', 'Business Administration'),
(14, '8613', 'Hassan Guled', 'Civil Engineering'),
(15, '8614', 'Ahmed Hassan', 'Nursing'),
(16, '8615', 'Mohamed Dirie', 'Electrical Engineering'),
(17, '8616', 'Mohamed Farah', 'Public Administration'),
(18, '8617', 'Yusuf Shire', 'Electrical Engineering'),
(19, '8618', 'Khalid Shire', 'Agriculture'),
(20, '8619', 'Ilhan Ahmed', 'Civil Engineering'),
(21, '8620', 'Naima Barre', 'Nursing'),
(22, '8621', 'Ismail Osman', 'Agriculture'),
(23, '8622', 'Hodan Dirie', 'Civil Engineering'),
(24, '8623', 'Naima Hassan', 'Business Administration'),
(25, '8624', 'Mohamed Muse', 'Civil Engineering'),
(26, '8625', 'Sahra Ahmed', 'Agriculture'),
(27, '8626', 'Omar Muse', 'Medicine'),
(28, '8627', 'Liban Hassan', 'Petroleum Engineering'),
(29, '8628', 'Ayaan Jama', 'Medicine'),
(30, '8629', 'Mohamed Dirie', 'Information Technology'),
(31, '8630', 'Naima Hassan', 'Agriculture'),
(32, '8631', 'Ilhan Abdullahi', 'Information Technology'),
(33, '8632', 'Maryan Muse', 'Agriculture'),
(34, '8633', 'Asha Gelle', 'Business Administration'),
(35, '8634', 'Hassan Abshir', 'Electrical Engineering'),
(36, '8635', 'Hodan Osman', 'Electrical Engineering'),
(37, '8636', 'Sahra Khalif', 'Public Administration'),
(38, '8637', 'Maryan Roble', 'Computer Science'),
(39, '8638', 'Maryan Dirie', 'Public Administration'),
(40, '8639', 'Abdi Ahmed', 'Public Administration'),
(41, '8640', 'Sahra Shire', 'Information Technology'),
(42, '8641', 'Yusuf Dirie', 'Computer Science'),
(43, '8642', 'Ahmed Ahmed', 'Computer Science'),
(44, '8643', 'Mohamed Guled', 'Medicine'),
(45, '8644', 'Liban Guled', 'Petroleum Engineering'),
(46, '8645', 'Ismail Jama', 'Civil Engineering'),
(47, '8646', 'Naima Ali', 'Agriculture'),
(48, '8647', 'Zahra Mohamed', 'Petroleum Engineering'),
(49, '8648', 'Ayaan Mohamed', 'Electrical Engineering'),
(50, '8649', 'Zahra Mohamed', 'Business Administration'),
(51, '8650', 'Asha Farah', 'Agriculture'),
(52, '8651', 'Naima Ahmed', 'Information Technology'),
(53, '8652', 'Khalid Barre', 'Petroleum Engineering'),
(54, '8653', 'Ifrah Mohamed', 'Computer Science'),
(55, '8654', 'Hassan Mohamud', 'Agriculture'),
(56, '8655', 'Hassan Osman', 'Nursing'),
(57, '8656', 'Fatima Farah', 'Medicine'),
(58, '8657', 'Hassan Guled', 'Petroleum Engineering'),
(59, '8658', 'Sahra Khalif', 'Civil Engineering'),
(60, '8659', 'Omar Guled', 'Agriculture'),
(61, '8660', 'Omar Gelle', 'Nursing'),
(62, '8661', 'Ilhan Ahmed', 'Agriculture'),
(63, '8662', 'Yusuf Barre', 'Medicine'),
(64, '8663', 'Ismail Shire', 'Medicine'),
(65, '8664', 'Fatima Dirie', 'Civil Engineering'),
(66, '8665', 'Omar Gelle', 'Computer Science'),
(67, '8666', 'Asha Dirie', 'Nursing'),
(68, '8667', 'Sahra Barre', 'Electrical Engineering'),
(69, '8668', 'Ahmed Osman', 'Business Administration'),
(70, '8669', 'Maryan Gelle', 'Information Technology'),
(71, '8670', 'Omar Khalif', 'Civil Engineering'),
(72, '8671', 'Hodan Mohamud', 'Electrical Engineering'),
(73, '8672', 'Liban Mohamed', 'Computer Science'),
(74, '8673', 'Omar Roble', 'Public Administration'),
(75, '8674', 'Ahmed Roble', 'Computer Science'),
(76, '8675', 'Omar Osman', 'Civil Engineering'),
(77, '8676', 'Abdi Ali', 'Agriculture'),
(78, '8677', 'Hassan Roble', 'Medicine'),
(79, '8678', 'Ismail Hassan', 'Civil Engineering'),
(80, '8679', 'Liban Mahad', 'Nursing'),
(81, '8680', 'Liban Jama', 'Agriculture'),
(82, '8681', 'Ali Nur', 'Medicine'),
(83, '8682', 'Asha Mohamud', 'Electrical Engineering'),
(84, '8683', 'Asha Ahmed', 'Information Technology'),
(85, '8684', 'Fatima Khalif', 'Medicine'),
(86, '8685', 'Ayaan Guled', 'Electrical Engineering'),
(87, '8686', 'Ismail Nur', 'Business Administration'),
(88, '8687', 'Sahra Shire', 'Civil Engineering'),
(89, '8688', 'Ilhan Roble', 'Electrical Engineering'),
(90, '8689', 'Zahra Farah', 'Business Administration'),
(91, '8690', 'Naima Gelle', 'Computer Science'),
(92, '8691', 'Ilhan Jama', 'Nursing'),
(93, '8692', 'Omar Muse', 'Computer Science'),
(94, '8693', 'Mohamed Gelle', 'Nursing'),
(95, '8694', 'Liban Osman', 'Petroleum Engineering'),
(96, '8695', 'Hassan Hassan', 'Public Administration'),
(97, '8696', 'Maryan Mohamud', 'Public Administration'),
(98, '8697', 'Fatima Ali', 'Medicine'),
(99, '8698', 'Sahra Mohamud', 'Business Administration'),
(100, '8699', 'Maryan Barre', 'Civil Engineering');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `must_change_password` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `phone`, `password`, `created_at`, `must_change_password`) VALUES
(1, 'Abdi Mohamed', '252907440616', '$2y$10$yH5vhF5jEO49ORvPRPeX4uzwsVXfNVtje9Q0qoejrv3WG3Z6yihwy', '2025-07-02 11:14:45', 0),
(2, 'Hodan Ali', '252906739721', '$2y$10$o2IdSVqS35wtQ3/odNRnz.KW9giwJ3GqTN8GK03Y2RxzcHGBd/99W', '2025-07-02 11:14:45', 0),
(3, 'Mohamed Yusuf', '252612345003', '$2y$10$kdmTim0xiEpBqrsdMS3aQ.wFmINYuYPzdh2NZA5tMzky2RQ6oJybO', '2025-07-02 11:14:45', 0),
(4, 'Fadumo Warsame', '252612345004', '$2y$10$K4q9FipCRXbLNdfCevoDMuuk14RmRL0sZKRkDjK5JgJmghoZV8kYu', '2025-07-02 11:14:45', 0),
(5, 'Nasteexo Ahmed', '252907991021', '$2y$10$DhPIlR3sxrqN69NdiJtg9OqFF.theouoU1an9E0gZIkL6EM2Fp/T.', '2025-07-02 11:14:45', 0),
(6, 'Yahya abdi', '252906168773', '$2y$10$dj3Pl409HTdffCKIznZakePiY2aeeh913LypxK/4cTiOQ3WsBYAYi', '2025-07-02 11:14:45', 0),
(7, 'Ismail Noor', '252612345007', '$2y$10$NXi4k2YxZsXb3MnIJY0qLOWsokdpmWggZRn64rLBylEJZ22kQVGJm', '2025-07-02 11:14:45', 0),
(8, 'Sahra Abdi', '252612345008', '$2y$10$JQS0GIuE/upaYga8Eh2YhuLyKQkKEF20NK8r9.8GGQulJVLn8DuPi', '2025-07-02 11:14:45', 1),
(9, 'Ali Hassan', '252612345009', '$2y$10$JQS0GIuE/upaYga8Eh2YhuLyKQkKEF20NK8r9.8GGQulJVLn8DuPi', '2025-07-02 11:14:45', 1),
(10, 'Zahra Mohamed', '252612345010', '$2y$10$JQS0GIuE/upaYga8Eh2YhuLyKQkKEF20NK8r9.8GGQulJVLn8DuPi', '2025-07-02 11:14:45', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
