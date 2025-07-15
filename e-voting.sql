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
-- Database: `e-voting`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_first_login` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `phone`, `password`, `is_first_login`) VALUES
(1, '+252907440616', '$2y$10$lsZNMSR31RSQgyOGQGwUYes.39vBt.A3PpnD2i/R6oF/uwn1IIDXO', 0),
(2, '+252907251502', '$2y$10$HgEUMbccNYk/GVqqHPFUQ.uk8aA44tb/QWv.3lLbebQaqAiGIjjVu', 0);

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `name`) VALUES
(7000, 'Maido Abdirashid'),
(7001, 'Mudalib Jamac'),
(7002, 'Abshir Hassan'),
(7003, 'Abshir Bashir'),
(7004, 'Abdullahi belgam'),
(7005, 'Rahma Yusuf'),
(7006, 'Yasmiin Abdullahi'),
(7007, 'Sayid Jamac'),
(7008, 'Saciid Deni');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `faculty` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `faculty`) VALUES
(6801, 'Muhanad Farah', 'Information Technology'),
(8602, 'Layla Musa', 'Economics'),
(8603, 'Hassan Musa', 'Business'),
(8604, 'Ali Hussein', 'Engineering'),
(8605, 'Sagal Mohamed', 'Business'),
(8606, 'Yusuf Yusuf', 'Business'),
(8607, 'Said Khalif', 'Nursing'),
(8608, 'Samira Said', 'Business'),
(8609, 'Khadija Ismail', 'Information Technology'),
(8610, 'Omar Ismail', 'Medicine'),
(8611, 'Fadumo Jama', 'Engineering'),
(8612, 'Hassan Ismail', 'Engineering'),
(8613, 'Hawa Said', 'Information Technology'),
(8614, 'Mahad Farah', 'Business'),
(8615, 'Halima Khalif', 'Business'),
(8616, 'Mohamud Abdulahi', 'Medicine'),
(8617, 'Ayan Said', 'Information Technology'),
(8618, 'Hodan Said', 'Nursing'),
(8619, 'Salah Omar', 'Business'),
(8620, 'Omar Farah', 'Nursing'),
(8621, 'Sagal Salad', 'Medicine'),
(8622, 'Omar Ismail', 'Education'),
(8623, 'Khadija Haji', 'Engineering'),
(8624, 'Samira Abdi', 'Education'),
(8625, 'Salah Ali', 'Education'),
(8626, 'Sagal Ali', 'Medicine'),
(8627, 'Fadumo Nur', 'Engineering'),
(8628, 'Barwaaqo Abdulahi', 'Medicine'),
(8629, 'Said Salad', 'Economics'),
(8630, 'Zahra Nur', 'Nursing'),
(8631, 'Mohamed Ahmed', 'Medicine'),
(8632, 'Ismail Salad', 'Medicine'),
(8633, 'Fatima Mohamed', 'Education'),
(8634, 'Mahad Haji', 'Medicine'),
(8635, 'Fadumo Jama', 'Economics'),
(8636, 'Yusuf Khalif', 'Information Technology'),
(8637, 'Yusuf Adam', 'Nursing'),
(8638, 'Layla Jama', 'Medicine'),
(8639, 'Khadar Khalif', 'Nursing'),
(8640, 'Bashir Mohamed', 'Nursing'),
(8641, 'Hawa Haji', 'Engineering'),
(8642, 'Jama Jama', 'Nursing'),
(8643, 'Ali Nur', 'Education'),
(8644, 'Mahad Ahmed', 'Engineering'),
(8645, 'Amina Mohamed', 'Business'),
(8646, 'Salah Ahmed', 'Medicine'),
(8647, 'Hodan Adam', 'Business'),
(8648, 'Yusuf Omar', 'Economics'),
(8649, 'Ahmed Ahmed', 'Economics'),
(8650, 'Layla Omar', 'Economics'),
(8651, 'Nur Omar', 'Nursing'),
(8652, 'Yusuf Nur', 'Business'),
(8653, 'Layla Mohamed', 'Business'),
(8654, 'Idris Said', 'Nursing'),
(8655, 'Mahamed Ahmed', 'Information Technology'),
(8656, 'Salah Ahmed', 'Business'),
(8657, 'Abdi Haji', 'Medicine'),
(8658, 'Ali Ismail', 'Information Technology'),
(8659, 'Jama Said', 'Education'),
(8660, 'Mohamed Omar', 'Economics'),
(8661, 'Maryan Omar', 'Nursing'),
(8662, 'Liban Haji', 'Information Technology'),
(8663, 'Nur Ibrahim', 'Education'),
(8664, 'Ayan Adam', 'Business'),
(8665, 'Bashir Abdulahi', 'Engineering'),
(8666, 'Farah Hassan', 'Economics'),
(8667, 'Sagal Nur', 'Nursing'),
(8668, 'Hassan Abdi', 'Economics'),
(8669, 'Samira Hassan', 'Education'),
(8670, 'Ayan Hassan', 'Economics'),
(8671, 'Yusuf Mohamed', 'Information Technology'),
(8672, 'Nasra Ismail', 'Education'),
(8673, 'Fatima Yusuf', 'Nursing'),
(8674, 'Ayan Yusuf', 'Nursing'),
(8675, 'Mahamed Ahmed', 'Business'),
(8676, 'Zahra Mohamed', 'Information Technology'),
(8677, 'Fatima Abdi', 'Information Technology'),
(8678, 'Yusuf Ibrahim', 'Education'),
(8679, 'Liban Salad', 'Education'),
(8680, 'Nasra Ismail', 'Nursing'),
(8681, 'Liban Jama', 'Information Technology'),
(8682, 'Mohamud Said', 'Nursing'),
(8683, 'Mahad Hassan', 'Nursing'),
(8684, 'Ali Jama', 'Information Technology'),
(8685, 'Idris Adam', 'Nursing'),
(8686, 'Layla Khalif', 'Education'),
(8687, 'Yusuf Farah', 'Information Technology'),
(8688, 'Khadija Ibrahim', 'Education'),
(8689, 'Khadar Ismail', 'Information Technology'),
(8690, 'Amina Musa', 'Economics'),
(8691, 'Nur Abdi', 'Education'),
(8692, 'Ayan Hussein', 'Economics'),
(8693, 'Jama Abdulahi', 'Nursing'),
(8694, 'Yasmin Farah', 'Economics'),
(8695, 'Ali Adam', 'Education'),
(8696, 'Mahamed Nur', 'Education'),
(8697, 'Idris Khalif', 'Nursing'),
(8698, 'Yusuf Abdi', 'Education'),
(8699, 'Halima Ismail', 'Medicine'),
(8700, 'Abdi Khalif', 'Economics'),
(8701, 'Omar Jama', 'Economics'),
(8702, 'Liban Ali', 'Business'),
(8703, 'Mahamed Yusuf', 'Education'),
(8704, 'Halima Mohamed', 'Education'),
(8705, 'Hawa Jama', 'Economics'),
(8706, 'Jama Farah', 'Education'),
(8707, 'Omar Ali', 'Economics'),
(8708, 'Fatima Jama', 'Economics'),
(8709, 'Hodan Mohamed', 'Nursing'),
(8710, 'Said Ali', 'Nursing'),
(8711, 'Hodan Musa', 'Education'),
(8712, 'Ahmed Yusuf', 'Nursing'),
(8713, 'Abdi Abdi', 'Engineering'),
(8714, 'Ismail Salad', 'Business'),
(8715, 'Hassan Musa', 'Medicine'),
(8716, 'Mahad Abdi', 'Nursing'),
(8717, 'Said Ahmed', 'Information Technology'),
(8718, 'Sagal Hussein', 'Economics'),
(8719, 'Sagal Ismail', 'Business'),
(8720, 'Hassan Ismail', 'Business'),
(8721, 'Saida Hussein', 'Information Technology'),
(8722, 'Maryan Mohamed', 'Economics'),
(8723, 'Asha Abdulahi', 'Economics'),
(8724, 'Asha Abdi', 'Information Technology'),
(8725, 'Ayan Mohamed', 'Nursing'),
(8726, 'Liban Abdulahi', 'Economics'),
(8727, 'Amina Yusuf', 'Education'),
(8728, 'Yasmin Abdi', 'Business'),
(8729, 'Salah Omar', 'Economics'),
(8730, 'Layla Khalif', 'Business'),
(8731, 'Fadumo Adam', 'Engineering'),
(8732, 'Layla Haji', 'Engineering'),
(8733, 'Mahamed Abdi', 'Nursing'),
(8734, 'Ismail Musa', 'Economics'),
(8735, 'Omar Khalif', 'Engineering'),
(8736, 'Abdi Ali', 'Information Technology'),
(8737, 'Hodan Mohamed', 'Education'),
(8738, 'Mohamed Farah', 'Nursing'),
(8739, 'Bashir Salad', 'Medicine'),
(8740, 'Hassan Haji', 'Information Technology'),
(8741, 'Yusuf Adam', 'Nursing'),
(8742, 'Ismail Hassan', 'Engineering'),
(8743, 'Layla Said', 'Nursing'),
(8744, 'Mohamud Haji', 'Nursing'),
(8745, 'Samira Said', 'Business'),
(8746, 'Bashir Salad', 'Education'),
(8747, 'Filsan Jama', 'Education'),
(8748, 'Nasra Haji', 'Medicine'),
(8749, 'Omar Hassan', 'Medicine'),
(8750, 'Amina Ali', 'Business'),
(8751, 'Nasra Hussein', 'Education'),
(8752, 'Layla Ahmed', 'Education'),
(8753, 'Yusuf Salad', 'Medicine'),
(8754, 'Yasmin Said', 'Nursing'),
(8755, 'Salah Nur', 'Engineering'),
(8756, 'Jama Ismail', 'Education'),
(8757, 'Ayan Omar', 'Education'),
(8758, 'Barwaaqo Nur', 'Information Technology'),
(8759, 'Mahamed Omar', 'Medicine'),
(8760, 'Fadumo Adam', 'Engineering'),
(8761, 'Fatima Ismail', 'Medicine'),
(8762, 'Mohamud Abdulahi', 'Information Technology'),
(8763, 'Ismail Ismail', 'Education'),
(8764, 'Mohamed Jama', 'Medicine'),
(8765, 'Halima Musa', 'Education'),
(8766, 'Hodan Musa', 'Information Technology'),
(8767, 'Jama Yusuf', 'Education'),
(8768, 'Zahra Abdi', 'Education'),
(8769, 'Abdirahman Farah', 'Nursing'),
(8770, 'Said Abdulahi', 'Business'),
(8771, 'Khadar Adam', 'Nursing'),
(8772, 'Saida Yusuf', 'Education'),
(8773, 'Samira Ahmed', 'Engineering'),
(8774, 'Hodan Khalif', 'Business'),
(8775, 'Mohamud Jama', 'Nursing'),
(8776, 'Fadumo Omar', 'Business'),
(8777, 'Hawa Hassan', 'Nursing'),
(8778, 'Nasra Jama', 'Economics'),
(8779, 'Idris Salad', 'Education'),
(8780, 'Hassan Mohamed', 'Business'),
(8781, 'Zahra Ibrahim', 'Nursing'),
(8782, 'Zahra Ismail', 'Business'),
(8783, 'Ismail Ali', 'Nursing'),
(8784, 'Abdi Abdi', 'Engineering'),
(8785, 'Layla Omar', 'Economics'),
(8786, 'Barwaaqo Ismail', 'Nursing'),
(8787, 'Said Khalif', 'Economics'),
(8788, 'Halima Farah', 'Medicine'),
(8789, 'Abdi Abdulahi', 'Education'),
(8790, 'Ayan Jama', 'Nursing'),
(8791, 'Halima Farah', 'Nursing'),
(8792, 'Mahad Salad', 'Education'),
(8793, 'Samira Adam', 'Engineering'),
(8794, 'Liban Omar', 'Engineering'),
(8795, 'Ahmed Abdi', 'Business'),
(8796, 'Fadumo Hassan', 'Business'),
(8797, 'Yusuf Musa', 'Engineering'),
(8798, 'Yusuf Ismail', 'Education'),
(8799, 'Yasmin Jama', 'Business'),
(8800, 'Fatima Adam', 'Information Technology'),
(8801, 'Ayan Haji', 'Nursing'),
(8802, 'Said Khalif', 'Information Technology'),
(8803, 'Khadija Hassan', 'Engineering'),
(8804, 'Sagal Ismail', 'Medicine'),
(8805, 'Barwaaqo Hussein', 'Nursing'),
(8806, 'Fatima Nur', 'Education'),
(8807, 'Filsan Haji', 'Economics'),
(8808, 'Halima Musa', 'Engineering'),
(8809, 'Filsan Haji', 'Engineering'),
(8810, 'Fatima Ismail', 'Education'),
(8811, 'Said Nur', 'Business'),
(8812, 'Mohamud Adam', 'Medicine'),
(8813, 'Ismail Hussein', 'Education'),
(8814, 'Jama Abdulahi', 'Medicine'),
(8815, 'Maryan Ismail', 'Medicine'),
(8816, 'Ali Ibrahim', 'Nursing'),
(8817, 'Nur Mohamed', 'Nursing'),
(8818, 'Jama Mohamed', 'Nursing'),
(8819, 'Sagal Hussein', 'Education'),
(8820, 'Asha Musa', 'Engineering'),
(8821, 'Khadar Abdulahi', 'Nursing'),
(8822, 'Layla Haji', 'Education'),
(8823, 'Khadija Ahmed', 'Engineering'),
(8824, 'Amina Farah', 'Economics'),
(8825, 'Farah Adam', 'Nursing'),
(8826, 'Liban Ibrahim', 'Economics'),
(8827, 'Khadar Haji', 'Education'),
(8828, 'Ayan Said', 'Nursing'),
(8829, 'Mahad Jama', 'Education'),
(8830, 'Fadumo Hassan', 'Engineering'),
(8831, 'Zahra Ibrahim', 'Business'),
(8832, 'Mohamud Ali', 'Business'),
(8833, 'Hawa Hussein', 'Business'),
(8834, 'Abdirahman Mohamed', 'Nursing'),
(8835, 'Hodan Hassan', 'Information Technology'),
(8836, 'Said Khalif', 'Business'),
(8837, 'Fatima Abdulahi', 'Medicine'),
(8838, 'Yusuf Omar', 'Education'),
(8839, 'Salah Adam', 'Engineering'),
(8840, 'Farah Abdi', 'Medicine'),
(8841, 'Filsan Adam', 'Business'),
(8842, 'Zahra Hassan', 'Education'),
(8843, 'Yasmin Hassan', 'Medicine'),
(8844, 'Mohamud Haji', 'Medicine'),
(8845, 'Saida Farah', 'Information Technology'),
(8846, 'Hodan Hassan', 'Economics'),
(8847, 'Mohamud Adam', 'Medicine'),
(8848, 'Salah Ali', 'Information Technology'),
(8849, 'Ayan Ali', 'Nursing'),
(8850, 'Mohamud Musa', 'Nursing'),
(8851, 'Fadumo Haji', 'Economics'),
(8852, 'Bashir Said', 'Nursing'),
(8853, 'Mahad Omar', 'Education'),
(8854, 'Hassan Nur', 'Information Technology'),
(8855, 'Samira Khalif', 'Economics'),
(8856, 'Bashir Omar', 'Medicine'),
(8857, 'Mahad Ahmed', 'Medicine'),
(8858, 'Zahra Ibrahim', 'Education'),
(8859, 'Idris Khalif', 'Engineering'),
(8860, 'Mahamed Yusuf', 'Business'),
(8861, 'Barwaaqo Ali', 'Engineering'),
(8862, 'Halima Yusuf', 'Education'),
(8863, 'Hassan Yusuf', 'Business'),
(8864, 'Jama Musa', 'Nursing'),
(8865, 'Ali Abdulahi', 'Medicine'),
(8866, 'Hodan Khalif', 'Business'),
(8867, 'Said Ahmed', 'Business'),
(8868, 'Said Haji', 'Engineering'),
(8869, 'Filsan Mohamed', 'Engineering'),
(8870, 'Said Jama', 'Information Technology'),
(8871, 'Farah Jama', 'Business'),
(8872, 'Asha Hussein', 'Business'),
(8873, 'Yusuf Ibrahim', 'Information Technology'),
(8874, 'Saida Adam', 'Information Technology'),
(8875, 'Sagal Yusuf', 'Nursing'),
(8876, 'Sagal Omar', 'Medicine'),
(8877, 'Zahra Jama', 'Nursing'),
(8878, 'Fadumo Musa', 'Business'),
(8879, 'Halima Abdi', 'Education'),
(8880, 'Omar Khalif', 'Medicine'),
(8881, 'Hodan Jama', 'Business'),
(8882, 'Mohamud Hussein', 'Economics'),
(8883, 'Fadumo Abdulahi', 'Information Technology'),
(8884, 'Mohamed Ismail', 'Engineering'),
(8885, 'Sagal Hassan', 'Information Technology'),
(8886, 'Sagal Abdulahi', 'Information Technology'),
(8887, 'Barwaaqo Nur', 'Economics'),
(8888, 'Omar Salad', 'Information Technology'),
(8889, 'Barwaaqo Abdulahi', 'Education'),
(8890, 'Samira Abdulahi', 'Information Technology'),
(8891, 'Saida Haji', 'Business'),
(8892, 'Maryan Jama', 'Economics'),
(8893, 'Farah Adam', 'Engineering'),
(8894, 'Mahamed Salad', 'Economics'),
(8895, 'Hodan Ali', 'Engineering'),
(8896, 'Hodan Ibrahim', 'Business'),
(8897, 'Ahmed Adam', 'Engineering'),
(8898, 'Maryan Adam', 'Education'),
(8899, 'Said Abdulahi', 'Information Technology'),
(8900, 'Ayan Ibrahim', 'Business'),
(8901, 'Maryan Nur', 'Education'),
(8902, 'Idris Hussein', 'Economics'),
(8903, 'Mahad Abdi', 'Information Technology'),
(8904, 'Nur Musa', 'Education'),
(8905, 'Liban Musa', 'Business'),
(8906, 'Hawa Haji', 'Education'),
(8907, 'Maryan Said', 'Nursing'),
(8908, 'Fadumo Salad', 'Information Technology'),
(8909, 'Sagal Nur', 'Nursing'),
(8910, 'Khadar Omar', 'Economics'),
(8911, 'Bashir Omar', 'Business'),
(8912, 'Asha Ismail', 'Engineering'),
(8913, 'Asha Haji', 'Medicine'),
(8914, 'Nur Adam', 'Nursing'),
(8915, 'Ali Salad', 'Engineering'),
(8916, 'Bashir Yusuf', 'Economics'),
(8917, 'Omar Farah', 'Information Technology'),
(8918, 'Farah Hassan', 'Nursing'),
(8919, 'Fadumo Yusuf', 'Engineering'),
(8920, 'Abdi Hassan', 'Business'),
(8921, 'Farah Abdi', 'Business'),
(8922, 'Farah Omar', 'Information Technology'),
(8923, 'Farah Farah', 'Information Technology'),
(8924, 'Idris Salad', 'Medicine'),
(8925, 'Samira Ali', 'Nursing'),
(8926, 'Nasra Musa', 'Nursing'),
(8927, 'Mohamed Khalif', 'Information Technology'),
(8928, 'Ayan Musa', 'Economics'),
(8929, 'Fatima Farah', 'Education'),
(8930, 'Idris Abdi', 'Information Technology'),
(8931, 'Liban Omar', 'Business'),
(8932, 'Asha Yusuf', 'Engineering'),
(8933, 'Yusuf Adam', 'Economics'),
(8934, 'Salah Hassan', 'Economics'),
(8935, 'Layla Nur', 'Medicine'),
(8936, 'Sagal Ahmed', 'Economics'),
(8937, 'Khadija Hussein', 'Engineering'),
(8938, 'Samira Ibrahim', 'Engineering'),
(8939, 'Hassan Abdulahi', 'Engineering'),
(8940, 'Fadumo Hussein', 'Economics'),
(8941, 'Mohamed Jama', 'Information Technology'),
(8942, 'Fadumo Ali', 'Nursing'),
(8943, 'Mahad Hussein', 'Engineering'),
(8944, 'Ismail Ali', 'Medicine'),
(8945, 'Barwaaqo Abdi', 'Economics'),
(8946, 'Said Jama', 'Nursing'),
(8947, 'Hodan Ahmed', 'Engineering'),
(8948, 'Mohamud Hussein', 'Economics'),
(8949, 'Hodan Khalif', 'Nursing'),
(8950, 'Halima Musa', 'Business'),
(8951, 'Ahmed Hussein', 'Engineering'),
(8952, 'Hodan Said', 'Business'),
(8953, 'Abdirahman Khalif', 'Business'),
(8954, 'Abdi Ismail', 'Information Technology'),
(8955, 'Khadija Jama', 'Nursing'),
(8956, 'Bashir Mohamed', 'Education'),
(8957, 'Nasra Ibrahim', 'Education'),
(8958, 'Zahra Nur', 'Medicine'),
(8959, 'Mahad Ahmed', 'Education'),
(8960, 'Abdirahman Omar', 'Education'),
(8961, 'Fadumo Musa', 'Economics'),
(8962, 'Nasra Farah', 'Engineering'),
(8963, 'Maryan Adam', 'Engineering'),
(8964, 'Said Ahmed', 'Engineering'),
(8965, 'Khadar Hussein', 'Engineering'),
(8966, 'Khadija Abdulahi', 'Economics'),
(8967, 'Salah Abdulahi', 'Information Technology'),
(8968, 'Sagal Omar', 'Information Technology'),
(8969, 'Idris Yusuf', 'Nursing'),
(8970, 'Mohamud Hussein', 'Nursing'),
(8971, 'Bashir Ali', 'Information Technology'),
(8972, 'Khadar Omar', 'Nursing'),
(8973, 'Yasmin Farah', 'Nursing'),
(8974, 'Samira Adam', 'Medicine'),
(8975, 'Mohamed Abdulahi', 'Education'),
(8976, 'Idris Abdulahi', 'Medicine'),
(8977, 'Asha Mohamed', 'Economics'),
(8978, 'Hawa Musa', 'Engineering'),
(8979, 'Said Omar', 'Nursing'),
(8980, 'Fadumo Khalif', 'Engineering'),
(8981, 'Said Ahmed', 'Nursing'),
(8982, 'Jama Salad', 'Economics'),
(8983, 'Nasra Khalif', 'Business'),
(8984, 'Khadija Hassan', 'Economics'),
(8985, 'Ismail Hussein', 'Education'),
(8986, 'Hodan Ahmed', 'Business'),
(8987, 'Hassan Ahmed', 'Education'),
(8988, 'Bashir Farah', 'Medicine'),
(8989, 'Nur Abdulahi', 'Medicine'),
(8990, 'Samira Musa', 'Economics'),
(8991, 'Amina Abdi', 'Economics'),
(8992, 'Sagal Yusuf', 'Information Technology'),
(8993, 'Yusuf Haji', 'Business'),
(8994, 'Hodan Farah', 'Education'),
(8995, 'Sagal Abdi', 'Information Technology'),
(8996, 'Salah Hassan', 'Medicine'),
(8997, 'Nur Haji', 'Information Technology'),
(8998, 'Asha Ali', 'Education'),
(8999, 'Nur Ismail', 'Education'),
(9000, 'Saida Hassan', 'Nursing'),
(9001, 'Salah Ahmed', 'Engineering');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `vote_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_candidate` (`candidate_id`),
  ADD KEY `fk_student` (`student_id`),
  ADD KEY `fk_admin` (`admin_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7009;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9002;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `fk_admin` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_candidate` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
