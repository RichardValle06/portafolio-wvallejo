<?php
/**
 * views/inventario/crear.php
 * ------------------------------------------------------------
 * VISTA: formulario de registro. No contiene lógica de negocio
 * ni acceso a la base de datos; solo HTML + los mensajes que
 * el controlador dejó en sesión.
 * ------------------------------------------------------------
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$errores       = $_SESSION['errores'] ?? [];
$datosPrevios  = $_SESSION['datos_previos'] ?? [];
unset($_SESSION['errores'], $_SESSION['datos_previos']);

function valorPrevio(array $datos, string $campo): string
{
    return htmlspecialchars($datos[$campo] ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar producto — Inventario Básico</title>
    <link rel="stylesheet" href="../../css/estilos.css">
</head>
<body>

<header class="app-header">
    <div class="app-header__marca">📦 Inventario Básico</div>
    <nav class="app-header__nav">
        <a href="../../index.php">Inicio</a>
        <a href="../../controllers/ProductoController.php?accion=listar">Ver inventario</a>
        <a class="activo" href="crear.php">Registrar producto</a>
    </nav>
</header>

<main class="contenedor">
    <div class="tarjeta tarjeta--formulario">
        <div class="tarjeta__encabezado">
            <span class="tarjeta__icono">📝</span>
            <h1>Formulario de registro</h1>
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
              action="../../controllers/ProductoController.php?accion=crear"
              method="POST" novalidate>

            <div class="campo">
                <label for="nombre">🛍️ Nombre del producto</label>
                <input type="text" id="nombre" name="nombre" maxlength="150"
                       value="<?= valorPrevio($datosPrevios, 'nombre') ?>"
                       placeholder="Ej. Mouse óptico USB">
                <small class="campo__error" id="err-nombre"></small>
            </div>

            <div class="campo">
                <label for="categoria">🗂️ Categoría</label>
                <select id="categoria" name="categoria">
                    <?php
                    $categorias = ['Tecnología', 'Papelería', 'Mobiliario', 'Limpieza', 'Alimentos', 'Otros'];
                    $seleccionada = $datosPrevios['categoria'] ?? '';
                    echo '<option value="">-- Selecciona --</option>';
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
                       value="<?= valorPrevio($datosPrevios, 'precio') ?>"
                       placeholder="Ej. 12.50">
                <small class="campo__error" id="err-precio"></small>
            </div>

            <div class="campo">
                <label for="cantidad">📦 Cantidad en stock</label>
                <input type="text" id="cantidad" name="cantidad"
                       value="<?= valorPrevio($datosPrevios, 'cantidad') ?>"
                       placeholder="Ej. 10">
                <small class="campo__error" id="err-cantidad"></small>
            </div>

            <div class="campo">
                <label for="proveedor_email">✉️ Correo del proveedor (opcional)</label>
                <input type="text" id="proveedor_email" name="proveedor_email"
                       value="<?= valorPrevio($datosPrevios, 'proveedor_email') ?>"
                       placeholder="Ej. ventas@proveedor.com">
                <small class="campo__error" id="err-email"></small>
            </div>

            <div class="campo">
                <label for="descripcion">🧾 Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4"
                          placeholder="Detalles del producto..."><?= valorPrevio($datosPrevios, 'descripcion') ?></textarea>
            </div>

            <button type="submit" class="boton boton--primario">💾 Guardar producto</button>
        </form>
    </div>
</main>

<script src="../../js/script.js"></script>
</body>
</html>
