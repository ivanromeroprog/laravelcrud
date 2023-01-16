import './bootstrap';
import '../sass/app.scss'

//Funciones globales
window.AskDelete = function (texto, callBackF, titulo = 'Eliminar') {
    Swal.fire({
      title: titulo,
      text: texto,
      //icon: 'warning',
      focusCancel: true,
      showCancelButton: true,
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Eliminar',
      cancelButtonText: 'Cancelar',
      showClass: {
        popup: 'animate__animated animate__fadeInDown animate__faster'
      },
      hideClass: {
        popup: 'animate__animated animate__fadeOutUp animate__faster'
      }
    }).then((result) => {callBackF(result)})
  }
  
  window.AskYesNo= function (texto, callBackF, titulo = 'Eliminar') {
    Swal.fire({
      title: titulo,
      text: texto,
      //icon: 'warning',
      focusCancel: true,
      showCancelButton: true,
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Sí',
      cancelButtonText: 'No',
      showClass: {
        popup: 'animate__animated animate__fadeInDown animate__faster'
      },
      hideClass: {
        popup: 'animate__animated animate__fadeOutUp animate__faster'
      }
    }).then((result) => {callBackF(result)})
  }
  
  window.Alert = function (texto, titulo = 'Atención') {
    Swal.fire({
      title: titulo,
      text: texto,
      //icon: 'warning',
      confirmButtonColor: '#6c757d',
      confirmButtonText: 'Aceptar',
      showClass: {
        popup: 'animate__animated animate__fadeInDown animate__faster'
      },
      hideClass: {
        popup: 'animate__animated animate__fadeOutUp animate__faster'
      }
    });
  }
  
 window.del = (e) => {
        window.AskDelete(
            "¿Quiere eliminar este elemento?",
            (result) => {
                if (result.isConfirmed) {
                    e.form.submit();
                }
            }
        )
    }