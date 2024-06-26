<?php
session_start();
include("../model/config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: ../index.php");
    exit();
}

// Obtener los datos para los select usando PDO
try {
    $regionales = $pdo->query("SELECT id, nombre FROM regional")->fetchAll(PDO::FETCH_ASSOC);
    $formaciones = $pdo->query("SELECT id, nombre FROM formacion")->fetchAll(PDO::FETCH_ASSOC);
    $modalidades = $pdo->query("SELECT id, nombre FROM modalidad")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener los datos: " . $e->getMessage();
    die();
}
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
                try {
                    $stmt = $pdo->query("SELECT * FROM ficha");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr class='fila'>
                                <td>{$row['Numero_Ficha']}</td>
                                <td>{$row['Nombre_Ficha']}</td>
                                <td>
                                    <a href='aprendices.php?id_ficha={$row['ID_Ficha']}' class='btn btn-primary'>Aprendices</a>
                                    <a href='lista_general.php?id_ficha={$row['ID_Ficha']}' class='btn btn-secondary'>Lista General</a>
                                </td>
                              </tr>";
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='3'>Error al cargar las fichas: " . $e->getMessage() . "</td></tr>";
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

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../static/js/listas_ficha.js"></script>
</body>
</html>