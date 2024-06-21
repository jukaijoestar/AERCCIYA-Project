<?php
session_start();
include("../model/config.php"); // Asegúrate de que la ruta sea correcta

header('Content-Type: application/json');

function handleError($errno, $errstr, $errfile, $errline) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => "$errstr in $errfile on line $errline"]);
    exit;
}

set_error_handler('handleError');
set_exception_handler(function($e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit;
});

if (!isset($_SESSION['valid'])) {
    echo json_encode(['success' => false, 'message' => 'No estás autorizado.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numeroFicha = $_POST['numeroFicha'];
    $nombreFicha = $_POST['nombreFicha'];
    $formacionId = $_POST['formacion'];
    $centroId = $_POST['centro'];
    $modalidadId = $_POST['modalidad'];

    if (!$con) {
        echo json_encode(['success' => false, 'message' => 'Error en la conexión: ' . mysqli_connect_error()]);
        exit;
    }

    $sql = "INSERT INTO ficha (Numero_Ficha, Nombre_Ficha, formacion_id, centro_id, modalidad_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('issii', $numeroFicha, $nombreFicha, $formacionId, $centroId, $modalidadId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conn->error]);
    }

    $con->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no permitido.']);
}
?>