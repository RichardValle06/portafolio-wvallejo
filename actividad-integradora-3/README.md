# Inventario Básico — Actividad Integradora 3 (PHP + MySQL + MVC)

Aplicación web para registrar y consultar productos de un inventario,
desarrollada con **HTML, CSS, JavaScript, PHP y MySQL**, organizada bajo
el patrón **MVC (Modelo – Vista – Controlador)**.

Flujo de la aplicación: **Vista → Controlador → Modelo → Base de datos**

## Estructura del proyecto

```
actividad-integradora-3/
├── index.php                          Portada / punto de entrada
├── config/
│   └── conexion.php                   Conexión a MySQL (PDO) — archivo independiente
├── controllers/
│   └── ProductoController.php         Recibe acciones (crear, listar, eliminar)
├── models/
│   └── Producto.php                   Toda la lógica SQL contra la tabla `productos`
├── views/
│   └── inventario/
│       ├── crear.php                  Formulario de registro
│       └── listar.php                 Tabla de consulta + búsqueda + eliminar
├── css/
│   └── estilos.css
├── js/
│   └── script.js                      Validaciones del lado del cliente
└── sql/
    └── integradora.sql                Crea la base `integradora` y la tabla `productos`
```

## 1. Requisitos

- Un servidor con PHP 7.4+ y la extensión `pdo_mysql` habilitada (XAMPP, WAMP o Laragon la traen por defecto).
- MySQL o MariaDB.

## 2. Instalación local (XAMPP / WAMP / Laragon) — recomendado

1. Copia la carpeta `actividad-integradora-3` dentro de `htdocs` (XAMPP/Laragon) o `www` (WAMP).
2. Abre **phpMyAdmin** (o tu cliente de MySQL preferido) y ejecuta el archivo `sql/integradora.sql` completo.
   Esto crea la base `integradora`, la tabla `productos` y 4 registros de ejemplo.
3. Revisa `config/conexion.php`: por defecto usa `usuario: root` y `clave: ''` (sin clave), que es
   la configuración estándar de XAMPP/Laragon. Si tu instalación usa otra clave, ajústala ahí.
4. Inicia Apache y MySQL desde el panel de control de XAMPP/Laragon.
5. Abre en el navegador: `http://localhost/actividad-integradora-3/index.php`

## 3. Despliegue en un hosting con cPanel (opcional)

cPanel no da acceso al usuario `root`. Para publicarlo ahí:

1. En cPanel → **MySQL® Databases**, crea una base de datos (te quedará con el prefijo de tu
   cuenta, ej. `tucuenta_integradora`) y un usuario con contraseña, y asígnalo a esa base con
   todos los privilegios.
2. En **phpMyAdmin** de cPanel, importa `sql/integradora.sql` (puedes quitar el `CREATE DATABASE`
   si cPanel ya te obliga a usar el nombre con prefijo).
3. Edita **solo** `config/conexion.php` con las 4 constantes que te dio cPanel (host, usuario,
   clave, nombre de base). El resto del proyecto no necesita ningún cambio.
4. Sube todos los archivos por **File Manager** o FTP dentro de `public_html` (o una subcarpeta).

## 4. Funcionalidades

- **Registrar producto** (`views/inventario/crear.php`): formulario con validaciones en
  JavaScript (campos vacíos, numéricos, longitud, valores incorrectos, formato de correo) y
  validación duplicada en el servidor (`ProductoController.php`), que es la que realmente
  protege la base de datos.
- **Consultar inventario** (`controllers/ProductoController.php?accion=listar`): tabla HTML con
  todos los productos, buscador por nombre/categoría, y totales (cantidad de productos y valor
  total del inventario).
- **Eliminar producto** (opcional, ya incluido): botón de eliminar por fila, con confirmación.

## 5. Notas de diseño MVC

- El **Modelo** (`models/Producto.php`) es el único archivo que ejecuta SQL.
- El **Controlador** (`controllers/ProductoController.php`) no contiene HTML ni SQL: solo valida
  la entrada, llama al Modelo y decide a qué Vista redirigir.
- Las **Vistas** (`views/inventario/*.php`) no acceden a la base de datos directamente; reciben
  los datos ya listos desde el Controlador.

## 6. Secuencia sugerida de commits para GitHub (mínimo 7)

Sube el proyecto a una carpeta nueva dentro de tu repositorio (o uno nuevo) y ve confirmando
por partes reales, por ejemplo:

1. `Creación de estructura inicial del proyecto` — carpetas vacías + `index.php` básico.
2. `Diseño de interfaz principal` — `css/estilos.css` + `index.php` terminado.
3. `Creación del formulario de registro` — `views/inventario/crear.php` (sin validar aún).
4. `Agregadas validaciones con JavaScript` — `js/script.js` + enganche en `crear.php`.
5. `Configuración de conexión con MySQL` — `config/conexion.php` + `sql/integradora.sql`.
6. `Implementación del modelo y controlador` — `models/Producto.php` + `controllers/ProductoController.php`.
7. `Registro y consulta de datos desde MySQL` — `views/inventario/listar.php` funcionando de
   punta a punta (registrar → consultar → eliminar).

Cada commit debe representar avance real; evita subir todo en un solo commit al final.

## 7. Verificación realizada antes de la entrega

Este proyecto fue probado de punta a punta contra una base MySQL real:

- Importación del script SQL con usuario `root` sin clave.
- Registro de un producto válido → insertado correctamente y visible en el listado.
- Envío de datos inválidos (precio negativo, cantidad no numérica, correo mal escrito) →
  rechazado por el servidor, sin insertar nada en la base.
- Eliminación de un producto → removido correctamente.
- Verificación de que tildes y "ñ" se guardan e imprimen correctamente (`SET NAMES utf8mb4`
  en el script SQL).
