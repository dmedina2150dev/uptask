<?php 
 
    // PARA COMPROBAR QUE EL USUARIO ESTE AUTENTICADO
    function usuario_autenticado(){
        if (!revisar_usuario()) {
            # si no existe la session redireccionar...
            header('Location:login.php');
            exit();
        }
    }
    // VERIFICA SI LA SESSION ESTA INICIADA
    function revisar_usuario(){
        return isset($_SESSION['nombre']); 
    }

    // permite pasar por las paginas sin loguearte a cada rato
    session_start();
    usuario_autenticado();