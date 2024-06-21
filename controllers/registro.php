<?php
include("model/config.php");

if (isset($_POST['register_submit'])) {
    $username = mysqli_real_escape_string($con, $_POST['register_username']);
    $email = mysqli_real_escape_string($con, $_POST['register_email']);
    $age = mysqli_real_escape_string($con, $_POST['register_age']);
    $password = mysqli_real_escape_string($con, $_POST['register_password']);
    
    
    $stmt = mysqli_prepare($con, "SELECT Email FROM users WHERE Email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) > 0) {
        echo "<script>Swal.fire('Error', 'Este email ya está en uso, ¡intente con otro!', 'error');</script>";
    } else {
        
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
        
        $stmt = mysqli_prepare($con, "INSERT INTO users (Username, Email, Age, Password) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssis", $username, $email, $age, $hashed_password);
        $success = mysqli_stmt_execute($stmt);
        
        if ($success) {
            
            echo "<script>Swal.fire('Éxito', 'Registro exitoso', 'success');</script>";
        } else {
            echo "<script>Swal.fire('Error', 'Error al registrarse', 'error');</script>";
        }
    }
}
?>
