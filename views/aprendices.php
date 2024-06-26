<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "comite_sena") or die("Couldn't connect");

// Verificar conexión
if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}

if (!isset($_SESSION['valid'])) {
    header("Location: ../index.php");
    exit();
}

$id_ficha = $_GET['id_ficha'];

// Asegúrate de que $id_ficha está correctamente definido
if (!isset($id_ficha)) {
    echo "ID de ficha no proporcionado.";
    exit();
}

// Consulta para obtener los datos de los aprendices junto con la información de la ficha
$result = $con->query("
    SELECT a.*, f.Numero_Ficha, f.Nombre_Ficha, a.Imagen
    FROM aprendiz a
    JOIN ficha f ON a.ID_Ficha = f.ID_Ficha
    WHERE a.ID_Ficha = $id_ficha
");

if (!$result) {
    echo "Error en la consulta: " . $con->error;
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="../static/img/favicon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <title>Lista de Aprendices</title>
    <link rel="stylesheet" href="../static/style/tablas.css">
    <link rel="stylesheet" href="../static/style/modal.css">
</head>

<body>
    <?php include '../components/menu.php'; ?>
    <section>
        <div class='title-accion'>
            <div>
                <a href="listas_ficha.php" class="agregar">
                    <i class="ph ph-arrow-bend-up-left"></i>
                </a>
                <button type="button" id="openAddAprendizModal" class="agregar">
                    <i class="ph ph-plus"></i>
                </button>
            </div>
            <h1>Lista de Aprendices</h1>
        </div>


        <table id='table'>
            <thead>
                <tr>
                    <th>Tipo De Documento</th>
                    <th>Número Documento</th>
                    <th>Nombre Completo</th>
                    <th>Email</th>
                    <th>Foto</th> <!-- Cambiado de Teléfono a Foto -->
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {
                        // Verifica que los índices existen antes de usarlos
                        $numeroFicha = isset($row['Numero_Ficha']) ? $row['Numero_Ficha'] : 'N/A';
                        $nombreFicha = isset($row['Nombre_Ficha']) ? $row['Nombre_Ficha'] : 'N/A';
                        $imagenAprendiz = isset($row['Imagen']) ? '../public/img/' . $row['Imagen'] : '../public/img/ruta_por_defecto_si_no_hay_imagen.jpg';
                        echo "<tr class='fila' data-id-aprendiz='{$row['ID_Aprendiz']}' data-tipo-documento='{$row['Tipo_Documento']}' data-numero-documento='{$row['Numero_Documento']}' data-nombre-completo='{$row['Primer_Nombre']} {$row['Segundo_Nombre']} {$row['Primer_Apellido']} {$row['Segundo_Apellido']}' data-email='{$row['Email']}' data-tipo-documento='{$row['Tipo_Documento']}' data-ficha-numero='{$numeroFicha}' 
                    data-ficha-nombre='{$nombreFicha}' >
                      
                    <td>{$row['Tipo_Documento']}</td>
                    <td>{$row['Numero_Documento']}</td>
                    <td>{$row['Primer_Nombre']} {$row['Segundo_Nombre']} {$row['Primer_Apellido']} {$row['Segundo_Apellido']}</td>
                    <td>{$row['Email']}</td>
                    <td><img src='{$imagenAprendiz}' alt='Foto del Aprendiz' style='width: 100px; height: 100px;'></td> <!-- Mostrar la imagen del aprendiz -->
                    <td>
                        <select class='form-select abrir-comite' data-id='{$row['ID_Aprendiz']}' data-documento='{$row['Numero_Documento']}'>
                            <option value='' disabled selected>Abrir Comité</option>
                            <option value='1'>Comité 1</option>
                            <option value='2'>Comité 2</option>
                            <option value='3'>Comité 3</option>
                            <option value='4'>Comité 4</option>
                            <option value='5'>Comité 5</option>
                            <option value='6'>Comité 6</option>
                        </select>
                         <a href='lista_comite.php?id_aprendiz={$row['ID_Aprendiz']}' class='btn btn-secondary'>Ver Comités</a>
                    </td>
                  </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay aprendices disponibles para esta ficha</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
    <!-- Modal -->
    <div id="addAprendizModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Agregar Nuevo Aprendiz</h2>
                <span class="close" onclick="cerrarModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form id="form-aprendiz" enctype="multipart/form-data">
                    <!-- Formulario de nuevo aprendiz -->
                    <input type="hidden" name="id_ficha" value="<?php echo $_GET['id_ficha']; ?>">
                    <div class="input-modal">
                        <label for="documento">Número Documento</label>
                        <input type="text" class="form-control" id="documento" name="documento" required>
                    </div>
                    <div class="input-modal">
                        <label for="tipoDocumento">Tipo Documento</label>
                        <select class="form-control" id="tipoDocumento" name="tipoDocumento" required>
                            <option value="">Seleccionar Tipo de Documento</option>
                            <option value="CC">Cédula de Ciudadanía</option>
                            <option value="CE">Cédula de Extranjería</option>
                            <option value="TI">Tarjeta de Identidad</option>
                        </select>
                    </div>
                    <div class="input-modal">
                        <label for="primerNombre">Primer Nombre</label>
                        <input type="text" class="form-control" id="primerNombre" name="primerNombre" required>
                    </div>
                    <div class="input-modal">
                        <label for="segundoNombre">Segundo Nombre</label>
                        <input type="text" class="form-control" id="segundoNombre" name="segundoNombre">
                    </div>
                    <div class="input-modal">
                        <label for="primerApellido">Primer Apellido</label>
                        <input type="text" class="form-control" id="primerApellido" name="primerApellido" required>
                    </div>
                    <div class="input-modal">
                        <label for="segundoApellido">Segundo Apellido</label>
                        <input type="text" class="form-control" id="segundoApellido" name="segundoApellido" required>
                    </div>
                    <div class="input-modal">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="input-modal">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono">
                    </div>
                    <div class="input-modal">
                        <label for="imagen">Imagen</label>
                        <input type="file" name="imagen" id="imagen" accept="image/*">
                    </div>
                    <div class='accion-btn-modal'>
                        <button type="button" onclick="guardarAprendiz()">Guardar Aprendiz</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal para mostrar y editar información del aprendiz -->
    <div class="modal fade" id="viewAprendizModal" tabindex="-1" role="dialog" aria-labelledby="viewAprendizModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewAprendizModalLabel">Información del Aprendiz</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editAprendizForm">
                        <input type="hidden" id="edit-id-aprendiz" name="id_aprendiz">

                        <!-- Campo de tipo de documento -->
                        <div class="form-group">
                            <label for="edit-tipo-documento-label">Tipo Documento: <span id="edit-tipo-documento-text"></span></label>
                            <select class="form-control" id="edit-tipo-documento" name="tipoDocumento" style="display:none;">
                                <option value="">Seleccionar Tipo de Documento</option>
                                <option value="CC">Cédula de Ciudadanía</option>
                                <option value="CE">Cédula de Extranjería</option>
                                <option value="TI">Tarjeta de Identidad</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="edit-numero-documento">Número Documento</label>
                            <input type="text" class="form-control" id="edit-numero-documento" name="numero_documento" readonly>
                        </div>
                        <div class="form-group">
                            <label for="edit-nombre-completo">Nombre Completo</label>
                            <input type="text" class="form-control" id="edit-nombre-completo" name="nombre_completo" readonly>
                        </div>
                        <div class="form-group">
                            <label for="edit-email">Email</label>
                            <input type="email" class="form-control" id="edit-email" name="email" readonly>
                        </div>
                        <div class="form-group">
                            <label for="edit-telefono">Teléfono</label>
                            <input type="text" class="form-control" id="edit-telefono" name="telefono" readonly>
                        </div>

                        <div class="form-group">
                            <label for="edit-imagen">Imagen</label>
                            <input type="file" class="form-control-file" id="edit-imagen" name="edit_imagen">
                        </div>

                        <button type="button" class="btn btn-primary" id="edit-button">Editar</button>
                        <button type="submit" class="btn btn-success" id="save-button" style="display:none;">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal para el Comité -->
    <div id="comiteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Comité del Aprendiz</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <form id="comiteAprendizForm" method="POST" class='form-column mas'>
                    <div class="input-modal">
                        <label for="documentoComite">Número Documento</label>
                        <input type="text" class="form-control" id="documentoComite" name="documentoComite" readonly>
                    </div>
                    <div class="input-modal">
                        <label for="nombreCompletoComite">Nombre Completo</label>
                        <input type="text" class="form-control" id="nombreCompletoComite" name="nombreCompletoComite" readonly>
                    </div>
                    <div class="input-modal">
                        <label for="fotoComite">Foto</label>
                        <img id="fotoComite" src="../public/img/" alt="Foto del Aprendiz" style="width: 100px; height: 100px;">
                    </div>
                    <div class="input-modal">
                        <label for="fichaNumeroComite">Número de Ficha</label>
                        <input type="text" class="form-control" id="fichaNumeroComite" name="fichaNumeroComite" readonly>
                    </div>
                    <div class="input-modal">
                        <label for="fichaNombreComite">Nombre de Ficha</label>
                        <input type="text" class="form-control" id="fichaNombreComite" name="fichaNombreComite" readonly>
                    </div>
                    <div class="input-modal">
                        <label for="descripcionComite">Descripción</label>
                        <textarea class="form-control" id="descripcionComite" name="descripcionComite" rows="10" required></textarea>
                    </div>
                    <input type="hidden" id="numeroComite" name="numeroComite">
                    <input type="hidden" id="idAprendizComite" name="idAprendizComite">

                    <div class="input-modal">
                        <label id="comentariosLabel"></label>
                    </div>
                    <div class='accion-btn-modal'>
                        <button type="submit" class="modal-button"><i class="ph ph-tray-arrow-up"></i>Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addAprendizModal = document.getElementById("addAprendizModal");
            const openAddAprendizModal = document.getElementById("openAddAprendizModal");
            const closeAddAprendizModal = addAprendizModal.querySelector(".close");

            openAddAprendizModal.onclick = function() {
                addAprendizModal.style.display = "block";
            }

            closeAddAprendizModal.onclick = function() {
                addAprendizModal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == addAprendizModal) {
                    addAprendizModal.style.display = "none";
                }
            }

        });

        document.querySelectorAll('table tbody tr').forEach(function(row) {
            row.addEventListener('click', function(event) {
                if (!event.target.classList.contains('abrir-comite')) {
                    var idAprendiz = this.getAttribute('data-id-aprendiz');
                    var numeroDocumento = this.getAttribute('data-numero-documento');
                    var nombreCompleto = this.getAttribute('data-nombre-completo');
                    var email = this.getAttribute('data-email');
                    var telefono = this.getAttribute('data-telefono');
                    var tipoDocumento = this.getAttribute('data-tipo-documento');

                    document.getElementById('edit-id-aprendiz').value = idAprendiz;
                    document.getElementById('edit-numero-documento').value = numeroDocumento;
                    document.getElementById('edit-nombre-completo').value = nombreCompleto;
                    document.getElementById('edit-email').value = email;
                    document.getElementById('edit-telefono').value = telefono;
                    document.getElementById('edit-tipo-documento-text').textContent = tipoDocumento;
                    document.getElementById('edit-tipo-documento').value = tipoDocumento;

                    // Mostrar el span y ocultar el select
                    document.getElementById('edit-tipo-documento-text').style.display = 'inline';
                    document.getElementById('edit-tipo-documento').style.display = 'none';

                    $('#viewAprendizModal').modal('show');
                }
            });
        });

        document.getElementById('edit-button').addEventListener('click', function() {
            document.getElementById('edit-nombre-completo').removeAttribute('readonly');
            document.getElementById('edit-email').removeAttribute('readonly');
            document.getElementById('edit-telefono').removeAttribute('readonly');

            // Ocultar el span y mostrar el select
            document.getElementById('edit-tipo-documento-text').style.display = 'none';
            document.getElementById('edit-tipo-documento').style.display = 'inline';

            document.getElementById('edit-button').style.display = 'none';
            document.getElementById('save-button').style.display = 'block';
        });

        document.getElementById('editAprendizForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            fetch('../controllers/actualizar_aprendiz.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'Se actualizó el aprendiz correctamente.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        // Recargar la página después de un tiempo
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema al realizar la operación: ' + data.message
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un error en el servidor: ' + error.message
                    });
                });
        });

        document.querySelectorAll('.abrir-comite').forEach(button => {
            button.addEventListener('click', function() {
                var idAprendiz = this.getAttribute('data-id');
                var documento = this.getAttribute('data-documento');

                document.getElementById('idAprendizComite').value = idAprendiz;
                document.getElementById('documentoComite').value = documento;
                document.getElementById('comiteForm').style.display = 'block';
            });
        });

        document.querySelectorAll('.comite-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Agrega la clase active al botón presionado y elimina la clase active de los demás
                document.querySelectorAll('.comite-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');

                var comite = this.getAttribute('data-comite');
                document.getElementById('comentariosLabel').innerText = 'Comentarios del Comité ' + comite;
            });
        });

        document.getElementById('comiteAprendizForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            // Agregar el id_ficha al formData
            formData.append('id_ficha', <?php echo $id_ficha; ?>);

            // Obtener el número del comité
            var numComite = document.querySelector('.comite-btn.active').getAttribute('data-comite');
            formData.append('num_comite', numComite);

            fetch('../controllers/agregar_comite.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'Comité guardado correctamente.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        // Recargar la página después de un tiempo
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema al realizar la operación: ' + data.message
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al procesar la solicitud.'
                    });
                });
        });


        // codigo javascript para abr

        document.addEventListener('DOMContentLoaded', (event) => {
            // Get the modal
            var addModal = document.getElementById("addAprendizModal");
            var comiteModal = document.getElementById("abrirComiteModal");

            // Get the button that opens the modal
            var btnOpenAddModal = document.getElementById("openAddAprendizModal");

            // Get the <span> element that closes the modal
            var spanCloseAddModal = addModal.getElementsByClassName("close")[0];
            var spanCloseComiteModal = comiteModal.getElementsByClassName("close")[0];

            // cuando presionas el aprendiz abre el modal
            btnOpenAddModal.onclick = function() {
                addModal.style.display = "block";
            }

            // cuando presionas la (x) cierra el modal
            spanCloseAddModal.onclick = function() {
                addModal.style.display = "none";
            }
            spanCloseComiteModal.onclick = function() {
                comiteModal.style.display = "none";
            }

            // cuando presionas fuera del modal lo cierra
            window.onclick = function(event) {
                if (event.target == addModal) {
                    addModal.style.display = "none";
                }
                if (event.target == comiteModal) {
                    comiteModal.style.display = "none";
                }
            }

            // abrir  modal comite
            document.querySelectorAll('.abrir-comite').forEach(button => {
                button.addEventListener('click', function() {
                    var idAprendiz = this.getAttribute('data-id');
                    document.getElementById('id_aprendiz_comite').value = idAprendiz;
                    comiteModal.style.display = 'block';
                });
            });
        });



        document.addEventListener('DOMContentLoaded', (event) => {
            const addAprendizModal = document.getElementById("addAprendizModal");
            const openAddAprendizModal = document.getElementById("openAddAprendizModal");
            const closeAddAprendizModal = addAprendizModal.querySelector(".close");

            openAddAprendizModal.onclick = function() {
                addAprendizModal.style.display = "block";
            }

            closeAddAprendizModal.onclick = function() {
                addAprendizModal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == addAprendizModal) {
                    addAprendizModal.style.display = "none";
                }
            }

            // Modal Comité
            const comiteModal = document.getElementById("comiteModal");
            const closeComiteModal = comiteModal.querySelector(".close");

            document.querySelectorAll(".abrir-comite").forEach(button => {
                button.addEventListener("click", () => {
                    const tr = button.closest('tr');
                    const idAprendiz = button.getAttribute("data-id");
                    const documentoAprendiz = button.getAttribute("data-documento");
                    const nombreCompleto = tr.getAttribute("data-nombre-completo");
                    const fotoAprendiz = tr.getAttribute("data-foto");
                    const fichaNumero = tr.getAttribute("data-ficha-numero");
                    const fichaNombre = tr.getAttribute("data-ficha-nombre");

                    document.getElementById("documentoComite").value = documentoAprendiz;
                    document.getElementById("nombreCompletoComite").value = nombreCompleto;
                    document.getElementById("fotoComite").src = fotoAprendiz;
                    document.getElementById("fichaNumeroComite").value = fichaNumero;
                    document.getElementById("fichaNombreComite").value = fichaNombre;
                    document.getElementById("idAprendizComite").value = idAprendiz;

                    comiteModal.style.display = "block";
                });
            });

            closeComiteModal.onclick = function() {
                comiteModal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == comiteModal) {
                    comiteModal.style.display = "none";
                }
            }

            // Formulario de agregar comité
            document.getElementById('comiteAprendizForm').addEventListener('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                formData.append('id_ficha', <?php echo $id_ficha; ?>);

                var numComite = document.querySelector('.abrir-comite option:checked').value;
                formData.append('num_comite', numComite);

                fetch('../controllers/agregar_comite.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Éxito',
                                text: 'Comité guardado correctamente.',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Hubo un problema al realizar la operación: ' + data.message
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al procesar la solicitud.'
                        });
                    });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const addAprendizModal = document.getElementById("addAprendizModal");
            const openAddAprendizModal = document.getElementById("openAddAprendizModal");
            const closeAddAprendizModal = addAprendizModal.querySelector(".close");

            openAddAprendizModal.onclick = function() {
                addAprendizModal.style.display = "block";
            }

            closeAddAprendizModal.onclick = function() {
                addAprendizModal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == addAprendizModal) {
                    addAprendizModal.style.display = "none";
                }
            }

            // Lógica para manejar el envío del formulario de agregar aprendiz
            document.getElementById('addAprendizForm').addEventListener('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                formData.append('id_ficha', <?php echo $id_ficha; ?>);

                fetch('../controllers/guardar_aprendiz.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Mostrar modal de éxito usando SweetAlert
                            Swal.fire({
                                icon: 'success',
                                title: 'Éxito',
                                text: 'El aprendiz se registró correctamente.',
                                showConfirmButton: false,
                                timer: 1500


                            });


                            // Cerrar el modal de agregar aprendiz después de un breve período
                            setTimeout(function() {
                                addAprendizModal.style.display = "none";
                            }, 1500);

                            // Opcional: Puedes actualizar la lista de aprendices aquí sin recargar la página
                            // Implementa la lógica para actualizar la lista según tu estructura actual

                        } else {
                            // Mostrar modal de error si no se pudo guardar el aprendiz
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al guardar el aprendiz: ' + data.message
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un error en el servidor: ' + error.message
                        });
                    });
            });
        });



        function guardarAprendiz() {
            // Obtener referencia al formulario
            var form = document.getElementById('form-aprendiz');

            // Crear objeto FormData para enviar los datos del formulario
            var formData = new FormData(form);

            // Configurar una solicitud AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../controllers/guardar_aprendiz.php', true);

            // Manejar la respuesta de la solicitud
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 400) {
                    // Éxito en la solicitud
                    var respuesta = xhr.responseText;
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'El aprendiz se ha guardado correctamente.',
                        showConfirmButton: false,
                        timer: 2000

                    });
                    // Actualizar la página
                    location.reload();
                    // Puedes manejar la respuesta aquí si es necesario
                    // Actualizar la lista de aprendices
                    actualizarListaAprendices();

                    // Puedes cerrar el modal, recargar la página, mostrar un mensaje de éxito, etc.
                    cerrarModal();
                } else {
                    // Error en la solicitud
                    console.error('Error en la solicitud: ' + xhr.status);
                    // Aquí puedes manejar el error, mostrar un mensaje de error, etc.
                }
            };

            // Enviar el formulario
            xhr.send(formData);
        }

        // Función para cerrar el modal de agregar aprendiz
        function cerrarModal() {
            addAprendizModal.style.display = "none";
        }

        // Función para actualizar la lista de aprendices después de agregar uno nuevo
        function actualizarListaAprendices() {
            fetch('../controllers/obtener_aprendiz.php?id_ficha=<?php echo $id_ficha; ?>')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('table tbody');
                    tableBody.innerHTML = ''; // Limpiar contenido actual de la tabla

                    if (data.error) {
                        console.error('Error al obtener los datos:', data.error);
                        // Manejar el error si ocurre alguno
                        tableBody.innerHTML = `<tr><td colspan="6">${data.error}</td></tr>`;
                    } else {
                        // Iterar sobre los aprendices y agregar filas a la tabla
                        data.aprendices.forEach(aprendiz => {
                            const row = document.createElement('tr');
                            // Construir la ruta de la imagen del aprendiz
                            const imagenAprendiz = aprendiz.Imagen ? `../public/img/${aprendiz.Imagen}` : '../public/img/ruta_por_defecto_si_no_hay_imagen.jpg';
                            row.innerHTML = `
                        <td>${aprendiz.Tipo_Documento}</td>
                        <td>${aprendiz.Numero_Documento}</td>
                        <td>${aprendiz.Primer_Nombre} ${aprendiz.Segundo_Nombre} ${aprendiz.Primer_Apellido} ${aprendiz.Segundo_Apellido}</td>
                        <td>${aprendiz.Email}</td>
                        <td><img src="${imagenAprendiz}" alt="Foto del Aprendiz" style="width: 100px; height: 100px;"></td>
                        <td>
                            <select class='form-select abrir-comite' data-id='${aprendiz.ID_Aprendiz}' data-documento='${aprendiz.Numero_Documento}'>
                                <option value='' disabled selected>Abrir Comité</option>
                                <option value='1'>Comité 1</option>
                                <option value='2'>Comité 2</option>
                                <option value='3'>Comité 3</option>
                                <option value='4'>Comité 4</option>
                                <option value='5'>Comité 5</option>
                                <option value='6'>Comité 6</option>
                            </select>
                            <a href='lista_comite.php?id_aprendiz=${aprendiz.ID_Aprendiz}' class='btn btn-secondary' id='verComites-${aprendiz.ID_Aprendiz}'>Ver Comités</a>
                        </td>
                    `;
                            tableBody.appendChild(row);
                        });

                        // Añadir evento change a los select de abrir comité
                        const selects = document.querySelectorAll('.abrir-comite');
                        selects.forEach(select => {
                            select.addEventListener('change', function() {
                                const idAprendiz = this.getAttribute('data-id');
                                const numeroDocumento = this.getAttribute('data-documento');
                                const comiteSeleccionado = this.value;

                                // Obtener el enlace para ver comités y simular clic
                                const verComitesLink = document.getElementById(`verComites-${idAprendiz}`);
                                if (verComitesLink) {
                                    verComitesLink.click();
                                }
                            });
                        });
                    }
                })
                .catch(error => {
                    console.error('Error al obtener la lista de aprendices:', error);
                    // Manejar el error si la solicitud fetch falla
                    const tableBody = document.querySelector('table tbody');
                    tableBody.innerHTML = `<tr><td colspan="6">Error al obtener la lista de aprendices.</td></tr>`;
                });
        }
    </script>
</body>

</html>