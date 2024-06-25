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

        // Consulta para obtener las observaciones relacionadas
        $sql_observaciones = "SELECT o.Contenido, a.Tipo_Documento, a.Numero_Documento, a.Primer_Nombre, a.Segundo_Nombre, a.Primer_Apellido, a.Segundo_Apellido
                              FROM observaciones o
                              JOIN aprendiz a ON o.ID_Aprendiz = a.ID_Aprendiz
                              WHERE o.ID_extraordinario = $id_extraordinario";
        $result_observaciones = mysqli_query($con, $sql_observaciones);

        $observaciones_tipo_documento = [];
        $observaciones_numero_documento = [];
        $observaciones_nombre_completo = [];
        $observaciones_apellido_completo = [];
        $observaciones_contenido = [];

        while ($row_obs = mysqli_fetch_assoc($result_observaciones)) {
            $tipo_documento = $row_obs['Tipo_Documento'];
            $numero_documento = $row_obs['Numero_Documento'];
            $primer_nombre = $row_obs['Primer_Nombre'];
            $segundo_nombre = $row_obs['Segundo_Nombre'];
            $primer_apellido = $row_obs['Primer_Apellido'];
            $segundo_apellido = $row_obs['Segundo_Apellido'];

            // Generar nombre completo separado
            $nombre_completo = $primer_nombre . ' ' . ($segundo_nombre ? $segundo_nombre . ' ' : '');
            $apellido_completo = $primer_apellido . ' ' . $segundo_apellido;

            // Almacenar datos en arrays
            $observaciones_tipo_documento[] = $tipo_documento;
            $observaciones_numero_documento[] = $numero_documento;
            $observaciones_nombre_completo[] = $nombre_completo;
            $observaciones_apellido_completo[] = $apellido_completo;
            $observaciones_contenido[] = $row_obs['Contenido'];
        }

        // Consulta para obtener las anotaciones relacionadas
        $sql_anotaciones = "SELECT a.A_Contenido, ap.Tipo_Documento, ap.Numero_Documento, ap.Primer_Nombre, ap.Segundo_Nombre, ap.Primer_Apellido, ap.Segundo_Apellido
                            FROM anotaciones a
                            JOIN aprendiz ap ON a.ID_Aprendiz = ap.ID_Aprendiz
                            WHERE a.ID_extraordinario = $id_extraordinario";
        $result_anotaciones = mysqli_query($con, $sql_anotaciones);

        $anotaciones_tipo_documento = [];
        $anotaciones_numero_documento = [];
        $anotaciones_nombre_completo = [];
        $anotaciones_apellido_completo = [];
        $anotaciones_contenido = [];

        while ($row_anot = mysqli_fetch_assoc($result_anotaciones)) {
            $tipo_documento = $row_anot['Tipo_Documento'];
            $numero_documento = $row_anot['Numero_Documento'];
            $primer_nombre = $row_anot['Primer_Nombre'];
            $segundo_nombre = $row_anot['Segundo_Nombre'];
            $primer_apellido = $row_anot['Primer_Apellido'];
            $segundo_apellido = $row_anot['Segundo_Apellido'];

            // Generar nombre completo separado
            $nombre_completo = $primer_nombre . ' ' . ($segundo_nombre ? $segundo_nombre . ' ' : '');
            $apellido_completo = $primer_apellido . ' ' . $segundo_apellido;

            // Almacenar datos en arrays
            $anotaciones_tipo_documento[] = $tipo_documento;
            $anotaciones_numero_documento[] = $numero_documento;
            $anotaciones_nombre_completo[] = $nombre_completo;
            $anotaciones_apellido_completo[] = $apellido_completo;
            $anotaciones_contenido[] = $row_anot['A_Contenido'];
        }

        // Redirigir a exportar.php con los datos obtenidos
        $observaciones_tipo_documento_encoded = implode(",", array_map('urlencode', $observaciones_tipo_documento));
        $observaciones_numero_documento_encoded = implode(",", array_map('urlencode', $observaciones_numero_documento));
        $observaciones_nombre_completo_encoded = implode(",", array_map('urlencode', $observaciones_nombre_completo));
        $observaciones_apellido_completo_encoded = implode(",", array_map('urlencode', $observaciones_apellido_completo));
        $observaciones_contenido_encoded = implode(",", array_map('urlencode', $observaciones_contenido));

        $anotaciones_tipo_documento_encoded = implode(",", array_map('urlencode', $anotaciones_tipo_documento));
        $anotaciones_numero_documento_encoded = implode(",", array_map('urlencode', $anotaciones_numero_documento));
        $anotaciones_nombre_completo_encoded = implode(",", array_map('urlencode', $anotaciones_nombre_completo));
        $anotaciones_apellido_completo_encoded = implode(",", array_map('urlencode', $anotaciones_apellido_completo));
        $anotaciones_contenido_encoded = implode(",", array_map('urlencode', $anotaciones_contenido));

        header("Location: exportar.php?id=$id_extraordinario&acta_num=$acta_num&nombre=$nombre&fecha=$fecha&hora_inicio=$hora_inicio&hora_fin=$hora_fin&agendas=$agendas&objetivo=$objetivo&desarrollo=$desarrollo&responsable=$responsable&tipo_documento=$observaciones_tipo_documento_encoded&numero_documento=$observaciones_numero_documento_encoded&nombre_completo=$observaciones_nombre_completo_encoded&apellido_completo=$observaciones_apellido_completo_encoded&contenido=$observaciones_contenido_encoded&anotaciones_tipo_documento=$anotaciones_tipo_documento_encoded&anotaciones_numero_documento=$anotaciones_numero_documento_encoded&anotaciones_nombre_completo=$anotaciones_nombre_completo_encoded&anotaciones_apellido_completo=$anotaciones_apellido_completo_encoded&anotaciones_contenido=$anotaciones_contenido_encoded");
        exit;
    } else {
        echo "No se encontraron datos para el ID proporcionado.";
    }
} else {
    echo "ID no proporcionado.";
}
?>