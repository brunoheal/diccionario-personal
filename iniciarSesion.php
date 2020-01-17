<?php session_start();?>
<?php include('include/reporteErrores.php'); ?>
<?php include('baseDeDatos/conexionBaseDeDatos.php');?>
<?php $controlador = 1 ?>
<?php include('php/funciones.php'); ?>
<?php include('include/encabezado.php'); ?>
<?php include('include/barraNavegacion.php'); ?>
<?php include('include/mostrarImagen.php'); ?>

<?php if (isset($_POST["submit"])):
    if (!empty($_POST['nombre']) && !empty($_POST['contra'])):
        $nombre = filtrado($_POST['nombre']);
        $contra = validarContra($_POST['contra']);
        $consulta = "SELECT u.nombre, u.idUsuario, u.contra FROM usuario u WHERE u.nombre = '" . $nombre . "' AND u.contra = '" . $contra . "'";
        $resultado = mysqli_query($mysqli, $consulta);
        
        if (mysqli_num_rows($resultado) > 0):
            // Devuelve una fila al menos
            while ($filas = mysqli_fetch_assoc($resultado)):
                $_SESSION['nombre'] = $filas['nombre'];
                $_SESSION['idUsuario'] = $filas['idUsuario'];
            endwhile;

            $_SESSION['mensaje1'] = 'Ha iniciado sesión correctamente';
            // Vaciamos y cerramos sesión
            mysqli_free_result($resultado);
            mysqli_close($mysqli);
            redireccion('index.php');
        endif;
    endif;
    $_SESSION['mensaje1'] = 'Inicio de sesión incorrecto';
    $_SESSION['mensaje2'] = 'Por favor, vuelva a intentarlo de nuevo.';
    mysqli_free_result($resultado);
endif; ?>
  
<div class="row">
    <div class="col text-center">
<?php if (!empty($_SESSION['mensaje1'])): ?>
    <h1><?= $_SESSION['mensaje1']; ?></h1>
    <p><?= $_SESSION['mensaje2']; ?></p>
    <?php unset($_SESSION['mensaje1'], $_SESSION['mensaje2']); ?>     

<?php else: ?>
    <h1>Inicie sesión o <a href="#">regístrese</a></h1>       
    <p>¿Ha perdido su contraseña? Entre <a href="#">aquí</a>.</p>   
<?php endif; ?>
    </div>
</div>

<?php include('include/formularioIniciarSesion.php'); ?>

<?php mysqli_close($mysqli); ?>
<?php include('include/pie.php') ?>