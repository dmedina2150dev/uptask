
evenListeners()
// VARIABLES GLOBALES
let  listaProyectos = document.querySelector('ul#proyectos');


function evenListeners(){
    // Document Ready
    document.addEventListener('DOMContentLoaded', function(){
        actualizarProgreso();
    });


    //boton de crear proyecto
    if (document.querySelector('#new-proyecto')) {
        document.querySelector('#new-proyecto').addEventListener('click', nuevosProyectos);
    }
    if (document.querySelector('#new-nota')) {
        document.querySelector('#new-nota').addEventListener('click', nuevasNotas);
    }

    // boton para agregar una nueva tarea
    if (document.querySelector('.nueva-tarea')) {
        document.querySelector('.nueva-tarea').addEventListener('click', agregarTarea);    
    }

    // Botones para las opciones de las tareas
    if (document.querySelector('.listado-pendientes')) {
        document.querySelector('.listado-pendientes').addEventListener('click', accionesTareas);
    }
    
}

function nuevosProyectos(e){
    e.preventDefault();
    console.log(e);
    // crear un input para el nuevo elemento
    let nuevoProyecto = document.createElement('li');
    nuevoProyecto.innerHTML = '<input type="text" id="nuevo-proyecto" >';
    listaProyectos.appendChild(nuevoProyecto);
    
    // seleccionar el input por el id
    let inputNuevoProyecto = document.querySelector('#nuevo-proyecto');
    let inputIdUsuario = document.querySelector('#id-usuario');
    
    // al presionar enter crear el nuevo proyecto
    inputNuevoProyecto.addEventListener('keypress', function(e){
        let tecla = e.which || e.keyCode;
        
        /** 
         * console.log(e);  para ver las teclas que presiono
         * enevntos del enter 
         * key: "Enter"
         * keyCode: 13
         * which: 13
         * 
         * **/
        if (tecla === 13) {
            console.log("Acabas de presionar enter");
            guardarProyectoDB(inputNuevoProyecto.value, inputIdUsuario.value);
            listaProyectos.removeChild(nuevoProyecto);
        }
    });
}
function nuevasNotas(e){
    e.preventDefault();
    console.log(e);
    // crear un input para el nuevo elemento
    let nuevaNota = document.createElement('li');
    nuevaNota.innerHTML = '<input type="text" id="nueva-nota" >';
    document.querySelector('.agregado-notas').style.display = 'grid';
    listaProyectos.appendChild(nuevaNota);
    
    // seleccionar el input por el id
    let inputNuevoNota = document.querySelector('#nueva-nota');
    let inputTextoNota = document.querySelector('#texto-nota');
    let inputBlockCodeNota = document.querySelector('#block-code');
    let inputIdUsuario = document.querySelector('#id-usuario');


    // al presionar enter crear el nuevo proyecto
    inputBlockCodeNota.addEventListener('keypress', function(e){
        let tecla = e.which || e.keyCode;
        
        if (tecla === 13) {
            // console.log("Acabas de presionar enter");
            guardarNotaDB(inputNuevoNota.value, inputIdUsuario.value, inputTextoNota.value, inputBlockCodeNota.value);
            listaProyectos.removeChild(nuevaNota);
        }
    });
}

function guardarProyectoDB(nombreProyecto, idUsuario){
    // crear el llamado a ajax
    let xhr = new XMLHttpRequest();
    let id_usuario = parseInt(idUsuario);
    console.log(typeof(id_usuario));
    // enviar datos por formData
    let datos = new FormData();
    datos.append('proyecto', nombreProyecto);
    datos.append('id_usuario', id_usuario);
    datos.append('accion', 'crear');
    
    // abrir la conexion
    xhr.open('POST', 'inc/modelos/modelo-proyecto.php', true);

    // la carga
    xhr.onload = function(){
        if (this.status === 200) {
            console.log(xhr.responseText);
            let respuesta = JSON.parse(xhr.responseText),
                proyecto = respuesta.nombre_proyecto,
                id_proyecto = respuesta.id_proyecto,
                tipo = respuesta.tipo
                resultado = respuesta.respuesta;

            if (resultado === 'correcto') {
                if (tipo === 'crear') {
                    // se creo un proyecto
                    // inyectar el html
                    let nuevoProyecto = document.createElement('li');
                    nuevoProyecto.innerHTML = `
                        <a href="index.php?id_proyecto=${id_proyecto}" id="proyecto:${id_proyecto}">
                            ${proyecto}
                        </a>
                    `;
                    listaProyectos.appendChild(nuevoProyecto);

                    Swal.fire({
                      icon: 'success',
                      title: 'Proyecto Creado',
                      text: 'El proyecto: ' + proyecto + ' se creó correctamente'
                    })
                    .then(resultado => {
                      if (resultado.value) {
                        // redireccionar al proyecto
                        window.location.href = 'index.php?id_respuesta='+id_proyecto;
                      }
                    });
                } else {
                    // se actualizo o  se borro
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error'
                  });
            }
            
            
        }
    }

    // Enviar el request
    xhr.send(datos);
};

function guardarNotaDB(nombreNota, idUsuario, textoNota, blockCodeNota){
    // crear el llamado a ajax
    let xhr = new XMLHttpRequest();
    let id_usuario = parseInt(idUsuario);
    
    // enviar datos por formData
    let datos = new FormData();
    datos.append('titulo_nota', nombreNota);
    datos.append('texto_nota', textoNota);
    datos.append('block_nota', blockCodeNota);
    datos.append('id_usuario', id_usuario);
    datos.append('accion', 'crear');
    
    // abrir la conexion
    xhr.open('POST', 'inc/modelos/modelo-notas.php', true);

    // la carga
    xhr.onload = function(){
        if (this.status === 200) {
            console.log(xhr.responseText);
            let respuesta = JSON.parse(xhr.responseText),
                titulo_nota = respuesta.titulo_nota,
                id_nota = respuesta.id_nota,
                texto = respuesta.texto_nota,
                block_nota = respuesta.block_nota,
                tipo = respuesta.tipo,
                resultado = respuesta.respuesta;

            if (resultado === 'correcto') {
                if (tipo === 'crear') {
                    // se creo un proyecto
                    // inyectar el html
                    let nuevaNota = document.createElement('li');
                    nuevaNota.innerHTML = `
                        <a href="notas.php?id_nota=${id_nota}" id="nota:${id_nota}">
                            ${titulo_nota}
                        </a>
                    `;
                    listaProyectos.appendChild(nuevaNota);

                    Swal.fire({
                      icon: 'success',
                      title: 'Proyecto Creado',
                      text: 'La nota: ' + titulo_nota + ' se creó correctamente'
                    })
                    .then(resultado => {
                      if (resultado.value) {
                        // redireccionar al proyecto
                        window.location.href = 'notas.php?id_respuesta='+id_nota;
                      }
                    });
                } else {
                    // se actualizo o  se borro
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error'
                  });
            }
            
            
        }
    }

    // Enviar el request
    xhr.send(datos);
};


// AGREGAR UNA TAREA AL PROYECTO ACTUAL

function agregarTarea(e) {
    e.preventDefault();
    let nombreTarea = document.querySelector('.nombre-tarea').value;

    // validar que no este vacio
    if (nombreTarea === '') {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'La tarea no puede estar vacia'

        });
    } else {
         // crear el llamado a ajax
        let xhr = new XMLHttpRequest();

        // enviar datos por formData
        let datos = new FormData();
        datos.append('tarea', nombreTarea);
        datos.append('accion', 'crear');
        datos.append('id_proyecto', document.querySelector('#id_proyecto').value);
        
        // abrir la conexion
        xhr.open('POST', 'inc/modelos/modelo-tareas.php', true);

        // la carga
        xhr.onload = function(){
            if(this.status === 200){
                console.log(xhr.responseText);
                let respuesta = JSON.parse(xhr.responseText);
                let resultado = respuesta.respuesta,
                    tarea = respuesta.tarea,
                    id_insertado = respuesta.id_tarea,
                    tipo = respuesta.tipo;

                if (resultado === 'correcto') {
                    if (tipo === 'crear') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Tarea Creada',
                            text: 'Se creo la siguiente tarea: ' +tarea
                        });

                        //seleccionar el parrafo de lista vacia
                        let parrafoListaVacia = document.querySelectorAll('.lista-vacia');
                        if (parrafoListaVacia.length > 0) {
                            document.querySelector('.lista-vacia').remove();
                        }

                        // CREARLO EN EL TEMPLATE
                        let nuevaTarea = document.createElement('li');

                        //agregamos el ID
                        nuevaTarea.id = 'tarea:'+id_insertado;

                        // agregamos la clase
                        nuevaTarea.classList.add('tarea');

                        // construir el block html
                        nuevaTarea.innerHTML = `
                            <p>${tarea}</p>
                            <div class="acciones">
                                <i class="far fa-check-circle"></i>
                                <i class="fas fa-trash"></i>
                            </div>

                        `;

                        // insertar en el HTML
                        let listaPendientes = document.querySelector('.listado-pendientes ul');
                        listaPendientes.appendChild(nuevaTarea);

                        // limpiar el formulario
                        document.querySelector('.agregar-tarea').reset();

                        // actualizar el progreso
                        actualizarProgreso();
                    }
                } else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un error'
                    });
                }
            }
        }

        xhr.send(datos);
    }
}

// cambia el estado de las tareas o las elimina
function accionesTareas(e){
    e.preventDefault();
    // console.log(e.target);
    if (e.target.classList.contains('fa-check-circle')) {
        // console.log("Hiciste click en el circulo");
        if (e.target.classList.contains('completo')) {
            e.target.classList.remove('completo');
            cambiarEstadoTarea(e.target, 0);
        } else{
            e.target.classList.add('completo');
            cambiarEstadoTarea(e.target, 1);
        }
    }

    if (e.target.classList.contains('fa-trash')) {
        Swal.fire({
            title: 'Estas Seguro(a)?',
            text: "Esta acción no se puede deshacer!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, borrar!'
          }).then((result) => {
            if (result.value) {
              let tareaEliminar = e.target.parentElement.parentElement;
                // borrar de la base de datos
                eliminarTareaDB(tareaEliminar);
                // borrar del html
                tareaEliminar.remove();

                Swal.fire(
                'Elimidado!',
                'La tarea fue eliminada',
                'success'
              )
            }
          });
    }
}

// completar o descompletar una tarea

function cambiarEstadoTarea(tarea, estado){
    let idTarea = tarea.parentElement.parentElement.id.split(':');
    console.log(idTarea[1]);

    // Crear el llamado a ajax
    let xhr = new XMLHttpRequest();

    // cargar datos
    let datos = new FormData();
    datos.append('id', idTarea[1]);
    datos.append('accion', 'actualizar');
    datos.append('estado', estado);
    // abrir la conexion
    xhr.open('POST', 'inc/modelos/modelo-tareas.php', true);

    // cargar 
    xhr.onload = function(){
        if (this.status === 200) {
            console.log(xhr.responseText);
            actualizarProgreso();
        }
    }

    // enviar informacion
    xhr.send(datos);
}

// funcion para eliminar la tarea de la base de datos
function eliminarTareaDB(tarea){
    
    let idTareaEliminar = tarea.id.split(':');
    // Crear el llamado a ajax
    let xhr = new XMLHttpRequest();

    // cargar datos
    let datos = new FormData();
    datos.append('id', idTareaEliminar[1]);
    datos.append('accion', 'eliminar');
    // abrir la conexion
    xhr.open('POST', 'inc/modelos/modelo-tareas.php', true);

    // cargar 
    xhr.onload = function(){
        if (this.status === 200) {
            // comprobar que no hay tareas y colocar el texto no ay tareas
            let listaTareasPendientes = document.querySelectorAll('li.tarea');
            console.log(listaTareasPendientes);
            if (listaTareasPendientes.length == 0) {
                document.querySelector('.listado-pendientes ul').innerHTML = "<h2 class='lista-vacia'> NO hay tareas para este proyecto </h2>";
            }
            // actualizar el progreso
            actualizarProgreso();
        }
    }

    // enviar informacion
    xhr.send(datos);
}

// actualiza el avance del proyecto
function actualizarProgreso(){
    // obtener todas las tareas
    const tareas = document.querySelectorAll('.tarea');
    
    // obtener todas las tareas
    let tareasCompletas = document.querySelectorAll('i.completo');
    
    // determintar el avance
    const avance = Math.round( (tareasCompletas.length / tareas.length) * 100);

    // asignar el avance a la barra
    if (document.querySelector('#porcentaje')) {
        const porcentaje = document.querySelector('#porcentaje');
        porcentaje.style.width = avance+'%';        
    }


}