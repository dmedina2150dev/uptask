<?php $pagina = obternerPaginaActual(); ?>
<aside class="contenedor-proyectos">
    <div class="panel crear-proyecto">
        <?php if($pagina == 'index'): ?>
            <a href="#" class="boton" id="new-proyecto">Nuevo Proyecto <i class="fas fa-plus"></i> </a>
        <?php else:  ?>
            <a href="#" class="boton" id="new-nota">Nueva Nota <i class="fas fa-plus"></i> </a>
        <?php endif; ?>
    </div>

    <div class="panel lista-proyectos">
        <?php if($pagina == 'index'): ?>
            <h2>Proyectos</h2>
        <?php else:  ?>
            <h2>Notas</h2>
        <?php endif; ?>
        
        <ul id="proyectos">
            <?php 
                if ($pagina === 'index') {
                    $proyectos = obtenerProyectos($id_user);

                    if($proyectos): ?>
                        <?php foreach($proyectos as $proyecto): ?>
                            <li>
                                <a href="index.php?id_proyecto=<?php echo $proyecto['id']; ?>" id="proyecto:<?php echo $proyecto['id']; ?>">
                                    <?php echo $proyecto['nombre']; ?>
                                </a>
                            </li>

                        <?php endforeach; ?>
                    <?php endif; ?>
        <?php   } else{
                    $tareas = obtenerTareas($id_user);

                    if($tareas): ?>
                        <?php foreach($tareas as $tarea): ?>
                            <li>
                                <a href="notas.php?id_tarea=<?php echo $tarea['id']; ?>" id="tarea:<?php echo $tarea['id']; ?>">
                                    <?php echo $tarea['titulo_nota']; ?>
                                </a>
                            </li>

                        <?php endforeach; ?>
                    <?php endif; ?>
        <?php   } ?>
            
            <li style="display: none"><input type="text" id="id-usuario" value="<?php echo $id_user; ?>"></li>
        </ul>
    </div>
</aside>