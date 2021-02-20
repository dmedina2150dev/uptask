<?php
  include 'inc/funciones/sesiones.php';
  include 'inc/funciones/funciones.php';
  include 'inc/templates/header.php';

  //echo "<pre>";
  //var_dump($_SESSION);
  //echo "</pre>";

  $id_user = $_SESSION['id'];
  // OBTENER EL ID DE LA URL

  if(isset($_GET['id_tarea'])){
    $id_tarea = $_GET['id_tarea'];
  }else{
    $id_tarea = NULL;
  }

?>


<?php  include 'inc/templates/barra.php'; ?>

<div class="contenedor">
    <?php  include 'inc/templates/sidebar.php'; ?>
      <main class="contenido-principal">
          <div class="agregado-notas">
              <label for="texto-nota">Escribe el texto de tu nota</label>
              <textarea name="texto-nota" id="texto-nota"></textarea>
              <label for="block-code">Escribe el codigo</label>
              <textarea name="block-code" id="block-code"></textarea>
            <hr>
              <span>Presione ENter para guardar</span>
            <hr>
          </div>

          

          <div class="tareas">
            <?php $tareas = obtenerTareas($id_user); ?>

            <?php 
              if ($tareas->num_rows > 0): 
                
                foreach ($tareas as $tarea): ?>
                  <div class="tarea">
                      <h3><?php echo $tarea["titulo_nota"]; ?></h3>
                      <p><?php echo $tarea["texto_nota"]; ?></p>
                      
                      <code>
                        <?php echo $tarea["bloque_nota"]; ?>
                      </code>
                      
                  </div>
                  
            <?php
                endforeach;
              endif;
            ?>

          </div>
      </main>
</div>

<?php 
  include 'inc/templates/footer.php';
?>