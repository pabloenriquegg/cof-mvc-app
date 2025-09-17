<?php
//model de la consulta para COFAPAAL.PACFINFOTRF

require_once __DIR__ . '/../../model/conexion.php';

class ModelConsulta {
    private $pdo;

    public function __construct(){
        $this->pdo = Conexion::getConexion();
    }
    public function getLineasInfoTransfer($codigoLaboratorio, $fechaInicio, $fechaFin){
        try {
            error_log("SE EJECUTA LA CONSULTA CON: lab=$codigoLaboratorio, fechaIni=$fechaInicio, fechaFin=$fechaFin");
        //$sql = "CALL COFAPAAL.PACFINFOTRF(:lab, :fechaIni, :fechaFin, ?";
        $sql = "CALL COFAPAAL.PACFINFOTRF(?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $mensaje = '';
        $stmt->bindParam(1, $codigoLaboratorio, PDO::PARAM_STR);
        $stmt->bindParam(2, $fechaInicio, PDO::PARAM_STR);
        $stmt->bindParam(3, $fechaFin, PDO::PARAM_STR);
        $stmt->bindParam(4, $mensaje, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 200);
            /*
        $stm->bindParam(':lab', $codigoLaboratorio, PDO::PARAM_STR);
        $stm->bindParam(':fechaIni', $fechaInicio, PDO::PARAM_STR);
        $stm->bindParam(':fechaFin', $fechaFin, PDO::PARAM_STR);
        $mensaje = null;
        $stm->bindParam(4, $mensaje, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 200);
        */
        $stmt->execute();

        
        $resultados = $stmt ->fetchAll(PDO::FETCH_ASSOC);
        $lineasParseadas = [];
            //procesar las lineas
        foreach ($resultados as $row) {
            if (!empty($row['STRLINEA'])){
                $datos = explode(";", $row['STRLINEA']);
                $lineasParseadas[] = [
                    'numeroTransfer' => $datos[0] ??'',
                    'cifDistribuidor' => $datos[1] ?? '',
                    'cifCliente' => $datos[2] ?? '',
                    'codigoDesconocido' => $datos[3] ?? '',
                    'descripcionArticulo' => $datos[4] ?? '',
                    'cantidad' => $datos[5] ?? ''
                ];
            }
        }
        error_log("CONSULTA EJECUTADA. MENSJAE: $mensaje, REGISTROS OBTENIDOS: " .count($resultados));

        return ['mensaje' => $mensaje ?: '', 'lineas' => $lineasParseadas]; 


        } catch (PDOException $e) {
            error_log("ERROR EN LA CONSULTA: " . $e->getMessage());
            return [ 'mensaje' => "Error de consulta", 'lineas' => []];
        }
    }
}


?>