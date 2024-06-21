<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h2>Datos recibidos:</h2>";

    echo "<h3>Información General</h3>";
    echo "ID Ficha: " . htmlspecialchars($_POST['id_ficha']) . "<br>";
    echo "Nombre del Comité: " . htmlspecialchars($_POST['nombre']) . "<br>";
    echo "Fecha: " . htmlspecialchars($_POST['fecha']) . "<br>";
    echo "Hora Inicio: " . htmlspecialchars($_POST['horaI']) . "<br>";
    echo "Hora Fin: " . htmlspecialchars($_POST['horaF']) . "<br>";
    echo "Agendas o Puntos para Desarrollar: " . htmlspecialchars($_POST['puntosD']) . "<br>";
    echo "Objetivos de la Reunión: " . htmlspecialchars($_POST['objetivos']) . "<br>";
    echo "Desarrollo de la Reunión: " . htmlspecialchars($_POST['desarrollo']) . "<br>";

    echo "<h3>Observaciones</h3>";
    if (isset($_POST['observaciones'])) {
        foreach ($_POST['observaciones'] as $numDoc => $observacion) {
            echo "Número de Documento: " . htmlspecialchars($numDoc) . " - Observación: " . htmlspecialchars($observacion) . "<br>";
        }
    }

    echo "<h3>Compromisos</h3>";
    if (isset($_POST['actividad'])) {
        foreach ($_POST['actividad'] as $index => $actividad) {
            echo "Actividad: " . htmlspecialchars($actividad) . "<br>";
            echo "Responsable: " . htmlspecialchars($_POST['responsable'][$index]) . "<br>";
            echo "Fecha: " . htmlspecialchars($_POST['fecha_compromiso'][$index]) . "<br><br>";
        }
    }

    echo "<h3>Asistentes</h3>";
    if (isset($_FILES['asistentes'])) {
        echo "Archivo Asistentes: " . htmlspecialchars($_FILES['asistentes']['name']) . "<br>";
    }
}
?>