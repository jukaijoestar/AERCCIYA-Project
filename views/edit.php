<?php 
   session_start();

   include("../model/config.php");
   if(!isset($_SESSION['valid'])){
    header("Location: ../index.php");
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
        <div >
            <?php 
               if(isset($_POST['submit'])){
                $username = $_POST['username'];
                $email = $_POST['email'];
                $age = $_POST['age'];

                $id = $_SESSION['id'];

                $edit_query = mysqli_query($con,"UPDATE users SET Username='$username', Email='$email', Age='$age' WHERE Id=$id ") or die("error occurred");

                if($edit_query){
                    echo "<div class='message'>
                    <p>Profile Updated!</p>
                </div> <br>";
              echo "<a href='home.php'><button class='btn'>Go Home</button>";
       
                }
               }else{

                $id = $_SESSION['id'];
                $query = mysqli_query($con,"SELECT*FROM users WHERE Id=$id ");

                while($result = mysqli_fetch_assoc($query)){
                    $res_Uname = $result['Username'];
                    $res_Email = $result['Email'];
                    $res_Age = $result['Age'];
                }

            ?>
            
            <header class="edit-text">
                <i class="ph ph-warning"></i>
                <p>¡Actualiza tu información para mantenerla siempre precisa! Haz clic para actualizar y mantener tus datos al día.</p>
            </header>

            <form action="" method="post" class="form-edit-profile">
                <div class="inpust-perfil">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo $res_Uname; ?>" autocomplete="off" required>
                </div>

                <div class="inpust-perfil">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" value="<?php echo $res_Email; ?>" autocomplete="off" required>
                </div>

                <div class="inpust-perfil">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" value="<?php echo $res_Age; ?>" autocomplete="off" required>
                </div>
                
                <div class="accion-btn">
                    <button type="submit" class="edit-button" name="submit">
                        <i class="ph ph-arrows-clockwise"></i> Actualizar
                    </button>
                </div>
            </form>

        </div>
        <?php } ?>
      </section>
</body>
</html>