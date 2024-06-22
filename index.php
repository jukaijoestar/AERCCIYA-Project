<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SENA - homepage</title>
    <link rel="stylesheet" href="static/style/main-page.css">
    <link rel="icon" type="image/png" sizes="32x32" href="static/img/favicon.ico">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<body>
    <header id="inicio">
        <img src="static/img/Sena-blanco.png" alt="">
        <nav>
            <h1>Servicio Nacional de Aprendizaje</h1>
        </nav>
        <a class="login" href="Starter_page.php">Ingresar<i class="ph ph-sign-in"></i></a>
    </header>
    
    <section>
        <main>
            <div class="text" >
                <h1 data-aos="fade-right" data-aos-duration="2000">Toda la informacion en una sola aplicación</h1> 
                <p data-aos="fade-right" data-aos-duration="2000" data-aos-delay="400">gestiona sus comites, automatiza los flujos de<br> trabajo empresariales y le ayuda a trabajar de forma colectiva en todos los departamentos.</p>
            </div>
            <div class="parent">
                <div data-aos="zoom-in-right" data-aos-duration="2000" data-aos-delay="500" class="div1" style="background-image: url('https://agenciapublicadeempleo.sena.edu.co/imgLayout/Boletines%20de%20prensa/Instructor%20SENA-min%20(1).jpg')"> </div>
                <div data-aos="zoom-in-left" data-aos-duration="2000" data-aos-delay="500" class="div2" style="background-image: url('static/img/img2.jpg')"> </div>
                <div data-aos="zoom-in-right" data-aos-duration="2000" data-aos-delay="500" class="div3" style="background-image: url('https://www.sena.edu.co/es-co/Noticias/NoticiasImg/Foto_22062021.jpeg')" > </div>
                <div data-aos="flip-down" data-aos-duration="2000" data-aos-delay="500" class="div4" style="background-image: url('https://www.sena.edu.co/es-co/Noticias/NoticiasImg/FotografiaWEB_23012023.png')"> </div>
                <div data-aos="zoom-in-down" data-aos-duration="2000" data-aos-delay="500" class="div5" style="background-image: url('https://www.wradio.com.co/resizer/v2/HRFV4HCK2VHC3FINS2R6PNGNPY.png?auth=4c4ee64a1e4cab7fb9cb5fba5523fc2ee8b0ed85734e8c64b228ff59b7d03839&width=377&height=377&quality=70&smart=true')"> </div>
                <div data-aos="zoom-in-up" data-aos-duration="2000" data-aos-delay="500" class="div6" style="background-image: url('https://imagenes.eltiempo.com/files/image_1200_600/uploads/2024/04/03/660d5b9fc3744.jpeg')"> </div>  
                <div data-aos="flip-down" data-aos-duration="2000" data-aos-delay="500" class="div7" style="background-image: url('https://www.portafolio.co/files/article_new_multimedia/uploads/2017/02/07/589a3947b03f6.jpeg')"> </div>  
            </div>
        </main>
    </section>

    <article class="redes">
        <div class="linea"></div>
        <a href="https://www.sena.edu.co/es-co/Paginas/default.aspx"><i class="ph ph-users-three"></i></a>
        <a href="https://www.facebook.com/SENAAtlantico/?locale=es_LA"><i class="ph ph-facebook-logo"></i></a>
        <a href="https://www.instagram.com/senacomunica/?hl=es-la"><i class="ph ph-instagram-logo"></i></a>
        <a href="https://twitter.com/SENAComunica?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor"><i class="ph ph-x-logo"></i></a>
    </article>

    <footer>
        <p data-aos="flip-down" data-aos-duration="2000" data-aos-delay="600">Copyright &copy; <?php echo date("Y"); ?> Servicio Nacional de Aprendizaje SENA. Todos los derechos reservados.</p>
    </footer>

    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init({
        offset:1
      });
    </script>
</body>
</html>
