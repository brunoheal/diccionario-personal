<?php
if ($controlador == 1):
    $consultaImagen = "SELECT src, alt FROM imagen WHERE idImagen = 1";
    unset($controlador);

elseif ($controlador == 2):
    $consultaImagen = "SELECT src, alt FROM imagen WHERE idImagen = 2";
    unset($controlador);

else:
    $consultaImagen = "SELECT src, alt FROM imagen WHERE idImagen != 1 AND idImagen != 2 ORDER BY floor(rand()*(10-3)+3) LIMIT 1"; 
    unset($controlador);
endif;
        
$resultImagen = mysqli_query($mysqli, $consultaImagen); ?>

<div class="row mt-4 mb-3">
    <div class="col-md-12 mx-auto text-center">

<?php
if (mysqli_num_rows($resultImagen) > 0):
    while ($filasImagen = mysqli_fetch_assoc($resultImagen)):
        echo "<img src='" . $filasImagen['src'] . "' alt='" . $filasImagen['alt'] . "' class='img-fluid'>";    
    endwhile;

else:
    echo "<p>No se puede mostrar la imagen</p>";
endif;

mysqli_free_result($resultImagen); ?>

    </div>
</div>