<?php
require_once("../lib_repositorio/planRepositorio.php");

class planAplicacion
{
    private $planRepositorio;
    
    // Metodo constructor que recibe un objeto de planRepositorio por medio de inyeccion de dependencias
    public function __construct($planRepositorio)
    {
        $this->planRepositorio = $planRepositorio;
    }
    
    function listarPlanes()
    {
        // Obtener el listado de planes del repositorio
        $resultado = $this->planRepositorio->listarPlanes();
        
        // Manejar errores del repositorio
        if (isset($resultado["error"])) {
            echo json_encode(["mensaje" => $resultado["error"]]);
            exit;
        }
        
        // Retornar el JSON con el listado de planes
        echo json_encode($resultado);
        exit;
    }
    
    function listarPlanesUsuario($IdUsuario)
    {
        // Validar IdUsuario
        if (empty($IdUsuario) || !ctype_digit($IdUsuario)) {
            echo json_encode(["mensaje" => "ID de usuario inválido."]);
            exit;
        }
        
        // Obtener el listado de planes del repositorio
        $resultado = $this->planRepositorio->listarPlanesUsuario($IdUsuario);
        
        // Manejar errores del repositorio
        if (isset($resultado["error"])) {
            echo json_encode(["mensaje" => $resultado["error"]]);
            exit;
        }
        
        // Retornar el JSON con el listado de planes
        echo json_encode($resultado);
        exit;
    }
    
    function insertarPlan($Nombre, $Descripcion, $RutaImg, $TipoActividad, $Fecha, $Direccion, $Visibilidad, $CantidadPersonas, $IdMunicipio, $IdUsuario, $IdSugerencia, $Lugar, $EdadMinima)
    {
        // Validar campos obligatorios
        if ( empty(trim($Lugar)) ||
            empty(trim($Nombre)) ||
            empty(trim($Descripcion)) ||
            empty(trim($TipoActividad)) ||
            empty(trim($Fecha)) ||
            empty(trim($Direccion)) ||
            empty(trim($Visibilidad)) ||
            empty($CantidadPersonas) || !ctype_digit($CantidadPersonas) ||
            empty($EdadMinima) || !ctype_digit($EdadMinima) ||
            empty($IdMunicipio) || !ctype_digit($IdMunicipio) ||
            empty($IdUsuario) || !ctype_digit($IdUsuario)) {
                echo json_encode(["mensaje" => "Hay campos vacíos o inválidos."]);
                exit;
            }
        
        // Validar que haya imagen
        if (empty($RutaImg)) {
            echo json_encode(["mensaje" => "Debe subir una imagen para el plan."]);
            exit;
        }
        
        // Insertar el plan
        $resultado = $this->planRepositorio->insertarPlan(
            $Nombre, $Descripcion, $RutaImg, $TipoActividad, $Fecha, $Direccion,
            $Visibilidad, $CantidadPersonas, $IdMunicipio, $IdUsuario, $IdSugerencia,
            $Lugar, $EdadMinima
        );
        
        // Manejar errores del repositorio
        if (isset($resultado["error"])) {
            echo json_encode(["mensaje" => $resultado["error"]]);
            exit;
        }
        
        // Retornar el JSON con el plan insertado
        echo json_encode($resultado);
        exit;
    }
        
    function modificarPlan($Id, $Nombre, $Descripcion, $RutaImg, $TipoActividad, $Fecha, $Direccion, $Visibilidad, $CantidadPersonas, $IdMunicipio, $IdUsuario, $IdSugerencia, $Lugar, $EdadMinima)
    {
        // Validar campos obligatorios
        if (empty($Id) || !ctype_digit($Id) ||
            empty(trim($Lugar)) ||
            empty(trim($Nombre)) ||
            empty(trim($Descripcion)) ||
            empty(trim($TipoActividad)) ||
            empty(trim($Fecha)) ||
            empty(trim($Direccion)) ||
            empty(trim($Visibilidad)) ||
            empty($CantidadPersonas) || !ctype_digit($CantidadPersonas) ||
            empty($EdadMinima) || !ctype_digit($EdadMinima) ||
            empty($IdMunicipio) || !ctype_digit($IdMunicipio) ||
            empty($IdUsuario) || !ctype_digit($IdUsuario)) {
                echo json_encode(["mensaje" => "Hay campos vacíos o inválidos."]);
                exit;
            }
            
        // Validar que haya imagen
        if (empty($RutaImg)) {
            echo json_encode(["mensaje" => "Debe subir una imagen para el plan."]);
            exit;
        }
        
        // Modificar el plan
        $resultado = $this->planRepositorio->modificarPlan(
            $Id, $Nombre, $Descripcion, $RutaImg, $TipoActividad, $Fecha, $Direccion,
            $Visibilidad, $CantidadPersonas, $IdMunicipio, $IdUsuario, $IdSugerencia,
            $Lugar, $EdadMinima);
            
            // Manejar errores del repositorio
            if (isset($resultado["error"])) {
                echo json_encode(["mensaje" => $resultado["error"]]);
                exit;
            }
            
            // Retornar el JSON con el plan modificado
            echo json_encode($resultado);
            exit;
        }

    function eliminarPlan($Id){
        $resultado = $this->planRepositorio->eliminarPlan($Id);
        
        if (isset($resultado["error"])) {
            echo json_encode(["mensaje" => $resultado["error"]]);
            exit;
        }
        
        echo json_encode($resultado);
        exit;
    }
}
            