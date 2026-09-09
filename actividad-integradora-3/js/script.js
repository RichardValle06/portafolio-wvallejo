/**
 * js/validaciones.js
 * ------------------------------------------------------------
 * Validaciones del lado del cliente para el formulario de
 * registro de productos. Verifica: campos vacíos, campos
 * numéricos, longitud de datos, valores incorrectos y formato
 * de correo electrónico (cuando el proveedor lo ingresa).
 *
 * IMPORTANTE: estas validaciones mejoran la experiencia del
 * usuario, pero no reemplazan la validación del servidor
 * (ver controllers/ProductoController.php), que es la que
 * realmente protege la base de datos.
 * ------------------------------------------------------------
 */

document.addEventListener('DOMContentLoaded', function () {
    const formulario = document.getElementById('form-producto');
    if (!formulario) return;

    const campos = {
        nombre:    document.getElementById('nombre'),
        categoria: document.getElementById('categoria'),
        precio:    document.getElementById('precio'),
        cantidad:  document.getElementById('cantidad'),
        email:     document.getElementById('proveedor_email'),
    };

    const errores = {
        nombre:    document.getElementById('err-nombre'),
        categoria: document.getElementById('err-categoria'),
        precio:    document.getElementById('err-precio'),
        cantidad:  document.getElementById('err-cantidad'),
        email:     document.getElementById('err-email'),
    };

    function marcarError(campo, mensajeEl, mensaje) {
        campo.classList.add('campo--invalido');
        mensajeEl.textContent = mensaje;
        return false;
    }

    function marcarValido(campo, mensajeEl) {
        campo.classList.remove('campo--invalido');
        mensajeEl.textContent = '';
        return true;
    }

    function validarNombre() {
        const valor = campos.nombre.value.trim();
        if (valor === '') {
            return marcarError(campos.nombre, errores.nombre, 'El nombre del producto es obligatorio.');
        }
        if (valor.length < 3 || valor.length > 150) {
            return marcarError(campos.nombre, errores.nombre, 'Debe tener entre 3 y 150 caracteres.');
        }
        return marcarValido(campos.nombre, errores.nombre);
    }

    function validarCategoria() {
        if (campos.categoria.value === '') {
            return marcarError(campos.categoria, errores.categoria, 'Selecciona una categoría.');
        }
        return marcarValido(campos.categoria, errores.categoria);
    }

    function validarPrecio() {
        const valor = campos.precio.value.trim();
        const numero = Number(valor);
        if (valor === '') {
            return marcarError(campos.precio, errores.precio, 'El precio es obligatorio.');
        }
        if (isNaN(numero)) {
            return marcarError(campos.precio, errores.precio, 'El precio debe ser un valor numérico.');
        }
        if (numero <= 0) {
            return marcarError(campos.precio, errores.precio, 'El precio debe ser mayor a 0.');
        }
        if (numero > 999999) {
            return marcarError(campos.precio, errores.precio, 'El precio ingresado es demasiado alto.');
        }
        return marcarValido(campos.precio, errores.precio);
    }

    function validarCantidad() {
        const valor = campos.cantidad.value.trim();
        if (valor === '') {
            return marcarError(campos.cantidad, errores.cantidad, 'La cantidad es obligatoria.');
        }
        if (!/^\d+$/.test(valor)) {
            return marcarError(campos.cantidad, errores.cantidad, 'La cantidad debe ser un número entero (sin decimales ni signos).');
        }
        if (parseInt(valor, 10) > 100000) {
            return marcarError(campos.cantidad, errores.cantidad, 'La cantidad ingresada es demasiado alta.');
        }
        return marcarValido(campos.cantidad, errores.cantidad);
    }

    function validarEmail() {
        const valor = campos.email.value.trim();
        if (valor === '') {
            // Es opcional: vacío es válido
            return marcarValido(campos.email, errores.email);
        }
        const patron = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!patron.test(valor)) {
            return marcarError(campos.email, errores.email, 'Ingresa un correo electrónico válido (ej. nombre@dominio.com).');
        }
        return marcarValido(campos.email, errores.email);
    }

    // Validar en tiempo real al salir de cada campo
    campos.nombre.addEventListener('blur', validarNombre);
    campos.categoria.addEventListener('change', validarCategoria);
    campos.precio.addEventListener('blur', validarPrecio);
    campos.cantidad.addEventListener('blur', validarCantidad);
    campos.email.addEventListener('blur', validarEmail);

    // Validar todo antes de enviar el formulario
    formulario.addEventListener('submit', function (evento) {
        const nombreValido    = validarNombre();
        const categoriaValida = validarCategoria();
        const precioValido    = validarPrecio();
        const cantidadValida  = validarCantidad();
        const emailValido     = validarEmail();

        const todoValido = nombreValido && categoriaValida && precioValido && cantidadValida && emailValido;

        if (!todoValido) {
            evento.preventDefault();
            const primerError = formulario.querySelector('.campo--invalido');
            if (primerError) primerError.focus();
        }
    });
});
