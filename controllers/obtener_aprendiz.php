<?php

$con = mysqli_connect("localhost", "root", "", "comite_sena") or die("Couldn't connect");

// Verificar conexión
if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}
// Verificar si se recibió el ID de la ficha
if (isset($_GET['id_ficha'])) {
    $id_ficha = $_GET['id_ficha'];

    try {
        // Preparar la conexión PDO
        $pdo = new PDO('mysql:host=localhost;dbname=comite_sena', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Obtener el número de ficha
        $stmt_ficha = $pdo->prepare("SELECT Numero_Ficha FROM ficha WHERE ID_Ficha = :id_ficha");
        $stmt_ficha->execute(['id_ficha' => $id_ficha]);
        $ficha = $stmt_ficha->fetch(PDO::FETCH_ASSOC);

        if ($ficha) {
            $numero_ficha = $ficha['Numero_Ficha'];

            // Obtener los aprendices asociados a la ficha
            $stmt_aprendices = $pdo->prepare("SELECT * FROM aprendiz WHERE ID_Ficha = :id_ficha");
            $stmt_aprendices->execute(['id_ficha' => $id_ficha]);
            $aprendices = $stmt_aprendices->fetchAll(PDO::FETCH_ASSOC);

            // Construir la respuesta en formato JSON
            $response = [
                'numero_ficha' => $numero_ficha,
                'aprendices' => $aprendices
            ];

            // Devolver la respuesta como JSON
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            // Si no se encuentra la ficha
            echo json_encode(['error' => 'Ficha no encontrada']);
        }
    } catch (PDOException $e) {
        // Manejar errores de conexión o consultas
        echo json_encode(['error' => 'Error de conexión: ' . $e->getMessage()]);
    }
} else {
    // Si no se proporcionó el ID de la ficha
    echo json_encode(['error' => 'ID de ficha no proporcionado']);
}
