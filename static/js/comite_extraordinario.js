$(document).ready(function () {
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
        type: "POST",
        url: "../controllers/get_fichas.php",
        data: {
          id_centro: id_centro,
          formacion_id: id_formacion,
          modalidad_id: id_modalidad,
        },
        success: function (html) {
          $("#ficha").html(html);
        },
      });
    } else {
      $("#ficha").html('<option value="">Seleccionar Ficha</option>');
    }
  }

  // Evento de cambio para regional
  $("#regional").change(function () {
    id_regional = $(this).val();
    if (id_regional) {
      $.ajax({
        type: "POST",
        url: "../controllers/get_centros.php",
        data: {
          id_regional: id_regional,
        },
        success: function (html) {
          $("#centro").html(html);
          id_centro = null; // Resetear la selección de centro
          $("#ficha").html('<option value="">Seleccionar Ficha</option>');
        },
      });
    } else {
      $("#centro").html('<option value="">Seleccionar Centro</option>');
      $("#ficha").html('<option value="">Seleccionar Ficha</option>');
    }
  });

  // Evento de cambio para centro
  $("#centro").change(function () {
    id_centro = $(this).val();
    updateFichas();
  });

  // Evento de cambio para formacion
  $("#formacion").change(function () {
    id_formacion = $(this).val();
    updateFichas();
  });

  // Evento de cambio para modalidad
  $("#modalidad").change(function () {
    id_modalidad = $(this).val();
    updateFichas();
  });

  $("#ficha").change(function () {
    var id_ficha = $(this).val();
    if (id_ficha) {
      $.ajax({
        type: "POST",
        url: "../controllers/obtener_aprendices.php",
        data: {
          id_ficha: id_ficha,
        },
        success: function (response) {
          var aprendices = JSON.parse(response);
          var tabla = $("#tabla-aprendices .row:not(.header)");
          tabla.remove(); // Eliminar filas anteriores
          aprendices.forEach(function (aprendiz) {
            $("#tabla-aprendices").append(
              '<div class="row">' +
                '<div class="cell">' +
                aprendiz.Numero_Documento +
                "</div>" +
                '<div class="cell">' +
                aprendiz.Primer_Nombre +
                " " +
                aprendiz.Segundo_Nombre +
                " " +
                aprendiz.Primer_Apellido +
                " " +
                aprendiz.Segundo_Apellido +
                "</div>" +
                '<div class="cell">' +
                aprendiz.Telefono +
                "</div>" +
                '<div class="cell"><input type="text" name="observaciones[' +
                aprendiz.ID_Aprendiz +
                ']" placeholder="Añadir observaciones" required></div>' +
                '<div class="cell">' +
                '<select name="accion[' +
                aprendiz.ID_Aprendiz +
                ']">' +
                '<option value="ninguno">Ningúno</option>' +
                '<option value="reconocimiento">Reconocimiento</option>' +
                '<option value="remision">Remisión a psicología</option>' +
                '<option value="llamado">Llamado de atención</option>' +
                "</select>" +
                "</div>" +
                '<input type="hidden" name="id_aprendiz[]" value="' +
                aprendiz.ID_Aprendiz +
                '">' +
                "</div>"
            );
          });

          // Mostrar u ocultar el contenedor de la tabla en función del número de filas
          if (aprendices.length > 3) {
            $("#table-container-aprendices").css("display", "block");
          } else {
            $("#table-container-aprendices").css("display", "none");
          }
        },
      });
    } else {
      $("#tabla-aprendices .row:not(.header)").remove();
      $("#table-container-aprendices").css("display", "none"); // Ocultar si no hay ficha seleccionada
    }
  });

  $("#iniciar-comite").click(function () {
    var formData = new FormData();

    formData.append("id_ficha", $("#ficha").val());
    formData.append("Acta", $("#Acta").val());
    formData.append("nombre", $("#nombre").val());
    formData.append("fecha", $("#fecha").val());
    formData.append("horaI", $("#horaI").val());
    formData.append("horaF", $("#horaF").val());
    formData.append("puntosD", $("#puntosD").val());
    formData.append("objetivos", $("#objetivos").val());
    formData.append("desarrollo", $("#desarrollo").val());

    // Añadir observaciones y anotaciones de cada aprendiz
    $("#tabla-aprendices .row:not(.header)").each(function () {
      var id_aprendiz = $(this).find('input[type="hidden"]').val();
      var observacion = $(this).find('input[type="text"]').val();
      var accion = $(this).find("select").val();

      if (id_aprendiz) {
        // Asegurarse de que hay un id de aprendiz
        formData.append("observaciones[" + id_aprendiz + "]", observacion);
        formData.append("accion[" + id_aprendiz + "]", accion);
      }
    });

    // Añadir actividades, responsables y fechas
    $('[name="actividad[]"]').each(function (index) {
      formData.append("actividad[" + index + "]", $(this).val());
    });
    $('[name="responsable[]"]').each(function (index) {
      formData.append("responsable[" + index + "]", $(this).val());
    });
    $('[name="fecha_compromiso[]"]').each(function (index) {
      formData.append("fecha_compromiso[" + index + "]", $(this).val());
    });

    // Añadir archivo de asistentes
    var asistentes = $("#asistentes")[0].files[0];
    if (asistentes) {
      formData.append("asistentes", asistentes);
    }

    $.ajax({
      url: "../controllers/guardar_extraordinario.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        // Asumimos que response ya es un objeto JSON porque configuramos el encabezado en PHP
        if (response.status === "success") {
          Swal.fire({
            title: "Éxito",
            text: response.message,
            icon: "success",
            confirmButtonText: "OK",
          }).then(() => {
            // Redirigir a consultar.php con el ID obtenido
            window.location.href =
              "../controllers/consultar.php?id=" + response.id;

            // Esperar 1 segundo antes de redirigir a home.php
            setTimeout(() => {
              window.location.href = "../views/home.php";
            }, 1000);
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            confirmButtonText: "OK",
          });
        }
      },
      error: function (xhr, status, error) {
        Swal.fire({
          title: "Error",
          text: "Hubo un problema al guardar los datos.",
          icon: "error",
          confirmButtonText: "OK",
        });
      },
    });
  });
});
