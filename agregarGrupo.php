<?php session_start();?>
<?php include('include/reporteErrores.php'); ?>
<?php include('baseDeDatos/conexionBaseDeDatos.php');?>
<?php $controlador = 3; ?>
<?php $titulo = 'Añadir Grupo'; ?>
<?php include('php/funciones.php'); ?>
<?php verificarSesion(); ?>
<?php include('include/encabezado.php'); ?>
<?php include('include/barraNavegacion.php'); ?>
<?php include('include/mostrarImagen.php'); ?>

<?php if (isset($_GET['submit'])):  
    if (!empty($_GET['nombreGrupo']) && !empty($_SESSION['idUsuario'])):
        $nombreGrupo = filtrado($_GET['nombreGrupo']);
        $idUsuario = filtrado($_SESSION['idUsuario']);
        
        $consulta = "SELECT nombreGrupo FROM grupo WHERE nombreGrupo = '" . $nombreGrupo . "' AND idUsuario = '" . $idUsuario . "'";
        $resultado = mysqli_query($mysqli, $consulta);
        
        if (mysqli_num_rows($resultado) > 0):
            // Nos devuelve alguna fila, por lo que ya existe un grupo con ese nombre
            $_SESSION['mensaje1'] = "El grupo que quiere crear ya existe"; 
            $_SESSION['mensaje2'] = "Puede cambiar el nombre para crear otro grupo nuevo.";
            
        else:
            // No existe el grupo y lo vamos a insertar
            $consulta2 = "INSERT INTO grupo (idGrupo, nombreGrupo, idUsuario) VALUES (NULL, '$nombreGrupo', '$idUsuario')";
                
            if (mysqli_query($mysqli, $consulta2)):
                // Se ha añadido correctamente y graba mensaje de ok en sesión
                $_SESSION['mensaje1'] = "Su nuevo grupo ha sido añadido correctamente";
                $_SESSION['mensaje2'] = "Muévase por la barra de navegación a donde desee.";
                
            else:
                // No ha ido bien y saca mensaje de error
                $_SESSION['mensaje1'] = "No ha sido posible añadir su nuevo grupo"; 
                $_SESSION['mensaje2'] = "Por favor, vuelva a intentarlo.";
            endif;       
        endif;
    mysqli_free_result($resultado);
    else: 
        // No ha ido bien, posiblemente faltan datos o no han llegado
        $_SESSION['mensaje1'] = "No se ha podido crear tu nuevo grupo";
        $_SESSION['mensaje2'] = "Por favor, vuelve a intentarlo.";       
    endif;
endif; ?>  

<div class="row">
    <div class="col text-center">
    <?php if (!empty($_SESSION['mensaje1'])): ?>
        <h1><?= $_SESSION['mensaje1']; ?></h1>
        <p><?= $_SESSION['mensaje2']; ?></p>
        <?php unset($_SESSION['mensaje1'], $_SESSION['mensaje2']); ?>     
    <?php else: ?>
        <h1 class="text-center">Introduzca el nombre del grupo que desea crear</h1>
        <div class="form-container text-left">
            <form action="#" method="get">
                <div class="form-group">
                    <label for="nombreGrupo">Nombre del nuevo grupo:</label>
                    <input type="text" name="nombreGrupo" class="form-control">
                </div>
                <button type="submit" name="submit" class="btn b_btn-1 mr-2">Añadir</button>
                <a href="javascript:history.back()" class="btn b_btn-1">Volver atrás</a>
            </form>
        </div>
    <?php endif; ?>
    </div>
</div>

<?php mysqli_close($mysqli); ?>
<?php include('include/pie.php'); ?>
