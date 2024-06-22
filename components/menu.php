<?php
include("../model/config.php");

// Definir variables de sesión
$res_Uname = isset($_SESSION['username']) ? $_SESSION['username'] : 'Usuario Desconocido';
$res_Email = isset($_SESSION['valid']) ? $_SESSION['valid'] : 'email@desconocido.com';
?>

<link rel="stylesheet" href="../static/style/menu.css">
<link rel="stylesheet" href="../static/style/oscuro.css">

<nav class="navbar">
    <div class="opcion">
        <img class="logo" src="../static/img/Sena-blanco.png" alt="">

        <ul class="menu-item">
            <li class="item">
                <a href="home.php" class="title">Inicio</a>
            </li>
            <li class="item">
                <a class="title" id="Dashboard">Listas</a>
                <div id="menu-desplegable">
                    <ul class="sub-menu">
                        <li class="enlaces">
                            <a href="listas_ficha.php" class="link">
                                <img src="../static/img/fichas.png" alt="">
                                <div>
                                    <span class="subtitle">Fichas</span>
                                    <span class="subconte">Manejo de comités</span>
                                </div>
                            </a>
                        </li>
                        <li class="enlaces">
                            <a href="lista_comite.php" class="link">
                                <img src="../static/img/comite.png" alt="">
                                <div>
                                    <span class="subtitle">Comité</span>
                                    <span class="subconte">Manejo de comités</span>
                                </div>
                            </a>
                        </li>
                        <li class="enlaces">
                            <a href="comite_general.php" class="link">
                                <img src="../static/img/comite-g.png" alt="">
                                <div>
                                    <span class="subtitle">Comité General</span>
                                    <span class="subconte">Manejo de comités</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>

    <div class="user-opcion">
        <div class="buscador">
            <i class="ph ph-magnifying-glass"></i>
            <input id="search" type="search" placeholder="Buscar..." class="search_box" autocomplete="off">
        </div>

        <div class="user">
            <img src="../static/img/perfil.png" alt="logo_img" />
            <div class="text">
                <span class="nombre"><?php echo htmlspecialchars($res_Uname); ?></span>
                <span class="correo"><?php echo htmlspecialchars($res_Email); ?></span>
            </div>
        </div>

        <div class="power">
            <a id="modo"> </a>
        </div>
        <a href="edit.php" class="power"><i class="ph ph-user"></i></a>
        <a href="../controllers/logout.php" class="power"><i class="ph ph-sign-out"></i></a>
    </div>
</nav>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js"
    integrity="sha512-8Z5++K1rB3U+USaLKG6oO8uWWBhdYsM3hmdirnOEWp8h2B1aOikj5zBzlXs8QOrvY9OxEnD2QDkbSKKpfqcIWw=="
    crossorigin="anonymous"></script>
<script src="https://unpkg.com/@phosphor-icons/web"></script>
<script src="../static/js/menu.js"></script>