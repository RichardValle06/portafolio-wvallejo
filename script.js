/* ================================================================
   script.js — Portafolio Walter Richard Vallejo Montero
   Ingeniería en Sistemas Inteligentes · Universidad ECOTEC
   Actividad Integradora 2 — JavaScript + LocalStorage + GitHub
   ================================================================
   Índice de este archivo:
     1. Referencias a elementos del DOM y variables globales
     2. Utilidades de LocalStorage
     3. Smooth scroll + sombra del header al hacer scroll (evento: scroll)
     4. Animación de barras de habilidades (IntersectionObserver)
     5. Modo oscuro / claro (funcionalidad adicional + LocalStorage)
     6. Saludo personalizado al visitante (LocalStorage)
     7. Contador de visitas simulado (LocalStorage)
     8. Proyectos favoritos (eventos: click, mouseover/mouseout + LocalStorage)
     9. Validación del formulario de contacto (eventos: submit, input)
    10. Botón "Volver al inicio" (evento: click + scroll)
    11. Fallback de la foto de perfil (evento: error)
   ================================================================ */


/* ================================================================
   1. REFERENCIAS AL DOM Y VARIABLES GLOBALES
   ================================================================ */
const cuerpoPagina      = document.body;
const botonTema         = document.getElementById('theme-toggle');
const encabezado        = document.getElementById('header');
const seccionHabilidades = document.querySelector('.habilidades');
const saludoHero        = document.getElementById('hero-eyebrow');
const avatarHero        = document.getElementById('hero-avatar');
const placeholderAvatar = document.getElementById('avatar-placeholder');
const contadorVisitasEl = document.getElementById('visit-counter');
const botonVolverArriba = document.getElementById('back-to-top');
const formularioContacto = document.getElementById('contact-form');
const mensajeFeedback   = document.getElementById('form-feedback');
const botonesFavoritos  = document.querySelectorAll('.project-card__fav');
const tarjetasProyecto  = document.querySelectorAll('.project-card');

// Nombres de las claves usadas en LocalStorage (centralizadas para evitar errores de tipeo)
const CLAVE_TEMA        = 'portafolio-tema';
const CLAVE_VISITANTE   = 'portafolio-nombre-visitante';
const CLAVE_VISITAS     = 'portafolio-contador-visitas';
const CLAVE_FAVORITOS   = 'portafolio-proyectos-favoritos';


/* ================================================================
   2. UTILIDADES DE LOCALSTORAGE
   Envuelven localStorage en funciones propias para poder manejar
   con un if...else los casos en que el navegador lo bloquee
   (por ejemplo, en modo incógnito con almacenamiento restringido).
   ================================================================ */
function guardarEnAlmacenamiento(clave, valor) {
    try {
        localStorage.setItem(clave, valor);
    } catch (error) {
        console.warn('No se pudo guardar en localStorage:', error);
    }
}

function leerDeAlmacenamiento(clave) {
    try {
        return localStorage.getItem(clave);
    } catch (error) {
        console.warn('No se pudo leer localStorage:', error);
        return null;
    }
}


/* ================================================================
   3. SMOOTH SCROLL + SOMBRA DEL HEADER AL HACER SCROLL
   ================================================================ */
document.querySelectorAll('a[href^="#"]').forEach(function (enlace) {
    enlace.addEventListener('click', function (evento) {
        const destino = document.querySelector(this.getAttribute('href'));
        if (destino) {
            evento.preventDefault();
            destino.scrollIntoView({ behavior: 'smooth' });
        }
    });
});

// Evento "scroll": agrega o quita una clase según la posición de scroll
window.addEventListener('scroll', function () {
    if (window.scrollY > 20) {
        encabezado.classList.add('header--scrolled');
    } else {
        encabezado.classList.remove('header--scrolled');
    }

    // Mostrar u ocultar el botón "Volver al inicio" (manipulación del DOM)
    if (window.scrollY > 500) {
        botonVolverArriba.classList.add('is-visible');
    } else {
        botonVolverArriba.classList.remove('is-visible');
    }
});


/* ================================================================
   4. ANIMACIÓN DE BARRAS DE HABILIDADES AL ENTRAR EN VIEWPORT
   ================================================================ */
if (seccionHabilidades && 'IntersectionObserver' in window) {
    const observadorHabilidades = new IntersectionObserver(function (entradas) {
        entradas.forEach(function (entrada) {
            if (entrada.isIntersecting) {
                entrada.target.classList.add('visible');
                observadorHabilidades.unobserve(entrada.target);
            }
        });
    }, { threshold: 0.25 });

    observadorHabilidades.observe(seccionHabilidades);
}


/* ================================================================
   5. MODO OSCURO / CLARO
   Funcionalidad adicional (punto 6) + persistencia con
   LocalStorage (punto 7): la preferencia de tema se recupera
   y se aplica automáticamente cada vez que se abre la página.
   ================================================================ */

// Función: aplica un tema ("oscuro" o "claro") y actualiza el ícono del botón
function aplicarTema(tema) {
    if (tema === 'oscuro') {
        cuerpoPagina.classList.add('dark-theme');
        botonTema.textContent = '☀️';
    } else {
        cuerpoPagina.classList.remove('dark-theme');
        botonTema.textContent = '🌙';
    }
}

// Función: alterna el tema actual y lo guarda en LocalStorage
function alternarTema() {
    const temaActual = cuerpoPagina.classList.contains('dark-theme') ? 'oscuro' : 'claro';
    const temaNuevo = temaActual === 'oscuro' ? 'claro' : 'oscuro';

    aplicarTema(temaNuevo);
    guardarEnAlmacenamiento(CLAVE_TEMA, temaNuevo);
}

// Evento "click" sobre el botón de tema
botonTema.addEventListener('click', alternarTema);

// Al cargar la página, se recupera la preferencia guardada (si existe)
const temaGuardado = leerDeAlmacenamiento(CLAVE_TEMA);
if (temaGuardado === 'oscuro' || temaGuardado === 'claro') {
    aplicarTema(temaGuardado);
} else {
    // Si el visitante nunca eligió un tema, se respeta la preferencia del sistema operativo
    const prefiereOscuro = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    aplicarTema(prefiereOscuro ? 'oscuro' : 'claro');
}


/* ================================================================
   6. SALUDO PERSONALIZADO AL VISITANTE
   Cuando alguien completa el formulario de contacto, su nombre se
   guarda en LocalStorage. En su próxima visita, el texto del hero
   ("¡Hola, bienvenido! Soy") cambia dinámicamente para saludarlo.
   ================================================================ */
function mostrarSaludoPersonalizado() {
    const nombreVisitante = leerDeAlmacenamiento(CLAVE_VISITANTE);

    if (nombreVisitante) {
        // Manipulación del DOM: se cambia el texto del elemento
        saludoHero.textContent = '¡Hola de nuevo, ' + nombreVisitante + '! Soy';
    } else {
        saludoHero.textContent = '¡Hola, bienvenido! Soy';
    }
}

mostrarSaludoPersonalizado();


/* ================================================================
   7. CONTADOR DE VISITAS SIMULADO
   Cada vez que se carga la página se incrementa un contador
   guardado en LocalStorage y se muestra en el footer.
   ================================================================ */
function actualizarContadorVisitas() {
    const visitasPrevias = parseInt(leerDeAlmacenamiento(CLAVE_VISITAS), 10);
    let totalVisitas;

    if (isNaN(visitasPrevias)) {
        totalVisitas = 1;
    } else {
        totalVisitas = visitasPrevias + 1;
    }

    guardarEnAlmacenamiento(CLAVE_VISITAS, totalVisitas);

    // Manipulación del DOM: se actualiza el texto del contador en el footer
    if (totalVisitas === 1) {
        contadorVisitasEl.textContent = 'Eres la primera visita registrada en este navegador 🎉';
    } else {
        contadorVisitasEl.textContent = 'Visitas registradas en este navegador: ' + totalVisitas;
    }
}

actualizarContadorVisitas();


/* ================================================================
   8. PROYECTOS FAVORITOS
   Permite marcar proyectos como favoritos con una estrella.
   La selección persiste entre recargas gracias a LocalStorage.
   ================================================================ */

// Función: lee el arreglo de IDs favoritos guardado (o un arreglo vacío si no existe)
function obtenerFavoritosGuardados() {
    const favoritosTexto = leerDeAlmacenamiento(CLAVE_FAVORITOS);

    if (favoritosTexto) {
        return JSON.parse(favoritosTexto);
    } else {
        return [];
    }
}

// Función: actualiza visualmente un botón de favorito según su estado
function pintarBotonFavorito(boton, esFavorito) {
    if (esFavorito) {
        boton.textContent = '★';
        boton.classList.add('is-favorite');
    } else {
        boton.textContent = '☆';
        boton.classList.remove('is-favorite');
    }
}

// Al cargar la página, se pintan los favoritos ya guardados
const favoritosGuardados = obtenerFavoritosGuardados();
botonesFavoritos.forEach(function (boton) {
    const idProyecto = boton.getAttribute('data-project-id');
    const esFavorito = favoritosGuardados.includes(idProyecto);
    pintarBotonFavorito(boton, esFavorito);
});

// Evento "click": alterna el estado de favorito de un proyecto
botonesFavoritos.forEach(function (boton) {
    boton.addEventListener('click', function () {
        const idProyecto = boton.getAttribute('data-project-id');
        let favoritosActuales = obtenerFavoritosGuardados();

        if (favoritosActuales.includes(idProyecto)) {
            // Ya era favorito: se quita del arreglo
            favoritosActuales = favoritosActuales.filter(function (id) {
                return id !== idProyecto;
            });
            pintarBotonFavorito(boton, false);
        } else {
            // No era favorito: se agrega al arreglo
            favoritosActuales.push(idProyecto);
            pintarBotonFavorito(boton, true);
        }

        guardarEnAlmacenamiento(CLAVE_FAVORITOS, JSON.stringify(favoritosActuales));
    });
});

// Eventos "mouseover" / "mouseout": al pasar el mouse sobre una tarjeta,
// su etiqueta superior cambia temporalmente de texto.
tarjetasProyecto.forEach(function (tarjeta) {
    const etiqueta = tarjeta.querySelector('.project-card__tag');
    const textoOriginal = etiqueta.getAttribute('data-original-tag');

    tarjeta.addEventListener('mouseover', function () {
        etiqueta.textContent = '👀 Viendo proyecto...';
    });

    tarjeta.addEventListener('mouseout', function () {
        etiqueta.textContent = textoOriginal;
    });
});


/* ================================================================
   9. VALIDACIÓN DEL FORMULARIO DE CONTACTO
   Verifica que nombre, correo y mensaje no estén vacíos antes de
   mostrar un mensaje de confirmación (o de error, en su defecto).
   ================================================================ */

// Función: muestra un mensaje de retroalimentación (éxito o error) en el formulario
function mostrarMensajeFormulario(texto, tipo) {
    mensajeFeedback.textContent = texto;
    mensajeFeedback.classList.remove('form-feedback--success', 'form-feedback--error');
    mensajeFeedback.classList.add('is-visible', 'form-feedback--' + tipo);
}

// Función: valida los tres campos obligatorios del formulario
function validarFormularioContacto(nombre, correo, mensaje) {
    const camposCompletos = nombre.trim() !== '' && correo.trim() !== '' && mensaje.trim() !== '';

    if (camposCompletos) {
        return true;
    } else {
        return false;
    }
}

formularioContacto.addEventListener('submit', function (evento) {
    evento.preventDefault();

    const campoNombre  = document.getElementById('nombre');
    const campoCorreo  = document.getElementById('email');
    const campoMensaje = document.getElementById('mensaje');

    const nombre  = campoNombre.value;
    const correo  = campoCorreo.value;
    const mensaje = campoMensaje.value;

    // Estructura condicional if...else que decide si se confirma o se rechaza el envío
    if (validarFormularioContacto(nombre, correo, mensaje)) {
        mostrarMensajeFormulario('¡Gracias, ' + nombre.trim() + '! Tu mensaje fue registrado correctamente.', 'success');

        // El nombre del visitante se guarda para personalizar su próxima visita
        guardarEnAlmacenamiento(CLAVE_VISITANTE, nombre.trim());
        mostrarSaludoPersonalizado();

        // Se limpian las marcas de error que pudieran haber quedado
        [campoNombre, campoCorreo, campoMensaje].forEach(function (campo) {
            campo.classList.remove('input-error');
        });

        formularioContacto.reset();
    } else {
        mostrarMensajeFormulario('Por favor completa nombre, correo y mensaje antes de enviar.', 'error');

        // Se resalta en rojo cada campo que esté vacío
        [campoNombre, campoCorreo, campoMensaje].forEach(function (campo) {
            if (campo.value.trim() === '') {
                campo.classList.add('input-error');
            } else {
                campo.classList.remove('input-error');
            }
        });
    }
});

// Evento "input": mientras el visitante escribe, se le quita la marca de error al campo
[document.getElementById('nombre'), document.getElementById('email'), document.getElementById('mensaje')]
    .forEach(function (campo) {
        campo.addEventListener('input', function () {
            if (campo.value.trim() !== '') {
                campo.classList.remove('input-error');
            }
        });
    });


/* ================================================================
   10. BOTÓN "VOLVER AL INICIO"
   ================================================================ */
botonVolverArriba.addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});


/* ================================================================
   11. FALLBACK DE LA FOTO DE PERFIL
   Si la imagen img/perfil.jpg no existe o no carga, se muestran
   las iniciales "WV" en su lugar (evita el manejador inline
   onerror que antes estaba escrito directamente en el HTML).
   ================================================================ */
avatarHero.addEventListener('error', function () {
    avatarHero.style.display = 'none';
    placeholderAvatar.style.display = 'flex';
});
