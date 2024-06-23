<?php
require_once '../vendor/autoload.php';
use PhpOffice\PhpWord\TemplateProcessor;

// Verificar si se recibieron los datos del comité extraordinario
if (
    isset($_GET['id']) && isset($_GET['acta_num']) && isset($_GET['nombre']) &&
    isset($_GET['fecha']) && isset($_GET['hora_inicio']) && isset($_GET['hora_fin']) &&
    isset($_GET['agendas']) && isset($_GET['objetivo']) && isset($_GET['desarrollo']) &&
    isset($_GET['responsable'])
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
    $outputFile = 'Comite Extraordinario ' . $id_extraordinario . '.docx';

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
    $templateProcessor->setValue('Responsable', $responsable);

    // Guardar el documento generado
    $templateProcessor->saveAs($outputFile);

    // Descargar el archivo generado
    header("Content-Disposition: attachment; filename=$outputFile");
    readfile($outputFile);
    exit;
} else {
    echo "No se recibieron todos los datos necesarios para generar el documento.";
}
?>