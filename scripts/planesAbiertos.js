/**
* Lógica para el carrusel de tarjetas (recomendaciones)
* Muestra el siguiente grupo de 2 tarjetas cada 5 segundos.
*/
document.addEventListener('DOMContentLoaded', () => {

    const base = window.location.pathname.split('/')[1];

    let listadoMunicipios = {"1": "Medellin", "2": "Bello", "3": "Girardota"};

    // Recuperación de parametros recibidos por la url usando get
    const parametro = new URLSearchParams(window.location.search);
    const nombreSugerencia = parametro.get("nombre");
    const tipoActSugerencia = parametro.get("tipoActividad");
    const direccionSugerencia = parametro.get("direccion");
    const municipioSugerencia = parametro.get("municipio");

    function obtenerKeyPorValor(objeto, valor) {
        return Object.keys(objeto).find(key => objeto[key] === valor);
    }
    const keyMunicipio = obtenerKeyPorValor(listadoMunicipios, municipioSugerencia);

    // Si hay parametros en la URL, llenar el formulario con esos valores   
    if (nombreSugerencia || tipoActSugerencia || direccionSugerencia || municipioSugerencia) {
        if (nombreSugerencia) {
            document.getElementById('lugarPlan').value = nombreSugerencia;
        }
        if (tipoActSugerencia) {
            document.getElementById('tipoActividadPlan').value = tipoActSugerencia;
        }
        if (direccionSugerencia) {
            document.getElementById('direccionPlan').value = direccionSugerencia;
        }
        if (municipioSugerencia && keyMunicipio) {
            document.getElementById('municipioPlan').value = keyMunicipio;
        }
    }

    const openMenuBtn = document.getElementById('open-menu-btn');
    const closeMenuBtn = document.getElementById('close-menu-btn');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
    const btnCrearPlan = document.getElementById('btn-crearPlan');
    const btnConfirmarModificacion = document.getElementById('btn-confirmarModificacion');
    const formCrearPlan = document.getElementById('form-crearPlan');
    
    inicializarCarruselTarjetas(); // Inicializar el carrusel
    obtenerPlanesUsuario(); // Listar los planes del usuario
    limitarInputFecha('fechaPlan');

    // Establece el mínimo para inputs date / datetime-local a partir del momento actual
    function limitarInputFecha(id) {
        const input = document.getElementById(id);
        if (!input) return;
        const now = new Date();

        const yyyy = now.getFullYear();
        const mm = String(now.getMonth() + 1).padStart(2, '0');
        const dd = String(now.getDate()).padStart(2, '0');

        if (input.type === 'datetime-local') {
            const hh = String(now.getHours()).padStart(2, '0');
            const min = String(now.getMinutes()).padStart(2, '0');
            input.setAttribute('min', `${yyyy}-${mm}-${dd}T${hh}:${min}`);
        } else if (input.type === 'date') {
            input.setAttribute('min', `${yyyy}-${mm}-${dd}`);
        }
    }

    // Función para abrir el menú
    const openMenu = () => {
        // Muestra el overlay
        mobileMenuOverlay.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    // Función para cerrar el menú
    const closeMenu = () => {
        // Oculta el overlay
        mobileMenuOverlay.style.display = 'none';
        // Habilita el scroll en el body
        document.body.style.overflow = 'auto';
    };
    
    // Evento para el botón de abrir (icono de hamburguesa)
    if (openMenuBtn) {
        openMenuBtn.addEventListener('click', openMenu);
    }
    
    // Evento para el botón de cerrar (la 'X')
    if (closeMenuBtn) {
        closeMenuBtn.addEventListener('click', closeMenu);
    }
    
    // Cerrar menú al hacer clic en una opción
    const mobileMenuItems = document.querySelectorAll('.mobile-nav-menu a');
    mobileMenuItems.forEach(item => {
        item.addEventListener('click', closeMenu);
    });
    
    // si el usuario agranda la pantalla por encima de 520px mientras el menú está abierto.
    window.addEventListener('resize', () => {
        if (window.innerWidth > 520) {
            closeMenu();
        }
    });
    
    // evento para simular el input type="file" y mostrar el nombre del archivo seleccionado (seguro si falta el elemento)
    const fotoPlanEl = document.getElementById('fotoPlan');
    if (fotoPlanEl) {
        fotoPlanEl.addEventListener('change', function() {
            const fileName = this.files.length > 0 ? this.files[0].name : 'Selecciona un archivo...';
            const display = document.getElementById('file-name-display');
            if (display) display.value = fileName;
            checkFormCompleteness();
        });
    } else {
        console.warn('Elemento #fotoPlan no encontrado en el DOM.');
    }

    // Evitar que se escriban caracteres distintos a letras y espacios en nombrePlan
    const inputNombrePlan = document.getElementById('nombrePlan');
    if (inputNombrePlan) {
        inputNombrePlan.addEventListener('input', () => {
            inputNombrePlan.value = inputNombrePlan.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúñÑ\s]/g, '');
            checkFormCompleteness();
        });
    }

    // Función que decide si habilitar el botón de crear
    function checkFormCompleteness() {
        if (!formCrearPlan || !btnCrearPlan) return;
        const controls = Array.from(formCrearPlan.querySelectorAll('input, select, textarea'));
        let todosLlenos = true;

        controls.forEach(el => {
            // Ignorar controles que no deben bloquear el botón
            if (el.type === 'file' || el.type === 'hidden' || el.disabled) return;
            if (el.tagName === 'BUTTON' || el.type === 'submit' || el.type === 'button') return;

            // Considerar como vacío solo strings vacíos (trim)
            if (el.value == null || String(el.value).trim() === '') {
                todosLlenos = false;
            }
        });

        btnCrearPlan.disabled = !todosLlenos;
        btnCrearPlan.classList.toggle('disabled', !todosLlenos);
    }

    // mantener el botón de "Crear plan" deshabilitado hasta que todos los campos del form esten llenos
    // inicializar estado seguro
    if (btnCrearPlan) {
        btnCrearPlan.disabled = true;
        btnCrearPlan.classList.add('disabled');
    }

    if (formCrearPlan) {
        // ejecutar al cargar (por si hay valores pre-llenados)
        checkFormCompleteness();

        // escuchar cambios de todos los inputs/selects/textarea
        formCrearPlan.addEventListener('input', checkFormCompleteness);
        formCrearPlan.addEventListener('change', checkFormCompleteness);
    } else {
        console.warn('Elemento #form-crearPlan no encontrado en el DOM.');
    }

    // Función para inicializar el carrusel de tarjetas
    function inicializarCarruselTarjetas() {
        // Obtenemos todos los contenedores de grupos de tarjetas
        const gruposTarjetas = document.querySelectorAll('.grupo-tarjetas');
        
        // Índice del grupo de tarjetas que se está mostrando actualmente
        let indiceActual = 0;
        // Tiempo de espera en milisegundos (5 segundos)
        const tiempoEspera = 5000; 
        
        
        // Funcion para mostrar el siguiente grupo de tarjetas
        function mostrarSiguienteGrupo() {
            // Ocultar el grupo de tarjetas actual
            gruposTarjetas[indiceActual].classList.add('hidden');
            
            // Calcular el siguiente índice (ciclo: 0 -> 1 -> 2 -> 0) se usa operador módulo (%) para volver al inicio (0) cuando llegamos al final.
            // La longitud de gruposTarjetas es 3.
            indiceActual = (indiceActual + 1) % gruposTarjetas.length;
            
            // Mostrar el nuevo grupo de tarjetas
            gruposTarjetas[indiceActual].classList.remove('hidden');
        }
        
        // Realizar el intercambio cada 5 segundos
        setInterval(mostrarSiguienteGrupo, tiempoEspera);
    }

    // mantener el botón de "Crear plan" deshabilitado hasta que todos los campos del form esten llenos
    // inicializar estado seguro
    if (btnCrearPlan) {
        btnCrearPlan.disabled = true;
        btnCrearPlan.classList.add('disabled');
    }

    formCrearPlan.addEventListener('input', () => {
        let todosLlenos = true;
        const inputs = formCrearPlan.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (input.value.trim() === '') {
                todosLlenos = false;
            }
        });
        btnCrearPlan.disabled = !todosLlenos;
        btnCrearPlan.classList.toggle('disabled', !todosLlenos);
    });

    // Funcion para generar las tarjetas de planes
    function generarTarjetasPlanes(respuestaPlanes) {
        const contenedorPlanes = document.querySelector('.container-misPlanes');
        contenedorPlanes.innerHTML = ''; // Limpiar contenido previo

        if (respuestaPlanes.length > 0) {
            respuestaPlanes.forEach(plan => {
            const planDiv = document.createElement('div');
            planDiv.classList.add('plan-item');

            // Atributos data para guardar la información del plan
            planDiv.setAttribute('data-id', plan.Id);
            planDiv.setAttribute('data-descripcion', plan.Descripcion);
            planDiv.setAttribute('data-direccion', plan.Direccion);
            planDiv.setAttribute('data-edadMinima', plan.EdadMinima);
            planDiv.setAttribute('data-fecha', plan.Fecha);
            planDiv.setAttribute('data-foto', plan.Foto);
            planDiv.setAttribute('data-cantidadPersonas', plan.CantidadPersonas);
            planDiv.setAttribute('data-idMunicipio', plan.IdMunicipio);
            planDiv.setAttribute('data-idSugerencia', plan.IdSugerencia);
            planDiv.setAttribute('data-idUsuario', plan.IdUsuario);
            planDiv.setAttribute('data-lugar', plan.Lugar);
            planDiv.setAttribute('data-nombre', plan.Nombre);
            planDiv.setAttribute('data-tipoActividad', plan.TipoActividad);
            planDiv.setAttribute('data-visibilidad', plan.Visibilidad);

            planDiv.innerHTML = `
                <div class="plan-image-and-info-container">
                    <div class="plan-image-container">
                        <img src="/${base}/${plan.Foto}" alt="Imagen del plan ${plan.Nombre}">
                    </div>
                    <div class="plan-text-primary">
                        <h3 class="plan-title">${plan.Nombre}</h3>
                        <p class="plan-location">${plan.Lugar}</p>
                        <p class="plan-address">${listadoMunicipios[plan.IdMunicipio]}, ${plan.Direccion}</p>
                    </div>
                </div>
                <div class="plan-description-desktop">
                    ${plan.Descripcion}
                </div>
                <div class="plan-actions">
                    <button class="btn-action btn-modify">MODIFICAR</button>
                    <button class="btn-action btn-cancel" style="display: none;">CANCELAR</button>
                    <button class="btn-action btn-deletePlan">BORRAR</button>
                </div>
            `;
            contenedorPlanes.appendChild(planDiv);
            });
        } else {
            contenedorPlanes.innerHTML = `<p style="text-align: center;">No tienes planes abiertos</p>`
        }
    }

    // Funcion para obtener los planes del usuario
    function obtenerPlanesUsuario() {
        //let idUsuario = 1; // Simulación de usuario logueado
        let formData = new FormData();
        formData.append("idUsuario", idUsuarioSesion["id"]);

        $.ajax({
            url: `/${base}/backend/controllers/planController.php?accion=listarPlanesUsuario`,
            type: 'POST',
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(response) {

                if (response.error) {
                    Swal.fire("Error", response.error, "error");
                    return;
                }

                // Genenerar las tarjetas de planes
                generarTarjetasPlanes(response);
            },
            error: function(xhr) {
                console.log("Status:", xhr.status);
                console.log("Response:", xhr.responseText);
                console.log("Objeto completo:", xhr);
            }
        });
    }

    // Evento para detectar clic sobre el btn de modificar plan
    document.querySelector('.container-misPlanes').addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-modify')) {
            const planItem = e.target.closest('.plan-item');

            // Llenar el formulario con los datos del plan
            document.getElementById('idPlan').value = planItem.getAttribute('data-id');
            document.getElementById('idUsuario').value = planItem.getAttribute('data-idUsuario');
            document.getElementById('nombrePlan').value = planItem.getAttribute('data-nombre');
            document.getElementById('descripcionPlan').value = planItem.getAttribute('data-descripcion');
            document.getElementById('tipoActividadPlan').value = planItem.getAttribute('data-tipoActividad');
            document.getElementById('fechaPlan').value = planItem.getAttribute('data-fecha');
            document.getElementById('direccionPlan').value = planItem.getAttribute('data-direccion');
            document.getElementById('visibilidadPlan').value = planItem.getAttribute('data-visibilidad');
            document.getElementById('cantidadPersonasPlan').value = planItem.getAttribute('data-cantidadPersonas');
            document.getElementById('municipioPlan').value = planItem.getAttribute('data-idMunicipio');
            document.getElementById('lugarPlan').value = planItem.getAttribute('data-lugar');
            document.getElementById('edadMinimaPlan').value = planItem.getAttribute('data-edadMinima');
            // document.getElementById('idSugerenciaPlan').value = planItem.getAttribute('data-idSugerencia');

            // Cambiar el boton de crear por confirmar
            btnCrearPlan.style.display = 'none';
            btnConfirmarModificacion.style.display = 'block';

            // Cambiar el boton de modificar por cancelar
            e.target.style.display = 'none';
            const btnCancelar = planItem.querySelector('.btn-cancel');
            btnCancelar.style.display = 'block';
        }
    });
    
    // Cuando se le clic al btn de cancelar se limpia todo el formulario, el boton de confirmar cambia a crear y el boton de cancelar pasa a modificar
    document.querySelector('.container-misPlanes').addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-cancel')) {
            // Limpiar el formulario
            formCrearPlan.reset();
            // Cambiar el boton de confirmar por crear
            btnCrearPlan.style.display = 'block';
            btnConfirmarModificacion.style.display = 'none';
            // Cambiar el boton de cancelar por modificar
            e.target.style.display = 'none';
            const planItem = e.target.closest('.plan-item');
            const btnModificar = planItem.querySelector('.btn-modify');
            btnModificar.style.display = 'block';
        }
    });

    // Funcion para modificar un plan abierto
    function modificarPlanAbierto() {
        // Obtener la imagen
        let archivo = document.getElementById('fotoPlan').files[0];

        if (!archivo) {
            Swal.fire({
                icon: "warning",
                // title: "Oops...",
                text: "Debes seleccionar una imagen para continuar.",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#ffe029",
            });
            return;
        }

        // Crear FormData y agregar datos
        let formData = new FormData();
        formData.append('accion', 'modificar');
        formData.append('idPlan', document.getElementById('idPlan').value);
        formData.append('nombre', document.getElementById('nombrePlan').value);
        formData.append('descripcion', document.getElementById('descripcionPlan').value);
        formData.append('foto', archivo);
        formData.append('tipoActividad', document.getElementById('tipoActividadPlan').value);
        formData.append('fecha', document.getElementById('fechaPlan').value);
        formData.append('direccion', document.getElementById('direccionPlan').value);
        formData.append('visibilidad', document.getElementById('visibilidadPlan').value);
        formData.append('cantidadPersonas', document.getElementById('cantidadPersonasPlan').value);
        formData.append('idMunicipio', document.getElementById('municipioPlan').value);
        formData.append('idUsuario', document.getElementById('idUsuario').value);
        formData.append('lugar', document.getElementById('lugarPlan').value);

        // Manejo seguro de idSugerencia
        let idSug = document.getElementById('idSugerenciaPlan') ? document.getElementById('idSugerenciaPlan').value : null;

        formData.append('idSugerencia', idSug && idSug !== "" ? idSug : null);

        formData.append('edadMinima', document.getElementById('edadMinimaPlan').value);

        //Enviar petición AJAX
        $.ajax({
            url: `/${base}/backend/controllers/planController.php?accion=modificar`,
            type: 'POST',
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.error) {
                    Swal.fire("Error", response.error, "error");
                    return;
                }
         
                Swal.fire({
                    title: "¡Plan modificado exitosamente!",
                    text: "Tu plan abierto ha sido modificado correctamente.",
                    icon: "success"
                }).then(() => window.location.reload());
            },
            error: function(xhr) {
                console.log("Status:", xhr.status);
                console.log("Response:", xhr.responseText);
                console.log("Objeto completo:", xhr);
            }
        });
    }

    // Evento para detectar clic sobre el btn de confirmar modificacion
    btnConfirmarModificacion.addEventListener('click', function (e) {
        e.preventDefault();

        // Validar que los campos numericos sean positivos y válidos
        let edadMinima = document.getElementById('edadMinimaPlan');
        let cantidadPersonas = document.getElementById('cantidadPersonasPlan');
        if (edadMinima.value < 18 || cantidadPersonas.value <= 0) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "La edad mínima debe ser 18 y cantidad de personas deben ser un valor mayor a 0.",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#ffe029",
            });
            return;
        } 

        modificarPlanAbierto();
    });

    // Funcion para insertar un nuevo plan abierto
    function insertarPlanAbierto() {
        // Obtener la imagen
        let archivo = document.getElementById('fotoPlan').files[0];

        if (!archivo) {
            Swal.fire({
                icon: "warning",
                text: "Debes seleccionar una imagen para continuar.",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#ffe029",
            });
            return;
        }

        // Crear FormData y agregar datos
        let formData = new FormData();
        formData.append('accion', 'insertar');
        formData.append('nombre', document.getElementById('nombrePlan').value);
        formData.append('descripcion', document.getElementById('descripcionPlan').value);
        formData.append('foto', archivo);
        formData.append('tipoActividad', document.getElementById('tipoActividadPlan').value);
        formData.append('fecha', document.getElementById('fechaPlan').value);
        formData.append('direccion', document.getElementById('direccionPlan').value);
        formData.append('visibilidad', document.getElementById('visibilidadPlan').value);
        formData.append('cantidadPersonas', document.getElementById('cantidadPersonasPlan').value);
        formData.append('idMunicipio', document.getElementById('municipioPlan').value);
        formData.append('idUsuario', idUsuarioSesion["id"]);
        formData.append('lugar', document.getElementById('lugarPlan').value);

        // Manejo seguro de idSugerencia
        let idSug = document.getElementById('idSugerenciaPlan') ? document.getElementById('idSugerenciaPlan').value : null;

        formData.append('idSugerencia', idSug && idSug !== "" ? idSug : null);

        formData.append('edadMinima', document.getElementById('edadMinimaPlan').value);

        // Enviar petición AJAX
        $.ajax({
            url: `/${base}/backend/controllers/planController.php?accion=insertar`,
            type: 'POST',
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(response) {

                if (response.error) {
                    Swal.fire("Error", response.error, "error");
                    return;
                }
                
                Swal.fire({
                    title: "¡Plan creado exitosamente!",
                    text: "Tu plan abierto ha sido creado correctamente.",
                    icon: "success"
                }).then(() => window.location.reload());
            },
            error: function(xhr) {
                console.log("Status:", xhr.status);
                console.log("Response:", xhr.responseText);
                console.log("Objeto completo:", xhr);
            }
        });
    }

    btnCrearPlan.addEventListener('click', function (e) {
        e.preventDefault();

        // Validar que los campos numericos sean positivos y válidos
        let edadMinima = document.getElementById('edadMinimaPlan');
        let cantidadPersonas = document.getElementById('cantidadPersonasPlan');
        if (edadMinima.value < 18 || cantidadPersonas.value <= 0) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "La edad mínima debe ser 18 y cantidad de personas deben ser un valor mayor a 0.",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#ffe029",
            });
            return;
        } 

        insertarPlanAbierto();
    });

    // Funcion para insertar un nuevo plan abierto
    function eliminarPlan(planId) {
        // Crear FormData y agregar datos
        let formData = new FormData();
        formData.append('accion', 'eliminar');
        formData.append('idPlan', planId);

        // Enviar petición AJAX
        $.ajax({
            url: `/${base}/backend/controllers/planController.php?accion=eliminar`,
            type: 'POST',
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(response) {

                if (response.error) {
                    Swal.fire("Error", response.error, "error");
                    return;
                }
                
                Swal.fire({
                    title: "¡Plan eliminado exitosamente!",
                    text: "Tu plan abierto ha sido eliminado correctamente.",
                    icon: "success"
                }).then(() => window.location.reload());
            },
            error: function(xhr) {
                console.log("Status:", xhr.status);
                console.log("Response:", xhr.responseText);
                console.log("Objeto completo:", xhr);
            }
        });
    }

    // Evento para detectar clic sobre el btn de eliminar plan
    document.querySelector('.container-misPlanes').addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-deletePlan')) {
            const planItem = e.target.closest('.plan-item');
            const planId = planItem.getAttribute('data-id');

            Swal.fire({
                title: "¿Está seguro?",
                text: "El plan será eliminado definitivamente!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ffe029",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Eliminar el plan
                    eliminarPlan(planId);
                }
            });
        }
    });

    // Quitar parámetros de la URL sin recargar
    if (window.history && history.replaceState) {
        const urlSinParams = window.location.pathname + window.location.hash; // conserva hash si lo necesitas
        history.replaceState({}, '', urlSinParams);
    }
    
});