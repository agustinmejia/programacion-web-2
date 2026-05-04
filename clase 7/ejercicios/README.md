# Ejercicios — Clase 7: Funciones y Arreglos Avanzados

**Duración estimada:** 70-90 minutos
**Modalidad:** Individual o en parejas

> Creá un archivo `.php` por ejercicio dentro de tu carpeta personal.
> Todos los archivos deben correr en `localhost` con XAMPP/Laragon.

---

## Ejercicio 1 — Funciones básicas (15 min)

Creá el archivo `ej1-funciones.php` con las siguientes funciones:

**1a. `calcularDescuento`**
```php
function calcularDescuento(float $precio, float $porcentaje = 10): float
```
- Retorna el precio con el descuento aplicado
- `$porcentaje` tiene valor por defecto de 10%
- Probá con: `calcularDescuento(200)`, `calcularDescuento(200, 25)`, `calcularDescuento(500, 50)`

**1b. `clasificarNota`**
```php
function clasificarNota(int $nota): string
```
- Retorna `"Excelente"` (90-100), `"Bueno"` (75-89), `"Regular"` (51-74), `"Reprobado"` (0-50)
- Usá `match` (PHP 8)
- Probá con al menos 6 notas distintas

**1c. `nombreCompleto`**
```php
function nombreCompleto(string $nombre, string $apellido, bool $invertido = false): string
```
- Si `$invertido` es `false`: retorna `"Ana García"`
- Si `$invertido` es `true`: retorna `"García, Ana"`

**Resultado esperado:** una tabla Bootstrap con los resultados de cada función.

---

## Ejercicio 2 — `array_map` (15 min)

Creá `ej2-array-map.php`.

Dado este arreglo de productos:
```php
$productos = [
    ["nombre" => "Notebook",  "precio" => 1200, "categoria" => "tecnologia"],
    ["nombre" => "Teclado",   "precio" => 85,   "categoria" => "tecnologia"],
    ["nombre" => "Mochila",   "precio" => 60,   "categoria" => "accesorios"],
    ["nombre" => "Monitor",   "precio" => 350,  "categoria" => "tecnologia"],
    ["nombre" => "Auriculares","precio" => 45,  "categoria" => "accesorios"],
];
```

Usá `array_map` para:
- **2a.** Agregar a cada producto el campo `"precio_con_iva"` (precio × 1.13)
- **2b.** Extraer solo los nombres en un arreglo de strings
- **2c.** Agregar el campo `"etiqueta"` con el formato `"NOMBRE - $PRECIO Bs"`
  (el nombre en mayúsculas, usando `strtoupper()`)

Mostrá el resultado de cada transformación en una tabla o lista Bootstrap.

---

## Ejercicio 3 — `array_filter` (15 min)

Creá `ej3-array-filter.php`.

Usando el mismo arreglo de productos del ejercicio 2:

- **3a.** Filtrar solo los productos con precio mayor a 100
- **3b.** Filtrar solo los de categoría `"tecnologia"`
- **3c.** Filtrar los que son de tecnología **Y** cuestan menos de 500
- **3d.** Mostrá cuántos productos quedaron en cada filtro

> Recordá usar `array_values()` para reindexar si vas a iterar con índice numérico.

**Resultado esperado:** 3 secciones, cada una con su lista de productos filtrados
y un badge que muestre la cantidad resultante.

---

## Ejercicio 4 — `usort` (20 min)

Creá `ej4-usort.php`.

Dado este arreglo de empleados:
```php
$empleados = [
    ["nombre" => "Roberto", "departamento" => "Ventas",    "salario" => 3500],
    ["nombre" => "Marta",   "departamento" => "IT",        "salario" => 5200],
    ["nombre" => "Carlos",  "departamento" => "Ventas",    "salario" => 2800],
    ["nombre" => "Elena",   "departamento" => "IT",        "salario" => 4800],
    ["nombre" => "Jorge",   "departamento" => "RRHH",      "salario" => 3100],
    ["nombre" => "Patricia","departamento" => "IT",        "salario" => 5500],
    ["nombre" => "Miguel",  "departamento" => "RRHH",      "salario" => 2900],
];
```

- **4a.** Ordenar por salario de mayor a menor
- **4b.** Ordenar por nombre alfabéticamente (A → Z)
- **4c.** Ordenar por departamento (A → Z) y dentro de cada departamento, por salario de mayor a menor
- **4d.** Mostrar cada ordenamiento en una tabla separada

---

## Ejercicio 5 — Integrador (25 min)

Creá `ej5-integrador.php`.

Dado este arreglo de estudiantes:
```php
$estudiantes = [
    ["nombre" => "Ana",     "curso" => "PHP",    "p1" => 80, "p2" => 75, "p3" => 90],
    ["nombre" => "Bruno",   "curso" => "Laravel","p1" => 45, "p2" => 50, "p3" => 40],
    ["nombre" => "Claudia", "curso" => "PHP",    "p1" => 92, "p2" => 88, "p3" => 95],
    ["nombre" => "Daniel",  "curso" => "MySQL",  "p1" => 60, "p2" => 55, "p3" => 70],
    ["nombre" => "Elena",   "curso" => "PHP",    "p1" => 35, "p2" => 40, "p3" => 30],
    ["nombre" => "Felipe",  "curso" => "Laravel","p1" => 78, "p2" => 82, "p3" => 70],
    ["nombre" => "Gabriela","curso" => "MySQL",  "p1" => 90, "p2" => 95, "p3" => 88],
];
```

Aplicá el siguiente pipeline **sin modificar `$estudiantes`**:

1. **`array_map`** — agregar `"promedio"` (promedio de p1, p2, p3), `"aprobado"` (bool) y `"estado"` (string)
2. **`array_filter`** — quedarse solo con los aprobados (promedio >= 51)
3. **`usort`** — ordenar por promedio de mayor a menor

Luego mostrá:
- Un **dashboard** con: total de estudiantes, aprobados, reprobados, promedio general
- Una **tabla de aprobados** ordenada con barras de progreso para el promedio
- Una **lista de reprobados** (los que no pasaron el filtro) con sus promedios

---

## Ejercicio Optativo — Función reutilizable de pipeline

Creá `ej-opt-pipeline.php`:

Escribí una función `procesarEstudiantes` que reciba el arreglo y tres parámetros:
- `string $curso` — filtrar por curso (`"todos"` para no filtrar)
- `string $orden` — `"asc"` o `"desc"` por promedio
- `int $minimo` — nota mínima para aprobar (por defecto 51)

La función debe retornar el arreglo procesado con map + filter + sort aplicados.

```php
function procesarEstudiantes(
    array $estudiantes,
    string $curso    = "todos",
    string $orden    = "desc",
    int    $minimo   = 51
): array { ... }
```

Probá llamándola de al menos 3 formas distintas y mostrá cada resultado.

---

## Criterios de evaluación

| Criterio | Puntos |
|----------|--------|
| Funciones con tipos y valores por defecto correctos | 15 |
| `array_map` transforma sin modificar el original | 20 |
| `array_filter` filtra correctamente + `array_values` | 20 |
| `usort` con criterio simple y compuesto | 20 |
| Ejercicio integrador: pipeline completo | 15 |
| HTML válido, Bootstrap y `htmlspecialchars()` | 10 |
| **Total** | **100** |
