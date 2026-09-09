<?php
/**
 * views/inventario/listar.php
 * ------------------------------------------------------------
 * VISTA: recibe del controlador $productos, $totalProductos,
 * $valorInventario y $busqueda ya listos; solo se encarga de
 * mostrarlos en HTML.
 * ------------------------------------------------------------
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$mensaje = $_SESSION['mensaje'] ?? null;
$errores = $_SESSION['errores'] ?? [];
unset($_SESSION['mensaje'], $_SESSION['errores']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario — Consulta de productos</title>
    <link rel="stylesheet" href="../../css/estilos.css">
</head>
<body>

<header class="app-header">
    <div class="app-header__marca">📦 Inventario Básico</div>
    <nav class="app-header__nav">
        <a href="../../index.php">Inicio</a>
        <a class="activo" href="../../controllers/ProductoController.php?accion=listar">Ver inventario</a>
        <a href="../views/inventario/crear.php">Registrar producto</a>
    </nav>
</header>

<main class="contenedor">

    <?php if ($mensaje): ?>
        <div class="alerta alerta--exito"><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    <?php if (!empty($errores)): ?>
        <div class="alerta alerta--error"><?= htmlspecialchars($errores[0], ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="resumen">
        <div class="resumen__tarjeta">
            <span class="resumen__valor"><?= (int) $totalProductos ?></span>
            <span class="resumen__etiqueta">Productos registrados</span>
        </div>
        <div class="resumen__tarjeta">
            <span class="resumen__valor">$<?= number_format($valorInventario, 2) ?></span>
            <span class="resumen__etiqueta">Valor total del inventario</span>
        </div>
    </div>

    <div class="tarjeta">
        <div class="tarjeta__encabezado">
            <span class="tarjeta__icono">📋</span>
            <h1>Consulta de registros</h1>
        </div>

        <form action="../../controllers/ProductoController.php" method="GET" class="form-busqueda">
            <input type="hidden" name="accion" value="listar">
            <input type="text" name="buscar" placeholder="Buscar por nombre o categoría..."
                   value="<?= htmlspecialchars($busqueda, ENT_QUOTES, 'UTF-8') ?>">
            <button type="submit" class="boton boton--secundario">🔍 Buscar</button>
            <?php if ($busqueda !== ''): ?>
                <a class="boton boton--enlace" href="../../controllers/ProductoController.php?accion=listar">Limpiar</a>
            <?php endif; ?>
        </form>

        <div class="tabla-responsive">
            <table class="tabla-datos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Proveedor</th>
                        <th>Registrado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($productos)): ?>
                        <tr>
                            <td colspan="8" class="tabla-datos__vacio">No hay productos que coincidan con la búsqueda.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($productos as $p): ?>
                            <tr>
                                <td><?= (int) $p['id'] ?></td>
                                <td><?= htmlspecialchars($p['nombre'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><span class="etiqueta-categoria"><?= htmlspecialchars($p['categoria'], ENT_QUOTES, 'UTF-8') ?></span></td>
                                <td>$<?= number_format((float) $p['precio'], 2) ?></td>
                                <td><?= (int) $p['cantidad'] ?></td>
                                <td><?= $p['proveedor_email'] ? htmlspecialchars($p['proveedor_email'], ENT_QUOTES, 'UTF-8') : '—' ?></td>
                                <td><?= htmlspecialchars(date('d/m/Y', strtotime($p['fecha_registro'])), ENT_QUOTES, 'UTF-8') ?></td>
                                <td>
                                    <a class="boton boton--secundario boton--pequeno"
                                       href="../../controllers/ProductoController.php?accion=editar&id=<?= (int) $p['id'] ?>">✏️ Editar</a>
                                    <a class="boton boton--peligro boton--pequeno"
                                       href="../../controllers/ProductoController.php?accion=eliminar&id=<?= (int) $p['id'] ?>"
                                       onclick="return confirm('¿Eliminar este producto del inventario?');">🗑️ Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

</body>
</html>
