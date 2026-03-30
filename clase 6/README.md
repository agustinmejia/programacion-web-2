# Clase 6 — PHP: Fundamentos del lenguaje

**Unidad 3: Fundamentos de PHP**
**Sesión:** Teórico-Práctica | **Tema:** 3.1 + 3.2 + 3.3 | **Semana:** 3

> **Nota docente:** Esta clase se insertó como nivelación antes del mini-proyecto
> integrador de la U2. Si los alumnos no dominan todos los conceptos, los temas de
> arreglos y funciones de arreglos se expanden en la **Clase 6b**.

---

## Objetivos de la clase

Al finalizar esta clase el alumno será capaz de:

1. Declarar variables en PHP y distinguir los tipos de datos primitivos
2. Usar operadores aritméticos, de comparación, lógicos y de concatenación
3. Controlar el flujo del programa con `if/elseif/else`, `switch` y `match`
4. Recorrer datos con los bucles `for`, `while`, `do-while` y `foreach`
5. Crear y manipular arreglos indexados y asociativos
6. Aplicar funciones básicas de arreglos (`count`, `array_push`, `in_array`, `array_keys`, `array_values`)

---

## Tabla de contenidos

| # | Recurso | Descripción |
|---|---------|-------------|
| 1 | [teoria/php-fundamentos.md](teoria/php-fundamentos.md) | Guía teórica completa con ejemplos inline |
| 2 | [ejemplos/01-variables.php](ejemplos/01-variables.php) | Variables, tipos de datos y conversión |
| 3 | [ejemplos/02-operadores.php](ejemplos/02-operadores.php) | Operadores aritméticos, comparación y lógicos |
| 4 | [ejemplos/03-condicionales.php](ejemplos/03-condicionales.php) | if/elseif/else, switch, match |
| 5 | [ejemplos/04-bucles.php](ejemplos/04-bucles.php) | for, while, do-while, foreach |
| 6 | [ejemplos/05-arreglos.php](ejemplos/05-arreglos.php) | Arreglos indexados, asociativos y multidimensionales |
| 7 | [ejemplos/index.html](ejemplos/index.html) | Panel para abrir cada ejemplo desde el navegador |
| 8 | [ejercicios/README.md](ejercicios/README.md) | 5 actividades prácticas + 1 desafío optativo |
| 9 | [slides.html](slides.html) | Presentación Reveal.js |

---

## Diferencias respecto a la clase anterior

| Aspecto | Clase 5 | Clase 6 |
|---------|---------|---------|
| Foco | Formularios HTML y `$_POST` / `$_GET` | Sintaxis nativa de PHP |
| PHP | Leer y validar datos de un form | Variables, estructuras, arreglos |
| Rol del navegador | Envía el formulario | Solo muestra la salida PHP |
| Conexión con U3 | Puente entre front y back | Base para lógica de negocio |

---

## Cómo levantar los ejemplos

1. Copiá la carpeta `clase 6/` dentro de tu servidor local (XAMPP / Laragon):
   ```
   htdocs/programacion-web-2/clase 6/
   ```

2. Abrí el panel de ejemplos en el navegador:
   ```
   http://localhost/programacion-web-2/clase%206/ejemplos/index.html
   ```

3. Desde ahí podés navegar a cada archivo `.php` directamente.

---

## Conceptos clave de la clase

```php
<?php
// 1. Variables — siempre empiezan con $
$nombre = "Ana";
$edad   = 20;
$activo = true;

// 2. Condicional
if ($edad >= 18) {
    echo "$nombre es mayor de edad";
} else {
    echo "$nombre es menor de edad";
}

// 3. Bucle foreach sobre un arreglo
$cursos = ["PHP", "Laravel", "MySQL"];
foreach ($cursos as $curso) {
    echo "- $curso\n";
}

// 4. Arreglo asociativo
$estudiante = [
    "nombre" => "Ana",
    "dni"    => "12345678",
    "nota"   => 85
];
echo $estudiante["nombre"]; // Ana
```

---

## Próxima clase

**Clase 6b (opcional) — PHP: Funciones y arreglos avanzados**
Si los alumnos necesitan más práctica: definición de funciones, parámetros,
`return`, `array_map`, `array_filter`, `usort` y arreglos multidimensionales.

**Clase 7 — Mini-proyecto integrador U2**
Formulario que consume un endpoint PHP y actualiza la UI sin recargar la página.
Entregable de la Unidad 2.
