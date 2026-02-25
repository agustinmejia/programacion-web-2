## Proyectos de la clase

El repositorio contiene dos proyectos paralelos que implementan el **mismo sistema**
(gestión de estudiantes y cursos), permitiendo comparar el enfoque vanilla vs framework:

| Proyecto | Carpeta | Tecnología | Unidades |
|----------|---------|------------|---------|
| Sistema CRUD PHP | [`sistema-crud/`](clase%201/sistema-crud/) | PHP 8 + PDO + Bootstrap 5 | U2, U3 |
| Gestión con Laravel | [`proyecto-laravel/`](clase%201/proyecto-laravel/) | Laravel + Eloquent + Blade | U4 |

---

## Proyecto 1 — Sistema CRUD en PHP puro

Sistema de gestión escolar desarrollado con **PHP 8**, **MySQL** y **Bootstrap 5**.
Incluye autenticación de usuarios y un CRUD completo para la administración de estudiantes.

**Funcionalidades:**
- Login seguro con sesiones PHP y protección de rutas
- Listado de estudiantes con búsqueda y filtros (por curso y estado)
- Alta, edición y baja de estudiantes
- Contraseñas hasheadas con `password_hash()`, SQL con prepared statements

**Instalación rápida:**
1. Copiar `sistema-crud/` al directorio raíz del servidor local (XAMPP, WAMP, Laragon)
2. Importar `database.sql` en MySQL / phpMyAdmin
3. Configurar credenciales en `config/database.php`
4. Acceder a `http://localhost/sistema-crud/`

**Credenciales demo:** `admin@sistema.com` / `password`

---

## Proyecto 2 — Sistema en Laravel

Misma aplicación construida con **Laravel**, para que los alumnos aprendan el framework
sobre un dominio ya conocido.

**Instalación rápida:**
```bash
cd "proyecto-laravel"
composer install
cp .env.example .env
php artisan key:generate
# Configurar DB en .env, luego:
php artisan migrate:fresh --seed
php artisan serve
```

Acceder a `http://localhost:8000`

---

## Estructura del repositorio

```
/
├── README.md
├── CLAUDE.md                        ← instrucciones para Claude Code
│
└── 
    ├── sistema-crud/                ← PHP puro
    │   ├── index.php
    │   ├── database.sql
    │   ├── config/database.php
    │   ├── auth/
    │   │   ├── login.php
    │   │   └── logout.php
    │   ├── includes/
    │   │   ├── auth_check.php
    │   │   ├── header.php
    │   │   ├── navbar.php
    │   │   └── footer.php
    │   └── students/
    │       ├── index.php
    │       ├── create.php
    │       ├── edit.php
    │       └── delete.php
    │
    └── proyecto-laravel/            ← Laravel
        ├── app/Http/Controllers/
        │   ├── EstudianteController.php
        │   └── AuthController.php
        ├── app/Models/
        │   ├── Estudiante.php
        │   └── Curso.php
        ├── database/
        ├── resources/views/
        └── routes/web.php
```

---

## Base de datos

Ambos proyectos usan el mismo esquema (3 tablas):

| Tabla | Descripción |
|-------|-------------|
| `usuarios` | Cuentas del sistema para el login |
| `cursos` | Catálogo de cursos disponibles |
| `estudiantes` | Entidad principal del CRUD |

- PHP puro → base de datos `gestion_estudiantes`
- Laravel → base de datos `gestion_estudiantes_laravel`

---