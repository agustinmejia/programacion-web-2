# Clase 7 — PHP: Funciones y Arreglos Avanzados

**Unidad 3: Fundamentos de PHP**
**Sesión:** Teórico-Práctica | **Tema:** 3.3 + 3.4 | **Semana:** 3

---

## Objetivos de la clase

Al finalizar esta clase el alumno será capaz de:

1. Definir funciones en PHP con parámetros y valor de retorno
2. Distinguir el paso de parámetros por valor vs. por referencia
3. Usar valores por defecto y parámetros con tipo declarado
4. Escribir funciones anónimas y arrow functions (`fn`)
5. Transformar arreglos con `array_map`
6. Filtrar arreglos con `array_filter`
7. Ordenar arreglos por criterio personalizado con `usort`
8. Combinar estas funciones para procesar colecciones de datos reales

---

## Tabla de contenidos

| # | Recurso | Descripción |
|---|---------|-------------|
| 1 | [teoria/php-funciones-arreglos.md](teoria/php-funciones-arreglos.md) | Guía teórica completa con ejemplos inline |
| 2 | [ejemplos/00-arreglos-asociativos.php](ejemplos/00-arreglos-asociativos.php) | Clave→valor, foreach, array_keys/values, colección de registros |
| 3 | [ejemplos/01-funciones.php](ejemplos/01-funciones.php) | Definición, parámetros, retorno, scope |
| 4 | [ejemplos/02-array-map.php](ejemplos/02-array-map.php) | Transformar arreglos con `array_map` |
| 5 | [ejemplos/03-array-filter.php](ejemplos/03-array-filter.php) | Filtrar arreglos con `array_filter` |
| 6 | [ejemplos/04-usort.php](ejemplos/04-usort.php) | Ordenar con criterio personalizado `usort` |
| 7 | [ejemplos/05-integrador.php](ejemplos/05-integrador.php) | Pipeline de datos: map + filter + sort |
| 8 | [ejemplos/index.html](ejemplos/index.html) | Panel para abrir cada ejemplo desde el navegador |
| 9 | [ejercicios/README.md](ejercicios/README.md) | 5 actividades prácticas + 1 desafío optativo |

---

## Conexión con la clase anterior

| Aspecto | Clase 6 | Clase 7 |
|---------|---------|---------|
| Arreglos | Crear, acceder, funciones básicas (`sort`, `count`, `in_array`) | Transformar y filtrar con callbacks |
| Lógica | En el cuerpo del script, secuencial | Encapsulada en funciones reutilizables |
| PHP | Variables, condicionales, bucles | Funciones, closures, arrow functions |

---

## Cómo levantar los ejemplos

1. Copiá la carpeta `clase 7/` dentro de tu servidor local:
   ```
   htdocs/programacion-web-2/clase 7/
   ```

2. Abrí el panel en el navegador:
   ```
   http://localhost/programacion-web-2/clase%207/ejemplos/index.html
   ```

---

## Conceptos clave de la clase

```php
<?php
// 1. Función con parámetro por defecto y tipo
function calcularPromedio(array $notas, int $decimales = 2): float {
    return round(array_sum($notas) / count($notas), $decimales);
}

echo calcularPromedio([75, 88, 92]); // 85.00

// 2. array_map — transforma cada elemento
$notas  = [75, 88, 92, 41, 63];
$dobles = array_map(fn($n) => $n * 2, $notas);
// [150, 176, 184, 82, 126]

// 3. array_filter — filtra por condición
$aprobados = array_filter($notas, fn($n) => $n >= 51);
// [75, 88, 92, 63]

// 4. usort — ordena con criterio propio
$estudiantes = [
    ["nombre" => "Luis",  "nota" => 75],
    ["nombre" => "Sara",  "nota" => 92],
    ["nombre" => "Pedro", "nota" => 60],
];
usort($estudiantes, fn($a, $b) => $b["nota"] <=> $a["nota"]); // desc
// Sara (92), Luis (75), Pedro (60)
```

---

## Próxima clase

**Clase 8 — Superglobales y formularios PHP (Tema 3.5)**
`$_GET`, `$_POST`, `$_REQUEST`. Procesamiento de formularios URL Encoded
y envío/recepción de JSON desde PHP (`json_decode`, `json_encode`).
