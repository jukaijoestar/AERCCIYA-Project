<?php
session_start();
include("../model/config.php");
header('Content-Type: application/json');

if (!isset($_SESSION['valid'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$id = isset($data['id']) ? $con->real_escape_string($data['id']) : '';

if (empty($id)) {
    echo json_encode(['success' => false, 'message' => 'ID de comité no proporcionado']);
    exit();
}

$query = "DELETE FROM comite WHERE id = '$id'";
if ($con->query($query) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al eliminar el comité: ' . $con->error]);
}
?>
