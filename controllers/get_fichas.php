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

// Verificar que se reciban los parámetros necesarios
$id_centro = isset($_POST['id_centro']) ? $_POST['id_centro'] : null;
$modalidad_id = isset($_POST['modalidad_id']) ? $_POST['modalidad_id'] : null;
$formacion_id = isset($_POST['formacion_id']) ? $_POST['formacion_id'] : null;

if ($id_centro) {
    // Construir la consulta SQL dinámica
    $sql = "SELECT ID_Ficha, Numero_Ficha, Nombre_Ficha FROM ficha WHERE centro_id = :id_centro";
    $params = ['id_centro' => $id_centro];

    if ($modalidad_id) {
        $sql .= " AND modalidad_id = :modalidad_id";
        $params['modalidad_id'] = $modalidad_id;
    }

    if ($formacion_id) {
        $sql .= " AND formacion_id = :formacion_id";
        $params['formacion_id'] = $formacion_id;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $fichas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Console log para depuración
    echo "<script>console.log('Datos obtenidos: " . json_encode($fichas) . "');</script>";

    if ($fichas) {
        echo '<option value="">Seleccionar Ficha</option>';
        foreach ($fichas as $ficha) {
            echo '<option value="' . $ficha['ID_Ficha'] . '">' . $ficha['Numero_Ficha'] . ' - ' . $ficha['Nombre_Ficha'] . '</option>';
        }
    } else {
        echo '<option value="">No se encontraron fichas</option>';
    }
} else {
    echo '<option value="">No se encontró el centro</option>';
}
?>