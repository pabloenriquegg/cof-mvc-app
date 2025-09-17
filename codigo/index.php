<?php
/**
 * Archivo de entrada, en caso de que el usuario haya inicidadop sesión lo redirige  a dashboard sino al formulario del login.
 * 
 * @author Pablo Enrique Guntín Garrido <pabloenriqueguntin@icloud.com>
 * @since 2025-03-10
 */

session_start();
if (!isset($_SESSION['usuario'])){
    header("Location: view/loginView.php");
    exit();
} else{
    header("Location: view/dashboardView.php");
    exit();
}


?>