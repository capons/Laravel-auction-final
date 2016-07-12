-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2016 at 08:54 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auction_promise`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `parent` smallint(6) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `parent`) VALUES
(1, 'construction', 0),
(3, 'cleaning', 0),
(4, 'New name', 0);

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_bin,
  `url` text COLLATE utf8_bin,
  `path` text COLLATE utf8_bin,
  `type` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `file`
--

INSERT INTO `file` (`id`, `name`, `url`, `path`, `type`, `users_id`) VALUES
(112, '1467962355.png', '/upload/120', 'C:\\xampp\\htdocs\\bogdan\\Laravel_auction\\auction\\public\\upload\\120', NULL, 120),
(113, '1467969345.png', '/upload/120', 'C:\\xampp\\htdocs\\bogdan\\Laravel_auction\\auction\\public\\upload\\120', NULL, 120),
(114, '1467969358.png', '/upload/120', 'C:\\xampp\\htdocs\\bogdan\\Laravel_auction\\auction\\public\\upload\\120', NULL, 120),
(115, '1468232403.png', '/upload/120', 'C:\\xampp\\htdocs\\bogdan\\laravel-final\\public\\upload\\120', NULL, 120);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `name` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `name`) VALUES
(3, 'Afghanistan'),
(4, 'Albania'),
(5, 'Algeria'),
(6, 'American Samoa'),
(7, 'Andorra'),
(8, 'Angola'),
(9, 'Anguilla'),
(10, 'Antarctica'),
(11, 'Antigua and Barbuda'),
(12, 'Argentina'),
(13, 'Armenia'),
(14, 'Aruba'),
(15, 'Australia'),
(16, 'Austria'),
(17, 'Azerbaijan'),
(18, 'Bahamas'),
(19, 'Bahrain'),
(20, 'Bangladesh'),
(21, 'Barbados'),
(22, 'Belarus'),
(23, 'Belgium'),
(24, 'Belize'),
(25, 'Benin'),
(26, 'Bermuda'),
(27, 'Bhutan'),
(28, 'Bolivia'),
(29, 'Bosnia and Herzegowina'),
(30, 'Botswana'),
(31, 'Bouvet Island'),
(32, 'Brazil'),
(33, 'British Indian Ocean Territory'),
(34, 'Brunei Darussalam'),
(35, 'Bulgaria'),
(36, 'Burkina Faso'),
(37, 'Burundi'),
(38, 'Cambodia'),
(39, 'Cameroon'),
(40, 'Canada'),
(41, 'Cape Verde'),
(42, 'Cayman Islands'),
(43, 'Central African Republic'),
(44, 'Chad'),
(45, 'Chile'),
(46, 'China'),
(47, 'Christmas Island'),
(48, 'Cocos (Keeling) Islands'),
(49, 'Colombia'),
(50, 'Comoros'),
(51, 'Congo'),
(52, 'Congo, the Democratic Republic of the'),
(53, 'Cook Islands'),
(54, 'Costa Rica'),
(55, 'Cote d''Ivoire'),
(56, 'Croatia (Hrvatska)'),
(57, 'Cuba'),
(58, 'Cyprus'),
(59, 'Czech Republic'),
(60, 'Denmark'),
(61, 'Djibouti'),
(62, 'Dominica'),
(63, 'Dominican Republic'),
(64, 'East Timor'),
(65, 'Ecuador'),
(66, 'Egypt'),
(67, 'El Salvador'),
(68, 'Equatorial Guinea'),
(69, 'Eritrea'),
(70, 'Estonia'),
(71, 'Ethiopia'),
(72, 'Falkland Islands (Malvinas)'),
(73, 'Faroe Islands'),
(74, 'Fiji'),
(75, 'Finland'),
(76, 'France'),
(77, 'France Metropolitan'),
(78, 'French Guiana'),
(79, 'French Polynesia'),
(80, 'French Southern Territories'),
(81, 'Gabon'),
(82, 'Gambia'),
(83, 'Georgia'),
(84, 'Germany'),
(85, 'Ghana'),
(86, 'Gibraltar'),
(87, 'Greece'),
(88, 'Greenland'),
(89, 'Grenada'),
(90, 'Guadeloupe'),
(91, 'Guam'),
(92, 'Guatemala'),
(93, 'Guinea'),
(94, 'Guinea-Bissau'),
(95, 'Guyana'),
(96, 'Haiti'),
(97, 'Heard and Mc Donald Islands'),
(98, 'Holy See (Vatican City State)'),
(99, 'Honduras'),
(100, 'Hong Kong'),
(101, 'Hungary'),
(102, 'Iceland'),
(103, 'India'),
(104, 'Indonesia'),
(105, 'Iran (Islamic Republic of)'),
(106, 'Iraq'),
(107, 'Ireland'),
(108, 'Israel'),
(109, 'Italy'),
(110, 'Jamaica'),
(111, 'Japan'),
(112, 'Jordan'),
(113, 'Kazakhstan'),
(114, 'Kenya'),
(115, 'Kiribati'),
(116, 'Korea, Democratic People''s Republic of'),
(117, 'Korea, Republic of'),
(118, 'Kuwait'),
(119, 'Kyrgyzstan'),
(120, 'Lao, People''s Democratic Republic'),
(121, 'Latvia'),
(122, 'Lebanon'),
(123, 'Lesotho'),
(124, 'Liberia'),
(125, 'Libyan Arab Jamahiriya'),
(126, 'Liechtenstein'),
(127, 'Lithuania'),
(128, 'Luxembourg'),
(129, 'Macau'),
(130, 'Macedonia, The Former Yugoslav Republic of'),
(131, 'Madagascar'),
(132, 'Malawi'),
(133, 'Malaysia'),
(134, 'Maldives'),
(135, 'Mali'),
(136, 'Malta'),
(137, 'Marshall Islands'),
(138, 'Martinique'),
(139, 'Mauritania'),
(140, 'Mauritius'),
(141, 'Mayotte'),
(142, 'Mexico'),
(143, 'Micronesia, Federated States of'),
(144, 'Moldova, Republic of'),
(145, 'Monaco'),
(146, 'Mongolia'),
(147, 'Montserrat'),
(148, 'Morocco'),
(149, 'Mozambique'),
(150, 'Myanmar'),
(151, 'Namibia'),
(152, 'Nauru'),
(153, 'Nepal'),
(154, 'Netherlands'),
(155, 'Netherlands Antilles'),
(156, 'New Caledonia'),
(157, 'New Zealand'),
(158, 'Nicaragua'),
(159, 'Niger'),
(160, 'Nigeria'),
(161, 'Niue'),
(162, 'Norfolk Island'),
(163, 'Northern Mariana Islands'),
(164, 'Norway'),
(165, 'Oman'),
(166, 'Pakistan'),
(167, 'Palau'),
(168, 'Panama'),
(169, 'Papua New Guinea'),
(170, 'Paraguay'),
(171, 'Peru'),
(172, 'Philippines'),
(173, 'Pitcairn'),
(174, 'Poland'),
(175, 'Portugal'),
(176, 'Puerto Rico'),
(177, 'Qatar'),
(178, 'Reunion'),
(179, 'Romania'),
(180, 'Russian Federation'),
(181, 'Rwanda'),
(182, 'Saint Kitts and Nevis'),
(183, 'Saint Lucia'),
(184, 'Saint Vincent and the Grenadines'),
(185, 'Samoa'),
(186, 'San Marino'),
(187, 'Sao Tome and Principe'),
(188, 'Saudi Arabia'),
(189, 'Senegal'),
(190, 'Seychelles'),
(191, 'Sierra Leone'),
(192, 'Singapore'),
(193, 'Slovakia (Slovak Republic)'),
(194, 'Slovenia'),
(195, 'Solomon Islands'),
(196, 'Somalia'),
(197, 'South Africa'),
(198, 'South Georgia and the South Sandwich Islands'),
(199, 'Spain'),
(200, 'Sri Lanka'),
(201, 'St. Helena'),
(202, 'St. Pierre and Miquelon'),
(203, 'Sudan'),
(204, 'Suriname'),
(205, 'Svalbard and Jan Mayen Islands'),
(206, 'Swaziland'),
(207, 'Sweden'),
(208, 'Switzerland'),
(209, 'Syrian Arab Republic'),
(210, 'Taiwan, Province of China'),
(211, 'Tajikistan'),
(212, 'Tanzania, United Republic of'),
(213, 'Thailand'),
(214, 'Togo'),
(215, 'Tokelau'),
(216, 'Tonga'),
(217, 'Trinidad and Tobago'),
(218, 'Tunisia'),
(219, 'Turkey'),
(220, 'Turkmenistan'),
(221, 'Turks and Caicos Islands'),
(222, 'Tuvalu'),
(223, 'Uganda'),
(224, 'Ukraine'),
(225, 'United Arab Emirates'),
(226, 'United Kingdom'),
(227, 'United States'),
(228, 'United States Minor Outlying Islands'),
(229, 'Uruguay'),
(230, 'Uzbekistan'),
(231, 'Vanuatu'),
(232, 'Venezuela'),
(233, 'Vietnam'),
(234, 'Virgin Islands (British)'),
(235, 'Virgin Islands (U.S.)'),
(236, 'Wallis and Futuna Islands'),
(237, 'Western Sahara'),
(238, 'Yemen'),
(239, 'Yugoslavia'),
(240, 'Zambia'),
(241, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `promise`
--

CREATE TABLE `promise` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `sub_title` varchar(255) DEFAULT NULL,
  `description` text,
  `price` float DEFAULT NULL,
  `terms` text,
  `type` tinyint(4) DEFAULT NULL,
  `time` timestamp NULL DEFAULT NULL,
  `featured` tinyint(4) DEFAULT NULL,
  `file_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `auction_end` datetime DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `winners` tinyint(4) DEFAULT NULL,
  `shows` smallint(6) DEFAULT NULL,
  `active` tinyint(2) DEFAULT '0',
  `sold` tinyint(2) DEFAULT NULL,
  `location_id` int(11) NOT NULL,
  `winner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `promise`
--

INSERT INTO `promise` (`id`, `title`, `sub_title`, `description`, `price`, `terms`, `type`, `time`, `featured`, `file_id`, `created_at`, `updated_at`, `auction_end`, `category_id`, `winners`, `shows`, `active`, `sold`, `location_id`, `winner_id`) VALUES
(42, 'title', NULL, 'detaile', 50, 'sdfsdf', 0, NULL, NULL, 112, '2016-07-08 07:19:15', '2016-07-08 07:20:50', NULL, 3, 1, NULL, 1, 1, 7, NULL),
(43, 'testtest', NULL, 'sdfsdfsdf', 50, 'sdfsdfsdf', 0, NULL, NULL, 113, '2016-07-08 09:15:45', '2016-07-08 09:15:45', NULL, 4, 1, NULL, 1, NULL, 7, NULL),
(44, 'testtest', NULL, 'sdfsdfsdf', 50, 'sdfsdfsdf', 1, NULL, NULL, 114, '2016-07-08 09:15:58', '2016-07-08 09:15:58', '2016-07-09 12:15:58', 3, 1, NULL, 1, NULL, 7, NULL),
(45, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2016-07-08 11:46:43', '2016-07-08 11:46:43', NULL, 0, NULL, NULL, 0, NULL, 0, NULL),
(46, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2016-07-08 11:46:58', '2016-07-08 11:46:58', NULL, 0, NULL, NULL, 0, NULL, 0, NULL),
(47, 'testtest', NULL, 'werwerwer', 50, 'werwerewr', 0, NULL, NULL, 115, '2016-07-11 10:20:03', '2016-07-11 10:20:03', NULL, 3, 1, NULL, 0, NULL, 6, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `id` int(11) NOT NULL,
  `promise_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`id`, `promise_id`, `amount`, `users_id`, `created_at`, `updated_at`) VALUES
(40, 42, 0, 120, '2016-07-08 07:19:15', '2016-07-08 07:20:49'),
(41, 43, 1, 120, '2016-07-08 09:15:45', '2016-07-08 09:15:45'),
(42, 44, 1, 120, '2016-07-08 09:15:59', '2016-07-08 09:15:59'),
(43, 47, 1, 120, '2016-07-11 10:20:03', '2016-07-11 10:20:03');

-- --------------------------------------------------------

--
-- Table structure for table `search`
--

CREATE TABLE `search` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `descript` varchar(255) NOT NULL,
  `expires` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `search`
--

INSERT INTO `search` (`id`, `users_id`, `price`, `descript`, `expires`) VALUES
(1, 0, 0, '', '2016-07-12'),
(2, 0, 50, '', '2016-07-18'),
(3, 120, 50, 'rrrrrrr', '2016-07-24'),
(4, 120, 50, 'rrrrrrr', '2016-07-24'),
(5, 120, 50, 'rrrrrrr', '2016-07-24'),
(6, 120, 50, 'rrrrrrr', '2016-07-24'),
(7, 120, 50, 'rrrrrrr', '2016-07-24'),
(8, 120, 50, 'rrrrrrr', '2016-07-24');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `val` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` smallint(6) NOT NULL,
  `name` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `category` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `f_name` varchar(128) DEFAULT NULL,
  `l_name` varchar(128) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `location_id` int(11) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `active` tinyint(1) DEFAULT '0',
  `category_id` int(11) NOT NULL,
  `access` tinyint(4) DEFAULT '0',
  `hash` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `f_name`, `l_name`, `email`, `password`, `location_id`, `remember_token`, `updated_at`, `created_at`, `active`, `category_id`, `access`, `hash`) VALUES
(120, 'test_name', 'test_Last_name', 'bog@ram.ru', '$2y$10$OnXQj0YhH1YRr782VOA9TuEaor2K0FSkhCw4n69RAGx78REDa2ECC', 5, 'u1NRhDrGojILqk7Y2eZZLf1hVZ6PQaqAUgwqnJTagOoQK5r9gKRxdkAnATbV', '2016-07-11 12:14:27', '2016-07-08 07:13:47', 1, 3, 2, '$2y$10$kRvTza3I92Z6l29okLcbD.1PKuuyQbSqdj6VHbD41FMUTvBPWHFpO');

-- --------------------------------------------------------

--
-- Table structure for table `winners`
--

CREATE TABLE `winners` (
  `id` int(11) NOT NULL,
  `promise_id` int(11) NOT NULL,
  `bid` int(11) NOT NULL,
  `winner_id` int(11) NOT NULL,
  `if_email` tinyint(2) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `winners`
--

INSERT INTO `winners` (`id`, `promise_id`, `bid`, `winner_id`, `if_email`, `time`) VALUES
(63, 42, 50, 120, 1, '2016-07-08 07:20:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_file_users1_idx` (`users_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promise`
--
ALTER TABLE `promise`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_id` (`file_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_request_promise1_idx` (`promise_id`),
  ADD KEY `fk_request_users1_idx` (`users_id`);

--
-- Indexes for table `search`
--
ALTER TABLE `search`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_location1_idx` (`location_id`),
  ADD KEY `fk_users_category1_idx` (`category_id`);

--
-- Indexes for table `winners`
--
ALTER TABLE `winners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promise_id` (`promise_id`),
  ADD KEY `winner_id` (`winner_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;
--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;
--
-- AUTO_INCREMENT for table `promise`
--
ALTER TABLE `promise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `search`
--
ALTER TABLE `search`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;
--
-- AUTO_INCREMENT for table `winners`
--
ALTER TABLE `winners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `winners`
--
ALTER TABLE `winners`
  ADD CONSTRAINT `winners_ibfk_3` FOREIGN KEY (`promise_id`) REFERENCES `promise` (`id`),
  ADD CONSTRAINT `winners_ibfk_4` FOREIGN KEY (`winner_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
