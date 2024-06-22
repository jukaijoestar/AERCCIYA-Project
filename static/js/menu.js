document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("search");
  const employeeTable = document.getElementById("table");
  const rows = employeeTable.getElementsByTagName("tr");

  searchInput.addEventListener("input", function () {
    const searchTerm = searchInput.value.toLowerCase();

    for (let i = 1; i < rows.length; i++) {
      const rowData = rows[i].textContent.toLowerCase();
      if (rowData.includes(searchTerm)) {
        rows[i].style.display = "";
      } else {
        rows[i].style.display = "none";
      }
    }
  });
});

$(document).ready(function () {
  $("#Dashboard").click(function () {
    $(this).next("#menu-desplegable").slideToggle();
    $(this).toggleClass("active");
  });
});

let modo = document.getElementById("modo");
let body = document.body;

modo.addEventListener("click", function () {
  let val = body.classList.toggle("dark");
  localStorage.setItem("modo", val);

  if (val) {
    modo.setAttribute("class", "ph ph-cloud-sun");
  } else {
    modo.setAttribute("class", "ph ph-cloud-moon");
  }
});

let valor = localStorage.getItem("modo");

if (valor === "true") {
  body.classList.add("dark");
  modo.setAttribute("class", "ph ph-cloud-sun");
} else {
  body.classList.remove("dark");
  modo.setAttribute("class", "ph ph-cloud-moon");
}

function confirmLogout(event) {
  event.preventDefault();

  Swal.fire({
    title: "¿Estás seguro de cerrar sesión?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, cerrar sesión",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "../controllers/logout.php";
    }
  });
}
