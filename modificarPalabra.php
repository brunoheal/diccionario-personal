<?php session_start();?>
<?php include('include/reporteErrores.php'); ?>
<?php include('baseDeDatos/conexionBaseDeDatos.php');?>
<?php $controlador = 3; ?>
<?php $llave = false; ?>
<?php $titulo = 'Modificar Palabra'; ?>
<?php include('php/funciones.php'); ?>
<?php verificarSesion(); ?>
<?php include('include/encabezado.php'); ?>
<?php include('include/barraNavegacion.php'); ?>
<?php include('include/mostrarImagen.php'); ?>

<?php if (isset($_GET['submit'])):
    if (!empty($_GET['modificarPalabra']) && !empty($_SESSION['idUsuario'])):
        $modificarPalabra = filtrado($_GET['modificarPalabra']);
        $idUsuario = filtrado($_SESSION['idUsuario']);

        $consulta = "SELECT significadoPalabra, idPalabra, idGrupo FROM palabra WHERE palabraOriginal = '" . $modificarPalabra . "' AND idUsuario = '" . $idUsuario . "'";
        $resultado = mysqli_query($mysqli, $consulta);
        
        if (mysqli_num_rows($resultado) > 0):
            // Devuelve una fila por lo que el término a modificar sí está archivado ?>
        <div class="container">
            <form action="#" method="get">
                <h1 class="text-center">Puede modificar algún campo de la palabra:</h1>
                <div class="form-group">

            <?php while ($filas = mysqli_fetch_assoc($resultado)): ?>           
                    <label for="modificarPalabra">Palabra:</label>
                    <input type="text" class="form-control" name="modificarPalabra" value="<?= ucwords($modificarPalabra); ?>" />
                </div>
                <div class="form-group">    
                    <input type="hidden" name="idPalabra" class="form-control" value="<?= ucwords($filas['idPalabra']); ?>" /> 
                </div>              
                <div class="form-group">
                    <label for="significadoPalabra">Traducción:</label>
                    <input type="text" class="form-control" name="significadoPalabra" value="<?= ucwords($filas['significadoPalabra']); ?>" />
                </div>
                <div class="form-group">
                    <label for="idGrupo">Nombre del grupo:</label>
                    <select name="idGrupo">

                    <?php $consulta2 = "SELECT idGrupo, nombreGrupo FROM grupo WHERE idUsuario = $idUsuario";
                    $resultado2 = mysqli_query($mysqli, $consulta2);
                    while ($filas2 = mysqli_fetch_assoc($resultado2)): 
                        if ($filas2['idGrupo'] == $filas['idGrupo']): ?>
                            <option value="<?= $filas2['idGrupo']; ?>" selected><?= ucwords($filas2['nombreGrupo']); ?></option>
                        
                        <?php else: ?>
                            <option value="<?= $filas2['idGrupo']; ?>"><?= ucwords($filas2['nombreGrupo']); ?></option>
                        <?php endif; ?>
                        
                    <?php endwhile; ?>
                    </select>
                </div>
            <?php endwhile; ?>
            <?php mysqli_free_result($resultado); ?>
            <?php mysqli_free_result($resultado2); ?>
            <?php $llave = true; ?>
                    <button type="submit" name="submit2" class="btn b_btn-1">Modificar</button>
                    <a href="index.php" class="btn b_btn-1">Volver</a>
                </div>
            </form>
        </div> <!-- form-container -->   

        <?php else:
            $_SESSION['mensaje1'] = "No ha sido posible mostrar la palabra elegida";
            $_SESSION['mensaje2'] = "Por favor, inténtelo de nuevo.";
        endif;

    else:
        $_SESSION['mensaje1'] = "No ha sido posible mostrar la palabra elegida";
        $_SESSION['mensaje2'] = "Compruebe que los campos estén correctos.";
    endif; 
endif; ?>

<?php if (isset($_GET['submit2'])):
    if (!empty($_GET['modificarPalabra']) && !empty($_GET['significadoPalabra']) && !empty($_GET['idGrupo']) && !empty($_GET['idPalabra']) && !empty($_SESSION['idUsuario'])):
        $modificarPalabra = filtrado($_GET['modificarPalabra']);
        $significadoPalabra = filtrado($_GET['significadoPalabra']);
        $idPalabra = filtrado($_GET['idPalabra']);
        $idGrupo = filtrado($_GET['idGrupo']);
        $idUsuario = filtrado($_SESSION['idUsuario']);
        $llave = false;

        // Aquí los vamos a insertar en la base de datos
        $consulta = "UPDATE palabra SET palabraOriginal = '" . $modificarPalabra . "', significadoPalabra = '" . $significadoPalabra . "', idGrupo = '" . $idGrupo . "' WHERE idPalabra = '" . $idPalabra . "' AND idUsuario = '" . $idUsuario . "'";
        if (mysqli_query($mysqli, $consulta)):
            // Realizado con éxito
            $_SESSION['mensaje1'] = "Se ha actualizado con éxito su palabra";
            $_SESSION['mensaje2'] = "Muévase por la barra de navegación.";
            
        else:
            // Algo ha fallado, mensaje de error
            $_SESSION['mensaje1'] = "No se ha podido archivar la palabra que ha modificado";
            $_SESSION['mensaje2'] = "Por favor, vuelva a intentarlo.";   
        endif;

    else:
        // No han llegado los datos completos por alguna razón, da mensaje de error y que vuelva a intentarlo
        $_SESSION['mensaje1'] = "Ha faltado algún dato para poder actualizar su palabra";
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
        <h1 class="text-center">Aquí puede modificar cualquier palabra ya archivada</h1>
        <div class="form-container text-left">
            <form action="#" method="get" class="mt-2">
                <div class="form-group">
                    <label for="modificarPalabra">Por favor, introduzca la palabra a modificar:</label>
                    <input type="text" class="form-control" name="modificarPalabra" />
                </div>
                <button type="submit" name="submit" class="btn b_btn-1 mr-2">Enviar</button>
                <a href="javascript:history.back()" class="btn b_btn-1">Volver atrás</a>
            </form>
        </div>
    <?php endif; ?>
<?php endif; ?> 

<?php mysqli_close($mysqli); ?>
<?php include('include/pie.php'); ?>

