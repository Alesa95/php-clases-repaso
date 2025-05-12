<?php
    header("Content-type: application/json");
    include("conexion.php");

    $metodo = $_SERVER["REQUEST_METHOD"];
    $entrada = json_decode(file_get_contents('php://input'), true);

    switch($metodo) {
        case "GET":
            manejarGet($_conexion);
            break;
        case "POST":
            manejarPost($_conexion, $entrada);
            break;
        case "PUT":
            echo json_encode(["metodo" => "put"]);
            break;
        case "DELETE":
            echo json_encode(["metodo" => "delete"]);
            break;
    }

    function manejarGet($_conexion) {
        if(isset($_GET["name"])) {
            $sql = "SELECT * FROM city WHERE name = :name";
            $stmt = $_conexion -> prepare($sql);
            $stmt -> execute([
                "name" => $_GET["name"]
            ]);
        } else if(isset($_GET["country"])) {
            //  sql con el join
            // luego el resto igual
        } else {
            $sql = "SELECT * FROM city";
            $stmt = $_conexion -> prepare($sql);
            $stmt -> execute();
        }

        $resultado = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado);
    }

    function manejarPost($_conexion, $entrada) {
        $sql = "INSERT INTO city (name, countryCode, district, population) 
            VALUES (:name, :countryCode, :district, :population)";
        $stmt = $_conexion -> prepare($sql);
        $stmt -> execute([
            "name" => $entrada["name"],
            "countryCode" => $entrada["countryCode"],
            "district" => $entrada["district"],
            "population" => $entrada["population"]
        ]);
    }
?>