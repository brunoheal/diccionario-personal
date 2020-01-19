<?php session_start();?>
<?php include('include/reporteErrores.php'); ?>
<?php include('baseDeDatos/conexionBaseDeDatos.php');?>
<?php $controlador = 3; ?>
<?php $llave = false; ?>
<?php $titulo = 'Mostrar Palabra'; ?>
<?php include('php/funciones.php'); ?>
<?php verificarSesion(); ?>
<?php include('include/encabezado.php'); ?>
<?php include('include/barraNavegacion.php'); ?>
<?php include('include/mostrarImagen.php'); ?>

<?php if (isset($_GET['submit'])):
    if (!empty($_GET['letraPalabra']) && !empty($_GET['opt_radio']) && !empty($_SESSION['idUsuario'])):
        // Han llegado los datos correctamente
        $letraPalabra = filtrado($_GET['letraPalabra']);
        $opt_radio = filtrado($_GET['opt_radio']);
        $idUsuario = filtrado($_SESSION['idUsuario']);

        $consulta = "SELECT palabraOriginal, significadoPalabra FROM palabra WHERE idUsuario = '" . $idUsuario . "' AND palabraOriginal LIKE '" . $letraPalabra . "%' ORDER BY palabraOriginal $opt_radio"; 
        $resultado = mysqli_query($mysqli, $consulta); 
        
        if (mysqli_num_rows($resultado) > 0): 
            // Existen términos que comiencen por dicha letra ?>
            <?php $llave = true; ?>
            <div class="row">
                <div class="col text-center mb-3">
                    <h1>Listado de sus palabras que empiezan por la letra '<?= $letraPalabra ;?>':</h1>
                </div>
            </div>
            
            <div class="row">
                <div class="col text-center">
                    <table class="table-bordered table-warning d-inline-block">
                        <tr>
                            <th>Palabra</th>
                            <th>Traducción</th>
                        </tr>              
                    <?php while ($filas = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><?= ucwords($filas['palabraOriginal']); ?> </td>
                            <td><?= ucwords($filas['significadoPalabra']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                    <?php mysqli_free_result($resultado); ?>
                    </table>
                </div>
            </div>

            <?php
            $consulta2 = "SELECT count(palabraOriginal) as numeroPalabras FROM palabra WHERE idUsuario ='" . $idUsuario . "'";
            $resultado2 = mysqli_query($mysqli, $consulta2);
            if (mysqli_num_rows($resultado2) > 0): 
                while ($filas2 = mysqli_fetch_assoc($resultado2)): ?>    
                    <div class="row">
                        <div class="col text-center mt-2">
                            <h5>En total tiene <?= $filas2['numeroPalabras']; ?> palabras archivadas.</h5>
                        </div>
                    </div>
                <?php endwhile;
            endif; 
            mysqli_free_result($resultado2); ?>
        
            <div class="row">
                <div class="col text-center">
                
                    <a href="index.php" class="btn b_btn-1 mt-2">Volver a principal</a>
                </div>
            </div>
    
        <?php // No existen términos que comiencen por dicha letra
        else:
            $_SESSION['mensaje1'] = "No tiene palabras que comiencen por la letra " . "'$letraPalabra'.";
            $_SESSION['mensaje2'] = "Si lo desea, introduzca otra letra.";
        endif;         
   
    else: // No han llegado los datos
        $_SESSION['mensaje1'] = "Ha faltado algún dato para poder listar las palabras";
        $_SESSION['mensaje2'] = "Por favor, vuelva a intentarlo.";
    endif;
endif; ?>

<?php if (!$llave): ?>
<div class="row">
    <div class="col text-center">
    <?php if (!empty($_SESSION['mensaje1'])): ?>
        <h1><?= $_SESSION['mensaje1']; ?></h1>
        <p><?= $_SESSION['mensaje2']; ?></p>
        <?php unset($_SESSION['mensaje1'], $_SESSION['mensaje2']); ?>
    </div>
</div>     
    <?php else: ?>
        <h1 class="text-center">Puede buscar todas las palabras que comiencen por una letra</h1>
    <div class="form-container text-left">
        <form action="#" method="get" class="mt-1">
            <div class="form-group">
                <label for="letraPalabra">Introduzca una letra:</label>
                <input type="text" class="form-control" name="letraPalabra">
            </div>
            <span>Elija el orden de listado de las palabras:&nbsp;&nbsp;</span>
            <div class="form-check-inline">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="opt_radio" value="ASC" checked />Ascendente
                </label>
            </div>
            <div class="form-check-inline">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="opt_radio" value="DESC" />Descendente
                </label>
            </div>
            <br />
            <button type="submit" name="submit" class="btn b_btn-1 mt-2 mr-2">Mostrar</button>
            <a href="javascript:history.back()" class="btn b_btn-1 mt-2">Volver atrás</a>
        </form>
    </div>
    <?php endif; ?>
<?php endif; ?>

<?php mysqli_close($mysqli); ?>
<?php include('include/pie.php'); ?>