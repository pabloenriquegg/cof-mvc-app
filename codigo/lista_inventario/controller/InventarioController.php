<?php
/**
 * Controlador InventarioController
 * 
 * Este controlador gestiona las consultas del inventario , asegurando que el usaurio esté autenticado
 * Se encarga de obtener los estados y tipos del inventario
 * y consulta los inventarios filtrados
 * 
 * @author Pablo Enrique Guntín Garrido <pabloenriqueguntin@icloud.com>
 * @since 2025-03-10
 * @version 1.0.0
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Verifica si el usuario ha iniciado sesion
 * Si no ha iniciado sesion, lo devuelve a la pagina de login
 */
if (!isset($_SESSION['usuario'])) {
    header("Location: /ApplicacionCofanoMVC/view/loginView.php");
    exit();
}

require_once __DIR__ . '/../model/InventarioModel.php';

/**
 * Clase inventarioController
 * 
 * Controlador para gestionar la obtencion de estados, tipos y listado de inventarios
 */
class InventarioController {

    /**
     * 
     *
     * @var InventarioModel instancia del modelo de inventario
     */
    private $model;

    /**
     * Constructor de la clase
     * Inicializa la instancia del modelo InventarioModel
     */
    public function __construct(){
        // error_log("CONSTRUCTOR CONTROLLER");
         $this->model = new InventarioModel();
     }
    
     /**
      * Obtiene la lista de estados y tipo de inventario
      *
      * @return array devuelve un array con estasados y tipos
      */
    public function obtenerEstadosTipos() {
        return $this->model->getEstadosTipos();
    }

    /**
     * Obtiene la lista de inventarios filtrada por estado y por tipo
     *
     * @param int $estado ID del estado seleccionado
     * @param int $tipo Id del tipo seleccioando
     * @return array Devuelve un arraty con los inventario filtrados
     */
    public function obtenerInventarios($estado, $tipo) {
        return $this->model->getInventarios($estado, $tipo);
    }
   
}

//Instancia del controlador de inventario
$controller = new InventarioController();

/**
 * @var array $dataSeleccion Estados y tipos de inventario obtenidos de  la BBDD
 */
$datosSeleccion = $controller->obtenerEstadosTipos();

//Se inician las variables vacías para los filtros de búsqueda
$estadoSeleccionado = 0;
$tipoSeleccionado = 0;
$inventarios = [];


/**
 * Maneja las solicitudes POST para filtrar los inventarios segun el estado y tipo seleccionado
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estadoSeleccionado = isset($_POST['estado']) ? (int) $_POST['estado'] : 0;
    $tipoSeleccionado = isset($_POST['tipo']) ? (int) $_POST['tipo'] : 0;
    
    $inventarios = $controller->obtenerInventarios($estadoSeleccionado, $tipoSeleccionado);
}

//Cargar la vista del inventario
require_once '../view/InventarioView.php';

?>