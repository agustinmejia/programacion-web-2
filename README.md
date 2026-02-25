# Programación Web II — PRW2T3

**Universidad Privada del Valle · Ingeniería de Sistemas Informáticos · 3er Semestre**

Repositorio de materiales y proyectos prácticos para la materia **Programación Web II**.
Cubre el desarrollo full-stack con PHP, desde PHP puro hasta el framework Laravel, con base
de datos MySQL y buenas prácticas de seguridad web.

---

## Distribución evaluativa

| Momento | Peso | Contenido |
|---------|------|-----------|
| 1er momento | 35% | Frontend + interacción con el servidor |
| 2do momento | 35% | PHP puro + framework MVC |
| Momento final | 30% | Proyecto integrador del equipo |

---

## Hoja de ruta (14 semanas)

> Carga horaria: **2 h teóricas + 4 h prácticas por semana** (≈ 3 sesiones/semana).
> Cada fila representa una sesión de clase. Las semanas de evaluación parcial no consumen
> sesiones de contenido nuevo.

---

### UNIDAD 2 — Interacción con el servidor · Semanas 1-2

| Semana | Clase | Tipo | Tema | Contenido |
|--------|-------|------|------|-----------|
| 1 | 1 | Teoría | **2.1 + 2.2** | Repaso del protocolo HTTP: ciclo petición-respuesta, stateless, versiones. Métodos GET, POST, PUT, DELETE y cuándo usar cada uno |
| 1 | 2 | Práctica | **2.3** | Cabeceras esenciales (Content-Type, Authorization, Accept, Status codes). Inspección con DevTools / Postman |
| 1 | 3 | Práctica | **2.4** | Llamados asincrónicos con AJAX: `XMLHttpRequest` vs `fetch`. Primer ejercicio: petición GET a una API pública |
| 2 | 4 | Teoría | **2.5** | JSON: estructura, `JSON.parse()`, `JSON.stringify()`. Comparativa con XML y Form data |
| 2 | 5 | Práctica | **2.5 + 2.6** | Envío de datos JSON con `fetch` (POST). Procesamiento de la respuesta: manejo de promesas, `async/await`, errores de red |
| 2 | 6 | Práctica | **2.6** | Mini-proyecto integrador: formulario que consume un endpoint PHP y actualiza la UI sin recargar la página. **Entregable U2** |

---

### UNIDAD 3 — Fundamentos de PHP · Semanas 3-6

| Semana | Clase | Tipo | Tema | Contenido |
|--------|-------|------|------|-----------|
| 3 | 7 | Teoría | **3.1 + 3.2** | Introducción a PHP: características, etiquetas, ejecución en servidor. Variables, tipos de datos (int, float, string, bool, null), operadores y conversión de tipos |
| 3 | 8 | Práctica | **3.3** | Estructuras de control: `if/else`, `switch`, `match`. Bucles `for`, `while`, `foreach` |
| 3 | 9 | Práctica | **3.3 + 3.4** | Funciones: definición, parámetros por valor/referencia, retorno. Arreglos indexados, asociativos y multidimensionales; funciones de arreglos (`array_map`, `array_filter`, `usort`) |
| 4 | 10 | Teoría | **3.5** | Superglobales `$_GET`, `$_POST`, `$_REQUEST`. Procesamiento de formularios URL Encoded y envío/recepción de JSON desde PHP (`json_decode`, `json_encode`) |
| 4 | 11 | Práctica | **3.6** | Manejo del sistema de archivos: lectura y escritura con `fopen`/`fclose`. File uploads: `$_FILES`, validación de tipo y tamaño, movimiento seguro con `move_uploaded_file` |
| 4 | 12 | Práctica | **3.7** | Conexión a MySQL con PDO. SELECT con prepared statements. Primer CRUD: INSERT y listado de registros |
| 5 | 13 | Teoría | **3.7** | CRUD completo: UPDATE y DELETE con prepared statements. Transacciones PDO. Manejo de errores de base de datos |
| 5 | 14 | Práctica | **3.8** | Cookies (`setcookie`, lectura y expiración). Sesiones PHP: `session_start`, `$_SESSION`, `session_regenerate_id`, `session_destroy`. Login básico |
| 5 | 15 | Práctica | **3.8** | Excepciones y manejo de errores: `try/catch/finally`, excepciones personalizadas, registro de errores. Integración con el sistema de login: protección de rutas con `auth_check.php` |
| 6 | 16 | Teoría | **3.9 + 3.10** | Introducción a POO: paradigma, ventajas. Clases, objetos, atributos, métodos, constructores (`__construct`), destructores (`__destruct`) |
| 6 | 17 | Práctica | **3.11 + 3.12** | Métodos mágicos: `__toString`, `__get`, `__set`, `__isset`, `__call`. Niveles de acceso: `public`, `protected`, `private`. Getters y setters |
| 6 | 18 | Práctica | **3.13** | Herencia (`extends`), sobreescritura de métodos, `parent::`. Polimorfismo e interfaces. Agregación y composición de objetos. **Evaluación / Práctica 6 — CRUD completo con sesiones** |

---

### UNIDAD 4 — Arquitectura MVC y Frameworks · Semanas 7-10

| Semana | Clase | Tipo | Tema | Contenido |
|--------|-------|------|------|-----------|
| 7 | 19 | Teoría | **4.1 + 4.2** | Patrón MVC: definición, responsabilidades de cada capa, flujo de una petición. ORM: concepto de mapeo objeto-relacional, ventajas frente a SQL manual |
| 7 | 20 | Práctica | **4.3** | Instalación de Laravel con Composer. Estructura del proyecto. Configuración de `.env`: conexión a BD, APP_KEY, APP_DEBUG |
| 7 | 21 | Práctica | **4.4** | Artisan CLI: `make:model`, `make:controller`, `make:migration`, `migrate`, `migrate:fresh --seed`, `serve`. Exploración de la estructura generada |
| 8 | 22 | Teoría | **4.5** | Controladores: creación manual y con `--resource`. Routing: `Route::get/post/put/delete`, `Route::resource`, parámetros de ruta, named routes, `route()` helper |
| 8 | 23 | Práctica | **4.6** | Servicios REST: controladores API (`--api`), retorno de `JsonResource`, códigos de respuesta HTTP, rutas en `api.php` |
| 8 | 24 | Práctica | **4.7** | Blade: `@extends`, `@section`, `@yield`, `@include`. Componentes (`@component` / Blade components). Directivas: `@foreach`, `@if`, `@csrf`, `@method` |
| 9 | 25 | Teoría | **4.8** | Modelos Eloquent: convenciones de nombres, `$fillable`, `$casts`. Migraciones: `up()`, `down()`, tipos de columna, claves foráneas. Relaciones: `belongsTo`, `hasMany` |
| 9 | 26 | Práctica | **4.9** | CRUD completo en Laravel: `index`, `create`, `store`, `edit`, `update`, `destroy`. Form Requests para validación. Mensajes flash con `session()->flash` |
| 9 | 27 | Práctica | **4.10** | Consultas avanzadas: `where`, `orWhere`, `whereHas`, `with` (Eager Loading), `paginate(10)`. Búsqueda y filtros que persisten en la URL con `request()->query()` |
| 10 | 28 | Teoría | **4.11** | Autenticación: Laravel Breeze o implementación manual. Registro, login, hash de contraseñas con `bcrypt`. Guards y providers |
| 10 | 29 | Práctica | **4.12** | Gestión de sesiones: middleware `auth`, `guest`. Protección de rutas con `Route::middleware('auth')`. Roles y permisos básicos con columna `rol` |
| 10 | 30 | Práctica | **4.13** | Analogía con otros frameworks MVC: comparativa Laravel vs Django vs Spring vs Express. Repaso general de la unidad. **Evaluación / Práctica 8 — Auth + permisos** |

---

### UNIDAD 5 — Creación de una aplicación web funcional · Semanas 11-14

| Semana | Clase | Tipo | Tema | Contenido |
|--------|-------|------|------|-----------|
| 11 | 31 | Teoría | **5.1** | Definición de la problemática: elección del dominio del proyecto. Levantamiento de requerimientos funcionales y no funcionales. Casos de uso |
| 11 | 32 | Práctica | **5.2** | Diseño de la base de datos: identificación de entidades, atributos, relaciones. Diagrama ER y script SQL inicial |
| 11 | 33 | Práctica | **5.3** | Arquitectura MVC del proyecto: definición de módulos, controladores necesarios, rutas, middlewares y estructura de carpetas |
| 12 | 34 | Práctica | **5.4** | Diseño de pantallas: wireframes o mockups de las vistas principales. Definición de flujos de navegación |
| 12 | 35 | Práctica | **5.5** | Desarrollo backend (I): migraciones, modelos, relaciones Eloquent y seeders con Faker |
| 12 | 36 | Práctica | **5.5** | Desarrollo backend (II): controladores, rutas resource, validaciones con Form Requests |
| 13 | 37 | Práctica | **5.5** | Desarrollo backend (III): autenticación, roles, middlewares, manejo de errores |
| 13 | 38 | Práctica | **5.6** | Desarrollo frontend (I): layouts Blade, componentes reutilizables, integración de Bootstrap |
| 13 | 39 | Práctica | **5.6** | Desarrollo frontend (II): vistas CRUD completas, paginación, búsqueda, feedback visual al usuario |
| 14 | 40 | Práctica | **5.5 + 5.6** | Integración final: ajustes de backend y frontend, pruebas funcionales, corrección de bugs |
| 14 | 41 | Teoría | **5.7** | Documentación: manual técnico (modelo ER, arquitectura, instrucciones de instalación) y manual de usuario |
| 14 | 42 | Práctica | **5.7** | **Presentación final del proyecto integrador** — demostración en vivo y defensa ante el docente |

---

## Proyectos del repositorio

| Proyecto | Carpeta | Unidades | Descripción |
|----------|---------|----------|-------------|
| PHP Puro | [`clase 1/sistema-crud/`](clase%201/sistema-crud/) | U3 | CRUD completo con PDO, sesiones y autenticación |
| Laravel | [`clase 1/proyecto-laravel/`](clase%201/proyecto-laravel/) | U4 | Mismo sistema con Eloquent, Blade y Breeze |

---

## Stack tecnológico

- **Backend:** PHP 8.x, Laravel (último estable)
- **Base de datos:** MySQL 8.x / MariaDB
- **Frontend:** HTML5, Bootstrap 5.3, Vanilla JS
- **Herramientas:** Composer, Artisan CLI, phpMyAdmin
- **Servidor local:** XAMPP / WAMP / Laragon

---

## Recursos

- [PHP Manual (es)](https://www.php.net/manual/es/)
- [Laravel Docs](https://laravel.com/docs)
- [Bootstrap 5](https://getbootstrap.com/docs/5.3/)
- [W3Schools JavaScript](https://www.w3schools.com/js/)
