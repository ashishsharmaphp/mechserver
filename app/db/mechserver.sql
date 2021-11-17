-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2021 at 03:18 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mechserver`
--

-- --------------------------------------------------------

--
-- Table structure for table `mech_master`
--

CREATE TABLE `mech_master` (
  `id` int(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `device_token` varchar(100) NOT NULL,
  `os` varchar(20) NOT NULL,
  `dp` text NOT NULL,
  `email_valid` varchar(50) NOT NULL,
  `mobile_valid` varchar(50) NOT NULL,
  `is_active` varchar(10) NOT NULL,
  `is_busy` varchar(10) NOT NULL,
  `is_logged_in` varchar(10) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mech_master`
--

INSERT INTO `mech_master` (`id`, `name`, `email`, `mobile`, `pass`, `device_token`, `os`, `dp`, `email_valid`, `mobile_valid`, `is_active`, `is_busy`, `is_logged_in`, `added_on`) VALUES
(1, 'A', 'ashish@gmail.com', '9878978733', 'abcd', 'hkhjkhjkhkj', 'jkhk', '', '1', '1', '1', '1', '1', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `mech_ratings`
--

CREATE TABLE `mech_ratings` (
  `id` int(50) NOT NULL,
  `mech_id` int(50) NOT NULL,
  `user_id` int(50) NOT NULL,
  `request_id` int(50) NOT NULL,
  `rating` int(10) NOT NULL,
  `comments` text NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mech_service`
--

CREATE TABLE `mech_service` (
  `id` int(50) NOT NULL,
  `mech_id` int(50) NOT NULL,
  `service_id` int(50) NOT NULL,
  `price` int(50) NOT NULL,
  `comments` text NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mech_service`
--

INSERT INTO `mech_service` (`id`, `mech_id`, `service_id`, `price`, `comments`, `added_on`) VALUES
(1, 1, 1, 500, 'JJJJJJJJJJJJJJJJ', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(50) NOT NULL,
  `notification_text` text NOT NULL,
  `is_active` int(5) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `notification_text`, `is_active`, `created_on`) VALUES
(1, 'HHHHHHHHHHHHHH', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `otp_master`
--

CREATE TABLE `otp_master` (
  `id` int(50) NOT NULL,
  `user_id` int(50) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `otp` int(50) NOT NULL,
  `generated_for` int(50) NOT NULL,
  `generated_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_expire` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `request_master`
--

CREATE TABLE `request_master` (
  `id` int(50) NOT NULL,
  `user_id` int(50) NOT NULL,
  `service_id` int(50) NOT NULL,
  `lats` varchar(100) NOT NULL,
  `longs` varchar(100) NOT NULL,
  `location_detail` text NOT NULL,
  `status` varchar(50) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `related_req_id` int(50) NOT NULL,
  `comments` text NOT NULL,
  `tracked_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `request_vehical_details`
--

CREATE TABLE `request_vehical_details` (
  `id` int(50) NOT NULL,
  `request_id` int(50) NOT NULL,
  `vehical_type` varchar(50) NOT NULL,
  `make` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `fuel` varchar(50) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `services_master`
--

CREATE TABLE `services_master` (
  `id` int(50) NOT NULL,
  `service_code` varchar(50) NOT NULL,
  `service_description` text NOT NULL,
  `vehical_type` varchar(50) NOT NULL,
  `is_active` int(5) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services_master`
--

INSERT INTO `services_master` (`id`, `service_code`, `service_description`, `vehical_type`, `is_active`, `added_on`) VALUES
(1, 'HGTYH', 'JKJHKJHJK', '7', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `track_master`
--

CREATE TABLE `track_master` (
  `id` int(50) NOT NULL,
  `mech_id` int(50) NOT NULL,
  `lat` varchar(100) NOT NULL,
  `long` varchar(100) NOT NULL,
  `location_detail` text NOT NULL,
  `tracked_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_master`
--

CREATE TABLE `transaction_master` (
  `id` int(50) NOT NULL,
  `request_id` int(50) NOT NULL,
  `user_id` int(50) NOT NULL,
  `mech_id` int(50) NOT NULL,
  `service_id` int(50) NOT NULL,
  `service_charge` int(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `paid_by` varchar(50) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `return_transaction_id` varchar(100) NOT NULL,
  `tracked_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

CREATE TABLE `user_master` (
  `id` int(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `device_token` varchar(100) NOT NULL,
  `os` varchar(50) NOT NULL,
  `dp` varchar(50) NOT NULL,
  `is_busy` varchar(50) NOT NULL,
  `is_active` varchar(10) NOT NULL,
  `is_logged_in` varchar(10) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_master`
--

INSERT INTO `user_master` (`id`, `name`, `email`, `mobile`, `pass`, `device_token`, `os`, `dp`, `is_busy`, `is_active`, `is_logged_in`, `added_on`) VALUES
(1, 'A2', 'ashish2@gmail.com', '4545454555', 'abcd', 'kljjljljljlkj', 'kk', '', '1', '1', '1', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_track_master`
--

CREATE TABLE `user_track_master` (
  `id` int(50) NOT NULL,
  `user_id` int(50) NOT NULL,
  `lat` varchar(100) NOT NULL,
  `long` varchar(100) NOT NULL,
  `location_detail` text NOT NULL,
  `tracked_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vehical_make_master`
--

CREATE TABLE `vehical_make_master` (
  `id` int(50) NOT NULL,
  `make` varchar(50) NOT NULL,
  `vehical_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vehical_model_master`
--

CREATE TABLE `vehical_model_master` (
  `id` int(50) NOT NULL,
  `make_id` int(50) NOT NULL,
  `model` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vouchers_master`
--

CREATE TABLE `vouchers_master` (
  `id` int(50) NOT NULL,
  `code` varchar(100) NOT NULL,
  `is_active` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vouchers_master`
--

INSERT INTO `vouchers_master` (`id`, `code`, `is_active`) VALUES
(1, 'HGHJGJH', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mech_master`
--
ALTER TABLE `mech_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mech_ratings`
--
ALTER TABLE `mech_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mech_service`
--
ALTER TABLE `mech_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp_master`
--
ALTER TABLE `otp_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_master`
--
ALTER TABLE `request_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_vehical_details`
--
ALTER TABLE `request_vehical_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services_master`
--
ALTER TABLE `services_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `track_master`
--
ALTER TABLE `track_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_master`
--
ALTER TABLE `transaction_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_master`
--
ALTER TABLE `user_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_track_master`
--
ALTER TABLE `user_track_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehical_make_master`
--
ALTER TABLE `vehical_make_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehical_model_master`
--
ALTER TABLE `vehical_model_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vouchers_master`
--
ALTER TABLE `vouchers_master`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mech_master`
--
ALTER TABLE `mech_master`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mech_ratings`
--
ALTER TABLE `mech_ratings`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mech_service`
--
ALTER TABLE `mech_service`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `otp_master`
--
ALTER TABLE `otp_master`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_master`
--
ALTER TABLE `request_master`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_vehical_details`
--
ALTER TABLE `request_vehical_details`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services_master`
--
ALTER TABLE `services_master`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `track_master`
--
ALTER TABLE `track_master`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_master`
--
ALTER TABLE `transaction_master`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_master`
--
ALTER TABLE `user_master`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_track_master`
--
ALTER TABLE `user_track_master`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehical_make_master`
--
ALTER TABLE `vehical_make_master`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehical_model_master`
--
ALTER TABLE `vehical_model_master`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vouchers_master`
--
ALTER TABLE `vouchers_master`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
