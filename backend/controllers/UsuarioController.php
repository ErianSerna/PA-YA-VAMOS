<?php
session_start();
require_once("../lib_aplicaciones/usuarioAplicacion.php");
// require_once("../lib_repositorio/UsuarioRepositorio.php");
// require_once("../database/Conexion.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Credentials: true");

// Si la solicitud es OPTIONS (preflight), responde y termina:
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Objetos para enviarlos por inyeccion de dependencias
$conexion = Conexion::getConnection(); 

$objUR = new usuarioRepositorio($conexion); // Recibe el obj de Conexion
$objUA = new usuarioAplicacion($objUR); // Recibe el obj de Repositorio

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

if ($datos) {
    $_POST = $datos; // Convertir JSON a POST normal
}

if (isset($datos["accion"])) {
    $accion = $datos["accion"];

    switch ($accion) {

        case "insertar" :
            $nombre = $datos["usuario_nombre"];
            $apellido = $datos["usuario_apellido"];
            $correo = $datos["usuario_correo"];
            $contrasena = $datos["usuario_contrasena"];
            $fechaNacimiento = $datos["usuario_fechaNacimiento"];
            $idMunicipio = $datos["usuario_idMunicipio"];


            // Retornar un json con los datos resultantes
            echo $objUA->insertarUsuario($nombre, $apellido, $correo, $contrasena, $fechaNacimiento, $idMunicipio);
            break;

        case "consultarUsuario":
            $correo = $datos["usuario_correo"];
            $contrasena = $datos["usuario_contrasena"];

            // Retornar un json con los datos resultantes
            echo $objUA->consultarUsuarioLogin($correo, $contrasena);

            break;
    }
}