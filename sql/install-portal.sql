-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2025 at 07:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `admin_id` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `conpassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`admin_id`, `name`, `role`, `username`, `password`, `conpassword`) VALUES
('AD123', 'VIVOR OSCAR MAKAFUI', 'administrator', 'administrator', '$2y$10$.OkYrPuXZD1hS0M07IPQ0eXU4yu93UHphsuzw20f1R0.7gknMTkTW', '$2y$10$3atD.Iu5YtizsOmCfipqKOo4vYHJcrtC69lkYwCcSHJTvVEJ9pBey'),
('AD554', 'ROYAL WEBSTERS', 'administrator', 'SUPER', '$2y$10$b1OuYd9AIW6wbIBzmou71.7sbVm5.TKzzCnnEatV0lUXEvux1Ytr.', '$2y$10$unpgxZziFBP/HyZbNtvseuGxO.xf6phcbMQnOdievIDnV5x.OvmUO');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `status` enum('Present','Absent') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `date`, `status`) VALUES
(25, 'STD0200008', '2025-08-01', 'Present'),
(26, 'STD0200010', '2025-08-01', 'Absent');

-- --------------------------------------------------------

--
-- Table structure for table `checkin_code`
--

CREATE TABLE `checkin_code` (
  `id` int(11) NOT NULL,
  `number` varchar(10) NOT NULL,
  `is_used` tinyint(10) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkin_code`
--

INSERT INTO `checkin_code` (`id`, `number`, `is_used`, `created_at`) VALUES
(540, '882894', 0, '2025-04-20 12:41:47'),
(541, '763326', 0, '2025-04-20 12:41:48');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` varchar(255) NOT NULL,
  `class_name` varchar(111) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `class_name`) VALUES
('CR001', 'Class 1'),
('CR002', 'Class 2'),
('CR003', 'Class 3'),
('CR004', 'Class 4'),
('CR005', 'Class 5'),
('CR006', 'Class 6'),
('CR007', 'Class 7'),
('CR008', 'Class 8'),
('CR009', 'Class 9');

-- --------------------------------------------------------

--
-- Table structure for table `fee_structures`
--

CREATE TABLE `fee_structures` (
  `fee_id` int(11) NOT NULL,
  `class_name` varchar(50) DEFAULT NULL,
  `fee_type` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `due_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fee_structures`
--

INSERT INTO `fee_structures` (`fee_id`, `class_name`, `fee_type`, `amount`, `due_date`) VALUES
(3, 'Class 3', 'test2', 665.00, '2025-08-03');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `target_role` varchar(50) NOT NULL COMMENT 'e.g., all, student, staff',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sender_name` varchar(255) DEFAULT 'Administrator'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `message`, `target_role`, `created_at`, `sender_name`) VALUES
(3, 'Here\'s a complete implementation for a student settings page where students can update their personal details, including password hashing with PASSWORD_BCRYPT.', 'all', '2025-08-07 16:38:27', 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `fee_id` int(11) DEFAULT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `receipt_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `student_id` varchar(100) NOT NULL,
  `filename` varchar(200) NOT NULL,
  `filesize` int(11) NOT NULL,
  `filetype` varchar(100) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `school_details`
--

CREATE TABLE `school_details` (
  `id` int(11) NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `type_of_institution` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `enrollment_capacity` int(11) NOT NULL,
  `facilities` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `academic_year` varchar(50) NOT NULL,
  `color_scheme` varchar(7) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_details`
--

INSERT INTO `school_details` (`id`, `school_name`, `type_of_institution`, `address`, `enrollment_capacity`, `facilities`, `email`, `contact`, `academic_year`, `color_scheme`, `image_path`, `created_at`, `updated_at`) VALUES
(5, 'ROYAL WEBSTERS ACADEMY', 'PRIVATE', 'Akwatia', 500, '14', 'school@mail.com', '+233533519466', '2024/2025', '#2b21c0', 'uploads/photo.jpg', '2025-01-12 21:46:03', '2025-01-27 19:20:45');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` varchar(255) NOT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `mid_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `class` varchar(110) NOT NULL,
  `healthinsur` varchar(255) DEFAULT NULL,
  `curaddress` varchar(255) DEFAULT NULL,
  `cityname` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `join_date` varchar(255) DEFAULT NULL,
  `curr_position` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `conpassword` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `gender`, `first_name`, `mid_name`, `last_name`, `dob`, `number`, `email`, `class`, `healthinsur`, `curaddress`, `cityname`, `qualification`, `join_date`, `curr_position`, `role`, `username`, `password`, `conpassword`) VALUES
('STF000001', 'Male', 'John', '', 'Kuma', '2001-09-24', '233 598 474 785', 'johnkumah@gmail.com', 'Class 3', '65489147', 'KM548', 'Kumasi', 'Degree', '2024-07-09', 'Staff', 'staff', 'johnkuma', '$2y$10$6wf9ABr1X7Ahg64dlcrNOumGqIb0KSiSYvU1aa.mFBcP/JQ7P6pem', '$2y$10$gY3k2bRL0oi9hoEY86t.WuVHCk7wmzhOVfsKUQ/edcYQeFtqxFO.S'),
('STF000004', 'Male', 'Kwame', '', 'Amponsah', '1990-05-15', '233 544 123 456', 'kwameamponsah@gmail.com', 'Class 1', '12345678', 'KN123', 'Kumasi', 'Degree', '2021-01-10', 'Teacher', 'staff', 'kwameamp', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000005', 'Female', 'Ama', '', 'Mensah', '1985-08-20', '233 544 654 321', 'amamensah@gmail.com', 'Class 9', '87654321', 'KN456', 'Accra', 'Masters', '2019-05-12', 'Teacher', 'staff', 'amamens', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000008', 'Male', 'Kofi', '', 'Asare', '1995-04-10', '233 544 987 654', 'kofiasare@gmail.com', '', '45678901', 'KN987', 'Kumasi', 'Degree', '2022-02-05', 'Teacher', 'staff', 'kofiasar', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000009', 'Female', 'Esi', '', 'Owusua', '1993-12-05', '233 544 654 987', 'esiowusu@gmail.com', '', '56789012', 'KN654', 'Accra', 'Masters', '2021-07-18', 'Teacher', 'staff', 'esiowus', '$2y$10$MUku3flzsoeGnHsv8e0QiewtL.z.5KRhFu8c67Rok4HDZPcHGTPB.', '$2y$10$i5vXqiaFeD/oUxFSDzSS4edEe1vxN.nS90HVdE97tCdmWMk8a4eYG'),
('STF000010', 'Male', 'Kwasi', '', 'Boadi', '1991-06-22', '233 544 321 987', 'kwasiaboadi@gmail.com', '', '67890123', 'KN321', 'Kumasi', 'Degree', '2020-11-30', 'Teacher', 'staff', 'kwasiab', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000011', 'Female', 'Afia', '', 'Agyemang', '1987-09-14', '233 544 789 321', 'afiaagyemang@gmail.com', '', '78901234', 'KN789', 'Accra', 'Masters', '2019-04-25', 'Teacher', 'staff', 'afiaagy', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000014', 'Male', 'Emmanuel', '', 'Amoah', '1990-02-14', '233 544 123 890', 'emmanuelamoah@gmail.com', 'Class 4', '12345678', 'KN890', 'Kumasi', 'Degree', '2021-03-22', 'Teacher', 'staff', 'emmanuelam', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000015', 'Female', 'Grace', '', 'Asante', '1986-07-19', '233 544 654 890', 'graceasante@gmail.com', '', '23456789', 'KN654', 'Accra', 'Masters', '2019-06-10', 'Teacher', 'staff', 'graceasant', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000016', 'Male', 'Samuel', '', 'Osei', '1993-05-25', '233 544 789 890', 'samuelosei@gmail.com', '', '34567890', 'KN789', 'Kumasi', 'Degree', '2020-09-15', 'Teacher', 'staff', 'samuelose', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000017', 'Female', 'Comfort', '', 'Mensah', '1988-12-30', '233 544 321 890', 'comfortmensah@gmail.com', '', '45678901', 'KN321', 'Accra', 'Masters', '2018-08-20', 'Teacher', 'staff', 'comfortmen', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000018', 'Male', 'Daniel', '', 'Appiah', '1991-04-12', '233 544 987 890', 'danielappiah@gmail.com', '', '56789012', 'KN987', 'Kumasi', 'Degree', '2022-01-05', 'Teacher', 'staff', 'danielapp', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000019', 'Female', 'Patience', '', 'Boateng', '1994-08-08', '233 544 654 890', 'patienceboateng@gmail.com', '', '67890123', 'KN654', 'Accra', 'Masters', '2021-05-18', 'Teacher', 'staff', 'patiencebo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000020', 'Male', 'Joseph', '', 'Opoku', '1992-11-15', '233 544 321 890', 'josephopoku@gmail.com', '', '78901234', 'KN321', 'Kumasi', 'Degree', '2020-10-30', 'Teacher', 'staff', 'josephopo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000021', 'Female', 'Mary', '', 'Agyei', '1987-06-20', '233 544 789 890', 'maryagyei@gmail.com', '', '89012345', 'KN789', 'Accra', 'Masters', '2019-03-25', 'Teacher', 'staff', 'maryagye', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000022', 'Male', 'Michael', '', 'Kwarteng', '1995-01-10', '233 544 123 890', 'michaelkwarteng@gmail.com', '', '90123456', 'KN123', 'Kumasi', 'Degree', '2021-09-12', 'Teacher', 'staff', 'michaelkw', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000023', 'Female', 'Esther', '', 'Owusu', '1989-09-05', '233 544 654 890', 'estherowusu@gmail.com', '', '12345678', 'KN654', 'Accra', 'Masters', '2018-11-15', 'Teacher', 'staff', 'estherowu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000024', 'Male', 'David', '', 'Acheampong', '1990-03-18', '233 544 789 890', 'davidacheampong@gmail.com', '', '23456789', 'KN789', 'Kumasi', 'Degree', '2020-04-22', 'Teacher', 'staff', 'davidache', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000025', 'Female', 'Deborah', '', 'Adjei', '1985-12-12', '233 544 321 890', 'deborahadjei@gmail.com', '', '34567890', 'KN321', 'Accra', 'Masters', '2019-07-10', 'Teacher', 'staff', 'deborahad', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000026', 'Male', 'Stephen', '', 'Bonsu', '1993-08-25', '233 544 987 890', 'stephenbonsu@gmail.com', '', '45678901', 'KN987', 'Kumasi', 'Degree', '2021-02-05', 'Teacher', 'staff', 'stephenbo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000027', 'Female', 'Gifty', '', 'Ampofo', '1988-05-30', '233 544 654 890', 'giftyampofo@gmail.com', '', '56789012', 'KN654', 'Accra', 'Masters', '2018-09-20', 'Teacher', 'staff', 'giftyamp', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000028', 'Male', 'Richard', '', 'Asante', '1991-10-15', '233 544 321 890', 'richardasante@gmail.com', '', '67890123', 'KN321', 'Kumasi', 'Degree', '2020-11-30', 'Teacher', 'staff', 'richardas', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000029', 'Female', 'Joyce', '', 'Mensah', '1987-04-18', '233 544 789 890', 'joycemensah@gmail.com', '', '78901234', 'KN789', 'Accra', 'Masters', '2019-05-25', 'Teacher', 'staff', 'joycemen', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000030', 'Male', 'Philip', '', 'Owusu', '1994-07-22', '233 544 123 890', 'philipowusu@gmail.com', '', '89012345', 'KN123', 'Kumasi', 'Degree', '2021-08-12', 'Teacher', 'staff', 'philipowu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000031', 'Female', 'Linda', '', 'Agyeman', '1989-02-10', '233 544 654 890', 'lindaagyeman@gmail.com', '', '90123456', 'KN654', 'Accra', 'Masters', '2018-12-15', 'Teacher', 'staff', 'lindaagy', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000032', 'Male', 'Benjamin', '', 'Amoah', '1990-06-14', '233 544 789 890', 'benjaminamoah@gmail.com', '', '12345678', 'KN789', 'Kumasi', 'Degree', '2021-03-22', 'Teacher', 'staff', 'benjaminam', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000033', 'Female', 'Comfort', '', 'Asare', '1986-09-19', '233 544 321 890', 'comfortasare@gmail.com', '', '23456789', 'KN321', 'Accra', 'Masters', '2019-06-10', 'Teacher', 'staff', 'comfortasa', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000034', 'Male', 'Samuel', '', 'Osei', '1993-05-25', '233 544 987 890', 'samuelosei@gmail.com', '', '34567890', 'KN987', 'Kumasi', 'Degree', '2020-09-15', 'Teacher', 'staff', 'samuelose', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000035', 'Female', 'Comfort', '', 'Mensah', '1988-12-30', '233 544 654 890', 'comfortmensah@gmail.com', '', '45678901', 'KN654', 'Accra', 'Masters', '2018-08-20', 'Teacher', 'staff', 'comfortmen', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000036', 'Male', 'Daniel', '', 'Appiah', '1991-04-12', '233 544 321 890', 'danielappiah@gmail.com', '', '56789012', 'KN321', 'Kumasi', 'Degree', '2022-01-05', 'Teacher', 'staff', 'danielapp', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000037', 'Female', 'Patience', '', 'Boateng', '1994-08-08', '233 544 654 890', 'patienceboateng@gmail.com', '', '67890123', 'KN654', 'Accra', 'Masters', '2021-05-18', 'Teacher', 'staff', 'patiencebo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000038', 'Male', 'Joseph', '', 'Opoku', '1992-11-15', '233 544 321 890', 'josephopoku@gmail.com', '', '78901234', 'KN321', 'Kumasi', 'Degree', '2020-10-30', 'Teacher', 'staff', 'josephopo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000040', 'Male', 'Michael', '', 'Kwarteng', '1995-01-10', '233 544 123 890', 'michaelkwarteng@gmail.com', '', '90123456', 'KN123', 'Kumasi', 'Degree', '2021-09-12', 'Teacher', 'staff', 'michaelkw', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000041', 'Female', 'Esther', '', 'Owusu', '1989-09-05', '233 544 654 890', 'estherowusu@gmail.com', '', '12345678', 'KN654', 'Accra', 'Masters', '2018-11-15', 'Teacher', 'staff', 'estherowu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STF000042', 'Male', 'David', '', 'Acheampong', '1990-03-18', '233 544 789 890', 'davidacheampong@gmail.com', '', '23456789', 'KN789', 'Kumasi', 'Degree', '2020-04-22', 'Teacher', 'staff', 'davidache', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- --------------------------------------------------------

--
-- Table structure for table `staff_attendance`
--

CREATE TABLE `staff_attendance` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `check_in_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_classes`
--

CREATE TABLE `staff_classes` (
  `assignment_id` int(11) NOT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `class_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_classes`
--

INSERT INTO `staff_classes` (`assignment_id`, `staff_id`, `class_name`) VALUES
(9, 'STF000008', 'Class 2'),
(10, 'STF000009', 'Class 1'),
(11, 'STF000001', 'Class 1');

-- --------------------------------------------------------

--
-- Stand-in structure for view `staff_count`
-- (See below for the actual view)
--
CREATE TABLE `staff_count` (
`total_staffs` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `mid_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `dob` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `class` varchar(25) NOT NULL,
  `healthinsur` int(11) NOT NULL,
  `curaddress` varchar(255) NOT NULL,
  `cityname` varchar(255) NOT NULL,
  `parent_first_name` varchar(255) NOT NULL,
  `parent_mid_name` varchar(255) NOT NULL,
  `parent_last_name` varchar(255) NOT NULL,
  `parent_email` varchar(255) NOT NULL,
  `parent_number` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT '''''''student''''''',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `conpassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `gender`, `first_name`, `mid_name`, `last_name`, `dob`, `number`, `email`, `class`, `healthinsur`, `curaddress`, `cityname`, `parent_first_name`, `parent_mid_name`, `parent_last_name`, `parent_email`, `parent_number`, `role`, `username`, `password`, `conpassword`) VALUES
('STD000017', 'Male', 'Yaw', 'Kofi', 'Osei', '2010-02-22', '233 522 345 555', 'yawosei@gmail.com', 'Class 5', 99887722, 'P606', 'Berekum', 'Kofi', 'Osei', 'Abena', 'kofiaddai@gmail.com', '233 501 666 222', 'student', 'yaw-kofi', '$2y$10$uvwxyz123456789abcd1000', '$2y$10$uvwxyz123456789abcd1000'),
('STD000018', 'Female', 'Esi', 'Nana', 'Appiah', '2011-12-13', '233 543 444 111', 'esianana@gmail.com', 'Class 6', 77889900, 'Q707', 'Kpando', 'Kojo', 'Appiah', 'Kwame', 'kojoappiah@gmail.com', '233 502 777 333', 'student', 'esi-nana', '$2y$10$123456789abcdefuvwxyz2000', '$2y$10$123456789abcdefuvwxyz2000'),
('STD000021', 'Male', 'Kwame', 'Y', 'Owusu', '2009-09-09', '233 522 444 000', 'kwameowusu@gmail.com', 'Class 3', 44556677, 'T101', 'Hohoe', 'Kojo', 'Owusu', 'Ama', 'kojowusu@gmail.com', '233 508 111 333', 'student', 'kwame-yaw', '$2y$10$abcdef123456789uvwxyz3000', '$2y$10$abcdef123456789uvwxyz3000'),
('STD0200002', 'Female', 'Ama', '', 'Mensah', '2011-03-15', '233 544 123 456', 'amamensah@gmail.com', 'Class 2', 12345678, 'KN123', 'Kumasi', 'Kwame', '', 'Amponsah', 'kwameamponsah@gmail.com', '233 544 654 321', 'student', 'amamens', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STD0200003', 'Male', 'Kwame', '', 'Amponsah', '2010-05-20', '233 544 654 321', 'kwameamponsah@gmail.com', 'Class 3', 23456789, 'KN456', 'Accra', 'Ama', '', 'Mensah', 'amamensah@gmail.com', '233 544 123 456', 'student', 'kwameamp', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STD0200006', 'Female', 'Esi', '', 'Owusu', '2010-12-05', '233 544 321 654', 'esiowusu@gmail.com', 'Class 6', 56789012, 'KN321', 'Kumasi', 'Kofi', '', 'Asare', 'kofiasare@gmail.com', '233 544 654 987', 'student', 'esiowus', '$2y$10$YUkL4Q291MfH.q6NuWllye9/CgUYzzWTWSVA76tbdZy/JVJcGus6i', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STD0200007', 'Male', 'Kofi', '', 'Asare', '2012-02-10', '233 544 654 987', 'kofiasare@gmail.com', 'Class 7', 67890123, 'KN654', 'Accra', 'Esi', '', 'Owusu', 'esiowusu@gmail.com', '233 544 321 654', 'student', 'kofiasar', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STD0200008', 'Female', 'Afia', '', 'Agyemang', '2011-04-15', '233 544 789 321', 'afiaagyemang@gmail.com', 'Class 1', 78901234, 'KN789', 'Kumasi', 'Kwabena', '', 'Adjei', 'kwabenaadjei@gmail.com', '233 544 123 789', 'student', 'afiaagy', '$2y$10$9cDRTmC3zfl6l8DFoAeZ6OnOstoS9GSLEqIN5wQHozNC6irIPTca6', '$2y$10$nQSI5GA8DWLcOv4RsLFx4ObBtsmIX4VsS.jov/Kd5nYesKoYOun8y'),
('STD0200009', 'Male', 'Kwabena', '', 'Adjei', '2010-06-20', '233 544 123 789', 'kwabenaadjei@gmail.com', 'Class 8', 89012345, 'KN123', 'Accra', 'Afia', '', 'Agyemang', 'afiaagyemang@gmail.com', '233 544 789 321', 'student', 'kwabenaa', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STD0200010', 'Female', 'Akosua', '', 'Danso', '2012-08-25', '233 544 654 123', 'akosuadanso@gmail.com', 'Class 1', 90123456, 'KN654', 'Kumasi', 'Emmanuel', '', 'Amoah', 'emmanuelamoah@gmail.com', '233 544 987 123', 'student', 'akosuada', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STD0200012', 'Female', 'Grace', '', 'Asante', '2010-12-05', '233 544 321 987', 'graceasante@gmail.com', 'Class 2', 23456789, 'KN321', 'Kumasi', 'Samuel', '', 'Osei', 'samuelosei@gmail.com', '233 544 789 654', 'student', 'graceasant', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STD0200013', 'Male', 'Samuel', '', 'Osei', '2012-02-10', '233 544 789 654', 'samuelosei@gmail.com', 'Class 3', 34567890, 'KN789', 'Accra', 'Grace', '', 'Asante', 'graceasante@gmail.com', '233 544 321 987', 'student', 'samuelose', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('STD0200014', 'Male', 'VIVOR', 'OSCAR', 'MAKAFUI', '2025-01-16', '0533519466', 'oscarvivor@gmail.com', 'Class 4', 54874587, 'Akwatia', 'Akwatia', 'Olivia', 'Oppong', 'Wilson', 'oliviawil@gmail.com', '0540255687', 'student', 'admin', '$2y$10$yQMpc9K2Jq/AFHxOJXu6iO3IGIKLs2NyXEEh136d2ZnKtM/.aRuvC', '$2y$10$8s3fOrABQJwDmBpt4u9WR.yU04obRqYkfZtsaz3La/xkGCuuuC/lO');

-- --------------------------------------------------------

--
-- Stand-in structure for view `student_count`
-- (See below for the actual view)
--
CREATE TABLE `student_count` (
`total_students` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` varchar(100) NOT NULL,
  `subject_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_name`) VALUES
('', ''),
('SBJ001', 'OWOP'),
('SBJ0010', 'Creative Arts'),
('SBJ002', 'English'),
('SBJ003', 'Science'),
('SBJ004', 'Mathematics'),
('SBJ005', 'ICT'),
('SBJ006', 'RME'),
('SBJ007', 'Social'),
('SBJ008', 'Creative Art');

-- --------------------------------------------------------

--
-- Table structure for table `subject_objectives`
--

CREATE TABLE `subject_objectives` (
  `id` int(11) NOT NULL,
  `subject_id` varchar(100) DEFAULT NULL,
  `objective` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_objectives`
--

INSERT INTO `subject_objectives` (`id`, `subject_id`, `objective`, `start_date`, `end_date`) VALUES
(15, 'SBJ004', 'fvbfdzgbsdf', '2025-01-16', '2025-01-23');

-- --------------------------------------------------------

--
-- Table structure for table `term_plan`
--

CREATE TABLE `term_plan` (
  `id` int(10) NOT NULL,
  `plan` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `term_plan`
--

INSERT INTO `term_plan` (`id`, `plan`, `date`) VALUES
(1, 'HOLIDAY', '2025-03-06');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `test_id` varchar(255) NOT NULL,
  `term` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `class_nm` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`test_id`, `term`, `type`, `class_nm`, `start_date`, `end_date`) VALUES
('TS00001', 'First Term', 'Class Test', 'Class 2', '2025-01-10', '2025-01-17'),
('TS00002', 'Second Term', 'Examination', 'Class 5', '2025-01-10', '2025-01-17'),
('TS00003', 'Second Term', 'Class Test', 'Class 7', '2025-01-10', '2025-01-17'),
('TS00006', 'First Term', 'Class Test', 'Class 8', '2025-02-19', '2025-02-05');

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_count`
-- (See below for the actual view)
--
CREATE TABLE `user_count` (
`user_type` varchar(8)
,`total_users` bigint(22)
);

-- --------------------------------------------------------

--
-- Structure for view `staff_count`
--
DROP TABLE IF EXISTS `staff_count`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `staff_count`  AS SELECT count(0) AS `total_staffs` FROM `staff` ;

-- --------------------------------------------------------

--
-- Structure for view `student_count`
--
DROP TABLE IF EXISTS `student_count`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `student_count`  AS SELECT count(0) AS `total_students` FROM `students` ;

-- --------------------------------------------------------

--
-- Structure for view `user_count`
--
DROP TABLE IF EXISTS `user_count`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_count`  AS SELECT 'STUDENTS' AS `user_type`, count(0) AS `total_users` FROM `students`union select 'STAFFS' AS `user_type`,count(0) AS `total_users` from `staff` union select 'TOTAL' AS `user_type`,(select count(0) from `students`) + (select count(0) from `staff`) AS `total_users`  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`,`date`);

--
-- Indexes for table `checkin_code`
--
ALTER TABLE `checkin_code`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `number` (`number`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_name`),
  ADD UNIQUE KEY `class_id` (`class_id`);

--
-- Indexes for table `fee_structures`
--
ALTER TABLE `fee_structures`
  ADD PRIMARY KEY (`fee_id`),
  ADD KEY `class_name` (`class_name`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD UNIQUE KEY `receipt_number` (`receipt_number`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `fee_id` (`fee_id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`filename`);

--
-- Indexes for table `school_details`
--
ALTER TABLE `school_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `staff_attendance`
--
ALTER TABLE `staff_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `staff_classes`
--
ALTER TABLE `staff_classes`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `class_id` (`class_name`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `class` (`class`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `subject_objectives`
--
ALTER TABLE `subject_objectives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `term_plan`
--
ALTER TABLE `term_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`test_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `checkin_code`
--
ALTER TABLE `checkin_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=542;

--
-- AUTO_INCREMENT for table `fee_structures`
--
ALTER TABLE `fee_structures`
  MODIFY `fee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `school_details`
--
ALTER TABLE `school_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `staff_attendance`
--
ALTER TABLE `staff_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `staff_classes`
--
ALTER TABLE `staff_classes`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `subject_objectives`
--
ALTER TABLE `subject_objectives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `term_plan`
--
ALTER TABLE `term_plan`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE;

--
-- Constraints for table `fee_structures`
--
ALTER TABLE `fee_structures`
  ADD CONSTRAINT `fee_structures_ibfk_1` FOREIGN KEY (`class_name`) REFERENCES `class` (`class_name`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`fee_id`) REFERENCES `fee_structures` (`fee_id`);

--
-- Constraints for table `staff_attendance`
--
ALTER TABLE `staff_attendance`
  ADD CONSTRAINT `staff_attendance_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`);

--
-- Constraints for table `staff_classes`
--
ALTER TABLE `staff_classes`
  ADD CONSTRAINT `staff_classes_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`),
  ADD CONSTRAINT `staff_classes_ibfk_2` FOREIGN KEY (`class_name`) REFERENCES `class` (`class_name`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`class`) REFERENCES `class` (`class_name`);

--
-- Constraints for table `subject_objectives`
--
ALTER TABLE `subject_objectives`
  ADD CONSTRAINT `subject_objectives_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
