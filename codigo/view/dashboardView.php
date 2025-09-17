<?php
/**
 * Panel de funcionalidades
 * 
 * Panel principal al que re redirige a los usuario que han sido autenticados de forma exitosa.
 * Si el usuario no ha iniciado sesion, será rederigido automaticamente a la pagina de login
 * 
 * @author Pablo Enrique Guntín Garrido <pabloenriqueguntin@icloud.com>
 * @since 2025-03-10
 * @version 1.0.0
 */
session_start();

/**
 * verifica si el usuario ha iniciado sesión. Si no, lo redirige a la pagina de login
 */
if (!isset($_SESSION['usuario'])) {
    header("Location: loginView.php");
    exit();
}
//echo "Bienvenido, " . $_SESSION['usuario'];

?>

<!DOCTYPE html>
<html lang= "es">
<head>
    <meta charset="UTF-8"> 
    <!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <meta name="description" content="Páginas a la que redirige a los usuarios que están autenticados." >
    <meta name="author" content="Pablo Enrique Guntín Garrido">
    <link rel="stylesheet" href="../styles.css">
    <title>Panel de funcionalidades</title>
</head>
<body>
        <?php include '../templates/header.php'; 
        //Arriba se define la cabecera del dashboard y abajo se define la URL base del sistema si está configurada como constante
        $base_url = BASE_URL;
        //echo("BASE_URL=" . BASE_URL . "\n");
        ?>
        <main>
            <!--<h3>Bienvenido, <?php echo $_SESSION['usuario']; ?> </h3>-->
            <!--<p>Añadir funcionalidades aquí.</p>-->
            <!-- <a href="../controller/LogoutController.php">Cerrar sesión.</a> -->
             <div class="botones-dashboard">
                <button onclick="location.href='<?php echo $base_url; ?>/lista_inventario/view/InventarioView.php'">Inventario</button>
                <button onclick="location.href='<?php echo $base_url; ?>/funcionalidadConsulta/view/viewConsulta.php'">Funcionalida2</button>
                <button onclick="location.href='<?php echo $base_url; ?>/consultabbdd/view/conssultaview.php'">Consulta TRF</button>
                <button onclick="location.href='funcionalidad4.php'">Funcionalida4</button>
                <!--<button onclick="location.href='../resultsetConsulta/view/resultsetConsultaView.php'">
                        <img src="" alt="icono X"> Funcionalidad1
                    </button>
                    <button onclick="location.href='../funcionalidadConsulta/view/viewConsulta.php'">
                        <img src="" alt="icono X"> Funcionalidad1
                    </button>
                    <button onclick="location.href='funcionalidad3.php'">
                        <img src="" alt="icono X"> Funcionalida3
                    </button>
                    <button onclick="location.href='funcionalidad4.php'">
                        <img src="" alt="icono X"> Funcionalida4
                    </button>-->

             </div>
        </main>
</body>


</html>