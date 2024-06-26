<?php
session_start();
include("../model/config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: ../index.php");
    exit();
}

// Inicializar variables
$result = null;
$id_aprendiz = null;
$nombre_aprendiz = "";

// Obtener el ID del aprendiz desde el URL si está presente
if (isset($_GET['id_aprendiz'])) {
    $id_aprendiz = $_GET['id_aprendiz'];

    // Consulta para obtener el nombre completo del aprendiz
    $query_aprendiz = "SELECT CONCAT(Primer_Nombre, ' ', Segundo_Nombre, ' ', Primer_Apellido, ' ', Segundo_Apellido) AS nombre_completo FROM aprendiz WHERE ID_Aprendiz = ?";
    $stmt_aprendiz = $pdo->prepare($query_aprendiz);
    $stmt_aprendiz->execute([$id_aprendiz]);
    $row_aprendiz = $stmt_aprendiz->fetch(PDO::FETCH_ASSOC);

    if ($row_aprendiz) {
        $nombre_aprendiz = $row_aprendiz['nombre_completo'];
    }
}

// Consulta para obtener los comités desde la tabla comite_extraordinario
if ($id_aprendiz !== null) {
    $query = "SELECT ce.*, f.Numero_Ficha, f.Nombre_Ficha 
              FROM comite_extraordinario ce
              JOIN ficha f ON ce.ID_ficha = f.ID_Ficha
              WHERE ce.ID_extraordinario = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_aprendiz]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Consulta general si no se proporciona un ID de aprendiz
    $query = "SELECT ce.*, f.Numero_Ficha, f.Nombre_Ficha 
              FROM comite_extraordinario ce
              JOIN ficha f ON ce.ID_ficha = f.ID_Ficha";
    $stmt = $pdo->query($query);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($stmt === false) {
        die("Error en la consulta: " . $pdo->errorInfo()[2]);
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="../static/img/favicon.ico">
    <title>Actas</title>
    <link rel="stylesheet" href="../static/style/tablas.css">
    <link rel="stylesheet" href="../static/style/modal.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        /* Estilos para el modal de la imagen */
        .modal-img {
            display: none;
            position: fixed;
            z-index: 9999;
            padding-top: 50px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.9);
        }

        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        .modal-img img {
            display: block;
            width: 100%;
            height: auto;
        }

        .modal-img-close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .modal-img-close:hover,
        .modal-img-close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php include '../components/menu.php'; ?>
    <section>
        <div class='title-accion'>
            <h1>Lista de Actas de comités extraordinarios <?php echo $nombre_aprendiz ? 'para ' . htmlspecialchars($nombre_aprendiz) : ''; ?></h1>
        </div>

        <table id='table'>
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Número del Acta</th>
                    <th>Nombre del comité o la reunión</th>
                    <th>Desarrollo del comité</th>
                    <th>Número de la Ficha</th>
                    <th>Nombre de la Ficha</th>
                    <th>Fecha de realización del comité</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result) : ?>
                    <?php foreach ($result as $row) : ?>
                        <tr class='fila'>
                            <td>
                                <button class="open-img-modal" data-img="<?= htmlspecialchars($row['ruta_foto']) ?>">
                                    <img src="<?= htmlspecialchars($row['ruta_foto']) ?>" width="50" height="50" alt="Imagen del comité">
                                </button>
                            </td>
                            <td><?= htmlspecialchars($row['Acta_Num']) ?></td>
                            <td><?= htmlspecialchars($row['Nombre']) ?></td>
                            <td><?= htmlspecialchars($row['Desarrollo']) ?></td>
                            <td><?= htmlspecialchars($row['Numero_Ficha']) ?></td>
                            <td><?= htmlspecialchars($row['Nombre_Ficha']) ?></td>
                            <td><?= date('d/m/Y', strtotime($row['Fecha'])) ?></td>
                            <td>
                                <form id="exportForm<?= htmlspecialchars($row['ID_extraordinario']) ?>" action="../controllers/consultar.php" method="get">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($row['ID_extraordinario']) ?>">
                                    <button type="button" class="export-button">Exportar Acta</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8">No hay Actas disponibles</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <!-- Modal para mostrar la imagen en grande -->
    <div id="myModal" class="modal-img">
        <span class="modal-img-close">&times;</span>
        <img class="modal-content" id="imgModal">
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const exportButtons = document.querySelectorAll('.export-button');
            exportButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    const id = form.querySelector('input[name="id"]').value;

                    Swal.fire({
                        title: 'Listo!',
                        text: 'El comité se estará descargando en este momento.',
                        icon: 'success',
                        showCancelButton: false,
                        showConfirmButton: false,
                        timer: 2000 // Duración del mensaje en milisegundos (2 segundos en este caso)
                    }).then(() => {
                        // Una vez que se muestre el SweetAlert, enviar el formulario
                        form.submit();
                    });
                });
            });

            // Modal para mostrar imagen en grande
            const modal = document.getElementById('myModal');
            const modalImg = document.getElementById("imgModal");

            const openModalButtons = document.querySelectorAll('.open-img-modal');
            openModalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const imgSrc = this.getAttribute('data-img');
                    modal.style.display = "block";
                    modalImg.src = imgSrc;
                });
            });

            const closeModal = document.getElementsByClassName("modal-img-close")[0];
            closeModal.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>