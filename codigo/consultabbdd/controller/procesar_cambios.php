<?php
//Procesar los cambios de semaforo
require_once __DIR__ . '/../../model/conexion.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo json_encode([
        "error" => "Método permitido.",
        "debug_method" => $_SERVER['REQUEST_METHOD']
    ]);
    exit(); 
}

$input = file_get_contents("php://input");
error_log("Datos recibidos: " . $input);
$datos = json_decode($input, true);

if (!$datos) {
    echo json_encode((["error" => "error al decodificar JSON.", "raw_data" => $input]));
}
//$datos = json_decode(file_get_contents("php://input"), true);

if (!isset($datos['cambios']) || empty($datos['cambios'])) {
    echo json_encode(["error" => "No se recibieron cambios.", "decoded_data" => $datos]);
    exit();
}

try {
    $pdo = Conexion::getConexion();
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("UPDATE COFAPAAL.PACFINFOTRF SET cantidad = :cantidadReal WHERE numeroTransfer = :numeroTransfer");

    foreach ($datos['cambios'] as $cambio) {
        $stmt->bindParam(":cantidadReal", $cambio['cantidadReal'], PDO::PARAM_INT);
        $stmt->bindParam(":numeroTransfer", $cambio['numeroTransfer'], PDO::PARAM_STR);
        $stmt->execute();
    }

    $pdo->commit();
    echo json_encode(["success" => "Datos actualizados correctamente."]);
} catch (PDOException $e) {
    $pdo->rollBack();
    error_log("error al actualizar datos: " . $e->getMessage());
    echo json_encode(["error" => "error en la actualizacion." . $e->getMessage()]);
}


?>