<?php
/**
 * views/inventario/editar.php
 * ------------------------------------------------------------
 * VISTA: formulario de edición. Recibe $producto ya cargado por
 * el controlador (accion=editar) y, si hubo un error de
 * validación en el intento de actualizar, los datos que el
 * usuario había escrito para no hacerle perder lo ya tipeado.
 * ------------------------------------------------------------
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$errores      = $_SESSION['errores'] ?? [];
$datosPrevios = $_SESSION['datos_previos'] ?? $producto;
unset($_SESSION['errores'], $_SESSION['datos_previos']);

function valorCampo(array $datos, string $campo): string
{
    return htmlspecialchars($datos[$campo] ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar producto — Inventario Básico</title>
    <link rel="stylesheet" href="../../css/estilos.css">
</head>
<body>

<header class="app-header">
    <div class="app-header__marca">📦 Inventario Básico</div>
    <nav class="app-header__nav">
        <a href="../../index.php">Inicio</a>
        <a href="../../controllers/ProductoController.php?accion=listar">Ver inventario</a>
        <a href="../views/inventario/crear.php">Registrar producto</a>
    </nav>
</header>

<main class="contenedor">
    <div class="tarjeta tarjeta--formulario">
        <div class="tarjeta__encabezado">
            <span class="tarjeta__icono">✏️</span>
            <h1>Editar producto #<?= (int) $producto['id'] ?></h1>
        </div>

        <?php if (!empty($errores)): ?>
            <div class="alerta alerta--error">
                <strong>Revisa lo siguiente:</strong>
                <ul>
                    <?php foreach ($errores as $err): ?>
                        <li><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form id="form-producto"
              action="../../controllers/ProductoController.php?accion=actualizar"
              method="POST" novalidate>

            <input type="hidden" name="id" value="<?= (int) $producto['id'] ?>">

            <div class="campo">
                <label for="nombre">🛍️ Nombre del producto</label>
                <input type="text" id="nombre" name="nombre" maxlength="150"
                       value="<?= valorCampo($datosPrevios, 'nombre') ?>">
                <small class="campo__error" id="err-nombre"></small>
            </div>

            <div class="campo">
                <label for="categoria">🗂️ Categoría</label>
                <select id="categoria" name="categoria">
                    <?php
                    $categorias = ['Tecnología', 'Papelería', 'Mobiliario', 'Limpieza', 'Alimentos', 'Otros'];
                    $seleccionada = $datosPrevios['categoria'] ?? '';
                    foreach ($categorias as $cat) {
                        $sel = ($seleccionada === $cat) ? 'selected' : '';
                        echo "<option value=\"$cat\" $sel>$cat</option>";
                    }
                    ?>
                </select>
                <small class="campo__error" id="err-categoria"></small>
            </div>

            <div class="campo">
                <label for="precio">🏷️ Precio (USD)</label>
                <input type="text" id="precio" name="precio"
                       value="<?= valorCampo($datosPrevios, 'precio') ?>">
                <small class="campo__error" id="err-precio"></small>
            </div>

            <div class="campo">
                <label for="cantidad">📦 Cantidad en stock</label>
                <input type="text" id="cantidad" name="cantidad"
                       value="<?= valorCampo($datosPrevios, 'cantidad') ?>">
                <small class="campo__error" id="err-cantidad"></small>
            </div>

            <div class="campo">
                <label for="proveedor_email">✉️ Correo del proveedor (opcional)</label>
                <input type="text" id="proveedor_email" name="proveedor_email"
                       value="<?= valorCampo($datosPrevios, 'proveedor_email') ?>">
                <small class="campo__error" id="err-email"></small>
            </div>

            <div class="campo">
                <label for="descripcion">🧾 Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4"><?= valorCampo($datosPrevios, 'descripcion') ?></textarea>
            </div>

            <button type="submit" class="boton boton--primario">💾 Guardar cambios</button>
            <a href="../../controllers/ProductoController.php?accion=listar" class="boton boton--enlace">Cancelar</a>
        </form>
    </div>
</main>

<script src="../../js/script.js"></script>
</body>
</html>
