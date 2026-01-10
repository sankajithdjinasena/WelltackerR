-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2026 at 06:36 PM
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
-- Database: `welltracker_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `community_likes`
--

CREATE TABLE `community_likes` (
  `like_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_ip` varchar(50) DEFAULT NULL,
  `liked_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `community_posts`
--

CREATE TABLE `community_posts` (
  `post_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `author` varchar(100) DEFAULT 'Guest',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `community_posts`
--

INSERT INTO `community_posts` (`post_id`, `title`, `message`, `author`, `created_at`) VALUES
(5, 'Health Awareness', 'Maintaining good health is more than just treating illness—it’s about daily habits that support your body and mind. Learn how simple lifestyle changes like proper nutrition, regular exercise, and adequate sleep can strengthen your immune system and prevent disease.', 'Sankajith Jinasena', '2025-11-26 16:23:46');

-- --------------------------------------------------------

--
-- Table structure for table `community_replies`
--

CREATE TABLE `community_replies` (
  `reply_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `author` varchar(100) DEFAULT 'Guest',
  `reply_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `community_replies`
--

INSERT INTO `community_replies` (`reply_id`, `post_id`, `author`, `reply_text`, `created_at`) VALUES
(9, 5, 'P.H. Perera', 'This is so true! I’ve started going for morning walks and I already feel more energetic.', '2025-11-26 16:26:16');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_notes`
--

CREATE TABLE `doctor_notes` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_notes`
--

INSERT INTO `doctor_notes` (`id`, `patient_id`, `doctor_id`, `note`, `created_at`) VALUES
(5, 5, 6, 'You need to balance your sugar level. ', '2025-11-26 16:28:54');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_verifications`
--

CREATE TABLE `doctor_verifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `license_number` varchar(50) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `notes` text DEFAULT NULL,
  `document_file` varchar(255) DEFAULT NULL,
  `verification_status` enum('Pending','Verified','Rejected') DEFAULT 'Pending',
  `submitted_at` datetime DEFAULT current_timestamp(),
  `verified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_verifications`
--

INSERT INTO `doctor_verifications` (`id`, `user_id`, `license_number`, `specialization`, `notes`, `document_file`, `verification_status`, `submitted_at`, `verified_at`) VALUES
(2, 6, '1763132001', 'Dentist', '', 'uploads/doctor_docs/1763441009_1763132001_ID.png', 'Verified', '2025-11-18 10:13:29', '2025-11-26 10:46:34');

-- --------------------------------------------------------

--
-- Table structure for table `forum_posts`
--

CREATE TABLE `forum_posts` (
  `post_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `author` varchar(100) DEFAULT 'Guest',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_history`
--

CREATE TABLE `medical_history` (
  `history_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `pdf_file` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_history`
--

INSERT INTO `medical_history` (`history_id`, `user_id`, `title`, `description`, `pdf_file`, `uploaded_at`) VALUES
(4, 5, 'Blood Report', 'Partlets good. ', 'uploads/medical_history/1764175331_report.pdf', '2025-11-26 16:42:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Doctor','Patient','Admin') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verification_status` enum('Pending','Verified','Rejected') DEFAULT 'Verified',
  `verification_details` text DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `role`, `created_at`, `verification_status`, `verification_details`, `telephone`) VALUES
(4, 'Welltracker', 'Admin', 'admin@welltracker.com', '$2y$10$U0bmQ/Kwpo9btsoVyDi/Me4Xq6mP7vLVoN8VUJ6NdSpaASKktt4tW', 'Admin', '2025-11-14 14:46:27', 'Verified', NULL, '0'),
(5, 'Sanodya', 'Jinadasa', 'sanodyav@gmail.com', '$2y$10$ZZ84jhlpbqGckuSgifRFpeT9hLaQ3bgk2vPpxC8SzVG9usrrPXDuS', 'Patient', '2025-11-17 14:23:34', 'Verified', NULL, '0'),
(6, 'Sankajith', 'Jinasena', 'sankajithdjinasena@gmail.com', '$2y$10$hrHcefoGlssRJmTWiA2Owuok39ZWC/0F.E1iDSpxb85cJDDjaKWwC', 'Doctor', '2025-11-18 04:30:05', 'Pending', NULL, '0713545642'),
(8, 'Nimesha', 'Jinasena', 'nimeshajinasena97@gmail.com', '$2y$10$Ka5yYOt6ZT54Ev31o47/je1GOFZxyQTuS2wE9xnZKTo5V4J7aJBo6', 'Patient', '2025-11-24 12:16:11', 'Verified', NULL, '0'),
(9, 'test', 'test', 'test123@gmail.com', '$2y$10$MV6cDMzQkn0IJpTWI8sxBeHGAsSBrDT6hYYPfvICxbm4s3uBi0/hO', 'Doctor', '2025-11-27 04:47:29', 'Pending', NULL, '0'),
(11, 'test', 'test', 'test1f23@gmail.com', '$2y$10$z9L6tU6G2667qJozbeChoeQHU2M79mGlkAi2w0s0lQIYQFx9llJL.', 'Doctor', '2025-12-20 12:57:42', 'Pending', NULL, '0713545642das');

-- --------------------------------------------------------

--
-- Table structure for table `vitals`
--

CREATE TABLE `vitals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `blood_pressure` varchar(20) DEFAULT NULL,
  `heart_rate` int(11) DEFAULT NULL,
  `blood_sugar` int(11) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vitals`
--

INSERT INTO `vitals` (`id`, `user_id`, `blood_pressure`, `heart_rate`, `blood_sugar`, `weight`, `notes`, `created_at`) VALUES
(1, 5, '15', 15, 10, 10, '', '2025-11-23 19:14:17'),
(2, 5, '50', 50, 50, 50, '', '2025-11-23 19:14:29'),
(3, 8, '120', 18, 100, 43, '--', '2025-11-24 12:17:32'),
(4, 5, '80', 60, 100, 55, '', '2025-11-26 09:44:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `community_likes`
--
ALTER TABLE `community_likes`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `community_posts`
--
ALTER TABLE `community_posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `community_replies`
--
ALTER TABLE `community_replies`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_notes`
--
ALTER TABLE `doctor_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `doctor_verifications`
--
ALTER TABLE `doctor_verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `forum_posts`
--
ALTER TABLE `forum_posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `medical_history`
--
ALTER TABLE `medical_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `vitals`
--
ALTER TABLE `vitals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `community_likes`
--
ALTER TABLE `community_likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `community_posts`
--
ALTER TABLE `community_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `community_replies`
--
ALTER TABLE `community_replies`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_notes`
--
ALTER TABLE `doctor_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `doctor_verifications`
--
ALTER TABLE `doctor_verifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `forum_posts`
--
ALTER TABLE `forum_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_history`
--
ALTER TABLE `medical_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `vitals`
--
ALTER TABLE `vitals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `community_likes`
--
ALTER TABLE `community_likes`
  ADD CONSTRAINT `community_likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `community_posts` (`post_id`) ON DELETE CASCADE;

--
-- Constraints for table `community_replies`
--
ALTER TABLE `community_replies`
  ADD CONSTRAINT `community_replies_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `community_posts` (`post_id`) ON DELETE CASCADE;

--
-- Constraints for table `doctor_notes`
--
ALTER TABLE `doctor_notes`
  ADD CONSTRAINT `doctor_notes_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `doctor_notes_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `doctor_verifications`
--
ALTER TABLE `doctor_verifications`
  ADD CONSTRAINT `doctor_verifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `medical_history`
--
ALTER TABLE `medical_history`
  ADD CONSTRAINT `medical_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vitals`
--
ALTER TABLE `vitals`
  ADD CONSTRAINT `vitals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
