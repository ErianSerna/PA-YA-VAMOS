document.addEventListener("DOMContentLoaded", () => {

    const base = window.location.pathname.split('/')[1];

    const url_controlador = "http://localhost/backend/controllers/UsuarioController.php";

    const form = document.querySelector("#formRegister");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Evitar submit clásico

        // Obtener valores
        const nombre = form.elements["nombre"].value;
        const apellido = form.elements["lastName"].value;
        const fechaNacimiento = form.elements["birthdate"].value;

        const idMunicipio = form.elements["city"].value;
        const correo = form.elements["email"].value;
        const password = form.elements["password"].value;
        const passwordConfirm = form.elements["passwordConfirm"].value;

        // Calcular el año de nacimiento
        const anioActual = new Date().getFullYear();
        let edad = anioActual - (fechaNacimiento.split('-')[0]);

        if (edad < 18) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Debes ser mayor de edad.",
                confirmButtonColor: "#ffe029"
            });
            return;
        }

        // Validación de contraseñas
        if (password !== passwordConfirm) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Las contraseñas no coinciden.",
                confirmButtonColor: "#ffe029"
            });
            return;
        }
        
        insertarUsuario(
            nombre,
            apellido,
            correo,
            password,
            fechaNacimiento,
            idMunicipio
        );
    });

    // Función para enviar al backend
    async function insertarUsuario(nombre, apellido, correo, contrasena, fechaNacimiento, idMunicipio) {
        try {
            let datos_form = {
                usuario_nombre: nombre,
                usuario_apellido: apellido,
                usuario_correo: correo,
                usuario_contrasena: contrasena,
                usuario_fechaNacimiento: fechaNacimiento,
                usuario_idMunicipio: idMunicipio,
                accion: "insertar"
            };

            let respuesta = await fetch(`/${base}/backend/controllers/usuarioController.php?accion=insertar`, {
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
                    text: "No se pudo registrar el usuario.",
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

            // Usuario guardado correctamente → ir al login
            Swal.fire({
                title: "Registro exitoso",
                text: "Tu cuenta ha sido creada correctamente.",
                icon: "success",
                confirmButtonColor: "#ffe029"
            }).then(() => {
                window.location.href = "login.php";
            });

        } catch (error) {
            Swal.fire({
                title: "Error inesperado",
                text: "Intenta nuevamente.",
                icon: "error"
            });
        }
    }

});
