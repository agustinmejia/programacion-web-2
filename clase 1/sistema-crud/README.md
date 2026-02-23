# GestiEstudiantes

Sistema de gestión escolar desarrollado en PHP con MySQL y Bootstrap 5. Incluye autenticación de usuarios y un CRUD completo para la administración de estudiantes.

---

## Tecnologías

- **Backend:** PHP 8+ con PDO
- **Base de datos:** MySQL 5.7+
- **Frontend:** Bootstrap 5.3 + Bootstrap Icons (via CDN)
- **Servidor local:** XAMPP / WAMP / Laragon

---

## Estructura del proyecto

```
sistema-crud/
├── index.php                  # Entrada: redirige según sesión activa
├── database.sql               # Script completo de MySQL
├── README.md
│
├── config/
│   └── database.php           # Conexión PDO (configurar credenciales aquí)
│
├── auth/
│   ├── login.php              # Formulario de inicio de sesión
│   └── logout.php             # Cierra sesión y redirige al login
│
├── includes/
│   ├── auth_check.php         # Protege páginas privadas (requiere sesión)
│   ├── header.php             # HTML head + estilos globales
│   ├── navbar.php             # Barra de navegación con menú de usuario
│   └── footer.php             # Scripts JS + cierre HTML
│
└── students/
    ├── index.php              # Listado con búsqueda y filtros
    ├── create.php             # Formulario de alta de estudiante
    ├── edit.php               # Formulario de edición
    └── delete.php             # Eliminación (solo acepta POST)
```

---

## Base de datos

El script `database.sql` crea automáticamente:

| Tabla          | Descripción                                      |
|----------------|--------------------------------------------------|
| `usuarios`     | Cuentas del sistema para el login                |
| `cursos`       | Catálogo de cursos disponibles                   |
| `estudiantes`  | Tabla principal del CRUD                         |

### Campos de `estudiantes`

| Campo       | Tipo                                  | Descripción              |
|-------------|---------------------------------------|--------------------------|
| id          | INT UNSIGNED (PK)                     | Identificador único      |
| nombre      | VARCHAR(100)                          | Nombre del estudiante    |
| apellido    | VARCHAR(100)                          | Apellido                 |
| dni         | VARCHAR(20) UNIQUE                    | Documento de identidad   |
| email       | VARCHAR(150)                          | Correo electrónico       |
| telefono    | VARCHAR(30)                           | Teléfono (opcional)      |
| fecha_nac   | DATE                                  | Fecha de nacimiento      |
| curso_id    | FK → cursos.id                        | Curso asignado           |
| estado      | ENUM(activo, inactivo, suspendido)    | Estado del estudiante    |
| created_at  | TIMESTAMP                             | Fecha de creación        |
| updated_at  | TIMESTAMP                             | Última modificación      |

---

## Instalación

### 1. Clonar o copiar el proyecto

Colocar la carpeta `sistema-crud/` dentro del directorio raíz del servidor:

- XAMPP → `C:/xampp/htdocs/sistema-crud/`
- WAMP → `C:/wamp64/www/sistema-crud/`
- Laragon → `C:/laragon/www/sistema-crud/`

### 2. Importar la base de datos

Desde phpMyAdmin o consola MySQL:

```sql
-- Opción A: consola
mysql -u root -p < database.sql

-- Opción B: phpMyAdmin
-- Ir a "Importar" y seleccionar el archivo database.sql
```

### 3. Configurar la conexión

Editar `config/database.php` con las credenciales del entorno:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'gestion_estudiantes');
define('DB_USER', 'root');   // tu usuario MySQL
define('DB_PASS', '');       // tu contraseña MySQL
```

### 4. Acceder al sistema

Abrir en el navegador:

```
http://localhost/sistema-crud/
```

---

## Credenciales de acceso (demo)

| Campo    | Valor               |
|----------|---------------------|
| Email    | admin@sistema.com   |
| Password | password            |

> Para crear un nuevo hash de contraseña usar: `password_hash('tu_password', PASSWORD_DEFAULT)`

---

## Funcionalidades

### Autenticación
- Login con email y contraseña
- Sesiones PHP seguras con `session_regenerate_id`
- Protección de rutas mediante `auth_check.php`
- Logout con destrucción completa de sesión

### CRUD de estudiantes
| Operación | Archivo         | Descripción                            |
|-----------|-----------------|----------------------------------------|
| Listar    | `index.php`     | Tabla con búsqueda y filtros           |
| Crear     | `create.php`    | Formulario con validaciones            |
| Editar    | `edit.php`      | Formulario prellenado con datos        |
| Eliminar  | `delete.php`    | Confirmación via modal, solo POST      |

### Búsqueda y filtros (en el listado)
- Búsqueda por nombre, apellido, DNI o email
- Filtro por curso
- Filtro por estado (activo / inactivo / suspendido)

---

## Seguridad implementada

- **SQL Injection:** consultas preparadas con PDO en todas las operaciones
- **XSS:** escapado con `htmlspecialchars()` en todas las salidas HTML
- **CSRF básico:** eliminación solo via POST (no se puede disparar por URL)
- **Passwords:** almacenados con `password_hash()` y verificados con `password_verify()`
- **Sesiones:** regeneración de ID al autenticarse correctamente

---

## Capturas de pantalla

| Pantalla      | Ruta                      |
|---------------|---------------------------|
| Login         | `/auth/login.php`         |
| Listado       | `/students/index.php`     |
| Nuevo         | `/students/create.php`    |
| Editar        | `/students/edit.php?id=1` |
