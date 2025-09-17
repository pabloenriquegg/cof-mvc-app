<?php
/**
 * Controlador de autenticacion de usuarios
 * 
 * Procesa el formulario de inicio de sesuión, valida los datos introducidos
 * y gestiona la redirección en función del resultado de autenticación.
 * 
 * @author Pablo Enrique Guntín Garrido <pabloenriqueguntin@icloud.com>
 * @since 2025-03-10
 * 
 */
session_start();
include '../model/user.php';
require_once '../model/conexion.php';

/**
 * Verifica si la solicitud es de tipo POST antes de procesar el formulario
 */
if ($_SERVER["REQUEST_METHOD"] == "POST"){
   // obtener y limpiar los datos enviados desde le formulario
    $usuario =  trim($_POST['usuario']);
    $password = trim($_POST['password']);

    /**
     * Si los campos están vacios, se muestra un mensaje de error
     * y se redirige al usaurio al formulario de invicio de sesion otra vez
     */
    if (empty($usuario) || empty($password)){
        echo "Campos necesarios.";
        header("Location: ../view/loginView.php");
        exit();
    }


    /**
     * Instancia el modelo usuarioo y valida las credenciales introducidas.
     * 
     * @var User $userModel Intancia de la clase User.
     * @var array $result Resultado de la validacion que contiene resulta (1 o 0) y el mensaje
     */

    $userModel = new User(Conexion::getConexion());
    $result = $userModel->validarUser($usuario, $password);

    /**
     * Si la autenticacion es exitosa (1), se guarda el usaurio y se redirige  al panel de control
     * Por lo controario, si falla, se guarda el mensaje de error en la sesion y se redirige a la pantalla de logueo.
     */
    if ($result['result'] == 1) {
        //Exito de login
        $_SESSION['usuario'] = $usuario;
        header("Location: ../view/dashboardView.php");
        exit();
    } 
    else{
        $_SESSION['error'] = "Error de autenticación: " . $result['mensaje'];
        header("Location: ../view/loginView.php");
        exit();
    }
}

?>