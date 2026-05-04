# Ejercicio: Reporte de Notas

## Descripción

Crear un archivo PHP que permita a un estudiante ingresar su nombre y las notas de
4 materias mediante un formulario. Al enviarlo, el sistema debe mostrar una tabla con
el estado de cada materia y un mensaje final basado en el promedio general.

---

## Materias

Definir un array con los siguientes nombres de materias:

```
Matemáticas, Programación, Inglés, Base de Datos
```

---

## Formulario

El formulario debe contener:
- Un campo de texto para el **nombre** del estudiante.
- Un campo numérico (0–100) por cada materia del array. *(Ayuda: usar un `foreach` para generarlos)*

---

## Funciones a implementar

Debes crear **3 funciones**:

```php
// Recibe una nota entera y devuelve true si es 51 o más, false si no.
function esta_aprobado(int $nota): bool {
    // ...
}

// Recibe un array de notas y devuelve el promedio como decimal.
function calcular_promedio(array $notas): float {
    // ...
}

// Recibe una nota entera y devuelve el string "Aprobado" o "Reprobado".
function obtener_estado(int $nota): string {
    // ...
}
```

---

## Resultados a mostrar (solo si el formulario fue enviado)

1. **Tabla** con tres columnas: `Materia | Nota | Estado`
   - Recorrer con `foreach` las materias y sus notas.
   - Usar `esta_aprobado()` y `obtener_estado()` para mostrar el estado de cada fila.

2. **Promedio general** al pie de la tabla usando `calcular_promedio()`.

3. **Mensaje final:**
   - Si el promedio es aprobatorio → *"¡Felicitaciones! [nombre] aprobó el semestre."*
   - Si no → *"[nombre] no alcanzó el promedio mínimo para aprobar."*

---

## Estructura esperada del archivo

```
ejercicio-notas.php
│
├── <?php ... ?>          ← array de materias + 3 funciones
│
└── HTML
    ├── <form>            ← nombre + notas (foreach sobre $materias)
    └── if POST           ← tabla de resultados + mensaje final
```
