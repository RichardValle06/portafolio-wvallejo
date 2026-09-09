<?php
/**
 * models/Producto.php
 * ------------------------------------------------------------
 * MODELO: única capa que conoce y ejecuta sentencias SQL contra
 * la tabla `productos`. El controlador nunca escribe SQL directo;
 * siempre pasa por aquí.
 * ------------------------------------------------------------
 */

require_once __DIR__ . '/../config/conexion.php';

class Producto
{
    private PDO $db;

    public function __construct()
    {
        $this->db = obtenerConexion();
    }

    /** Inserta un nuevo producto. Devuelve el id generado. */
    public function insertar(array $datos): int
    {
        $sql = "INSERT INTO productos (nombre, categoria, precio, cantidad, proveedor_email, descripcion)
                VALUES (:nombre, :categoria, :precio, :cantidad, :proveedor_email, :descripcion)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nombre'          => $datos['nombre'],
            ':categoria'       => $datos['categoria'],
            ':precio'          => $datos['precio'],
            ':cantidad'        => $datos['cantidad'],
            ':proveedor_email' => $datos['proveedor_email'] ?: null,
            ':descripcion'     => $datos['descripcion'] ?: null,
        ]);

        return (int) $this->db->lastInsertId();
    }

    /** Devuelve todos los productos, opcionalmente filtrados por texto. */
    public function obtenerTodos(string $busqueda = ''): array
    {
        if ($busqueda !== '') {
            $sql = "SELECT * FROM productos
                    WHERE nombre LIKE :buscar OR categoria LIKE :buscar
                    ORDER BY id DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':buscar' => '%' . $busqueda . '%']);
        } else {
            $sql = "SELECT * FROM productos ORDER BY id DESC";
            $stmt = $this->db->query($sql);
        }

        return $stmt->fetchAll();
    }

    /** Devuelve un producto por su id (útil para editar). */
    public function obtenerPorId(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $fila = $stmt->fetch();
        return $fila ?: null;
    }

    /** Elimina un producto por id. Devuelve true si eliminó una fila. */
    public function eliminar(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    /** Totales rápidos para el panel principal. */
    public function contarProductos(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) AS total FROM productos")->fetch()['total'];
    }

    public function valorTotalInventario(): float
    {
        $r = $this->db->query("SELECT SUM(precio * cantidad) AS valor FROM productos")->fetch();
        return (float) ($r['valor'] ?? 0);
    }
}
