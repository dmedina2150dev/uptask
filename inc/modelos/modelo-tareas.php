<?php 

    $accion = $_POST['accion'];
 
    

    if ($accion === 'crear') {
        $id_proyecto = (int)$_POST['id_proyecto'];
        $tarea = $_POST['tarea'];


        // IMPORTAMOS LA CONEXION
        include '../funciones/conexion.php';

        try {
            $stmt = $conn->prepare("INSERT INTO tareas (nombre, id_proyecto) VALUES (?, ?)");
            $stmt->bind_param("si", $tarea ,$id_proyecto);
            $stmt->execute();
            if($stmt->affected_rows > 0){
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'id_tarea' => $stmt->insert_id,
                    'tipo' => $accion,
                    'tarea' => $tarea
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

    if ($accion === 'actualizar') {
        // echo json_encode($_POST);
        // IMPORTAMOS LA CONEXION
        $estado = $_POST['estado'];
        $id_tarea = (int)$_POST['id'];
        
        include '../funciones/conexion.php';

        try {
            $stmt = $conn->prepare("UPDATE tareas SET estado = ? WHERE id = ?");
            $stmt->bind_param("ii", $estado ,$id_tarea);
            $stmt->execute();
            if($stmt->affected_rows > 0){
                $respuesta = array(
                    'respuesta' => 'correcto'
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


    if ($accion === 'eliminar') {
        // echo json_encode($_POST);
        $id_tarea = (int)$_POST['id'];
        // IMPORTAMOS LA CONEXION
        include '../funciones/conexion.php';

        try {
            $stmt = $conn->prepare("DELETE FROM tareas WHERE id = ?");
            $stmt->bind_param("i", $id_tarea);
            $stmt->execute();
            if($stmt->affected_rows > 0){
                $respuesta = array(
                    'respuesta' => 'correcto'
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