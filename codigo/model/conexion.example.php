<?php
/**
 * Clase conexion modificada para evitar problemas de seguridad
 * 
 * Maneja la conexion de la base de datos utilizando PDO y ODBC.
 * @author Pablo Enrique Guntín Garrido <pabloenriqueguntin@icloud.com>
 * @since 2025-03-10
 */
class Conexion {
    /**
     *
     * @var PDO|null $pdo Instancia única de la conexion a la base de datos.
     */
    private static $pdo = null;
    /**
     * Constructor privado para evitar la creacion de instancias de la clase.
     */
    private function __construct(){

    }
    /**
     * Obtiene una conexion PDO con la bbdd.
     * Si la conexion existe, la devuelve, si no existe la crea.
     */
    
   class Conexion {
    private static $pdo = null;

    private function __construct() {}

    public static function getConexion() {
        if (self::$pdo === null) {
            $dsn = "odbc:Driver={iSeries Access ODBC Driver};SYSTEM=SERVIDOR;PORT=PUERTO;UID=USUARIO;PWD=CONTRASEÑA;CCSID=1208";

            try {
                self::$pdo = new PDO($dsn);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error al conectarse con la base de datos: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }

    public static function cerrarConexion() {
        self::$pdo = null;
    }
}

?>