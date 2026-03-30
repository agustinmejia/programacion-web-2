# Ejercicios — Clase 6: PHP Fundamentos

**Duración estimada:** 60-90 minutos
**Modalidad:** Individual o en parejas

> Creá un archivo `.php` por ejercicio dentro de tu carpeta personal.
> Todos los archivos deben correr en `localhost` con XAMPP/Laragon.

---

## Ejercicio 1 — Variables y tipos (15 min)

Creá el archivo `ej1-mi-perfil.php` que muestre en una tabla HTML la siguiente
información tuya, usando variables PHP:

| Campo | Tipo esperado |
|-------|--------------|
| Nombre completo | string |
| Edad | int |
| Promedio de la gestión pasada | float |
| ¿Estás inscripto en la materia? | bool |
| Ciudad de nacimiento | string |

**Requisitos:**
- Cada variable debe tener el tipo correcto (no todo como string)
- Mostrar el tipo de cada una con `gettype()`
- Usar `htmlspecialchars()` al imprimir strings en HTML

**Resultado esperado:** tabla con 5 filas: campo | valor | tipo

---

## Ejercicio 2 — Condicionales (15 min)

Creá `ej2-calculadora-notas.php`. El archivo debe:

1. Tener una variable `$nota` con un valor entre 0 y 100
2. Usar `if/elseif/else` para determinar:
   - 90-100 → "Excelente" (verde)
   - 70-89  → "Aprobado" (azul)
   - 51-69  → "Regular" (amarillo)
   - 0-50   → "Reprobado" (rojo)
3. Mostrar el resultado con un badge de Bootstrap del color correspondiente
4. **Plus:** aceptar la nota desde la URL con `$_GET['nota']` y validarla con `isset()`

---

## Ejercicio 3 — Bucles (20 min)

Creá `ej3-bucles.php` con tres secciones:

**3a. Tabla de multiplicar** con `for`:
- El número de la tabla también debe venir de la URL: `?numero=7`
- Si no hay parámetro, usar 5 como defecto
- Mostrar del 1 al 12

**3b. FizzBuzz** con `for` + condicionales:
- Del 1 al 30
- Si es divisible por 3 → "Fizz" (badge verde)
- Si es divisible por 5 → "Buzz" (badge azul)
- Si es divisible por ambos → "FizzBuzz" (badge rojo)
- Si no → el número

**3c. Lista de cursos** con `foreach`:
- Definí un arreglo con al menos 5 materias que cursás
- Mostrá la lista numerada (usando el índice del foreach)

---

## Ejercicio 4 — Arreglos (20 min)

Creá `ej4-arreglos.php`:

**Parte A — Arreglo indexado:**
```php
$materias = ["Matemáticas", "Programación Web I", "Programación Web II", "Base de Datos", "Redes"];
```
Mostrá:
- Total de materias con `count()`
- La primera y última materia
- Las materias en orden inverso con `array_reverse()`

**Parte B — Arreglo asociativo:**
```php
$perfil = [
    "nombre"   => "tu nombre",
    "carrera"  => "Ingeniería de Sistemas",
    "semestre" => 3,
    "promedio" => 7.5,
];
```
Mostrá el perfil en una tarjeta Bootstrap. Agregá una clave `"ciudad"` con `$perfil["ciudad"] = "..."`
y verificá con `isset()` que existe antes de mostrarla.

**Parte C — Arreglo multidimensional:**
Creá un arreglo `$compañeros` con al menos 3 compañeros de clase
(nombre, carrera, semestre). Mostrá la lista en una tabla HTML.

---

## Ejercicio 5 — Integrador (desafío, 20 min)

Creá `ej5-estadisticas.php`:

Dado el siguiente arreglo de notas de un grupo:
```php
$notas = [75, 42, 88, 61, 95, 50, 73, 39, 82, 67];
```

Calculá y mostrá:
- [ ] Cantidad total de alumnos
- [ ] Nota más alta y más baja (`max`, `min`)
- [ ] Promedio del grupo (suma / cantidad)
- [ ] Cantidad de aprobados (>= 51) y reprobados
- [ ] Lista de notas ordenada de mayor a menor
- [ ] Mostrar cada nota en una barra de progreso Bootstrap cuyo ancho sea `$nota . "%"`

**Plus:** diferenciar con color si la nota es aprobatoria o no.

---

## Ejercicio Optativo — Match y switch

Creá `ej-opt-dias.php`:

1. Definí una variable `$dia` con el nombre de un día de la semana
2. Usá `switch` para mostrar las materias que tenés ese día
3. Reescribí lo mismo usando `match` (PHP 8)
4. Mostrá ambas versiones en la pantalla con el resultado

---

## Criterios de evaluación

| Criterio | Puntos |
|----------|--------|
| Variables con tipos correctos (no todo string) | 10 |
| Condicionales que funcionan correctamente | 20 |
| Bucles sin errores y resultado correcto | 20 |
| Arreglos: acceso, modificación, funciones | 30 |
| HTML válido y uso de `htmlspecialchars()` | 10 |
| Ejercicio 5 (integrador) | 10 |
| **Total** | **100** |
