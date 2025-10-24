<?php
// Determino si es HTTP o HTTPS
if ($_SERVER["SERVER_PROTOCOL"] == "HTTP/1.1") {
    $protocolo = "http";
} else {
    $protocolo = "https";
}

$host = $_SERVER["HTTP_HOST"];

$uri = $_SERVER["REQUEST_URI"];

// Dejar unicamente la primera parte de la uri 
$arrayUri = explode("/", $uri);
$nombreProyecto = $arrayUri[1];
$url_base = $protocolo . "://" . $host . "/" . $nombreProyecto;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pa'Ya Vamos</title>
    <link rel="icon" type="image/png" href="<?= $url_base ?>/images/logo.png">
    <link rel="stylesheet" href="<?= $url_base ?>/styles/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <h1>PA'YA VAMOS</h1>
    <!--Boton para el registro-->
    <div class="btnRegister">
        <a href="<?= $url_base ?>/views/register.php">
            <span>Registrarse</span>
            <img src="<?= $url_base ?>/images/usuario.png" class="iconUser" alt="icono">
        </a>
    </div>
    <div class="mainContainer">
        <!--comentarios-->
        <div class="containerCards">
            <div class="card">
                <img src="<?= $url_base ?>/images/shop.png" class="icon" id="icon1" alt="icono">
                <p>Decide qué hacer, dónde hacerlo y con quién</p>
            </div>

            <div class="cardRigth">
                <img src="<?= $url_base ?>/images/restaurant(2).png" class="icon" id="icon2" alt="icono">
                <p>No preocuparse por el clima...</p>
            </div>

            <div class="card">
                <img src="<?= $url_base ?>/images/train-station.png" class="icon" id="icon3" alt="icono">
                <p>Conoce gente de forma segura.</p>
            </div>

            <div class="cardRigth">
                <img src="<?= $url_base ?>/images/garden.png" class="icon" id="icon4" alt="icono">
                <p>Obtén recomendaciones únicas</p>
            </div>
        </div>
        <!--formulario de login-->
        <div class="containerForm">
            <form action="<?= $url_base ?>/views/principal.php" method="post">
                <h2>INICIO DE SESIÓN</h2>
                <label>Correo</label>
                <input type="email" name="email" class="fieldForm" required><br>
                <label>Contraseña</label>
                <input type="password" name="password" class="fieldForm" required><br>

                <div class="buttonsContainer">
                    <button type="submit" class="btnSubmit">INGRESAR</button>
                    <a href="<?= $url_base ?>/views/register.php" class="btnRegisterResponsive">REGISTRO</a>
                </div>

            </form>
        </div>
    </div>
    <script src="<?= $url_base ?>/scripts/login.js"></script>
</body>

</html>