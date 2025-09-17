<?php
//prueba de la llamda a cofapaal pacfinfotrf
require_once __DIR__ . '/model/conexion.php';
try {
    $pdo = Conexion::getConexion();
     if (!$pdo) {
        throw new Exception("no hay conexion a la bbdd\n");
     } else {
        echo "<p>-hay conexion a la bbdd\n</p>";
       /* $sql = "SELECT 1 FROM SYSIBM.SYSDUMMY1\n";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute();
        echo "RESULTADO OK";
     */
    }


    $codigoLaboratorio = 'STD';
    $fechaInicio = 20250212;
    $fechaFin = 20250212;
    $mensaje = '';
    //COFAPAAL.PACFINFOTRF('ETS', 20250212, 20250212, ?);
    $sql = "CALL COFAPAAL.PACFINFOTRF('STD',20250212,20250212,?)";
    $stmt = $pdo->prepare($sql);
    echo "AQUI 1\n";

    //$stmt->bindParam(1, $codigoLaboratorio, PDO::PARAM_STR);
    //$stmt->bindParam(2, $fechaInicio, PDO::PARAM_STR);
    //$stmt->bindParam(3, $fechaFin, PDO::PARAM_STR);
    $stmt->bindParam(1, $mensaje, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 200);
    echo "AQUI\n";
    $stmt->execute();
    echo "DESPUESD\n";
    $resultados = $stmt ->fetchAll(PDO::FETCH_ASSOC);
    error_log("CONSULTA EJECUTADA. MENSJAE: $mensaje, REGISTROS OBTENIDOS: " .count($resultados));
    echo "<h2>Mensaje de la consulta:</h2>";
    echo "<p>" . htmlspecialchars($mensaje) . "</p>";

    echo "<h2>Dstos obtenidos:</h2>";
    if (!empty($resultados)) {
        echo "<pre>" . print_r($resultados, true) . "</pre>";

    } else{
        echo "<p>No se encontraron datos...</p>";
    }

} catch (PDOException $e) {
    echo "<p>Error en la consulta: " . $e->getMessage() . "</p>";
}


?>