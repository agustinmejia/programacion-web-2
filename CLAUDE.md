# CLAUDE.md — Programación Web II (PRW2T3)
> Universidad Privada del Valle · Ingeniería de Sistemas Informáticos · 3er Semestre

---

## Contexto del curso

Materia semestral de **120 horas** (2 teóricas + 4 prácticas por semana) enfocada en el
desarrollo **full-stack** con PHP. Los estudiantes ya tienen conocimientos de HTML, CSS y
JavaScript básico (Programación Web I). El objetivo es que al final del semestre puedan
construir una aplicación web completa con back-end, base de datos, autenticación y buenas
prácticas.

**Distribución evaluativa:**
- 1er momento (35%) → Unidades 1 y 2: frontend + interacción con el servidor
- 2do momento (35%) → Unidades 3 y 4: PHP puro + framework MVC
- Momento final (30%) → Unidad 5: proyecto integrador completo

---

## Estructura del repositorio

### Convención de carpetas

Cada sesión de clase tiene su propia carpeta `clase N/` con la siguiente estructura interna:

```
clase N/
├── README.md          ← objetivos, temas cubiertos y próxima clase
├── teoria/            ← guías teóricas en Markdown
├── ejemplos/          ← código de demostración (PHP, HTML, JS)
└── ejercicios/        ← consignas y actividades para los alumnos
```

### Árbol actual

```
/
├── CLAUDE.md                        ← instrucciones para Claude Code
├── README.md                        ← hoja de ruta completa del semestre
│
├── clase 0/                         ← clase introductoria (demo del semestre)
│   ├── README.md
│   ├── sistema-crud/                ← PHP puro: CRUD completo (referencia U3)
│   │   ├── index.php
│   │   ├── database.sql
│   │   ├── config/database.php
│   │   ├── auth/
│   │   ├── includes/
│   │   └── students/
│   └── proyecto-laravel/            ← Laravel: misma app con MVC (referencia U4)
│       ├── app/Http/Controllers/
│       ├── app/Models/
│       ├── database/
│       ├── resources/views/
│       └── routes/web.php
│
└── clase 1/                         ← Unidad 2 · Temas 2.1-2.2 · HTTP y métodos
    ├── README.md
    ├── teoria/
    │   └── http-fundamentos.md      ← protocolo HTTP, ciclo req/res, GET/POST/PUT/DELETE
    ├── ejemplos/
    │   ├── server.php               ← endpoint PHP que maneja los 4 métodos HTTP
    │   └── cliente.html             ← UI Bootstrap/JS para probar el endpoint
    └── ejercicios/
        └── README.md                ← 5 actividades: conceptual, DevTools, práctica, tarea
```

---

## Proyecto 1: PHP Puro — Sistema de Gestión de Estudiantes (`sistema-crud/`)

### ¿Qué aprenden con este proyecto?
- Conectar PHP a MySQL con PDO
- Arquitectura sin framework: separación manual de lógica y presentación
- CRUD completo con validaciones server-side
- Sesiones PHP para autenticación básica
- Prepared statements para prevenir SQL injection
- Protección de rutas con un archivo `auth_check.php` reutilizable

### Base de datos (`gestion_estudiantes`)

```sql
CREATE DATABASE IF NOT EXISTS gestion_estudiantes
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE usuarios (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre     VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    rol        ENUM('admin', 'editor') NOT NULL DEFAULT 'editor',
    activo     TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cursos (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(100) NOT NULL,
    descripcion TEXT,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE estudiantes (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre     VARCHAR(100) NOT NULL,
    apellido   VARCHAR(100) NOT NULL,
    dni        VARCHAR(20)  NOT NULL UNIQUE,
    email      VARCHAR(150) NOT NULL,
    telefono   VARCHAR(30),
    fecha_nac  DATE,
    curso_id   INT UNSIGNED,
    estado     ENUM('activo', 'inactivo', 'suspendido') NOT NULL DEFAULT 'activo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE SET NULL
);
```

**Credenciales demo:** `admin@sistema.com` / `password`

### Funcionalidades implementadas

**Autenticación:**
- [x] Login con email y contraseña
- [x] Sesiones PHP seguras con `session_regenerate_id`
- [x] Protección de rutas mediante `auth_check.php`
- [x] Logout con destrucción completa de sesión

**CRUD de estudiantes:**
- [x] Listar con búsqueda por nombre/apellido/DNI/email y filtros por curso y estado
- [x] Crear con formulario validado
- [x] Editar con formulario prellenado
- [x] Eliminar con confirmación via modal (solo POST)

**Seguridad:**
- [x] Prepared statements con PDO en todas las operaciones
- [x] Escapado con `htmlspecialchars()` en todas las salidas HTML
- [x] Eliminación solo via POST (protección básica contra CSRF por URL)
- [x] Contraseñas con `password_hash()` / `password_verify()`

### Stack técnico
- PHP 8.x + PDO
- MySQL 8.x / MariaDB
- Bootstrap 5.3 + Bootstrap Icons (CDN)
- Servidor local: XAMPP / WAMP / Laragon

---

## Proyecto 2: Laravel — Sistema de Gestión de Estudiantes (`proyecto-laravel/`)

### ¿Qué aprenden con este proyecto?
- Instalación y configuración de Laravel con Composer
- Artisan CLI para generar componentes
- Migraciones y seeders como control de versiones de la BD
- Eloquent ORM: relaciones `belongsTo`, `hasMany`
- Controladores Resource y rutas RESTful
- Blade como motor de plantillas
- Middleware de autenticación (manual o Laravel Breeze)
- Validación con Form Requests
- Paginación y búsqueda con Eloquent

### Base de datos (`gestion_estudiantes_laravel`)

Mismo esquema que el proyecto PHP puro, con `updated_at` en todas las tablas
(requerido por los timestamps de Eloquent).

**Modelos y relaciones:**
- `Estudiante` → `belongsTo(Curso::class)`
- `Curso` → `hasMany(Estudiante::class)`
- `User` → tabla `usuarios` (login del sistema)

### Funcionalidades objetivo

**Unidad 4 (semanas 7-10) — Laravel:**
- [ ] Migraciones para las 3 tablas (`usuarios`, `cursos`, `estudiantes`)
- [ ] Seeders con datos de prueba (Faker)
- [ ] `EstudianteController` con los 7 métodos resource
- [ ] Rutas definidas con `Route::resource()`
- [ ] Vistas Blade con layouts, secciones y componentes
- [ ] Relaciones Eloquent: `Estudiante->Curso`
- [ ] Búsqueda y filtrado con Query Builder
- [ ] Paginación con `->paginate(10)`
- [ ] Autenticación con middleware `auth`
- [ ] API JSON: rutas en `api.php` que devuelven recursos con `JsonResource`

### Comandos Artisan clave (para enseñar en clase)

```bash
# Crear proyecto
composer create-project laravel/laravel proyecto-laravel

# Modelos con migración, factory y seeder de una vez
php artisan make:model Estudiante -mfs
php artisan make:model Curso -mfs

# Controladores
php artisan make:controller EstudianteController --resource
php artisan make:controller Api/EstudianteController --api

# Autenticación simple
composer require laravel/breeze --dev
php artisan breeze:install blade

# Ejecutar migraciones con seeders
php artisan migrate:fresh --seed

# Servidor de desarrollo
php artisan serve
```

---

## Hoja de ruta de desarrollo (14 semanas)

| Semana | Unidad | Proyecto activo  | Entregable |
|--------|--------|------------------|-----------|
| 1-2    | U2     | PHP puro         | API JSON funcional con AJAX |
| 3      | U3     | `sistema-crud`   | Conexión BD + CRUD básico |
| 4      | U3     | `sistema-crud`   | Validaciones + autenticación |
| 5      | U3     | `sistema-crud`   | Sesiones + protección de rutas |
| 6      | U3     | `sistema-crud`   | **Práctica 6: CRUD completo** |
| 7      | U4     | `proyecto-laravel` | Instalación + primeras migraciones |
| 8      | U4     | `proyecto-laravel` | Controladores + rutas + vistas Blade |
| 9      | U4     | `proyecto-laravel` | Eloquent CRUD + relaciones |
| 10     | U4     | `proyecto-laravel` | **Práctica 8: Auth + permisos** |
| 11-14  | U5     | Proyecto propio  | Aplicación web completa del equipo |

---

## Convenciones y estándares de código

### PHP
- PHP 8.x con tipos estrictos cuando sea posible
- Nombres de variables y funciones en `camelCase`
- Nombres de clases en `PascalCase`
- Prepared statements **siempre** (nunca concatenar variables en SQL)
- Nunca mostrar errores PDO en producción (`PDO::ERRMODE_EXCEPTION` solo en dev)

### Laravel
- Seguir convenciones de nomenclatura de Laravel (tabla `estudiantes`, modelo `Estudiante`)
- Usar Form Requests para validación, no validar en el controlador
- Eloquent por defecto; Query Builder solo cuando Eloquent no alcance
- `php artisan pint` para formateo de código

### Git (se recomienda para el proyecto de curso)
```
main          → rama principal, solo código estable
develop       → integración del equipo
feature/xxx   → ramas de funcionalidades individuales
```

Mensaje de commit sugerido:
```
feat: agregar CRUD de estudiantes con paginación
fix: corregir validación de DNI duplicado
docs: agregar comentarios a la conexión PDO
```

---

## Ideas de proyectos finales para equipos (Unidad 5)

Claude Code puede ayudar a scaffoldear cualquiera de estos desde cero:

1. **Sistema de inventario** para una tienda (productos, categorías, ventas, reportes)
2. **Gestor de turnos** para una clínica (pacientes, doctores, citas, estados)
3. **Plataforma de eventos** (eventos, inscripciones, asistentes, QR de entrada)
4. **Sistema de notas académicas** (materias, estudiantes, calificaciones, boletines)
5. **Tienda online simplificada** (catálogo, carrito en sesión, pedidos)
6. **Blog con roles** (admin publica, editor revisa, lector comenta)

Todos deben incluir: autenticación, al menos 3 entidades relacionadas, CRUD completo,
búsqueda/filtrado, validaciones y una vista de reportes o dashboard.

---

## Cómo usar Claude Code en este proyecto

```bash
# Instalar Claude Code (requiere Node.js 18+)
npm install -g @anthropic-ai/claude-code

# Desde la raíz del proyecto
claude

# Comandos útiles de ejemplo para decirle a Claude:
# "Crea el modelo Estudiante con su migración y la relación con Curso"
# "Agrega validación server-side al formulario de creación de estudiantes"
# "Convierte el CRUD de estudiantes de PHP puro a una API REST que devuelva JSON"
# "Genera seeders con 50 estudiantes de prueba usando Faker"
# "Agrega búsqueda por nombre y DNI con highlight en los resultados"
# "Implementa paginación con filtros que persistan en la URL"
```

---

## Recursos del curso

- Documentación Laravel: https://laravel.com/docs
- PHP Manual: https://www.php.net/manual/es/
- W3Schools JS: https://www.w3schools.com/js/
- Bootstrap 5: https://getbootstrap.com/docs/5.3/
- Tutorial Laravel (complementario): https://www.tutorialspoint.com/laravel/index.htm
