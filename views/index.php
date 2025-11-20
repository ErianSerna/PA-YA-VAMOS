<?php

    session_start();

    if (!isset($_SESSION["usuario"])) {
        header("Location: login.php");
        exit();
    }

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
                <h2><a href="<?=$url_base?>/views/index.php">PA'YA VAMOS</a></h2>
                <button id="close-menu-btn" class="close-menu-btn">&times;</button>
            </div>
            <nav class="mobile-nav-main">
                <ul class="mobile-nav-menu">
                    <li><a href="<?=$url_base?>/views/planesAbiertos.php">PLANES ABIERTOS</a></li>
                </ul>
                <ul class="mobile-nav-menu">
                    <li><a href="logout.php">CERRAR SESIÓN</a></li>
                </ul>
            </nav>
        </div>
    </div>
    
    <header>
        <!-- Botón para abrir el menú (icono hamburguesa) -->
        <button id="open-menu-btn" class="menu-toggle-btn">
            <i class="fas fa-bars"></i>
        </button>
        <h1><a href="<?=$url_base?>/views/index.php">PA'YA VAMOS</a></h1>
        <nav class="nav-main">
            <ul class="nav-menu">
                <li><a href="<?=$url_base?>/views/planesAbiertos.php">PLANES ABIERTOS</a></li>
            </ul>
            <div class="logout-container">
                <a href="logout.php">
                    <img src="<?= $url_base ?>/images/logout.png" class="logout-icon" alt="Cerrar sesión">
                </a>
            </div>
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
                            <option value="bello">Bello</option>
                            <option value="girardota">Girardota</option>
                        </select>
                    </div>
                </div>
                <div class="container-botonBuscar">
                    <button type="submit" id="btn-buscarPlan">Consultar</button>
                </div>
            </form>
            <div class="container-resultados" id="container-resultados">
                <!-- Los resultados de la busqueda se mostraran aqui -->
            </div>
            
        </div> <!-- Fin container-buscarPlan -->

        <div class="container-planesAbiertos">
            <h2 id="h2-buscarPlan">PLANES ABIERTOS</h2>
            <div class="container-listadoPlanesAbiertos" id="container-listadoPlanesAbiertos">
                <!--los planes se mostraran aqui-->
            </div>
             <button class="btn-crear-plan-nuevo" id="btn-crear-plan-nuevo">Crear plan</button>
        </div>
    </main>
    <footer>
            <div class="footer-row">
                <div class="footer-links">
                    <h4>Servicios</h4>
                    <ul>
                        <li><a href="#">Encontrar plan</a></li>
                        <li><a href="<?=$url_base?>/views/planesAbiertos.php">Planes abiertos</a></li>
                    </ul>
                </div>
                
            </div>
            <div class="footer-copyright">
                <p>&copy; 2025 Pa'Ya Vamos. Todos los derechos reservados.</p>
            </div>
    </footer>
    <!--modal de sugerencias-->
    <div id="modal-sugerencia" class="modal">
        <div class = "modal-content">
            <button id="close-modal-btn" class="close-modal-btn">&times;</button>
            <div class="modal-body">
                <div class="modal-image">
                    <img id="modal-foto" src="" alt="Imagen sugerencia">
                </div>
                <div class="modal-info">
                    <h2 id="modal-nombre" class="modal-titulo">Nombre del Lugar</h2>
                    <h3 id="modal-tipo-actividad" class="modal-subtitulo">Tipo de Actividad</h3>
                    <p id="modal-descripcion" class="modal-descripcion">
                        Descripción del lugar...
                    </p>
                    <div class="modal-detalles">
                        <div class="modal-detalle-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span id="modal-direccion">Dirección</span>
                        </div>
                        
                        <div class="modal-detalle-item">
                            <i class="fas fa-clock"></i>
                            <span id="modal-horario">Horario: 1PM - 8PM</span>
                        </div>
                    </div>
                    <div class="modal-acciones">
                        <button class="btn-crear-plan">CREAR PLAN</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Referencia al javascript -->
    <!-- Se actualiza la ruta al nuevo archivo index.js -->
    <script src="<?=$url_base?>/scripts/index.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
