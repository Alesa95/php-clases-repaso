<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    if(isset($_GET["indice"])) {
        $indice = $_GET["indice"];
    } else {
        $indice = 0;
    }

    $siguiente = $indice+5;
    $anterior = $indice-5;

    ?>

    <a href="rover.php?indice=<?= $anterior ?>">
        Anterior
    </a>

    <a href="rover.php?indice=<?= $siguiente ?>">
        Siguiente
    </a>

    <?php

    $apiKey = "5dsEDjOCvuzhnoJDf743Wp9VCSInYPzjELN8jLbh";
    $url = "https://api.nasa.gov/mars-photos/api/v1/rovers/curiosity/photos?sol=1000";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, $apiKey . ":");
    $respuesta = curl_exec($curl);
    curl_close($curl);

    $datos = json_decode($respuesta, true);
    //print_r($datos);

    $contador = 0;
    $fotos = $datos["photos"];
    while($contador < 5) {
        $foto = $fotos[$indice];

        $id = $foto["id"];
        $nombre_rover = $foto["rover"]["name"];
        echo "<h1>$id</h1>";
        echo "<h2>$nombre_rover</h2>";

        $indice++;
        $contador++;
    }
    ?>
</body>
</html>