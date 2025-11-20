<?php
require_once("../lib_aplicaciones/planAplicacion.php");

// Objetos para enviarlos por inyeccion de dependencias
$conexion = Conexion::getConnection(); 
$objPR = new planRepositorio($conexion); // Recibe el obj de Conexion
$objPA = new planAplicacion($objPR); // Recibe el obj de Repositorio

$accion = $_GET["accion"] ?? $_POST["accion"] ?? null; 

if ($accion) { 
    switch($accion) {
        case "listarPlanes" :
            $resultado = $objPA->listarPlanes();

            header('Content-Type: application/json');
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            exit;
        break;

        case "listarPlanesUsuario" :
            $idUsuario = $_POST["idUsuario"] ?? null;
            $resultado = $objPA->listarPlanesUsuario($idUsuario);

            header('Content-Type: application/json');
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            exit;
        break;

        case "insertar" :
            // Datos normales (texto, números)
            $nombre = $_POST["nombre"] ?? null;
            $descripcion = $_POST["descripcion"] ?? null;
            $tipoActividad = $_POST["tipoActividad"] ?? null;
            $fecha = $_POST["fecha"] ?? null;
            $direccion = $_POST["direccion"] ?? null;
            $visibilidad = $_POST["visibilidad"] ?? null;
            $cantidadPersonas = $_POST["cantidadPersonas"] ?? null;
            $idMunicipio = $_POST["idMunicipio"] ?? null;
            $idUsuario = $_POST["idUsuario"] ?? null;
            $idSugerencia = $_POST["idSugerencia"] ?? null; 
            $lugar = $_POST["lugar"] ?? null;
            $edadMinima = $_POST["edadMinima"] ?? null;
            
            // Si $idSugerencia es la cadena de texto "null" o está vacío, lo convertimos al valor NULL de PHP.
            if ($idSugerencia === 'null' || empty($idSugerencia)) {
                $idSugerencia = null; // <-- ¡Esto es lo que necesita MySQL!
            }
            
            // Manejo de la imagen
            $rutaPublica = null;

            if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === 0) {
                $file = $_FILES["foto"];
                $tmp = $file["tmp_name"];
                $original = basename($file["name"]);

                // Carpeta donde se guardarán físicamente
                $carpetaFisica = __DIR__ . "/../../images/uploads/";

                // Si no existe, crearla
                if (!is_dir($carpetaFisica)) {
                    mkdir($carpetaFisica, 0777, true);
                }

                // Nombre único
                $nombreFinal = uniqid() . "_" . $original;

                // Ruta física → para move_uploaded_file
                $rutaFisica = $carpetaFisica . $nombreFinal;

                // Ruta pública → guardar en BD
                $rutaPublica = "/images/uploads/" . $nombreFinal;

                // Mover la imagen
                move_uploaded_file($tmp, $rutaFisica);
            }

            // guardado el plan 
            $resultado = $objPA->insertarPlan($nombre, $descripcion, $rutaPublica, $tipoActividad, $fecha, $direccion, $visibilidad, $cantidadPersonas, $idMunicipio, $idUsuario, $idSugerencia, $lugar, $edadMinima);
            header('Content-Type: application/json');
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            exit;
        break;

        case "modificar" :
            // Datos normales (texto, números)
            $id = $_POST["idPlan"] ?? null;
            $nombre = $_POST["nombre"] ?? null;
            $descripcion = $_POST["descripcion"] ?? null;
            $tipoActividad = $_POST["tipoActividad"] ?? null;
            $fecha = $_POST["fecha"] ?? null;
            $direccion = $_POST["direccion"] ?? null;
            $visibilidad = $_POST["visibilidad"] ?? null;
            $cantidadPersonas = $_POST["cantidadPersonas"] ?? null;
            $idMunicipio = $_POST["idMunicipio"] ?? null;
            $idUsuario = $_POST["idUsuario"] ?? null;
            $idSugerencia = $_POST["idSugerencia"] ?? null; 
            $lugar = $_POST["lugar"] ?? null;
            $edadMinima = $_POST["edadMinima"] ?? null;

            // Si $idSugerencia es la cadena de texto "null" o está vacío, lo convertimos al valor NULL de PHP.
            if ($idSugerencia === 'null' || empty($idSugerencia)) {
                $idSugerencia = null; // <-- ¡Esto es lo que necesita MySQL!
            }
            
            // Manejo de la imagen
            $rutaPublica = null;

            if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === 0) {
                $file = $_FILES["foto"];
                $tmp = $file["tmp_name"];
                $original = basename($file["name"]);

                // Carpeta donde se guardarán físicamente
                $carpetaFisica = __DIR__ . "/../../images/uploads/";

                // Si no existe, crearla
                if (!is_dir($carpetaFisica)) {
                    mkdir($carpetaFisica, 0777, true);
                }

                // Nombre único
                $nombreFinal = uniqid() . "_" . $original;

                // Ruta física → para move_uploaded_file
                $rutaFisica = $carpetaFisica . $nombreFinal;

                // Ruta pública → guardar en BD
                $rutaPublica = "/images/uploads/" . $nombreFinal;

                // Mover la imagen
                move_uploaded_file($tmp, $rutaFisica);
            }

            // guardado el plan 
            $resultado = $objPA->modificarPlan($id, $nombre, $descripcion, $rutaPublica, $tipoActividad, $fecha, $direccion, $visibilidad, $cantidadPersonas, $idMunicipio, $idUsuario, $idSugerencia, $lugar, $edadMinima);
            header('Content-Type: application/json');
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            exit;
        break;

        case "eliminar" : 
            $id = $_POST["idPlan"] ?? null;

            // Retornar un json con los datos resultantes
            $resultado = $objPA->eliminarPlan($id);
            echo json_encode($id, JSON_UNESCAPED_UNICODE);
            exit;
        break;
    }
}