<?php
//controlador consulta
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario'])) {
    header("Location: /ApplicacionCofanoMVC/view/loginView.php");
    exit();
}

require_once __DIR__ . '/../model/consultamodel.php';

class ControllerConsulta {
    private $model;

    public function __construct(){
       // error_log("CONSTRUCTOR CONTROLLER");
        $this->model = new ModelConsulta();
    }
    public function mostrarConsulta($codigoLaboratorio, $fechaInicio, $fechaFin) {
        return $this->model->getLineasInfoTransfer($codigoLaboratorio, $fechaInicio, $fechaFin);      
        
    }
    
}
$data = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['codigoLaboratorio']) && !empty($_POST['fechaInicio']) && !empty($_POST['fechaFin'])){
    $codigoLaboratorio = $_POST['codigoLaboratorio'];
    $fechaInicio = date('Ymd', strtotime($_POST['fechaInicio']));
    $fechaFin = date('Ymd', strtotime($_POST['fechaFin']));
    $controller = new ControllerConsulta();
    $data = $controller->mostrarConsulta($codigoLaboratorio, $fechaInicio, $fechaFin);
}

require_once '../view/conssultaview.php';

?>