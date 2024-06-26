<?php
session_start();

 
$con = mysqli_connect("localhost","root","","comite_sena") or die("Couldn't connect");

// Verificar conexión
if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}

header('Content-Type: application/json');

if (!isset($_SESSION['valid'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

$idAprendiz = isset($_POST['idAprendiz']) ? $con->real_escape_string($_POST['idAprendiz']) : '';
$idFicha = isset($_POST['idFicha']) ? $con->real_escape_string($_POST['idFicha']) : '';
$descripcion = isset($_POST['descripcion']) ? $con->real_escape_string($_POST['descripcion']) : '';
$num = isset($_POST['num']) ? $con->real_escape_string($_POST['num']) : '';

if (empty($idAprendiz) || empty($idFicha) || empty($descripcion) || empty($num)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son requeridos']);
    exit();
}

$query = "INSERT INTO comite (id_aprendiz, id_ficha, descripcion, num) VALUES ('$idAprendiz', '$idFicha', '$descripcion', '$num')";
if ($con->query($query) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar el comité: ' . $con->error]);
}
?>
