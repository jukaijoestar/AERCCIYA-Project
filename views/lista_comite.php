<?php
session_start();
include("../model/config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: ../index.php");
    exit();
}

// Conexión PDO
try {
    $pdo = new PDO('mysql:host=localhost;dbname=comite_sena', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    die();
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

// Consulta para obtener los comités (con filtro si se proporciona id_aprendiz)
if ($id_aprendiz !== null) {
    $query = "SELECT comite.*, ficha.Numero_Ficha FROM comite 
              JOIN ficha ON comite.id_ficha = ficha.ID_Ficha 
              WHERE id_aprendiz = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_aprendiz]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Consulta general si no se proporciona un ID de aprendiz
    $query = "SELECT comite.*, ficha.Numero_Ficha FROM comite 
              JOIN ficha ON comite.id_ficha = ficha.ID_Ficha";
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
    <title>Lista de Comités</title>
    <link rel="stylesheet" href="../static/style/tablas.css">
    <link rel="stylesheet" href="../static/style/modal.css">
</head>

<body>
    <?php include '../components/menu.php'; ?>
    <section>
        <div class='title-accion'>
            <div>
                <button type="button" id="openAddComiteModal" class="agregar">
                    <i class="ph ph-plus"></i>
                </button>
            </div>
            <h1>Lista de Comités <?php echo $nombre_aprendiz ? 'para ' . htmlspecialchars($nombre_aprendiz) : ''; ?></h1>
        </div>

        <form action="exportar_comite.php" method="post">
            <label for="formato">Formato de exportación:</label>
            <select name="formato" id="formato">
                <option value="excel">Excel</option>
                <option value="word">Word</option>
            </select>
            <button type="submit">Exportar</button>
        </form>

        <table id='table'>
            <thead>
                <tr>
                    <th>ID del comité</th>
                    <th>Número de Ficha</th>
                    <th>Descripción</th>
                    <th>Número de comité</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result) : ?>
                    <?php foreach ($result as $row) : ?>
                        <tr class='fila'>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['Numero_Ficha']) ?></td>
                            <td><?= htmlspecialchars($row['descripcion']) ?></td>
                            <td><?= htmlspecialchars($row['num']) ?></td>
                            <td>
                                <button type="button" class="btn btn-warning" onclick="editarComite(<?= htmlspecialchars($row['id']) ?>)">Editar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6">No hay comités disponibles</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Modal Agregar -->
        <div id="addComiteModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Agregar Nuevo Comité</h2>
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                    <form id="addComiteForm" class='form-column mas'>
                        <div class="input-modal">
                            <label for="idAprendiz">ID Aprendiz</label>
                            <input type="number" class="form-control" id="idAprendiz" name="idAprendiz" required>
                        </div>
                        <div class="input-modal">
                            <label for="idFicha">ID Ficha</label>
                            <input type="number" class="form-control" id="idFicha" name="idFicha" required>
                        </div>
                        <div class="input-modal">
                            <label for="descripcion">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                        </div>
                        <div class="input-modal">
                            <label for="num">Número</label>
                            <input type="number" class="form-control" id="num" name="num" required>
                        </div>
                        <div class='accion-btn-modal'>
                            <button type="submit" class="modal-button"><i class="ph ph-tray-arrow-up"></i>Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Editar -->
    <div id="editComiteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Editar Comité</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <form id="editComiteForm" class='form-column mas'>
                    <input type="hidden" id="editComiteId" name="editComiteId">
                    <div class="input-modal">
                        <label for="editIdAprendiz">ID Aprendiz</label>
                        <input type="number" class="form-control" id="editIdAprendiz" name="editIdAprendiz" required>
                    </div>
                    <div class="input-modal">
                        <label for="editIdFicha">ID Ficha</label>
                        <input type="number" class="form-control" id="editIdFicha" name="editIdFicha" required>
                    </div>
                    <div class="input-modal">
                        <label for="editDescripcion">Descripción</label>
                        <input type="text" class="form-control" id="editDescripcion" name="editDescripcion" required>
                    </div>
                    <div class="input-modal">
                        <label for="editNum">Número</label>
                        <input type="number" class="form-control" id="editNum" name="editNum" required>
                    </div>
                    <div class='accion-btn-modal'>
                        <button type="submit" class="modal-button"><i class="ph ph-tray-arrow-up"></i>Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('openAddComiteModal').addEventListener('click', function() {
                document.getElementById('addComiteModal').style.display = 'block';
            });

            var closeButtons = document.getElementsByClassName('close');
            for (var i = 0; i < closeButtons.length; i++) {
                closeButtons[i].addEventListener('click', function() {
                    var modal = this.parentElement.parentElement;
                    modal.style.display = 'none';
                });
            }

            window.addEventListener('click', function(event) {
                var modals = document.getElementsByClassName('modal');
                for (var i = 0; i < modals.length; i++) {
                    if (event.target == modals[i]) {
                        modals[i].style.display = "none";
                    }
                }
            });

            document.getElementById('addComiteForm').addEventListener('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);

                fetch('../controllers/guardar_comite.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Comité guardado exitosamente.');
                            location.reload();
                        } else {
                            alert('Error al guardar el comité: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Hubo un error en el servidor: ' + error.message);
                    });
            });

            window.eliminarComite = function(id) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('../controllers/eliminar_comite.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({
                                    id: id
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire(
                                        'Eliminado!',
                                        'El comité ha sido eliminado.',
                                        'success'
                                    ).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Hubo un problema al eliminar el comité: ' + data.message,
                                        'error'
                                    );
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire(
                                    'Error!',
                                    'Hubo un error al procesar la solicitud',
                                    'error'
                                );
                            });
                    }
                });
            };

            window.editarComite = function(id) {
                fetch('../controllers/obtener_comite.php?id=' + id)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('editComiteId').value = data.comite.id;
                            document.getElementById('editIdAprendiz').value = data.comite.id_aprendiz;
                            document.getElementById('editIdFicha').value = data.comite.id_ficha;
                            document.getElementById('editDescripcion').value = data.comite.descripcion;
                            document.getElementById('editNum').value = data.comite.num;
                            document.getElementById('editComiteModal').style.display = 'block';
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Hubo un problema al obtener los datos del comité: ' + data.message
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un error al procesar la solicitud'
                        });
                    });
            };

            document.getElementById('editComiteForm').addEventListener('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);

                fetch('../controllers/actualizar_comite.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Comité actualizado exitosamente',
                                showConfirmButton: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Hubo un problema al actualizar el comité: ' + data.message
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un error al procesar la solicitud'
                        });
                    });
            });

            window.exportar = function(formato) {
                // Establecer el valor del campo oculto "formato" en el formulario
                document.getElementById('formato').value = formato;
                // Enviar el formulario
                document.getElementById('exportForm').submit();
            }
        });

        function exportar(formato) {
            // Establecer el valor del campo oculto "formato" en el formulario
            document.getElementById('formato').value = formato;
            // Enviar el formulario
            document.getElementById('exportForm').submit();
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>

</html>