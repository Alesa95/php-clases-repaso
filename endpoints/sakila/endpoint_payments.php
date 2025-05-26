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
        if(isset($_GET["p_desde"]) && isset($_GET["p_hasta"])) {
            if(isset($_GET["f_desde"]) && isset($_GET["f_hasta"])) {
                $sql = "SELECT * FROM payment WHERE 
                    (amount BETWEEN :p_desde AND :p_hasta)
                    AND
                    (payment_date BETWEEN :f_desde AND :f_hasta)";
                $stmt = $_conexion -> prepare($sql);
                $stmt -> execute([
                    "p_desde" => $_GET["p_desde"],
                    "p_hasta" => $_GET["p_hasta"],
                    "f_desde" => $_GET["f_desde"],
                    "f_hasta" => $_GET["f_hasta"]
                ]);
            } elseif(isset($_GET["f_desde"])) {
                $sql = "SELECT * FROM payment WHERE 
                    (amount BETWEEN :p_desde AND :p_hasta)
                    AND
                    (payment_date >= f_desde)";
                $stmt = $_conexion -> prepare($sql);
                $stmt -> execute([
                    "p_desde" => $_GET["p_desde"],
                    "p_hasta" => $_GET["p_hasta"],
                    "f_desde" => $_GET["f_desde"],
                ]);
            } elseif(isset($_GET["f_hasta"])) {
                $sql = "SELECT * FROM payment WHERE 
                    (amount BETWEEN :p_desde AND :p_hasta)
                    AND
                    (payment_date <= f_hasta)";
                $stmt = $_conexion -> prepare($sql);
                $stmt -> execute([
                    "p_desde" => $_GET["p_desde"],
                    "p_hasta" => $_GET["p_hasta"],
                    "f_hasta" => $_GET["f_hasta"],
                ]);
            } else {
                $sql = "SELECT * FROM payment WHERE amount BETWEEN :p_desde AND :p_hasta";
                $stmt = $_conexion -> prepare($sql);
                $stmt -> execute([
                    "p_desde" => $_GET["p_desde"],
                    "p_hasta" => $_GET["p_hasta"]
                ]);
            }
        } elseif(isset($_GET["p_desde"])) {
            $sql = "SELECT * FROM payment WHERE amount >= :p_desde";
            $stmt = $_conexion -> prepare($sql);
            $stmt -> execute([
                "p_desde" => $_GET["p_desde"],
            ]);
        } elseif(isset($_GET["p_hasta"])) {
            $sql = "SELECT * FROM payment WHERE amount <= :p_hasta";
            $stmt = $_conexion -> prepare($sql);
            $stmt -> execute([
                "p_hasta" => $_GET["p_hasta"]
            ]);
        } else {
            $sql = "SELECT * FROM payment";
            $stmt = $_conexion -> prepare($sql);
        }
        $stmt -> execute();
        $resultado = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado);
    }
?>