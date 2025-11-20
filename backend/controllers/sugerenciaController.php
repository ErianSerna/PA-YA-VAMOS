<?php
require_once("../lib_aplicaciones/sugerenciaAplicacion.php");

// Objetos para enviarlos por inyeccion de dependencias
$conexion = Conexion::getConnection();

$objAR = new sugerenciaRepositorio($conexion); // Recibe el obj de Conexion
$objAA = new sugerenciaAplicacion($objAR); // Recibe el obj de Repositorio

// Establece el encabezado para JSON

header("Content-Type: application/json");

$datos_json = file_get_contents("php://input"); // Recibe los datos del cuerpo de la petición
$datos = json_decode($datos_json, true); // Decodifica el JSON

// Verifica y muestra información detallada
if ($datos === null) { // error 
    echo json_encode([
        "error" => "Error al decodificar JSON",
        "datos_raw" => $datos_json,
        "error_json" => json_last_error_msg()
    ]);
    exit;
}

if (isset($datos["accion"])) {
    $accion = $datos["accion"];

    switch ($accion) {
        case "listar" : 
            $objAA->consultarTodos();
            break;
            
        case "consultarPorFiltro" :
            $idMunicipio = $datos["IdMunicipio"];
            $tipoActividad = $datos["TipoActividad"];

            // Retornar un json con los datos resultantes
            echo $objAA->consultarSugerenciasPorFiltro($idMunicipio, $tipoActividad);
            break;
    }
}
?>