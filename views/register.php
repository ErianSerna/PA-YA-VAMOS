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
    <link rel="stylesheet" href="<?= $url_base ?>/styles/register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Nuestro archivo JavaScript -->
    <script src="<?= $url_base ?>/scripts/register.js"></script>
</head>

<body>
    <h1>PA'YA VAMOS</h1>
    <!--Boton para el registro-->
    <div class="btnRegister">
        <a href="<?= $url_base ?>/views/login.php">
            <span>Iniciar Sesión</span>
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
        <div class="containerForm ">
                

            <form id="formRegister">

                <h2>REGISTRO</h2>
                <label>Nombre</label>
                <input type="text" name="nombre" pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+" class="fieldForm" title="Solo se permiten letras" required><br>
                <label>Apellidos</label>
                <input type="text" name="lastName" pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+" class="fieldForm" title="Solo se permiten letras" required><br>
                <label>Fecha nacimiento</label>
                <input type="date" name="birthdate" class="fieldForm" required><br>
                <label>Municipio</label>
                <select name="city" class="fieldForm" required>
                    <option value="1">Medellín</option>
                    <option value="2">Bello</option>
                    <option value="3">Girardota</option>
                </select>
                <label>Correo</label>
                <input type="email" name="email" class="fieldForm" required><br>
                <label>Contraseña</label>
                <input type="password" name="password" class="fieldForm" required><br>
                <label>Confirmar contraseña</label>
                <input type="password" name="passwordConfirm" class="fieldForm" required><br>


                <div class="buttonsContainer">
                    <button id="btnSubmit" type="submit" class="btnSubmit">REGISTRO</button>
                    <a href="<?= $url_base?>/views/login.php" class="btnLoginResponsive">INICIO DE SESIÓN</a>
                </div>

            </form>
        </div>
    </div>
    <script src="<?= $url_base ?>/scripts/register.js"></script>
</body>

</html>