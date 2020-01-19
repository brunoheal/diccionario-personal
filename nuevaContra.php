<?php session_start();?>
<?php include('include/reporteErrores.php'); ?>
<?php include('baseDeDatos/conexionBaseDeDatos.php');?>
<?php $controlador = 1; ?>
<?php $titulo = 'Iniciar Sesión'; ?>
<?php include('php/funciones.php'); ?>
<?php include('include/encabezado.php'); ?>
<?php include('include/barraNavegacion.php'); ?>
<?php include('include/mostrarImagen.php'); ?>

<?php if (isset($_POST['submit'])):
    if (!empty($_POST['nombreUsuario']) && !empty($_POST['correo'])):
        // Nombre y email existen y están saneados
        $nombreUsuario = filtrado($_POST['nombreUsuario']);
        $correo = filtrado($_POST['correo']);
        if (validarNombre($nombreUsuario) && verCorreo($correo)):
            // Están validados
            $consulta = "SELECT nombreUsuario, correo FROM usuario WHERE nombreUsuario = '" . $nombreUsuario . "' AND correo = '" . $correo . "'";
            $resultado = mysqli_query($mysqli, $consulta);
           
            if (mysqli_num_rows($resultado) > 0):
                // Corresponden a un usuario que está en la base de datos
                // Se crea nueva contraseña en md5
                $contra = nuevaClave();
                include('include/enviarNuevaContra.php');  
            
            else:
                // No corresponden estos datos con ningún usuario
                $_SESSION['mensaje1'] = "Nombre o correo electrónico incorrectos"; 
                $_SESSION['mensaje2'] = "Por favor, revise los datos y vuelva a intentarlo.";
            endif;
        
        else:
            // No han pasado la validación
            $_SESSION['mensaje1'] = "Nombre o correo electrónico incorrectos";
            $_SESSION['mensaje2'] = "Por favor, revisa los datos y vuelve a intentarlo";
        endif;
    
    else:
        // No han introducido algún campo o no han llegado los datos
        $_SESSION['mensaje1'] = "Algún dato de los requeridos no se ha recibido"; 
        $_SESSION['mensaje2'] = "Por favor, introduzca de nuevo los datos y vuelva a intentarlo.";
    endif;
endif; ?>


<div class="row">
    <div class="col text-center">
<?php if (!empty($_SESSION['mensaje1'])): ?>
    <h1><?= $_SESSION['mensaje1']; ?></h1>
    <p><?= $_SESSION['mensaje2']; ?></p>
    <?php unset($_SESSION['mensaje1'], $_SESSION['mensaje2']); ?>  
<?php else: ?>
        <h1>Introduzca su nombre y su correo electrónico de registro</h1>
        <p>Le enviamos una contraseña nueva para acceder a la web.</p>
<?php endif; ?>
    </div>
</div>

<div class="form-container">
    <form action="#" onsubmit="return validarNuevaContra();" method="post">
        <div class="form-group">
            <label for="nombreUsuario">Nombre:</label>
                <input type="text" name="nombreUsuario" class="form-control" id="nombreUsuario" />
            <div id="js_nombreUsuario"></div>
        </div>
        <div class="form-group">
            <label for="correo">Correo electrónico:</label>
                <input type="text" name="correo" class="form-control" id="correo" />
            <div id="js_correo"></div>
        </div>
        <div class="form-group">
            <input type="hidden" name="formulario" id="formulario" value="nuevaContra" />
        </div>
        <button type="submit" name="submit" class="btn b_btn-1 mr-2">Enviar</button>
        <a href="javascript:history.back()" class="btn b_btn-1">Volver atrás</a>
    </form>
</div>



<?php mysqli_close($mysqli); ?>
<?php include('include/pie.php') ?>