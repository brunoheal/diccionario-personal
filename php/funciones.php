<?php
// Se manda a iniciar sesión si no se ha hecho
function verificarSesion() {
    if (empty($_SESSION['nombreUsuario'])):       
        $url = 'iniciarSesion.php';
        redireccion($url);
    endif;
}

// Redireccionar
function redireccion($url) {
    if (!headers_sent()):
        header('Location: ' . $url);
        exit;
    
    else:
        echo '<script type="text/javascript">';
        echo 'window.location.href="' . $url . '";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0; url=' . $url . '" />';
        echo '</noscript>'; 
        exit;
    endif;
}

function filtrado($datos) {                
    $datos = trim($datos);
    $datos = stripslashes($datos); 
    $datos = htmlspecialchars($datos); 
    return $datos;
}

function verCorreo(&$correo) {
    $correo = filter_var($correo, FILTER_SANITIZE_EMAIL);
    if (filter_var($correo, FILTER_VALIDATE_EMAIL)):
        return true;
    else:
        return false;
    endif;      
}

function validarNombre($datos) {
    if (strlen($datos) >= 3 && strlen($datos) <= 50):    
        return true;
    else:
        return false;
    endif;    
}

function validarContra($datos) {
    $datos = md5($datos);
    $datos = filtrado($datos);
    return $datos;
}

// Nueva contraseña aleatoria
function nuevaClave() {
    $caracteres = 8;
    $contra = substr(md5(microtime()), 1, $caracteres);
    return $contra;
} 

// Ver hora para mostrar saludo en bienvenida
function saludo() {
    $hora = date('G');

    if ($hora > 6 && $hora < 12):
        $saludo = 'Buenos días';   
    
    elseif ($hora > 12 && $hora < 20):
        $saludo = 'Buenas tardes';
                
    else:
        $saludo = 'Buenas noches';
    
    endif;   
    return $saludo;
}
