<?php
    $materias = ["Matemáticas", "Física", "Química", "Lenguaje"];

    function promedio(array $notas): float {
        $suma = 0;
        foreach ($notas as $nota) {
            $suma = $suma + $nota;
        }

        return $suma / count($notas);
    }

    function mensaje(array $notas): string {
        if (promedio($notas) > 50) {
            return "Felicidades";
        }
        return "Suerte para la próxima";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "<h1>Tu nota es: ".promedio($_POST['notas'])."</h1>";
        echo "<h3>".mensaje($_POST['notas'])."</h3>";

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de notas</title>

    <style>
        input {
            margin-top: 10px;
            padding: 5px
        }
        label {
            font-weight: bold
        }
    </style>
</head>
<body>
    <h2>Calcular</h2>
    <form action="" method="POST">
        <label>Matemáticas</label>
        <input type="number" name="notas[]" /> <br>

        <label>Física</label>
        <input type="number" name="notas[]" /> <br>

        <label>Química</label>
        <input type="number" name="notas[]" /> <br>

        <label>Lenguaje</label>
        <input type="number" name="notas[]" /> <br>

        <br><br>
        <button type="submit">Calcular</button>
    </form>
</body>
</html>