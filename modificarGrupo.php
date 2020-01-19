<?php session_start();?>
<?php include('include/reporteErrores.php'); ?>
<?php include('baseDeDatos/conexionBaseDeDatos.php');?>
<?php $controlador = 3; ?>
<?php $titulo = 'Modificar Grupo'; ?>
<?php include('php/funciones.php'); ?>
<?php verificarSesion(); ?>
<?php include('include/encabezado.php'); ?>
<?php include('include/barraNavegacion.php'); ?>
<?php include('include/mostrarImagen.php'); ?>

<?php if (empty($_SESSION['mensaje1'])): ?>
    <?php if (isset($_GET['submit'])):
        if (!empty($_GET['idGrupo']) && !empty($_GET['nombreGrupo']) && !empty($_SESSION['idUsuario'])):
            // Hemos recibido correctamente los datos
            $idGrupo = filtrado($_GET['idGrupo']);
            $nombreGrupo = filtrado($_GET['nombreGrupo']);
            $idUsuario = filtrado($_SESSION['idUsuario']);

            // Hacemos consulta para ver si el nombre modificado ya existe
            $consulta = "SELECT nombreGrupo FROM grupo WHERE nombreGrupo = '" . $nombreGrupo . "'  AND idUsuario = '" .  $idUsuario . "'";
            $resultado = mysqli_query($mysqli, $consulta);
            if (mysqli_num_rows($resultado) > 0):
                // Ya existe, y no lo podemos volver a archivar
                $_SESSION['mensaje1'] = "El nombre del grupo que quiere modificar ya existe";
                $_SESSION['mensaje2'] = "Si lo desea, introduzca otro nombre diferente.";
            
            else:
                $consulta2 = "UPDATE grupo SET nombreGrupo = '" . $nombreGrupo . "' WHERE idGrupo = '" . $idGrupo . "' AND idUsuario = '" .  $idUsuario . "'";
                if (mysqli_query($mysqli, $consulta2)):
                    // Se han actualizado los datos correctamente
                    $_SESSION['mensaje1'] = "Se ha modificado correctamente el grupo que ha elegido";
                    $_SESSION['mensaje2'] = "Muévase por la barra de navegación.";
                
                else:
                    // No se ha hecho la actualización
                    $_SESSION['mensaje1'] = "El grupo que ha elegido no ha podido ser modificado";
                    $_SESSION['mensaje2'] = "Por favor, vuelva a intentarlo.";     
                endif;
                mysqli_free_result($resultado);
            endif;  
        
        else:
            // No se han recibido los datos correctamente
            $_SESSION['mensaje1'] = "No se ha podido modificar el grupo";
            $_SESSION['mensaje2'] = "Por favor, vuelva a intentarlo.";
        endif; ?>
    <?php endif; ?>

    <?php if (isset($_GET['accion']) && $_GET['accion'] == 'modificar'):
        if (!empty($_GET['idGrupo']) && !empty($_SESSION['idUsuario'])):
            // Hemos recibido correctamente los datos
            $idGrupo = filtrado($_GET['idGrupo']);
            $idUsuario = filtrado($_SESSION['idUsuario']);

            $consulta = "SELECT nombreGrupo FROM grupo WHERE idGrupo ='" . $idGrupo . "'";
            $resultado = mysqli_query($mysqli, $consulta);
            
            if (mysqli_num_rows($resultado) > 0): // Nos devuelve una fila, por tanto existe el grupo ?>
                <div class="form-container mt-4">               
                    <form action="#" method="get">
                    <?php while ($filas = mysqli_fetch_assoc($resultado)): ?>
                        <div class="form-group">
                            <label name="nombreGrupo">Nombre del grupo:</label>
                            <input type="text" name="nombreGrupo" value="<?= $filas['nombreGrupo']; ?>">
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="idGrupo" value="<?= $idGrupo; ?>">       
                        </div>
                        <button type="submit" name="submit" class="btn b_btn-1 mr-2">Modificar</button>
                        <a href="javascript:history.back()" class="btn b_btn-1">Volver atrás</a>
                    <?php endwhile; ?>
                    </form>
                </div> <!-- container -->
                <?php mysqli_free_result($resultado); ?>
            
            <?php else:
                // No ha devuelto ninguna fila, por tanto no existe el grupo
                $_SESSION['mensaje1'] = "El grupo que ha escogido no está archivado"; 
                $_SESSION['mensaje2'] = "Inténtelo con un grupo diferente.";
            endif;

        else:
            // No hemos recibido el id del grupo
            $_SESSION['mensaje1'] = "No se ha podido mostrar el grupo elegido";
            $_SESSION['mensaje2'] = "Inténtelo con otro distinto.";
        endif; 
    endif; ?>

    <?php if (isset($_GET['accion']) && $_GET['accion'] == 'listar'):
        $consulta = "SELECT idGrupo, nombreGrupo FROM grupo WHERE idUsuario = '" . $_SESSION['idUsuario'] . "'";
        $resultado = mysqli_query($mysqli, $consulta); 

        if (!mysqli_num_rows($resultado) > 0): ?>
            <div class="row">
                <div class="col text-center">
                    <h1>No hay grupos para mostrar</h1>
                    <p>Si lo desea, puede crear alguno.</p>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                <button type="submit" name="submit" class="btn b_btn-1 mt-2 mr-2">Añadir grupo</button>
                <a href="javascript:history.back()" class="btn b_btn-1 mt-2">Volver atrás</a>
                </div>
            </div>

        <?php else: ?>   
            <div class="row">
                <div class="col text-center mb-3">
                    <h1>Listado de sus grupos</h1>
                </div>
            </div>
            <div class="row">
                <div class="col text-center table-responsive">
                    <table class="table-bordered table-warning d-inline-block">
                        <tr>
                            <th>Nombre</th>
                            <th>Ver palabras</th>
                            <th>Modificar</th>
                        </tr>
                    <?php
                    while ($filas = mysqli_fetch_assoc($resultado)): ?>
                        <tr>      
                            <td><?= ucwords($filas['nombreGrupo']); ?></td>
                            <td><a href="modificarGrupo.php?idGrupo=<?= $filas['idGrupo']; ?>&accion=ver" class="btn">Ver palabras del grupo</a></td>
                            <td><a href="modificarGrupo.php?idGrupo=<?= $filas['idGrupo']; ?>&accion=modificar" class="btn">Modificar grupo</a></td>
                        </tr>
                    <?php 
                endwhile; ?>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    <a href="agregarGrupo.php" class="btn b_btn-1 mt-2 mr-2">Añadir grupo</a>
                    <a href="javascript:history.back()" class="btn b_btn-1 mt-2">Volver atrás</a>
                </div>
            </div>
        <?php endif; ?>
        <?php mysqli_free_result($resultado); ?>
    <?php endif; ?>

    <?php if (isset($_GET['accion']) && $_GET['accion'] == 'ver'):
        if (!empty($_GET['idGrupo']) && !empty($_SESSION['idUsuario'])):
            // Los datos han llegado bien
            $idGrupo = filtrado($_GET['idGrupo']);
            $idUsuario = filtrado($_SESSION['idUsuario']);
            
            // Esta consulta es para pintar las palabras del grupo escogido
            $consulta = "SELECT palabraOriginal, significadoPalabra FROM palabra WHERE idGrupo ='" . $idGrupo . "' AND idUsuario ='" .  $idUsuario . "'";
            $resultado = mysqli_query($mysqli, $consulta);
            
            if (mysqli_num_rows($resultado) > 0): ?>
                <div class="row">
                    <div class="col text-center">
                        <h1>Sus palabras del grupo escogido:</h1>
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
                                <td><?= ucwords($filas['palabraOriginal']); ?></td>
                                <td><?= ucwords($filas['significadoPalabra']); ?></td>
                            </tr>
                <?php endwhile;
                mysqli_free_result($resultado); ?>
                        </table>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col text-center">
                    <a href="javascript:history.back()" class="btn b_btn-1 mt-2">Volver atrás</a>
                    </div>
                </div>

            <?php else:
                $_SESSION['mensaje1'] = "No existen palabras en el grupo que ha escogido";
                $_SESSION['mensaje2'] = "Introduzca palabras o liste otro grupo.";
            endif;

        else:
            $_SESSION['mensaje1'] = "No se pueden listar las palabras del grupo que ha escogido";
            $_SESSION['mensaje2'] = "Por favor, vuelva a intentarlo.";
        endif;
    endif;
endif; ?>

<?php if (!empty($_SESSION['mensaje1'])): ?>
<div class="row">
    <div class="col text-center">
        <h1><?= $_SESSION['mensaje1']; ?></h1>
        <p><?= $_SESSION['mensaje2']; ?></p>
        <?php unset($_SESSION['mensaje1'], $_SESSION['mensaje2']); ?>     
    </div>
</div>
<?php endif; ?>

<?php mysqli_close($mysqli); ?>
<?php include('include/pie.php'); ?>