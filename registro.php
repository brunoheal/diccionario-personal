<?php session_start();?>
<?php include('include/reporteErrores.php'); ?>
<?php include('baseDeDatos/conexionBaseDeDatos.php');?>
<?php $controlador = 3; ?>
<?php $titulo = 'Registro'; ?>
<?php include('php/funciones.php'); ?>
<?php include('include/encabezado.php'); ?>
<?php include('include/barraNavegacion.php'); ?>
<?php include('include/mostrarImagen.php'); ?>

<?php if (isset($_POST['submit'])):
    if (!empty($_POST['nombreUsuario']) && !empty($_POST['correo']) && !empty($_POST['contra']) && !empty($_POST['contra2'])):
        // Sanea el nombre y email
        $nombreUsuario = filtrado($_POST['nombreUsuario']);
        $correo = filtrado($_POST['correo']);
        // Sanea y encripta con md5 las contraseñas
        $contra = validarContra($_POST['contra']);
        $contra2 = validarContra($_POST['contra2']);
        
        if (validarNombre($nombreUsuario) && verCorreo($correo) && ($contra == $contra2)):
            // Nombre, email y contraseña validados
            // Ahora vemos si el email ya está usado por otro usuario 
            $consulta = "SELECT correo FROM usuario WHERE correo = '" . $correo . "'";
            $resultado = mysqli_query($mysqli, $consulta);
            
            if (mysqli_num_rows($resultado) > 0):
                // Ya existe este email, por tanto no pueden haber nuevos registros con él
                $_SESSION['mensaje1'] = "Error de registro con correo electrónico o contraseña";
                $_SESSION['mensaje2'] = "Por favor, vuelva a intentarlo.";
                // Vaciamos variable y cerramos conexión
               
            else:
                // No nos devuelve ningún resultado, por lo que no existe dicho email en nuestra base de datos y podemois registrar
                $consulta2 = "INSERT INTO usuario (nombreUsuario, correo, contra) VALUES ('$nombreUsuario', '$correo', '$contra')";
                
                if (mysqli_query($mysqli, $consulta2)):
                    // La inserción ha ido bien
                    // Sacamos el ultimo id insertado para meterlo en sesión
                    $ultimoId = mysqli_insert_id($mysqli);
                    // Insertamos en sesión el nombre y el id del usuario
                    $_SESSION['nombreUsuario'] = $nombreUsuario;
                    $_SESSION['idUsuario'] = $ultimoId;
                    $_SESSION['mensaje1'] = "El registro se ha realizado con éxito";
                    $_SESSION['mensaje2'] = "Muévase por la barra de navegación.";
                    // Ver saludo
                
                else:
                    // La inserción no ha ido bien
                    $_SESSION['mensaje1'] = "No ha sido posible llevar a cabo el registro";
                    $_SESSION['mensaje2'] = "Por favor, vuelva a intentarlo.";
                endif;
            endif;        
        
        else:
            // Algún dato no cumple la verificación de registro
            $_SESSION['mensaje1'] = "No ha sido posible terminar el registro. Alguno de los datos es incorrecto";
            $_SESSION['mensaje2'] = "Por favor, verifique y vuelva a introducir los datos requeridos.";
        endif;  
    
    else:
        // No se han recibido los datos esperados
        $_SESSION['mensaje1'] = "No ha sido posible realizar el registro. Falta alguno de los datos requeridos";
        $_SESSION['mensaje2'] = "Por favor, vuelva a intentarlo.";  
    endif;
endif; ?>

<?php if (empty($_SESSION['mensaje1'])): ?>
    <h1 class="text-center">Introduzca los datos requeridos para registrarse:</h1>
    <div class="container">
        <form action="#" onsubmit="return validarFormulario();" method="post">   
            <div class="form-group">
                <label for="nombreUsuario">Nombre:</label>
                <input type="text" name="nombreUsuario" class="form-control" id="nombreUsuario">
                <div id="js_nombreUsuario"></div>
            </div>
            <div class="form-group">
                <label for="correo">Correo electrónico:</label>
                <input type="text" name="correo" class="form-control" id="correo">
                <div id="js_correo"></div>
            </div>
            <div class="form-group">
                <label for="contra">Contraseña:</label>
                <input type="password" name="contra" class="form-control" id="contra">
                <div id="js_contra"></div>
            </div>
            <div class="form-group">
                <label for="contra2">Repita contraseña:</label>
                <input type="password" name="contra2" class="form-control" id="contra2">
                <div id="js_contra2"></div>
            </div>        
            <button type="submit" name="submit" class="btn b_btn-1">Registrar</button>
        </form>
    </div>
<?php else: ?>
    <div class="row">
        <div class="col text-center">
            <h1><?= $_SESSION['mensaje1']; ?></h1>
            <p><?= $_SESSION['mensaje2']; ?></p>
            <?php unset($_SESSION['mensaje1'], $_SESSION['mensaje2']); ?>
        </div>
    </div>   
<?php endif ?>

<?php mysqli_close($mysqli); ?>
<?php include('include/pie.php'); ?>