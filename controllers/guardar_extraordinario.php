<?php
session_start();
include("../model/config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: ../index.php");
    exit();
}

header('Content-Type: application/json');

try {
    $pdo = new PDO('mysql:host=localhost;dbname=comite_sena', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Error de conexión: " . $e->getMessage()]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acta_num = $_POST['Acta'];
    $nombre = $_POST['nombre'];
    $fecha = $_POST['fecha'];
    $hora_inicio = $_POST['horaI'];
    $hora_fin = $_POST['horaF'];
    $agendas = $_POST['puntosD'];
    $objetivo = $_POST['objetivos'];
    $desarrollo = $_POST['desarrollo'];
    $id_ficha = $_POST['id_ficha'];

    // Guardar el archivo de asistentes
    $ruta_foto = '';
    if (isset($_FILES['asistentes']) && $_FILES['asistentes']['error'] == UPLOAD_ERR_OK) {
        $ruta_foto = '../uploads/' . basename($_FILES['asistentes']['name']);
        move_uploaded_file($_FILES['asistentes']['tmp_name'], $ruta_foto);
    }

    try {
        $pdo->beginTransaction();

        // Insertar en comite_extraordinario
        $stmt = $pdo->prepare("INSERT INTO comite_extraordinario (Acta_Num, Nombre, Fecha, Hora_inicio, Hora_fin, Agendas, Objetivo, Desarrollo, Actividad, Responsable, ruta_foto, ID_ficha) VALUES (:acta_num, :nombre, :fecha, :hora_inicio, :hora_fin, :agendas, :objetivo, :desarrollo, :actividad, :responsable, :ruta_foto, :id_ficha)");
        $stmt->execute([
            'acta_num' => $acta_num,
            'nombre' => $nombre,
            'fecha' => $fecha,
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin,
            'agendas' => $agendas,
            'objetivo' => $objetivo,
            'desarrollo' => $desarrollo,
            'actividad' => implode(', ', $_POST['actividad']),
            'responsable' => implode(', ', $_POST['responsable']),
            'ruta_foto' => $ruta_foto,
            'id_ficha' => $id_ficha
        ]);

        $id_extraordinario = $pdo->lastInsertId();

        // Insertar observaciones
        if (isset($_POST['observaciones']) && is_array($_POST['observaciones'])) {
            $stmt = $pdo->prepare("INSERT INTO observaciones (Contenido, ID_Aprendiz, ID_extraordinario) VALUES (:contenido, :id_aprendiz, :id_extraordinario)");
            foreach ($_POST['observaciones'] as $id_aprendiz => $contenido) {
                $stmt->execute([
                    'contenido' => $contenido,
                    'id_aprendiz' => $id_aprendiz,
                    'id_extraordinario' => $id_extraordinario
                ]);
            }
        }

        // Insertar anotaciones
        if (isset($_POST['accion']) && is_array($_POST['accion'])) {
            $stmt = $pdo->prepare("INSERT INTO anotaciones (A_Contenido, ID_Aprendiz, ID_extraordinario) VALUES (:contenido, :id_aprendiz, :id_extraordinario)");
            foreach ($_POST['accion'] as $id_aprendiz => $contenido) {
                $stmt->execute([
                    'contenido' => $contenido,
                    'id_aprendiz' => $id_aprendiz,
                    'id_extraordinario' => $id_extraordinario
                ]);
            }
        }

        $pdo->commit();
        echo json_encode(["status" => "success", "id" => $id_extraordinario, "message" => "Datos guardados exitosamente."]);
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(["status" => "error", "message" => "Error al guardar los datos: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método de solicitud no válido."]);
}
?>