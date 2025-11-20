<?php  
    session_start(); // Sesion para el control del usuario
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
    <title>Planes abiertos</title>
    <link rel="icon" type="image/png" href="<?= $url_base ?>/images/logo.png">
    <link rel="stylesheet" href="<?=$url_base?>/styles/planesAbiertos.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js" xintegrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ" crossorigin="anonymous"></script>
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
        <div class="container-firstPart">
            <div class="container-crearPlan"> <!-- Contenedor principal del formulario -->
                <form action="" id="form-crearPlan">
                    <input type="hidden" name="idPlan" id="idPlan" value="">
                    <input type="hidden" name="idUsuario" id="idUsuario" value="">
                    <!-- Fila 1 -->
                    <div class="form-row">
                        <div class="filtro">
                            <label for="nombrePlan">Nombre</label>
                            <input type="text" name="nombrePlan" id="nombrePlan" pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+" title="Solo letras y espacios" required>
                        </div>
                        <div class="filtro">
                            <label for="lugarPlan">Lugar</label>
                            <input type="text" id="lugarPlan" name="lugarPlan" required>
                        </div> 
                    </div>

                    <!-- Fila 2 -->
                    <div class="form-row">
                        <div class="filtro">
                            <label for="municipioPlan">Municipio</label>
                            <select name="municipioPlan" id="municipioPlan" required>
                                <option value="" selected disabled></option>
                                <option value="1">Medellin</option>
                                <option value="2">Bello</option>
                                <option value="3">Girardota</option>
                            </select>
                        </div>
                        <div class="filtro">
                            <label for="direccionPlan">Dirección</label>
                            <input type="text" id="direccionPlan" name="direccionPlan" required>
                        </div>
                    </div>

                    <!-- Fila 3 -->
                    <div class="form-row">
                        <div class="filtro">
                            <label for="descripcionPlan">Descripción</label>
                            <input type="text" id="descripcionPlan" name="descripcionPlan" required>
                        </div>
                        <div class="filtro">
                            <label for="fechaPlan">Fecha</label>
                            <input type="datetime-local" id="fechaPlan" name="fechaPlan" required>
                        </div>
                    </div>

                    <!-- Fila 4 -->
                    <div class="form-row">
                        <div class="filtro">
                            <label for="fotoPlan">Foto</label>
                            <div class="file-input-group">
                                <input type="text" id="file-name-display" placeholder="Selecciona un archivo..." readonly>
                                <input type="file" name="fotoPlan" id="fotoPlan" accept="image/png, image/jpeg" required class="hidden-file-input">
                                <button type="button" class="file-custom-button" onclick="document.getElementById('fotoPlan').click()">Examinar</button>
                            </div>
                        </div>
                        <div class="filtro">
                            <label for="visibilidadPlan">Visibilidad (estado)</label>
                            <select name="visibilidadPlan" id="visibilidadPlan" required>
                                <option value="" selected disabled></option>
                                <option value="publico">Público</option>
                                <option value="privado">Privado</option>
                            </select>
                        </div>    
                    </div>

                    <!-- Fila 5 -->
                    <div class="form-row">
                        <div class="filtro">
                            <label for="cantidadPersonasPlan">Cantidad personas</label>
                            <input type="number" id="cantidadPersonasPlan" name="cantidadPersonasPlan" min="1" required>
                        </div>
                        <div class="filtro">
                            <!-- Corrijo el label que era repetido en tu código original -->
                            <label for="edadMinimaPlan">Edad mínima</label>
                            <input type="number" id="edadMinimaPlan" name="edadMinimaPlan" min="18" required>
                        </div>
                    </div>

                    <!-- Fila 6 -->
                    <div class="form-row"> 
                        <div class="filtro">
                            <label for="tipoActividadPlan">Tipo de actividad</label>
                            <select name="tipoActividadPlan" id="tipoActividadPlan" required>
                                <option value="" selected disabled></option>
                                <option value="comida">Comida</option>
                                <option value="deportes">Deporte</option>
                                <option value="cultura">Cultura</option>
                                <option value="entretenimiento">Entretenimiento</option>
                            </select>
                        </div> 
                        <div class="container-botonCrear">
                            <button type="submit" id="btn-crearPlan" disabled>Crear plan</button>
                            <button type="submit" id="btn-confirmarModificacion" style="display: none;">Confirmar</button>
                        </div>
                    </div>                
                </form>
            </div> <!-- Fin container-crearPlan -->

            <!-- Seccion de recomendaciones: Estructura de la derecha -->
            <div class="container-planesAbiertos">
                <!-- Grupo 1 (visible por defecto) -->
                <div class="grupo-tarjetas">
                    <div class="recommendation-card top-card" id="recommendation-card1">
                        <div class="card-content">
                            <!-- Contenido de la primera tarjeta: ¿Empezamos a planear? -->
                            <h2>¿Empezamos a planear?</h2>
                        </div>
                    </div>
                    <div class="recommendation-card bottom-card" id="recommendation-card2">
                        <div class="card-content">
                            <!-- Contenido de la segunda tarjeta: ¡Sube una foto atractiva! -->
                            <i class="fas fa-camera"></i>
                            <h2>¡Sube una foto atractiva!</h2>
                        </div>
                    </div>
                </div>
                <!-- Grupo 2 (oculto por defecto) -->
                <div class="grupo-tarjetas hidden">
                    <div class="recommendation-card top-card" id="recommendation-card3">
                        <div class="card-content">
                            <!-- Contenido de la primera tarjeta del grupo 2 -->
                            <h2>Abre tus planes al público</h2>
                        </div>
                    </div>
                    <div class="recommendation-card bottom-card" id="recommendation-card4">
                        <div class="card-content">
                            <!-- Contenido de la segunda tarjeta del grupo 2 -->
                            <i class="fas fa-camera"></i>
                            <h2>Conoce gente nueva</h2>
                        </div>
                    </div>
                </div>
                <!-- Grupo 3 (oculto por defecto) -->
                <div class="grupo-tarjetas hidden">
                    <div class="recommendation-card top-card" id="recommendation-card5">
                        <div class="card-content">
                            <!-- Contenido de la primera tarjeta del grupo 3 -->
                            <h2>Visita nuevos lugares</h2>
                        </div>
                    </div>
                    <div class="recommendation-card bottom-card" id="recommendation-card6">
                        <div class="card-content">
                            <!-- Contenido de la segunda tarjeta del grupo 3 -->
                            <h2>Explora actividades únicas</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <div class="container-secondPart">
            <h2>Mis planes</h2>
            <!-- Contenedor con el listado de planes -->
            <div class="container-misPlanes">

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
                <!-- ... otros links ... -->
            </div>
            <div class="footer-copyright">
                <p>&copy; 2025 Pa'Ya Vamos. Todos los derechos reservados.</p>
            </div>
    </footer>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?=$url_base?>/scripts/planesAbiertos.js"></script>

    <script> // Cargo la variable usuario para que puedan ser usadas por el script que referencié arriba
        var idUsuarioSesion = <?php echo json_encode($_SESSION['usuario']);?>;
    </script>
</body>
</html>