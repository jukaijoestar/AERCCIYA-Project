<?php
include("../model/config.php");

try {
    $stmt = $pdo->query("SELECT id, nombre FROM regional");
    $regionales = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($regionales);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
