<?php
require_once("../lib_repositorio/sugerenciaRepositorio.php");

class sugerenciaAplicacion{
    private $sugerenciaRepositorio;

    // Metodo constructor que recibe un objeto de usuarioRepositorio por medio de inyeccion de dependencias
    public function __construct($sugerenciaRepositorio)
    {
        $this->sugerenciaRepositorio = $sugerenciaRepositorio;
    }

    function consultarSugerenciasPorFiltro($IdMunicipio,$TipoActividad){
        // Valido que id pasado sea un número y mayor a 0
        if (!is_numeric($IdMunicipio) || intval($IdMunicipio) <= 0) {
            echo json_encode(["mensaje" => "El ID debe ser un número mayor a 0"]);
            exit;
        }

        // Valido que la variable exista, sea un string y no esre vacio
        if (!isset($TipoActividad) || !is_string($TipoActividad) || trim($TipoActividad) == "") {
            echo json_encode(["mensaje" => "El NOMBRE debe ser un texto válido"]);
            exit;
        }

        $resultado = $this->sugerenciaRepositorio->consultarSugerenciasPorFiltro($IdMunicipio,$TipoActividad);

        // Verifico si hubo un error en la consulta
        if (isset($resultado["error"])) {
            echo json_encode(["mensaje" => $resultado["error"]]);
            exit;
        }

        if (empty($resultado)) {
            echo json_encode(["mensaje" => "No se encontró la sugerencia a consultar"]);
            exit;
        }

        echo json_encode($resultado);
        exit;
    }

      function consultarTodos()
    {
        $resultado = $this->sugerenciaRepositorio->consultarTodos();

        // Verifico si hubo un error en la consulta
        if (isset($resultado["error"])) {
            echo json_encode(["mensaje" => $resultado["error"]]);
            exit;
        }

        if (empty($resultado)) {
            echo json_encode(["mensaje" => "No hay sugerencias activos en la base de datos"]);
            exit;
        }

        echo json_encode($resultado);
        exit;
    }
}
?>