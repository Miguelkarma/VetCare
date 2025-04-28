-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2025 at 06:35 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ovas_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment_list`
--

CREATE TABLE `appointment_list` (
  `id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `schedule` date NOT NULL,
  `owner_name` text NOT NULL,
  `contact` text NOT NULL,
  `email` text NOT NULL,
  `address` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `breed` text NOT NULL,
  `age` varchar(50) NOT NULL,
  `service_ids` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `pet_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `time_sched` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE appointment_list 
CHANGE time_sched time_sched VARCHAR(50);


--
-- Table structure for table `category_list`
--

CREATE TABLE `category_list` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = Active, 1 = Delete',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `name`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'Dogs', 1, '2022-01-04 10:31:11', NULL),
(2, 'Cats', 0, '2022-01-04 10:31:38', NULL),
(3, 'Hamsters', 0, '2022-01-04 10:32:02', NULL),
(4, 'Rabbits', 1, '2022-01-04 10:32:13', NULL),
(5, 'Birds', 1, '2022-01-04 10:32:47', NULL),
(6, 'test', 1, '2022-01-04 10:33:02', NULL),
(7, 'crocodile', 0, '2024-12-16 14:26:31', NULL),
(8, 'Manok', 1, '2024-12-19 19:35:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clinic_history`
--

CREATE TABLE `clinic_history` (
  `id` int(11) NOT NULL,
  `owner_id` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `breed` text NOT NULL,
  `age` varchar(50) NOT NULL,
  `service_ids` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `pet_id` int(11) NOT NULL,
  `notes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clinic_history`
--

INSERT INTO `clinic_history` (`id`, `owner_id`, `category_id`, `breed`, `age`, `service_ids`, `status`, `date_created`, `date_updated`, `pet_id`, `notes`) VALUES
(9, '1', 7, 'Fresh Water', '2', '7', 1, '2024-12-18 20:59:43', '2024-12-18 21:05:44', 4, ''),
(10, '2', 2, 'trex2', '2', '3,2', 1, '2024-12-19 13:29:28', NULL, 0, '<p>Lower neck full of bones</p>'),
(11, '1', 2, 'German Cat', '2', '1,2,8', 1, '2024-12-19 19:33:01', NULL, 1, '<ul><li>May sipon saka ubo yung pusa</li><li>ghhhhhh</li><li>hhhhhhh</li></ul>'),
(12, '1', 2, 'German Cat', '2', '1,2', 1, '2025-01-06 00:30:42', NULL, 1, '<p>Sample Note</p>');

-- --------------------------------------------------------

--
-- Table structure for table `message_list`
--

CREATE TABLE `message_list` (
  `id` int(11) NOT NULL,
  `fullname` text NOT NULL,
  `contact` text NOT NULL,
  `email` text NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message_list`
--

INSERT INTO `message_list` (`id`, `fullname`, `contact`, `email`, `message`, `status`, `date_created`) VALUES
(1, 'test', '09123456897', 'jsmith@sample.com', 'test', 1, '2022-01-04 17:26:19'),
(2, 'test', '09854698789 ', 'sanospaulmigz@gmail.com', 'hehe', 1, '2025-04-18 17:43:06');

-- --------------------------------------------------------

--
-- Table structure for table `pet_records`
--

CREATE TABLE `pet_records` (
  `pet_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `breed` text NOT NULL,
  `age` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `delete_flag` int(11) NOT NULL,
  `pet_name` varchar(200) NOT NULL,
  `image_path` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pet_records`
--

INSERT INTO `pet_records` (`pet_id`, `owner_id`, `category_id`, `breed`, `age`, `status`, `date_created`, `date_updated`, `delete_flag`, `pet_name`, `image_path`) VALUES
(1, 1, 2, 'German Cat', '2', 0, '2024-12-16 14:31:28', '2025-04-19 00:09:50', 1, 'memo1', 'uploads/pet_images/1.png?v=1737800248'),
(2, 3, 2, 'Galaxy', '2', 0, '2024-12-16 15:00:38', '2025-04-19 00:10:29', 1, 'memo2', ''),
(3, 3, 7, 'Salt Water', '2', 0, '2024-12-16 15:04:13', '2024-12-18 19:53:14', 0, 'memo3', ''),
(4, 1, 7, 'Fresh Water', '2', 0, '2024-12-18 20:07:46', '2025-04-19 00:14:46', 1, 'Croco 1', ''),
(5, 1, 5, 'Maya', '1', 0, '2024-12-19 19:28:06', NULL, 0, 'Maya-1', ''),
(6, 1, 1, 'Sample', '2', 0, '2025-01-06 00:31:01', NULL, 0, 'Killer', ''),
(7, 4, 2, 'Maya', '3', 0, '2025-01-06 00:32:37', NULL, 0, 'Pome2', ''),
(8, 5, 2, '11asas', '1', 0, '2025-01-26 21:22:07', '2025-01-26 21:22:45', 0, 'asasas', 'uploads/pet_images/8.png?v=1737897765'),
(9, 6, 7, 'German Crocks', '3', 0, '2025-02-26 09:01:11', NULL, 0, 'Croco 33', NULL),
(10, 7, 7, 'siberian husky', '2', 0, '2025-03-01 21:44:12', '2025-04-19 00:10:44', 1, 'snoop', 'uploads/pet_images/10.png?v=1740836652');

-- --------------------------------------------------------

--
-- Table structure for table `service_list`
--

CREATE TABLE `service_list` (
  `id` int(11) NOT NULL,
  `category_ids` text NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `fee` float NOT NULL DEFAULT 0,
  `delete_flag` tinyint(4) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_list`
--

INSERT INTO `service_list` (`id`, `category_ids`, `name`, `description`, `fee`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, '2,7,1,3', 'Immunization', '<p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris quis quam tellus. Nam elit lectus, lobortis vitae eros a, condimentum pretium eros. Sed mauris nulla, aliquam vel hendrerit ac, aliquam quis mi. In non purus ac metus luctus aliquam. Praesent porta turpis eget molestie pellentesque. In fringilla est vitae sem imperdiet eleifend. Praesent lacinia arcu elit, quis venenatis nisl sollicitudin nec. Pellentesque tempor est nec porta mattis. In hendrerit eleifend felis, quis fermentum dolor eleifend quis. Maecenas dolor magna, luctus id blandit sit amet, bibendum id lacus.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;\">Nunc pellentesque nibh vel sapien lobortis tempus. In pretium nulla felis, cursus bibendum augue pretium at. Integer eget dignissim libero. Praesent laoreet, purus eu vehicula hendrerit, felis leo lobortis mi, at aliquet nisl est a dolor. Duis eleifend pharetra augue ut finibus. Curabitur id lorem lobortis, tempus mauris quis, fermentum nunc. Vestibulum eu euismod diam, fermentum vulputate elit. Aenean eu odio tincidunt, semper nulla eget, pretium eros. In ullamcorper fringilla faucibus. Curabitur aliquam leo ex, in cursus arcu commodo eu. Vivamus in nulla id massa efficitur rhoncus. Ut sagittis arcu ipsum, at posuere eros pretium nec. Nam neque mauris, molestie eu euismod a, vulputate at diam. Nullam mattis purus tortor, rutrum fringilla lorem eleifend nec. Vestibulum vitae purus sit amet leo imperdiet tristique at ac orci.</p>', 1500, 0, '2022-01-04 10:59:49', '2025-01-26 21:31:24'),
(2, '2,1', 'Vaccination', '<p><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Curabitur facilisis consequat lacinia. Curabitur luctus nunc ac libero mattis, id bibendum mauris pretium. Donec vulputate ac velit ac laoreet. Aliquam cursus feugiat turpis, id posuere nisl ornare sit amet. Duis pharetra quam vel risus semper vestibulum. Aliquam lacinia sit amet dolor a viverra. Ut sit amet turpis laoreet, euismod dui at, accumsan lacus. Fusce est nunc, consectetur ac neque at, commodo faucibus ipsum. Nullam rutrum dapibus pulvinar. Mauris eget magna id nisl consequat mollis vitae id purus. Cras eros tellus, fringilla et dictum quis, vulputate id erat. Aliquam erat volutpat.</span><br></p>', 1700, 0, '2022-01-04 11:14:24', NULL),
(3, '5,2,1,3,4', 'Check-up', '<p><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Ut fringilla velit quis condimentum mattis. Sed egestas ligula imperdiet orci elementum, eu aliquet sem cursus. Vestibulum maximus ex ut mi lobortis ultricies. Ut id congue ipsum. Donec porttitor a nunc a egestas. Ut non urna eget erat vestibulum eleifend. Phasellus blandit dui non neque cursus, id viverra turpis aliquet. Sed tempor nisl a ipsum porta, eget iaculis sem venenatis. Sed ac dolor sagittis, interdum leo ut, sagittis risus. Etiam suscipit, orci eget hendrerit malesuada, nisl mauris semper dolor, non accumsan nisl nibh ac augue. Integer vel lectus quis quam suscipit pharetra quis in lectus. Nulla bibendum ex sed accumsan laoreet. Cras et elit vitae sapien faucibus luctus. Morbi leo nibh, viverra vitae elit ac, luctus elementum urna.</span><br></p>', 500, 0, '2022-01-04 11:15:09', NULL),
(4, '1', 'Anti-Rabies', '<p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Ut fringilla velit quis condimentum mattis. Sed egestas ligula imperdiet orci elementum, eu aliquet sem cursus. Vestibulum maximus ex ut mi lobortis ultricies. Ut id congue ipsum. Donec porttitor a nunc a egestas. Ut non urna eget erat vestibulum eleifend. Phasellus blandit dui non neque cursus, id viverra turpis aliquet. Sed tempor nisl a ipsum porta, eget iaculis sem venenatis. Sed ac dolor sagittis, interdum leo ut, sagittis risus. Etiam suscipit, orci eget hendrerit malesuada, nisl mauris semper dolor, non accumsan nisl nibh ac augue. Integer vel lectus quis quam suscipit pharetra quis in lectus. Nulla bibendum ex sed accumsan laoreet. Cras et elit vitae sapien faucibus luctus. Morbi leo nibh, viverra vitae elit ac, luctus elementum urna.</span><br></p>', 500, 0, '2022-01-04 11:16:24', '2022-01-04 11:17:00'),
(5, '2', 'Anti-Rabies', '<p>Ut fringilla velit quis condimentum mattis. Sed egestas ligula imperdiet orci elementum, eu aliquet sem cursus. Vestibulum maximus ex ut mi lobortis ultricies. Ut id congue ipsum. Donec porttitor a nunc a egestas. Ut non urna eget erat vestibulum eleifend. Phasellus blandit dui non neque cursus, id viverra turpis aliquet. Sed tempor nisl a ipsum porta, eget iaculis sem venenatis. Sed ac dolor sagittis, interdum leo ut, sagittis risus. Etiam suscipit, orci eget hendrerit malesuada, nisl mauris semper dolor, non accumsan nisl nibh ac augue. Integer vel lectus quis quam suscipit pharetra quis in lectus. Nulla bibendum ex sed accumsan laoreet. Cras et elit vitae sapien faucibus luctus. Morbi leo nibh, viverra vitae elit ac, luctus elementum urna.<br></p>', 250, 0, '2022-01-04 11:16:38', '2022-01-04 11:17:08'),
(6, '4', 'deleted', '<p>test</p>', 123, 1, '2022-01-04 11:17:34', '2022-01-04 11:17:46'),
(7, '7', 'Dental Service', '<p>Full dental cleaning</p>', 10000, 0, '2024-12-18 20:10:35', NULL),
(8, '2', 'Vetrasine', '<p>HSahshasas</p>', 30, 0, '2024-12-19 19:31:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(11) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Veterinary Clinic Management System'),
(6, 'short_name', 'VETCMS'),
(11, 'logo', 'uploads/logo-1744994665.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover-1734675857.png'),
(15, 'content', 'Array'),
(16, 'email', 'short-tail@vetclinic.com'),
(17, 'contact', '+639152820168'),
(25, 'contact2', '+639XXXXXXXXX'),
(18, 'from_time', '11:00'),
(19, 'to_time', '21:30'),
(20, 'address', 'General Tinio Street, Cabanatuan City, 3100 Nueva Ecija'),
(23, 'max_appointment', '15'),
(24, 'clinic_schedule', '10:00 AM - 5:00 PM');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `address` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0=not verified, 1 = verified',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `contact` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `address`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `status`, `date_added`, `date_updated`, `contact`) VALUES
(1, 'Adminstrator', 'Quezon City Manila', 'Admin', 'admin@mail.com', '325a2cc052914ceeb8c19016c091d2ac', 'uploads/avatar-1.png?v=1734675895', NULL, 1, 1, '2021-01-20 14:02:37', '2024-12-27 10:11:00', '09929122'),
(3, 'jepitot', '', 'spot', 'cblake', '0192023a7bbd73250516f069df18b500', 'uploads/avatar-3.png?v=1639467985', NULL, 2, 1, '2021-12-14 15:46:25', '2025-04-19 23:37:00', '095641235185'),
(4, 'Trex', 'Quezon city, Manila', 'Trail', 'trex01', '325a2cc052914ceeb8c19016c091d2ac', 'uploads/avatar-4.png?v=1734672216', NULL, 2, 1, '2024-12-16 13:38:46', '2024-12-20 13:25:05', '099291222'),
(5, 'Sample', 'asasas', 'Last', 'client@mail.com', '325a2cc052914ceeb8c19016c091d2ac', 'uploads/avatar-5.png?v=1737897642', NULL, 2, 1, '2025-01-26 21:19:20', '2025-01-26 21:20:42', '0929921122'),
(6, 'Monds', 'asasasas', 'Cals', 'trex2@gmail.com', '325a2cc052914ceeb8c19016c091d2ac', NULL, NULL, 3, 1, '2025-02-19 07:33:42', NULL, 'asasas'),
(7, 'mig', 'www', 'Santos', 'primo@admin.com', 'ce2c039ceb8d544d2b3e7d7ffe84894f', 'uploads/avatar-7.png?v=1740836596', NULL, 3, 1, '2025-03-01 21:43:16', '2025-04-19 23:24:56', '09963555431');

-- --------------------------------------------------------

--
-- Table structure for table `vaccinations`
--

CREATE TABLE `vaccinations` (
  `id` int(11) NOT NULL,
  `pet_name` varchar(255) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `vaccine_type` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vaccinations`
--

INSERT INTO `vaccinations` (`id`, `pet_name`, `pet_id`, `vaccine_type`, `start_date`, `created_at`) VALUES
(1, 'Croco 1', 0, 'Rabies', '2024-12-21', '2024-12-20 07:57:33'),
(2, 'Maya-1', 0, 'Feline Leukemia', '2024-12-20', '2024-12-20 07:58:23'),
(3, 'Maya-1', 0, 'Feline Leukemia', '2024-12-28', '2024-12-27 01:59:21'),
(4, 'Croco 1', 4, 'Feline Leukemia', '2024-12-27', '2024-12-27 05:24:18'),
(5, 'memo1', 1, 'Rabies', '2025-01-07', '2025-01-05 16:33:17'),
(6, 'memo1', 1, 'Canine Distemper', '2025-02-26', '2025-02-26 01:31:55'),
(7, 'memo1', 1, 'Rabies', '2025-02-27', '2025-02-26 01:37:00');

-- --------------------------------------------------------

--
-- Table structure for table `vaccination_schedule`
--

CREATE TABLE `vaccination_schedule` (
  `id` int(11) NOT NULL,
  `vaccination_id` int(11) NOT NULL,
  `scheduled_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vaccination_schedule`
--

INSERT INTO `vaccination_schedule` (`id`, `vaccination_id`, `scheduled_date`, `created_at`) VALUES
(1, 1, '2024-12-21', '2024-12-20 07:57:33'),
(2, 1, '2025-12-21', '2024-12-20 07:57:33'),
(3, 2, '2024-12-20', '2024-12-20 07:58:23'),
(4, 2, '2025-01-10', '2024-12-20 07:58:23'),
(5, 2, '2025-12-20', '2024-12-20 07:58:23'),
(6, 3, '2024-12-28', '2024-12-27 01:59:21'),
(7, 3, '2025-01-18', '2024-12-27 01:59:21'),
(8, 3, '2025-12-28', '2024-12-27 01:59:21'),
(9, 4, '2024-12-27', '2024-12-27 05:24:18'),
(10, 4, '2025-01-17', '2024-12-27 05:24:18'),
(11, 4, '2025-12-27', '2024-12-27 05:24:18'),
(12, 5, '2025-01-07', '2025-01-05 16:33:17'),
(13, 5, '2026-01-07', '2025-01-05 16:33:17'),
(14, 6, '2025-02-26', '2025-02-26 01:31:55'),
(15, 6, '2025-03-19', '2025-02-26 01:31:55'),
(16, 6, '2026-02-26', '2025-02-26 01:31:55'),
(17, 7, '2025-02-27', '2025-02-26 01:37:00'),
(18, 7, '2026-02-27', '2025-02-26 01:37:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment_list`
--
ALTER TABLE `appointment_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clinic_history`
--
ALTER TABLE `clinic_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `message_list`
--
ALTER TABLE `message_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pet_records`
--
ALTER TABLE `pet_records`
  ADD PRIMARY KEY (`pet_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `service_list`
--
ALTER TABLE `service_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vaccinations`
--
ALTER TABLE `vaccinations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vaccination_schedule`
--
ALTER TABLE `vaccination_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vaccination_id` (`vaccination_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment_list`
--
ALTER TABLE `appointment_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `clinic_history`
--
ALTER TABLE `clinic_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `message_list`
--
ALTER TABLE `message_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pet_records`
--
ALTER TABLE `pet_records`
  MODIFY `pet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `service_list`
--
ALTER TABLE `service_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vaccinations`
--
ALTER TABLE `vaccinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vaccination_schedule`
--
ALTER TABLE `vaccination_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment_list`
--
ALTER TABLE `appointment_list`
  ADD CONSTRAINT `appointment_list_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `clinic_history`
--
ALTER TABLE `clinic_history`
  ADD CONSTRAINT `clinic_history_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pet_records`
--
ALTER TABLE `pet_records`
  ADD CONSTRAINT `pet_records_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vaccination_schedule`
--
ALTER TABLE `vaccination_schedule`
  ADD CONSTRAINT `vaccination_schedule_ibfk_1` FOREIGN KEY (`vaccination_id`) REFERENCES `vaccinations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
