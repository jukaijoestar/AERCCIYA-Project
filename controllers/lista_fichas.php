<?php
session_start();
include("../model/config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: ../index.php");
    exit;
}

$fichas = array();

$result = $con->query("SELECT * FROM ficha");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fichas[] = $row['Numero_Ficha'];
    }
}

echo json_encode($fichas);
?>
