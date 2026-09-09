<?php
/**
 * controllers/ProductoController.php
 * ------------------------------------------------------------
 * CONTROLADOR: recibe las acciones del usuario (formularios, links)
 * y coordina la comunicación entre la Vista y el Modelo.
 * No contiene SQL ni HTML propio (salvo los mensajes cortos que
 * pasa a la vista).
 *
 * Rutas manejadas (todas pasan por este único archivo):
 *   ?accion=listar                 -> lista / busca productos
 *   ?accion=crear   (POST)         -> valida e inserta un producto
 *   ?accion=eliminar&id=N          -> elimina un producto
 * ------------------------------------------------------------
 */

require_once __DIR__ . '/../models/Producto.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$productoModelo = new Producto();
$accion = $_GET['accion'] ?? ($_POST['accion'] ?? 'listar');

switch ($accion) {

    case 'crear':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ../views/inventario/crear.php');
            exit;
        }

        // --- Validación en el servidor (nunca confiar solo en JavaScript) ---
        $errores = [];

        $nombre    = trim($_POST['nombre'] ?? '');
        $categoria = trim($_POST['categoria'] ?? '');
        $precio    = $_POST['precio'] ?? '';
        $cantidad  = $_POST['cantidad'] ?? '';
        $email     = trim($_POST['proveedor_email'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');

        $largoNombre = function_exists('mb_strlen') ? mb_strlen($nombre) : strlen($nombre);
        if ($nombre === '' || $largoNombre < 3) {
            $errores[] = 'El nombre del producto es obligatorio (mínimo 3 caracteres).';
        }
        if ($categoria === '') {
            $errores[] = 'Debes seleccionar una categoría.';
        }
        if ($precio === '' || !is_numeric($precio) || (float) $precio <= 0) {
            $errores[] = 'El precio debe ser un número mayor a 0.';
        }
        if ($cantidad === '' || !ctype_digit((string) $cantidad) || (int) $cantidad < 0) {
            $errores[] = 'La cantidad debe ser un número entero mayor o igual a 0.';
        }
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'El correo del proveedor no tiene un formato válido.';
        }

        if (!empty($errores)) {
            $_SESSION['errores']      = $errores;
            $_SESSION['datos_previos'] = $_POST;
            header('Location: ../views/inventario/crear.php');
            exit;
        }

        // --- Todo válido: delega la inserción al Modelo ---
        $productoModelo->insertar([
            'nombre'          => $nombre,
            'categoria'       => $categoria,
            'precio'          => $precio,
            'cantidad'        => $cantidad,
            'proveedor_email' => $email,
            'descripcion'     => $descripcion,
        ]);

        $_SESSION['mensaje'] = 'Producto registrado correctamente.';
        header('Location: ProductoController.php?accion=listar');
        exit;

    case 'eliminar':
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0 && $productoModelo->eliminar($id)) {
            $_SESSION['mensaje'] = 'Producto eliminado correctamente.';
        } else {
            $_SESSION['errores'] = ['No se pudo eliminar el producto indicado.'];
        }
        header('Location: ProductoController.php?accion=listar');
        exit;

    case 'listar':
    default:
        $busqueda  = trim($_GET['buscar'] ?? '');
        $productos = $productoModelo->obtenerTodos($busqueda);
        $totalProductos = $productoModelo->contarProductos();
        $valorInventario = $productoModelo->valorTotalInventario();

        // La Vista solo recibe datos ya listos para mostrar
        require __DIR__ . '/../views/inventario/listar.php';
        break;
}
