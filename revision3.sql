-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2024 at 12:44 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `revision3`
--

-- --------------------------------------------------------

--
-- Table structure for table `carrito`
--

CREATE TABLE `carrito` (
  `IdUsuario` int(10) NOT NULL,
  `IdProducto` int(10) NOT NULL,
  `Cantidad` int(10) NOT NULL,
  `FechaCarrito` date NOT NULL,
  `PrecioProducto` decimal(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `IdCategoria` int(10) NOT NULL,
  `DescripcionCategoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ciudad`
--

CREATE TABLE `ciudad` (
  `IdCiudad` int(10) NOT NULL,
  `NombreCiudad` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `direccion`
--

CREATE TABLE `direccion` (
  `IdDireccion` int(10) NOT NULL,
  `Calle` varchar(30) NOT NULL,
  `Colonia` varchar(30) NOT NULL,
  `IdCiudad` int(10) NOT NULL,
  `CodigoPostal` varchar(5) NOT NULL,
  `IdUsuario` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estadoventa`
--

CREATE TABLE `estadoventa` (
  `IdEstadoVenta` int(10) NOT NULL,
  `DescripcionEstadoVenta` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `metodoenvio`
--

CREATE TABLE `metodoenvio` (
  `IdMetodoEnvio` int(10) NOT NULL,
  `NombreEnvio` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `metodopago`
--

CREATE TABLE `metodopago` (
  `IdMetodoPago` int(10) NOT NULL,
  `NombrePago` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE `producto` (
  `IdProducto` int(10) NOT NULL,
  `NombreProducto` varchar(30) NOT NULL,
  `DescripcionProducto` varchar(50) DEFAULT NULL,
  `PrecioProducto` decimal(10,3) NOT NULL,
  `Categoria` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE `rol` (
  `IdRol` int(10) NOT NULL,
  `NombreRol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`IdRol`, `NombreRol`) VALUES
(1, 'Cliente'),
(2, 'Admnistrador');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `IdUsuario` int(10) NOT NULL,
  `NombreUsuario` varchar(50) NOT NULL,
  `CorreoUsuario` varchar(50) NOT NULL,
  `CelularUsuario` varchar(15) NOT NULL,
  `ContrasenaUsuario` varchar(64) NOT NULL,
  `IdRol` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`IdUsuario`, `NombreUsuario`, `CorreoUsuario`, `CelularUsuario`, `ContrasenaUsuario`, `IdRol`) VALUES
(1, 'Tristan Darian', 'tristan.amadorhnj@uanl.edu.mx', '8181192902', '4813494d137e1631bba301d5acab6e7bb7aa74ce1185d456565ef51d737677b2', 1),
(2, 'KR', 'anuel@trap.com', '8181192902', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuariometodopago`
--

CREATE TABLE `usuariometodopago` (
  `IdUsuarioMetodoPago` int(10) NOT NULL,
  `IdUsuario` int(10) NOT NULL,
  `IdMetodoPago` int(10) NOT NULL,
  `Proveedor` varchar(30) NOT NULL,
  `NumeroCuenta` char(16) NOT NULL,
  `FechaExpiracion` char(5) NOT NULL,
  `EsPredeterminada` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `venta`
--

CREATE TABLE `venta` (
  `IdVenta` int(10) NOT NULL,
  `FechaVenta` date NOT NULL,
  `VentaTotal` decimal(10,3) NOT NULL,
  `IdEstadoVenta` int(10) NOT NULL,
  `IdUsuario` int(10) NOT NULL,
  `IdMetodoPago` int(10) NOT NULL,
  `IdDireccion` int(10) NOT NULL,
  `IdMetodoEnvio` int(10) NOT NULL,
  `IVA` decimal(10,3) NOT NULL DEFAULT 0.000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ventadetalle`
--

CREATE TABLE `ventadetalle` (
  `IdVenta` int(10) NOT NULL,
  `IdProducto` int(10) NOT NULL,
  `CantidadVentaDetalle` int(10) NOT NULL,
  `PrecioProducto` decimal(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`IdUsuario`,`IdProducto`),
  ADD KEY `IdProducto` (`IdProducto`);

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`IdCategoria`);

--
-- Indexes for table `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`IdCiudad`);

--
-- Indexes for table `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`IdDireccion`),
  ADD KEY `IdCiudad` (`IdCiudad`),
  ADD KEY `FK_Direccion_Usuario` (`IdUsuario`);

--
-- Indexes for table `estadoventa`
--
ALTER TABLE `estadoventa`
  ADD PRIMARY KEY (`IdEstadoVenta`);

--
-- Indexes for table `metodoenvio`
--
ALTER TABLE `metodoenvio`
  ADD PRIMARY KEY (`IdMetodoEnvio`);

--
-- Indexes for table `metodopago`
--
ALTER TABLE `metodopago`
  ADD PRIMARY KEY (`IdMetodoPago`);

--
-- Indexes for table `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`IdProducto`),
  ADD KEY `Categoria` (`Categoria`);

--
-- Indexes for table `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`IdRol`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`IdUsuario`),
  ADD KEY `FK_Usuario_Rol` (`IdRol`);

--
-- Indexes for table `usuariometodopago`
--
ALTER TABLE `usuariometodopago`
  ADD PRIMARY KEY (`IdUsuarioMetodoPago`),
  ADD KEY `IdUsuario` (`IdUsuario`),
  ADD KEY `IdMetodoPago` (`IdMetodoPago`);

--
-- Indexes for table `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`IdVenta`),
  ADD KEY `IdEstadoVenta` (`IdEstadoVenta`),
  ADD KEY `IdUsuario` (`IdUsuario`),
  ADD KEY `IdMetodoPago` (`IdMetodoPago`),
  ADD KEY `IdDireccion` (`IdDireccion`),
  ADD KEY `IdMetodoEnvio` (`IdMetodoEnvio`);

--
-- Indexes for table `ventadetalle`
--
ALTER TABLE `ventadetalle`
  ADD PRIMARY KEY (`IdVenta`,`IdProducto`),
  ADD KEY `IdProducto` (`IdProducto`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `IdUsuario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usuariometodopago`
--
ALTER TABLE `usuariometodopago`
  MODIFY `IdUsuarioMetodoPago` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`IdUsuario`),
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`IdProducto`) REFERENCES `producto` (`IdProducto`);

--
-- Constraints for table `direccion`
--
ALTER TABLE `direccion`
  ADD CONSTRAINT `FK_Direccion_Usuario` FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`IdUsuario`),
  ADD CONSTRAINT `direccion_ibfk_1` FOREIGN KEY (`IdCiudad`) REFERENCES `ciudad` (`IdCiudad`);

--
-- Constraints for table `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`Categoria`) REFERENCES `categoria` (`IdCategoria`);

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_Usuario_Rol` FOREIGN KEY (`IdRol`) REFERENCES `rol` (`IdRol`);

--
-- Constraints for table `usuariometodopago`
--
ALTER TABLE `usuariometodopago`
  ADD CONSTRAINT `usuariometodopago_ibfk_1` FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`IdUsuario`),
  ADD CONSTRAINT `usuariometodopago_ibfk_2` FOREIGN KEY (`IdMetodoPago`) REFERENCES `metodopago` (`IdMetodoPago`);

--
-- Constraints for table `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`IdEstadoVenta`) REFERENCES `estadoventa` (`IdEstadoVenta`),
  ADD CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`IdUsuario`),
  ADD CONSTRAINT `venta_ibfk_3` FOREIGN KEY (`IdMetodoPago`) REFERENCES `metodopago` (`IdMetodoPago`),
  ADD CONSTRAINT `venta_ibfk_4` FOREIGN KEY (`IdDireccion`) REFERENCES `direccion` (`IdDireccion`),
  ADD CONSTRAINT `venta_ibfk_5` FOREIGN KEY (`IdMetodoEnvio`) REFERENCES `metodoenvio` (`IdMetodoEnvio`);

--
-- Constraints for table `ventadetalle`
--
ALTER TABLE `ventadetalle`
  ADD CONSTRAINT `ventadetalle_ibfk_1` FOREIGN KEY (`IdVenta`) REFERENCES `venta` (`IdVenta`),
  ADD CONSTRAINT `ventadetalle_ibfk_2` FOREIGN KEY (`IdProducto`) REFERENCES `producto` (`IdProducto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
