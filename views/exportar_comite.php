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
        $sheet->setCellValue('B1', 'ID Aprendiz');
        $sheet->setCellValue('C1', 'ID Ficha');
        $sheet->setCellValue('D1', 'Descripción');
        $sheet->setCellValue('E1', 'Número');

        // Obtener los datos de la base de datos
        include("../model/config.php");
        $query = "SELECT * FROM comite";
        $result = $con->query($query);

        if ($result->num_rows > 0) {
            $rowIndex = 2;
            while ($row = $result->fetch_assoc()) {
                $sheet->setCellValue('A' . $rowIndex, $row['id']);
                $sheet->setCellValue('B' . $rowIndex, $row['id_aprendiz']);
                $sheet->setCellValue('C' . $rowIndex, $row['id_ficha']);
                $sheet->setCellValue('D' . $rowIndex, $row['descripcion']);
                $sheet->setCellValue('E' . $rowIndex, $row['num']);
                $rowIndex++;
            }
        }

        // Guardar el archivo en el servidor
        $filename = 'lista_comites.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        // Descargar el archivo
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        readfile($filename);
        exit;
    } elseif ($_POST['formato'] === 'word') {
        // Crear una instancia de PhpWord
        $phpWord = new PhpWord();

        // Crear una sección y un texto simple para el documento Word
        $section = $phpWord->addSection();
        $section->addText('ID    | ID Aprendiz    | ID Ficha    | Descripción    | Número');

        // Obtener los datos de la base de datos
        include("../model/config.php");
        $query = "SELECT * FROM comite";
        $result = $con->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $text = $row['id'] . ' | ' . $row['id_aprendiz'] . ' | ' . $row['id_ficha'] . ' | ' . $row['descripcion'] . ' | ' . $row['num'];
                $section->addText($text);
            }
        }

        // Guardar el archivo en el servidor
        $filename = 'lista_comites.docx';
        
        // Configurar el uso de PclZip para PhpWord si es necesario
        \PhpOffice\PhpWord\Settings::setZipClass(\PhpOffice\PhpWord\Settings::PCLZIP);
        
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filename);

        // Descargar el archivo
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        readfile($filename);
        exit;
    }
} else {
    // Si no se proporcionó un formato válido, redirigir de vuelta a la página anterior
    header("Location: lista_comite.php");
    exit();
}
?>
