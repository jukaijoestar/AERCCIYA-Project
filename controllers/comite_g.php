<?php
// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "comite_sena";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$fecha = $_POST['fecha'];
$horaI = $_POST['horaI'];
$horaF = $_POST['horaF'];
$puntosD = $_POST['puntosD'];
$objetivos = $_POST['objetivos'];
$desarrollo = $_POST['desarrollo'];
$actividad = $_POST['actividad'][0];
$responsable = $_POST['responsable'][0];
$fecha_compromiso = $_POST['fecha_compromiso'][0];
$asistentes = $_FILES['asistentes']['name'];

// ID_Ficha podría ser un valor estático o dinámico, ajusta según tus necesidades
$ID_Ficha = 12345; // Ejemplo de valor para ID_Ficha

// Subir archivo
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["asistentes"]["name"]);
move_uploaded_file($_FILES["asistentes"]["tmp_name"], $target_file);

// Insertar datos en la tabla comite_general
$sql = "INSERT INTO comite_general (nombre, fecha, hora_inicio, hora_fin, puntos_destacados, objetivos, ID_Ficha, desarrollo, asistentes, actividad, responsables, fecha_compromiso) 
        VALUES ('$nombre', '$fecha', '$horaI', '$horaF', '$puntosD', '$objetivos', '$ID_Ficha', '$desarrollo', '$asistentes', '$actividad', '$responsable', '$fecha_compromiso')";

if ($conn->query($sql) === TRUE) {
    echo "Datos guardados correctamente.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
