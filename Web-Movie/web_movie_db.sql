-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2024 at 09:33 PM
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
-- Database: `web_movie_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `MovieID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `TokenCost` int(11) NOT NULL,
  `ThumbnailURL` varchar(255) DEFAULT NULL,
  `MovieURL` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`MovieID`, `Title`, `Description`, `TokenCost`, `ThumbnailURL`, `MovieURL`) VALUES
(1, 'Ski Run', 'Best Ski Runner In Tunnel', 200, 'movies/thumbnails/ski run.png', 'movies/videos/ski run.MOV'),
(2, 'Motorbike Vs Bike', 'Hard competition between bike and motorbike', 200, 'movies/thumbnails/motor vs bike.png', 'movies/videos/motorbike vs bike.MOV'),
(3, 'Hill Run Competition', 'Hard hill climb with various options', 300, 'movies/thumbnails/hill run.png', 'movies/videos/hill run.MOV'),
(4, 'Downhill Bike Track', 'High adrenaline track with hard rocking biker', 250, 'movies/thumbnails/downhill bike.png', 'movies/videos/downhill track.MOV'),
(5, 'Dance Competition', 'This dude is just INSANE', 200, 'movies/thumbnails/dance competition.png', 'movies/videos/dance competition.MOV');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `PurchaseID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `MovieID` int(11) NOT NULL,
  `PurchaseDate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`PurchaseID`, `UserID`, `MovieID`, `PurchaseDate`) VALUES
(1, 1, 1, '2024-06-12 22:55:20'),
(2, 1, 1, '2024-06-12 23:15:35'),
(3, 3, 1, '2024-06-15 10:36:26');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `ReviewID` int(11) NOT NULL,
  `MovieID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `ReviewText` text DEFAULT NULL,
  `ReviewDate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`ReviewID`, `MovieID`, `UserID`, `Rating`, `ReviewText`, `ReviewDate`) VALUES
(1, 1, 1, 5, 'haha', '2024-06-12 23:30:16'),
(2, 1, 3, 2, 'good', '2024-06-15 10:39:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Tokens` int(11) DEFAULT 1000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `Tokens`) VALUES
(1, 'lior_king', '$2y$10$J080CJ.oVk9Z/x2LZtbok.MaVCDLlRBX52v5WJvq1EqDIDZi63HpO', 'lior@gmail.com', 600),
(2, 'lior', '$2y$10$fxlxvkIMOKcQ3JsmlQWgz.gihygCSn9v7kznzLid7/yFP/R6n1PZS', 'a@gmail.com', 1000),
(3, 'dodik', '$2y$10$DtvFKjcoEfLiCZ2rVzieZuG83n2Tq.M.BBIJGS1VJLtlujFfn/9nO', 'c@gmail.com', 1300);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`MovieID`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`PurchaseID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `MovieID` (`MovieID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `MovieID` (`MovieID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `MovieID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `PurchaseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`MovieID`) REFERENCES `movies` (`MovieID`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`MovieID`) REFERENCES `movies` (`MovieID`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
