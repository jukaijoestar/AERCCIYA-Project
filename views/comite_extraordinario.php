<?php
session_start();
include("../model/config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: ../index.php");
    exit();
}

// Inicialización de la conexión PDO
try {
    $pdo = new PDO('mysql:host=localhost;dbname=comite_sena', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    die();
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
    <link rel="stylesheet" href="../static/style/comiteGeneral.css">
    <link rel="stylesheet" href="../static/style/tablas.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Comite Extraordinario</title>
    <style>
        .table {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .header,
        .row {
            display: table-row;
        }

        .cell {
            display: table-cell;
            padding: 8px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .header .cell {
            font-weight: bold;
            background-color: #f2f2f2;
        }
    </style>
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
                                    <textarea id="puntosD" name="puntosD" rows="3" required></textarea>
                                </div>
                                <div>
                                    <label for="objetivos">Objetivos de la Reunión:</label>
                                    <textarea id="objetivos" name="objetivos" rows="3" required></textarea>
                                </div>
                                <div>
                                    <label for="desarrollo">Desarrollo de la Reunión:</label>
                                    <textarea id="desarrollo" name="desarrollo" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="content">
                            <div id="tabla-aprendices" class="table">
                                <div class="row header">
                                    <div class="cell">Numero Documento</div>
                                    <div class="cell">Aprendiz</div>
                                    <div class="cell">Telefono</div>
                                    <div class="cell">Observaciones</div>
                                </div>
                                <div class="row"></div> <!-- Filas llenadas dinámicamente por JavaScript -->
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
                                        <label for="horaF">Hora Fin (Opcional):</label>
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
    <script>
        $(document).ready(function() {
            const tabs = document.querySelectorAll(".tab-btn");
            const all_content = document.querySelectorAll(".content");

            tabs.forEach((tab, index) => {
                tab.addEventListener("click", () => {
                    tabs.forEach((tab) => {
                        tab.classList.remove("active");
                    });
                    tab.classList.add("active");

                    all_content.forEach((content) => {
                        content.classList.remove("active");
                    });
                    all_content[index].classList.add("active");
                });
            });

            // Activa el primer botón y el primer contenido al cargar la página
            tabs[0].classList.add("active");
            all_content[0].classList.add("active");

            // Variables para almacenar las selecciones
            let id_regional, id_centro, id_formacion, id_modalidad;

            // Función para actualizar las fichas
            function updateFichas() {
                if (id_regional && id_centro && id_formacion && id_modalidad) {
                    $.ajax({
                        type: 'POST',
                        url: '../controllers/get_fichas.php',
                        data: {
                            id_centro: id_centro,
                            formacion_id: id_formacion,
                            modalidad_id: id_modalidad
                        },
                        success: function(html) {
                            $('#ficha').html(html);
                        }
                    });
                } else {
                    $('#ficha').html('<option value="">Seleccionar Ficha</option>');
                }
            }

            // Evento de cambio para regional
            $('#regional').change(function() {
                id_regional = $(this).val();
                if (id_regional) {
                    $.ajax({
                        type: 'POST',
                        url: '../controllers/get_centros.php',
                        data: {
                            id_regional: id_regional
                        },
                        success: function(html) {
                            $('#centro').html(html);
                            id_centro = null; // Resetear la selección de centro
                            $('#ficha').html('<option value="">Seleccionar Ficha</option>');
                        }
                    });
                } else {
                    $('#centro').html('<option value="">Seleccionar Centro</option>');
                    $('#ficha').html('<option value="">Seleccionar Ficha</option>');
                }
            });

            // Evento de cambio para centro
            $('#centro').change(function() {
                id_centro = $(this).val();
                updateFichas();
            });

            // Evento de cambio para formacion
            $('#formacion').change(function() {
                id_formacion = $(this).val();
                updateFichas();
            });

            // Evento de cambio para modalidad
            $('#modalidad').change(function() {
                id_modalidad = $(this).val();
                updateFichas();
            });

            // Llenar la tabla de aprendices cuando se selecciona una ficha
            $('#ficha').change(function() {
                var id_ficha = $(this).val();
                if (id_ficha) {
                    $.ajax({
                        type: 'POST',
                        url: '../controllers/obtener_aprendices.php',
                        data: {
                            id_ficha: id_ficha
                        },
                        success: function(response) {
                            var aprendices = JSON.parse(response);
                            var tabla = $('#tabla-aprendices .row:not(.header)');
                            tabla.remove(); // Eliminar filas anteriores
                            aprendices.forEach(function(aprendiz) {
                                $('#tabla-aprendices').append(
                                    '<div class="row">' +
                                    '<div class="cell">' + aprendiz.Numero_Documento + '</div>' +
                                    '<div class="cell">' +
                                    aprendiz.Primer_Nombre + ' ' +
                                    aprendiz.Segundo_Nombre + ' ' +
                                    aprendiz.Primer_Apellido + ' ' +
                                    aprendiz.Segundo_Apellido +
                                    '</div>' +
                                    '<div class="cell">' + aprendiz.Telefono + '</div>' +
                                    '<div class="cell"><input type="text" name="observaciones[' + aprendiz.ID_Aprendiz + ']" placeholder="Añadir observaciones" required></div>' +
                                    '<input type="hidden" name="id_aprendiz[]" value="' + aprendiz.ID_Aprendiz + '">' +
                                    '</div>'
                                );
                            });
                        }
                    });
                } else {
                    $('#tabla-aprendices .row:not(.header)').remove();
                }
            });

            $('#iniciar-comite').click(function() {
                var formData = new FormData();

                formData.append('id_ficha', $('#ficha').val());
                formData.append('Acta', $('#Acta').val());
                formData.append('nombre', $('#nombre').val());
                formData.append('fecha', $('#fecha').val());
                formData.append('horaI', $('#horaI').val());
                formData.append('horaF', $('#horaF').val());
                formData.append('puntosD', $('#puntosD').val());
                formData.append('objetivos', $('#objetivos').val());
                formData.append('desarrollo', $('#desarrollo').val());

                // Añadir observaciones de cada aprendiz
                $('#tabla-aprendices .row:not(.header)').each(function() {
                    var id_aprendiz = $(this).find('input[type="hidden"]').val();
                    var observacion = $(this).find('input[type="text"]').val();
                    if (id_aprendiz && observacion) { // Asegurarse de que hay un id de aprendiz y una observación válida
                        formData.append('observaciones[' + id_aprendiz + ']', observacion);
                    }
                });

                // Añadir actividades, responsables y fechas
                $('[name="actividad[]"]').each(function(index) {
                    formData.append('actividad[' + index + ']', $(this).val());
                });
                $('[name="responsable[]"]').each(function(index) {
                    formData.append('responsable[' + index + ']', $(this).val());
                });
                $('[name="fecha_compromiso[]"]').each(function(index) {
                    formData.append('fecha_compromiso[' + index + ']', $(this).val());
                });

                // Añadir archivo de asistentes
                var asistentes = $('#asistentes')[0].files[0];
                if (asistentes) {
                    formData.append('asistentes', asistentes);
                }

                $.ajax({
                    url: '../controllers/guardar_extraordinario.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Asumimos que response ya es un objeto JSON porque configuramos el encabezado en PHP
                        if (response.status === "success") {
                            Swal.fire({
                                title: 'Éxito',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // Redirigir a consultar.php con el ID obtenido
                                window.location.href = "../controllers/consultar.php?id=" + response.id;

                                // Esperar 1 segundo antes de redirigir a home.php
                                setTimeout(() => {
                                    window.location.href = "../views/home.php";
                                }, 1000);
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un problema al guardar los datos.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });

            });
        });
    </script>
</body>

</html>