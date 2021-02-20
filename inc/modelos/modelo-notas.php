<?php

    $accion = $_POST['accion'];
    $titulo = $_POST['titulo_nota'];
    $texto = $_POST['texto_nota'];
    $bloque = $_POST['block_nota'];

    if ($accion === 'crear') {
        $id_usuario = (int)$_POST['id_usuario'];
        // IMPORTAMOS LA CONEXION
        include '../funciones/conexion.php';

        try {
            $stmt = $conn->prepare("INSERT INTO notas (id_usuario, titulo_nota, texto_nota, bloque_nota) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $id_usuario, $titulo, $texto, $bloque);
            $stmt->execute();
            if($stmt->affected_rows > 0){
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'id_nota' => $stmt->insert_id,
                    'tipo' => $accion,
                    'titulo_nota' => $titulo,
                    'texto_nota' => $texto,
                    'block_nota' => $bloque
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