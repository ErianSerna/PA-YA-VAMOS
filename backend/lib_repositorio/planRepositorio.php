<?php
require_once("../database/Conexion.php");

class planRepositorio
{
    private $conexion; 

    // Constructor que recibe la conexion por medio de inyección de dependencias
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    // Metodo para listar todos los planes
    function listarPlanes() {
        $planes = []; // Array para almacenar los planes

        // Verificar si la conexión fue exitosa
        if ($this->conexion->connect_error) {
            return ["error" => "Error de conexión: " . $this->conexion->connect_error];
        }

        // Preparar la consulta
        $sql = "CALL sp_listar_planes();";
        $sentencia = $this->conexion->prepare($sql);

        if (!$sentencia) {
            return ["error" => "Error en la preparación de la consulta: " . $this->conexion->error];
        }

        // Ejecutar la consulta
        if (!$sentencia->execute()) {
            return ["error" => "Error al obtener los planes: " . $sentencia->error];
        }

        // Obtener el resultado
        $resultado = $sentencia->get_result();

        // Recorrer los resultados y almacenarlos en el array
        while ($fila = $resultado->fetch_assoc()) {
            $planes[] = $fila;
        }

        $sentencia->close();

        return $planes; // Retorna el array de planes
    }

    // Metodo para obtener el listado de todos los planes asociados a un usuario
    function listarPlanesUsuario($IdUsuario) {
        $planes = []; // Array para almacenar los planes

        // Verificar si la conexión fue exitosa
        if ($this->conexion->connect_error) {
            return ["error" => "Error de conexión: " . $this->conexion->connect_error];
        }

        // Preparar la consulta
        $sql = "CALL sp_listar_planes_usuario(?);";
        $sentencia = $this->conexion->prepare($sql);

        if (!$sentencia) {
            return ["error" => "Error en la preparación de la consulta: " . $this->conexion->error];
        }

        // Vincular parámetros
        $sentencia->bind_param("i", $IdUsuario);

        // Ejecutar la consulta
        if (!$sentencia->execute()) {
            return ["error" => "Error al obtener los planes: " . $sentencia->error];
        }

        // Obtener el resultado
        $resultado = $sentencia->get_result();

        // Recorrer los resultados y almacenarlos en el array
        while ($fila = $resultado->fetch_assoc()) {
            $planes[] = $fila;
        }

        $sentencia->close();

        return $planes; // Retorna el array de planes
    }

    // Metodo para insertar un nuevo plan a la base de datos: Puede devolver un array con error o un array con datos
    function insertarPlan($Nombre, $Descripcion, $Foto, $TipoActividad, $Fecha, $Direccion, $Visibilidad, $CantidadPersonas, $IdMunicipio, $IdUsuario, $IdSugerencia, $Lugar, $EdadMinima)
    {
        $planInsertado = []; // Array asociativo para almacenar los datos del plan recien insertado

        // Verificar si la conexión fue exitosa
        if ($this->conexion->connect_error) {
            return ["error" => "Error de conexión: " . $this->conexion->connect_error];
        }

        // Preparar la consulta con el procedimiento almacenado
        $sql = "CALL SP_insertar_plan(?,?,?,?,?,?,?,?,?,?,?,?,?);";
        $sentencia = $this->conexion->prepare($sql);

        if (!$sentencia) {
            return ["error" => "Error en la preparación de la consulta: " . $this->conexion->error];
        }

        // Vincular parámetros
        $sentencia->bind_param("sssssssiiiisi", $Nombre, $Descripcion, $Foto, $TipoActividad, $Fecha, $Direccion, $Visibilidad, $CantidadPersonas, $IdMunicipio, $IdUsuario, $IdSugerencia, $Lugar, $EdadMinima);

        // Ejecutar la consulta
        if (!$sentencia->execute()) {
            return ["error" => "Error al insertar el plan: " . $sentencia->error];
        }

        // Obtener resultado del SP (que devuelve SELECT LAST_INSERT_ID() AS id)
        $resultado = $sentencia->get_result();
        $fila = $resultado ? $resultado->fetch_assoc() : null;

        $sentencia->close();

        if (!$fila) {
            return ["error" => "No se pudo obtener el ID insertado."];
        }

        $idInsertado = $fila["id"];

        // Setteo el plan recien insertado para retornarlo
        $planInsertado = [
            "plan_id" => $idInsertado,
            "plan_nombre" => $Nombre,
            "plan_descripcion" => $Descripcion,
            "plan_foto" => $Foto,
            "plan_tipoActividad" => $TipoActividad,
            "plan_fecha" => $Fecha,
            "plan_direccion" => $Direccion,
            "plan_visibilidad" => $Visibilidad,
            "plan_cantidadPersonas" => $CantidadPersonas,
            "plan_idMunicipio" => $IdMunicipio,
            "plan_idUsuario" => $IdUsuario,
            "plan_idSugerencia" => $IdSugerencia,
            "plan_lugar" => $Lugar,
            "plan_edadMinima" => $EdadMinima
        ];
        return $planInsertado; // Retorna el plan insertado
    }

    // Metodo para modificar un plan: Puede devolver un array con error o un array con datos
    function modificarPlan($Id, $Nombre, $Descripcion, $Foto, $TipoActividad, $Fecha, $Direccion, $Visibilidad, $CantidadPersonas, $IdMunicipio, $IdUsuario, $IdSugerencia, $Lugar, $EdadMinima)
    {
        $planModificado = []; // Array asociativo para almacenar los datos del plan recien actualizado

        // Verificar si la conexión fue exitosa
        if ($this->conexion->connect_error) {
            return ["error" => "Error de conexión: " . $this->conexion->connect_error];
        }

        // Preparar la consulta con el procedimiento almacenado
        $sql = "CALL SP_modificar_plan(?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
        $sentencia = $this->conexion->prepare($sql);

        if (!$sentencia) {
            return ["error" => "Error en la preparación de la consulta: " . $this->conexion->error];
        }

        // Vincular parámetros
        $sentencia->bind_param("isssssssiisiii", $Id, $Nombre, $Descripcion, $Foto, $TipoActividad, $Fecha, $Direccion, $Visibilidad, $CantidadPersonas, $EdadMinima, $Lugar, $IdMunicipio, $IdUsuario, $IdSugerencia);

        // Ejecutar la consulta
        if (!$sentencia->execute()) {
            return ["error" => "Error al modificar el plan: " . $sentencia->error];
        }

        $sentencia->close();

        // Setteo el plan recien insertado para retornarlo
        $planModificado = [
            "plan_id" => $Id,
            "plan_nombre" => $Nombre,
            "plan_descripcion" => $Descripcion,
            "plan_foto" => $Foto,
            "plan_tipoActividad" => $TipoActividad,
            "plan_fecha" => $Fecha,
            "plan_direccion" => $Direccion,
            "plan_visibilidad" => $Visibilidad,
            "plan_cantidadPersonas" => $CantidadPersonas,
            "plan_idMunicipio" => $IdMunicipio,
            "plan_idUsuario" => $IdUsuario,
            "plan_idSugerencia" => $IdSugerencia,
            "plan_lugar" => $Lugar,
            "plan_edadMinima" => $EdadMinima
        ];
        return $planModificado; // Retorna el plan modificado
    }

    // Metodo para eliminar un plan: Puede devolver un array con error o un array con datos
    function eliminarPlan($Id)
    {
        $planEliminado = []; // Array asociativo para almacenar los datos del plan eliminado

        // Verificar si la conexión fue exitosa
        if ($this->conexion->connect_error) {
            return ["error" => "Error de conexión: " . $this->conexion->connect_error];
        }

        // Preparar la consulta con el procedimiento almacenado
        $sql = "CALL sp_eliminar_plan(?)";
        $sentencia = $this->conexion->prepare($sql);

        if (!$sentencia) { 
            return ["error" => "Error en la preparación de la consulta: " . $this->conexion->error];
        }

        // Vincular parámetros
        $sentencia->bind_param("i", $Id);

        // Ejecutar la consulta
        if (!$sentencia->execute()) {
            return ["error" => "Error al eliminar el plan: " . $sentencia->error];
        }

        // Obtener filas afectadas
        $resultado = $sentencia->affected_rows;

        // Cerrar la sentencia y la conexión
        $sentencia->close();

        if ($resultado === 0) {
            return ["error" => "No se encontró el plan con ID: " . $Id];
        }

        $planEliminado = [
            "plan_id" => $Id,
            "mensaje" => "Plan eliminado correctamente."
        ];

        return $planEliminado; // Retorna el plan eliminado
    }

} // Fin de la clase 