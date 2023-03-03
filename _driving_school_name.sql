-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2023 at 12:54 PM
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
-- Database: `_driving_school_name`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(255) DEFAULT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_email`, `admin_password`) VALUES
(1, 'Mabuhay Admin', 'admin@drivingschool.com', 'admin@drivingschool.com');

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `enrollment_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `student_name` varchar(255) NOT NULL,
  `schedule_id` int(11) DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL,
  `enrollment_status` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `course_type` varchar(255) DEFAULT NULL,
  `instructor_id` int(11) NOT NULL,
  `instructor_name` varchar(255) NOT NULL,
  `student_address` varchar(255) DEFAULT NULL,
  `student_phone` int(255) DEFAULT NULL,
  `student_birthdate` date DEFAULT NULL,
  `student_age` int(11) DEFAULT NULL,
  `student_classification` varchar(255) DEFAULT NULL,
  `student_restriction_code_number` int(11) DEFAULT NULL,
  `student_gender` varchar(255) DEFAULT NULL,
  `student_civil_status` varchar(255) DEFAULT NULL,
  `student_religion` varchar(255) DEFAULT NULL,
  `student_parent_guardian` varchar(255) DEFAULT NULL,
  `student_parent_guardian_address` varchar(255) DEFAULT NULL,
  `student_parent_guardian_home_phone` int(15) DEFAULT NULL,
  `student_parent_guardian_email` varchar(255) DEFAULT NULL,
  `student_transmission` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`enrollment_id`, `student_id`, `student_name`, `schedule_id`, `enrollment_date`, `enrollment_status`, `title`, `course_type`, `instructor_id`, `instructor_name`, `student_address`, `student_phone`, `student_birthdate`, `student_age`, `student_classification`, `student_restriction_code_number`, `student_gender`, `student_civil_status`, `student_religion`, `student_parent_guardian`, `student_parent_guardian_address`, `student_parent_guardian_home_phone`, `student_parent_guardian_email`, `student_transmission`) VALUES
(20, 5, 'Paolo Laña ', 1, '2023-01-25', NULL, 'Paolo Olyoper Laña', '', 0, '', 'Toledo', 912312312, '2000-02-04', 22, 'Professional', 12316546, '', 'Separated', '', '', '', 0, '', 'Automatic Transmission'),
(21, 5, 'Maria Lux ', 10, '2023-01-25', 'Approved', 'Paolo Olyoper Laña', '', 0, '', 'Toho', 2222, '2000-02-22', 22, 'Professional', 22, '', 'Married', '', '', '', 0, '', 'Automatic Transmission'),
(22, 5, 'Juan dela Cruz ', 11, '2023-01-26', 'Approved', 'Paolo Olyoper Laña', '', 0, '', 'Toledo City', 2147483647, '2000-02-04', 23, 'Professional', 123, '', 'Single', '', 'Ferolino', 'Lunas', 910474431, 'pao@gmail.com', 'Manual Transmission'),
(23, 2, 'Jule Ann Ferolino ', 15, '2023-01-27', 'Approved', '15 hours Driving Wheel Course', 'Theoretical Driving Lesson', 0, '', 'Lunas, Asturias', 0, '0000-00-00', 0, 'Student Permit', 0, '', '', '', '', '', 0, '', 'Automatic Transmission'),
(24, 8, 'Brian Villarin ', 15, '2023-01-27', 'Approved', '15 hours Driving Wheel Course', 'Theoretical Driving Lesson', 0, '', 'Tuburan', 910474431, '1999-07-01', 23, 'Professional', 123, '', 'Single', '', '', '', 0, '', 'Manual Transmission');

-- --------------------------------------------------------

--
-- Table structure for table `enrollment_request`
--

CREATE TABLE `enrollment_request` (
  `enrollment_request_id` int(11) NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `student_name` varchar(255) DEFAULT NULL,
  `schedule_id` int(11) DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL,
  `enrollment_status` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `course_type` varchar(255) DEFAULT NULL,
  `instructor_id` int(11) NOT NULL,
  `instructor_name` varchar(255) NOT NULL,
  `student_address` varchar(255) DEFAULT NULL,
  `student_phone` int(255) DEFAULT NULL,
  `student_birthdate` date DEFAULT NULL,
  `student_age` int(11) DEFAULT NULL,
  `student_classification` varchar(255) DEFAULT NULL,
  `student_restriction_code_number` int(11) DEFAULT NULL,
  `student_gender` varchar(255) DEFAULT NULL,
  `student_civil_status` varchar(255) DEFAULT NULL,
  `student_religion` varchar(255) DEFAULT NULL,
  `student_parent_guardian` varchar(255) DEFAULT NULL,
  `student_parent_guardian_address` varchar(255) DEFAULT NULL,
  `student_parent_guardian_home_phone` int(15) DEFAULT NULL,
  `student_parent_guardian_email` varchar(255) DEFAULT NULL,
  `student_transmission` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollment_request`
--

INSERT INTO `enrollment_request` (`enrollment_request_id`, `student_id`, `student_name`, `schedule_id`, `enrollment_date`, `enrollment_status`, `title`, `course_type`, `instructor_id`, `instructor_name`, `student_address`, `student_phone`, `student_birthdate`, `student_age`, `student_classification`, `student_restriction_code_number`, `student_gender`, `student_civil_status`, `student_religion`, `student_parent_guardian`, `student_parent_guardian_address`, `student_parent_guardian_home_phone`, `student_parent_guardian_email`, `student_transmission`) VALUES
(2, '2', 'Mariasdf Luxsd', 1, '2023-01-25', 'Approved', 'Jule Ann  Ferolino', '', 0, '', 'Toho 23', 1892389213, '2000-02-22', 23, 'Student Permit', 23423423, 'Female', 'Widow/er', 'asdf', ' ', ' ', 0, ' ', 'Manual Transmission'),
(3, '5', 'Paolo Laña', 1, '2023-01-25', 'Approved', 'Paolo Olyoper Laña', '', 0, '', 'Toledo', 912312312, '2000-02-04', 22, 'Professional', 12316546, 'Female', 'Separated', 'Catholico', '', '', 0, '', 'Automatic Transmission'),
(6, '5', 'Maria Lux', 10, '2023-01-25', 'Approved', 'Paolo Olyoper Laña', '', 0, '', 'Toho', 2222, '2000-02-22', 22, 'Professional', 22, 'Male', 'Married', '222', '', '', 0, '', 'Automatic Transmission'),
(7, '7', 'Paolo Laa', 1, '2023-01-26', 'Approved', 'Paoo Loo Laa', '', 0, '', 'talavera', 2147483647, '2000-02-02', 24, 'Non-Professional', 123, 'Female', 'Single', 'Catholic', '', '', 0, '', 'Manual Transmission'),
(10, '5', 'Juan dela Cruz', 11, '2023-01-26', 'Approved', 'Paolo Olyoper Laña', '', 0, '', 'Toledo City', 2147483647, '2000-02-04', 23, 'Professional', 123, 'Male', 'Single', 'INC', 'Ferolino', 'Lunas', 910474431, 'pao@gmail.com', 'Manual Transmission'),
(11, '2', 'Jule Ann Ferolino', 15, '2023-01-27', 'Approved', '15 hours Driving Wheel Course', 'Theoretical Driving Lesson', 0, '', 'Lunas, Asturias', 0, '0000-00-00', 0, 'Student Permit', 0, 'Prefer not to say', '', '', '', '', 0, '', 'Automatic Transmission'),
(12, '8', 'Brian Villarin', 15, '2023-01-27', 'Approved', '15 hours Driving Wheel Course', 'Theoretical Driving Lesson', 0, '', 'Tuburan', 910474431, '1999-07-01', 23, 'Professional', 123, 'Male', 'Single', 'Catholic', '', '', 0, '', 'Manual Transmission'),
(13, '12', 'PJ Cong', 16, '2023-01-31', 'Approved', 'Proper use of headlights, turn signals, and brake lights', 'Theoretical Driving Lesson', 1, 'Sam Sarah', 'Cebu City', 978946122, '2000-12-02', 24, 'Professional', 3165788, 'Female', 'Married', 'Catholic', '', '', 0, 'pjcong@gmail.com', 'Manual Transmission'),
(14, '14', 'Nasad Khan', 16, '2023-02-01', 'Approved', 'Proper use of headlights, turn signals, and brake lights', 'Theoretical Driving Lesson', 1, 'Sam Sarah', '', 0, '0000-00-00', 0, 'Non-Professional', 0, 'Prefer not to say', '', '', '', '', 0, '', 'Automatic Transmission');

-- --------------------------------------------------------

--
-- Table structure for table `evaluations`
--

CREATE TABLE `evaluations` (
  `evaluation_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `course_type` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `evaluation_date` varchar(255) DEFAULT NULL,
  `instructor_id` int(11) NOT NULL,
  `instructor_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evaluations`
--

INSERT INTO `evaluations` (`evaluation_id`, `student_id`, `student_name`, `title`, `course_type`, `remark`, `evaluation_date`, `instructor_id`, `instructor_name`) VALUES
(27, 2, 'Jule Ann  Ferolino', '', NULL, 'Failed', '2023-01-27', 1, 'Sam Sarah'),
(37, 12, 'PJ Cong ', 'Proper use of headlights, turn signals, and brake lights', 'Theoretical Driving Lesson', 'Passed', '2023-01-31', 1, 'Sam Sarah'),
(38, 14, 'Nasad Khan ', 'Proper use of headlights, turn signals, and brake lights', 'Theoretical Driving Lesson', 'Passed', '2023-02-01', 1, 'Sam Sarah');

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE `instructor` (
  `instructor_id` int(11) NOT NULL,
  `instructor_email` varchar(255) DEFAULT NULL,
  `instructor_name` varchar(255) DEFAULT NULL,
  `instructor_password` varchar(255) DEFAULT NULL,
  `instructor_phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`instructor_id`, `instructor_email`, `instructor_name`, `instructor_password`, `instructor_phone`) VALUES
(1, 'samsarah@gmail.com', 'Sam Sarah', 'samsarah@gmail.com', '09104744341'),
(2, 'nazrulislam@gmail.com', 'Nazrul Islam', 'nazrulislam@gmail.com', '098965656'),
(3, 'riyakhan@gmail.com', 'Riya Khan', 'riyakhan@gmail.com', NULL),
(4, 'ellahohm@gmail.com', 'Ellah Ohm', '', '123465');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sent_by` varchar(255) NOT NULL,
  `received_by` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `createdAt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sent_by`, `received_by`, `message`, `createdAt`) VALUES
(1, 'juancruz@gmail.com', 'samsarah@gmail.com', 'hey', '2023-01-25 09:53:43am'),
(2, 'juancruz@gmail.com', 'samsarah@gmail.com', 'aa', '2023-01-25 10:19:07am'),
(3, 'juancruz@gmail.com', 'samsarah@gmail.com', 'ha', '2023-01-25 10:29:07am'),
(4, 'juancruz@gmail.com', 'samsarah@gmail.com', 'unsa man', '2023-01-25 10:29:19am'),
(5, 'p@gmail.com', 'juancruz@gmail.com', 'hey', '2023-01-25 05:02:19pm'),
(6, 'pao@gmail.com', 'samsarah@gmail.com', 'hey', '2023-01-25 07:24:00pm'),
(7, 'samsarah@gmail.com', 'juancruz@gmail.com', 'hello', '2023-01-25 08:06:29pm'),
(8, 'samsarah@gmail.com', 'pao@gmail.com', 'yes?', '2023-01-25 08:06:51pm'),
(9, 'samsarah@gmail.com', 'pao@gmail.com', 'hi', '2023-01-25 08:07:02pm'),
(10, 'samsarah@gmail.com', 'juancruz@gmail.com', 'yes?', '2023-01-25 08:07:12pm'),
(11, 'samsarah@gmail.com', 'juancruz@gmail.com', 'test', '2023-01-25 08:08:24pm'),
(12, 'samsarah@gmail.com', 'pao@gmail.com', 'ano po yun', '2023-01-25 08:08:40pm'),
(13, 'pao@gmail.com', 'samsarah@gmail.com', 'wala lang', '2023-01-25 08:08:54pm'),
(14, 'pao@gmail.com', 'samsarah@gmail.com', 'crush lang kita', '2023-01-25 08:08:59pm'),
(15, 'juleann@gmail.com', 'samsarah@gmail.com', 'hi', '2023-01-26 08:13:47am'),
(16, 'samsarah@gmail.com', 'juleann@gmail.com', 'hello', '2023-01-26 08:14:03am'),
(17, 'p@gmail.com', 'riyakhan@gmail.com', 'hi', '2023-01-26 08:32:42am'),
(18, 'riyakhan@gmail.com', '', 'yes?', '2023-01-26 08:28:27pm'),
(19, 'riyakhan@gmail.com', '', 'hey', '2023-01-26 08:32:22pm'),
(20, 'riyakhan@gmail.com', '', 'hey hye', '2023-01-26 08:33:25pm'),
(21, 'riyakhan@gmail.com', '', 'sdf', '2023-01-26 08:33:56pm'),
(22, 'juleann@gmail.com', 'samsarah@gmail.com', 'sd', '2023-01-26 09:42:14pm'),
(23, 'juleann@gmail.com', 'samsarah@gmail.com', 'hk', '2023-01-27 02:16:46am'),
(24, 'juleann@gmail.com', 'samsarah@gmail.com', 'Hello', '2023-01-27 03:13:04am');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `instructor_name` varchar(255) NOT NULL,
  `enrollment_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `course_type` varchar(255) DEFAULT NULL,
  `schedule_date` varchar(255) DEFAULT NULL,
  `schedule_time` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `instructor_id`, `instructor_name`, `enrollment_id`, `title`, `course_type`, `schedule_date`, `schedule_time`) VALUES
(11, 3, 'Riya Khan', NULL, '15 hours Driving Wheel Course', 'Theoretical Driving Lesson', '2023-02-01', '10:00'),
(13, 2, 'Nazrul Islam', NULL, 'Understanding traffic signs and signals', 'Theoretical Driving Lesson', '2023-01-27', '08:00'),
(14, 4, 'Ellah Ohm', NULL, 'gaw', 'Theoretical Driving Lesson', '2023-02-01', '22:09'),
(15, 1, 'Sam Sarah', NULL, 'Safe Driving and Protocols', 'Theoretical Driving Lesson', '2023-01-30', '07:52'),
(16, 1, 'Sam Sarah', NULL, 'Proper use of headlights, turn signals, and brake lights', 'Theoretical Driving Lesson', '2023-02-03', '07:00');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `student_email` varchar(255) DEFAULT NULL,
  `student_name` varchar(255) DEFAULT NULL,
  `student_password` varchar(255) DEFAULT NULL,
  `student_address` varchar(255) DEFAULT NULL,
  `student_birthdate` date DEFAULT NULL,
  `student_phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `student_email`, `student_name`, `student_password`, `student_address`, `student_birthdate`, `student_phone`) VALUES
(1, 'andrewmalone@gmail.com', 'Andrew  Malone', 'andrewmalone@gmail.com', NULL, '1999-08-23', NULL),
(2, 'juleann@gmail.com', 'Jule Ann  Ferolino', 'juleann@gmail.com', NULL, '2000-05-08', NULL),
(5, 'p@gmail.com', 'Paolo Olyoper Laña', 'pao', 'Toledo City', '2003-12-31', '09104744341'),
(8, 'brian@gmail.com', 'Brian Calida Villarin', 'brian', NULL, '1999-07-01', NULL),
(9, 'teo@gmail.com', 'Teo B Buhia', 'teo', NULL, '1999-09-01', NULL),
(10, 'teodor@gmail.com', 'Teodoro B Buhia', 'teodoro', NULL, '1999-09-01', NULL),
(11, 'jane@gmail.com', 'Jane  Heist', 'jane@gmail.com', NULL, '2000-01-10', NULL),
(12, 'pjcong@gmail.com', 'PJ  Cong', '3k3k3k', NULL, '1999-01-01', NULL),
(13, 'trialcardnipj@gmail.com', 'trial  card', '3k3k3k', NULL, '2000-02-01', NULL),
(14, '3k3k3k@gmail.com', 'trial  card nasad', '3k3k3k', NULL, '1999-01-01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `webuser`
--

CREATE TABLE `webuser` (
  `email` varchar(255) NOT NULL,
  `usertype` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `webuser`
--

INSERT INTO `webuser` (`email`, `usertype`) VALUES
('3k3k3k@gmail.com', 'student'),
('admin@drivingschool.com', 'admin'),
('andrewmalone@gmail.com', 'student'),
('brian@gmail.com', 'student'),
('efreimgenson@gmail.com', 'instructor'),
('ellahohm@gmail.com', 'instructor'),
('jane@gmail.com', 'student'),
('juleann@gmail.com', 'student'),
('nazrulislam@gmail.com', 'instructor'),
('p@gmail.com', 'student'),
('pjcong@gmail.com', 'student'),
('riyakhan@gmail.com', 'instructor'),
('samsarah@gmail.com', 'instructor'),
('teo@gmail.com', 'student'),
('teodor@gmail.com', 'student'),
('trialcardnipj@gmail.com', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `admin_email` (`admin_email`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `schedule_id` (`schedule_id`),
  ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `enrollment_request`
--
ALTER TABLE `enrollment_request`
  ADD PRIMARY KEY (`enrollment_request_id`),
  ADD KEY `student_id` (`student_id`,`schedule_id`),
  ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`evaluation_id`),
  ADD KEY `instructor_id` (`instructor_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`instructor_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `instructor_id` (`instructor_id`),
  ADD KEY `enrollment_id` (`enrollment_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `webuser`
--
ALTER TABLE `webuser`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `enrollment`
--
ALTER TABLE `enrollment`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `enrollment_request`
--
ALTER TABLE `enrollment_request`
  MODIFY `enrollment_request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `evaluation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `instructor`
--
ALTER TABLE `instructor`
  MODIFY `instructor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
