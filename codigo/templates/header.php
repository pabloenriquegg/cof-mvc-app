<?php
/**
 * Header para todas las vistas tras haberse autenticado correctamente
 * 
 * @author Pablo Enrique Guntín Garrido <pabloenriqueguntin@icloud.com>
 * @since 2025-03-10
 */
define('BASE_URL', 'http://localhost/ApplicacionCofanoMVC');
?>
<header class="main-header">
   
    <nav class="menu">
    <h3>Inicio de sesión, <?php echo $_SESSION['usuario']; ?> </h3>
    <div class="banner">
        <!--<h1>COFANO</h1> -->
        <!--<img src="/imagenes/logocofano.png" alt="logo cofano"> -->
        <img src="<?php echo '/ApplicacionCofanoMVC/imagenes/logocofano.png';?>">        
    </div>
    <?php 
        $base_url = BASE_URL;
        
        ?>
        <ul>
            <li><a href="<?php echo $base_url; ?>/view/dashboardView.php">Inicio</a></li>
            <li class="dropdown">
                <a href="#" onclick="toggleDropdown(event)">☰ Menú</a>
                <ul class="dropdown-content">
                    <li><a href="<?php echo $base_url; ?>/lista_inventario/view/InventarioView.php">Inventario</a></li>
                    <li><a href="<?php echo $base_url; ?>/funcionalidadConsulta/view/viewConsulta.php">Funcionalida2</a></li>
                    <li><a href="/ApplicacionCofanoMVC/consultabbdd/view/conssultaview.php">Consulta TRF</a></li>
                    <li><a href="../view/funcionalidad4">Funcionalida4</a></li>
                    <li><a href="<?php echo $base_url; ?>/controller/LogoutController.php">Salir</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</header>

