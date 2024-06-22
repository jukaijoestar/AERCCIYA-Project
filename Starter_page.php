<?php 
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SENA - Login</title>
    <link rel="stylesheet" href="static/style/login.css">
    <link rel="icon" type="image/png" sizes="32x32" href="static/img/favicon.ico">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<main>
    <div class="box">
      <div class="inner-box">
        <div class="forms-wrap">
          <?php 
            include("controllers/login.php");
            include("controllers/registro.php");
          ?>
          <form action="" method="post" autocomplete="off" class="sign-in-form">
            <div class="heading">
              <h1>Bienvenido</h1>
            </div>

            <div class="actual-form">
              <div class="input-wrap">
                <input class="input-field" type="text" name="login_email" id="login_email" autocomplete="off" required>
                <label for="login_email">Correo electrónico</label>
              </div>

              <div class="input-wrap">
                <input class="input-field" type="password" name="login_password" id="login_password" autocomplete="off" required>
                <label for="login_password">Contraseña</label>
              </div>

              <input type="submit" class="sign-btn" name="login_submit" value="Acceder" required>

              <p class="text">
                ¿Olvidó su contraseña o sus datos de inicio de sesión?
                <a href="#">Obtén ayuda </a> para iniciar sesión
              </p>
            </div>
          </form>

          <form action="" method="post" class="sign-up-form">
            <!-- <div class="logo">
            <img src="static/img/Sena.png" alt="sena" />
              <h4>SENA</h4>
            </div> -->

            <div class="heading">
              <h1>Empezar</h1>
              <h6>¿Ya tienes una cuenta?</h6>
              <a href="#" class="toggle">Iniciar sesión</a>
            </div>

            <div class="actual-form">
              <div class="input-wrap">
                <input class="input-field" type="text" name="register_username" id="register_username" autocomplete="off" required>
                <label>Nombre</label>
              </div>

              <div class="input-wrap">
                  <input class="input-field" type="number" name="register_age" id="register_age" autocomplete="off" required>
                  <label>Edad</label>
              </div>

              <div class="input-wrap">
                  <input class="input-field" type="text" name="register_email" id="register_email" autocomplete="off" required>
                  <label>Correo electrónico</label>
              </div>

              <div class="input-wrap">
                  <input class="input-field" type="password" name="register_password" id="register_password" autocomplete="off" required>
                  <label>Contraseña</label>
              </div>

              <input type="submit" class="sign-btn" name="register_submit" value="Registrar" required>

              <p class="text">
                Al registrarme, acepto los
                <a href="#">Términos de servicios</a> y la
                <a href="#">Política de privacidad</a>
              </p>
            </div>
          </form>
          
        </div>


        <div class="carousel">
          <div class="images-wrapper">
            <img src="https://www.sena.edu.co/es-co/Noticias/Galeria_SENA_IMG/Queremos%20tener%20una%20entidad%20igual%20al%20SENA%20en%20Curazao/11.JPG" class="image img-1 show" alt="" />
            <img src="https://www.sena.edu.co/es-co/Noticias/NoticiasImg/Formacion-03102323.jpg" class="image img-2" alt="" />
            <img src="https://www.sena.edu.co/es-co/Noticias/NoticiasImg/Aprendices-10072023.jpg" class="image img-3" alt="" />
          </div>

          <div class="text-slider">
            <div class="text-wrap">
              <div class="text-group">
                <h2>No tienes de que preocuparte</h2>
                <h2>Trabaja a tu manera</h2>
                <h2>Disfruta de los beneficios</h2>
              </div>
            </div>

            <div class="bullets">
              <span class="active" data-value="1"></span>
              <span data-value="2"></span>
              <span data-value="3"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <div class="floating-icon">
    <a href="Starter_page.php">
      <i class="ph-light ph-arrow-counter-clockwise"></i>
    </a>
  </div>


    <script src="static/js/login.js"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</body>
</html>