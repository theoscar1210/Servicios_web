document.getElementById("loginForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const usuario = document.getElementById("usuario").value;
  const password = document.getElementById("password").value;

  console.log("Usuario:", usuario);
  console.log("Contraseña:", password);

  fetch("http://localhost/Servicios_web/Api-Auth/db/endpoints/login.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      usuario: usuario,
      password: password,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log("Respuesta del servidor:", data);
      if (data.status === "success") {
        alert("¡Inicio de sesión exitoso!");
        // Redirige o haz algo aquí
        // window.location.href = "menu.html";
      } else {
        alert("Error: " + data.mensaje);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Ocurrió un error en la conexión.");
    });
});
