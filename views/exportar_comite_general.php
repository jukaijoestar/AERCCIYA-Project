<?php
// Incluir la biblioteca de PhpSpreadsheet y PhpWord
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

// Verificar si se envió un formato válido
if (isset($_POST['formato']) && ($_POST['formato'] === 'excel' || $_POST['formato'] === 'word')) {
    // Crear una instancia del documento según el formato elegido
    if ($_POST['formato'] === 'excel') {
        // Crear una instancia de Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Configurar los encabezados
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nombre del Comité o Reunión');
        $sheet->setCellValue('C1', 'Fecha');
        $sheet->setCellValue('D1', 'Hora Inicio');
        $sheet->setCellValue('E1', 'Hora Fin');
        $sheet->setCellValue('F1', 'Lugar');
        $sheet->setCellValue('G1', 'Dirección');
        $sheet->setCellValue('H1', 'Puntos Destacados');
        $sheet->setCellValue('I1', 'Objetivos');

        // Obtener los datos de la base de datos
        include("../model/config.php");
        $query = "SELECT * FROM comite_general";
        $result = $con->query($query);

        if ($result->num_rows > 0) {
            $rowIndex = 2;
            while ($row = $result->fetch_assoc()) {
                $sheet->setCellValue('A' . $rowIndex, $row['id']);
                $sheet->setCellValue('B' . $rowIndex, $row['nombre']);
                $sheet->setCellValue('C' . $rowIndex, $row['fecha']);
                $sheet->setCellValue('D' . $rowIndex, $row['hora_inicio']);
                $sheet->setCellValue('E' . $rowIndex, $row['hora_fin']);
                $sheet->setCellValue('F' . $rowIndex, $row['lugar']);
                $sheet->setCellValue('G' . $rowIndex, $row['direccion']);
                $sheet->setCellValue('H' . $rowIndex, $row['puntos_destacados']);
                $sheet->setCellValue('I' . $rowIndex, $row['objetivos']);
                $rowIndex++;
            }
        }

        // Crear un objeto Writer para guardar el archivo Excel
        $writer = new Xlsx($spreadsheet);

        // Guardar el archivo en el servidor
        $filename = 'lista_comites_generales.xlsx';
        $writer->save($filename);
    } elseif ($_POST['formato'] === 'word') {
        // Crear una instancia de PhpWord
        $phpWord = new PhpWord();

        // Crear una sección y un texto simple para el documento Word
        $section = $phpWord->addSection();
        $section->addText('ID | Nombre del Comité o Reunión | Fecha | Hora Inicio | Hora Fin | Lugar | Dirección | Puntos Destacados | Objetivos');

        // Obtener los datos de la base de datos
        include("../model/config.php");
        $query = "SELECT * FROM comite_general";
        $result = $con->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $text = $row['id'] . ' | ' . $row['nombre'] . ' | ' . $row['fecha'] . ' | ' . $row['hora_inicio'] . ' | ' . $row['hora_fin'] . ' | ' . $row['lugar'] . ' | ' . $row['direccion'] . ' | ' . $row['puntos_destacados'] . ' | ' . $row['objetivos'];
                $section->addText($text);
            }
        }

        // Guardar el archivo en el servidor
        $filename = 'lista_comites_generales.docx';

        // Asegúrate de usar PclZip
        \PhpOffice\PhpWord\Settings::setZipClass(\PhpOffice\PhpWord\Settings::PCLZIP);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filename);
    }

    // Descargar el archivo
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    readfile($filename);
    exit;
} else {
    // Si no se proporcionó un formato válido, redirigir de vuelta a la página anterior
    header("Location: lista_comite_general.php");
    exit();
}
?>
