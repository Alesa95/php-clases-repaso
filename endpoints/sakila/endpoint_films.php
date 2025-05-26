<?php
    error_reporting( E_ALL );
    ini_set("display_errores", 1);

    header("Content-Type: application/json");
    include("conexion.php");

    $metodo = $_SERVER["REQUEST_METHOD"];
    $_entrada = json_decode(file_get_contents('php://input'), true);

    switch($metodo) {
        case "GET":
            manejarGet($_conexion);
            break;
        case "POST":
            manejarPost($_conexion, $_entrada);
            break;
        case "PUT":
            manejarPut($_conexion, $_entrada);
            break;
        case "DELETE":
            manejarDelete($_conexion, $_entrada);
            break;
    }

    function manejarGet($_conexion) {
        if(isset($_GET["rating"])) {
            $sql = "SELECT * FROM film WHERE rating = :rating";
            $stmt = $_conexion -> prepare($sql);
            $stmt -> execute([
                "rating" => $_GET["rating"]
            ]);
        } else {
            $sql = "SELECT * FROM film";
            $stmt = $_conexion -> prepare($sql);
            $stmt -> execute();
        }
        $resultado = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado);
    }

    function manejarPost($_conexion, $_entrada) {
        $sql = "INSERT INTO film 
        (
            title, 
            release_year, 
            language_id, 
            rental_duration,
            rental_rate,
            replacement_cost,
            rating
            )
        VALUES 
        (
            :title, 
            :release_year, 
            :language_id, 
            :rental_duration,
            :rental_rate,
            :replacement_cost,
            :rating
        )";
        $stmt = $_conexion -> prepare($sql);
        $stmt -> execute([
            "title" => $_entrada["title"],
            "release_year" => $_entrada["release_year"],
            "language_id" => $_entrada["language_id"],
            "rental_duration" => $_entrada["rental_duration"],
            "rental_rate" => $_entrada["rental_rate"],
            "replacement_cost" => $_entrada["replacement_cost"],
            "rating" => $_entrada["rating"]
        ]);
        if($stmt) {
            echo json_encode(["mensaje" => "todo ok"]);
        } else {
            echo json_encode(["mensaje" => "la vida no está ok"]);
        }
    }
?>