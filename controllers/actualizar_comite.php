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

$id = isset($_POST['editComiteId']) ? $_POST['editComiteId'] : '';
$idAprendiz = isset($_POST['editIdAprendiz']) ? $_POST['editIdAprendiz'] : '';
$idFicha = isset($_POST['editIdFicha']) ? $_POST['editIdFicha'] : '';
$descripcion = isset($_POST['editDescripcion']) ? $_POST['editDescripcion'] : '';
$num = isset($_POST['editNum']) ? $_POST['editNum'] : '';

if (empty($id) || empty($idAprendiz) || empty($idFicha) || empty($descripcion) || empty($num)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son requeridos']);
    exit();
}

// Consulta preparada para actualizar el comité
$query = "UPDATE comite SET id_aprendiz = ?, id_ficha = ?, descripcion = ?, num = ? WHERE id = ?";
$stmt = $con->prepare($query);

// Vincular parámetros
$stmt->bind_param('iisii', $idAprendiz, $idFicha, $descripcion, $num, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar el comité: ' . $stmt->error]);
}

$stmt->close();
$con->close();
?>
