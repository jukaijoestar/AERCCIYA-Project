<?php
// Incluir el archivo de configuración de la base de datos
include("../model/config.php");

// Verificar si se recibió un ID válido
if (isset($_GET['id'])) {
    $id_extraordinario = $_GET['id'];

    // Consulta para obtener los datos del comité extraordinario
    $sql = "SELECT * FROM comite_extraordinario WHERE ID_extraordinario = $id_extraordinario";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Obtener los datos del resultado de la consulta
        $row = mysqli_fetch_assoc($result);

        // Asignar los datos a variables para pasar a exportar.php
        $acta_num = $row['Acta_Num'];
        $nombre = $row['Nombre'];
        $fecha = $row['Fecha'];
        $hora_inicio = $row['Hora_inicio'];
        $hora_fin = $row['Hora_fin'];
        $agendas = $row['Agendas'];
        $objetivo = $row['Objetivo'];
        $desarrollo = $row['Desarrollo'];
        $responsable = $row['Responsable'];

        // Redirigir a exportar.php con los datos obtenidos
        header("Location: exportar.php?id=$id_extraordinario&acta_num=$acta_num&nombre=$nombre&fecha=$fecha&hora_inicio=$hora_inicio&hora_fin=$hora_fin&agendas=$agendas&objetivo=$objetivo&desarrollo=$desarrollo&responsable=$responsable");
        exit;
    } else {
        echo "No se encontraron datos para el ID proporcionado.";
    }
} else {
    echo "ID no proporcionado.";
}
?>
