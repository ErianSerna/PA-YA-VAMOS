<?php
require_once("../lib_repositorio/UsuarioRepositorio.php");

class usuarioAplicacion
{
    private $usuarioRepositorio;

    // Metodo constructor que recibe un objeto de usuarioRepositorio por medio de inyeccion de dependencias
    public function __construct($usuarioRepositorio)
    {
        $this->usuarioRepositorio = $usuarioRepositorio;
    }

    //----------------------------------------------------------------------Parte del register----------------------------------------------------------------------

    function insertarUsuario($nombre, $apellido, $correo, $contrasena, $fechaNacimiento, $idMunicipio)
    {
        // Validar que los datos no estén vacios
        if ((!is_string($nombre) || empty(trim($nombre))) ||
            (!is_string($apellido) || empty(trim($apellido))) ||
            (!is_string($correo) || empty(trim($correo))) ||
            (!is_string($contrasena) || empty(trim($contrasena))) ||
            (empty(trim($fechaNacimiento))) ||
            (empty(trim($idMunicipio)))
        ) {


            echo json_encode(["mensaje" => "Todos los campos de texto deben ser válidos y no vacíos"]);
            exit;
        }

        // Validar que el usuario no este en uso
        if ($this->validarExistenciaUsuarioCorreo($correo)){
            echo json_encode(["mensaje" => "El correo no esta disponible"]);
            exit;
        }

        // Valido el formato del correo electronico
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["mensaje" => "El email debe tener un formato válido"]);
            exit;
        }

        // Hash de la contraseña
        $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

        // Almacena los datos del usuario insertado
        $resultado = $this->usuarioRepositorio->insertarUsuario($nombre, $apellido, $correo, $contrasenaHash, $fechaNacimiento, $idMunicipio);

        // Verifico si hubo un error en la insercion
        if (isset($resultado["error"])) {
            echo json_encode(["mensaje" => $resultado["error"]]);
            exit;
        }

        // Si no hubo problema alguno, retorna el json con los datos del usuario insertado
        echo json_encode($resultado);
        exit;
    }

        // Metodo para verificar si un nombre de usuario ya esta en uso
    function validarExistenciaUsuarioCorreo ($correo) {
        $resultado = $this->usuarioRepositorio->consultarPorCorreo($correo);

        $existe = false;
        if (count($resultado) > 0) {
            $existe = true;
        }
        return $existe;
    }

    //----------------------------------------------------------------------Parte del login----------------------------------------------------------------------

        function consultarUsuarioLogin($correo, $contrasena)
    {

        // Validar que los datos no estén vacios
        if ((!is_string($correo) || empty(trim($correo))) ||
            (!is_string($contrasena) || empty(trim($contrasena)))
        ) {
            echo json_encode(["mensaje" => "Todos los campos de texto deben ser válidos y no vacíos"]);
            exit;
        }

        // Validar que el usuario no este en uso
        if (!$this->validarExistenciaUsuarioCorreo($correo)){
            echo json_encode(["mensaje" => "El correo no existe"]);
            exit;
        }

        // Valido el formato del correo electronico
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["mensaje" => "El email debe tener un formato válido"]);
            exit;
        }

        // Almacena los datos del usuario insertado
        $resultado = $this->usuarioRepositorio->consultarPorCorreo($correo);

        // Verificar contraseña
        if (!password_verify($contrasena, $resultado["Contrasena"])) {
            echo json_encode(["mensaje" => "Contraseña incorrecta"]);
            exit;
        }

        // LOGIN EXITOSO → CREAR SESIÓN
        $_SESSION["usuario"] = [
            "id" => $resultado["Id"],
            "nombre" => $resultado["Nombre"],
            "apellido" => $resultado["Apellido"],
            "correo" => $resultado["Correo"],
        ];

        // Verifico si hubo un error en la insercion
        if (isset($resultado["error"])) {
            echo json_encode(["mensaje" => $resultado["error"]]);
            exit;
        }

        // Si no hubo problema alguno, retorna el json con los datos del usuario insertado
        echo json_encode($resultado);
        exit;
    }

}
