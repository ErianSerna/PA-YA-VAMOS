document.addEventListener("DOMContentLoaded", () => {

    const base = window.location.pathname.split('/')[1];

    const form = document.querySelector("#formLogin");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Evitar submit clásico

        // Obtener valores
        const correo = form.elements["email"].value;
        const password = form.elements["password"].value;

        consultarUsuarioLogin(correo, password);
    });

    // Función para enviar al backend
    async function consultarUsuarioLogin(correo, contrasena) {
        try {
            let datos_form = {

                usuario_correo: correo,
                usuario_contrasena: contrasena,
                accion: "consultarUsuario"
            };

            let respuesta = await fetch(`/${base}/backend/controllers/usuarioController.php?accion=consultarUsuario`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(datos_form),
            });

            const respuestaTexto = await respuesta.text();

            if (!respuesta.ok) {
                Swal.fire({
                    title: "Error",
                    text: "No se pudo iniciar sesión.",
                    icon: "error"
                });
                return;
            }

            const datosRespuesta = JSON.parse(respuestaTexto);

            if (datosRespuesta.mensaje) {
                Swal.fire({
                    title: "Error",
                    text: datosRespuesta.mensaje,
                    icon: "error"
                });
                return;
            }

            // Inicio de sesión exitoso
            window.location.href = "index.php";


        } catch (error) {
            Swal.fire({
                title: "Error inesperado",
                text: "Intenta nuevamente.",
                icon: "error"
            });
        }
    }

});
