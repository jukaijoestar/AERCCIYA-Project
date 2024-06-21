<?php
include("../model/config.php");

$centroId = $_GET['centro_id'];

try {
    $stmt = $pdo->prepare("SELECT id, nombre FROM formacion WHERE centro_id = ?");
    $stmt->execute([$centroId]);
    $formaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($formaciones);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
