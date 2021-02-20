
eventListeners();

function eventListeners(params) {
  document.querySelector('#formulario').addEventListener('submit', validarRegistro);
}

function validarRegistro(e) {
  e.preventDefault();

  let usuario = document.querySelector('#usuario').value,
      password = document.querySelector('#password').value,
      tipo = document.querySelector('#tipo').value;

  if (usuario === "" || password === "") {
    // LA VALIDACION FALLO
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: 'Ambos campos son obligatorios'
      });
  } else{
    // AMBOS CAMPOS SON CORRECTOS, MANDAR A EJECUTAR AJAX
    
    // Datos que se enviaran
    let datos = new FormData();
    datos.append('usuario', usuario);
    datos.append('password', password);
    datos.append('accion', tipo);

    // crear el llamado a  ajax
    let xhr = new XMLHttpRequest();

    // Abrir la conexion
    xhr.open('POST', 'inc/modelos/modelo-admin.php', true);
    
    // retorno de datos
    xhr.onload = function(){
      
      if (this.status === 200) {
        let respuesta = JSON.parse(xhr.responseText);
        
        console.log(respuesta);
        // si la respuesta es correcta
        if (respuesta.respuesta === 'correcto') {
          // si es un usuario nuevo
          if (respuesta.tipo === "crear") {
            Swal.fire({
              icon: 'success',
              title: 'Usuario creado',
              text: 'El usuario se creó correctamente'
            });
          } else if(respuesta.tipo === 'login'){
            Swal.fire({
              icon: 'success',
              title: 'Login Correcto',
              text: 'Presiona OK para abrir el dashboard'
            })
            .then(resultado => {
              if (resultado.value) {
                window.location.href = "index.php";
              }
            });
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

    // Enviar la peticion
    xhr.send(datos);


    
  }
    
}