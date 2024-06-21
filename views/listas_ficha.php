<?php
session_start();
include("../model/config.php");

if(!isset($_SESSION['valid'])){
    header("Location: ../index.php");
    exit();
}

// Obtener los datos para los select
$regionales = $con->query("SELECT id, nombre FROM regional")->fetch_all(MYSQLI_ASSOC);
$formaciones = $con->query("SELECT id, nombre FROM formacion")->fetch_all(MYSQLI_ASSOC);
$modalidades = $con->query("SELECT id, nombre FROM modalidad")->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="../static/img/favicon.ico">
    <title>Lista de Fichas</title>
    <link rel="stylesheet" href="../static/style/tablas.css">
    <link rel="stylesheet" href="../static/style/modal.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <?php include '../components/menu.php'; ?>
    <section>
        <div class='title-accion'>
            <div>
                <button type="button" id="openModalBtn" class="agregar">
                <i class="ph ph-plus"></i>
                </button>              
            </div>
            <h1>Lista de Fichas</h1>
        </div>

        <table id='table'>
            <thead>
                <tr>
                    <th>Número Ficha</th>
                    <th>Nombre Ficha</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $con->query("SELECT * FROM ficha");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class='fila'>
                                <td>{$row['Numero_Ficha']}</td>
                                <td>{$row['Nombre_Ficha']}</td>
                                <td>
                                    <a href='aprendices.php?id_ficha={$row['ID_Ficha']}' class='btn btn-primary'>Aprendices</a>
                                    <a href='lista_general.php?id_ficha={$row['ID_Ficha']}' class='btn btn-secondary'>Lista General</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No hay fichas disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div id="addFichaModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Agregar Nueva Ficha</h2>
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                    <form id="addFichaForm" class='form-column'>
                        <div class="input-modal">
                            <label for="numeroFicha">Número Ficha</label>
                            <input type="number" id="numeroFicha" name="numeroFicha" required>
                        </div>
                        <div class="input-modal">
                            <label for="nombreFicha">Nombre Ficha</label>
                            <input type="text" id="nombreFicha" name="nombreFicha" required>
                        </div>
                        <div class="form-group">
                            <label for="regional">Regional:</label>
                            <select class="form-control" id="regional" name="regional" required>
                                <option value="">Seleccionar Regional</option>
                                <?php foreach ($regionales as $regional) : ?>
                                    <option value="<?php echo $regional['id']; ?>"><?php echo $regional['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="centro">Centro:</label>
                            <select class="form-control" id="centro" name="centro" required>
                                <option value="">Seleccionar Centro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="formacion">Formación:</label>
                            <select class="form-control" id="formacion" name="formacion" required>
                                <option value="">Seleccionar Formación</option>
                                <?php foreach ($formaciones as $formacion) : ?>
                                    <option value="<?php echo $formacion['id']; ?>"><?php echo $formacion['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="modalidad">Modalidad:</label>
                            <select class="form-control" id="modalidad" name="modalidad" required>
                                <option value="">Seleccionar Modalidad</option>
                                <?php foreach ($modalidades as $modalidad) : ?>
                                    <option value="<?php echo $modalidad['id']; ?>"><?php echo $modalidad['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class='accion-btn-modal'>
                            <button type="submit" class="modal-button"><i class="ph ph-tray-arrow-up"></i>Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
    var openModalBtn = document.getElementById('openModalBtn');
    var modal = document.getElementById('addFichaModal');
    var closeModalBtn = modal.querySelector('.close');

    openModalBtn.addEventListener('click', function() {
        modal.style.display = 'block';
    });

    closeModalBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Envío del formulario
    var addFichaForm = document.getElementById('addFichaForm');
    addFichaForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        var formData = new FormData(addFichaForm);

        fetch('../controllers/guardar_ficha.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Ficha guardada exitosamente',
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
                    text: 'Hubo un problema al guardar la ficha: ' + data.message
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
        
        modal.style.display = 'none';
    });

    // Cargar centros basados en la selección de regional
    document.getElementById('regional').addEventListener('change', function() {
        var regionalId = this.value;
        if (regionalId) {
            var formData = new FormData();
            formData.append('regional_id', regionalId);

            fetch('../controllers/get_centros.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('centro').innerHTML = html;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('centro').innerHTML = '<option value="">Error al cargar centros</option>';
            });
        } else {
            document.getElementById('centro').innerHTML = '<option value="">Seleccionar Centro</option>';
        }
    });

    // Cargar fichas basadas en la selección de centro
    document.getElementById('centro').addEventListener('change', function() {
        var id_centro = this.value;
        if (id_centro) {
            var formData = new FormData();
            formData.append('id_centro', id_centro);

            fetch('../controllers/get_fichas.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('ficha').innerHTML = html;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('ficha').innerHTML = '<option value="">Error al cargar fichas</option>';
            });
        } else {
            document.getElementById('ficha').innerHTML = '<option value="">Seleccionar Ficha</option>';
        }
    });
});
    </script>
</body>
</html>
