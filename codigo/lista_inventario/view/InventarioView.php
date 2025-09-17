<?php
/**
 * Vista de consulta de inventario
 * 
 * Esta página permite visualizar y consultar inventarios en funcion de diferentes filtros como estado y tipo.
 * También proporciona una opcion para ver detalles de un inventario específico
 * 
 * @author Pablo Enrique Guntín Garrido <pabloenriqueguntin@icloud.com>
 * @since 2025-03-10
 */

if (session_status() === PHP_SESSION_NONE) {
session_start();
}
require_once '../controller/InventarioController.php';
/*

if (!isset($_SESSION['usuario'])) {
    header("Location: /view/loginView.php");
    exit();
}

if (!isset($data) || !is_array($data['lineas'])) {
    echo "<p>HOLAAAAAAAAAAAAAA---No hay datos para mostrar</p>";
    exit();
}
*/
?>

<!DOCTYPE html>
<html lang= "es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <meta name="description" content="CONSULTA DE INVENTARIO." >
    <meta name="author" content="Pablo Enrique Guntín Garrido">
    <link rel="stylesheet" href="../../styles.css">
    <title>INVETARIO CONSULTA</title>
    <!--<link rel="shortcut icon" href="/imagenes/logocofano.png">-->
    <!--Librerias a adjuntar para la paginación y semaforo-->
    <!--DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <!--jQuery y DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css"></script>
    <!--Script de paginación y semaforo-->
    <script src="/ApplicacionCofanoMVC/js/paginacion_inventario.js"></script>
</head>
<body>
    <?php include '../../templates/header.php'; ?>
    <main>
        <div class="contenedor-inventario">
        <h2>Inventario</h2>

        <form method="post" action="../controller/InventarioController.php" class="formulario-inventario">
            
            <label for="estado">Selecciona un estado:</label>
            <select name="estado" id="estado">
                <option value="0">--Mostrar estados--</option>
                <?php foreach ($datosSeleccion['estados'] as $estado): ?>
                            <option value="<?= $estado['id']?>" <?= ($estadoSeleccionado == $estado['id']) ? "selected" : "" ?>>
                            <?= htmlspecialchars($estado['texto']) ?>
                        </option>
                <?php endforeach; ?>
            </select>

            <label for="tipo">Selecciona un tipo:</label>
            <select name="tipo" id="tipo">
                <option value="0">--Mostrar tipos--</option>
                <?php foreach ($datosSeleccion['tipos'] as $tipo): ?>
                            <option value="<?= $tipo['id']?>" <?= ($tipoSeleccionado == $tipo['id']) ? "selected" : "" ?>>
                            <?= htmlspecialchars($tipo['texto']) ?>
                        </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Consultar</button>
        </form>
       
        <br>

        <?php if (!empty($inventarios) && is_array($inventarios)): ?>
            <div class="contenedor-tabla">
            <table border="1" class="tabla-inventario" id="tabla-resultados" class="tabla-resultados">
                <thead>  
                    <tr>
                        <th>ID inventario</th>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Usuario</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inventarios as $inv): ?>
                        <tr onclick="abrirDetalle(<?= $inv['id_inventario']; ?>)">
                            
                            <td><?php echo htmlspecialchars($inv['id_inventario']); ?></td>
                            <td><?php echo htmlspecialchars($inv['fecha']); ?></td>
                            <td><?php echo htmlspecialchars($inv['descripcion']); ?></td>
                            <td><?php echo htmlspecialchars($inv['tipo']); ?></td>
                            <td><?php echo htmlspecialchars($inv['estado']); ?></td>
                            <td><?php echo htmlspecialchars($inv['usuario']); ?></td>
                            
                        </tr>
                        <?php endforeach; ?>
                    
                </tbody>
            </table>
            </div>
            
            
        </div>
        <?php else: ?>
            <p>No hay datos para mostrar.</p>
        <?php endif; ?>
    </main>
</body>
<script>
                function abrirDetalle(id) {
                    let usuario = encodeURIComponent("<?php echo $_SESSION['usuario']; ?>"); 
                    window.location.href= '../view/DetalleInventarioView.php?id=' + id +'&usuario=' + usuario;
                }
            </script>

</html>