<?php
/**
 * Cierre de sesion
 * 
 * Destrulle la sesion del uisuario y elimina las cookies de sesion
 * antes de redirigir al usuario a la pagina de inciio de sesion
 * 
 * @author Pablo Enrique Guntín Garrido <pabloenriqueguntin@icloud.com>
 * @since 2025-03-10
 * @version 1.0.0
 * 
 */
session_start();

/**
 * Reestablece el array de la sesio  oara ekiminar todas las variables almacenadas
 */
$_SESSIONB = array();
//Verifica si las cookies de sesion están activas y las elimina
if (ini_get("session.use_cookies")){
    $params = session_get_cookie_params();

    //Se establece una cookie de sesion caducada para forzar su eliminacion
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"], 
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}
/** 
 * Destruye ñla sesion 
 */
session_destroy();

/**
 * Redirige al usaurio a la pagina de inicio de sesion
 */
header("Location: ../view/loginView.php");
exit();

?>