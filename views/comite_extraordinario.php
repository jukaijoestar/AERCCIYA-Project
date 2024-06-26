<?php
session_start();
include("../model/config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: ../index.php");
    exit();
}

// Inicialización de variables
$ficha_id = null;
$aprendices = [];
$ficha = null;

if (isset($_POST['ficha']) && !empty($_POST['ficha'])) {
    $numero_ficha = $_POST['ficha'];

    $stmt = $pdo->prepare("SELECT ID_Ficha, Numero_Ficha FROM ficha WHERE Numero_Ficha = :numero_ficha");
    $stmt->execute(['numero_ficha' => $numero_ficha]);
    $ficha = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($ficha) {
        $ficha_id = $ficha['ID_Ficha'];

        $stmt = $pdo->prepare("SELECT * FROM aprendiz WHERE ID_Ficha = :ficha_id");
        $stmt->execute(['ficha_id' => $ficha_id]);
        $aprendices = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $aprendices = [];
    }
}

// Obtener datos para los nuevos listbox
$regionales = $pdo->query("SELECT id, nombre FROM regional")->fetchAll(PDO::FETCH_ASSOC);
$formaciones = $pdo->query("SELECT id, nombre FROM formacion")->fetchAll(PDO::FETCH_ASSOC);
$modalidades = $pdo->query("SELECT id, nombre FROM modalidad")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="../static/img/favicon.ico">
    <link rel="stylesheet" href="../static/style/comiteExtraordinario.css">
    <link rel="stylesheet" href="../static/style/tablas.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Comite Extraordinario</title>
</head>

<body>
    <?php include '../components/menu.php'; ?>
    <section>
        <div class='title-accion'>
            <div>
                <a href="listas_ficha.php" class="agregar">
                    <i class="ph ph-arrow-bend-up-left"></i>
                </a>
            </div>
            <h1>Comite Extraordinario</h1>
        </div>


        <div class='info-general'>
            <div class="datos-reunion">
                <form id="filtro-fichas" method="post">
                    <div>
                        <label for="Acta">Número del acta:</label>
                        <input type="Number" id="Acta" name="Acta" required>
                    </div>
                    <div>
                        <label for="regional">Regional:</label>
                        <select id="regional" name="regional" required>
                            <option value="">Seleccionar Regional</option>
                            <?php foreach ($regionales as $regional) : ?>
                                <option value="<?php echo $regional['id']; ?>"><?php echo $regional['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="centro">Centro:</label>
                        <select id="centro" name="centro" required>
                            <option value="">Seleccionar Centro</option>
                        </select>
                    </div>
                    <div class="form-columna-fechas">
                        <div>
                            <label for="formacion">Formación:</label>
                            <select id="formacion" name="formacion" required>
                                <option value="">Seleccionar</option>
                                <?php foreach ($formaciones as $formacion) : ?>
                                    <option value="<?php echo $formacion['id']; ?>"><?php echo $formacion['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="modalidad">Modalidad:</label>
                            <select id="modalidad" name="modalidad" required>
                                <option value="">Seleccionar</option>
                                <?php foreach ($modalidades as $modalidad) : ?>
                                    <option value="<?php echo $modalidad['id']; ?>"><?php echo $modalidad['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="ficha">Ficha:</label>
                            <select id="ficha" name="ficha" required>
                                <option value="">Seleccionar</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="datos-comite">
                <form action="../controllers/comite_g.php" method="post" enctype="multipart/form-data">
                    <div class="tab-box">
                        <button class="tab-btn active">General</button>
                        <button class="tab-btn">Contenido</button>
                        <button class="tab-btn">Observaciones</button>
                        <button class="tab-btn">Compromisos</button>
                    </div>
                    <div class="content-box">
                        <div class="content active general">
                            <div>
                                <label for="nombre">Nombre del Comité o de la Reunión:</label>
                                <input type="text" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-columna-fechas">
                                <div>
                                    <label for="fecha">Fecha:</label>
                                    <input type="date" id="fecha" name="fecha" required>
                                </div>
                                <div>
                                    <label for="horaI">Hora Inicio:</label>
                                    <input type="time" id="horaI" name="horaI" required>
                                </div>
                            </div>
                        </div>
                        <div class="content">
                            <div class="form-columna-fechas">
                                <div>
                                    <label for="puntosD">Agendas o Puntos para Desarrollar:</label>
                                    <textarea id="puntosD" name="puntosD" rows="2" required></textarea>
                                </div>
                                <div>
                                    <label for="objetivos">Objetivos de la Reunión:</label>
                                    <textarea id="objetivos" name="objetivos" rows="2" required></textarea>
                                </div>
                                <div>
                                    <label for="desarrollo">Desarrollo de la Reunión:</label>
                                    <textarea id="desarrollo" name="desarrollo" rows="2" required></textarea>
                                </div>
                                <div>
                                    <label for="Integrantes">Integrantes de la Reunión:</label>
                                    <textarea id="Integrantes" name="Integrantes" rows="2" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="content">
                            <div class="table-container" id="table-container-aprendices">
                                <div id="tabla-aprendices" class="table">
                                    <div class="row header">
                                        <div class="cell">Numero Documento</div>
                                        <div class="cell">Aprendiz</div>
                                        <div class="cell">Telefono</div>
                                        <div class="cell">Observaciones</div>
                                        <div class="cell">Anotaciones</div>
                                    </div>
                                    <div class="row"></div> <!-- Filas llenadas dinámicamente por JavaScript -->
                                </div>
                            </div>
                        </div>
                        <div class="content">
                            <div>
                                <div class="form-columna-fechas">
                                    <div>
                                        <label for="actividad">Actividad (Opcional):</label>
                                        <input type="text" id="actividad" name="actividad[]">
                                    </div>
                                    <div>
                                        <label for="responsable">Responsable (Opcional):</label>
                                        <input type="text" id="responsable" name="responsable[]">
                                    </div>
                                    <div>
                                        <label for="horaF">Hora Fin:</label>
                                        <input type="time" id="horaF" name="horaF">
                                    </div>
                                </div>
                                <div>
                                    <label for="asistentes">Asistentes (Formato de Imagen):</label>
                                    <input type="file" id="asistentes" name="asistentes" required>
                                </div>
                            </div>
                            <div class="botones">
                                <button type="button" class="guardar" id="iniciar-comite">Guardar todo</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../static/js/comite_extraordinario.js"></script>
</body>
</html>