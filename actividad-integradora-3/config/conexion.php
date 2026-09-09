<?php
/**
 * config/conexion.php
 * ------------------------------------------------------------
 * Archivo independiente de conexión a MySQL (requisito punto 4).
 *
 * Uso LOCAL (XAMPP / WAMP / Laragon) — cumple la consigna tal cual
 * ("usuario: root; sin clave"):
 *   DB_HOST = 'localhost'
 *   DB_USER = 'root'
 *   DB_PASS = ''
 *   DB_NAME = 'integradora'
 *
 * Uso en cPanel (si luego subes el proyecto a un hosting):
 * cPanel NO da acceso a root. Debes crear ahí una base de datos y
 * un usuario MySQL desde "MySQL Databases", y cPanel les pondrá
 * automáticamente el prefijo de tu cuenta, por ejemplo:
 *   DB_HOST = 'localhost'                 (casi siempre, dentro del mismo hosting)
 *   DB_USER = 'tucuenta_usuarioinventario'
 *   DB_PASS = 'la_clave_que_definiste_en_cPanel'
 *   DB_NAME = 'tucuenta_integradora'
 * Solo cambia las 4 constantes de abajo; el resto del proyecto no
 * necesita tocarse.
 * ------------------------------------------------------------
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'integradora');

function obtenerConexion(): PDO
{
    static $conexion = null;

    if ($conexion === null) {
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
            $conexion = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die('Error de conexión a la base de datos: ' . $e->getMessage());
        }
    }

    return $conexion;
}
