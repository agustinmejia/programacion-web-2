<?php
    // definimis nuestro arreglo de estudiantes con sus información de personal y nota
    $estudiantes = [
        [
            "nombre_completo" => "Ricardo Antelo",
            "ci" => "1561564",
            "nota" => 42
        ],
        [
            "nombre_completo" => "Marcelo Arteaga",
            "ci" => "6545646",
            "nota" => 50
        ],
        [
            "nombre_completo" => "Mario Velez",
            "ci" => "6554678",
            "nota" => 80
        ],
        [
            "nombre_completo" => "Bianca Flores",
            "ci" => "98784785",
            "nota" => 92
        ],
    ];

    // for ($i = 0; $i < count($estudiantes); $i++) {
    //     echo $estudiantes[$i]['nombre_completo'].' '.$estudiantes[$i]['ci'].', nota: '.$estudiantes[$i]['nota'].' pts.<br>';
    // }

    // echo "Lista de alumnos: <br>";
    // foreach($estudiantes as $estudiante){
    //     echo "{$estudiante['nombre_completo']} {$estudiante['ci']}, nota: {$estudiante['nota']} pts.<br>";
    // }

    // // solo los que aprobaron el curso
    // echo "<br><br>Alumnos aprobados: <br>";
    // foreach($estudiantes as $estudiante){
    //     if($estudiante['nota'] > 50){
    //         echo "{$estudiante['nombre_completo']} {$estudiante['ci']}, nota: {$estudiante['nota']} pts.<br>";
    //     }
    // }
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Lista de estudiantes</h2>
    <ol>
        <?php
            // foreach($estudiantes as $estudiante){
            //     echo "<li>{$estudiante['nombre_completo']} {$estudiante['ci']}, nota: {$estudiante['nota']} pts.</li>";
            // }
        ?>
    </ol>
</body>
</html> -->