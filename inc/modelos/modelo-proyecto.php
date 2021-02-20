<?php

    $accion = $_POST['accion'];
    $proyecto = $_POST['proyecto'];
    

    if ($accion === 'crear') {
        $id_usuario = (int)$_POST['id_usuario'];
        // IMPORTAMOS LA CONEXION
        include '../funciones/conexion.php';

        try {
            $stmt = $conn->prepare("INSERT INTO proyectos (nombre, id_usuario) VALUES (?, ?)");
            $stmt->bind_param("si", $proyecto, $id_usuario);
            $stmt->execute();
            if($stmt->affected_rows > 0){
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'id_proyecto' => $stmt->insert_id,
                    'tipo' => $accion,
                    'nombre_proyecto' => $proyecto
                );
            }else{
                $respuesta = array(
                    'respuesta' => "error",
                    'error' => $stmt->error,
                    'tipo' => 'error'
                );
            }
            $stmt->close();
            $conn->close();
        } catch (\Exception $e) {
            //tomar la execpcion
            $respuesta = array(
                'error' => $e->getMessage()
            );
        };

        echo json_encode($respuesta); 
    }

?>