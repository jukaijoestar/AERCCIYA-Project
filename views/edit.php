<?php 
session_start();

include("../model/config.php");

// Verificar si la sesión es válida
if(!isset($_SESSION['valid'])){
    header("Location: ../index.php");
    exit(); // Asegurarse de que el script se detenga después de redirigir
}

// Procesar el formulario de actualización del perfil
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $id = $_SESSION['id'];

    try {
        // Preparar la consulta SQL para actualizar el perfil
        $stmt = $pdo->prepare("UPDATE users SET Username=:username, Email=:email, Age=:age WHERE Id=:id");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':age', $age, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        // Ejecutar la consulta
        $stmt->execute();

        // Verificar si la actualización fue exitosa
        if($stmt->rowCount() > 0){
            echo "<div class='message'>
                    <p>¡Perfil actualizado!</p>
                  </div> <br>";
            echo "<a href='home.php'><button class='btn'>Ir a Inicio</button></a>";
        } else {
            echo "No se pudo actualizar el perfil.";
        }
    } catch(PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    // Obtener los datos actuales del usuario para prellenar el formulario
    $id = $_SESSION['id'];

    try {
        // Preparar y ejecutar la consulta para obtener los datos del usuario
        $stmt = $pdo->prepare("SELECT * FROM users WHERE Id=:id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener los resultados y asignarlos a variables
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $res_Uname = $result['Username'];
        $res_Email = $result['Email'];
        $res_Age = $result['Age'];

    } catch(PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="../static/img/favicon.ico">
    <link rel="stylesheet" href="../static/style/perfil.css">
    <title>Editar perfil</title>
</head>
<body>
    <?php include '../components/menu.php'; ?>
    
    <section>
        <div>
            <header class="edit-text">
                <i class="ph ph-warning"></i>
                <p>¡Actualiza tu información para mantenerla siempre precisa! Haz clic para actualizar y mantener tus datos al día.</p>
            </header>

            <form action="" method="post" class="form-edit-profile">
                <div class="inpust-perfil">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($res_Uname); ?>" autocomplete="off" required>
                </div>

                <div class="inpust-perfil">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($res_Email); ?>" autocomplete="off" required>
                </div>

                <div class="inpust-perfil">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" value="<?php echo htmlspecialchars($res_Age); ?>" autocomplete="off" required>
                </div>
                
                <div class="accion-btn">
                    <button type="submit" class="edit-button" name="submit">
                        <i class="ph ph-arrows-clockwise"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>