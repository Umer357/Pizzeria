-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2024 at 06:05 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pizzeria`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `A_name` varchar(30) NOT NULL,
  `A_email` varchar(30) NOT NULL,
  `A_password` varchar(30) NOT NULL,
  `A_phone` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`A_name`, `A_email`, `A_password`, `A_phone`) VALUES
('admin', 'admin@gmail.com', 'admin', '0000000000');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `C_ID` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Phone` varchar(30) NOT NULL,
  `Delivery_address` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`C_ID`, `Name`, `Phone`, `Delivery_address`, `Email`, `Password`) VALUES
(1, 'me', '00000000000', 'xyz', 'me@gmail.com', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `mealorder`
--

CREATE TABLE `mealorder` (
  `Order_ID` int(30) NOT NULL,
  `Order_date_time` varchar(30) NOT NULL,
  `T_price` varchar(30) NOT NULL,
  `Status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mealorder`
--

INSERT INTO `mealorder` (`Order_ID`, `Order_date_time`, `T_price`, `Status`) VALUES
(6, '2024-04-25 20:32:36', '320', 'Pending'),
(7, '2024-04-25 20:49:32', '340', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE `meals` (
  `M_name` varchar(30) NOT NULL,
  `M_type` varchar(30) NOT NULL,
  `Ingredient` varchar(50) NOT NULL,
  `Price` varchar(30) NOT NULL,
  `M_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`M_name`, `M_type`, `Ingredient`, `Price`, `M_image`) VALUES
('Kunafa', 'Dessert', 'Akkawi, Butter, Cream, Sugar, Pistachios', '20 ', 'uploads/Kunafa.jpg'),
('Luqaimat', 'Dessert', 'Wheat flour, Yeast, Sugar, Salt', '20', 'uploads/Luqaimat.jpg'),
('Mirinda', 'Drink', 'Carbonated water, sugar, citric acid (E330), flavo', '60', 'uploads/mirinda.jpeg'),
('Neapolitan Pizza', 'Pizza', 'Dough, San Marzano tomatoes, buffalo mozzarella, b', '100', 'uploads/NeapolitanPizza.jpg'),
('Sicilian Pizza', 'Pizza', '\r\nDough, tomato sauce, mozzarella cheese, anchovie', '120', 'uploads/SicilianPizza.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart`
--

CREATE TABLE `shoppingcart` (
  `Quantity` varchar(30) NOT NULL,
  `Meal_name` varchar(30) NOT NULL,
  `Total_price` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`A_email`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`C_ID`);

--
-- Indexes for table `mealorder`
--
ALTER TABLE `mealorder`
  ADD PRIMARY KEY (`Order_ID`);

--
-- Indexes for table `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`M_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `C_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mealorder`
--
ALTER TABLE `mealorder`
  MODIFY `Order_ID` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
