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