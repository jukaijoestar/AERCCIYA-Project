<?php
require_once '../vendor/autoload.php';
use PhpOffice\PhpWord\TemplateProcessor;

// Verificar si se recibieron los datos del comité extraordinario, observaciones y anotaciones
if (
    isset($_GET['id']) && isset($_GET['acta_num']) && isset($_GET['nombre']) &&
    isset($_GET['fecha']) && isset($_GET['hora_inicio']) && isset($_GET['hora_fin']) &&
    isset($_GET['agendas']) && isset($_GET['objetivo']) && isset($_GET['desarrollo']) &&
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
    $responsable = $_GET['responsable'];
    $tipo_documento = explode(",", $_GET['tipo_documento']);
    $numero_documento = explode(",", $_GET['numero_documento']);
    $nombre_completo = explode(",", $_GET['nombre_completo']);
    $apellido_completo = explode(",", $_GET['apellido_completo']);
    $contenido = explode(",", $_GET['contenido']);

    $anotaciones_tipo_documento = explode(",", $_GET['anotaciones_tipo_documento']);
    $anotaciones_numero_documento = explode(",", $_GET['anotaciones_numero_documento']);
    $anotaciones_nombre_completo = explode(",", $_GET['anotaciones_nombre_completo']);
    $anotaciones_apellido_completo = explode(",", $_GET['anotaciones_apellido_completo']);
    $anotaciones_contenido = explode(",", $_GET['anotaciones_contenido']);

    // Función para limpiar y decodificar en UTF-8
    function cleanAndDecode($data) {
        return array_map('utf8_decode', array_map('urldecode', $data));
    }

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

    // Formatear la fecha
    $fecha_formateada = date('j', strtotime($fecha)) . ' de ';
    $mes = date('n', strtotime($fecha));
    $meses = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    $fecha_formateada .= $meses[$mes - 1] . ' del ';
    $fecha_formateada .= date('Y', strtotime($fecha));

    // Formatear la hora a formato am/pm
    $hora_inicio_formateada = date('h:i A', strtotime($hora_inicio));
    $hora_fin_formateada = date('h:i A', strtotime($hora_fin));

    // Plantilla de Word
    $templateFile = '../static/templates/Acta_Comite_extraordinario_Template.docx';
    $outputFile = $nombre . '.docx';

    // Crear un objeto TemplateProcessor
    $templateProcessor = new TemplateProcessor($templateFile);

    // Asignar valores a la plantilla
    $templateProcessor->setValue('Acta_Num', utf8_encode($acta_num));
    $templateProcessor->setValue('Nombre', utf8_encode($nombre));
    $templateProcessor->setValue('Fecha', utf8_encode($fecha_formateada));
    $templateProcessor->setValue('Hora_inicio', utf8_encode($hora_inicio_formateada));
    $templateProcessor->setValue('Hora_fin', utf8_encode($hora_fin_formateada));
    $templateProcessor->setValue('Agendas', utf8_encode($agendas));
    $templateProcessor->setValue('Objetivo', utf8_encode($objetivo));
    $templateProcessor->setValue('Desarrollo', utf8_encode($desarrollo));
    $templateProcessor->setValue('Responsable', utf8_encode($responsable));

    // Añadir filas a la tabla de observaciones
    $count = count($tipo_documento);
    $templateProcessor->cloneRow('Tip_Doc', $count);
    for ($i = 0; $i < $count; $i++) {
        $row_index = $i + 1;
        $templateProcessor->setValue("Tip_Doc#{$row_index}", utf8_encode($tipo_documento[$i]));
        $templateProcessor->setValue("Num_Doc#{$row_index}", utf8_encode($numero_documento[$i]));
        $templateProcessor->setValue("Nom_Comp#{$row_index}", utf8_encode($nombre_completo[$i]));
        $templateProcessor->setValue("Ap_Comp#{$row_index}", utf8_encode($apellido_completo[$i]));
        $templateProcessor->setValue("Contenido#{$row_index}", utf8_encode($contenido[$i]));
    }

    // Filtrar y clasificar anotaciones
    $reconocimientos = [];
    $remisiones = [];
    $llamados = [];
    for ($i = 0; $i < count($anotaciones_contenido); $i++) {
        $nombre_completo_aprendiz = utf8_encode($anotaciones_nombre_completo[$i]) . ' ' . utf8_encode($anotaciones_apellido_completo[$i]);
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

    // Guardar el documento generado
    $templateProcessor->saveAs($outputFile);

    // Descargar el archivo generado
    header("Content-Disposition: attachment; filename=\"$outputFile\"");
    readfile($outputFile);
    exit;
} else {
    echo "No se recibieron todos los datos necesarios para generar el documento.";
}
?>