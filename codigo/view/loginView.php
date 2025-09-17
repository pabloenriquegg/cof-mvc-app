<?php
/**
 * Vista de formulario de inicio de sesion
 * 
 * Muestra un formularoio para que lo usuarioos puedan autenticarse.
 * Si existen errorres de autenticacion previosa, se muestran en la interfaz
 * 
 * @author Pablo Enrique Guntín Garrido <pabloenriqueguntin@icloud.com>
 * @since 2025-03-10
 */

session_start();

/**
 * Inicializa la variable de error y verifica si existe un  mensaje de error en la sesion
 * si hay un error previo lo muestra y lo elimina de la sesion
 * @var string $error Mensaje de error si la autenticación falló
 */
$error = "";
if (isset($_SESSION['error'])){
    $error = $_SESSION['error'];
    unset($_SESSION['error']); //elimina el error de la sesion después de mostrarlo
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"> 
        <!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" > -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" >
        <meta name="description" content="Páginas de identificación que muestra un formulario para autenticación." >
        <meta name="author" content="Pablo Enrique Guntín Garrido">
        <link rel="stylesheet" href="../styles.css">
        <title>Inicio de sesión</title>

    </head>

    <body>
    <?php include '../templates/header-login.php'; ?>
        <main>
            <div id="inicio_sesion">
                <h2>Iniciar sesión</h2>
                <form action="../controller/LoginController.php" method="POST" class="formulario-incio-sesion">
                    <label>Usuario:</label> 
                        <input type="text" class="text" placeholder="Introduzca el usuario" name="usuario" required>
                        <br>
                        <label>Contraseña:</label>
                        <input type="password" class="text" placeholder="Introduzca la contraseña." name="password" required>
                        <br>
                        <input type="submit" value="Entrar">
                    </form>
            </div>
        </main>
    </body>
</html>