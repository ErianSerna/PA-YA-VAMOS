//esperar a que el contenido de la pagina este cargada
document.addEventListener("DOMContentLoaded",() => {
    // selecciono el formulario del cual escuchare el enivo
    const form = document.querySelector("form");
    form.addEventListener("submit",function(event){
        //evito el envio por defecto
        event.preventDefault();
        //validacion de las contraseñas
        const password = form.elements["password"].value;
        const passwordConfirm = form.elements["passwordConfirm"].value;
        if(password !== passwordConfirm){
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Las contraseñas no coinciden.",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#ffe029",
            });
            return;
        }
        Swal.fire({
            title: "¡Registro exitoso!",
            text: "Tu cuenta ha sido creada correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
            confirmButtonColor: "#ffe029",
            }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});