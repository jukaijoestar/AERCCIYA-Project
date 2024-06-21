<?php
include("../model/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_aprendiz = $_POST['id_aprendiz'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $numero_documento = $_POST['numero_documento'];
    $nombre_completo = $_POST['nombre_completo'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];

    // Separamos el nombre completo en partes
    $nombres = explode(" ", $nombre_completo);
    $primer_nombre = $nombres[0];
    $segundo_nombre = isset($nombres[1]) ? $nombres[1] : "";
    $primer_apellido = isset($nombres[2]) ? $nombres[2] : "";
    $segundo_apellido = isset($nombres[3]) ? $nombres[3] : "";

    $query = "UPDATE aprendiz SET Numero_Documento='$numero_documento', Tipo_Documento='$tipoDocumento', Primer_Nombre='$primer_nombre', Segundo_Nombre='$segundo_nombre', Primer_Apellido='$primer_apellido', Segundo_Apellido='$segundo_apellido', Email='$email', Telefono='$telefono' WHERE ID_Aprendiz='$id_aprendiz'";

    if ($con->query($query) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $con->error]);
    }
}
?>