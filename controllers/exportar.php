<?php
require_once '../vendor/autoload.php';

use PhpOffice\PhpWord\TemplateProcessor;

// Verificar si se recibieron los datos del comité extraordinario, observaciones y anotaciones
if (
    isset($_GET['id']) && isset($_GET['acta_num']) && isset($_GET['nombre']) &&
    isset($_GET['fecha']) && isset($_GET['fecha_actividad']) && isset($_GET['hora_inicio']) && isset($_GET['hora_fin']) &&
    isset($_GET['agendas']) && isset($_GET['objetivo']) && isset($_GET['desarrollo']) && isset($_GET['integrantes']) &&
    isset($_GET['responsable']) && isset($_GET['tipo_documento']) && isset($_GET['numero_documento']) &&
    isset($_GET['nombre_completo']) && isset($_GET['apellido_completo']) && isset($_GET['contenido']) &&
    isset($_GET['anotaciones_tipo_documento']) && isset($_GET['anotaciones_numero_documento']) &&
    isset($_GET['anotaciones_nombre_completo']) && isset($_GET['anotaciones_apellido_completo']) && isset($_GET['anotaciones_contenido'])
) {
    // Obtener los datos del GET
    $id_extraordinario = $_GET['id'];
    $acta_num = $_GET['acta_num'];
    $nombre = $_GET['nombre'];
    $fecha = $_GET['fecha'];
    $hora_inicio = $_GET['hora_inicio'];
    $hora_fin = $_GET['hora_fin'];
    $agendas = $_GET['agendas'];
    $objetivo = $_GET['objetivo'];
    $desarrollo = $_GET['desarrollo'];
    $integrantes = $_GET['integrantes'];
    $responsable = $_GET['responsable'];
    $tipo_documento = explode(",", $_GET['tipo_documento']);
    $numero_documento = explode(",", $_GET['numero_documento']);
    $nombre_completo = explode(",", $_GET['nombre_completo']);
    $apellido_completo = explode(",", $_GET['apellido_completo']);
    $contenido = explode(",", $_GET['contenido']);
    $fecha_actividad = $_GET['fecha_actividad'];

    $anotaciones_tipo_documento = explode(",", $_GET['anotaciones_tipo_documento']);
    $anotaciones_numero_documento = explode(",", $_GET['anotaciones_numero_documento']);
    $anotaciones_nombre_completo = explode(",", $_GET['anotaciones_nombre_completo']);
    $anotaciones_apellido_completo = explode(",", $_GET['anotaciones_apellido_completo']);
    $anotaciones_contenido = explode(",", $_GET['anotaciones_contenido']);

    // Función para limpiar y decodificar en UTF-8
    function cleanAndDecode($data)
    {
        return array_map('urldecode', $data);
    }

    // Asegurar que los datos estén en UTF-8
    function ensureUtf8($data)
    {
        return array_map(function ($item) {
            return mb_convert_encoding($item, 'UTF-8', 'auto');
        }, $data);
    }

    // Limpiar y decodificar los datos
    $tipo_documento = cleanAndDecode($tipo_documento);
    $numero_documento = cleanAndDecode($numero_documento);
    $nombre_completo = cleanAndDecode($nombre_completo);
    $apellido_completo = cleanAndDecode($apellido_completo);
    $contenido = cleanAndDecode($contenido);

    $anotaciones_tipo_documento = cleanAndDecode($anotaciones_tipo_documento);
    $anotaciones_numero_documento = cleanAndDecode($anotaciones_numero_documento);
    $anotaciones_nombre_completo = cleanAndDecode($anotaciones_nombre_completo);
    $anotaciones_apellido_completo = cleanAndDecode($anotaciones_apellido_completo);
    $anotaciones_contenido = cleanAndDecode($anotaciones_contenido);

    // Asegurar que todos los datos estén en UTF-8
    $tipo_documento = ensureUtf8($tipo_documento);
    $numero_documento = ensureUtf8($numero_documento);
    $nombre_completo = ensureUtf8($nombre_completo);
    $apellido_completo = ensureUtf8($apellido_completo);
    $contenido = ensureUtf8($contenido);

    $anotaciones_tipo_documento = ensureUtf8($anotaciones_tipo_documento);
    $anotaciones_numero_documento = ensureUtf8($anotaciones_numero_documento);
    $anotaciones_nombre_completo = ensureUtf8($anotaciones_nombre_completo);
    $anotaciones_apellido_completo = ensureUtf8($anotaciones_apellido_completo);
    $anotaciones_contenido = ensureUtf8($anotaciones_contenido);

    // Formatear la fecha
    $fecha_formateada = date('j', strtotime($fecha)) . ' de ';
    $mes = date('n', strtotime($fecha));
    $meses = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    $fecha_formateada .= $meses[$mes - 1] . ' del ';
    $fecha_formateada .= date('Y', strtotime($fecha));

    // Formatear la fecha de Fecha_Actividad
    $fecha_actividad_formateada = date('j', strtotime($fecha_actividad)) . ' de ';
    $mes_actividad = date('n', strtotime($fecha_actividad));
    $fecha_actividad_formateada .= $meses[$mes_actividad - 1] . ' del ';
    $fecha_actividad_formateada .= date('Y', strtotime($fecha_actividad));

    // Formatear la hora a formato am/pm
    $hora_inicio_formateada = date('h:i A', strtotime($hora_inicio));
    $hora_fin_formateada = date('h:i A', strtotime($hora_fin));

    // Plantilla de Word
    $templateFile = '../static/templates/Acta_Comite_extraordinario_Template.docx';

    // Crear un objeto TemplateProcessor
    $templateProcessor = new TemplateProcessor($templateFile);

    // Asignar valores a la plantilla
    $templateProcessor->setValue('Acta_Num', $acta_num);
    $templateProcessor->setValue('Nombre', $nombre);
    $templateProcessor->setValue('Fecha', $fecha_formateada);
    $templateProcessor->setValue('Hora_inicio', $hora_inicio_formateada);
    $templateProcessor->setValue('Hora_fin', $hora_fin_formateada);
    $templateProcessor->setValue('Agendas', $agendas);
    $templateProcessor->setValue('Objetivo', $objetivo);
    $templateProcessor->setValue('Desarrollo', $desarrollo);
    $templateProcessor->setValue('Integrantes', $integrantes);
    $templateProcessor->setValue('Responsable', $responsable);

    // Añadir filas a la tabla de observaciones
    $count = count($tipo_documento);
    $templateProcessor->cloneRow('Tip_Doc', $count);
    for ($i = 0; $i < $count; $i++) {
        $row_index = $i + 1;
        $templateProcessor->setValue("Tip_Doc#{$row_index}", $tipo_documento[$i]);
        $templateProcessor->setValue("Num_Doc#{$row_index}", $numero_documento[$i]);
        $templateProcessor->setValue("Nom_Comp#{$row_index}", $nombre_completo[$i]);
        $templateProcessor->setValue("Ap_Comp#{$row_index}", $apellido_completo[$i]);
        $templateProcessor->setValue("Contenido#{$row_index}", $contenido[$i]);
    }

    // Filtrar y clasificar anotaciones
    $reconocimientos = [];
    $remisiones = [];
    $llamados = [];
    for ($i = 0; $i < count($anotaciones_contenido); $i++) {
        $nombre_completo_aprendiz = $anotaciones_nombre_completo[$i] . ' ' . $anotaciones_apellido_completo[$i];
        switch (strtolower($anotaciones_contenido[$i])) {
            case 'reconocimiento':
                $reconocimientos[] = $nombre_completo_aprendiz;
                break;
            case 'remision':
                $remisiones[] = $nombre_completo_aprendiz . " (Remisión a orientación psicológica)";
                break;
            case 'llamado':
                $llamados[] = $nombre_completo_aprendiz;
                break;
        }
    }

    // Asignar valores de anotaciones a la plantilla
    $templateProcessor->setValue('reconocimientos', implode(', ', $reconocimientos));
    $templateProcessor->setValue('remisiones', implode(', ', $remisiones));
    $templateProcessor->setValue('llamados', implode(', ', $llamados));

    // Guardar el documento generado en memoria
    $temp_file = tempnam(sys_get_temp_dir(), 'Word');
    $templateProcessor->saveAs($temp_file);

    // Enviar el archivo al navegador para su descarga
    header('Content-Description: File Transfer');
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment; filename="' . basename($nombre . '.docx') . '"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($temp_file));
    readfile($temp_file);

    // Eliminar el archivo temporal
    unlink($temp_file);
    exit;
} else {
    echo "No se recibieron todos los datos necesarios para generar el documento.";
}