<?php
/**
 * Modelo Detalle Inventario Model
 * 
 * Este modelo gestiona la obtencion y actualizacion de detalles del inventario
 * en la BBDD mediante procedimientos almacenados
 * 
 * @author Pablo Enrique Guntín Garrido <pabloenriqueguntin@icloud.com>
 * @since 2025-03-10
 */

require_once __DIR__ . '/../../model/conexion.php';

class DetalleInventarioModel {
    /**
     * 
     *
     * @var PDO $pdo Instancia de conexion a la BBDD
     */
    
    private $pdo;

    /**
     * Constructor a de la clase
     * 
     * Establece la conexion con la BBDD utilizando la clase conexion
     */
    public function __construct(){
        $this->pdo = Conexion::getConexion();
    }

    /**
     * Obtiene el detalle de un inventraio específico
     *
     * @param int $idinventario ID del inventario del cuel se desea obtener el detalle
     * @return array Devuelve un array con los detalles del inventario o un array vacio si no existieran datos
     */
    public function getDetalleinventario($idinventario) {
        try {

            //Llamada al procedimiento almacenado para obtener el detalle del inventario
            //      CALL PABLOG.paSelDetInv(?);
            $sql = "CALL PABLOG.PASELDETINV(?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(1, $idinventario, PDO::PARAM_INT);
            $stmt->execute();

            //Obteien los resultados y devuelve un array vacio si hay datos
            $resultados = $stmt->fetchAll(PDO::FETCH_NUM);
            return $resultados ?: [];

        } catch (PDOException $e) {
            error_log("Error en la consulta" . $e->getMessage());
            return [];
        }
    }

    /**
     * Guarda los cambios en el detalle de un invnetario
     *
     * @param int $idinventario Id del inventario a actualizar
     * @param int $ean Codigo EAN 13 del producto (codigo de barras)
     * @param int $uds Camtodad de unidades del producto
     * @param string $caducidad Fecha de caducidad del producto (mes y año)
     * @param string $usuario Nombre del usaurio que hace la modificaion
     * @return bool Devuelve true si hubo exito. false si ocurre un error.
     */
    public function saveCambiosDetalle($idinventario, $ean, $uds, $caducidad, $usuario) {
        try{

            //LLamada al procedimiento para actualizar 
            //      CALL paUpdInv(idInventario, EAN13, Uds,Caducidad,Usuario)
            $sql = "CALL PABLOG.PAUPDINV(?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(1, $idinventario, PDO::PARAM_INT);
            $stmt->bindParam(2, $ean, PDO::PARAM_INT);
            $stmt->bindParam(3, $uds, PDO::PARAM_INT);
            $stmt->bindParam(4, $caducidad, PDO::PARAM_STR);
            $stmt->bindParam(5, $usuario, PDO::PARAM_STR);
            
            //ejecutar la consulta y verificar si existe exito
            if (!$stmt->execute()){
                error_log("Error en la consulta de update");
                error_log("valores enviado: idInventario=$idinventario, ean=$ean, uds=$uds, caducidad=$caducidad, usuario=$usuario");
                return false;
            }
            return true;
            //return $stmt->execute();

        } catch (PDOException $e) {
            error_log("Error al actualizar: " . $e->getMessage());
            return false;
        }
    }


}

?>