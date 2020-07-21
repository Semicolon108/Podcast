-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 21, 2020 at 06:17 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Podcast`
--

-- --------------------------------------------------------

--
-- Table structure for table `podcasts`
--

CREATE TABLE `podcasts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `pod_photo` varchar(255) NOT NULL,
  `pod_file` varchar(255) NOT NULL,
  `tag` int(11) NOT NULL,
  `date_uploaded` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `podcasts`
--

INSERT INTO `podcasts` (`id`, `title`, `description`, `pod_photo`, `pod_file`, `tag`, `date_uploaded`, `deleted`) VALUES
(1, 'BOOTSTRAP', 'thus ui anice course', '/Podcast/View/Admin/Uploads/69ae06bfe5bafe0ab002d101323c82e3166f5cd5.png', '/Podcast/View/Admin/Podcast-files/376ec34c9497755834172ed4e6290e432c40f7f5.mp3', 1, '2020-07-20 16:13:14', 0),
(2, 'LEARN BOOTSTRAP', 'thus ui anice course', '/Podcast/View/Admin/Uploads/f0060013f6be8c2c4bd2f5d849338660b141145f.jpg', '/Podcast/View/Admin/Podcast-files/0e35cb10f98e978467b250aa8d7b75b8df882fdc.mp3', 1, '2020-07-20 16:15:31', 1),
(3, 'LEARN BOOTSTRAP', 'thus ui anice course', '/Podcast/View/Admin/Uploads/316b0a5361ec1614d8ab9206003ffc8fe2764f87.jpg', '/Podcast/View/Admin/Podcast-files/d7666f531899a81ed1a2220e836b102b9dd8923a.mp3', 4, '2020-07-20 16:16:00', 0),
(4, 'Javascript', 'This is a nice course by Dr. Smith', '/Podcast/View/Admin/Uploads/d7b6e6bba49f5a21bdeebd05d1d3883df84b463f.jpg', '/Podcast/View/Admin/Podcast-files/03439087a403a86d12760a4dadb961d801db0820.mp3', 2, '2020-07-20 16:51:32', 0),
(5, 'Javascript', 'this is anice course', '/Podcast/View/Admin/Uploads/8b8b413946567e597e90f292e340da85e71eff96.jpg', '/Podcast/View/Admin/Podcast-files/982885b1855d6db9f846a8d8616600970ba20ea5.mp3', 2, '2020-07-20 16:52:36', 0),
(6, 'Beginner JAVA Class', 'This is a very good Beginner friendly JAVA Class', '/Podcast/View/Admin/Uploads/062df826a4ec324bde79225f2a3598a325b17040.png', '/Podcast/View/Admin/Podcast-files/5e62f54fe4d44575b3ad3e62fbf08fb024a75edc.mp3', 5, '2020-07-20 20:51:52', 0),
(7, 'This is,Yet another C# Course For Beginners', 'This is a good course for Beginners', '/Podcast/View/Admin/Uploads/1cf0e56446dc229cdc9d06c5307e1eb2ce2dcbc3.jpg', '/Podcast/View/Admin/Podcast-files/5ed332dd998afd2f7cdedec5475944f1a58b2a80.mp3', 6, '2020-07-21 07:50:27', 0),
(8, 'PHP:EPISODE 01', 'This course is a series.Stay stuned.', '/Podcast/View/Admin/Uploads/1518b54172e59fbcdbbecf087966b142a9ad9586.png', '/Podcast/View/Admin/Podcast-files/e6e1dd27748980a5f0614ea3247e556a7fc94925.mp3', 7, '2020-07-21 14:34:34', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `tag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `tag`) VALUES
(1, 'BOOTSTRAP'),
(2, 'Javascrpt'),
(3, 'Lesson'),
(4, 'Extra Lesson'),
(5, 'Java'),
(6, 'C#'),
(7, 'PHP');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pword` varchar(255) NOT NULL,
  `permission` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `pword`, `permission`) VALUES
(1, 'ajani_habeeb@yahoo.com', '$2y$10$vs4R4RR1PPkkU1MoXqCcSOu2wjjX0ThejY3r33UJppe.1aQTSSf8S', 1),
(2, 'podcast@gmail.com', '$2y$10$geidUgg87wPK47VrPiLfWOk.v3KVqZz13mV7EKe6jpxTvzoiu4/a2', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `podcasts`
--
ALTER TABLE `podcasts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `podcasts`
--
ALTER TABLE `podcasts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
