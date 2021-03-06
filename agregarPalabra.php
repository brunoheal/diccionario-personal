<?php session_start();?>
<?php include('include/reporteErrores.php'); ?>
<?php include('baseDeDatos/conexionBaseDeDatos.php');?>
<?php $controlador = 3; ?>
<?php $titulo = 'Añadir Palabra'; ?>
<?php include('php/funciones.php'); ?>
<?php verificarSesion(); ?>
<?php include('include/encabezado.php'); ?>
<?php include('include/barraNavegacion.php'); ?>
<?php include('include/mostrarImagen.php'); ?>

<?php if (isset($_GET['submit'])):
    if (!empty($_GET['palabraOriginal']) && !empty($_GET['significadoPalabra']) && !empty($_GET['idGrupo']) && !empty($_SESSION['idUsuario'])):
        $palabraOriginal = filtrado($_GET['palabraOriginal']);
        $significadoPalabra = filtrado($_GET['significadoPalabra']);
        $idGrupo = filtrado($_GET['idGrupo']);
        $idUsuario = filtrado($_SESSION['idUsuario']);
        
        $consulta = "SELECT palabraOriginal FROM palabra WHERE palabraOriginal ='" . $palabraOriginal . "' AND idUsuario ='" . $idUsuario . "'";
        $resultado = mysqli_query($mysqli, $consulta);
    
        if (mysqli_num_rows($resultado) > 0):
            // Devuelve una fila por que el término ya existe en la base de datos
            $_SESSION['mensaje1'] = "El término que quiere archivar ya existe en el diccionario";
            $_SESSION['mensaje2'] = "Si lo desea, puede introducir otro.";
          
        else:
            // No está en base de datos y lo añadimos
            $consulta2 = "INSERT INTO palabra (palabraOriginal, significadoPalabra, idGrupo, idUsuario) VALUES ('$palabraOriginal', '$significadoPalabra', '$idGrupo', '$idUsuario')"; 
            
            if (mysqli_query($mysqli, $consulta2)):
                // Se ha añadido correctamente y graba mensaje de ok en sesión
                $_SESSION['mensaje1'] = "Nuevo término añadido al diccionario correctamente";
                $_SESSION['mensaje2'] = "Muévase por la barra de navegación.";                
    
            else:
                // No ha ido bien y saca mensaje de error
                $_SESSION['mensaje1'] = "No ha sido posible añadir su término al diccionario";
                $_SESSION['mensaje2'] = "Por favor, vuelva a intentarlo.";
                   
            endif;
        endif;
        mysqli_free_result($resultado);    
    else:
        // Faltan datos
        $_SESSION['mensaje1'] = "Tiene que enviar un término en inglés y su significado en español para poder guardarlo";
        $_SESSION['mensaje2'] = "Por favor, verifique los datos antes de enviarlos.";       
    endif;
endif; ?>

<div class="row">
    <div class="col text-center">
    <?php if (!empty($_SESSION['mensaje1'])): ?>
        <h1><?= $_SESSION['mensaje1']; ?></h1>
        <p><?= $_SESSION['mensaje2']; ?></p>
        <?php unset($_SESSION['mensaje1'], $_SESSION['mensaje2']); ?>     
    <?php else: ?>
        <h1 class="text-center">Introduzca una palabra en inglés con su traducción al español:</h1>
        <div class="form-container text-left">
            <form action="#" method="get">
                <div class="form-group">
                    <label for="palabraOriginal">Palabra:</label>
                <?php $consulta = "SELECT nombreGrupo FROM grupo WHERE idUsuario ='" . $_SESSION['idUsuario'] . "' LIMIT 1"; ?>
                <?php $resultado = mysqli_query($mysqli, $consulta); ?>
                <?php if (mysqli_num_rows($resultado) > 0): ?>
                    <input type="text" class="form-control" name="palabraOriginal" />
                
                <?php else: ?>
                    <input type="text" class="form-control" name="palabraOriginal" data-toggle="popover" data-placement="top" data-content="Tiene que entrar primero a 'mis grupos' para crear un grupo e ir añadiendo sus palabras al mismo" />
                <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="significadoPalabra">Traducción:</label>
                    <input type="text" class="form-control" name="significadoPalabra" />
                </div>
                <div class="form-group">
                    <label for="idGrupo">Grupo:</label>
                    <select class="form-control" name="idGrupo">
                    <?php $consulta2 = "SELECT nombreGrupo, idGrupo FROM grupo WHERE idUsuario = '" . $_SESSION['idUsuario'] . "'"; ?>
                    <?php $resultado2 = mysqli_query($mysqli, $consulta2); ?>
                    <?php while ($filas = mysqli_fetch_assoc($resultado2)): ?>
                        <option value="<?= $filas['idGrupo']; ?>"><?= ucwords($filas['nombreGrupo']); ?></option>
                    <?php endwhile; ?>
                    </select>
                </div>       
                <button type="submit" name="submit" class="btn b_btn-1 mr-3">Añadir</button>
                <a href="modificarGrupo.php?accion=listar" class="btn b_btn-1">Mis grupos</a>
            </form>
        </div>
        <?php mysqli_free_result($resultado2); ?>
    <?php endif; ?>
    </div>
</div>

<?php mysqli_close($mysqli); ?>
<?php include('include/pie.php'); ?>