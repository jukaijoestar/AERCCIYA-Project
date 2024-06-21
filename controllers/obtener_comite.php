<?php
session_start();
include("../model/config.php");

header('Content-Type: application/json');

if (!isset($_SESSION['valid'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID de comité no proporcionado']);
    exit();
}

$id = $con->real_escape_string($_GET['id']);

$query = "SELECT * FROM comite WHERE id = '$id'";
$result = $con->query($query);

if ($result && $result->num_rows > 0) {
    $comite = $result->fetch_assoc();
    echo json_encode(['success' => true, 'comite' => $comite]);
} else {
    echo json_encode(['success' => false, 'message' => 'Comité no encontrado']);
}
?>
