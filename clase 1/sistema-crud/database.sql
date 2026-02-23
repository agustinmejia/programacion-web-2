-- ============================================
-- Sistema de Gestión de Estudiantes
-- Script de base de datos MySQL
-- ============================================

CREATE DATABASE IF NOT EXISTS gestion_estudiantes
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE gestion_estudiantes;

-- Tabla de usuarios del sistema (para login)
CREATE TABLE IF NOT EXISTS usuarios (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre     VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    rol        ENUM('admin', 'editor') NOT NULL DEFAULT 'editor',
    activo     TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Usuario por defecto: admin / admin123
INSERT INTO usuarios (nombre, email, password, rol) VALUES
('Administrador', 'admin@sistema.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
-- password en texto plano: "password"
-- Para generar tu propio hash usa: password_hash('tu_password', PASSWORD_DEFAULT)

-- Tabla de cursos
CREATE TABLE IF NOT EXISTS cursos (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre     VARCHAR(100) NOT NULL,
    descripcion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO cursos (nombre, descripcion) VALUES
('Matemáticas',   'Álgebra, cálculo y geometría'),
('Lengua',        'Literatura y gramática española'),
('Historia',      'Historia universal y argentina'),
('Ciencias',      'Biología, física y química'),
('Programación',  'Introducción a la programación'),
('Inglés',        'Idioma inglés nivel básico-intermedio');

-- Tabla principal de estudiantes (CRUD)
CREATE TABLE IF NOT EXISTS estudiantes (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre       VARCHAR(100) NOT NULL,
    apellido     VARCHAR(100) NOT NULL,
    dni          VARCHAR(20)  NOT NULL UNIQUE,
    email        VARCHAR(150) NOT NULL,
    telefono     VARCHAR(30),
    fecha_nac    DATE,
    curso_id     INT UNSIGNED,
    estado       ENUM('activo', 'inactivo', 'suspendido') NOT NULL DEFAULT 'activo',
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Datos de ejemplo
INSERT INTO estudiantes (nombre, apellido, dni, email, telefono, fecha_nac, curso_id, estado) VALUES
('Lucas',    'García',    '38111222', 'lucas.garcia@mail.com',    '11-1111-1111', '2008-03-15', 5, 'activo'),
('Valentina','López',     '39222333', 'val.lopez@mail.com',       '11-2222-2222', '2007-07-22', 1, 'activo'),
('Mateo',    'Martínez',  '40333444', 'mateo.m@mail.com',         '11-3333-3333', '2009-01-10', 2, 'activo'),
('Sofía',    'Rodríguez', '41444555', 'sofi.r@mail.com',          '11-4444-4444', '2008-11-05', 3, 'inactivo'),
('Santiago', 'Fernández', '42555666', 'santi.f@mail.com',         '11-5555-5555', '2007-04-18', 4, 'activo'),
('Camila',   'González',  '43666777', 'cami.g@mail.com',          NULL,           '2009-09-30', 6, 'activo');
