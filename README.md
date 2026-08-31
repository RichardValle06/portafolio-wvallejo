# 💼 Portafolio Personal — Walter Richard Vallejo Montero

## 📋 Descripción
Sitio web de portafolio personal desarrollado como proyecto académico en la
**Ingeniería en Sistemas Inteligentes** de la **Universidad Tecnológica ECOTEC**.

Presenta información profesional, habilidades técnicas, proyectos destacados
y un formulario de contacto validado con JavaScript. Este proyecto corresponde
a la **Actividad Integradora 2**, que actualiza el portafolio de la Actividad
Integradora 1 incorporando interactividad con JavaScript y persistencia de
datos con `localStorage`.

---

## ⚡ Funcionalidades de JavaScript (Actividad Integradora 2)

| Funcionalidad | Detalle |
|---|---|
| 🌙 **Modo oscuro / claro** | Botón en la barra de navegación que alterna el tema del sitio. La preferencia se guarda en `localStorage` y se restaura automáticamente en visitas futuras. |
| 👋 **Saludo personalizado** | Al enviar el formulario de contacto, el nombre se guarda en `localStorage`. La próxima vez que la persona visite el sitio, el texto de bienvenida del inicio la saluda por su nombre. |
| 🔢 **Contador de visitas simulado** | Cada carga de la página incrementa un contador guardado en `localStorage` y lo muestra en el pie de página. |
| ⭐ **Proyectos favoritos** | Cada tarjeta de proyecto tiene un botón de favorito (☆ / ★). La selección persiste entre recargas mediante `localStorage`. |
| ✅ **Validación del formulario de contacto** | Verifica que nombre, correo y mensaje no estén vacíos antes de mostrar un mensaje de confirmación; si falta algún dato, resalta el campo y muestra un mensaje de error. |
| 🖱️ **Interactividad en tarjetas de proyecto** | Al pasar el mouse sobre una tarjeta (`mouseover` / `mouseout`), su etiqueta cambia temporalmente de texto. |
| ⬆️ **Botón "Volver al inicio"** | Aparece al hacer scroll hacia abajo y regresa suavemente al inicio de la página. |
| 🖼️ **Fallback de foto de perfil** | Si `img/perfil.jpg` no carga, se muestran automáticamente las iniciales "WV" (gestionado con el evento `error`, sin JavaScript en línea). |

Toda la lógica anterior vive en **`script.js`**, un archivo externo enlazado
desde `index.html`. No hay código JavaScript escrito directamente en el HTML.

---

## 🛠️ Tecnologías utilizadas

| Tecnología    | Uso                                                                 |
|---------------|---------------------------------------------------------------------|
| HTML5         | Estructura semántica (header, nav, main, section, article, footer)  |
| CSS3          | Estilos, variables `:root`, Flexbox, `:hover`, animaciones, modo oscuro |
| JavaScript    | Eventos, manipulación del DOM, validación de formularios, `localStorage` |
| Google Fonts  | Poppins (display) + Inter (body)                                    |
| GitHub        | Control de versiones y alojamiento                                  |
| GitHub Pages  | Despliegue público del sitio                                        |

---

## 📁 Estructura del proyecto

```
portafolio-wvallejo/
├── index.html       ← Archivo HTML principal
├── styles.css       ← Hoja de estilos externa
├── script.js        ← Lógica de JavaScript (eventos, DOM, localStorage)
├── README.md        ← Este archivo
└── img/
    ├── perfil.jpg       ← Foto de perfil
    ├── proyecto1.jpg    ← Captura proyecto 1
    ├── proyecto2.jpg    ← Captura proyecto 2
    └── proyecto3.jpg    ← Captura proyecto 3
```

---

## 📑 Secciones del portafolio

| Sección         | Descripción                                                    |
|-----------------|----------------------------------------------------------------|
| **Inicio**      | Hero con nombre, rol, descripción y llamados a la acción       |
| **Sobre mí**    | Presentación personal, intereses y objetivos profesionales     |
| **Habilidades** | Barras de progreso animadas con CSS y JavaScript               |
| **Proyectos**   | Cards con imagen, tecnología, descripción y enlace             |
| **Contacto**    | Formulario validado con JavaScript + datos de contacto         |
| **Footer**      | Nombre, año, contador de visitas y enlace al perfil de GitHub  |

---

## ✅ Requisitos técnicos implementados

- [x] Etiquetas semánticas: `header`, `nav`, `main`, `section`, `article`, `footer`
- [x] Archivo HTML principal: `index.html`
- [x] Archivo CSS externo: `styles.css`
- [x] Carpeta de imágenes: `img/`
- [x] Clases CSS para aplicar estilos
- [x] Colores, tipografías, márgenes, rellenos y tamaños
- [x] `display: flex` en múltiples secciones
- [x] Efectos con pseudoclase `:hover`
- [x] Variables CSS dentro de `:root`
- [x] Código ordenado e indentado
- [x] Sin estilos CSS escritos directamente en etiquetas HTML
- [x] Archivo `script.js` externo, enlazado correctamente en `index.html`
- [x] Sin código JavaScript escrito directamente en el HTML
- [x] Al menos dos eventos con `addEventListener` (`click`, `scroll`, `submit`, `input`, `mouseover`/`mouseout`, `error`)
- [x] Manipulación del DOM en más de dos elementos (texto, clases, estilos, visibilidad)
- [x] Uso de variables, funciones y estructuras condicionales `if...else`
- [x] Validación del formulario de contacto (nombre, correo y mensaje)
- [x] Funcionalidad adicional: modo oscuro
- [x] Persistencia de datos con `localStorage` (tema, visitante, visitas, favoritos)

---

## 🚀 Cómo visualizar el proyecto

1. Clona el repositorio:
   ```bash
   git clone https://github.com/RichardValle06/portafolio-wvallejo.git
   ```
2. Abre `index.html` en tu navegador (no requiere instalar nada ni levantar un servidor).
3. Para ver la persistencia de datos, interactúa con el sitio (cambia el tema,
   marca un proyecto como favorito, envía el formulario de contacto) y luego
   recarga la página: los cambios se mantienen porque quedaron guardados en
   `localStorage` del navegador.

**O visita directamente:**
[https://RichardValle06.github.io/portafolio-wvallejo/](https://RichardValle06.github.io/portafolio-wvallejo/)

---

## 📝 Commits realizados

**Actividad Integradora 1**

| # | Mensaje del commit                                       |
|---|----------------------------------------------------------|
| 1 | `Initial commit`                                         |
| 2 | `feat: agregada estructura HTML y sección principal`     |
| 3 | `feat: agregados estilos CSS, variables y animaciones`   |
| 4 | `feat: agregadas imágenes del portafolio`                |
| 5 | `style: personalización final de datos y enlaces`        |

**Actividad Integradora 2**

| # | Mensaje del commit                                                    |
|---|------------------------------------------------------------------------|
| 6 | `feat: integracion de script.js y eliminacion de JS en linea`         |
| 7 | `feat: implementacion de eventos (click, scroll, mouseover, input)`   |
| 8 | `feat: manipulacion del DOM (tema oscuro, saludo y contador de visitas)` |
| 9 | `feat: validacion del formulario de contacto`                         |
| 10 | `feat: proyectos favoritos, boton volver arriba y ajustes finales con localStorage` |

---

## 👤 Autor

**Walter Richard Vallejo Montero**
Ingeniería en Sistemas Inteligentes — Universidad Tecnológica ECOTEC
Guayaquil, Ecuador · 2026
GitHub: [@RichardValle06](https://github.com/RichardValle06)
