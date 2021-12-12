-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 12, 2021 at 12:29 AM
-- Server version: 5.5.68-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ahmad_salman`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

DROP TABLE IF EXISTS `activity`;
CREATE TABLE `activity` (
  `a_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf16_turkish_ci NOT NULL,
  `location` varchar(255) COLLATE utf16_turkish_ci NOT NULL,
  `date` date NOT NULL,
  `type` varchar(255) COLLATE utf16_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `airport`
--

DROP TABLE IF EXISTS `airport`;
CREATE TABLE `airport` (
  `airport_code` char(3) COLLATE utf16_turkish_ci NOT NULL,
  `name` varchar(255) COLLATE utf16_turkish_ci NOT NULL,
  `city` varchar(255) COLLATE utf16_turkish_ci NOT NULL,
  `country` varchar(255) COLLATE utf16_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

DROP TABLE IF EXISTS `booking`;
CREATE TABLE `booking` (
  `b_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `r_id` int(11) NOT NULL,
  `e_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `type` varchar(255) COLLATE utf16_turkish_ci NOT NULL,
  `status` varchar(255) COLLATE utf16_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_review`
--

DROP TABLE IF EXISTS `customer_review`;
CREATE TABLE `customer_review` (
  `cr_id` int(11) NOT NULL,
  `tour_rate` int(11) NOT NULL,
  `tour_comment` varchar(1000) COLLATE utf16_turkish_ci NOT NULL,
  `guide_rate` int(11) NOT NULL,
  `guide_comment` varchar(1000) COLLATE utf16_turkish_ci NOT NULL,
  `c_id` int(11) NOT NULL,
  `ts_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee` (
  `e_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf16_turkish_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf16_turkish_ci NOT NULL,
  `email` varchar(190) COLLATE utf16_turkish_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf16_turkish_ci NOT NULL,
  `birthday` date DEFAULT NULL,
  `salary` int(11) DEFAULT NULL,
  `position` varchar(255) COLLATE utf16_turkish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`e_id`, `name`, `lastname`, `email`, `password_hash`, `birthday`, `salary`, `position`) VALUES
(11, 'a', 'a', 'a@a', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '2021-12-22', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

DROP TABLE IF EXISTS `flight`;
CREATE TABLE `flight` (
  `f_id` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `ticket_price` int(11) NOT NULL,
  `dept_airport` char(3) COLLATE utf16_turkish_ci NOT NULL,
  `dest_airport` char(3) COLLATE utf16_turkish_ci NOT NULL,
  `dept_date` date NOT NULL,
  `arrive_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flight_reservation`
--

DROP TABLE IF EXISTS `flight_reservation`;
CREATE TABLE `flight_reservation` (
  `fr_id` int(11) NOT NULL,
  `f_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `number_of_passengers` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guides`
--

DROP TABLE IF EXISTS `guides`;
CREATE TABLE `guides` (
  `tg_id` int(11) NOT NULL,
  `ts_id` int(11) NOT NULL,
  `e_id` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf16_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

--
-- Dumping data for table `guides`
--

INSERT INTO `guides` (`tg_id`, `ts_id`, `e_id`, `status`) VALUES
(13, 2, 11, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

DROP TABLE IF EXISTS `hotel`;
CREATE TABLE `hotel` (
  `h_id` int(11) NOT NULL,
  `phone` int(12) DEFAULT NULL,
  `name` varchar(255) COLLATE utf16_turkish_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf16_turkish_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf16_turkish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE `reservation` (
  `res_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `ts_id` int(11) NOT NULL,
  `e_id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf16_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`res_id`, `c_id`, `ts_id`, `e_id`, `number`, `status`) VALUES
(1, 26, 2, 11, 3, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_activity`
--

DROP TABLE IF EXISTS `reservation_activity`;
CREATE TABLE `reservation_activity` (
  `res_id` int(11) NOT NULL,
  `a_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
CREATE TABLE `room` (
  `h_id` int(11) NOT NULL COMMENT 'foreignkey',
  `price` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `r_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thecustomer`
--

DROP TABLE IF EXISTS `thecustomer`;
CREATE TABLE `thecustomer` (
  `c_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf16_turkish_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf16_turkish_ci NOT NULL,
  `email` varchar(190) COLLATE utf16_turkish_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf16_turkish_ci NOT NULL,
  `birthday` date NOT NULL,
  `profile_picture` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

--
-- Dumping data for table `thecustomer`
--

INSERT INTO `thecustomer` (`c_id`, `name`, `lastname`, `email`, `password_hash`, `birthday`, `profile_picture`) VALUES
(26, 'Mehmet', 'Kck', 'a@a', 'ca978112ca1bbdcafac231b39a23dc4da786eff8147c4e72b9807785afee48bb', '2021-12-09', NULL),
(27, 'a', 'a', 'v@a', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '2021-12-09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tour`
--

DROP TABLE IF EXISTS `tour`;
CREATE TABLE `tour` (
  `t_id` int(11) NOT NULL,
  `place` varchar(255) COLLATE utf16_turkish_ci NOT NULL,
  `type` varchar(255) COLLATE utf16_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

--
-- Dumping data for table `tour`
--

INSERT INTO `tour` (`t_id`, `place`, `type`) VALUES
(2, 'place1', 'best tour name'),
(3, 'place2', 'another tour name');

-- --------------------------------------------------------

--
-- Table structure for table `tour_activity`
--

DROP TABLE IF EXISTS `tour_activity`;
CREATE TABLE `tour_activity` (
  `ts_id` int(11) NOT NULL,
  `a_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_guide`
--

DROP TABLE IF EXISTS `tour_guide`;
CREATE TABLE `tour_guide` (
  `tg_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf16_turkish_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf16_turkish_ci NOT NULL,
  `email` varchar(190) COLLATE utf16_turkish_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf16_turkish_ci NOT NULL,
  `birthday` date DEFAULT NULL,
  `registration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_picture` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

--
-- Dumping data for table `tour_guide`
--

INSERT INTO `tour_guide` (`tg_id`, `name`, `lastname`, `email`, `password_hash`, `birthday`, `registration`, `profile_picture`) VALUES
(13, 'ahmet', 'salman', 'a@a', 'a', '2021-12-09', '2021-12-11 14:04:42', NULL),
(14, 'MCan', 'Kck', 'M@C', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '2021-12-01', '2021-12-11 23:13:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tour_guide_review`
--

DROP TABLE IF EXISTS `tour_guide_review`;
CREATE TABLE `tour_guide_review` (
  `tgr_id` int(11) NOT NULL,
  `tour_comment` varchar(1000) COLLATE utf16_turkish_ci NOT NULL,
  `tg_id` int(11) NOT NULL,
  `ts_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_section`
--

DROP TABLE IF EXISTS `tour_section`;
CREATE TABLE `tour_section` (
  `ts_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `t_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `airport`
--
ALTER TABLE `airport`
  ADD PRIMARY KEY (`airport_code`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`b_id`),
  ADD KEY `fk_booking_customer` (`c_id`),
  ADD KEY `fk_booking_employee` (`e_id`),
  ADD KEY `fk_booking_room` (`r_id`);

--
-- Indexes for table `customer_review`
--
ALTER TABLE `customer_review`
  ADD PRIMARY KEY (`cr_id`),
  ADD KEY `fk_cr_customer` (`c_id`),
  ADD KEY `fk_cr_tour_section` (`ts_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`e_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `fk_flight_dept_airport` (`dept_airport`),
  ADD KEY `fk_flight_dest_airport` (`dest_airport`);

--
-- Indexes for table `flight_reservation`
--
ALTER TABLE `flight_reservation`
  ADD PRIMARY KEY (`fr_id`),
  ADD KEY `fk_fr_flight` (`f_id`),
  ADD KEY `fk_fr_customer` (`c_id`);

--
-- Indexes for table `guides`
--
ALTER TABLE `guides`
  ADD KEY `fk_guides_tour_guide` (`tg_id`),
  ADD KEY `fk_guides_tour_section` (`ts_id`),
  ADD KEY `fk_guides_employee` (`e_id`);

--
-- Indexes for table `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`h_id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`res_id`),
  ADD KEY `fk_reservation_customer` (`c_id`),
  ADD KEY `fk_reservation_employee` (`e_id`),
  ADD KEY `fk_reservation_tour_section` (`ts_id`);

--
-- Indexes for table `reservation_activity`
--
ALTER TABLE `reservation_activity`
  ADD KEY `fk_reservation_activity_reservation` (`res_id`),
  ADD KEY `fk_reservation_activity_activity` (`a_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`r_id`),
  ADD KEY `fk_hotel_room` (`h_id`);

--
-- Indexes for table `thecustomer`
--
ALTER TABLE `thecustomer`
  ADD PRIMARY KEY (`c_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tour`
--
ALTER TABLE `tour`
  ADD PRIMARY KEY (`t_id`);

--
-- Indexes for table `tour_activity`
--
ALTER TABLE `tour_activity`
  ADD KEY `fk_ta_activity` (`a_id`),
  ADD KEY `fk_ta_tour_section` (`ts_id`);

--
-- Indexes for table `tour_guide`
--
ALTER TABLE `tour_guide`
  ADD PRIMARY KEY (`tg_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tour_guide_review`
--
ALTER TABLE `tour_guide_review`
  ADD PRIMARY KEY (`tgr_id`),
  ADD KEY `fk_tgr_tour_guide` (`tg_id`),
  ADD KEY `fk_tgr_tour_section` (`ts_id`);

--
-- Indexes for table `tour_section`
--
ALTER TABLE `tour_section`
  ADD PRIMARY KEY (`ts_id`),
  ADD KEY `fk_ts_tour` (`t_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_review`
--
ALTER TABLE `customer_review`
  MODIFY `cr_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `e_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flight_reservation`
--
ALTER TABLE `flight_reservation`
  MODIFY `fr_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hotel`
--
ALTER TABLE `hotel`
  MODIFY `h_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `thecustomer`
--
ALTER TABLE `thecustomer`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tour`
--
ALTER TABLE `tour`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tour_guide`
--
ALTER TABLE `tour_guide`
  MODIFY `tg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tour_guide_review`
--
ALTER TABLE `tour_guide_review`
  MODIFY `tgr_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour_section`
--
ALTER TABLE `tour_section`
  MODIFY `ts_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `fk_booking_customer` FOREIGN KEY (`c_id`) REFERENCES `thecustomer` (`c_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_booking_employee` FOREIGN KEY (`e_id`) REFERENCES `employee` (`e_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_booking_room` FOREIGN KEY (`r_id`) REFERENCES `room` (`r_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer_review`
--
ALTER TABLE `customer_review`
  ADD CONSTRAINT `fk_cr_customer` FOREIGN KEY (`c_id`) REFERENCES `thecustomer` (`c_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cr_tour_section` FOREIGN KEY (`ts_id`) REFERENCES `tour_section` (`ts_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `flight`
--
ALTER TABLE `flight`
  ADD CONSTRAINT `fk_flight_dept_airport` FOREIGN KEY (`dept_airport`) REFERENCES `airport` (`airport_code`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_flight_dest_airport` FOREIGN KEY (`dest_airport`) REFERENCES `airport` (`airport_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `flight_reservation`
--
ALTER TABLE `flight_reservation`
  ADD CONSTRAINT `fk_fr_flight` FOREIGN KEY (`f_id`) REFERENCES `flight` (`f_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_fr_customer` FOREIGN KEY (`c_id`) REFERENCES `thecustomer` (`c_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `guides`
--
ALTER TABLE `guides`
  ADD CONSTRAINT `fk_guides_tour_guide` FOREIGN KEY (`tg_id`) REFERENCES `tour_guide` (`tg_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_guides_tour_section` FOREIGN KEY (`ts_id`) REFERENCES `tour_section` (`ts_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_guides_employee` FOREIGN KEY (`e_id`) REFERENCES `employee` (`e_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `fk_reservation_customer` FOREIGN KEY (`c_id`) REFERENCES `thecustomer` (`c_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reservation_employee` FOREIGN KEY (`e_id`) REFERENCES `employee` (`e_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reservation_tour_section` FOREIGN KEY (`ts_id`) REFERENCES `tour_section` (`ts_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation_activity`
--
ALTER TABLE `reservation_activity`
  ADD CONSTRAINT `fk_reservation_activity_reservation` FOREIGN KEY (`res_id`) REFERENCES `reservation` (`res_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reservation_activity_activity` FOREIGN KEY (`a_id`) REFERENCES `activity` (`a_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `fk_hotel_room` FOREIGN KEY (`h_id`) REFERENCES `hotel` (`h_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tour_activity`
--
ALTER TABLE `tour_activity`
  ADD CONSTRAINT `fk_ta_activity` FOREIGN KEY (`a_id`) REFERENCES `activity` (`a_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ta_tour_section` FOREIGN KEY (`ts_id`) REFERENCES `tour_section` (`ts_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tour_guide_review`
--
ALTER TABLE `tour_guide_review`
  ADD CONSTRAINT `fk_tgr_tour_guide` FOREIGN KEY (`tg_id`) REFERENCES `tour_guide` (`tg_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tgr_tour_section` FOREIGN KEY (`ts_id`) REFERENCES `tour_section` (`ts_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tour_section`
--
ALTER TABLE `tour_section`
  ADD CONSTRAINT `fk_ts_tour` FOREIGN KEY (`t_id`) REFERENCES `tour` (`t_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
