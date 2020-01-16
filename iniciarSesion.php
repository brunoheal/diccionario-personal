<?php session_start();?>
<?php include('include/reporteErrores.php'); ?>
<?php include('baseDeDatos/conexionBaseDeDatos.php');?>
<?php $controlador = 1 ?>
<?php include('php/funciones.php'); ?>
<?php include('include/encabezado.php'); ?>
<?php include('include/barraNavegacion.php'); ?>
<?php include('include/mostrarImagen.php'); ?>

<?php if (!empty($_SESSION['mensaje1'])): ?>
    <div class="row">
        <div class="col text-center">
            <h1><?= $_SESSION['mensaje1']; ?></h1>
            <p><?= $_SESSION['mensaje2']; ?></p>
            <?php unset($_SESSION['mensaje1'], $_SESSION['mensaje2']); ?>
        </div>
    </div>

<?php else: ?>
<div class="row">
    <div class="col text-center">
        <h1>Inicie sesión o <a href="#">regístrese</a></h1>       
        <p>¿Ha perdido su contraseña? Entre <a href="#">aquí</a>.</p>
    </div>
</div>
<?php endif; ?>

<?php include('include/formularioIniciarSesion.php'); ?>
<?php mysqli_close($mysqli); ?>
<?php include('include/pie.php') ?>