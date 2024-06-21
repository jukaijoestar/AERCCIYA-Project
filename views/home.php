<?php
session_start();

include("../model/config.php");
if (!isset($_SESSION['valid'])) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="../static/img/favicon.ico">
    <link rel="stylesheet" href="../static/style/dashboard.css">
    <title>Home</title>
</head>
<body>
    <?php include '../components/menu.php'; ?>

    <section>

        <div class="parent">
            <div class="div1"> 
                <h2>Hola 👋</h2>
                <h1>Bienvenido <?php echo htmlspecialchars($res_Uname); ?></h1>
            </div>
           
        </div>
    </section> 

</body>
</html>
