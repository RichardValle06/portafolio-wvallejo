-- ============================================================
-- Proyecto: Inventario Básico (Actividad Integradora 3)
-- Base de datos: integradora
-- Motor: MySQL / MariaDB
-- ============================================================

-- Fuerza la codificación de la sesión a UTF-8: evita que las tildes
-- y la "ñ" se corrompan al importar este archivo (p. ej. desde la
-- línea de comandos o desde phpMyAdmin con otro charset por defecto).
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS integradora
    CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE integradora;

CREATE TABLE IF NOT EXISTS productos (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    nombre          VARCHAR(150)   NOT NULL,
    categoria       VARCHAR(100)   NOT NULL,
    precio          DECIMAL(10,2)  NOT NULL,
    cantidad        INT            NOT NULL,
    proveedor_email VARCHAR(150)   NULL,
    descripcion     TEXT           NULL,
    fecha_registro  DATETIME       DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Datos de ejemplo (opcional, puedes borrar estas filas)
INSERT INTO productos (nombre, categoria, precio, cantidad, proveedor_email, descripcion) VALUES
('Mouse óptico USB',        'Tecnología', 8.50,  25, 'ventas@perifericos.com', 'Mouse óptico con cable USB, 3 botones.'),
('Teclado mecánico',        'Tecnología', 32.00, 10, 'ventas@perifericos.com', 'Teclado mecánico switch azul, retroiluminado.'),
('Cuaderno universitario',  'Papelería',  1.75,  80, NULL,                     '100 hojas, cuadriculado.'),
('Silla de oficina',        'Mobiliario', 65.00, 5,  'contacto@mueblesya.com', 'Silla ergonómica con soporte lumbar.');
