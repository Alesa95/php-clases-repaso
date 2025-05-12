<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    $apiKey = "5dsEDjOCvuzhnoJDf743Wp9VCSInYPzjELN8jLbh";
    $url = "https://api.nasa.gov/planetary/apod";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, $apiKey . ":");
    $respuesta = curl_exec($curl);
    curl_close($curl);

    $datos = json_decode($respuesta, true);

    if(isset($datos["hdurl"])) {
        $imagen = $datos["hdurl"];
    } else {
        $imagen = $datos["url"];
    }
    ?>

    <h1><?= $datos["title"] ?></h1>
    <h2><?= $datos["date"] ?></h2>
    <p><?= $datos["explanation"] ?></p>
    <img width=50% src="<?= $imagen ?>">
</body>
</html>