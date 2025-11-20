<?php
require_once("../database/Conexion.php");

class sugerenciaRepositorio {

    private $conexion;

     // Constructor que recibe la conexion por medio de inyección de dependencias
    public function __construct($conexion)
    {
        $this->conexion = $conexion;

    }

    //consultar las sugerencias segun el filtro: esta funcion puede devolver un array con un error, un array con datos o un array vacio
    function consultarSugerenciasPorFiltro($IdMunicipio,$TipoActividad){
        //primero verificamos si la conexion fue exitosa
        if($this->conexion->connect_error){
            return ["error" => "Error de conexión: " . $this->conexion->connect_error];
        }
        //llama al procedimiento almacenado y se prepara la consulta
        $sql = "CALL SP_consultarSugerenciasPorFiltro(?,?)";
        $sentencia = $this->conexion->prepare($sql);

        if (!$sentencia) { // sentencia = false
            return ["error" => "Error en la preparación de la consulta: " . $this->conexion->error];
        }

        //luego vinculamos los parametros
        $sentencia->bind_param("is", $IdMunicipio,$TipoActividad);

        //ejecutamos la sentencia
        if (!$sentencia->execute()) { // si la ejecucion fue fallida, retorna false, de lo contrario true
            return ["error" => "Error al consultar sugerencias"];
        }

        $resultado = $sentencia->get_result(); // Obtengo un objeto mysqli_result con los resultados

        // true si $resultado es un objeto mysqli_result, false si es null
        if ($resultado) {
            $resultado = $resultado->fetch_all(MYSQLI_ASSOC); // Obtiene un array con la fila obtenida
        }

        //cerra la sentenecia y la conexion
        $sentencia->free_result();
        $sentencia->close();
        if(isset($resultado)){
            $sugerenciaConsultado = $resultado;
        }else{
            $sugerenciaConsultado = [];
        }
        return $sugerenciaConsultado;
    }

    function consultarTodos()
    {
        if ($this->conexion->connect_error) {
            return ["error" => "Error de conexión: " . $this->conexion->connect_error];
        }

        $this->conexion->set_charset("utf8mb4");

        $sql = "SELECT * FROM sugerencia";
        $resultado = $this->conexion->query($sql);

        if (!$resultado) {
            return ["error" => "Error en consulta: " . $this->conexion->error];
        }

        $datos = [];
        if ($resultado) {
            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
            $resultado->free();
        }

        return $datos;
    }
}
?>
