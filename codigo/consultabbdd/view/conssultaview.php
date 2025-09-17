<?php
//vista del resultset

if (session_status() === PHP_SESSION_NONE) {
session_start();
}
require_once '../controller/consultacontroller.php';
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
    <meta name="description" content="Páginas que muestra la información TRF." >
    <meta name="author" content="Pablo Enrique Guntín Garrido">
    <link rel="stylesheet" href="../../styles.css">
    <title>Información de la tabla TRF</title>
    <!--Librerias a adjuntar para la paginación y semaforo-->
    <!--DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <!--jQuery y DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css"></script>
    <!--Script de paginación y semaforo-->
    <script src="/ApplicacionCofanoMVC/js/paginacion.js"></script>
    <script src="/ApplicacionCofanoMVC/js/semaforo.js"></script>



</head>
<body>
        <?php include '../../templates/header.php'; ?>
        <main>
            <h2>Información TRF</h2>
            <form method="post" action="../controller/consultacontroller.php" class="formulario-consulta">
                <div class="formulario-fila">
                <label form="codigoLaboratorio">Código del laboratorio:</label>
                <input type="text" id="codigoLaboratorio" placeholder="Ejemplo: STD"name="codigoLaboratorio" require>
                <label form="fechaInicio">Fecha de inicio:</label>
                <input type="date" id="fechaInicio"  name="fechaInicio" require>
                <label form="fechaFin">Fecha final:</label>
                <input type="date" id="fechaFin" name="fechaFin" require>
                <button type="submit">Consultar</button>
                </div>
            </form>




            <p><?php echo htmlspecialchars($data['mensaje'] ?? ''); ?></p>
            <?php if (!empty($data['lineas'])): ?>


           <button class="procesar-btn">Procesar</button> 
            <table class="tabla-resultados" id="tabla-resultados" class="display">
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Número de transfer</th>
                        <th>CIF distribuidor</th>
                        <th>CIF clientes</th>
                        <th>Código</th>
                        <th>Descripción artículo</th>
                        <th>Cantidad</th>
                        <th>Cantiada real</th>
                        <th>Guardar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['lineas'] as $linea): ?> 
                        <tr>
                            <td class="semaforo">🔴</td>
                            <td><?php echo htmlspecialchars($linea['numeroTransfer']); ?></td>
                            <td><?php echo htmlspecialchars($linea['cifDistribuidor']); ?></td>
                            <td><?php echo htmlspecialchars($linea['cifCliente']); ?></td>
                            <td><?php echo htmlspecialchars($linea['codigoDesconocido']); ?></td>
                            <td><?php echo htmlspecialchars($linea['descripcionArticulo']); ?></td>
                            <td><?php echo htmlspecialchars($linea['cantidad']); ?></td>
                            <td>
                                <input type="number" class="editCantidadReal" value="<?php echo htmlspecialchars($linea['cantidad']); ?>">
                            </td>
                            <td>
                                <button class="guardar-btn" disabled>Guardar</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6">No hay datos disponibles</td></tr>
                        <?php endif; ?>
                </tbody>
            </table>
        </main>
        
    </body>
</html>
