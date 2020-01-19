<?php session_start();?>
<?php include('include/reporteErrores.php'); ?>
<?php include('baseDeDatos/conexionBaseDeDatos.php');?>
<?php $controlador = 1; ?>
<?php $titulo = 'Iniciar Sesión'; ?>
<?php include('php/funciones.php'); ?>
<?php include('include/encabezado.php'); ?>
<?php include('include/barraNavegacion.php'); ?>
<?php include('include/mostrarImagen.php'); ?>

<?php if (isset($_POST["submit"])):
    if (!empty($_POST['nombreUsuario']) && !empty($_POST['contra'])):
        $nombreUsuario = filtrado($_POST['nombreUsuario']);
        $contra = validarContra($_POST['contra']);
        $consulta = "SELECT nombreUsuario, idUsuario, contra FROM usuario u WHERE nombreUsuario = '" . $nombreUsuario . "' AND contra = '" . $contra . "'";
        $resultado = mysqli_query($mysqli, $consulta);
        
        if (mysqli_num_rows($resultado) > 0):
            // Devuelve una fila al menos
            while ($filas = mysqli_fetch_assoc($resultado)):
                $_SESSION['nombreUsuario'] = $filas['nombreUsuario'];
                $_SESSION['idUsuario'] = $filas['idUsuario'];
            endwhile;
            
            $_SESSION['mensaje1'] = 'Ha iniciado sesión correctamente';
            // Vaciamos y cerramos sesión
            mysqli_free_result($resultado);
            mysqli_close($mysqli);
            redireccion('index.php');
        endif;
    else:
        $_SESSION['mensaje1'] = 'Inicio de sesión incorrecto';
        $_SESSION['mensaje2'] = 'Por favor, vuelva a intentarlo de nuevo.';
    endif;
    mysqli_free_result($resultado); 
    
endif; ?>
  
<div class="row">
    <div class="col text-center">
<?php if (!empty($_SESSION['mensaje1'])): ?>
    <h1><?= $_SESSION['mensaje1']; ?></h1>
    <p><?= $_SESSION['mensaje2']; ?></p>
    <?php unset($_SESSION['mensaje1'], $_SESSION['mensaje2']); ?>     

<?php else: ?>
    <h1>Inicie sesión o <a href="registro.php">regístrese</a></h1>       
    <p>¿Ha perdido su contraseña? Entre <a href="nuevaContra.php">aquí</a>.</p>   
<?php endif; ?>
    </div>
</div>

<div class="container">
    <form action="#" onsubmit="return validarFormulario();" method="post">
        <div class="form-group">
            <label for="nombreUsuario">Nombre:</label>
            <input type="text" class="form-control" name="nombreUsuario" id="nombreUsuario" />
            <div id="js_nombreUsuario"></div>
        </div>
        <div class="form-group">
            <label for="contra">Contraseña:</label>
            <input type="password" class="form-control" name="contra" id="contra" />
            <div id="js_contra"></div>
        </div>
        <div class="form-group">
            <input type="hidden" name="formulario" id="formulario" value="iniciarSesion" />
        </div>
        <button type="submit" name="submit" class="btn b_btn-1">Entrar</button>
    </form>
</div>

<?php mysqli_close($mysqli); ?>
<?php include('include/pie.php') ?>