<?php
  include 'inc/funciones/sesiones.php';
  include 'inc/funciones/funciones.php';
  include 'inc/templates/header.php';

  //echo "<pre>";
  //var_dump($_SESSION);
  //echo "</pre>";

  $id_user = $_SESSION['id'];
  // OBTENER EL ID DE LA URL

  if(isset($_GET['id_proyecto'])){
    $id_proyecto = $_GET['id_proyecto'];
  }else{
    $id_proyecto = NULL;
  }

?>


<?php  include 'inc/templates/barra.php'; ?>

<div class="contenedor">
  <?php  include 'inc/templates/sidebar.php'; ?>  

  <main class="contenido-principal">
        <?php 
            if ($id_proyecto === NULL) {
              $proyecto = NULL;
            }else{
              $proyecto = obtenterNombreProyecto($id_proyecto);
            }
            

            if($proyecto): ?>
               <h1>Proyecto Actual:
                    <?php foreach($proyecto as $nombre): ?>
                        <span><?php echo $nombre['nombre']; ?></span>
                    <?php endforeach;  ?>    
                </h1>

                <form action="#" class="agregar-tarea">
                    <div class="campo">
                        <label for="tarea">Tarea:</label>
                        <input type="text" placeholder="Nombre Tarea" class="nombre-tarea"> 
                    </div>
                    <div class="campo enviar">
                        <input type="hidden" id="id_proyecto" value="<?php echo $id_proyecto; ?>">
                        <input type="submit" class="boton nueva-tarea" value="Agregar">
                    </div>
                </form>
            <?php 
                else: 
                    echo "<h2> Selecciona un proyecto de la barra </h2>";
                endif;
            ?>


      <h2>Listado de tareas:</h2>

      <div class="listado-pendientes">
          <ul>
            <?php  
                // obtener tareas del proyecto seleccionado
                if ($id_proyecto === NULL) {
                    $tareas = array();
                    echo "<h2 class='lista-vacia'> NO hay tareas disponibles </h2>";
                }else{
                  $tareas = obtenterTareasProyectos($id_proyecto);
                  if ($tareas->num_rows > 0 ) {
                      // si hay tareas
                      foreach($tareas as $tarea): ?>
                          <li id="tarea:<?php echo $tarea['id']; ?>" class="tarea">
                          <p><?php echo $tarea['nombre']; ?></p>
                              <div class="acciones">
                                  <i class="far fa-check-circle <?php echo ($tarea['estado']) === '1' ? 'completo' : '' ?>"></i>
                                  <i class="fas fa-trash"></i>
                              </div>
                          </li> 
                  <?php endforeach;
                  } else{
                      // si no hay tareas
                      echo "<h2 class='lista-vacia'> NO hay tareas para este proyecto </h2>";
                  }
                }
                
            ?> 
          </ul>
      </div>
      <div class="avance">
            <h2>Avance del proyecto:</h2>
            <div id="barra-avance" class="barra-avance">
                <div class="porcentaje" id="porcentaje"></div>
            </div>
      </div>
  </main>
</div><!--.contenedor-->

<?php 
  include 'inc/templates/footer.php';
?>