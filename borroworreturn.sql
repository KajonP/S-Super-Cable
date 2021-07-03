-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2021 at 08:46 PM
-- Server version: 5.6.24
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_s_super_cable`
--

-- --------------------------------------------------------

--
-- Table structure for table `borroworreturn`
--

CREATE TABLE `borroworreturn` (
  `ID_BorrowOrReturn` int(10) NOT NULL,
  `ID_Promotion` int(10) NOT NULL,
  `Amount_BorrowOrReturn` int(10) NOT NULL COMMENT 'จำนวนที่ยืม/คืน',
  `Date_BorrowOrReturn` date NOT NULL COMMENT 'วันที่ยืม/คืน',
  `Detail_BorrowOrReturn` text COMMENT 'รายละเอียดที่ยืม/คืน',
  `ID_Employee` varchar(255) NOT NULL,
  `Type_BorrowOrReturn` int(1) NOT NULL COMMENT '1=ยืม,2=คืน',
  `Approve_BorrowOrReturn` int(1) NOT NULL COMMENT '0=รอ ,1=อนุมัติ ,2=ไม่'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borroworreturn`
--
ALTER TABLE `borroworreturn`
  ADD PRIMARY KEY (`ID_BorrowOrReturn`),
  ADD KEY `ID_Employee` (`ID_Employee`),
  ADD KEY `ID_Promotion` (`ID_Promotion`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borroworreturn`
--
ALTER TABLE `borroworreturn`
  MODIFY `ID_BorrowOrReturn` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borroworreturn`
--
ALTER TABLE `borroworreturn`
  ADD CONSTRAINT `borroworreturn_ibfk_1` FOREIGN KEY (`ID_Employee`) REFERENCES `employee` (`ID_Employee`),
  ADD CONSTRAINT `borroworreturn_ibfk_2` FOREIGN KEY (`ID_Promotion`) REFERENCES `promotion` (`ID_Promotion`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
