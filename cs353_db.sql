-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 01, 2022 at 11:09 AM
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

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS ` employee_booking_endorsement`$$
CREATE DEFINER=`ahmad.salman`@`localhost` PROCEDURE ` employee_booking_endorsement` (IN `reservation_status` ENUM('approved','pending','rejected'))  READS SQL DATA
SELECT
        e.e_id,
        IFNULL(SUM(`b`.`bill`),0) AS sum_of_bills
    FROM
        employee AS e
    LEFT JOIN booking b ON
        b.e_id = e.e_id and b.status = reservation_status
         group by e.e_id$$

DROP PROCEDURE IF EXISTS `employee_reservation_endorsement`$$
CREATE DEFINER=`ahmad.salman`@`localhost` PROCEDURE `employee_reservation_endorsement` (IN `reservation_status` ENUM('approved','pending','rejected'))  READS SQL DATA
SELECT
        e.e_id,
        IFNULL(SUM(`r`.`bill`),0) AS sum_of_bills
    FROM
        employee AS e
    LEFT JOIN reservation r ON
        r.e_id = e.e_id and r.status = reservation_status
         group by e.e_id$$

DROP PROCEDURE IF EXISTS `sum_of_bill_endorsement`$$
CREATE DEFINER=`ahmad.salman`@`localhost` PROCEDURE `sum_of_bill_endorsement` (IN `reservation_status` ENUM('approved','pending','rejected'))  NO SQL
SELECT sum_of_bills, e.e_id as employee_id, e.name, e.lastname, e.email, e.salary, e.position from (SELECT
    e_id,
	IFNULL(SUM(sum_of_bills),
        0) AS sum_of_bills
FROM
    (
    SELECT
        e.e_id,
        IFNULL(SUM(`r`.`bill`),
        0) AS sum_of_bills,
        'reservation' AS TYPE
    FROM
        employee AS e
    LEFT JOIN reservation r ON
        r.e_id = e.e_id AND r.status = reservation_status
    GROUP BY
        e.e_id
    UNION
SELECT
    e.e_id,
    IFNULL(SUM(`b`.`bill`),
    0) AS sum_of_bills,
    'bill' AS TYPE
FROM
    employee AS e
LEFT JOIN booking b ON
    b.e_id = e.e_id AND b.status = reservation_status
GROUP BY
    e.e_id
) AS union_table
GROUP BY
    union_table.e_id ) the_list left join employee e on the_list.e_id = e.e_id
    order by sum_of_bills DESC$$

DROP PROCEDURE IF EXISTS `test_sum_of_bill_endorsement`$$
CREATE DEFINER=`ahmad.salman`@`localhost` PROCEDURE `test_sum_of_bill_endorsement` (IN `reservation_status` ENUM('approved','pending','rejected'))  SELECT
    e_id,
	IFNULL(SUM(sum_of_bills),
        0) AS sum_of_bills
FROM
    (
    SELECT
        e.e_id,
        IFNULL(SUM(`r`.`bill`),
        0) AS sum_of_bills,
        'reservation' AS TYPE
    FROM
        employee AS e
    LEFT JOIN reservation r ON
        r.e_id = e.e_id AND r.status = reservation_status
    GROUP BY
        e.e_id
    UNION
SELECT
    e.e_id,
    IFNULL(SUM(`b`.`bill`),
    0) AS sum_of_bills,
    'bill' AS TYPE
FROM
    employee AS e
LEFT JOIN booking b ON
    b.e_id = e.e_id AND b.status = reservation_status
GROUP BY
    e.e_id
) AS union_table
GROUP BY
    union_table.e_id$$

DROP PROCEDURE IF EXISTS `tour_participant_depart_city`$$
CREATE DEFINER=`ahmad.salman`@`localhost` PROCEDURE `tour_participant_depart_city` ()  NO SQL
select stats.city as `Flight Depart City`, number_of_participants_from_that_city,
    stats.ts_id, t.place as `Tour Place`, t.type `Tour Name`, ts.start_date as `Tour Start Date`, ts.end_date as `Tour End Date`
    from (
    SELECT
    a.city,
    r.ts_id,
    COUNT(*) AS number_of_participants_from_that_city
FROM
    flight_reservation fr
NATURAL JOIN flight f LEFT JOIN airport a ON
    f.dept_airport = a.airport_code
LEFT JOIN reservation r ON
    r.c_id = fr.c_id
GROUP BY
    a.city,
    r.ts_id
    ) stats left join tour_section ts on stats.ts_id = ts.ts_id
    left join tour t on ts.ts_id = t.t_id
    
ORDER BY
    number_of_participants_from_that_city
DESC$$

DELIMITER ;

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
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`a_id`, `name`, `location`, `date`, `start_time`, `end_time`) VALUES
(1, 'act1', 'place1', '2021-12-31', '02:00:00', '03:00:00'),
(3, 'act2', 'place2', '2021-12-15', '03:30:00', '04:00:00'),
(4, 'act3', 'place3', '2022-01-04', '00:00:10', '00:00:12'),
(5, 'act1', 'place1', '2021-12-31', '02:00:00', '03:00:00'),
(6, 'extra Activity', 'some place', '2021-12-30', '15:40:28', '18:48:45'),
(8, 'swimming party', 'antalya', '2021-12-21', '23:43:00', '23:46:00'),
(9, 'extra activity2', 'place 2', '2022-01-03', '15:54:33', '19:54:33'),
(10, 'section4eklemedenemesi', 'bilkent', '2021-12-21', '20:01:00', '21:06:00'),
(11, '', '', '0000-00-00', '00:00:00', '00:00:00'),
(12, '', '', '0000-00-00', '00:00:00', '00:00:00'),
(13, '', '', '0000-00-00', '00:00:00', '00:00:00');

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

--
-- Dumping data for table `airport`
--

INSERT INTO `airport` (`airport_code`, `name`, `city`, `country`) VALUES
('101', 'Esenboga Airport', 'Ankara', 'Turkey'),
('102', 'Istanbul Airport', 'Istanbul', 'Turkey');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

DROP TABLE IF EXISTS `booking`;
CREATE TABLE `booking` (
  `b_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `r_id` int(11) NOT NULL,
  `e_id` int(11) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `type` varchar(255) COLLATE utf16_turkish_ci NOT NULL,
  `status` enum('approved','pending','rejected') COLLATE utf16_turkish_ci NOT NULL,
  `reason` varchar(500) COLLATE utf16_turkish_ci DEFAULT NULL,
  `bill` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`b_id`, `c_id`, `r_id`, `e_id`, `start_date`, `end_date`, `type`, `status`, `reason`, `bill`) VALUES
(19, 1, 1, NULL, '2022-11-30', '2022-12-31', 'online', 'pending', 'sevmedim', '0.00'),
(31, 26, 2, 13, '2024-09-30', '2025-10-30', 'facetoface', 'approved', 'reservation was made by an employee', '0.00');

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

--
-- Dumping data for table `customer_review`
--

INSERT INTO `customer_review` (`cr_id`, `tour_rate`, `tour_comment`, `guide_rate`, `guide_comment`, `c_id`, `ts_id`) VALUES
(3, 5, 'fgs', 4, 'fsghgfs', 28, 3),
(4, 5, 'hd', 3, 'dghgdh', 28, 3),
(5, 4, 'tour was good', 5, 'guide was awesome', 28, 3),
(6, 1, 'hdg', 1, 'hdg', 28, 3),
(7, 4, 'very nice tour', 5, 'not very nice tour guide', 28, 9),
(8, 3, 'sdfgh', 5, 'dfghjk', 28, 9),
(9, 1, 'dfghj', 1, 'dfghjk', 28, 9),
(10, 2, 'sdfghj', 3, 'sdsfrtyjui', 28, 1);

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
(11, 'a', 'a', 'a@a', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '2021-12-22', NULL, NULL),
(12, 'employee', 'hello', 'emp@gmail.com', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '2021-11-29', NULL, NULL),
(13, 'employee1', 'bey', 'employee1@employee1', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '2000-01-12', NULL, NULL);

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

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`f_id`, `capacity`, `ticket_price`, `dept_airport`, `dest_airport`, `dept_date`, `arrive_date`) VALUES
(1, 120, 200, '101', '102', '2022-01-18', '2022-01-18'),
(2, 95, 280, '102', '101', '2022-01-10', '2022-01-10');

-- --------------------------------------------------------

--
-- Stand-in structure for view `flight_capacity`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `flight_capacity`;
CREATE TABLE `flight_capacity` (
`f_id` int(11)
,`max_capacity` int(11)
,`number_of_reserved_seats` decimal(32,0)
,`available_seats` decimal(33,0)
);

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
  `date` date NOT NULL,
  `bill` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

--
-- Dumping data for table `flight_reservation`
--

INSERT INTO `flight_reservation` (`fr_id`, `f_id`, `c_id`, `number_of_passengers`, `date`, `bill`) VALUES
(21, 2, 27, 10, '2022-01-10', '2800.00'),
(22, 1, 27, 7, '2022-01-10', '1960.00'),
(23, 2, 27, 78, '2022-01-10', '21840.00'),
(24, 2, 28, 10, '2022-01-10', '2800.00'),
(25, 1, 28, 7, '2022-01-10', '1960.00');

-- --------------------------------------------------------

--
-- Table structure for table `guides`
--

DROP TABLE IF EXISTS `guides`;
CREATE TABLE `guides` (
  `tg_id` int(11) NOT NULL,
  `ts_id` int(11) NOT NULL,
  `e_id` int(11) NOT NULL,
  `status` enum('approved','rejected','pending') COLLATE utf16_turkish_ci NOT NULL,
  `reason` varchar(1023) COLLATE utf16_turkish_ci NOT NULL DEFAULT 'I would prefer not to state the reason'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

--
-- Dumping data for table `guides`
--

INSERT INTO `guides` (`tg_id`, `ts_id`, `e_id`, `status`, `reason`) VALUES
(13, 1, 11, 'approved', 'I would prefer not to state the reason'),
(13, 9, 11, 'approved', 'I would prefer not to state the reason'),
(14, 3, 11, 'approved', 'I would prefer not to state the reason'),
(14, 4, 11, 'approved', 'no reason is stated'),
(14, 9, 11, 'rejected', 'Can sÄ±kÄ±ntÄ±sÄ± be kurban!');

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
  `address` varchar(100) COLLATE utf16_turkish_ci DEFAULT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

--
-- Dumping data for table `hotel`
--

INSERT INTO `hotel` (`h_id`, `phone`, `name`, `city`, `address`, `rating`) VALUES
(1, 1111, 'hotel1', 'city1', 'some place', 3),
(2, 53600003, 'Blue Hotel', 'New York', '5th Avenue', 5),
(3, 5445123, 'hoteldeneme', 'izmir', 'alsancak', 2);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE `reservation` (
  `res_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `ts_id` int(11) NOT NULL,
  `e_id` int(11) DEFAULT NULL,
  `number` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf16_turkish_ci NOT NULL,
  `isRated` varchar(3) COLLATE utf16_turkish_ci DEFAULT NULL,
  `reason` varchar(500) COLLATE utf16_turkish_ci DEFAULT NULL,
  `bill` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`res_id`, `c_id`, `ts_id`, `e_id`, `number`, `status`, `isRated`, `reason`, `bill`) VALUES
(47, 28, 9, 12, 6, 'approved', 'yes', NULL, '150.00'),
(53, 28, 7, NULL, 6, 'pending', 'yes', 'hadi orada', '150.00'),
(54, 26, 4, NULL, 6, 'pending', 'yes', 'sevmedimseni', '150.00'),
(59, 27, 9, 12, 6, 'approved', 'yes', NULL, '1200.00');

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
  `type` varchar(255) COLLATE utf16_turkish_ci NOT NULL,
  `r_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`h_id`, `price`, `capacity`, `type`, `r_id`) VALUES
(1, 111, 3, 'King', 1),
(1, 123, 6, 'Suite', 2),
(1, 250, 1, 'Single Room', 3),
(2, 432, 2, 'Emperor Room', 4),
(1, 99, 14, 'suit', 6);

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
  `wallet` decimal(15,2) NOT NULL DEFAULT '0.00',
  `birthday` date NOT NULL,
  `profile_picture` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

--
-- Dumping data for table `thecustomer`
--

INSERT INTO `thecustomer` (`c_id`, `name`, `lastname`, `email`, `password_hash`, `wallet`, `birthday`, `profile_picture`) VALUES
(1, '1', '1', '1@1', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '0.00', '2002-05-04', NULL),
(26, 'Mehmet', 'Kck', 'a@a', 'ca978112ca1bbdcafac231b39a23dc4da786eff8147c4e72b9807785afee48bb', '0.00', '2021-12-09', NULL),
(27, 'a', 'a', 'v@a', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '9983400.00', '2021-12-09', NULL),
(28, 'Guven', 'Gergerli', '123@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '125944.35', '2000-03-13', 0x52494646901c00005745425056503820841c000030c2009d012a580258023e5128914623a2a1a125f39820700a09696efc7c996ec01ea5ebe54dd049f90ffc27819fccffb17f62fdbdfee3ee2f8e2f42fb8bc8afcfbfb1f33bf8d7d9efd3ff65fddbfcd0f93ff597c55f94dfe5fda8fc817e3bfcaffcbfe5cfa1dec83001f54bfd67dd4fa36ea53e0dff9ffdd7f127ec03f5cbfe7f1a67e2bfe67eba7c00fe83ffcdecd7fd4fff1ff51e80ff44ff3dffcbfd5fc06ff38fef3ff6ffbdf69bf49b100807a198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc21984330865373c16a2c103b2085b6d285638b9290cc2198433086610cc219842b7daffff83fdfc7fa313627d8eaa41429c825bb1d6745230008db3f567eacfd59fab3f565f40282d7ddf5379f15658ce2707e9d2e5cba969bfa053ee78f66fcde06000aca98326e6ac2a4b926133086610cc2198432fdf6e97a5f268d43820211fffd54437f1ffbeeac75a59984df85d65595db6d8fbc491d884d050443c424a65fccbf997f32c289c83f3981922b33f9727ff0258be0bdc533f2f8da5268ed157cc3902991e45e13fb6aacfd59fab3f5478e52e4ea8fb3321ddfd1b6872bad336d86db0d8cb544cd5bc0a68d43c17ccce7fb046db0db61b66970b915cb7ecf51546e03fa5a42299b1f178e47ff96f1353af203507d3f099937dffcefbb66b6442f03cbd26d5812ae559fab3f565f404e3bd354431c2778ca11749cbff9c3ef9a23683fad326193650829006741f610b0328729b9c048ad6fb864edd1d6ae74bffab3f38be885e68315761b34f63eda299b2040621eea90f08665f71547c950e9970dc5590ca3fea3acd2992e24bf997f06d27e2b4e100f16aa48e0f062be695d6ff8ac2cbf97f1765f66d30e1b0c171c231299ad5ed4160d446e99b6bd0a96594928e6c01e5ffd5236a8c76998434d974f324357997cf9a197e7ee0617066f714cb1b072dfd1714e9aa17a1983d604df610cc1ebc3af0d723cf51c05018c4b76d0ef1e278c596bd7d2bff45f4322d5cd6f0db37a3ddf9263fb8a658d69129c3bdc52fd47f491e8ef7009a8d0cc1e9bfd8dabacdf2bf2ffeaca9ba9a2cc083f2f660f5c301e71ce77eb4610ca16b0240de55c7a8bc21fb0aa8befe12bbbf997f2f9657f6d0c7be8eb98b66ce83e0b9d8fb91b4cdb5e79ee7970f8cb65fcbfa58aaaa6fcff567eacaac8ddc0b1f33f8168c2003ffbb237650ff677da8c74bffab2c7f708eaf2386daf2bc3a1f0295c9d336d86db0e492ffeacfd5210d97f44aafdc52feb63dcbeab3aa9b61b6c2ebc8ea27e364a850e8d67aeec2f8bcf963a73d7e10f43307a93e239570a42cb4cdb3507385d08066aadf8936f0ba11257fff6617ff3012b241661ba4fed8566fda0ae4c09306432fe4da1ace1224af012f8cbf97ff69b71ab2165eb10c7de861f03713b7a8d21e1100f42bd8b4781eec2014945fd2dda096f8239e0009b8c5802b8c7f28d9f411e5b4e4afe4ba418b76201e866112d5121915c68d17e8e5ae6e1d46d69b054c13d0cc1eb92668b096752e57da0a1d192db97686610cc21983d1f27eee1be5f2d484e1c0770eddb0132fe65fc14fced483597d25c28083156011dfb8a65fccbf99620c131aa14f83c90c4819981963876436d86db0d9087e381a2860c19ee89eacc050cc21984330859694011d668603c82339511c065db0db61b6bc2a1775ba06f045a5a14665c82b20807a1984330857c804f82140d48eed63ef7170b97130ce164dc62cbf97e92111f046dc14162d289230931d2b9021b4cdb61b6c36cc512ebc295a4c7ee0e236acca16dee2997f32fe5faa689dc37428b8b2fe65fccbf997fc168919cff8ea9462a84403d0cc21983d1de4147dd1c775b23d0cc2198432fddfb75fa9f2bed0ba532fe65fccbf997cd49509f2cc94aa5c36d86db0d8e7173db5ee02cf18d246fccbf997f32fe65fcbfb18e3d748a5fa91fa05da66daf271363f3f9e226e14ed63b3f567eacfd59fab3f567e7df8e238835955d00f20286b700c368fbe30b4e2f169520fc440b490f911b79684403d0cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc21984330864e0000fefb180000000cbf140f24074d9c73ac044815b92da22dcb15070c47f1a405496a68b76c8ccecdbb76a65f77f106f21dab2390f78db3be084d1d658d2c17924790cd5374634ed567ec588165a4d912a254fb72e393c5d0a8b025a5e12a4739d9dd68daff27b9b1953951d46a857eed00e6b1b88a5154069cd08d423b8dc75c86ab1842bf42d29f0901c88ec22cd229acc15235f82e3a821384dcdf506b72ac9c1dc3a264bf3ee01071150eaad3a150221a605ff19778efe6b2b51018cfe86cf2bcb3b54368d3fe5d45f57f5af6de2e083c2f8b40f59fcdb2469d8ce93c6cbbc7b418cc29c3416e052709dfeaa80a40c7b06843c45097ba44dd49fd5c876208f440d588fba55644faa8302a7293fda0c7016ae97a05d46a7f9ff210a59d4a7fa0deaa6860a9239a5a5a2ab0035af08d210ff9d342a2d5a53b3227a5fa76407132f169aafde14c7c3c565e56b41521960d1e6f07dd8dd09afd2da470a870643508dec5db39561606c3fde2719a2ef036e25f17a88761b60188fd009ddf9ee373ec1ab96e037f32f427e004a988f63a0a177553ebe1ce9615e3dc495bc7b463efb06fccbafa3b105160076e7ca76694ad6ea6d802e3f36dadb0f2ed4a264b7fc7035e168e8c80c8c0d756cb8a0c1ca2576deb322f0289b7641c6bc1864543fb3d37d51959d20cb7959ad4a0545d152946cb4a92593ea7d470e5aad48c00bff7fe660ba890d2a278a8328c3cd59091945efa94966b411fd3bcdc79e989296d5f87cb6dfdbb12aa95aad6a5c07fc4381c72f72a8519431ef98cd4f227fde9b1169ce088826c0bcdfad22630214513726c4891da207516cae5e14da998dfac7fae1f1921b49191659ce1b1cdfb05147888d08d351d4cdf42ceba0bb3d5867d5f3911f2129507a3e708048b8c41a3be242cacfc53d73f6b95734f79470130f568bef92d898e4a53479a78c51eddbf0cd09ead6a3b81d49a8c8d3bd74acb9f7482b15b35691c4c2ebbb6f8c8f8c0b2ec3d10618e79d0ce516961590d5fc3e74aeec0001d9c00098111376887944b3982b595bf62d887bc55327d70d6909371367643a79d19e2a16a498c88c79d9ec5884b7877868818416fc03534edac3609dbbbb8b6a25129a67f0bd95ac074c259aa0e8d2f329f4dacfd37f8c7bc142a43a73a0e17a0d0d92e42b7886204c7f6c02454a80a3625eea74f67219c5c4d192f6215bdc48c97414a1a7ecd8ab881ff8653ea4c47aa03440ca4cdcd2a05dcc67aa4ebbd6109aae01a4dbf56424eab1e02f7e861164df999a52d8a9825bde9fb764d1f54419ec4d956a811b20d72f9479e957df42db56ccc4841708e9d052699fd7a37ece67f66ce739f67e7360d12d8a874119d5e5b355bebd91519f873933e968aad53d88d4ec46f6b4cd5d68192001d181ed885cf849afa194043edae2b6191d5d937133dfd9a3adedc8bb8d1b2f8f1c64eaa3320a3dbc5aa91923d3b4996feb10e5462f9c985c95558127bb9c7d2dbbc8012ff711c21e28cc76959069516410c6df3ef023d7518ee52857f3fe6a13de1605218de0d98f87cfce62f5453db81f95fbd92c9a16298a6d6623fa6688014292ad533acd2dd3d7497fda0ec30bfb82593e02bccf90e0779f5606d2c11fd866a834b079c3ac4fcd5cb43800f3bb66c4750cbc669d087eb8f4a8387a5f893b9469dbb071c741537360082f2b202c176f60a69190ab3ef98e1c2be59f4e3f3963ddeda044713d0f79ebe7ce53286c3f8396ee969e2f068ab78ef9991bd966388d81cdea87dd206909eb011fa74ea1196fe6d0ca5bfcab7902cf8547d9ca03de40420c4033669a58fbff24dbe41c2cdb5a408907e0ff2be41177ac55bdcbaaba14b317b99699c72842dbf915db0b4c160c8888f46cd5eb6f77eb7d895a225c8cc4270c256318a5d9e13bb8d061f76953e0597e27613454f5758911b41234e5608cd21aabc440838b58a47545b003fb50d88f2e9cf092dc9a6582576440b7f704714239e1a1049a96935aaa8f21ef86157a4e214dd2a696d000ec008e3f963cda75199785c483b43b4b5222482371821479d501363c4d198ee8a96b914be86d4a9ab9a343d64e2e787b4974803538fc6a5e994aa35552651d0c887049bc367189499241345780e9f39470f91fa5b74b94414ffe70d7e6cb0d2dcc2e3fbe6385e2d1ae77ce9f16834a10554a2dd899e68ac7755523eb5f5fdac733e825fa9d676ac49588c15602a99ca6c23ef09aa0fa3ff3aa0ccfde08c5d73ffd14de06457dbb1995a22ca68b8dfd2b91c070d60957b39ca06cb87a73e6ea919f130c6d433e268c6049a9f9ba5ee142a9b3513b7a00855f0f0100e7d467528955f9a4c6025e0e73c8fbb795fd6c35779ab3db842825e5239f374b02a1a119163e35b89a32fe235d3b922e8eb3cd5c9d359ace5d8e5a5ca8b320e3e2b644ae21811a5f07526fb94a75e6694f068e329dbac1acd8a43f9627fbd214511112db0f9112e9337f036328a713116724abe0e4aceed16ab0cf6cd6862a82b720b4c6f63e99bda6f0089ef83df0235da23e2e73b996c93eb3c88e9ec60cb4c6d942d84bc0ccda3e392aecc0608fab234c7422ae64a165a85e3e54f332de3c1d092497419c8ffc5dec4d1d22d1eccecf62ff5cd14a3976f10bfc1aafff8311ef647e01327348cbe4fbd27a3c3851c3cab0a6d701b21e52319720b124590aef07efe20ffcaef7e0100ddd7e7274fa9d30b2696320d1b4ca9905fb32dfdc10bffdf42e0ee15e05f0edf3be5d0b8f96059bc9bfb8460bf5316142fee471ca535b5294781afb1d54618ad12750b9422bcd30e4de260bc19ee7800a549d0ecb2e0907559075d9e0c4d0fab445199e5e67c352eca050dc8a61414e5cb08063b47d1f994e5fb47ce7747ef4fb371f28acf2b03b513a168a9da25b305bdb89f98f6a9ff54dc842b7176a998d04bf30cbfc5af9d4d306f96862ca5e22088e9ac7c2c49e9218d5242d96e6e9202849a6fb3b9a3831b85731da918111e80025b6383724964265d52bcd4e17fdbb8537c22b0ac04cb052829f93b031a979e4e0501e2c1fbddfe011e5aad4ca22f3c1cb31069f65f379a8398f05666ba1f6264d6a3638485827b03631c0edcaad525581689941bd815a234f6c7259fabc1a863769815f299bee2f6093a4c654470ac90bb53a9b8929e4660ce013f174dd4ab54c9ded08fb800189fe21a8bcbacff4fe2983ccde1d046936c436a569ed2eb3d34d10e55197bf8dad4dbcc56d40279164abeb66f52e5fff0a845257e967c69df3beb6271481d9eef535c8f2d7097fb47aa4f4bbd7e9a27b5855e03b61d67ad69d585c14647f8bacd04ceb988ef4971b611cb25e932f81c619d2f7a42b8d5316b176acdad2b47e678079da85788a22df771db078f480f2d21c8f0ec443f41921e5c1c3ff2e96440b6bf1bb441cd8fff6e0666c1254d7d0adfecf97315b54f399f9a32d77b94aee926b576f10cab78de2eb15993dbc2f9e6ea23c3445c1613f51f8044d21447d169493c242b7e04339a0a670561441ad0ded1e18424a659eb1b6c799c2d60b4d6868b4754a51d7cbc5db24078183604c47a915c06ad183a86642f7fdb94dd8629e88acba6b16d8c37ceadcff2493072389d902b33e6911ce4026801008c2c943a2e63b5c4891d86170bac8769ea4c25bd9ba67d40b9f6cc43c98e7fb9aa6dd7581162730a43e821cbe9a22da368c95be15d9f53a1530c0c6950fe602fa4131181a2dd6a6920cc21c3ae904bbde3f13903aa409cc67701c2e5d73711fd57ccdfc40bcc53f54b344c6239949dcc1e00b4d955a89e74ce3c469531b9fea2407c1ece3808234a18e181c75befae7d1c4cd7c9d9708848e1af7933118e133d609b9a599f6a4c8eea8cd817d67f38fb191a5d1bb794800de6011a2e83480d3001c06d8214b0960733df4c552970891ceb70e11c9df6c9481393735348023b5f1c484c74b6253b2f6e1fface33826bd2849e53c6ea2f4da56f82cc39e2897f69b305977c2889299c47ec3881247e36e43c838ee1ae6d7c183ad9dd0902bf2c6e55d277ae011652cb44fb736ada7d830d844a02327f5705146a850ce78ad1d09f4bd6ca7165ff6b07f8d6356a5f689e9399e19ad35b7b49f1cd7254164f4d1f48948878f1677ae00a90340a900bdbe4d17f8809d2774692881953683df806e5dd953e96a913ee8e6dff1a33eceba6ca35872f02af1eed1efa572adc0cbe09db85924aee868b64c3f49f1dc4f75fed3e8e86689fb3fd2ef16bd4c70d31e8bcf5e0f3272dc4efafc6ace7d9e0e1e13076defefcdc4e89d9688e89fc294e19f390a5689b277918e035ebbba49e8c09285dc74faab309845f8a84b255b95fa1a5d158f5cd82b1f215ca88e167cf176b0a4fa0fb6f079b61b79e63781673f589308ea38049c663e0feb8f626fb6f7e383c3496b42fb313050b006ab137341f6e3bfc00d8fae56b93e525a3c2d7e4383ceef69496b6829a98e71b3ecf92ad11d8e89dcc2d2805a22aadac0d0d52dcf5dbcda1966aa6a30966732c05286f8a857b80484521ad0292b3df6388bcb6eb3ff0aaede69e9ed64a02cdff3ff7b08df67d18895c09ced3208b12a9b78e065406a867e6f14e144ca30304678d3d91c865b054f540ca70d0abd2ec6d62480fedf03fb9b645da0252f58912a0f3561066fa7d3c8b8b4fc3e170f6030f479f87c27d356bd43c84ff046721f5c20bcf1cc43ccf2c1eb9ee2eb41810d1bbec81f64f1a24fd8303bd6689a2ccbaddbbc8c026132b3b1e4f4a7b62e244da794fab2d8e8da415a6d4aca7cb9a4820e9f09c4d88c147a95f627507cf52e491ddaa7ba549464372b3973c7a69ced2aa909e76ff3268047fdf83b5e2670e112b18b106780761138f5a63d9e8d133710a29adce57e65583991212b8b32c209b4ca2097e1676cdfc087fb90adb5e7adf5343106b6b8096b4cbfb7a97697f7a906bb543f8ab2d4e53ee8291632e15bf30fd4f757eb88f2d66a268406acaeddf827507b4133693737c11440688ce01947ac2bcd112ab88c352fd77eb6af41483e09a28d7e1ea0b5cb9d7f190d6e5b23fdcfa3ceb51bccd7cf247fab140c04926d84f532c74fcbc9795ad05485c70d5a304d03f656ea194d83a8ba04650a2b99b3ea7f555dc8b4c94ae529f7baeab44cd60048a0927b2c16a3537b9365cd511a715fa2a252064f5faca42b686bed4ceea180405d9efdcd418c976b16b008bfa0ea3001d03cf3dcc82e28ea434079e19c576ff3bf9160e878aac1ef5ec6b299657cfe0b36505e34fe3d96bb13485f5955a1baf0c13452e4b542ccf6377a35ab0ee8e61fa6158d6e44f13e68fb019b0db630379f3c3cd7a4ed8d12f5438d39c8bc4e84d0997df8a78438ae23d555bb19781a178e9f33ebd4e0285d1efa510e6259ea318f413f59b39e68c24928825c34aa8e33eeb3aaa42c078e14e6636608a32e071151a7dbd258346e0ba3192924179d166b363b6409d6b12a13d3a01900b9230edf4221b670b2c23cbe9fce7bae8ddc350e0a1f0914e0f88c1374f5e40c74a599afb7b34e3e175d263e264b16723e09661a3edf7a43f11ff4a7e83c30a99d8ff7074c1810611a20f4a0dfc07209560b32df34ff525e6db362b53389608dc0bda2d113c79450f88612d1269a3e2b08e58f45ab0b2e08e675c4285f89eee32c616c95e7e47d7c04f5cbb44ab2456c13478ddb56df13b592df77a73656c076f2311c0989374f6ce7e561b9f225362aa7514cd2f72ed0e5cf8fc6073799809ddef46731f738aaae06985bb97a5ba3eb62f6c2d441f710de6000a2c3b33fe3d869ebcd2aa1dea370ac9513fb4e64787ee17cb944ecc2421287c92df0432300800fe7903e38d8bf76a14bf16d67a9747dffb6a7b0564d924aacd9ccbe83ab28e57dc0b98a4bcccda581e5f17c10404af0cefefb4a84da6427809b5091cfa7bb3178b6cd0f7db2fe8beee3d03d9de95ff2b916784c8a8c199d6c02322c4ce27932de619b0bc6cd243617a8df0078393c4a3c45d198c2635d449ad989281a1a4ead4d15c6b05aa7dab271cb6cf2206e38b9f435e205bcb6dda02dd3cc20413c5d208de8968eadee55589c3fbd4ccbd423919aaf08e6ae92e5a83a4c0e252908168177a1a0d6f2a50c2159fa7bb8b0f46f992c82f20e202dbeb595cf0d1c4f47ef7110e88847fce5ea9513b4e52e3900f260f78fb2ec9948bc81058e067898aa3b0d4a99fc03008ba011a5e65492bfd10935529cb3a841b82249fc2a4a274945a371f52881c05c6387dfc58b879eaaa17ebef42613744171d53d1559fcc1a63b513aa4836c1a7f84c341665817f9c227face16fa7617723449be620d1720a250ca67693ca874d185126472792b90b04ec2f4925d066ae7d9a8cf7a3d7c999f31be217f0e4db53e327b4aeecd92928f7eea98225fa981f7cd6b8f8ccaf7cec93d54d1ede7954c2369edd6ba655880c28a6946b88a3f2690c308ad0e67bbf219c48cfcad626bc82d3f92c2e3da6da98873d4310ca076b582d7bc72200cc81e80101ddc1ef48cd276a25b9596088b2fab0b582b5539193906bd419a65094fe51e9fb8a9b5e0a58d326a0cf6ba85a842abfcaeb42127c55fb774ab506ff14c3856bf55767196f06a27633845c947bb100055651fe5082cdab2ff8cd74128b95c6d30af454411bc9d22d363f743a2779a90a487b8dfa354c97716133484df5981e17aaed5780bc9358b484c9088e3528d48c3e3dfd5e9eb18a173d7801fd4897a669f38e2bea04792322e6075ac7bd2aa2041c6e236cd0e31cf97125b0d03d2fce8da5c96ccd49dd046f707ee28c1b47d634e8734a5e8e3b7f0bf2b52babc81f05226bdeda932a026a1e9af5643042a1dd3702482481dfa8b60033b55ad521f2c8de6884295467e4d303bb907a13eb1b9be1aa185ea19a3815af473b9b235f90fd1c26e13c8d357e3e4fa6324d7bd29fa9cc362f8f5f95aebd77a47730901445d3498861c7ea88122c9ece79b4660aa669e6e2be14f224fc5a03756d9e435548eaad8f237bb2b7416fbfb6828cf924a876b5436f563ffea1bf611beb23063e94b06546cff90df0438ba889bdce90cfda0c25906ac0f478791a5a7608fa2f8f012a1f1e9ddcf3aa52ccf85d2d94fc19b6e1e730579925deb618be7e308052aa17d233e353dc8cdcccea8d952d6a0a693775c03126d0e33748fd37f314d7731cbcc0e79a90ab3b5107b4c28a9b000e18e5dfdf134a706bc02624518018e680dd3dd7086f69966adb3ed7ef6b585ef576c481868c8f86ef7148e5b14270e541f8315916e9f4dc7936ccb16f431148e37f3ed9b52d2fc162687447bb69dd4b1cd7a4c87b696343be946f1d12688680406d4eb6abec470d8dd0790423a75294f707c700becb99e2354a7a5e60992f44927eca42346f237fc62c4bbff5b213f05618ff87bbd80d4d8aaf9dca899a4cf40821cd4caa6bfbb5865591d2e7978143edbae3c72fb99bab86632126bfb91c6269ced0c38c63836f3e1b1ad9d2b0a2819c583b5980dedeb24eb3d4445ec324d88e1d86375cf1784ec374a46784c0f71d5987d919eae2160017dd5705cb54ffb72817c00256b6abee6580218c0d15cc00ac0dbf49db2cbf6bdb9c1bacc612b255787d23fac3189415f7858c5e3ea91778582d15df5d530ca6860963fd2162acada0a98f05a11994fa6f25267a86e88e0f65c4f01bf44b2f06e53056ce60354fd55eb1751a93d08d90fdba687eeb259b336ec5f8b1245b01cb8d47f90c3f4f9ebc5a0002c630a5e6dfb7442e7672d7220759d8fa5b1e1fc78d207f46233669352a5ff39ccd628c279c80c83e63d5fd31370865a2c0d31d9cad2e8a84677c34dfa289128ff4470294cdeb967c1dfad0f4f315e7621b61d70fc79938f92627c96c5b2c98ecde099db80a58070bfbe57caf19168ba72705a8f2b458e5c614d162d981ee2f5d3b319d57fb7f5fddecde5ffd5a7321280c0a05a3e838558570737606fe94a0666388341b69bd8528f79ef230be94ff7a7362ff345588eeaea85b081d86610eb8e7ffc68d501513e63548d7c1334a800f375c9041faa311111cf21597000000000000),
(29, 'Muhammed', 'Küçükaslan', 'm@c', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '999999999.00', '2021-12-09', NULL);

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
(3, 'place2', 'another tour name'),
(4, '123123', '12'),
(5, 'ankara', 'mytourMustafa'),
(6, 'ankara', 'mytourMustafa'),
(7, 'ankara', 'mytourMustafa'),
(8, 'ankara', 'mytourMustafa'),
(9, 'ankara', 'mytourMustafadene'),
(10, 'istanbul', 'mytourMustafadenemelerdedenemeler'),
(11, 'izmir', 'mustafababatour'),
(12, 'Hata', 'Deneme'),
(13, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tour_activity`
--

DROP TABLE IF EXISTS `tour_activity`;
CREATE TABLE `tour_activity` (
  `ts_id` int(11) NOT NULL,
  `a_id` int(11) NOT NULL,
  `type` enum('extra','basic') COLLATE utf16_turkish_ci NOT NULL DEFAULT 'basic',
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

--
-- Dumping data for table `tour_activity`
--

INSERT INTO `tour_activity` (`ts_id`, `a_id`, `type`, `cost`) VALUES
(1, 4, 'extra', '13.50'),
(1, 5, 'basic', '0.00'),
(1, 6, 'basic', '0.00'),
(3, 1, 'basic', '0.00'),
(3, 4, 'basic', '0.00'),
(3, 5, 'extra', '0.00'),
(3, 6, 'basic', '0.00'),
(3, 9, 'extra', '12.50'),
(4, 10, 'basic', '0.00'),
(4, 13, '', '0.00'),
(9, 1, 'basic', '0.00'),
(9, 3, 'basic', '0.00'),
(9, 4, 'basic', '0.00'),
(9, 8, 'basic', '0.00'),
(9, 11, '', '0.00'),
(9, 12, '', '0.00');

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
(13, 'ahmet', 'salman', 'a@a', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '2021-12-09', '2021-12-11 14:04:42', 0x52494646901c00005745425056503820841c000030c2009d012a580258023e5128914623a2a1a125f39820700a09696efc7c996ec01ea5ebe54dd049f90ffc27819fccffb17f62fdbdfee3ee2f8e2f42fb8bc8afcfbfb1f33bf8d7d9efd3ff65fddbfcd0f93ff597c55f94dfe5fda8fc817e3bfcaffcbfe5cfa1dec83001f54bfd67dd4fa36ea53e0dff9ffdd7f127ec03f5cbfe7f1a67e2bfe67eba7c00fe83ffcdecd7fd4fff1ff51e80ff44ff3dffcbfd5fc06ff38fef3ff6ffbdf69bf49b100807a198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc21984330865373c16a2c103b2085b6d285638b9290cc2198433086610cc219842b7daffff83fdfc7fa313627d8eaa41429c825bb1d6745230008db3f567eacfd59fab3f565f40282d7ddf5379f15658ce2707e9d2e5cba969bfa053ee78f66fcde06000aca98326e6ac2a4b926133086610cc2198432fdf6e97a5f268d43820211fffd54437f1ffbeeac75a59984df85d65595db6d8fbc491d884d050443c424a65fccbf997f32c289c83f3981922b33f9727ff0258be0bdc533f2f8da5268ed157cc3902991e45e13fb6aacfd59fab3f5478e52e4ea8fb3321ddfd1b6872bad336d86db0d8cb544cd5bc0a68d43c17ccce7fb046db0db61b66970b915cb7ecf51546e03fa5a42299b1f178e47ff96f1353af203507d3f099937dffcefbb66b6442f03cbd26d5812ae559fab3f565f404e3bd354431c2778ca11749cbff9c3ef9a23683fad326193650829006741f610b0328729b9c048ad6fb864edd1d6ae74bffab3f38be885e68315761b34f63eda299b2040621eea90f08665f71547c950e9970dc5590ca3fea3acd2992e24bf997f06d27e2b4e100f16aa48e0f062be695d6ff8ac2cbf97f1765f66d30e1b0c171c231299ad5ed4160d446e99b6bd0a96594928e6c01e5ffd5236a8c76998434d974f324357997cf9a197e7ee0617066f714cb1b072dfd1714e9aa17a1983d604df610cc1ebc3af0d723cf51c05018c4b76d0ef1e278c596bd7d2bff45f4322d5cd6f0db37a3ddf9263fb8a658d69129c3bdc52fd47f491e8ef7009a8d0cc1e9bfd8dabacdf2bf2ffeaca9ba9a2cc083f2f660f5c301e71ce77eb4610ca16b0240de55c7a8bc21fb0aa8befe12bbbf997f2f9657f6d0c7be8eb98b66ce83e0b9d8fb91b4cdb5e79ee7970f8cb65fcbfa58aaaa6fcff567eacaac8ddc0b1f33f8168c2003ffbb237650ff677da8c74bffab2c7f708eaf2386daf2bc3a1f0295c9d336d86db0e492ffeacfd5210d97f44aafdc52feb63dcbeab3aa9b61b6c2ebc8ea27e364a850e8d67aeec2f8bcf963a73d7e10f43307a93e239570a42cb4cdb3507385d08066aadf8936f0ba11257fff6617ff3012b241661ba4fed8566fda0ae4c09306432fe4da1ace1224af012f8cbf97ff69b71ab2165eb10c7de861f03713b7a8d21e1100f42bd8b4781eec2014945fd2dda096f8239e0009b8c5802b8c7f28d9f411e5b4e4afe4ba418b76201e866112d5121915c68d17e8e5ae6e1d46d69b054c13d0cc1eb92668b096752e57da0a1d192db97686610cc21983d1f27eee1be5f2d484e1c0770eddb0132fe65fc14fced483597d25c28083156011dfb8a65fccbf99620c131aa14f83c90c4819981963876436d86db0d9087e381a2860c19ee89eacc050cc21984330859694011d668603c82339511c065db0db61b6bc2a1775ba06f045a5a14665c82b20807a1984330857c804f82140d48eed63ef7170b97130ce164dc62cbf97e92111f046dc14162d289230931d2b9021b4cdb61b6c36cc512ebc295a4c7ee0e236acca16dee2997f32fe5faa689dc37428b8b2fe65fccbf997fc168919cff8ea9462a84403d0cc21983d1de4147dd1c775b23d0cc2198432fddfb75fa9f2bed0ba532fe65fccbf997cd49509f2cc94aa5c36d86db0d8e7173db5ee02cf18d246fccbf997f32fe65fcbfb18e3d748a5fa91fa05da66daf271363f3f9e226e14ed63b3f567eacfd59fab3f567e7df8e238835955d00f20286b700c368fbe30b4e2f169520fc440b490f911b79684403d0cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc21984330864e0000fefb180000000cbf140f24074d9c73ac044815b92da22dcb15070c47f1a405496a68b76c8ccecdbb76a65f77f106f21dab2390f78db3be084d1d658d2c17924790cd5374634ed567ec588165a4d912a254fb72e393c5d0a8b025a5e12a4739d9dd68daff27b9b1953951d46a857eed00e6b1b88a5154069cd08d423b8dc75c86ab1842bf42d29f0901c88ec22cd229acc15235f82e3a821384dcdf506b72ac9c1dc3a264bf3ee01071150eaad3a150221a605ff19778efe6b2b51018cfe86cf2bcb3b54368d3fe5d45f57f5af6de2e083c2f8b40f59fcdb2469d8ce93c6cbbc7b418cc29c3416e052709dfeaa80a40c7b06843c45097ba44dd49fd5c876208f440d588fba55644faa8302a7293fda0c7016ae97a05d46a7f9ff210a59d4a7fa0deaa6860a9239a5a5a2ab0035af08d210ff9d342a2d5a53b3227a5fa76407132f169aafde14c7c3c565e56b41521960d1e6f07dd8dd09afd2da470a870643508dec5db39561606c3fde2719a2ef036e25f17a88761b60188fd009ddf9ee373ec1ab96e037f32f427e004a988f63a0a177553ebe1ce9615e3dc495bc7b463efb06fccbafa3b105160076e7ca76694ad6ea6d802e3f36dadb0f2ed4a264b7fc7035e168e8c80c8c0d756cb8a0c1ca2576deb322f0289b7641c6bc1864543fb3d37d51959d20cb7959ad4a0545d152946cb4a92593ea7d470e5aad48c00bff7fe660ba890d2a278a8328c3cd59091945efa94966b411fd3bcdc79e989296d5f87cb6dfdbb12aa95aad6a5c07fc4381c72f72a8519431ef98cd4f227fde9b1169ce088826c0bcdfad22630214513726c4891da207516cae5e14da998dfac7fae1f1921b49191659ce1b1cdfb05147888d08d351d4cdf42ceba0bb3d5867d5f3911f2129507a3e708048b8c41a3be242cacfc53d73f6b95734f79470130f568bef92d898e4a53479a78c51eddbf0cd09ead6a3b81d49a8c8d3bd74acb9f7482b15b35691c4c2ebbb6f8c8f8c0b2ec3d10618e79d0ce516961590d5fc3e74aeec0001d9c00098111376887944b3982b595bf62d887bc55327d70d6909371367643a79d19e2a16a498c88c79d9ec5884b7877868818416fc03534edac3609dbbbb8b6a25129a67f0bd95ac074c259aa0e8d2f329f4dacfd37f8c7bc142a43a73a0e17a0d0d92e42b7886204c7f6c02454a80a3625eea74f67219c5c4d192f6215bdc48c97414a1a7ecd8ab881ff8653ea4c47aa03440ca4cdcd2a05dcc67aa4ebbd6109aae01a4dbf56424eab1e02f7e861164df999a52d8a9825bde9fb764d1f54419ec4d956a811b20d72f9479e957df42db56ccc4841708e9d052699fd7a37ece67f66ce739f67e7360d12d8a874119d5e5b355bebd91519f873933e968aad53d88d4ec46f6b4cd5d68192001d181ed885cf849afa194043edae2b6191d5d937133dfd9a3adedc8bb8d1b2f8f1c64eaa3320a3dbc5aa91923d3b4996feb10e5462f9c985c95558127bb9c7d2dbbc8012ff711c21e28cc76959069516410c6df3ef023d7518ee52857f3fe6a13de1605218de0d98f87cfce62f5453db81f95fbd92c9a16298a6d6623fa6688014292ad533acd2dd3d7497fda0ec30bfb82593e02bccf90e0779f5606d2c11fd866a834b079c3ac4fcd5cb43800f3bb66c4750cbc669d087eb8f4a8387a5f893b9469dbb071c741537360082f2b202c176f60a69190ab3ef98e1c2be59f4e3f3963ddeda044713d0f79ebe7ce53286c3f8396ee969e2f068ab78ef9991bd966388d81cdea87dd206909eb011fa74ea1196fe6d0ca5bfcab7902cf8547d9ca03de40420c4033669a58fbff24dbe41c2cdb5a408907e0ff2be41177ac55bdcbaaba14b317b99699c72842dbf915db0b4c160c8888f46cd5eb6f77eb7d895a225c8cc4270c256318a5d9e13bb8d061f76953e0597e27613454f5758911b41234e5608cd21aabc440838b58a47545b003fb50d88f2e9cf092dc9a6582576440b7f704714239e1a1049a96935aaa8f21ef86157a4e214dd2a696d000ec008e3f963cda75199785c483b43b4b5222482371821479d501363c4d198ee8a96b914be86d4a9ab9a343d64e2e787b4974803538fc6a5e994aa35552651d0c887049bc367189499241345780e9f39470f91fa5b74b94414ffe70d7e6cb0d2dcc2e3fbe6385e2d1ae77ce9f16834a10554a2dd899e68ac7755523eb5f5fdac733e825fa9d676ac49588c15602a99ca6c23ef09aa0fa3ff3aa0ccfde08c5d73ffd14de06457dbb1995a22ca68b8dfd2b91c070d60957b39ca06cb87a73e6ea919f130c6d433e268c6049a9f9ba5ee142a9b3513b7a00855f0f0100e7d467528955f9a4c6025e0e73c8fbb795fd6c35779ab3db842825e5239f374b02a1a119163e35b89a32fe235d3b922e8eb3cd5c9d359ace5d8e5a5ca8b320e3e2b644ae21811a5f07526fb94a75e6694f068e329dbac1acd8a43f9627fbd214511112db0f9112e9337f036328a713116724abe0e4aceed16ab0cf6cd6862a82b720b4c6f63e99bda6f0089ef83df0235da23e2e73b996c93eb3c88e9ec60cb4c6d942d84bc0ccda3e392aecc0608fab234c7422ae64a165a85e3e54f332de3c1d092497419c8ffc5dec4d1d22d1eccecf62ff5cd14a3976f10bfc1aafff8311ef647e01327348cbe4fbd27a3c3851c3cab0a6d701b21e52319720b124590aef07efe20ffcaef7e0100ddd7e7274fa9d30b2696320d1b4ca9905fb32dfdc10bffdf42e0ee15e05f0edf3be5d0b8f96059bc9bfb8460bf5316142fee471ca535b5294781afb1d54618ad12750b9422bcd30e4de260bc19ee7800a549d0ecb2e0907559075d9e0c4d0fab445199e5e67c352eca050dc8a61414e5cb08063b47d1f994e5fb47ce7747ef4fb371f28acf2b03b513a168a9da25b305bdb89f98f6a9ff54dc842b7176a998d04bf30cbfc5af9d4d306f96862ca5e22088e9ac7c2c49e9218d5242d96e6e9202849a6fb3b9a3831b85731da918111e80025b6383724964265d52bcd4e17fdbb8537c22b0ac04cb052829f93b031a979e4e0501e2c1fbddfe011e5aad4ca22f3c1cb31069f65f379a8398f05666ba1f6264d6a3638485827b03631c0edcaad525581689941bd815a234f6c7259fabc1a863769815f299bee2f6093a4c654470ac90bb53a9b8929e4660ce013f174dd4ab54c9ded08fb800189fe21a8bcbacff4fe2983ccde1d046936c436a569ed2eb3d34d10e55197bf8dad4dbcc56d40279164abeb66f52e5fff0a845257e967c69df3beb6271481d9eef535c8f2d7097fb47aa4f4bbd7e9a27b5855e03b61d67ad69d585c14647f8bacd04ceb988ef4971b611cb25e932f81c619d2f7a42b8d5316b176acdad2b47e678079da85788a22df771db078f480f2d21c8f0ec443f41921e5c1c3ff2e96440b6bf1bb441cd8fff6e0666c1254d7d0adfecf97315b54f399f9a32d77b94aee926b576f10cab78de2eb15993dbc2f9e6ea23c3445c1613f51f8044d21447d169493c242b7e04339a0a670561441ad0ded1e18424a659eb1b6c799c2d60b4d6868b4754a51d7cbc5db24078183604c47a915c06ad183a86642f7fdb94dd8629e88acba6b16d8c37ceadcff2493072389d902b33e6911ce4026801008c2c943a2e63b5c4891d86170bac8769ea4c25bd9ba67d40b9f6cc43c98e7fb9aa6dd7581162730a43e821cbe9a22da368c95be15d9f53a1530c0c6950fe602fa4131181a2dd6a6920cc21c3ae904bbde3f13903aa409cc67701c2e5d73711fd57ccdfc40bcc53f54b344c6239949dcc1e00b4d955a89e74ce3c469531b9fea2407c1ece3808234a18e181c75befae7d1c4cd7c9d9708848e1af7933118e133d609b9a599f6a4c8eea8cd817d67f38fb191a5d1bb794800de6011a2e83480d3001c06d8214b0960733df4c552970891ceb70e11c9df6c9481393735348023b5f1c484c74b6253b2f6e1fface33826bd2849e53c6ea2f4da56f82cc39e2897f69b305977c2889299c47ec3881247e36e43c838ee1ae6d7c183ad9dd0902bf2c6e55d277ae011652cb44fb736ada7d830d844a02327f5705146a850ce78ad1d09f4bd6ca7165ff6b07f8d6356a5f689e9399e19ad35b7b49f1cd7254164f4d1f48948878f1677ae00a90340a900bdbe4d17f8809d2774692881953683df806e5dd953e96a913ee8e6dff1a33eceba6ca35872f02af1eed1efa572adc0cbe09db85924aee868b64c3f49f1dc4f75fed3e8e86689fb3fd2ef16bd4c70d31e8bcf5e0f3272dc4efafc6ace7d9e0e1e13076defefcdc4e89d9688e89fc294e19f390a5689b277918e035ebbba49e8c09285dc74faab309845f8a84b255b95fa1a5d158f5cd82b1f215ca88e167cf176b0a4fa0fb6f079b61b79e63781673f589308ea38049c663e0feb8f626fb6f7e383c3496b42fb313050b006ab137341f6e3bfc00d8fae56b93e525a3c2d7e4383ceef69496b6829a98e71b3ecf92ad11d8e89dcc2d2805a22aadac0d0d52dcf5dbcda1966aa6a30966732c05286f8a857b80484521ad0292b3df6388bcb6eb3ff0aaede69e9ed64a02cdff3ff7b08df67d18895c09ced3208b12a9b78e065406a867e6f14e144ca30304678d3d91c865b054f540ca70d0abd2ec6d62480fedf03fb9b645da0252f58912a0f3561066fa7d3c8b8b4fc3e170f6030f479f87c27d356bd43c84ff046721f5c20bcf1cc43ccf2c1eb9ee2eb41810d1bbec81f64f1a24fd8303bd6689a2ccbaddbbc8c026132b3b1e4f4a7b62e244da794fab2d8e8da415a6d4aca7cb9a4820e9f09c4d88c147a95f627507cf52e491ddaa7ba549464372b3973c7a69ced2aa909e76ff3268047fdf83b5e2670e112b18b106780761138f5a63d9e8d133710a29adce57e65583991212b8b32c209b4ca2097e1676cdfc087fb90adb5e7adf5343106b6b8096b4cbfb7a97697f7a906bb543f8ab2d4e53ee8291632e15bf30fd4f757eb88f2d66a268406acaeddf827507b4133693737c11440688ce01947ac2bcd112ab88c352fd77eb6af41483e09a28d7e1ea0b5cb9d7f190d6e5b23fdcfa3ceb51bccd7cf247fab140c04926d84f532c74fcbc9795ad05485c70d5a304d03f656ea194d83a8ba04650a2b99b3ea7f555dc8b4c94ae529f7baeab44cd60048a0927b2c16a3537b9365cd511a715fa2a252064f5faca42b686bed4ceea180405d9efdcd418c976b16b008bfa0ea3001d03cf3dcc82e28ea434079e19c576ff3bf9160e878aac1ef5ec6b299657cfe0b36505e34fe3d96bb13485f5955a1baf0c13452e4b542ccf6377a35ab0ee8e61fa6158d6e44f13e68fb019b0db630379f3c3cd7a4ed8d12f5438d39c8bc4e84d0997df8a78438ae23d555bb19781a178e9f33ebd4e0285d1efa510e6259ea318f413f59b39e68c24928825c34aa8e33eeb3aaa42c078e14e6636608a32e071151a7dbd258346e0ba3192924179d166b363b6409d6b12a13d3a01900b9230edf4221b670b2c23cbe9fce7bae8ddc350e0a1f0914e0f88c1374f5e40c74a599afb7b34e3e175d263e264b16723e09661a3edf7a43f11ff4a7e83c30a99d8ff7074c1810611a20f4a0dfc07209560b32df34ff525e6db362b53389608dc0bda2d113c79450f88612d1269a3e2b08e58f45ab0b2e08e675c4285f89eee32c616c95e7e47d7c04f5cbb44ab2456c13478ddb56df13b592df77a73656c076f2311c0989374f6ce7e561b9f225362aa7514cd2f72ed0e5cf8fc6073799809ddef46731f738aaae06985bb97a5ba3eb62f6c2d441f710de6000a2c3b33fe3d869ebcd2aa1dea370ac9513fb4e64787ee17cb944ecc2421287c92df0432300800fe7903e38d8bf76a14bf16d67a9747dffb6a7b0564d924aacd9ccbe83ab28e57dc0b98a4bcccda581e5f17c10404af0cefefb4a84da6427809b5091cfa7bb3178b6cd0f7db2fe8beee3d03d9de95ff2b916784c8a8c199d6c02322c4ce27932de619b0bc6cd243617a8df0078393c4a3c45d198c2635d449ad989281a1a4ead4d15c6b05aa7dab271cb6cf2206e38b9f435e205bcb6dda02dd3cc20413c5d208de8968eadee55589c3fbd4ccbd423919aaf08e6ae92e5a83a4c0e252908168177a1a0d6f2a50c2159fa7bb8b0f46f992c82f20e202dbeb595cf0d1c4f47ef7110e88847fce5ea9513b4e52e3900f260f78fb2ec9948bc81058e067898aa3b0d4a99fc03008ba011a5e65492bfd10935529cb3a841b82249fc2a4a274945a371f52881c05c6387dfc58b879eaaa17ebef42613744171d53d1559fcc1a63b513aa4836c1a7f84c341665817f9c227face16fa7617723449be620d1720a250ca67693ca874d185126472792b90b04ec2f4925d066ae7d9a8cf7a3d7c999f31be217f0e4db53e327b4aeecd92928f7eea98225fa981f7cd6b8f8ccaf7cec93d54d1ede7954c2369edd6ba655880c28a6946b88a3f2690c308ad0e67bbf219c48cfcad626bc82d3f92c2e3da6da98873d4310ca076b582d7bc72200cc81e80101ddc1ef48cd276a25b9596088b2fab0b582b5539193906bd419a65094fe51e9fb8a9b5e0a58d326a0cf6ba85a842abfcaeb42127c55fb774ab506ff14c3856bf55767196f06a27633845c947bb100055651fe5082cdab2ff8cd74128b95c6d30af454411bc9d22d363f743a2779a90a487b8dfa354c97716133484df5981e17aaed5780bc9358b484c9088e3528d48c3e3dfd5e9eb18a173d7801fd4897a669f38e2bea04792322e6075ac7bd2aa2041c6e236cd0e31cf97125b0d03d2fce8da5c96ccd49dd046f707ee28c1b47d634e8734a5e8e3b7f0bf2b52babc81f05226bdeda932a026a1e9af5643042a1dd3702482481dfa8b60033b55ad521f2c8de6884295467e4d303bb907a13eb1b9be1aa185ea19a3815af473b9b235f90fd1c26e13c8d357e3e4fa6324d7bd29fa9cc362f8f5f95aebd77a47730901445d3498861c7ea88122c9ece79b4660aa669e6e2be14f224fc5a03756d9e435548eaad8f237bb2b7416fbfb6828cf924a876b5436f563ffea1bf611beb23063e94b06546cff90df0438ba889bdce90cfda0c25906ac0f478791a5a7608fa2f8f012a1f1e9ddcf3aa52ccf85d2d94fc19b6e1e730579925deb618be7e308052aa17d233e353dc8cdcccea8d952d6a0a693775c03126d0e33748fd37f314d7731cbcc0e79a90ab3b5107b4c28a9b000e18e5dfdf134a706bc02624518018e680dd3dd7086f69966adb3ed7ef6b585ef576c481868c8f86ef7148e5b14270e541f8315916e9f4dc7936ccb16f431148e37f3ed9b52d2fc162687447bb69dd4b1cd7a4c87b696343be946f1d12688680406d4eb6abec470d8dd0790423a75294f707c700becb99e2354a7a5e60992f44927eca42346f237fc62c4bbff5b213f05618ff87bbd80d4d8aaf9dca899a4cf40821cd4caa6bfbb5865591d2e7978143edbae3c72fb99bab86632126bfb91c6269ced0c38c63836f3e1b1ad9d2b0a2819c583b5980dedeb24eb3d4445ec324d88e1d86375cf1784ec374a46784c0f71d5987d919eae2160017dd5705cb54ffb72817c00256b6abee6580218c0d15cc00ac0dbf49db2cbf6bdb9c1bacc612b255787d23fac3189415f7858c5e3ea91778582d15df5d530ca6860963fd2162acada0a98f05a11994fa6f25267a86e88e0f65c4f01bf44b2f06e53056ce60354fd55eb1751a93d08d90fdba687eeb259b336ec5f8b1245b01cb8d47f90c3f4f9ebc5a0002c630a5e6dfb7442e7672d7220759d8fa5b1e1fc78d207f46233669352a5ff39ccd628c279c80c83e63d5fd31370865a2c0d31d9cad2e8a84677c34dfa289128ff4470294cdeb967c1dfad0f4f315e7621b61d70fc79938f92627c96c5b2c98ecde099db80a58070bfbe57caf19168ba72705a8f2b458e5c614d162d981ee2f5d3b319d57fb7f5fddecde5ffd5a7321280c0a05a3e838558570737606fe94a0666388341b69bd8528f79ef230be94ff7a7362ff345588eeaea85b081d86610eb8e7ffc68d501513e63548d7c1334a800f375c9041faa311111cf21597000000000000),
(14, 'MCan', 'Kucukaslan', 'M@C', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '2021-12-01', '2021-12-11 23:13:49', 0x52494646901c00005745425056503820841c000030c2009d012a580258023e5128914623a2a1a125f39820700a09696efc7c996ec01ea5ebe54dd049f90ffc27819fccffb17f62fdbdfee3ee2f8e2f42fb8bc8afcfbfb1f33bf8d7d9efd3ff65fddbfcd0f93ff597c55f94dfe5fda8fc817e3bfcaffcbfe5cfa1dec83001f54bfd67dd4fa36ea53e0dff9ffdd7f127ec03f5cbfe7f1a67e2bfe67eba7c00fe83ffcdecd7fd4fff1ff51e80ff44ff3dffcbfd5fc06ff38fef3ff6ffbdf69bf49b100807a198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc21984330865373c16a2c103b2085b6d285638b9290cc2198433086610cc219842b7daffff83fdfc7fa313627d8eaa41429c825bb1d6745230008db3f567eacfd59fab3f565f40282d7ddf5379f15658ce2707e9d2e5cba969bfa053ee78f66fcde06000aca98326e6ac2a4b926133086610cc2198432fdf6e97a5f268d43820211fffd54437f1ffbeeac75a59984df85d65595db6d8fbc491d884d050443c424a65fccbf997f32c289c83f3981922b33f9727ff0258be0bdc533f2f8da5268ed157cc3902991e45e13fb6aacfd59fab3f5478e52e4ea8fb3321ddfd1b6872bad336d86db0d8cb544cd5bc0a68d43c17ccce7fb046db0db61b66970b915cb7ecf51546e03fa5a42299b1f178e47ff96f1353af203507d3f099937dffcefbb66b6442f03cbd26d5812ae559fab3f565f404e3bd354431c2778ca11749cbff9c3ef9a23683fad326193650829006741f610b0328729b9c048ad6fb864edd1d6ae74bffab3f38be885e68315761b34f63eda299b2040621eea90f08665f71547c950e9970dc5590ca3fea3acd2992e24bf997f06d27e2b4e100f16aa48e0f062be695d6ff8ac2cbf97f1765f66d30e1b0c171c231299ad5ed4160d446e99b6bd0a96594928e6c01e5ffd5236a8c76998434d974f324357997cf9a197e7ee0617066f714cb1b072dfd1714e9aa17a1983d604df610cc1ebc3af0d723cf51c05018c4b76d0ef1e278c596bd7d2bff45f4322d5cd6f0db37a3ddf9263fb8a658d69129c3bdc52fd47f491e8ef7009a8d0cc1e9bfd8dabacdf2bf2ffeaca9ba9a2cc083f2f660f5c301e71ce77eb4610ca16b0240de55c7a8bc21fb0aa8befe12bbbf997f2f9657f6d0c7be8eb98b66ce83e0b9d8fb91b4cdb5e79ee7970f8cb65fcbfa58aaaa6fcff567eacaac8ddc0b1f33f8168c2003ffbb237650ff677da8c74bffab2c7f708eaf2386daf2bc3a1f0295c9d336d86db0e492ffeacfd5210d97f44aafdc52feb63dcbeab3aa9b61b6c2ebc8ea27e364a850e8d67aeec2f8bcf963a73d7e10f43307a93e239570a42cb4cdb3507385d08066aadf8936f0ba11257fff6617ff3012b241661ba4fed8566fda0ae4c09306432fe4da1ace1224af012f8cbf97ff69b71ab2165eb10c7de861f03713b7a8d21e1100f42bd8b4781eec2014945fd2dda096f8239e0009b8c5802b8c7f28d9f411e5b4e4afe4ba418b76201e866112d5121915c68d17e8e5ae6e1d46d69b054c13d0cc1eb92668b096752e57da0a1d192db97686610cc21983d1f27eee1be5f2d484e1c0770eddb0132fe65fc14fced483597d25c28083156011dfb8a65fccbf99620c131aa14f83c90c4819981963876436d86db0d9087e381a2860c19ee89eacc050cc21984330859694011d668603c82339511c065db0db61b6bc2a1775ba06f045a5a14665c82b20807a1984330857c804f82140d48eed63ef7170b97130ce164dc62cbf97e92111f046dc14162d289230931d2b9021b4cdb61b6c36cc512ebc295a4c7ee0e236acca16dee2997f32fe5faa689dc37428b8b2fe65fccbf997fc168919cff8ea9462a84403d0cc21983d1de4147dd1c775b23d0cc2198432fddfb75fa9f2bed0ba532fe65fccbf997cd49509f2cc94aa5c36d86db0d8e7173db5ee02cf18d246fccbf997f32fe65fcbfb18e3d748a5fa91fa05da66daf271363f3f9e226e14ed63b3f567eacfd59fab3f567e7df8e238835955d00f20286b700c368fbe30b4e2f169520fc440b490f911b79684403d0cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc2198433086610cc21984330864e0000fefb180000000cbf140f24074d9c73ac044815b92da22dcb15070c47f1a405496a68b76c8ccecdbb76a65f77f106f21dab2390f78db3be084d1d658d2c17924790cd5374634ed567ec588165a4d912a254fb72e393c5d0a8b025a5e12a4739d9dd68daff27b9b1953951d46a857eed00e6b1b88a5154069cd08d423b8dc75c86ab1842bf42d29f0901c88ec22cd229acc15235f82e3a821384dcdf506b72ac9c1dc3a264bf3ee01071150eaad3a150221a605ff19778efe6b2b51018cfe86cf2bcb3b54368d3fe5d45f57f5af6de2e083c2f8b40f59fcdb2469d8ce93c6cbbc7b418cc29c3416e052709dfeaa80a40c7b06843c45097ba44dd49fd5c876208f440d588fba55644faa8302a7293fda0c7016ae97a05d46a7f9ff210a59d4a7fa0deaa6860a9239a5a5a2ab0035af08d210ff9d342a2d5a53b3227a5fa76407132f169aafde14c7c3c565e56b41521960d1e6f07dd8dd09afd2da470a870643508dec5db39561606c3fde2719a2ef036e25f17a88761b60188fd009ddf9ee373ec1ab96e037f32f427e004a988f63a0a177553ebe1ce9615e3dc495bc7b463efb06fccbafa3b105160076e7ca76694ad6ea6d802e3f36dadb0f2ed4a264b7fc7035e168e8c80c8c0d756cb8a0c1ca2576deb322f0289b7641c6bc1864543fb3d37d51959d20cb7959ad4a0545d152946cb4a92593ea7d470e5aad48c00bff7fe660ba890d2a278a8328c3cd59091945efa94966b411fd3bcdc79e989296d5f87cb6dfdbb12aa95aad6a5c07fc4381c72f72a8519431ef98cd4f227fde9b1169ce088826c0bcdfad22630214513726c4891da207516cae5e14da998dfac7fae1f1921b49191659ce1b1cdfb05147888d08d351d4cdf42ceba0bb3d5867d5f3911f2129507a3e708048b8c41a3be242cacfc53d73f6b95734f79470130f568bef92d898e4a53479a78c51eddbf0cd09ead6a3b81d49a8c8d3bd74acb9f7482b15b35691c4c2ebbb6f8c8f8c0b2ec3d10618e79d0ce516961590d5fc3e74aeec0001d9c00098111376887944b3982b595bf62d887bc55327d70d6909371367643a79d19e2a16a498c88c79d9ec5884b7877868818416fc03534edac3609dbbbb8b6a25129a67f0bd95ac074c259aa0e8d2f329f4dacfd37f8c7bc142a43a73a0e17a0d0d92e42b7886204c7f6c02454a80a3625eea74f67219c5c4d192f6215bdc48c97414a1a7ecd8ab881ff8653ea4c47aa03440ca4cdcd2a05dcc67aa4ebbd6109aae01a4dbf56424eab1e02f7e861164df999a52d8a9825bde9fb764d1f54419ec4d956a811b20d72f9479e957df42db56ccc4841708e9d052699fd7a37ece67f66ce739f67e7360d12d8a874119d5e5b355bebd91519f873933e968aad53d88d4ec46f6b4cd5d68192001d181ed885cf849afa194043edae2b6191d5d937133dfd9a3adedc8bb8d1b2f8f1c64eaa3320a3dbc5aa91923d3b4996feb10e5462f9c985c95558127bb9c7d2dbbc8012ff711c21e28cc76959069516410c6df3ef023d7518ee52857f3fe6a13de1605218de0d98f87cfce62f5453db81f95fbd92c9a16298a6d6623fa6688014292ad533acd2dd3d7497fda0ec30bfb82593e02bccf90e0779f5606d2c11fd866a834b079c3ac4fcd5cb43800f3bb66c4750cbc669d087eb8f4a8387a5f893b9469dbb071c741537360082f2b202c176f60a69190ab3ef98e1c2be59f4e3f3963ddeda044713d0f79ebe7ce53286c3f8396ee969e2f068ab78ef9991bd966388d81cdea87dd206909eb011fa74ea1196fe6d0ca5bfcab7902cf8547d9ca03de40420c4033669a58fbff24dbe41c2cdb5a408907e0ff2be41177ac55bdcbaaba14b317b99699c72842dbf915db0b4c160c8888f46cd5eb6f77eb7d895a225c8cc4270c256318a5d9e13bb8d061f76953e0597e27613454f5758911b41234e5608cd21aabc440838b58a47545b003fb50d88f2e9cf092dc9a6582576440b7f704714239e1a1049a96935aaa8f21ef86157a4e214dd2a696d000ec008e3f963cda75199785c483b43b4b5222482371821479d501363c4d198ee8a96b914be86d4a9ab9a343d64e2e787b4974803538fc6a5e994aa35552651d0c887049bc367189499241345780e9f39470f91fa5b74b94414ffe70d7e6cb0d2dcc2e3fbe6385e2d1ae77ce9f16834a10554a2dd899e68ac7755523eb5f5fdac733e825fa9d676ac49588c15602a99ca6c23ef09aa0fa3ff3aa0ccfde08c5d73ffd14de06457dbb1995a22ca68b8dfd2b91c070d60957b39ca06cb87a73e6ea919f130c6d433e268c6049a9f9ba5ee142a9b3513b7a00855f0f0100e7d467528955f9a4c6025e0e73c8fbb795fd6c35779ab3db842825e5239f374b02a1a119163e35b89a32fe235d3b922e8eb3cd5c9d359ace5d8e5a5ca8b320e3e2b644ae21811a5f07526fb94a75e6694f068e329dbac1acd8a43f9627fbd214511112db0f9112e9337f036328a713116724abe0e4aceed16ab0cf6cd6862a82b720b4c6f63e99bda6f0089ef83df0235da23e2e73b996c93eb3c88e9ec60cb4c6d942d84bc0ccda3e392aecc0608fab234c7422ae64a165a85e3e54f332de3c1d092497419c8ffc5dec4d1d22d1eccecf62ff5cd14a3976f10bfc1aafff8311ef647e01327348cbe4fbd27a3c3851c3cab0a6d701b21e52319720b124590aef07efe20ffcaef7e0100ddd7e7274fa9d30b2696320d1b4ca9905fb32dfdc10bffdf42e0ee15e05f0edf3be5d0b8f96059bc9bfb8460bf5316142fee471ca535b5294781afb1d54618ad12750b9422bcd30e4de260bc19ee7800a549d0ecb2e0907559075d9e0c4d0fab445199e5e67c352eca050dc8a61414e5cb08063b47d1f994e5fb47ce7747ef4fb371f28acf2b03b513a168a9da25b305bdb89f98f6a9ff54dc842b7176a998d04bf30cbfc5af9d4d306f96862ca5e22088e9ac7c2c49e9218d5242d96e6e9202849a6fb3b9a3831b85731da918111e80025b6383724964265d52bcd4e17fdbb8537c22b0ac04cb052829f93b031a979e4e0501e2c1fbddfe011e5aad4ca22f3c1cb31069f65f379a8398f05666ba1f6264d6a3638485827b03631c0edcaad525581689941bd815a234f6c7259fabc1a863769815f299bee2f6093a4c654470ac90bb53a9b8929e4660ce013f174dd4ab54c9ded08fb800189fe21a8bcbacff4fe2983ccde1d046936c436a569ed2eb3d34d10e55197bf8dad4dbcc56d40279164abeb66f52e5fff0a845257e967c69df3beb6271481d9eef535c8f2d7097fb47aa4f4bbd7e9a27b5855e03b61d67ad69d585c14647f8bacd04ceb988ef4971b611cb25e932f81c619d2f7a42b8d5316b176acdad2b47e678079da85788a22df771db078f480f2d21c8f0ec443f41921e5c1c3ff2e96440b6bf1bb441cd8fff6e0666c1254d7d0adfecf97315b54f399f9a32d77b94aee926b576f10cab78de2eb15993dbc2f9e6ea23c3445c1613f51f8044d21447d169493c242b7e04339a0a670561441ad0ded1e18424a659eb1b6c799c2d60b4d6868b4754a51d7cbc5db24078183604c47a915c06ad183a86642f7fdb94dd8629e88acba6b16d8c37ceadcff2493072389d902b33e6911ce4026801008c2c943a2e63b5c4891d86170bac8769ea4c25bd9ba67d40b9f6cc43c98e7fb9aa6dd7581162730a43e821cbe9a22da368c95be15d9f53a1530c0c6950fe602fa4131181a2dd6a6920cc21c3ae904bbde3f13903aa409cc67701c2e5d73711fd57ccdfc40bcc53f54b344c6239949dcc1e00b4d955a89e74ce3c469531b9fea2407c1ece3808234a18e181c75befae7d1c4cd7c9d9708848e1af7933118e133d609b9a599f6a4c8eea8cd817d67f38fb191a5d1bb794800de6011a2e83480d3001c06d8214b0960733df4c552970891ceb70e11c9df6c9481393735348023b5f1c484c74b6253b2f6e1fface33826bd2849e53c6ea2f4da56f82cc39e2897f69b305977c2889299c47ec3881247e36e43c838ee1ae6d7c183ad9dd0902bf2c6e55d277ae011652cb44fb736ada7d830d844a02327f5705146a850ce78ad1d09f4bd6ca7165ff6b07f8d6356a5f689e9399e19ad35b7b49f1cd7254164f4d1f48948878f1677ae00a90340a900bdbe4d17f8809d2774692881953683df806e5dd953e96a913ee8e6dff1a33eceba6ca35872f02af1eed1efa572adc0cbe09db85924aee868b64c3f49f1dc4f75fed3e8e86689fb3fd2ef16bd4c70d31e8bcf5e0f3272dc4efafc6ace7d9e0e1e13076defefcdc4e89d9688e89fc294e19f390a5689b277918e035ebbba49e8c09285dc74faab309845f8a84b255b95fa1a5d158f5cd82b1f215ca88e167cf176b0a4fa0fb6f079b61b79e63781673f589308ea38049c663e0feb8f626fb6f7e383c3496b42fb313050b006ab137341f6e3bfc00d8fae56b93e525a3c2d7e4383ceef69496b6829a98e71b3ecf92ad11d8e89dcc2d2805a22aadac0d0d52dcf5dbcda1966aa6a30966732c05286f8a857b80484521ad0292b3df6388bcb6eb3ff0aaede69e9ed64a02cdff3ff7b08df67d18895c09ced3208b12a9b78e065406a867e6f14e144ca30304678d3d91c865b054f540ca70d0abd2ec6d62480fedf03fb9b645da0252f58912a0f3561066fa7d3c8b8b4fc3e170f6030f479f87c27d356bd43c84ff046721f5c20bcf1cc43ccf2c1eb9ee2eb41810d1bbec81f64f1a24fd8303bd6689a2ccbaddbbc8c026132b3b1e4f4a7b62e244da794fab2d8e8da415a6d4aca7cb9a4820e9f09c4d88c147a95f627507cf52e491ddaa7ba549464372b3973c7a69ced2aa909e76ff3268047fdf83b5e2670e112b18b106780761138f5a63d9e8d133710a29adce57e65583991212b8b32c209b4ca2097e1676cdfc087fb90adb5e7adf5343106b6b8096b4cbfb7a97697f7a906bb543f8ab2d4e53ee8291632e15bf30fd4f757eb88f2d66a268406acaeddf827507b4133693737c11440688ce01947ac2bcd112ab88c352fd77eb6af41483e09a28d7e1ea0b5cb9d7f190d6e5b23fdcfa3ceb51bccd7cf247fab140c04926d84f532c74fcbc9795ad05485c70d5a304d03f656ea194d83a8ba04650a2b99b3ea7f555dc8b4c94ae529f7baeab44cd60048a0927b2c16a3537b9365cd511a715fa2a252064f5faca42b686bed4ceea180405d9efdcd418c976b16b008bfa0ea3001d03cf3dcc82e28ea434079e19c576ff3bf9160e878aac1ef5ec6b299657cfe0b36505e34fe3d96bb13485f5955a1baf0c13452e4b542ccf6377a35ab0ee8e61fa6158d6e44f13e68fb019b0db630379f3c3cd7a4ed8d12f5438d39c8bc4e84d0997df8a78438ae23d555bb19781a178e9f33ebd4e0285d1efa510e6259ea318f413f59b39e68c24928825c34aa8e33eeb3aaa42c078e14e6636608a32e071151a7dbd258346e0ba3192924179d166b363b6409d6b12a13d3a01900b9230edf4221b670b2c23cbe9fce7bae8ddc350e0a1f0914e0f88c1374f5e40c74a599afb7b34e3e175d263e264b16723e09661a3edf7a43f11ff4a7e83c30a99d8ff7074c1810611a20f4a0dfc07209560b32df34ff525e6db362b53389608dc0bda2d113c79450f88612d1269a3e2b08e58f45ab0b2e08e675c4285f89eee32c616c95e7e47d7c04f5cbb44ab2456c13478ddb56df13b592df77a73656c076f2311c0989374f6ce7e561b9f225362aa7514cd2f72ed0e5cf8fc6073799809ddef46731f738aaae06985bb97a5ba3eb62f6c2d441f710de6000a2c3b33fe3d869ebcd2aa1dea370ac9513fb4e64787ee17cb944ecc2421287c92df0432300800fe7903e38d8bf76a14bf16d67a9747dffb6a7b0564d924aacd9ccbe83ab28e57dc0b98a4bcccda581e5f17c10404af0cefefb4a84da6427809b5091cfa7bb3178b6cd0f7db2fe8beee3d03d9de95ff2b916784c8a8c199d6c02322c4ce27932de619b0bc6cd243617a8df0078393c4a3c45d198c2635d449ad989281a1a4ead4d15c6b05aa7dab271cb6cf2206e38b9f435e205bcb6dda02dd3cc20413c5d208de8968eadee55589c3fbd4ccbd423919aaf08e6ae92e5a83a4c0e252908168177a1a0d6f2a50c2159fa7bb8b0f46f992c82f20e202dbeb595cf0d1c4f47ef7110e88847fce5ea9513b4e52e3900f260f78fb2ec9948bc81058e067898aa3b0d4a99fc03008ba011a5e65492bfd10935529cb3a841b82249fc2a4a274945a371f52881c05c6387dfc58b879eaaa17ebef42613744171d53d1559fcc1a63b513aa4836c1a7f84c341665817f9c227face16fa7617723449be620d1720a250ca67693ca874d185126472792b90b04ec2f4925d066ae7d9a8cf7a3d7c999f31be217f0e4db53e327b4aeecd92928f7eea98225fa981f7cd6b8f8ccaf7cec93d54d1ede7954c2369edd6ba655880c28a6946b88a3f2690c308ad0e67bbf219c48cfcad626bc82d3f92c2e3da6da98873d4310ca076b582d7bc72200cc81e80101ddc1ef48cd276a25b9596088b2fab0b582b5539193906bd419a65094fe51e9fb8a9b5e0a58d326a0cf6ba85a842abfcaeb42127c55fb774ab506ff14c3856bf55767196f06a27633845c947bb100055651fe5082cdab2ff8cd74128b95c6d30af454411bc9d22d363f743a2779a90a487b8dfa354c97716133484df5981e17aaed5780bc9358b484c9088e3528d48c3e3dfd5e9eb18a173d7801fd4897a669f38e2bea04792322e6075ac7bd2aa2041c6e236cd0e31cf97125b0d03d2fce8da5c96ccd49dd046f707ee28c1b47d634e8734a5e8e3b7f0bf2b52babc81f05226bdeda932a026a1e9af5643042a1dd3702482481dfa8b60033b55ad521f2c8de6884295467e4d303bb907a13eb1b9be1aa185ea19a3815af473b9b235f90fd1c26e13c8d357e3e4fa6324d7bd29fa9cc362f8f5f95aebd77a47730901445d3498861c7ea88122c9ece79b4660aa669e6e2be14f224fc5a03756d9e435548eaad8f237bb2b7416fbfb6828cf924a876b5436f563ffea1bf611beb23063e94b06546cff90df0438ba889bdce90cfda0c25906ac0f478791a5a7608fa2f8f012a1f1e9ddcf3aa52ccf85d2d94fc19b6e1e730579925deb618be7e308052aa17d233e353dc8cdcccea8d952d6a0a693775c03126d0e33748fd37f314d7731cbcc0e79a90ab3b5107b4c28a9b000e18e5dfdf134a706bc02624518018e680dd3dd7086f69966adb3ed7ef6b585ef576c481868c8f86ef7148e5b14270e541f8315916e9f4dc7936ccb16f431148e37f3ed9b52d2fc162687447bb69dd4b1cd7a4c87b696343be946f1d12688680406d4eb6abec470d8dd0790423a75294f707c700becb99e2354a7a5e60992f44927eca42346f237fc62c4bbff5b213f05618ff87bbd80d4d8aaf9dca899a4cf40821cd4caa6bfbb5865591d2e7978143edbae3c72fb99bab86632126bfb91c6269ced0c38c63836f3e1b1ad9d2b0a2819c583b5980dedeb24eb3d4445ec324d88e1d86375cf1784ec374a46784c0f71d5987d919eae2160017dd5705cb54ffb72817c00256b6abee6580218c0d15cc00ac0dbf49db2cbf6bdb9c1bacc612b255787d23fac3189415f7858c5e3ea91778582d15df5d530ca6860963fd2162acada0a98f05a11994fa6f25267a86e88e0f65c4f01bf44b2f06e53056ce60354fd55eb1751a93d08d90fdba687eeb259b336ec5f8b1245b01cb8d47f90c3f4f9ebc5a0002c630a5e6dfb7442e7672d7220759d8fa5b1e1fc78d207f46233669352a5ff39ccd628c279c80c83e63d5fd31370865a2c0d31d9cad2e8a84677c34dfa289128ff4470294cdeb967c1dfad0f4f315e7621b61d70fc79938f92627c96c5b2c98ecde099db80a58070bfbe57caf19168ba72705a8f2b458e5c614d162d981ee2f5d3b319d57fb7f5fddecde5ffd5a7321280c0a05a3e838558570737606fe94a0666388341b69bd8528f79ef230be94ff7a7362ff345588eeaea85b081d86610eb8e7ffc68d501513e63548d7c1334a800f375c9041faa311111cf21597000000000000),
(15, 't', 'g', 'tg@gmail.com', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '2021-12-07', '2021-12-14 21:23:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tour_guide_review`
--

DROP TABLE IF EXISTS `tour_guide_review`;
CREATE TABLE `tour_guide_review` (
  `t_id` int(11) NOT NULL,
  `ts_id` int(11) NOT NULL,
  `tg_id` int(11) NOT NULL,
  `tour_comment` varchar(1000) COLLATE utf16_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

--
-- Dumping data for table `tour_guide_review`
--

INSERT INTO `tour_guide_review` (`t_id`, `ts_id`, `tg_id`, `tour_comment`) VALUES
(0, 1, 14, 'Lol\r\n'),
(3, 3, 14, 'I loved it!');

-- --------------------------------------------------------

--
-- Table structure for table `tour_section`
--

DROP TABLE IF EXISTS `tour_section`;
CREATE TABLE `tour_section` (
  `ts_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `t_id` int(11) NOT NULL,
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

--
-- Dumping data for table `tour_section`
--

INSERT INTO `tour_section` (`ts_id`, `start_date`, `end_date`, `t_id`, `cost`) VALUES
(1, '2022-01-02', '2022-01-05', 2, '13.50'),
(3, '2021-12-30', '2022-01-12', 3, '0.00'),
(4, '2023-03-11', '2024-01-13', 3, '0.00'),
(7, '2023-12-27', '2023-12-29', 8, '0.00'),
(8, '2021-12-27', '2021-12-30', 9, '0.00'),
(9, '2022-03-04', '2021-11-16', 2, '25.00'),
(10, '2021-12-14', '2021-12-23', 11, '0.00'),
(11, '2021-12-31', '2021-12-15', 12, '0.00'),
(12, '0000-00-00', '0000-00-00', 13, '0.00');

-- --------------------------------------------------------

--
-- Structure for view `flight_capacity`
--
DROP TABLE IF EXISTS `flight_capacity`;

CREATE ALGORITHM=UNDEFINED DEFINER=`ahmad.salman`@`localhost` SQL SECURITY DEFINER VIEW `flight_capacity`  AS SELECT `f`.`f_id` AS `f_id`, `f`.`capacity` AS `max_capacity`, ifnull(sum(`fr`.`number_of_passengers`),0) AS `number_of_reserved_seats`, ifnull((`f`.`capacity` - sum(`fr`.`number_of_passengers`)),`f`.`capacity`) AS `available_seats` FROM (`flight` `f` left join `flight_reservation` `fr` on((`f`.`f_id` = `fr`.`f_id`))) GROUP BY `f`.`f_id`, `f`.`capacity` ;

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
  ADD KEY `fk_flight_dest_airport` (`dest_airport`),
  ADD KEY `dept_airport` (`dept_airport`),
  ADD KEY `dest_airport` (`dest_airport`);

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
  ADD UNIQUE KEY `tg_id` (`tg_id`,`ts_id`),
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
  ADD PRIMARY KEY (`ts_id`,`a_id`),
  ADD KEY `fk_ta_activity` (`a_id`),
  ADD KEY `fk_ta_tour_section` (`ts_id`),
  ADD KEY `type` (`type`);

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
  ADD PRIMARY KEY (`t_id`,`tg_id`,`ts_id`),
  ADD UNIQUE KEY `unique_ts_id_tg_id` (`ts_id`,`tg_id`) USING BTREE,
  ADD KEY `fk_tgr_tour_guide` (`tg_id`),
  ADD KEY `fk_tgr_tour_section` (`ts_id`);

--
-- Indexes for table `tour_section`
--
ALTER TABLE `tour_section`
  ADD PRIMARY KEY (`ts_id`),
  ADD UNIQUE KEY `ts_id` (`ts_id`),
  ADD KEY `fk_ts_tour` (`t_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `customer_review`
--
ALTER TABLE `customer_review`
  MODIFY `cr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `e_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `flight_reservation`
--
ALTER TABLE `flight_reservation`
  MODIFY `fr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `hotel`
--
ALTER TABLE `hotel`
  MODIFY `h_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `thecustomer`
--
ALTER TABLE `thecustomer`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tour`
--
ALTER TABLE `tour`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tour_guide`
--
ALTER TABLE `tour_guide`
  MODIFY `tg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tour_section`
--
ALTER TABLE `tour_section`
  MODIFY `ts_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  ADD CONSTRAINT `fk_fr_customer` FOREIGN KEY (`c_id`) REFERENCES `thecustomer` (`c_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_fr_flight` FOREIGN KEY (`f_id`) REFERENCES `flight` (`f_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `guides`
--
ALTER TABLE `guides`
  ADD CONSTRAINT `fk_guides_employee` FOREIGN KEY (`e_id`) REFERENCES `employee` (`e_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_guides_tour_guide` FOREIGN KEY (`tg_id`) REFERENCES `tour_guide` (`tg_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_guides_tour_section` FOREIGN KEY (`ts_id`) REFERENCES `tour_section` (`ts_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `fk_reservation_activity_activity` FOREIGN KEY (`a_id`) REFERENCES `activity` (`a_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reservation_activity_reservation` FOREIGN KEY (`res_id`) REFERENCES `reservation` (`res_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
