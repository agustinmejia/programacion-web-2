# Ejercicios: valor, referencia y scope

**Tema:** Funciones en PHP, paso por valor, paso por referencia y alcance de variables.

Estos ejercicios son cortos y están pensados para ver claramente qué cambia y qué no cambia cuando una variable entra a una función.

---

## Ejercicio 1 - Bonus de nota: por valor vs. por referencia

### Enunciado

Crear un archivo PHP llamado `ej1-valor-referencia.php`.

Tienes una nota inicial:

```php
$nota = 45;
```

Debes crear dos funciones:

```php
function sumarBonusValor(int $nota): int
```

- Recibe una nota.
- Le suma 10 puntos.
- Retorna la nueva nota.
- No debe modificar la variable original.

```php
function sumarBonusReferencia(int &$nota): void
```

- Recibe una nota por referencia.
- Le suma 10 puntos.
- Modifica directamente la variable original.
- No retorna nada.

Luego muestra en pantalla:

- La nota original antes de llamar a las funciones.
- El resultado de llamar a `sumarBonusValor($nota)`.
- El valor de `$nota` después de llamar a `sumarBonusValor`.
- El valor de `$nota` después de llamar a `sumarBonusReferencia`.

### Pregunta para responder

¿Cuál función cambia la variable original y cuál no?

### Respuesta esperada

```php
<?php

function sumarBonusValor(int $nota): int {
    $nota = $nota + 10;
    return $nota;
}

function sumarBonusReferencia(int &$nota): void {
    $nota = $nota + 10;
}

$nota = 45;

echo "Nota original: $nota<br>";

$notaConBonus = sumarBonusValor($nota);

echo "Resultado por valor: $notaConBonus<br>";
echo "Nota original despues de sumarBonusValor: $nota<br>";

sumarBonusReferencia($nota);

echo "Nota original despues de sumarBonusReferencia: $nota<br>";
```

### Salida aproximada

```text
Nota original: 45
Resultado por valor: 55
Nota original despues de sumarBonusValor: 45
Nota original despues de sumarBonusReferencia: 55
```

### Explicación

`sumarBonusValor()` recibe una copia de `$nota`, por eso la variable original sigue valiendo `45`.

`sumarBonusReferencia()` recibe la variable original usando `&`, por eso modifica directamente `$nota` y queda en `55`.

---

## Ejercicio 2 - Precio con descuento: scope de variables

### Enunciado

Crear un archivo PHP llamado `ej2-scope.php`.

Tienes estas variables fuera de una función:

```php
$precio = 200;
$descuento = 0.15;
```

Debes crear una función llamada `precioFinal`:

```php
function precioFinal(float $precio, float $descuento): float
```

La función debe:

- Recibir el precio como parámetro.
- Recibir el descuento como parámetro.
- Calcular el precio final.
- Retornar el resultado redondeado a 2 decimales.

Importante: no uses directamente `$descuento` dentro de la función si no fue recibido como parámetro.

Luego muestra:

- El precio original.
- El porcentaje de descuento.
- El precio final.

### Pregunta para responder

¿Por qué la función necesita recibir `$descuento` como parámetro si esa variable ya existe fuera?

### Respuesta esperada

```php
<?php

function precioFinal(float $precio, float $descuento): float {
    $resultado = $precio - ($precio * $descuento);
    return round($resultado, 2);
}

$precio = 200;
$descuento = 0.15;

$final = precioFinal($precio, $descuento);

echo "Precio original: $precio Bs<br>";
echo "Descuento: " . ($descuento * 100) . "%<br>";
echo "Precio final: $final Bs<br>";
```

### Salida aproximada

```text
Precio original: 200 Bs
Descuento: 15%
Precio final: 170 Bs
```

### Explicación

Las variables creadas fuera de una función no existen automáticamente dentro de ella.

Por eso `precioFinal()` debe recibir `$precio` y `$descuento` como parámetros. Así la función no depende de variables externas y se puede reutilizar con otros valores:

```php
echo precioFinal(100, 0.10); // 90
echo precioFinal(500, 0.20); // 400
```
