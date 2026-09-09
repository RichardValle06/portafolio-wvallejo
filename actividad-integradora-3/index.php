<?php
/**
 * index.php
 * ------------------------------------------------------------
 * Punto de entrada / portada del proyecto. Solo enlaza a las
 * dos operaciones principales; no accede a la base de datos.
 * ------------------------------------------------------------
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario Básico — Actividad Integradora 3</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<header class="app-header">
    <div class="app-header__marca">📦 Inventario Básico</div>
    <nav class="app-header__nav">
        <a class="activo" href="index.php">Inicio</a>
        <a href="controllers/ProductoController.php?accion=listar">Ver inventario</a>
        <a href="views/inventario/crear.php">Registrar producto</a>
    </nav>
</header>

<main class="contenedor">
    <section class="portada">
        <h1>Sistema de Inventario Básico</h1>
        <p>
            Aplicación desarrollada con PHP, MySQL y JavaScript, organizada bajo el
            patrón <strong>Modelo – Vista – Controlador (MVC)</strong>, para registrar
            y consultar los productos de un inventario.
        </p>
        <div class="portada__acciones">
            <a href="views/inventario/crear.php" class="boton boton--primario">📝 Registrar producto</a>
            <a href="controllers/ProductoController.php?accion=listar" class="boton boton--secundario">📋 Ver inventario</a>
        </div>
    </section>

    <section class="portada__flujo">
        <h2>Flujo de la aplicación</h2>
        <div class="flujo">
            <div class="flujo__paso">Vista</div>
            <span>→</span>
            <div class="flujo__paso">Controlador</div>
            <span>→</span>
            <div class="flujo__paso">Modelo</div>
            <span>→</span>
            <div class="flujo__paso">MySQL</div>
        </div>
    </section>
</main>

</body>
</html>
