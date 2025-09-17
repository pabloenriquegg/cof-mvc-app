<?php
/**
 * Controlador DetalleInventarioController
 * 
 * Este controller gestiona la consulta y actualizaciones de los detalles de inventario
 * se asegura que ell usuario esté autenticado y maneja tanto las actualizaciones individuales como múltiples a la BBDD mediante procedimientos almacenados
 * 
 * @author Pablo Enrique Guntín Garrido <pabloenriqueguntin@icloud.com>
 * @since 2025-03-10
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

require_once __DIR__ . '/../model/DetalleInventarioModel.php';


/**
 * Clase DetalleInventarioController
 * 
 * Controllador para gestionar la obtencion y actualizacion de los detalles de inventario
 */
class DetalleInventarioController {

    /**
     * 
     *
     * @var DetalleInventarioModel $model Instancia del modelo de detalle de inventario
     */
    private $model;

    /**
     * Constructor de la clase
     * 
     * Inicializa la instancia del modelo DetalleInventarioModel
     */
    public function __construct(){
        // error_log("CONSTRUCTOR CONTROLLER");
         $this->model = new DetalleInventarioModel();
    }


    /**
     * Obtiene los detalles de un inventario específico
     *
     * @param int $idInventario ID del invnetario a consultar
     * @return array Devuelve un array con los detalles del ivnentario o un array vacio si no hay datos
     */
    public function obtenerDetalleInventario($idInventario) {
        return $this->model->getDetalleInventario($idInventario);
                            
    }

    /**
     * Guarda los cambios en el detalle de un inventario
     *
     * @param int $idinventario Id del inventario a actualizar
     * @param int $ean Codigo EAN 13 del producto (codigo de barras)
     * @param int $uds Camtodad de unidades del producto
     * @param string $caducidad Fecha de caducidad del producto (mes y año)
     * @param string $usuario Nombre del usaurio que hace la modificaion
     * @return bool Devuelve true si hubo exito. false si ocurre un error
     */
    public function guardarCambiosDetalle ($idInventario, $ean, $uds, $caducidad, $usuario) {
        return $this->model->saveCambiosDetalle($idInventario, $ean, $uds, $caducidad, $usuario);
    }
}


//Procesa solicitudes POST para guardar los cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new DetalleInventarioController(); 
    /**
     * Guarda un unico cmabio en el detalle del inventario
     */
    if ($_POST['action'] === "guardar") {
        $idInventario = $_POST['id_inventario'] ?? null;
        $ean = isset($_POST['ean']) ? $_POST['ean'] : null;
        $uds = isset($_POST['uds']) ? $_POST['uds'] : null;
        $caducidad = (int) $_POST['caducidad'] ?? null;
        $usuario = $_POST['usuario'] ?? ($_SESSION['usuario'] ?? 'Desconocido');

        error_log("Intentando guardar datos: idInventario=$idInventario, ean=$ean, uds=$uds, caducidad=$caducidad, usuario=$usuario");

        //Verifica que los datos no estén vacíos antes de guardar
        if ($idInventario === null || $ean === null || $uds === null || $caducidad === null){
            error_log("Error. Los datos están incompletos.");
            echo "Error. Los datos están incompletos.";
        }
        
        $resultado = $controller->guardarCambiosDetalle($idInventario, $ean, $uds, $caducidad, $usuario);
        if (!$resultado) {
            error_log("Error al ejecutar el procedemiento almacenado");
            echo "EErrror al guardar los camboios";
        } else {
        echo "Guardado correctamente";
        }
        exit();
        
    }
    /**
     * Guarda múltiples cambios en el detalle del inventario
     */
    if ($_POST['action'] === "guardar_todos") {
        //compribar si contiene cambios
        if (!isset($_POST['cambios']) || empty($_POST['cambios'])) { 
            echo "Error: No se han recibido datos."; 
            exit(); 
        } 
        //verificar si es un array valido
        $cambios = json_decode($_POST['cambios'], true); 
        if (!is_array($cambios)) { 
            echo "Errorrrr. Los datos recibidos no son validos."; 
            exit(); 
        }
        
        $errores = 0; 

        foreach ($cambios as $cambio) { 
            
            //comprobar que las claves existen antes de acceder 
            
            $idInventario = isset($cambio['id_inventario']) ? (int) $cambio['id_inventario'] : null; 
            $ean = isset($cambio['ean']) ? (int) $cambio['ean'] : null; 
            $uds = isset($cambio['uds']) ? (int) $cambio['uds'] : null; 
            $caducidad = isset($cambio['caducidad']) ? $cambio['caducidad'] : null; 
            $usuario = isset($cambio['usuario']) ? $cambio['usuario'] : 'Desconocido'; 
            
            if ($idInventario === null || $ean === null || $uds === null || $caducidad === null) { 
                error_log("Errorr. Datos incompletos."); 
                $errores++; 
                continue; 
            } 

            //guarda los cambios en la BBDD (o lo intenta)
            $resultado = $controller->guardarCambiosDetalle($idInventario, $ean, $uds, $caducidad, $usuario); 
            if (!$resultado) { 
                error_log("Error al ejecitar el procedimiento para idInventario: $idInventario, EAN: $ean"); 
                $errores++; 
            } 
        } 
        echo $errores === 0 ? "Todos los cambios fueron guardados correctamente." : "Existen $errores errores al intentar guardar los cambios"; 
        exit(); 
    }  
}

?>