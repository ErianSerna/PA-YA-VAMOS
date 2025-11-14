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
    $url_base = $protocolo."://".$host."/".$nombreProyecto;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Principal</title>
    <link rel="icon" type="image/png" href="<?= $url_base ?>/images/logo.png">
    <link rel="stylesheet" href="<?=$url_base?>/styles/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js" xintegrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" crossorigin="anonymous"> -->
</head>
<body>
    
    <!-- OVERLAY DEL MENÚ HAMBURGUESA (Se muestra solo en móvil) -->
    <div id="mobile-menu-overlay" class="mobile-menu-overlay">
        <div class="mobile-menu-content">
            <div class="mobile-menu-header">
                <h2>PA'YA VAMOS</h2>
                <button id="close-menu-btn" class="close-menu-btn">&times;</button>
            </div>
            <nav class="mobile-nav-main">
                <ul class="mobile-nav-menu">
                    <li><a href="#">PÁGINA PRINCIPAL</a></li>
                    <!-- Si tienes más opciones, agrégalas aquí para el menú móvil -->
                </ul>
            </nav>
        </div>
    </div>
    
    <div class="container">

    </div>
    <header>
        <!-- Botón para abrir el menú (icono hamburguesa) -->
        <button id="open-menu-btn" class="menu-toggle-btn">
            <i class="fas fa-bars"></i>
        </button>
        <h1>PA'YA VAMOS</h1>
        <nav class="nav-main">
            <ul class="nav-menu">
                <li><a href="#">PÁGINA PRINCIPAL</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <!-- El ancho del buscarPlan sera el mismo para planesAbiertos -->
        <div class="container-buscarPlan">
            <h2 id="h2-buscarPlan">BUSQUEMOS UN PLAN</h2>
            <form action="" id="form-buscarPlan">
                <div class="container-filtros">
                    <div class="filtro">
                        <label for="select-actividad1">Tipo de Actividad</label>
                        <select name="" id="select-actividad1">
                            <option value="" selected disabled></option>
                            <option value="Comida">Comida</option>
                            <option value="Comida">Deporte</option>
                            <option value="Comida">Cultura</option>
                            <option value="Comida">Entretenimiento</option>
                        </select>
                    </div>
                        
                    <div class="filtro">
                        <label for="select-actividad2">Cantidad de Personas</label>
                        <select name="" id="select-actividad2">
                            <option value="" selected disabled></option>
                            <option value="solo">Solo</option>
                            <option value="acompanado">Acompañado</option>
                        </select>
                    </div>

                    <div class="filtro">
                        <label for="select-actividad3">Horario</label>
                        <select name="" id="select-actividad3">
                            <option value="" selected disabled></option>
                            <option value="manana">Mañana</option>
                            <option value="tarde">Tarde</option>
                            <option value="noche">Noche</option>
                        </select>
                    </div>

                    <div class="filtro">
                        <label for="select-actividad4">Ubicación</label>
                        <select name="" id="select-actividad4">
                            <option value="" selected disabled></option>
                            <option value="medellin">Medellín</option>
                            <option value="barbosa">Barbosa</option>
                            <option value="copacabana">Copacabana</option>
                            <option value="girardota">Girardota</option>
                            <option value="envigado">Envigado</option>
                            <option value="itagui">Itagüí</option>
                            <option value="sabaneta">Sabaneta</option>
                            <option value="laEstrella">La estrella </option>
                            <option value="caldas">Caldas</option>
                            <option value="bello">Bello</option>
                        </select>
                    </div>
                </div>
                <div class="container-botonBuscar">
                    <button type="submit" id="btn-buscarPlan">Consultar</button>
                </div>
            </form>

            <div class="container-resultados">
                <div class="card card-vEsmeralda">
                    <img src="<?=$url_base?>/images/tierra-querida.jpg" alt="icono1">
                    <div class="card-content">
                        <h3>Tierra Querida</h3>
                        <p>No nos conocían por el nombre… pero sí por el sabor. </p>
                    </div>
                </div>
                <div class="card card-vBosque">
                    <img src="<?=$url_base?>/images/fresas-crema.jpg" alt="icono2">
                    <div class="card-content">
                        <h3>Fresas con Crema</h3>
                        <p>Las mejores fresas con crema de todo el mundo. </p>
                    </div>
                </div>
                <div class="card card-vOliva">
                    <img src="<?=$url_base?>/images/pizza.jpg" alt="icono3">
                    <div class="card-content">
                        <h3>Domino's Pizza</h3>
                        <p>Es una de las compañías de pizza más grandes del mundo. </p>
                    </div>
                </div>
                <div class="card card-vLima">
                    <img src="<?=$url_base?>/images/cine.jpg" alt="icono4">
                    <div class="card-content">
                        <h3>Cinema Procinal</h3>
                        <p>Peliculas super entretenidas para disfrutar. </p>
                    </div>
                </div>
            </div>
        </div> <!-- Fin container-buscarPlan -->

        <div class="container-planesAbiertos">
            <h2 id="h2-buscarPlan">PLANES ABIERTOS</h2>
            <div class="container-listadoPlanesAbiertos">
                <div class="container-planAbierto">
                    <img src="<?=$url_base?>/images/iglesia.jpg" alt="Img iglesia">
                    <div class="container-planAbiertoContent">
                        <h3>IGLESIA CARMEN</h3>
                        <p>Vamos a misa juntos :D</p>
                    </div>
                </div>
                <div class="container-planAbierto">
                    <img src="<?=$url_base?>/images/cinecolombia.jpg" alt="Img cine">
                    <div class="container-planAbiertoContent">
                        <h3>CINE: EL CONJURO</h3>
                        <p>Busco amigos para ver esta peli :j</p>
                    </div>
                </div>
                <div class="container-planAbierto">
                    <img src="<?=$url_base?>/images/cementerio.jpg" alt="Img cementerio">
                    <div class="container-planAbiertoContent">
                        <h3>CEMENTERIO SAN PEDRO</h3>
                        <p>Vamos a saquear tumbas >:D</p>
                    </div>
                </div>
                <div class="container-planAbierto">
                    <img src="<?=$url_base?>/images/bolos.jpg" alt="Img bolos">
                    <div class="container-planAbiertoContent">
                        <h3>BOLOS Y COMIDA</h3>
                        <p>Pasar el rato con bolos y a comer</p>
                    </div>
                </div>
                <div class="container-planAbierto">
                    <img src="<?=$url_base?>/images/volley.webp" alt="Img volley">
                    <div class="container-planAbiertoContent">
                        <h3>JUGAR VOLLEY</h3>
                        <p>Busco amigos para jugar un rato :v</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
            <div class="footer-row">
                <div class="footer-links">
                    <h4>Servicios</h4>
                    <ul>
                        <li><a href="#">Encontrar plan</a></li>
                        <li><a href="#">Planes abiertos</a></li>
                    </ul>
                </div>
                
            </div>
            <div class="footer-copyright">
                <p>&copy; 2025 Pa'Ya Vamos. Todos los derechos reservados.</p>
            </div>
    </footer>

    <!-- Referencia al javascript -->
    <!-- Se actualiza la ruta al nuevo archivo index.js -->
    <script src="<?=$url_base?>/scripts/index.js"></script>
</body>
</html>
