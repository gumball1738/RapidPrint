-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2025 at 02:37 PM
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
-- Database: `rapidprintdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `AdminID` int(50) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`AdminID`, `username`, `email`, `password`) VALUES
(1, 'aiman', 'aiman@gmail.com', '321');

-- --------------------------------------------------------

--
-- Table structure for table `bonus`
--

CREATE TABLE `bonus` (
  `BonusID` int(50) NOT NULL,
  `StaffID` int(50) NOT NULL,
  `bonusReward` int(20) NOT NULL,
  `AdminID` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bonus`
--

INSERT INTO `bonus` (`BonusID`, `StaffID`, `bonusReward`, `AdminID`) VALUES
(1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `BranchID` int(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `manager` varchar(255) NOT NULL,
  `contact` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`BranchID`, `name`, `address`, `manager`, `contact`) VALUES
(1, 'KOOP UMPSA PEKAN', 'Universiti Malaysia Pahang\r\nAl-Sultan Abdullah\r\n26600 Pekan\r\nPahang, Malaysia', 'Nasrul', '01112175797'),
(2, 'KOOP UMPSA GAMBANG', 'Universiti Malaysia Pahang\r\nAl-Sultan Abdullah\r\nLebuh Persiaran Tun Khalil Yaakob\r\n26300, Kuantan\r\nPahang, Malaysia', 'Adham', '609 431 5000');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerID` int(3) NOT NULL,
  `membershipStatus` varchar(10) NOT NULL,
  `MembershipID` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phoneNumber` varchar(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerID`, `membershipStatus`, `MembershipID`, `username`, `password`, `email`, `phoneNumber`, `file`, `file_path`, `status`) VALUES
(8, '', 0, 'cdd', '123', 'amiralariff9716@gmail.com', '0174286054', 'uploads/file_677dc5457abda4.14355871.pdf', '', 'verified'),
(12, '', 0, 'zul', '123', 'amiralariff97122@gmail.com', '0174286032', 'uploads/file_677dcc4b4d02a0.45204879.pdf', '', 'verified'),
(13, '', 0, 'CAA', '123', 'amiralariff2197@gmail.com', '', '', '', ''),
(14, '', 0, 'ca', 'ca123', 'ca22026@gmail.com', '', 'uploads/file_677e2e2210d818.18445289.pdf', '', 'verified');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `InvoiceID` int(3) NOT NULL,
  `OrderID` int(3) NOT NULL,
  `StaffID` int(3) NOT NULL,
  `amount` int(11) NOT NULL,
  `dateGenerated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE `membership` (
  `MembershipID` int(10) NOT NULL,
  `MembershipPoint` int(255) NOT NULL,
  `membershipStatus` varchar(10) NOT NULL,
  `pointsEarned` int(10) NOT NULL,
  `moneyBalance` int(10) NOT NULL,
  `QRid` varchar(5) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `totalPoint` int(255) NOT NULL,
  `createdAt` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`MembershipID`, `MembershipPoint`, `membershipStatus`, `pointsEarned`, `moneyBalance`, `QRid`, `username`, `password`, `totalPoint`, `createdAt`) VALUES
(1, 157, 'Active', 0, 14, '0', 'Fawas', 'fawas123', 5, '2025-01-08'),
(2, 150, 'Active', 20, 80, '0', 'kamal', 'kamal123', 130, '2025-02-18'),
(3, 270, 'Active', 30, 90, '0', 'adli', 'adli123', 97, '2025-03-20'),
(7, 0, 'active', 0, 0, '', 'cd', '123', 0, '2025-01-08'),
(8, 0, 'active', 0, 10, '', 'cdd', '123', 0, '2025-01-08'),
(9, 0, 'active', 0, 0, '', 'zul', '123', 0, '2025-01-08'),
(10, 0, 'active', 0, 10, '', 'ca', 'ca123', 0, '2025-01-08');

-- --------------------------------------------------------

--
-- Table structure for table `orderline`
--

CREATE TABLE `orderline` (
  `OrderlineID` int(3) NOT NULL,
  `PackageID` int(3) NOT NULL,
  `OrderID` int(3) NOT NULL,
  `quantity` int(20) NOT NULL,
  `totalPrice` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(3) NOT NULL,
  `CustomerID` int(3) NOT NULL,
  `MembershipID` int(3) NOT NULL,
  `StaffID` int(3) NOT NULL,
  `pointEarned` int(11) NOT NULL,
  `InvoiceID` int(3) NOT NULL,
  `totalPrice` decimal(10,2) NOT NULL,
  `size` varchar(2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `pagePerSheet` int(11) NOT NULL,
  `document` varchar(255) NOT NULL,
  `request` text NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `color` varchar(10) NOT NULL,
  `orderStatus` varchar(10) NOT NULL,
  `PackageID` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `CustomerID`, `MembershipID`, `StaffID`, `pointEarned`, `InvoiceID`, `totalPrice`, `size`, `quantity`, `pagePerSheet`, `document`, `request`, `createdAt`, `color`, `orderStatus`, `PackageID`, `price`) VALUES
(5, 15, 0, 301, 0, 0, 0.20, 'A4', 2, 6, '', 'binding', '2025-01-08 01:32:49', 'color', 'collected', 0, 0.20),
(6, 15, 0, 0, 0, 0, 0.40, 'A4', 2, 20, 'Gmail - The Third Monthly Executive Committee Meeting.pdf', '0', '2025-01-08 01:35:34', 'color', 'collected', 0, 0.20),
(7, 16, 0, 1, 0, 0, 11.00, 'A3', 22, 20, 'Lab Assignment 3.pdf', '0', '2025-01-08 01:38:11', 'grayscale', 'accepted', 0, 0.50),
(8, 16, 0, 0, 0, 0, 11.00, 'A3', 22, 20, 'Lab Assignment 3.pdf', '0', '2025-01-08 01:40:51', 'grayscale', 'To Pay', 0, 0.50),
(9, 21, 0, 0, 0, 0, 1.00, 'A3', 2, 20, 'LAB2_CD22026 (2).pdf', '0', '2025-01-08 01:41:07', 'grayscale', 'To Pay', 0, 0.50),
(10, 21, 0, 0, 0, 0, 1.00, 'A3', 2, 20, 'LAB2_CD22026 (2).pdf', '0', '2025-01-08 01:43:01', 'grayscale', 'To Pay', 0, 0.50),
(13, 11, 0, 0, 0, 0, 1.00, 'A3', 2, 111, 'LAB2_CD22026 (2).pdf', '0', '2025-01-08 01:45:38', 'color', 'To Pay', 0, 0.50),
(14, 12, 0, 0, 0, 0, 11.00, 'A3', 22, 20, 'DNS PROJECT PROGRESSION.pdf', '0', '2025-01-08 01:45:55', 'grayscale', 'To Pay', 0, 0.50),
(16, 14, 0, 301, 0, 0, 0.00, '', 0, 0, 'DNS PROJECT PROGRESSION.pdf', '0', '0000-00-00 00:00:00', 'grayscale', 'accepted', 0, 0.50),
(17, 15, 0, 1, 0, 0, 13.00, 'A4', 21, 1, 'DNS PROJECT PROGRESSION.pdf', '0', '2025-01-08 01:45:55', 'grayscale', 'collected', 0, 0.50),
(18, 16, 0, 1, 0, 0, 73.00, 'A4', 21, 1, 'DNS PROJECT PROGRESSION.pdf', '0', '2025-02-06 01:45:55', 'grayscale', 'Ordered', 0, 0.50),
(19, 17, 0, 1, 0, 0, 45.00, 'A4', 21, 1, 'DNS PROJECT PROGRESSION.pdf', '0', '2025-03-19 01:45:55', 'grayscale', 'Ordered', 0, 0.50),
(20, 15, 0, 0, 0, 0, 87.00, 'A3', 2, 20, 'BCS2243_Project Instruction_SEM I_2024_25 (2).pdf', '0', '2025-04-17 04:12:53', 'color', 'collected', 0, 0.50),
(21, 15, 0, 0, 0, 0, 29.00, 'A3', 2, 20, 'BCS2243_Project Instruction_SEM I_2024_25 (2).pdf', '0', '2025-05-15 04:24:05', 'color', 'collected', 0, 0.50),
(22, 15, 0, 0, 0, 0, 56.00, 'A3', 2, 20, 'BCS2243_Project Instruction_SEM I_2024_25 (2).pdf', '123', '2025-06-26 04:24:28', 'color', 'collected', 0, 0.50),
(23, 15, 0, 0, 0, 0, 14.00, 'A3', 2, 20, 'BCS2243_Project Instruction_SEM I_2024_25 (2).pdf', '12', '2025-07-22 04:24:51', 'color', 'collected', 0, 0.50),
(24, 15, 0, 0, 0, 0, 92.00, 'A3', 2, 20, 'BCS2243_Project Instruction_SEM I_2024_25 (2).pdf', '12 qiasd', '2025-08-14 04:25:49', 'color', 'collected', 0, 0.50);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PaymentID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `paymentMethod` int(11) NOT NULL,
  `paymentStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`PaymentID`, `OrderID`, `paymentMethod`, `paymentStatus`) VALUES
(0, 4, 0, 0),
(0, 20, 0, 0),
(0, 5, 0, 0),
(0, 7, 0, 0),
(0, 7, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `printing_packages`
--

CREATE TABLE `printing_packages` (
  `PackageID` int(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('Active','Suspended','','') NOT NULL,
  `quantity` int(50) NOT NULL,
  `totalPrice` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `printing_packages`
--

INSERT INTO `printing_packages` (`PackageID`, `name`, `description`, `price`, `status`, `quantity`, `totalPrice`) VALUES
(1, 'A3', 'A3 Paper Size', 6.40, 'Active', 0, 0),
(2, 'A4', 'A4 Paper Size', 2.00, 'Active', 0, 0),
(3, 'A5', 'A5 Paper Size', 15.20, 'Active', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `StaffID` int(50) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `monthlySale` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`StaffID`, `username`, `email`, `password`, `monthlySale`) VALUES
(301, 'yasmin', 'yasmin@gmail.com', '123', 442),
(302, 'fadaly', 'fadaly@gmail.com', '123', 280),
(303, 'adnan', 'adnan@gmail.com', '123', 350),
(304, 'azami', 'azami@gmail.com', '123', 450);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `bonus`
--
ALTER TABLE `bonus`
  ADD PRIMARY KEY (`BonusID`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`BranchID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`InvoiceID`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`MembershipID`);

--
-- Indexes for table `orderline`
--
ALTER TABLE `orderline`
  ADD PRIMARY KEY (`OrderlineID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `printing_packages`
--
ALTER TABLE `printing_packages`
  ADD PRIMARY KEY (`PackageID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`StaffID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `AdminID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bonus`
--
ALTER TABLE `bonus`
  MODIFY `BonusID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `BranchID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `InvoiceID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `membership`
--
ALTER TABLE `membership`
  MODIFY `MembershipID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orderline`
--
ALTER TABLE `orderline`
  MODIFY `OrderlineID` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `printing_packages`
--
ALTER TABLE `printing_packages`
  MODIFY `PackageID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `StaffID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=305;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
