
document.addEventListener('DOMContentLoaded', () => {
    const openMenuBtn = document.getElementById('open-menu-btn');
    const closeMenuBtn = document.getElementById('close-menu-btn');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
    const btnSearchPlan = document.getElementById('btn-buscarPlan'); 
    const formSearchPlan = document.getElementById('form-buscarPlan');
    const constainerResult = document.getElementById('container-resultados');
    const containerPlanesAbierto = document.getElementById('container-listadoPlanesAbiertos');
    const btnCreatePlan = document.getElementById('btn-crear-plan-nuevo');
    const btnCrearPlanCard = document.querySelector('.btn-crear-plan');

    //URL base de la api
    const urlBase = window.location.origin + '/' + window.location.pathname.split('/')[1];
    const urlController = urlBase + '/backend/controllers/sugerenciaController.php';
    const urlBasePlan = window.location.pathname.split('/')[1];
    
    //elementos del modal
    const modal = document.getElementById('modal-sugerencia');
    const btnCloseModal = document.getElementById('close-modal-btn');

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
    
    //funciones para las sugerencias

    //lo primero que necesito es un metodo para mostrar todas las sugerencias
    async function loadAllSugerencias(){
        try{
            const response = await fetch(urlController, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    accion: 'listar'
                })
            });
            const data = await response.json();
            showSugerencias(data);
        }catch(error){
            console.error('Error al cargar las sugerencias: ',error);
        }
    }

    //luego necesito un metodo para mostrar cada sugerencia
    function showSugerencias(sugerencias){
        constainerResult.innerHTML = ''; //se limpia el contenido
        if (!sugerencias || sugerencias.length === 0) {
            constainerResult.innerHTML = '<p>No se encontraron sugerencias</p>';
            return;
        }
        //ciclo para recorrer las sugerencias
        sugerencias.forEach((sugerencia, index) =>{
            const cards = createCard(sugerencia,index);
            constainerResult.appendChild(cards);
        });
    }

    //finalmente se crea la tarjeta de cada sugerencia
    function createCard(sugerencia,index){
        const card = document.createElement('div');
        card.className = 'card';

        //asignacion de diferentes colores
        const colors = ['card-vEsmeralda', 'card-vBosque', 'card-vOliva', 'card-vLima'];
        const colorAssigned = colors[index % colors.length];
        card.classList.add(colorAssigned);
        card.style.display = 'block';
        //limitar la descripcion para las tarjetas
        const descriptionLimit = sugerencia.Descripcion.length > 70 ? sugerencia.Descripcion.substring(0, 65) + "..." : sugerencia.Descripcion;

        card.innerHTML = `
            <img src="${urlBase}/${sugerencia.Foto}" alt="${sugerencia.Nombre}" onerror="this.src='${urlBase}/images/placeholder.jpg'">
            <div class="card-content">
                <h3>${sugerencia.Nombre}</h3>
                <p>${descriptionLimit}</p>
            </div>
        `;

        //evento para abrir el modal
        card.addEventListener('click',() =>{
            openModal(sugerencia);
        });
        card.style.cursor = 'pointer';

        return card;
    }

    // Evento para detectar clic sobre el btn de crear plan en la tarjeta
    btnCrearPlanCard.addEventListener('click', function (e) {
        const contenedor = e.target.closest('.modal-info');
        let nombreSugerencia = contenedor.querySelector('#modal-nombre').textContent;
        let tipoActividadSugerencia = contenedor.querySelector('#modal-tipo-actividad').textContent;
        let direccionCompleta = (contenedor.querySelector('#modal-direccion').textContent).split(',');
        let direccionSugerencia = direccionCompleta[0];
        let municipioSugerencia = direccionCompleta[1].trim();

        // Redireccionar a planesAbiertos.php enviando los valores por la url
        window.location.href = urlBase + `/views/planesAbiertos.php?nombre=${encodeURIComponent(nombreSugerencia)}&tipoActividad=${encodeURIComponent(tipoActividadSugerencia)}&direccion=${encodeURIComponent(direccionSugerencia)}&municipio=${encodeURIComponent(municipioSugerencia)}`;
    })

    //evento para el boton de buscar plan
    btnSearchPlan.addEventListener('click', function(e){
        e.preventDefault();
        let cont = 0;
        // Validar que todos los selects estén completos
        let selects = formSearchPlan.querySelectorAll('select');
        selects.forEach(select => {
            if (select.value == '') {
                cont++;
                
                select.style.transition = 'border 0.3s ease';
                select.style.border = '1px solid #FF0000';
                select.style.boxShadow = '0 0 5px rgba(255, 0, 0, 0.5)';
                
                setTimeout(() => {
                    select.style.border = '1px solid #000'; 
                    select.style.boxShadow = 'none';
                }, 2000);
            }
        });
        if(cont == 0){
            //obtengo los valores de los selects
            const activityType = document.getElementById('select-actividad1').value;
            const location = document.getElementById('select-actividad4').value;

            const mapMunicipios = {
                'medellin': 1,
                'bello': 2,
                'girardota': 3,
            };
            const idMunicipio = mapMunicipios[location];
            searchSugerenciasByFilter(idMunicipio,activityType);
        }
    });

    //funciona para buscar las sugerencias por filtro
    async function searchSugerenciasByFilter(idMunicipio,activityType) {
        try{
            const response = await fetch(urlController, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    accion: 'consultarPorFiltro',
                    IdMunicipio: idMunicipio,
                    TipoActividad: activityType
                })
            });
                
            const data = await response.json();
            if (!Array.isArray(data)) {
                constainerResult.innerHTML = `<p>${"No se encontraron sugerencias"}</p>`;
            return;
        }
            showSugerencias(data);
        }catch(error){
            console.error('Error al buscar sugerencias por filtro: ', error);
        }
    }
    

    //funciones para el modal de sugerencias
    function openModal(sugerencia){
        //optengo todos los datos para el modal
        document.getElementById('modal-nombre').textContent = sugerencia.Nombre;
        document.getElementById('modal-tipo-actividad').textContent = sugerencia.TipoActividad;
        document.getElementById('modal-descripcion').textContent = sugerencia.Descripcion;
        document.getElementById('modal-direccion').textContent = sugerencia.Direccion;
        document.getElementById('modal-foto').src = urlBase + "/" + sugerencia.Foto;
        document.getElementById('modal-foto').alt = sugerencia.Nombre;

        //mostrar el modal
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    //funcion para cerrar el modal
    function closeModal(){
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    //evento para el boton de cerra
    btnCloseModal.addEventListener('click', closeModal);

    //para cerra el modal al hacer click fuera del contenido
    modal.addEventListener('click',(e) =>{
        if(e.target === modal){
            closeModal();
        }
    });

    //funciones plan abiertos

    //es la misma logica de sigerencias primero cargo todos los planes abiertos
    async function loadAllPlanes() {
        $.ajax({
            url: `/${urlBasePlan}/backend/controllers/planController.php?accion=listarPlanes`,
            type: 'POST',
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(response) {
                showPlanes(response);
            },
            error: function(xhr) {
                console.log("Status:", xhr.status);
                console.log("Response:", xhr.responseText);
                console.log("Objeto completo:", xhr);
            }
        });
    }
    

    function showPlanes(planes){
        containerPlanesAbierto,innerHTML = '';
        if(!planes || planes.length === 0){
            containerPlanesAbierto.innerHTML = '<p>No se encontraron planes abiertos</p>';
            return;
        }

        planes.forEach(plan =>{
            const accordion= createAccordion(plan);
            containerPlanesAbierto.appendChild(accordion);
        });
    }

    //funcion para la creacion de los planes abierto en acordion
    function createAccordion(plan){
        const accordion = document.createElement('div');
        accordion.className = 'plan-acordeon';

        accordion.innerHTML = `
        <div class="plan-acordeon-header">
            <img src="${urlBase}${plan.Foto}" alt="${plan.Nombre}" class="plan-acordeon-imagen">
            <div class="plan-acordeon-info">
                <h3 class="plan-acordeon-titulo">${plan.Nombre}</h3>
                <p class="plan-acordeon-subtitulo">${plan.Descripcion.substring(0, 50)}${plan.Descripcion.length > 50 ? '...' : ''}</p>
            </div>
            <div class="plan-acordeon-toggle">+</div>
        </div>
        <div class="plan-acordeon-body">
            <div class="plan-acordeon-detalle">
                <div class="plan-detalle-item">
                    <span class="plan-detalle-label">Creado por:</span>
                    <span class="plan-detalle-valor">${plan.NombreUsuario}</span>
                </div>
        
                <div class="plan-detalle-item">
                    <span class="plan-detalle-label">Ubicación:</span>
                    <span class="plan-detalle-valor">${plan.Direccion}</span>
                </div>
                
                <div class="plan-detalle-item">
                    <span class="plan-detalle-label">Fecha:</span>
                    <span class="plan-detalle-valor">${plan.Fecha}</span>
                </div>
                
                <div class="plan-detalle-item">
                    <span class="plan-detalle-label">Actividad:</span>
                    <span class="plan-detalle-valor">${plan.TipoActividad}</span>
                </div>
                
                <div class="plan-detalle-item">
                    <span class="plan-detalle-label">Personas:</span>
                    <span class="plan-detalle-valor">${plan.CantidadPersonas}</span>
                </div>
                
                <div class="plan-descripcion-completa">
                    <strong>Descripción completa:</strong>
                    <p>${plan.Descripcion}</p>
                </div>
            </div>
            <button class="btn-unirse-plan" id="btn-unirse-plan-${plan.Id}">UNIRSE</button>
        </div>
    `;
    
    //evento pra abrir y cerra el acordion
    const header = accordion.querySelector('.plan-acordeon-header');
    header.addEventListener('click', () => {
        document.querySelectorAll('.plan-acordeon').forEach(item => {
            if (item !== accordion) {
                item.classList.remove('active');
            }
        });
        accordion.classList.toggle('active');
    });

containerPlanesAbierto.addEventListener('click', (e) => {
    if (e.target.classList.contains('btn-unirse-plan')) {
        e.stopPropagation(); 
        unirseAPlan(e.target);
    }
});

function unirseAPlan(boton) {
    // Verificar si ya se unió antes (evita múltiples clics)
    if (boton.disabled) {
        return;
    }

    // Ubicar el contenedor del acordeón
    const accordion = boton.closest('.plan-acordeon');

    // El campo donde aparece la cantidad de personas
    const personasElem = accordion.querySelector(
        '.plan-detalle-item:nth-child(5) .plan-detalle-valor'
        );

        let textoPersonas = personasElem.textContent.trim(); 
        const numero = parseInt(textoPersonas);
        personasElem.textContent = numero + 1;

        boton.disabled = true;
        boton.textContent = "YA TE UNISTE";
        boton.style.background = "#888";
        boton.style.cursor = "not-allowed";
    }

    return accordion;
    }

    btnCreatePlan.addEventListener('click', () => {
        window.location.href = urlBase + '/views/planesAbiertos.php';
    });

    //finalmente llamamos el metodo para cargar todas las sugerencias
    loadAllSugerencias();
    loadAllPlanes();


});
