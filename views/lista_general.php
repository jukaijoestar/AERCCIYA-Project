<?php
session_start();
include("../model/config.php");

if(!isset($_SESSION['valid'])){
    header("Location: ../index.php");
    exit();
}

$result = $con->query("SELECT * FROM comite_general");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="../static/img/favicon.ico">
    <title>Listado de Comités Generales</title>
    <link rel="stylesheet" href="../static/style/tablas.css">
    <link rel="stylesheet" href="../static/style/modal.css">
</head>
<body>
<?php include '../components/menu.php'; ?>
    <section>
        <h2>Listado de Comités Generales</h2>
        <table id="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Nombre del Comité o Reunión</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Hora Inicio</th>
                    <th scope="col">Hora Fin</th>
                    <th scope="col">Lugar</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">Puntos Destacados</th>
                    <th scope="col">Objetivos</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class='fila'>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['nombre']) ?></td>
                            <td><?= htmlspecialchars($row['fecha']) ?></td>
                            <td><?= htmlspecialchars($row['hora_inicio']) ?></td>
                            <td><?= htmlspecialchars($row['hora_fin']) ?></td>
                            <td><?= htmlspecialchars($row['lugar']) ?></td>
                            <td><?= htmlspecialchars($row['direccion']) ?></td>
                            <td><?= htmlspecialchars($row['puntos_destacados']) ?></td>
                            <td><?= htmlspecialchars($row['objetivos']) ?></td>
                            <td>
                                <button type="button" class="btn btn-warning" onclick="abrirModalEditar(<?= htmlspecialchars($row['id']) ?>)">Editar</button>
                            </td>
                            
                        </tr>
                        
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10">No hay comités disponibles</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
    <form method="POST" action="exportar_comite_general.php">
    <div class="form-group">
        <label for="formato">Selecciona el formato de exportación:</label>
        <select name="formato" id="formato" class="form-control" required>
            <option value="excel">Excel</option>
            <option value="word">Word</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Exportar</button>
</form>

    

    <!-- Modal para editar comité -->
    <div class="modal fade" id="editarComiteModal" tabindex="-1" role="dialog" aria-labelledby="editarComiteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarComiteModalLabel">Editar Comité</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editarComiteForm">
                        <input type="hidden" id="idEditar" name="id">
                        <div class="form-group">
                            <label for="nombre">Nombre del Comité o Reunión:</label>
                            <input type="text" class="form-control" id="nombreEditar" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha:</label>
                            <input type="date" class="form-control" id="fechaEditar" name="fecha" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="horaI">Hora Inicio:</label>
                                <input type="time" class="form-control" id="horaIEditar" name="horaI" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="horaF">Hora Fin:</label>
                                <input type="time" class="form-control" id="horaFEditar" name="horaF" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lugar">Lugar y/o Enlace:</label>
                            <input type="text" class="form-control" id="lugarEditar" name="lugar" required>
                        </div>
                        <div class="form-group">
                            <label for="direccion">Dirección General/ Regional/ Centro:</label>
                            <input type="text" class="form-control" id="direccionEditar" name="direccion" required>
                        </div>
                        <div class="form-group">
                            <label for="puntosD">Agendas o Puntos para Desarrollar:</label>
                            <textarea class="form-control" id="puntosDEditar" name="puntosD" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="objetivos">Objetivos de la Reunión:</label>
                            <textarea class="form-control" id="objetivosEditar" name="objetivos" rows="3" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarCambios()">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para eliminar comité -->
    <div class="modal fade" id="eliminarComiteModal" tabindex="-1" role="dialog" aria-labelledby="eliminarComiteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarComiteModalLabel">Eliminar Comité</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este comité?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
   <script>
    function abrirModalEditar(id) {
        $.ajax({
            url: '../controllers/crud_general.php',
            method: 'GET',
            data: { action: 'obtener', id: id },
            success: function(response) {
                $('#idEditar').val(response.id);
                $('#nombreEditar').val(response.nombre);
                $('#fechaEditar').val(response.fecha);
                $('#horaIEditar').val(response.hora_inicio);
                $('#horaFEditar').val(response.hora_fin);
                $('#lugarEditar').val(response.lugar);
                $('#direccionEditar').val(response.direccion);
                $('#puntosDEditar').val(response.puntos_destacados);
                $('#objetivosEditar').val(response.objetivos);
                $('#editarComiteModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function guardarCambios() {
    var datosComite = {
        id: $('#idEditar').val(),
        nombre: $('#nombreEditar').val(),
        fecha: $('#fechaEditar').val(),
        hora_inicio: $('#horaIEditar').val(),
        hora_fin: $('#horaFEditar').val(),
        lugar: $('#lugarEditar').val(),
        direccion: $('#direccionEditar').val(),
        puntos_destacados: $('#puntosDEditar').val(),
        objetivos: $('#objetivosEditar').val()
    };

    $.ajax({
        url: '../controllers/crud_general.php',
        method: 'POST',
        data: { action: 'editar', datos: JSON.stringify(datosComite) },
        success: function(response) {
            console.log('Cambios guardados correctamente');
            Swal.fire({
                icon: 'success',
                title: 'Comité actualizado exitosamente',
                showConfirmButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        },
        error: function(xhr, status, error) {
            console.error('Error al guardar los cambios:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al actualizar el comité.'
            });
        }
    });
}

    function abrirModalEliminar(id) {
        $('#eliminarComiteModal').modal('show');

        $('#eliminarComiteModal').on('click', '.btn-danger', function () {
            $.ajax({
                url: '../controllers/crud_general.php',
                method: 'POST',
                data: { action: 'eliminar', id: id },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    }
</script>

</body>
</html>
