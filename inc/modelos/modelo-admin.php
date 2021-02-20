<?php
    // con esto comprobamos que los datos vienen correctos
    //die(json_encode($_POST));

    $accion = $_POST['accion'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];


    if ($accion === 'crear') {
        // creamos los administradores
        
        //hashear passwords
        $opciones = array(
            'cost' => 12
        );
        $hash_password = password_hash($password, PASSWORD_BCRYPT, $opciones);

        // IMPORTAMOS LA CONEXION
        include '../funciones/conexion.php';

        try {
            //Realiza la consulta a la bd...
            $stmt = $conn->prepare("INSERT INTO usuarios (usuario, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $usuario, $hash_password);
            $stmt->execute();
            /*PARA DEBUGER ERROR
            $respuesta = array(
                'respuesta' => $stmt->error_list,
                'error' => $stmt->error
            );*/
            if($stmt->affected_rows > 0){
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'id_insertado' => $stmt->insert_id,
                    'tipo' => $accion
                );
            } else{
                $respuesta = array(
                    'respuesta' => "error",
                    'error' => $stmt->error,
                    'tipo' => 'error'
                );  
            }
            
            $stmt->close();// se cierra la consulta
            $conn->close(); // Se cierra la conexion
        } catch (\Exception $e) {
            //tomar la execpcion
            $respuesta = array(
                'error' => $e->getMessage()
            );
        };
        
        echo json_encode($respuesta); // se envia el resultado
    }

    if ($accion === 'login') {
        // escribir codigo para loguear a los administradores
        
        // IMPORTAMOS LA CONEXION
        include '../funciones/conexion.php';

        try {
            //Seleccionar el administrador de la base de datos
            $stmt = $conn->prepare("SELECT id, usuario, password FROM usuarios WHERE usuario = ?");
            $stmt->bind_param("s", $usuario);
            $stmt->execute();

            //loguear el usuario
            $stmt->bind_result($id_usuario, $nombre_usuario, $pass_usuario);
            $stmt->fetch();

            if($nombre_usuario){
                // el usuario existe verificar el password
                if (password_verify($password, $pass_usuario)) {
                    // iniciar la session
                    session_start();
                    $_SESSION['nombre'] = $usuario;
                    $_SESSION['id'] = $id_usuario;
                    $_SESSION['login'] = true;

                    # Login correcto...
                    $respuesta = array(
                        'respuesta' => 'correcto',
                        'nombre' => $nombre_usuario,
                        'tipo' => $accion
                    );
                } else {
                    // Login incorrecto ..Enviar error...
                    $respuesta = array(
                        'resultado' => "Password incorrecto!"
                    );
                }   
            }else{
                $respuesta = array(
                    'error' => "Usuario no existe"
                );
            }

            $stmt->close();
            $conn->close();
        }  catch (\Exception $e) {
            //tomar la execpcion
            $respuesta = array(
                'error' => $e->getMessage()
            );
        };
        
        echo json_encode($respuesta); 
    }