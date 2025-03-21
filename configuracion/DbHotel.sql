CREATE DATABASE DBHOTEL;
USE DBHOTEL;

CREATE TABLE IF NOT EXISTS `Personas` (
    `dni` varchar(9) NOT NULL UNIQUE,
    `nombres` varchar(25) NOT NULL,
    `apellidos` varchar(25) NOT NULL,
    `direccion` varchar(100),
    `celular` varchar(15),
    `correo` varchar(30),
    PRIMARY KEY (`dni`)
);

CREATE TABLE IF NOT EXISTS `Roles` (
    `id_rol` int AUTO_INCREMENT NOT NULL UNIQUE,
    `cargo` varchar(20) NOT NULL,
    PRIMARY KEY (`id_rol`)
);

CREATE TABLE IF NOT EXISTS `Estados` (
    `id_estado` int AUTO_INCREMENT NOT NULL UNIQUE,
    `nom_estado` varchar(10) NOT NULL,
    PRIMARY KEY (`id_estado`)
);

CREATE TABLE IF NOT EXISTS `Usuarios` (
    `id_usuario` int AUTO_INCREMENT NOT NULL UNIQUE,
    `usuario` varchar(20) NOT NULL,
    `password` varchar(32) NOT NULL,
    `fk_idrol` int NOT NULL,
    `fk_dni` VARCHAR(9) NOT NULL,
    `fk_id_estado` int NOT NULL DEFAULT '1',
    PRIMARY KEY (`id_usuario`),
    FOREIGN KEY (`fk_idrol`) REFERENCES `Roles`(`id_rol`),
    FOREIGN KEY (`fk_dni`) REFERENCES `Personas`(`dni`),
    FOREIGN KEY (`fk_id_estado`) REFERENCES `Estados`(`id_estado`)
);

CREATE TABLE IF NOT EXISTS `Turnos` (
    `id_turno` int AUTO_INCREMENT NOT NULL UNIQUE,
    `nombre_turno` varchar(10) NOT NULL,
    `hora_entrada` time NOT NULL,
    `hora_salida` time NOT NULL,
    PRIMARY KEY (`id_turno`)
);

CREATE TABLE IF NOT EXISTS `Asistencias` (
    `id_asistencia` int AUTO_INCREMENT NOT NULL UNIQUE,
    `nombre_asistencia` varchar(15) NOT NULL,
    PRIMARY KEY (`id_asistencia`)
);

CREATE TABLE IF NOT EXISTS `Detalles_Horario` (
    `fk_id_usuario` int NOT NULL,
    `fk_id_turno` int NOT NULL,
    `fecha` date NOT NULL,
    `fk_id_asistencia` int NOT NULL,
    FOREIGN KEY (`fk_id_usuario`) REFERENCES `Usuarios`(`id_usuario`),
    FOREIGN KEY (`fk_id_turno`) REFERENCES `Turnos`(`id_turno`),
    FOREIGN KEY (`fk_id_asistencia`) REFERENCES `Asistencias`(`id_asistencia`)
);

CREATE TABLE IF NOT EXISTS `Clientes` (
    `id_cliente` int AUTO_INCREMENT NOT NULL UNIQUE,
    `fk_dni` VARCHAR(9) NOT NULL,
    PRIMARY KEY (`id_cliente`),
    FOREIGN KEY (`fk_dni`) REFERENCES `Personas`(`dni`)
);

CREATE TABLE IF NOT EXISTS `Tipo_Habitacion` (
    `id_tipo` int AUTO_INCREMENT NOT NULL UNIQUE,
    `nom_tipo` varchar(20) NOT NULL,
    PRIMARY KEY (`id_tipo`)
);

CREATE TABLE IF NOT EXISTS `Estado_Habitacion` (
    `id_estado_habitacion` int AUTO_INCREMENT NOT NULL UNIQUE,
    `nombre_estado` varchar(20) NOT NULL,
    PRIMARY KEY (`id_estado_habitacion`)
);

CREATE TABLE IF NOT EXISTS `Habitaciones` (
    `id_habitacion` int AUTO_INCREMENT NOT NULL UNIQUE,
    `numero_habitacion` int NOT NULL,
    `descripcion` text NOT NULL,
    `fk_id_tipo` int NOT NULL,
    `fk_id_estado_habitacion` int NOT NULL,
    PRIMARY KEY (`id_habitacion`),
    FOREIGN KEY (`fk_id_tipo`) REFERENCES `Tipo_Habitacion`(`id_tipo`),
    FOREIGN KEY (`fk_id_estado_habitacion`) REFERENCES `Estado_Habitacion`(`id_estado_habitacion`)
);

CREATE TABLE IF NOT EXISTS `Reservas` (
    `id_reserva` int AUTO_INCREMENT NOT NULL UNIQUE,
    `fk_id_cliente` int NOT NULL,
    `fk_id_usuario` int NOT NULL,
    `fk_id_habitacion` int NOT NULL,
    `precio` decimal(10,2) NOT NULL,
    `fecha_inicio` date NOT NULL,
    `fecha_salida` date NOT NULL,
    PRIMARY KEY (`id_reserva`),
    FOREIGN KEY (`fk_id_cliente`) REFERENCES `Clientes`(`id_cliente`),
    FOREIGN KEY (`fk_id_usuario`) REFERENCES `Usuarios`(`id_usuario`),
    FOREIGN KEY (`fk_id_habitacion`) REFERENCES `Habitaciones`(`id_habitacion`)
);

CREATE TABLE IF NOT EXISTS `Tipos_Pago` (
    `id_tipo_pago` int AUTO_INCREMENT NOT NULL UNIQUE,
    `nombre_tipo` varchar(20) NOT NULL,
    PRIMARY KEY (`id_tipo_pago`)
);

CREATE TABLE IF NOT EXISTS `Detalle_Pago` (
    `fk_id_reserva` int NOT NULL,
    `fk_id_tipo_pago` int NOT NULL,
    `fecha_pago` datetime NOT NULL,
    `monto` decimal(10,2) NOT NULL,
    FOREIGN KEY (`fk_id_reserva`) REFERENCES `Reservas`(`id_reserva`),
    FOREIGN KEY (`fk_id_tipo_pago`) REFERENCES `Tipos_Pago`(`id_tipo_pago`)
);