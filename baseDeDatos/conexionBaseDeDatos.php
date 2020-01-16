<?php
require_once('baseDeDatos/datosBaseDeDatos.php');

// Se crea la conexión o se muestra error
$mysqli = mysqli_connect($nombreHost, $nombreUsuario, $contra, $baseDatos) or
die("Fallo en la conexión a MySQL: " . mysqli_connect_error());

// Codificación para evitar problemas con los acentos
mysqli_set_charset($mysqli, "utf8");