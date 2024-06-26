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
