<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $urlLibro = $_GET["urlLibro"];
    //echo "<h1>$urlLibro</h1>";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $urlLibro);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $respuesta = curl_exec($curl);
    curl_close($curl);
    
    $libro = json_decode($respuesta, true);
    ?>

    <h1>
        <?php echo $libro["name"] ?>
    </h1>
    <h2>
        <?php
        $ano = substr($libro["released"],0,4);
        echo $ano;
        ?>
    </h2>
    <ul>
        <?php
        $urlPersonajesPov = $libro["povCharacters"];
        if(count($urlPersonajesPov) == 0) {
            echo "<li>No hay personajes POV</li>";
        } else {
            foreach($urlPersonajesPov as $urlPersonajePov) {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $urlPersonajePov);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $respuesta = curl_exec($curl);
                curl_close($curl);
                
                $personajePov = json_decode($respuesta, true);

                ?>
                <li>
                    <?php echo $personajePov["name"] ?>
                </li>
                <?php
            }
        }
        ?>
    </ul>
    
</body>
</html>