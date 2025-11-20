<?php
require_once("../database/Conexion.php");

class usuarioRepositorio
{
    private $conexion; 

    // Constructor que recibe la conexion por medio de inyección de dependencias
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

   function insertarUsuario($nombre, $apellido, $correo, $contrasena, $fechaNacimiento, $idMunicipio)
    {
        $usuarioInsertado = []; // Array asociativo para almacenar los datos del usuario recien insertado

        // Verificar si la conexión fue exitosa
        if ($this->conexion->connect_error) {
            #return "Error de conexión: " . $conexion->connect_error;
            return ["error" => "Error de conexión: " . $this->conexion->connect_error];
        }

        // Preparar la consulta con el procedimiento almacenado
        $sql = "CALL SP_crearUsuario(?, ?, ?, ?, ?, ?)";
        $sentencia = $this->conexion->prepare($sql);

        if (!$sentencia) { // sentencia = false
            # return "Error en la preparación de la consulta: " . $conexion->error;
            return ["error" => "Error en la preparación de la consulta: " . $this->conexion->error];
        }

        // Vincular parámetros
        $sentencia->bind_param(
        "sssssi",
        $nombre,
        $apellido,
        $correo,
        $contrasena,
        $fechaNacimiento,
        $idMunicipio
        );

        // Ejecutar la consulta
        if (!$sentencia->execute()) {
            #return "Error al ejecutar la consulta: " . $sentencia->error;
            return ["error" => "Error al insertar el usuario: " . $sentencia->error];
        }

        // Obtener resultados
        $resultado = $sentencia->get_result();
        //$idInsertado = $conexion->insert_id; // Variable para almacenar el id del usuario recien insertado

        // true si $resultado es un objeto mysqli_result, false si es null
        if ($resultado) {
            $resultado = $resultado->fetch_assoc(); // Obtener un arreglo con LA FILA resultante
        }

        // Cerrar la sentencia y la conexión
        $sentencia->close();

        // Setteo el usuario recien insertado para retornarlo
        $usuarioInsertado = [
            "usuario_nombre" => $nombre,
            "usuario_correo" => $correo,
            "usuario_apellido" => $apellido,
            "usuario_contrasena" => $contrasena,
            "usuario_fechaNacimiento" => $fechaNacimiento,
            "usuario_idMunicipio" => $idMunicipio,
        ];

        return $usuarioInsertado; // Retorna el usuario insertado
    }

    // Consultar por correo de usuario. Puede devolver un array con error, un array con datos o un array vacio
    function consultarPorCorreo($correo)
    {
        // Verificar si la conexion fue exitosa
        if ($this->conexion->connect_error) {
            return ["error" => "Error de conexión: " . $this->conexion->connect_error];
        }

        // Llamo al procedimiento almacenado y preparo la consulta
        $sql = "CALL SP_consultarPorCorreo(?)";
        $sentencia = $this->conexion->prepare($sql);

        if (!$sentencia) { // sentencia = false
            return ["error" => "Error en la preparación de la consulta: " . $this->conexion->error];
        }

        // Vinculo los parametros
        $sentencia->bind_param("s", $correo);

        // Ejecutar la sentencia
        if (!$sentencia->execute()) { // si la ejecucion fue fallida, retorna false, de lo contrario true
            return ["error" => "Error al consultar el usuario"];
        }

        $resultado = $sentencia->get_result(); // Obtengo un objeto mysqli_result con los resultados

        // true si $resultado es un objeto mysqli_result, false si es null
        if ($resultado) {
            $resultado = $resultado->fetch_assoc(); // Obtiene un array con la fila obtenida
        }

        // Cerrar la sentencia y la conexión
        $sentencia->close();

        if (isset($resultado)) { // Hay resultados
            $usuarioConsultado = $resultado;
        } else {
            $usuarioConsultado = [];
        }
        return $usuarioConsultado;
    }
    
} // Fin de la clase 
