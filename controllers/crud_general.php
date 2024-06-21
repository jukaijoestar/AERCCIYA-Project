<?php
session_start();
include("../model/config.php");

header('Content-Type: application/json');

if (!isset($_SESSION['valid'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'obtener' && isset($_GET['id'])) {
    $id = $con->real_escape_string($_GET['id']);
    $query = "SELECT * FROM comite_general WHERE id = '$id'";
    $result = $con->query($query);

    if ($result && $result->num_rows > 0) {
        $comite = $result->fetch_assoc();
        echo json_encode(['success' => true, 'id' => $comite['id'], 'nombre' => $comite['nombre'], 'fecha' => $comite['fecha'],
                          'hora_inicio' => $comite['hora_inicio'], 'hora_fin' => $comite['hora_fin'], 'lugar' => $comite['lugar'],
                          'direccion' => $comite['direccion'], 'puntos_destacados' => $comite['puntos_destacados'], 'objetivos' => $comite['objetivos']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Comité no encontrado']);
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'editar':
            if (!isset($_POST['datos'])) {
                echo json_encode(['success' => false, 'message' => 'Datos no proporcionados']);
                exit();
            }
            $datos = json_decode($_POST['datos'], true);
            $id = $con->real_escape_string($datos['id']);
            $nombre = $con->real_escape_string($datos['nombre']);
            $fecha = $con->real_escape_string($datos['fecha']);
            $hora_inicio = $con->real_escape_string($datos['hora_inicio']);
            $hora_fin = $con->real_escape_string($datos['hora_fin']);
            $lugar = $con->real_escape_string($datos['lugar']);
            $direccion = $con->real_escape_string($datos['direccion']);
            $puntos_destacados = $con->real_escape_string($datos['puntos_destacados']);
            $objetivos = $con->real_escape_string($datos['objetivos']);

            $query = "UPDATE comite_general SET nombre = '$nombre', fecha = '$fecha', hora_inicio = '$hora_inicio',
                      hora_fin = '$hora_fin', lugar = '$lugar', direccion = '$direccion', puntos_destacados = '$puntos_destacados',
                      objetivos = '$objetivos' WHERE id = '$id'";
            
            if ($con->query($query) === TRUE) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar el comité: ' . $con->error]);
            }
            break;

        case 'eliminar':
            if (!isset($_POST['id'])) {
                echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
                exit();
            }
            $id = $con->real_escape_string($_POST['id']);
            $query = "DELETE FROM comite_general WHERE id = '$id'";
            
            if ($con->query($query) === TRUE) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al eliminar el comité: ' . $con->error]);
            }
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud no válida']);
}
?>
