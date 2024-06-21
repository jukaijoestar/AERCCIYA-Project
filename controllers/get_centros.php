<?php
session_start();
include("../model/config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: ../index.php");
    exit();
}

// Inicialización de la conexión PDO
try {
    $pdo = new PDO('mysql:host=localhost;dbname=comite_sena', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    die();
}

// Unificación de las verificaciones de id_regional
if (isset($_POST['id_regional']) || isset($_POST['regional_id'])) {
    $id_regional = isset($_POST['id_regional']) ? $_POST['id_regional'] : $_POST['regional_id'];
    $stmt = $pdo->prepare("SELECT id, nombre FROM centro WHERE regional_id = :id_regional");
    $stmt->execute(['id_regional' => $id_regional]);
    $centros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($centros) {
        echo '<option value="">Seleccionar Centro</option>';
        foreach ($centros as $centro) {
            echo '<option value="' . $centro['id'] . '">' . $centro['nombre'] . '</option>';
        }
    } else {
        echo '<option value="">No se encontraron centros</option>';
    }
} else {
    echo '<option value="">No se encontró la regional</option>';
}
?>
