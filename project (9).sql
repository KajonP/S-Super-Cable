-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2021 at 08:23 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `award`
--

CREATE TABLE `award` (
  `ID_Award` int(10) NOT NULL,
  `Tittle_Award` varchar(255) NOT NULL,
  `Picture_Award` text NOT NULL,
  `Date_Award` datetime NOT NULL,
  `ID_Employee` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `ID_Company` int(10) NOT NULL,
  `Name_Company` varchar(255) NOT NULL,
  `Address_Company` text NOT NULL,
  `Tel_Company` int(10) NOT NULL,
  `Email_Company` text NOT NULL,
  `Tax_Number__Company` int(13) NOT NULL,
  `Credit_Limit_Company` int(10) NOT NULL,
  `Credit_Term_Company` varchar(255) NOT NULL,
  `Cluster_Shop` varchar(255) NOT NULL,
  `Contact_Name_Company` text DEFAULT NULL,
  `IS_Blacklist` tinyint(1) NOT NULL,
  `Cause_Blacklist` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `ID_Employee` varchar(255) NOT NULL,
  `Name_Employee` varchar(255) NOT NULL,
  `Surname_Employee` varchar(255) NOT NULL,
  `Username_Employee` text NOT NULL,
  `Password_Employee` text NOT NULL,
  `Email_Employee` text NOT NULL,
  `Picuture_Employee` text NOT NULL,
  `User_Status_Employee` enum('Admin','Sales','User','') NOT NULL,
  `ID_Company` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `ID_File` int(10) NOT NULL,
  `Name_File` varchar(255) NOT NULL,
  `Path_File` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `goods`
--

CREATE TABLE `goods` (
  `ID_Goods` int(10) NOT NULL,
  `Name_Goods` varchar(255) NOT NULL,
  `Picture_Goods` text NOT NULL,
  `Price_Goods` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `ID_Message` int(10) NOT NULL,
  `Tittle_Message` varchar(255) NOT NULL,
  `Text_Message` text NOT NULL,
  `Picture_Message` text NOT NULL,
  `Date_Message` datetime NOT NULL,
  `ID_Employee` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `promotion`
--

CREATE TABLE `promotion` (
  `ID_Promotion` int(10) NOT NULL,
  `Name_Promotion` varchar(255) NOT NULL,
  `Unit_Promotion` int(10) NOT NULL,
  `Date_Promotion` date NOT NULL,
  `Price_Unit_Promotion` double NOT NULL,
  `Note_Promotion` text NOT NULL,
  `ID_Employee` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `ID_Excel` int(10) NOT NULL,
  `Date_Sales` date NOT NULL,
  `ID_Company` int(10) NOT NULL,
  `ID_Employee` varchar(255) NOT NULL,
  `Result_Sales` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `zone`
--

CREATE TABLE `zone` (
  `ID_Zone` int(10) NOT NULL,
  `Name_Zone` varchar(255) NOT NULL,
  `ID_Employee` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `award`
--
ALTER TABLE `award`
  ADD PRIMARY KEY (`ID_Award`),
  ADD KEY `ID_Employee` (`ID_Employee`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`ID_Company`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`ID_Employee`),
  ADD KEY `ID_Company` (`ID_Company`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`ID_File`);

--
-- Indexes for table `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`ID_Goods`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`ID_Message`),
  ADD UNIQUE KEY `ID_Employee` (`ID_Employee`);

--
-- Indexes for table `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`ID_Promotion`),
  ADD KEY `ID_Employee` (`ID_Employee`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`ID_Excel`),
  ADD KEY `ID_Employee` (`ID_Employee`),
  ADD KEY `ID_Customer` (`ID_Company`);

--
-- Indexes for table `zone`
--
ALTER TABLE `zone`
  ADD PRIMARY KEY (`ID_Zone`),
  ADD KEY `ID_Employee` (`ID_Employee`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `award`
--
ALTER TABLE `award`
  MODIFY `ID_Award` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `ID_Company` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `ID_File` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `goods`
--
ALTER TABLE `goods`
  MODIFY `ID_Goods` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `ID_Message` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotion`
--
ALTER TABLE `promotion`
  MODIFY `ID_Promotion` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `ID_Excel` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zone`
--
ALTER TABLE `zone`
  MODIFY `ID_Zone` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `award`
--
ALTER TABLE `award`
  ADD CONSTRAINT `award_ibfk_1` FOREIGN KEY (`ID_Employee`) REFERENCES `employee` (`ID_Employee`);

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `company_ibfk_1` FOREIGN KEY (`ID_Company`) REFERENCES `sales` (`ID_Company`);

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`ID_Company`) REFERENCES `company` (`ID_Company`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`ID_Employee`) REFERENCES `employee` (`ID_Employee`);

--
-- Constraints for table `promotion`
--
ALTER TABLE `promotion`
  ADD CONSTRAINT `promotion_ibfk_1` FOREIGN KEY (`ID_Employee`) REFERENCES `employee` (`ID_Employee`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`ID_Employee`) REFERENCES `employee` (`ID_Employee`);

--
-- Constraints for table `zone`
--
ALTER TABLE `zone`
  ADD CONSTRAINT `zone_ibfk_1` FOREIGN KEY (`ID_Employee`) REFERENCES `employee` (`ID_Employee`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
