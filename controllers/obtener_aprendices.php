<?php
include("../model/config.php");

if (isset($_POST['id_ficha'])) {
    $id_ficha = $_POST['id_ficha'];

    // Inicialización de la conexión PDO
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=comite_sena', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo json_encode(['error' => "Error de conexión: " . $e->getMessage()]);
        exit();
    }

    // Obtener aprendices
    $stmt = $pdo->prepare("SELECT * FROM aprendiz WHERE ID_Ficha = :id_ficha");
    $stmt->execute(['id_ficha' => $id_ficha]);
    $aprendices = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($aprendices);
} else {
    echo json_encode(['error' => 'ID de ficha no proporcionado']);
}
?>