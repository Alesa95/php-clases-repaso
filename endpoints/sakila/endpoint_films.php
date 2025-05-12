<?php
    error_reporting( E_ALL );
    ini_set("display_errores", 1);

    header("Content-Type: application/json");
    include("conexion.php");

    $metodo = $_SERVER["REQUEST_METHOD"];

    switch($metodo) {
        case "GET":
            manejarGet($_conexion);
            break;
        case "POST":
            echo json_encode(["mensaje" => "POST"]);
            break;
        case "PUT":
            echo json_encode(["mensaje" => "PUT"]);
            break;
        case "DELETE":
            echo json_encode(["mensaje" => "DELETE"]);
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
?>