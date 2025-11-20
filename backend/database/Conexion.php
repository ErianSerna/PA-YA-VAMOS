<?php
require_once("datosConexion.php");

// Clase de Conexion implementando el Patrón de Diseño Singleton
class Conexion {
    private static $conexion = null; // Objeto mysqli

    private function __construct() {
        self::$conexion = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    }

    public static function getConnection() {
        if (self::$conexion == null) {
            new Conexion(); //Llamada al constructor privado para inicializar $conexion
        }

        return self::$conexion; // Retorno la conexion
    }
}