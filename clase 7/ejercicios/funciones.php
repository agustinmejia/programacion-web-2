<?php
    // // declaraciones de función
    // function saludar($nombre_persona, $saludo = "Hola") {
    //     return "$saludo, soy $nombre_persona<br>";
    // }


    // // Llamada de la función
    // echo saludar("Juan");
    // echo saludar("Ana");
    // echo saludar("Ariel", "Que tal");
    // echo saludar("José");
    // echo saludar("Martha");


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


    // // devolver estudiantes aprobados
    // foreach ($estudiantes as $estudiante) {
    //     if (esta_aprobado($estudiante)){
    //         echo "{$estudiante['nombre_completo']}<br>";
    //     }
    // }



    // // Ésta función calcula si un estudiante tiene nota de 51 en adelante y devuelve true, sino devuelve false
    // function esta_aprobado(array $alumno): bool {
    //     if ($alumno['nota'] > 50) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    aprobados($estudiantes);

    // Ésta función calcula si un estudiante tiene nota de 51 en adelante y devuelve true, sino devuelve false
    function aprobados(array $alumnos) {
        foreach ($alumnos as $alumno) {
            if ($alumno['nota'] > 50){
                echo "{$alumno['nombre_completo']}<br>";
            }
        }
    }