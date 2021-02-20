<?php 
    // obtiene la pagina actual en que se encuentra
    function obternerPaginaActual(){
        $archivo = basename($_SERVER['PHP_SELF']);
        $pagina = str_replace(".php", "", $archivo);
        return $pagina;
    }
    obternerPaginaActual();

    /** CONSULTAS A LA BD */

    // obtener todos los proyectos
    function obtenerProyectos($id = null){
        include 'conexion.php';
        try {

            return $conn->query("SELECT id, nombre FROM proyectos WHERE id_usuario = {$id}");
        } catch (\Exception $e) {
            echo "Error! : " . $e->getMessage();
            return false;
        }
    }

    // Obtener el nombre del proyecto
    function obtenterNombreProyecto($id = null){
        include 'conexion.php';
        try {

        return $conn->query("SELECT nombre FROM proyectos WHERE id = {$id}");
        } catch (\Exception $e) {
            echo "Error! : " . $e->getMessage();
            return false;
        }
    }

     // Obtener las clases del proyecto
     function obtenterTareasProyectos($id = null){
        include 'conexion.php';
        try {

        return $conn->query("SELECT id, nombre, estado FROM tareas WHERE id_proyecto = {$id}");
        } catch (\Exception $e) {
            echo "Error! : " . $e->getMessage();
            return false;
        }
    }


    // Obtener las notas

     function obtenerTareas($id = null){
        include 'conexion.php';
        try {

            return $conn->query("SELECT id, titulo_nota, texto_nota, bloque_nota FROM notas WHERE id_usuario = {$id}");
        } catch (\Exception $e) {
            echo "Error! : " . $e->getMessage();
            return false;
        }
    }



