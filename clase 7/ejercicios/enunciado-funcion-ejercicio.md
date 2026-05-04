# Calculadora de Notas con Funciones PHP

**Tema:** Funciones en PHP — definición, parámetros tipados y retorno de valores

---

## Descripción

Crea un archivo PHP llamado `funcion-ejercicio.php` que implemente una calculadora de notas para un estudiante universitario. La aplicación debe mostrar un formulario HTML donde el usuario ingrese sus calificaciones por materia y, al enviarlo, calcule y muestre el promedio junto con un mensaje de resultado.

---

## Requerimientos

**1. Array de materias**

Define un array con las siguientes 4 materias:
- Matemáticas
- Física
- Química
- Lenguaje

**2. Función `promedio()`**

Crea una función llamada `promedio` que:
- Reciba un array de notas como parámetro (tipo `array`)
- Tenga como tipo de retorno `float`
- Calcule y retorne el promedio aritmético de las notas recibidas

**3. Función `mensaje()`**

Crea una función llamada `mensaje` que:
- Reciba un array de notas como parámetro (tipo `array`)
- Tenga como tipo de retorno `string`
- Utilice la función `promedio()` internamente
- Retorne `"Felicidades"` si el promedio es mayor a 50
- Retorne `"Suerte para la próxima"` en caso contrario

**4. Formulario HTML**

Diseña un formulario con:
- Un campo de tipo `number` por cada materia, usando el nombre `notas[]` para que PHP los reciba como array
- Un botón para enviar el formulario mediante `POST`

**5. Procesamiento del POST**

Cuando el formulario sea enviado:
- Detecta la solicitud con `$_SERVER['REQUEST_METHOD'] === 'POST'`
- Muestra el promedio en un `<h1>` con el texto: `Tu nota es: [promedio]`
- Muestra el mensaje en un `<h3>`

---

## Ejemplo de salida esperada

```
Tu nota es: 72.5
Felicidades
```

---

## Conceptos a practicar

- Declaración de funciones con **tipos de parámetros** y **tipos de retorno**
- Uso de `foreach` para recorrer arrays
- Reutilización de funciones (llamar `promedio()` dentro de `mensaje()`)
- Procesamiento de formularios con `$_POST` y arrays en PHP (`name="notas[]"`)
