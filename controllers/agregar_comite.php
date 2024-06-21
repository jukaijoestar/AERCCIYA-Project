<?php
session_start();
header('Content-Type: application/json');

include("../model/config.php");

// Inicializar respuesta
$response = ["success" => false];

// Verificar si la sesión es válida
if (!isset($_SESSION['valid'])) {
    $response['message'] = "Sesión no válida.";
    echo json_encode($response);
    exit();
}

// Verificar si los datos del comité se han enviado correctamente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_ficha']) && isset($_POST['idAprendizComite']) && isset($_POST['descripcionComite']) && isset($_POST['num_comite'])) {
        $id_ficha = $_POST['id_ficha'];
        $id_aprendiz = $_POST['idAprendizComite'];
        $descripcion = $_POST['descripcionComite'];
        $num_comite = $_POST['num_comite'];

        // Preparar la consulta SQL para insertar datos del comité
        $stmt = $con->prepare("INSERT INTO comite (id_aprendiz, id_ficha, descripcion, num) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            $response['message'] = "Prepare failed: " . $con->error;
            echo json_encode($response);
            exit();
        }

        // Enlazar los parámetros con los valores del formulario
        $stmt->bind_param("iisi", $id_aprendiz, $id_ficha, $descripcion, $num_comite);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $response['success'] = true;
        } else {
            $response['message'] = "Execute failed: " . $stmt->error;
        }

        // Cerrar la declaración preparada
        $stmt->close();
    } else {
        $response['message'] = "Todos los campos son obligatorios.";
    }
} else {
    $response['message'] = "Invalid request method.";
}

echo json_encode($response);
exit();
?>
