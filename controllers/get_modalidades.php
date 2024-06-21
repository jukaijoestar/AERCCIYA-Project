<?php
include("../model/config.php");

$formacionId = $_GET['formacion_id'];

try {
    $stmt = $pdo->prepare("SELECT id, nombre FROM modalidad WHERE formacion_id = ?");
    $stmt->execute([$formacionId]);
    $modalidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($modalidades);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
