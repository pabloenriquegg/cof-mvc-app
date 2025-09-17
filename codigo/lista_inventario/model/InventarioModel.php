<?php
/**
 * Modelo Inventario Model
 * 
 * Maneja la conexion y las consultas a la BBDD relacionadas con los inventarios
 * Utiliza procedimientos almacenados en la BBDD para obtener estados, tipos e informacion de inventarios
 * 
 * @author Pablo Enrique Guntín Garrido <pabloenriqueguntin@icloud.com>
 * @since 2025-03-10
 * 
 */

require_once __DIR__ . '/../../model/conexion.php';

class InventarioModel {
    /**
     * 
     *
     * @var PDO $pdo Intancia de conexion a la base de datos
     */
    private $pdo;

    /**
     * Constructor de la clase
     * 
     * establece la conexion a la BBDD utilizando la clas e'Conexion'
     */

    public function __construct(){
        $this->pdo = Conexion::getConexion();
    }

    /**
     * Obtiene los aestados y tipos de inventario mediante procedimientos almacenados
     *
     * @return array Devuelve un array con estados  (id y texto) y tipos (id y texto)
     */
    public function getEstadosTipos(){
        try {
            $estados = [];
            $tipos = [];
                    
            //Llamada al procedimiento almaceado para obtener estados de la familia 1
            $sql = "CALL PABLOG.PASELTXTINV(1)"; //obtener estados de la fmailia 1
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $resultadosEstados = $stmt->fetchAll(PDO::FETCH_NUM);

            error_log("Estados obtenidos: " . print_r($resultadosEstados, true));
           
            //Procesar los resultados de los estados
            foreach ($resultadosEstados as $estado) {
                if (isset($estado[0], $estado[1])){
                    $estados[] = [
                        'id' => $estado[0],
                        'texto' => $estado[1]
                    ];
                }
            }
             //Llamada al procedimiento almaceado para obtener estados de la familia 3
            $sql = "CALL PABLOG.PASELTXTINV(3)"; //obtener tipos de la familia 3
            $stmt = $this->pdo->prepare($sql);
            error_log("se ejecuta la consulta");
            if (!$stmt->execute()){
                error_log("Error ejecutando consulta de tipos");
            } else {
                error_log("Consulta de tipos ejecutada correctamente");
            }
            //$stmt->execute();
            $resultadosTipos = $stmt->fetchAll(PDO::FETCH_NUM);
            if (!$resultadosTipos) {
                error_log("No se obtuvieron tipos");
            } else {                
                error_log("Estados obtenidos: " . print_r($resultadosTipos, true));
            }
            
           //Procesar los resultados de los estados
            foreach ($resultadosTipos as $tipo) {
                if (isset($tipo[0], $tipo[1])){
                    $tipos[] =[
                        'id' => $tipo[0],
                        'texto' => $tipo[1]
                    ];
                }
            }
            return [
                'estados' => $estados,
                'tipos' => $tipos
            ];

            
        } catch (PDOException $e) {
            error_log("error en la consulta: " . $e->getMessage());
            return ['estados' => [], 'tipos' => []];
        }

    }

    /**
     * Obtiene la lista de inventarios filtrada del bombo de estado y de tipo
     *
     * @param int $estado ID del estado del inventario
     * @param int $tipo ID del tipo de inventario
     * @return array Devuelve una lisa de inventarios con el id, fecha, descripcion, tipo, estado y usuario.
     */
    public function getInventarios($estado, $tipo) {
        try {
            //      CALL PABLOG.paSelLstInv(0,0);
            //      CALL PABLOG.PASELLSTINV(0,0);
            //LLamada al procedimiento almaceado con el estado y tipo
            $sql = "CALL PABLOG.PASELLSTINV(?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(1, $estado, PDO::PARAM_INT);
            $stmt->bindParam(2, $tipo, PDO::PARAM_INT);
            $stmt->execute();

            $resultados = $stmt->fetchAll(PDO::FETCH_NUM) ?: [];

            if (!$resultados) {
                error_log("No se obtuvieron estados  y tipos de la bbdd.");
            } else {
                error_log("Estados y tipos obtenidos: " . json_encode($resultados));
            }

            $inventarios = [];

            //Procesa los resulados de inventario
            foreach ($resultados as $inv) {
                $inventarios[] = [
                    'id_inventario' => $inv[0] ?? 'Vacío',
                    'fecha' => $inv[1] ?? 'Vacío',
                    'descripcion' => $inv[2] ?? 'Vacío',
                    'tipo' => $inv[3] ?? 'Vacío',
                    'estado' => $inv[4] ?? 'Vacío',
                    'usuario' => $inv[5] ?? 'Vacío'
                ];
            }

            return $inventarios;
        }catch (PDOException $e) {
            error_log("error en la consulta: " . $e->getMessage());
            return ["error" => $e->getMessage()];
        }
    }

  
}

?>