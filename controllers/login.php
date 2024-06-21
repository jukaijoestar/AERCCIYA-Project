<?php
include("model/config.php");

if (isset($_POST['login_submit'])) {
    $email = mysqli_real_escape_string($con, $_POST['login_email']);
    $password = mysqli_real_escape_string($con, $_POST['login_password']);
    
    $stmt = mysqli_prepare($con, "SELECT * FROM users WHERE Email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    if ($row) {
        if (password_verify($password, $row['Password'])) {
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
}
?>
