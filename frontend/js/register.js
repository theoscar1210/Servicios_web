document
  .getElementById("registerForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const usuario = document.getElementById("usuario").value;
    const password = document.getElementById("password").value;

    console.log("Usuario:", usuario); // Solo para verificar en consola
    console.log("Contraseña:", password);

    fetch("http://localhost/Servicios_web/Api-Auth/db/endpoints/register.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        usuario: usuario,
        password: password,
      }),
    })
      .then((res) => res.json())
      .then((data) => {
        console.log(data);
        alert(data.mensaje); // Opcional, para mostrar el mensaje
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  });
