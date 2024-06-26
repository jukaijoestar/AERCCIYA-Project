<?php
include("model/config.php");

if (isset($_POST['login_submit'])) {
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];
    
    try {
        $query = "SELECT * FROM users WHERE Email = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            // Comparar la contraseña directamente (menos seguro)
            if ($password == $row['Password']) {
                session_start();
                $_SESSION['valid'] = $row['Email'];
                $_SESSION['username'] = $row['Username'];
                $_SESSION['age'] = $row['Age'];
                $_SESSION['id'] = $row['Id'];  

                header("Location: ../views/home.php");
                exit();
            } else {
                echo "<script>Swal.fire('Error', 'Contraseña incorrecta', 'error');</script>";
            }
        } else {
            echo "<script>Swal.fire('Error', 'Correo electrónico incorrecto', 'error');</script>";
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
}
?>