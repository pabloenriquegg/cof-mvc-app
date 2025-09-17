<?php
/**
 * Vista de detalle y modificacions de inventario
 * 
 * En esta vista se puede visualizar y modificar los detalles de inventario, proporcionando opciones para editar unidades y fecha de caducidad
 * también s epueden guardar cambios de forma individual o por lotes. 
 * Se muestra también un semaforo que cmabia de rojo a verde en función de si se ha modificado, volviendo a rojo cuando se guarda el cambio
 * 
 * @author Pablo Enrique Guntín Garrido <pabloenriqueguntin@icloud.com>
 * @since 2025-03-10
 */

require_once '../controller/DetalleInventarioController.php';
/**
 * Verifica si se ha proporcionado un ID de inventario y un usuario en la URL
 */
if (!isset($_GET['id'])) {
    echo "ID de inventario no seleccionado";
    exit();
}

if (!isset($_GET['usuario'])) {
    echo "Usuario no especificado.";
    exit();
} 

$idInventario = (int) $_GET['id'];
$usuario = htmlspecialchars($_GET['usuario']);

/**
 * Obtiene los detalles del inventario seleccionado
 * @var array $detalles Contiene la informacion de los productos del inventario
 */
$controller = new DetalleInventarioController();
$detalles = $controller->obtenerDetalleInventario($idInventario);
?>

<!DOCTYPE html>
<html lang= "es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <meta name="description" content="Detalles y modificaciones del inventario." >
    <meta name="author" content="Pablo Enrique Guntín Garrido">
    <link rel="stylesheet" href="../../styles/inventario.css"> 
    <title>Detalles de inventario</title>
    <!--Librerias a adjuntar para la paginación-->
    <!--DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.2.4/css/fixedColumns.dataTables.css">
    <!-- jQuery y DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/3.2.4/js/fixedColumns.dataTables.js"></script>
     <!-- Script paginación-->
     <script src="/ApplicacionCofanoMVC/js/paginacion_detalle_inventario.js"></script>
    
</head>
<body>
    <?php include '../../templates/header.php'; ?>
    <h3 class="titulo-inventario">Detalle y modificaciones del inventario ID: <?= htmlspecialchars($idInventario); ?></h2>
    <h3 class="titulo-inventario">Usuario: <?= htmlspecialchars($usuario); ?></h3>
    <?php if (!empty($detalles)): ?>
        <div class="contenedor-boton">
            <button id="procesar-todos">Procesar cambios</button>
        </div>
        <table class= "tabla-inventario" id="tabla-inventario" border="1">
            <thead>
                <tr>
                    <th>Semáforo</th>
                    <th>EAN</th> <!--Detalle 0-->
                    <th>Descripción</th>
                    <th>Unidades</th>
                    <th>Fecha Caducidad (MMAAAA)</th>
                    <th>Estado</th>
                    <th>Usuario</th>
                    <th>Ubicación</th>
                    <th>Unidades reales</th>
                    <th>Caducidad reales</th>
                    <th>Guardar</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($detalles as $detalle): ?>
                    <tr>
                        <td class="semaforo rojo">🔴</td>
                        <td><?= htmlspecialchars($detalle[0]); ?></td> <!--EAN-->
                        <td><?= htmlspecialchars($detalle[1]); ?></td>
                        <td><?= htmlspecialchars($detalle[2]); ?></td>
                        <td><?= htmlspecialchars($detalle[3]); ?></td>
                        <td><?= htmlspecialchars($detalle[4]); ?></td>
                        <td><?= htmlspecialchars($detalle[5]); ?></td>
                        <td><?= htmlspecialchars($detalle[6]); ?></td>
                        <td>
                            <input type="number" value="<?= htmlspecialchars($detalle[2]); ?>" class="editable uds">
                        </td>
                        <td>
                            <input type="number" value="<?= htmlspecialchars($detalle[3]); ?>" class="editable caducidad">
                            <!--Ver como poner un calendario solo para mes y año y parsearlo-->
                        </td>
                        <td>
                            <button class="guardar-btn" data-id="<?= $detalle[0]; ?>" disabled>Guardar</button>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    <?php else: ?>
        <p>No hay detalles para mostrar en este inventario.</p>
        <?php endif; ?>

        <script>
            //script para semáforo
            $(document).ready(function(){

                //primero se detectan los cambios en cualquiera de los inputs y habilita el botón guardar
                $(".editable").on("input", function(){
                    let row = $(this).closest("tr");
                    row.find(".semaforo").removeClass("rojo").addClass("verde").text("🟢");
                    row.find(".guardar-btn").prop("disabled", false);
                });

                //se guarda solo la fila modificada
                $(".guardar-btn").click(function(){
                    let row = $(this).closest("tr");
                    let idInventario = <?=  $idInventario; ?>; //obtener el id del inventarioo
                    let usuario = "<?= $usuario; ?>"
                    let idEan = row.find(".guardar-btn").data("id"); //ID ean del producto
                    let uds = row.find(".uds").val();
                    let caducidad = row.find(".caducidad").val();

                    $.post("../controller/DetalleInventarioController.php", {
                        action: "guardar", 
                        id_inventario: idInventario, 
                        ean: idEan, 
                        uds: uds, 
                        caducidad: caducidad, 
                        usuario: usuario
                    }, function(response){
                        alert(response);
                        row.find(".semaforo").removeClass("verde").addClass("rojo").text("🔴");
                        row.find(".guardar-btn").prop("disabled", true);
                    });
                });
                //Botón para guardar todos los cambios a la vez
                $("#procesar-todos").click(function(){
                    let cambios = [];

                    $("tr").each(function() {
                        let row = $(this);
                        if (row.find(".semaforo").hasClass("verde")) { //Se procesan y guardan las filas modificadas
                            let idInventario = <?= $idInventario; ?>;

                            let idEan = row.find(".guardar-btn").data("id");
                            let uds = row.find(".uds").val();
                            let caducidad = row.find(".caducidad").val();
                            cambios.push({
                                id_inventario: idInventario, 
                                ean: idEan, 
                                uds: uds, 
                                caducidad: caducidad, 
                                usuario: "<?= $usuario; ?>"
                            });
                        }
                    });
                    if (cambios.length > 0) {
                        $.post("../controller/DetalleInventarioController.php", {
                            action: "guardar_todos", 
                            cambios: JSON.stringify(cambios) //Se envían todos los ambios al json
                        }, function(response) {
                            alert(response);
                            row.find(".semaforo").removeClass("verde").addClass("rojo").text("🔴");
                            row.find(".guardar-btn").prop("disabled", true);
                        });
                    } else {
                        alert("No hay cambios para procesar.");
                    }
                });
            });
        </script>
        <!-- Script paginación
        <script src="../../js/paginacion_detalle_inventario.js"></script>-->
</body>

</html>
