<?php session_start();?>
<?php include('include/reporteErrores.php'); ?>
<?php include('baseDeDatos/conexionBaseDeDatos.php');?>
<?php $controlador = 2 ?>
<?php include('php/funciones.php'); ?>
<?php verificarSesion(); ?>
<?php include('include/encabezado.php'); ?>
<?php include('include/barraNavegacion.php'); ?>
<?php include('include/mostrarImagen.php'); ?>

<div class="row">
    <div class="col text-center">
<?php if (!empty($_SESSION['mensaje1'])): ?>
    <h1><?= $saludo = saludo() . " " . ucwords($_SESSION['nombre']); ?></h1>
    <h2><?= $_SESSION['mensaje1']; ?></h2>
    <p>Muévase por la barra de navegación para dirigirse a donde desee.</p>
    <?php unset($_SESSION['mensaje1']); ?>

<?php else: ?>
        <h1>Bienvenido a su diccionario de inglés personal</h1>       
        <p>Muévase por la barra de navegación para dirigirse a donde desee.</p>
<?php endif; ?>
</div>
    </div>

<?php // Bloque alerta cookies ?>
<div class="alert text-center cookiealert" role="alert">
    <b>¿Quiere nuestras cookies?</b> &#x1F36A; &nbsp; Utilizamos cookies para asegurar que damos la mejor experiencia al usuario en nuestro sitio web. Si continúa utilizando este sitio, asumiremos que está de acuerdo. <a href="#" class="bh_esp">Leer más</a>

    <button type="button" class="btn b_btn-1 btn-sm acceptcookies" aria-label="Close">
        Estoy de acuerdo
    </button>
</div>

<?php mysqli_close($mysqli); ?>
<?php include('include/pie.php') ?>