<?php 
 
 $con = mysqli_connect("localhost","root","","comite_sena") or die("Couldn't connect");

// Verificar conexión
if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}
?>

