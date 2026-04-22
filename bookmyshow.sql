-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 21, 2026 at 05:10 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookmyshow`
--

-- --------------------------------------------------------

--
-- Table structure for table `book_list`
--

CREATE TABLE `book_list` (
  `book_id` int NOT NULL,
  `library_id` int DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `author` varchar(50) DEFAULT NULL,
  `category` varchar(25) DEFAULT NULL,
  `year` int DEFAULT NULL,
  `language` varchar(25) DEFAULT NULL,
  `total_copy` int DEFAULT NULL,
  `available_copy` int DEFAULT NULL,
  `rating` float(2,1) DEFAULT NULL,
  `rating_count` int NOT NULL DEFAULT '0',
  `status` varchar(25) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `book_list`
--

INSERT INTO `book_list` (`book_id`, `library_id`, `title`, `author`, `category`, `year`, `language`, `total_copy`, `available_copy`, `rating`, `rating_count`, `status`, `image`) VALUES
(33176190, 89002511, 'World History', 'Krishna Reddy', 'History', 2018, 'English', 4, 1, 4.7, 3, 'Available', '69be540f7e5f8world history.jpg'),
(47504259, 89002511, 'Database Management System', 'R. S. Salaria', 'Database', 2013, 'Hindi', 2, 1, 4.5, 2, 'Available', '69be541e68dccdatabase management system.jpg'),
(88891203, 51867580, 'Introduction To Java Programming', 'K. Somsundaram', 'Programming', 2016, 'English', 5, 3, 5.0, 1, 'Available', '69be542961a70java introduction.jpg'),
(99536486, 51867580, 'Python Programmin', 'Rilika Mehra', 'Programming', 2017, 'English', 3, 0, 0.0, 0, 'Unavailable', '69be549246e17python programmin.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int NOT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `category_description` varchar(255) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_description`, `status`) VALUES
(3412, 'History', 'N/A', 'Active'),
(3915, 'Programming', 'N/A', 'Active'),
(5641, 'Database', 'N/A', 'Active'),
(8044, 'Science', 'N/A', 'Active'),
(8815, 'Mathematics', 'N/A', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `chair_bookings`
--

CREATE TABLE `chair_bookings` (
  `booking_id` int NOT NULL,
  `library_id` int NOT NULL,
  `table_id` int NOT NULL,
  `chair_id` int NOT NULL,
  `user_id` int NOT NULL,
  `booking_date` date NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `status` enum('active','expired','cancelled') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chair_bookings`
--

INSERT INTO `chair_bookings` (`booking_id`, `library_id`, `table_id`, `chair_id`, `user_id`, `booking_date`, `start_time`, `end_time`, `status`, `created_at`) VALUES
(3, 51867580, 2, 13, 37023314, '2026-03-23', '2026-03-23 21:54:37', '2026-03-23 22:54:37', 'expired', '2026-03-23 16:24:37'),
(4, 51867580, 2, 14, 37023314, '2026-03-24', '2026-03-24 10:22:58', '2026-03-24 12:22:58', 'expired', '2026-03-24 04:52:58'),
(9, 51867580, 3, 23, 37023314, '2026-03-24', '2026-03-24 18:55:05', '2026-03-24 20:55:05', 'expired', '2026-03-24 13:25:05'),
(10, 59924686, 17, 108, 48085869, '2026-04-01', '2026-04-01 08:40:37', '2026-04-01 08:42:37', 'expired', '2026-04-01 03:10:37');

-- --------------------------------------------------------

--
-- Table structure for table `issue`
--

CREATE TABLE `issue` (
  `issue_id` int NOT NULL,
  `book_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `library_id` int DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `fine_amount` int DEFAULT NULL,
  `renew_count` int NOT NULL DEFAULT '0',
  `status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `last_mailed_status` varchar(50) DEFAULT NULL,
  `is_rated` tinyint NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `issue`
--

INSERT INTO `issue` (`issue_id`, `book_id`, `user_id`, `library_id`, `issue_date`, `return_date`, `fine_amount`, `renew_count`, `status`, `last_mailed_status`, `is_rated`, `created_at`) VALUES
(10486573, 47504259, 36297750, 89002511, '2026-04-01', '2026-04-06', 0, 0, 'Return at library', 'Return at library', 0, '2026-04-09 12:51:32'),
(21186127, 47504259, 36297750, 89002511, '2026-03-24', '2026-03-28', 0, 0, 'Returned', 'Returned', 1, '2026-04-01 18:43:24'),
(42284099, 33176190, 37023314, 89002511, '2026-03-20', '2026-03-21', 0, 0, 'Returned', 'Returned', 1, '2026-04-01 18:43:24'),
(68257468, 33176190, 37023314, 89002511, '2026-03-25', '2026-04-01', 0, 0, 'Returned', 'Returned', 1, '2026-04-01 18:43:24');

-- --------------------------------------------------------

--
-- Table structure for table `librarian_request`
--

CREATE TABLE `librarian_request` (
  `request_id` int NOT NULL,
  `user_id` int NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `request_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `approved_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `librarian_request`
--

INSERT INTO `librarian_request` (`request_id`, `user_id`, `subject`, `message`, `status`, `request_date`, `approved_date`) VALUES
(5793, 37023314, 'Request for Librarian Role Access', 'Write why you need librarian', 'Approved', '2026-03-25 10:58:58', '2026-03-25 05:55:41');

-- --------------------------------------------------------

--
-- Table structure for table `library`
--

CREATE TABLE `library` (
  `library_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `library_name` varchar(100) NOT NULL,
  `library_owner_name` varchar(100) NOT NULL,
  `library_email` varchar(255) NOT NULL,
  `table_capacity` int NOT NULL,
  `chair_capacity` int NOT NULL,
  `open_at` time NOT NULL,
  `close_at` time NOT NULL,
  `library_location` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `upi_id` varchar(100) NOT NULL DEFAULT 'test@upi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `library`
--

INSERT INTO `library` (`library_id`, `user_id`, `library_name`, `library_owner_name`, `library_email`, `table_capacity`, `chair_capacity`, `open_at`, `close_at`, `library_location`, `status`, `upi_id`) VALUES
(51867580, NULL, 'Central City Library', 'James Gosling', 'central.city.library@gmail.com', 2, 13, '08:00:00', '17:30:00', 'Downtown, Rajkot', 'Active', 'test@upi'),
(59924686, NULL, 'RKU library', 'James Gosling', 'rku.library@gmail.com', 12, 66, '10:50:00', '22:49:00', 'Downtown, Rajkot', 'Active', 'test@upi'),
(89002511, 37023314, 'Main Library', 'James Gosling', 'main.library@gmail.com', 1, 7, '10:30:00', '23:00:00', 'Downtown, Rajkot', 'Active', 'asodariyadhruvil80@pingpay');

-- --------------------------------------------------------

--
-- Table structure for table `library_chairs`
--

CREATE TABLE `library_chairs` (
  `chair_id` int NOT NULL,
  `table_id` int NOT NULL,
  `library_id` int NOT NULL,
  `chair_no` int NOT NULL,
  `status` enum('available','booked') NOT NULL DEFAULT 'available',
  `booked_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `library_chairs`
--

INSERT INTO `library_chairs` (`chair_id`, `table_id`, `library_id`, `chair_no`, `status`, `booked_by`, `created_at`, `updated_at`) VALUES
(13, 2, 51867580, 1, 'available', NULL, '2026-03-23 16:01:30', '2026-03-24 04:52:17'),
(14, 2, 51867580, 2, 'available', NULL, '2026-03-23 16:01:30', '2026-03-24 13:05:07'),
(15, 3, 51867580, 1, 'available', NULL, '2026-03-24 04:55:00', '2026-03-24 04:55:00'),
(16, 3, 51867580, 2, 'available', NULL, '2026-03-24 04:55:00', '2026-03-24 04:55:00'),
(17, 3, 51867580, 3, 'available', NULL, '2026-03-24 04:55:00', '2026-03-24 04:55:00'),
(18, 3, 51867580, 4, 'available', NULL, '2026-03-24 04:55:00', '2026-03-24 04:55:00'),
(19, 3, 51867580, 5, 'available', NULL, '2026-03-24 04:55:00', '2026-03-24 04:55:00'),
(20, 3, 51867580, 6, 'available', NULL, '2026-03-24 04:55:00', '2026-03-24 04:55:00'),
(21, 3, 51867580, 7, 'available', NULL, '2026-03-24 04:55:00', '2026-03-24 04:55:00'),
(22, 3, 51867580, 8, 'available', NULL, '2026-03-24 04:55:00', '2026-03-24 04:55:00'),
(23, 3, 51867580, 9, 'available', NULL, '2026-03-24 04:55:00', '2026-03-25 04:38:57'),
(24, 3, 51867580, 10, 'booked', NULL, '2026-03-24 04:55:00', '2026-03-24 13:21:46'),
(25, 3, 51867580, 11, 'available', NULL, '2026-03-24 04:55:00', '2026-03-24 13:21:42'),
(34, 5, 89002511, 1, 'available', NULL, '2026-03-30 16:43:14', '2026-03-30 16:43:14'),
(35, 5, 89002511, 2, 'available', NULL, '2026-03-30 16:43:14', '2026-03-30 16:43:14'),
(36, 5, 89002511, 3, 'available', NULL, '2026-03-30 16:43:14', '2026-03-30 16:43:14'),
(37, 5, 89002511, 4, 'available', NULL, '2026-03-30 16:43:14', '2026-03-30 16:43:14'),
(38, 5, 89002511, 5, 'available', NULL, '2026-03-30 16:43:14', '2026-03-30 16:43:14'),
(39, 5, 89002511, 6, 'available', NULL, '2026-03-30 16:43:14', '2026-03-30 16:43:14'),
(40, 5, 89002511, 7, 'available', NULL, '2026-03-30 16:43:14', '2026-03-30 16:43:14'),
(65, 10, 59924686, 1, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(66, 10, 59924686, 2, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(67, 10, 59924686, 3, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(68, 10, 59924686, 4, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(69, 10, 59924686, 5, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(70, 10, 59924686, 6, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(71, 11, 59924686, 1, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(72, 11, 59924686, 2, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(73, 11, 59924686, 3, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(74, 11, 59924686, 4, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(75, 11, 59924686, 5, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(76, 11, 59924686, 6, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(77, 12, 59924686, 1, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(78, 12, 59924686, 2, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(79, 12, 59924686, 3, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(80, 12, 59924686, 4, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(81, 12, 59924686, 5, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(82, 12, 59924686, 6, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(83, 13, 59924686, 1, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(84, 13, 59924686, 2, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(85, 13, 59924686, 3, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(86, 13, 59924686, 4, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(87, 13, 59924686, 5, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(88, 13, 59924686, 6, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(89, 14, 59924686, 1, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(90, 14, 59924686, 2, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(91, 14, 59924686, 3, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(92, 14, 59924686, 4, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(93, 14, 59924686, 5, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(94, 14, 59924686, 6, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(95, 15, 59924686, 1, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(96, 15, 59924686, 2, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(97, 15, 59924686, 3, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(98, 15, 59924686, 4, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(99, 15, 59924686, 5, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(100, 15, 59924686, 6, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(101, 16, 59924686, 1, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(102, 16, 59924686, 2, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(103, 16, 59924686, 3, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(104, 16, 59924686, 4, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(105, 16, 59924686, 5, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(106, 17, 59924686, 1, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(107, 17, 59924686, 2, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(108, 17, 59924686, 3, 'available', NULL, '2026-03-30 17:20:13', '2026-04-01 03:12:37'),
(109, 17, 59924686, 4, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(110, 17, 59924686, 5, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(111, 18, 59924686, 1, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(112, 18, 59924686, 2, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(113, 18, 59924686, 3, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(114, 18, 59924686, 4, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(115, 18, 59924686, 5, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(116, 19, 59924686, 1, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(117, 19, 59924686, 2, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(118, 19, 59924686, 3, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(119, 19, 59924686, 4, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(120, 19, 59924686, 5, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(121, 20, 59924686, 1, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(122, 20, 59924686, 2, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(123, 20, 59924686, 3, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(124, 20, 59924686, 4, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(125, 20, 59924686, 5, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(126, 21, 59924686, 1, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(127, 21, 59924686, 2, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(128, 21, 59924686, 3, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(129, 21, 59924686, 4, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(130, 21, 59924686, 5, 'available', NULL, '2026-03-30 17:20:13', '2026-03-30 17:20:13');

-- --------------------------------------------------------

--
-- Table structure for table `library_tables`
--

CREATE TABLE `library_tables` (
  `table_id` int NOT NULL,
  `library_id` int NOT NULL,
  `table_name` varchar(100) NOT NULL,
  `chair_count` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `library_tables`
--

INSERT INTO `library_tables` (`table_id`, `library_id`, `table_name`, `chair_count`, `created_at`, `updated_at`) VALUES
(2, 51867580, 'TABLE 1', 2, '2026-03-23 16:01:30', '2026-03-23 16:02:10'),
(3, 51867580, 'TABLE 2', 11, '2026-03-24 04:55:00', '2026-03-24 04:55:00'),
(5, 89002511, 'TABLE 1', 7, '2026-03-30 16:43:14', '2026-03-30 16:43:41'),
(10, 59924686, 'Table 1', 6, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(11, 59924686, 'Table 2', 6, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(12, 59924686, 'Table 3', 6, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(13, 59924686, 'Table 4', 6, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(14, 59924686, 'Table 5', 6, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(15, 59924686, 'Table 6', 6, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(16, 59924686, 'Table 7', 5, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(17, 59924686, 'Table 8', 5, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(18, 59924686, 'Table 9', 5, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(19, 59924686, 'Table 10', 5, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(20, 59924686, 'Table 11', 5, '2026-03-30 17:20:13', '2026-03-30 17:20:13'),
(21, 59924686, 'Table 12', 5, '2026-03-30 17:20:13', '2026-03-30 17:20:13');

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `payment_id` int NOT NULL,
  `issue_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `library_id` int DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `utr_no` varchar(100) DEFAULT NULL,
  `screenshot` varchar(255) DEFAULT NULL,
  `verify_status` varchar(20) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payment_history`
--

INSERT INTO `payment_history` (`payment_id`, `issue_id`, `user_id`, `library_id`, `amount`, `payment_method`, `payment_status`, `payment_date`, `utr_no`, `screenshot`, `verify_status`) VALUES
(11072, 10486573, 36297750, 89002511, 15, 'UPI', 'Paid', '2026-04-11', '609926289447', 'payment_1775911702_3932.jpeg', 'Pending'),
(13416, 21186127, 36297750, 89002511, 10, 'UPI', 'Paid', '2026-04-01', NULL, NULL, 'Approved'),
(56072, 21186127, 36297750, 89002511, 10, 'UPI', 'Paid', '2026-04-01', NULL, NULL, 'Approved'),
(62725, 42284099, 37023314, 89002511, 10, 'UPI', 'Paid', '2026-03-25', NULL, NULL, 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `rating_id` int NOT NULL,
  `book_id` int DEFAULT NULL,
  `library_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `description` text,
  `rating` int DEFAULT NULL,
  `rating_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`rating_id`, `book_id`, `library_id`, `user_id`, `description`, `rating`, `rating_date`) VALUES
(19911, 33176190, 89002511, 37023314, '', 4, '2026-03-20'),
(33213, 33176190, 89002511, 37023314, '', 5, '2026-03-30'),
(59171, 47504259, 89002511, 36297750, '', 5, '2026-04-09'),
(80363, 88891203, 51867580, 37023314, '', 5, '2026-03-20'),
(82377, 33176190, 89002511, 37023314, '', 5, '2026-03-25');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_no` varchar(15) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) DEFAULT NULL,
  `status` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `email`, `contact_no`, `gender`, `address`, `image`, `password`, `role`, `status`) VALUES
(24842354, 'Asodariya', 'Dhruvil', 'admin@gmail.com', '1234567890', 'Male', '123 Main St, Cityville', 'default_profile.png', '$2y$10$6TYW2NEOJvQqGc/s1ncHReDVGqPBw61N4PQKOePGgjG6YtXANDYxa', 'Admin', 'Active'),
(36297750, 'Virani ', 'Yash', 'viraniyash432@gmail.com', '1234567890', 'Male', '123 Main St, Cityville', 'default_profile.png', '$2y$10$ySfnEcsCyjQvakK09jUhjuRZmjcgt1pVoDTJfHr0AHwWrYeoccQ62', 'User', 'Active'),
(37023314, 'Asodariya', 'Dhruvil', 'asodariyadhruvil80@gmail.com', '1234567890', 'Male', 'Mavdi, Rajkot, Gujarat, India (360004)', 'default_profile.png', '$2y$10$FozJ4tfCgJUL5t4g5V6Uu.wJYUK5G6998RNueRocwPAZ5Bco8A3I2', 'Librarian', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book_list`
--
ALTER TABLE `book_list`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `fk_library` (`library_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `chair_bookings`
--
ALTER TABLE `chair_bookings`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `issue`
--
ALTER TABLE `issue`
  ADD PRIMARY KEY (`issue_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `library_id` (`library_id`);

--
-- Indexes for table `librarian_request`
--
ALTER TABLE `librarian_request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`library_id`),
  ADD KEY `fk_library_user` (`user_id`);

--
-- Indexes for table `library_chairs`
--
ALTER TABLE `library_chairs`
  ADD PRIMARY KEY (`chair_id`),
  ADD UNIQUE KEY `unique_chair_per_table` (`table_id`,`chair_no`);

--
-- Indexes for table `library_tables`
--
ALTER TABLE `library_tables`
  ADD PRIMARY KEY (`table_id`),
  ADD UNIQUE KEY `unique_table_per_library` (`library_id`,`table_name`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `fk_issue_payment` (`issue_id`),
  ADD KEY `fk_user_payment` (`user_id`),
  ADD KEY `fk_library_payment` (`library_id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `fk_rating_book` (`book_id`),
  ADD KEY `fk_rating_library` (`library_id`),
  ADD KEY `fk_rating_user` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chair_bookings`
--
ALTER TABLE `chair_bookings`
  MODIFY `booking_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `librarian_request`
--
ALTER TABLE `librarian_request`
  MODIFY `request_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9184;

--
-- AUTO_INCREMENT for table `library`
--
ALTER TABLE `library`
  MODIFY `library_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90356641;

--
-- AUTO_INCREMENT for table `library_chairs`
--
ALTER TABLE `library_chairs`
  MODIFY `chair_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `library_tables`
--
ALTER TABLE `library_tables`
  MODIFY `table_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book_list`
--
ALTER TABLE `book_list`
  ADD CONSTRAINT `fk_library` FOREIGN KEY (`library_id`) REFERENCES `library` (`library_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `issue`
--
ALTER TABLE `issue`
  ADD CONSTRAINT `issue_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book_list` (`book_id`),
  ADD CONSTRAINT `issue_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `issue_ibfk_3` FOREIGN KEY (`library_id`) REFERENCES `library` (`library_id`);

--
-- Constraints for table `librarian_request`
--
ALTER TABLE `librarian_request`
  ADD CONSTRAINT `librarian_request_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `library`
--
ALTER TABLE `library`
  ADD CONSTRAINT `fk_library_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `library_chairs`
--
ALTER TABLE `library_chairs`
  ADD CONSTRAINT `fk_chair_table` FOREIGN KEY (`table_id`) REFERENCES `library_tables` (`table_id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD CONSTRAINT `fk_issue_payment` FOREIGN KEY (`issue_id`) REFERENCES `issue` (`issue_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_library_payment` FOREIGN KEY (`library_id`) REFERENCES `library` (`library_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_payment` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `fk_rating_book` FOREIGN KEY (`book_id`) REFERENCES `book_list` (`book_id`),
  ADD CONSTRAINT `fk_rating_library` FOREIGN KEY (`library_id`) REFERENCES `library` (`library_id`),
  ADD CONSTRAINT `fk_rating_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
