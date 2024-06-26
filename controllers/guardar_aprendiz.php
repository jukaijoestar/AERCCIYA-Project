<?php

$con = mysqli_connect("localhost", "root", "", "comite_sena") or die("Couldn't connect");

// Verificar conexión
if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}

// Verificar si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $documento = $_POST['documento'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $primerNombre = $_POST['primerNombre'];
    $segundoNombre = $_POST['segundoNombre'];
    $primerApellido = $_POST['primerApellido'];
    $segundoApellido = $_POST['segundoApellido'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $id_ficha = $_POST['id_ficha']; // Obtener el ID de la ficha desde el formulario POST

    // Procesar la imagen si se subió correctamente
    if (!empty($_FILES['imagen']['name'])) {
        $imagen = $_FILES['imagen']['name'];
        $imagen_temp = $_FILES['imagen']['tmp_name'];
        $upload_dir = '../public/img/';
        $target_file = $upload_dir . basename($imagen);

        // Intentar mover la imagen al directorio final
        if (move_uploaded_file($imagen_temp, $target_file)) {
            // Preparar la consulta SQL para insertar el aprendiz
            $query = "INSERT INTO aprendiz (Tipo_Documento, Numero_Documento, Primer_Nombre, Segundo_Nombre, Primer_Apellido, Segundo_Apellido, Email, Telefono, Imagen, ID_Ficha)
                      VALUES ('$tipoDocumento', '$documento', '$primerNombre', '$segundoNombre', '$primerApellido', '$segundoApellido', '$email', '$telefono', '$imagen', '$id_ficha')";

            // Ejecutar la consulta
            if ($con->query($query)) {
                // Preparar la respuesta JSON
                $response = array(
                    'success' => true,
                    'message' => 'Aprendiz guardado exitosamente'
                );
                echo json_encode($response);
            } else {
                // Preparar la respuesta JSON en caso de error
                $response = array(
                    'success' => false,
                    'message' => 'Error al guardar el aprendiz: ' . $con->error
                );
                echo json_encode($response);
            }
        } else {
            // Preparar la respuesta JSON en caso de error al subir la imagen
            $response = array(
                'success' => false,
                'message' => 'Error al subir la imagen'
            );
            echo json_encode($response);
        }
    } else {
        // Preparar la respuesta JSON en caso de que no se seleccione una imagen
        $response = array(
            'success' => false,
            'message' => 'Error: Debes seleccionar una imagen'
        );
        echo json_encode($response);
    }
} else {
    // Si la solicitud no es POST, devolver un mensaje de acceso no autorizado
    $response = array(
        'success' => false,
        'message' => 'Acceso no autorizado'
    );
    echo json_encode($response);
}

// Cerrar conexión a la base de datos
$con->close();
