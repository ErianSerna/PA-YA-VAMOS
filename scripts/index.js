document.addEventListener('DOMContentLoaded', () => {
    const openMenuBtn = document.getElementById('open-menu-btn');
    const closeMenuBtn = document.getElementById('close-menu-btn');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
    const btnbuscarPlan = document.getElementById('btn-buscarPlan'); 
    const formbuscarPlan = document.getElementById('form-buscarPlan');
    
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
    
    // Evento para detectar clic sobre el botón "Consultar"
    btnbuscarPlan.addEventListener('click', function (e) {
        e.preventDefault();
        let cont = 0;
        // Validar que todos los selects esten completos
        let selects = formbuscarPlan.querySelectorAll('select');
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
        })
        
        if (cont == 0) {
            // Mostrar las cards con los resultados
            let containerResults = document.querySelector('.container-resultados');
            let cards = containerResults.querySelectorAll('.card');
            cards.forEach(card => {
                card.style.display = 'block';
            })
        }
    })
});
