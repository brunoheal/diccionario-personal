function validarRegistro() {
    nombreUsuario = document.getElementById('nombreUsuario').value;
    correo = document.getElementById('correo').value;
    contra = document.getElementById('contra').value;
    contra2 = document.getElementById('contra2').value;

    if (validarNombre(nombreUsuario)) {
        document.getElementById('js_nombreUsuario').style.color = "red";
        document.getElementById('js_nombreUsuario').innerHTML = "Tu nombre tiene que tener entre 3 y 50 caracteres.";
        return false;
    }

    if (validarCorreo(correo)) {
        document.getElementById('js_correo').style.color = "red";
        document.getElementById('js_correo').innerHTML = "Revisa que el correo electrónico sea correcto.";
        return false;
    }

    if (validarContra(contra)) {
        document.getElementById('js_contra').style.color = "red";
        document.getElementById('js_contra').innerHTML = "Tu contraseña tiene que tener entre 4 y 20 caracteres.";
        return false;
    }

    if (validarContra(contra2)) {
        document.getElementById('js_contra2').style.color = "red";
        document.getElementById('js_contra2').innerHTML = "Tu contraseña tiene que tener entre 4 y 20 caracteres.";
        return false;
    }

    if (contra != contra2) {
        document.getElementById('js_contra').style.color = "red";
        document.getElementById('js_contra').innerHTML = "Las dos contraseñas tienen que ser iguales.";
        document.getElementById('js_contra2').style.color = "red";
        document.getElementById('js_contra2').innerHTML = "Las dos contraseñas tienen que ser iguales.";
        return false;
    }

    return true;
} 

function validarNuevaContra() {
    nombreUsuario = document.getElementById('nombreUsuario').value;
    correo = document.getElementById('correo').value;

        if (validarNombre(nombreUsuario)) {
            document.getElementById('js_nombreUsuario').style.color = "red";
            document.getElementById('js_nombreUsuario').innerHTML = "Tu nombre tiene que tener entre 3 y 50 caracteres.";
            return false;
        }

        if (validarCorreo(correo)) {
            document.getElementById('js_correo').style.color = "red";
            document.getElementById('js_correo').innerHTML = "Revisa que el correo electrónico sea correcto.";
            return false;
        }
    
    return true;

}

function validarIniciarSesion() {
    nombreUsuario = document.getElementById('nombreUsuario').value;
    contra = document.getElementById('contra').value;

    if (validarContra(contra)) {
        document.getElementById('js_contra').style.color = "red";
        document.getElementById('js_contra').innerHTML = "Tu contraseña tiene que tener entre 4 y 20 caracteres.";
        return false;
    }
    
    if (validarNombre(nombreUsuario)) {
        document.getElementById('js_nombreUsuario').style.color = "red";
        document.getElementById('js_nombreUsuario').innerHTML = "Tu nombre tiene que tener entre 3 y 50 caracteres.";
        return false;
    }

    return true;
}

function validarNombre(data) {
    if (data.length == 0 || data == null || /^\s+$/.test(data) || data.length < 3 || data.length > 50) {
        return true;
    }
}

function validarContra(data) {
    if (data.length == 0 || data == null || /^\s+$/.test(data) || data.length < 4 || data.length > 20) {
        return true;
    }
}

function validarCorreo(data) {
    if (data.length == 0 || data == null || /^\s+$/.test(data) || !(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(data))) {
        return true;
    }
}

// Popover se activa si el usuario no ha creado grupos
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
  });