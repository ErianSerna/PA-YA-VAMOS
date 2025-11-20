<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planes Abiertos - Acordeón</title>
    <!-- Carga de Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Estilos personalizados para la paleta de colores de tus capturas */
        :root {
            --color-bg-light: #fef08a; /* Amarillo claro/Naranja de fondo */
            --color-card-bg: #fff;     /* Fondo de tarjetas blancas */
            --color-button: #facc15;   /* Amarillo vibrante para botones */
            --color-border: #000;      /* Borde negro */
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #e0f2fe; /* Azul muy claro para el fondo principal */
        }
        #app-container {
            max-width: 420px; /* Simulación de ancho de móvil */
            min-height: 100vh;
            background-color: var(--color-bg-light);
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        /* La tarjeta principal tiene el borde completo */
        .plan-card {
            border: 2px solid var(--color-border);
            border-radius: 0.75rem; /* rounded-xl */
            overflow: hidden; /* Importante para la animación de apertura */
            transition: box-shadow 0.2s ease;
        }
        /* Estilo para el icono de expansión */
        .accordion-icon {
            transition: transform 0.3s ease;
        }
        .accordion-icon.expanded {
            transform: rotate(45deg); /* Gira 45 grados cuando está abierto (cambio de + a x) */
        }
    </style>
</head>
<body class="flex justify-center items-start min-h-screen p-4">

    <!-- Contenedor Principal de la App (Simulación de Dispositivo) -->
    <div id="app-container" class="w-full rounded-2xl p-6 border-4 border-black">
        
        <h1 class="text-2xl font-bold text-center mb-6 uppercase">PLANES ABIERTOS</h1>

        <!-- Lista de Planes como Acordeones -->
        <div id="plans-list">

            <!-- Plan 1: IGLESIA CARMEN -->
            <div id="plan-iglesia-carmen" class="plan-card bg-white mb-4 shadow-md">
                <!-- Acordeón Header (Clickable area) -->
                <div onclick="togglePlanDetails('iglesia-carmen')" class="p-3 cursor-pointer flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="https://placehold.co/60x60/facc15/000?text=I" alt="Ícono de Plan" class="w-12 h-12 rounded-full mr-4 border border-black">
                        <div>
                            <p class="font-bold text-lg">IGLESIA CARMEN</p>
                            <p class="text-sm text-gray-600">Vamos a misa juntos :D</p>
                        </div>
                    </div>
                    <!-- Icono para indicar expansión. Usamos un '+' que rota a 'x' -->
                    <span id="icon-iglesia-carmen" class="accordion-icon text-2xl font-bold text-black transform">
                        +
                    </span>
                </div>

                <!-- Acordeón Body (Inicialmente oculto) -->
                <div id="details-iglesia-carmen" class="accordion-body hidden border-t-2 border-black p-4">
                    <div class="space-y-2 text-sm mb-4">
                        <p><strong class="font-medium">Creado por:</strong> Erian Serna</p>
                        <p><strong class="font-medium">Ubicación:</strong> CII 32 #25-15</p>
                        <p><strong class="font-medium">Hora:</strong> 5PM</p>
                        <p><strong class="font-medium">Personas:</strong> 0/4</p>
                    </div>

                    <h3 class="font-semibold mb-2 text-sm">Descripción completa:</h3>
                    <p class="text-gray-700 text-sm mb-4">
                        Una actividad relajante y espiritual para comenzar bien la semana. ¡Te esperamos en la puerta principal de la iglesia!
                    </p>
                    
                    <!-- Botón UNIRSE (más pequeño para el acordeón) -->
                    <button class="w-full px-4 py-2 bg-yellow-400 font-bold text-md uppercase rounded-full border-2 border-black shadow-[3px_3px_0_0_#000] hover:bg-yellow-500 transition duration-150">
                        UNIRSE
                    </button>
                </div>
            </div>

            <!-- Plan 2: Cine: El conjuro -->
            <div id="plan-cine-conjuro" class="plan-card bg-white mb-4 shadow-md">
                <!-- Acordeón Header (Clickable area) -->
                <div onclick="togglePlanDetails('cine-conjuro')" class="p-3 cursor-pointer flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="https://placehold.co/60x60/1e40af/fff?text=C" alt="Ícono de Plan" class="w-12 h-12 rounded-full mr-4 border border-black">
                        <div>
                            <p class="font-bold text-lg">Cine: El conjuro</p>
                            <p class="text-sm text-gray-600">Busco amigos para ver esta peli :)</p>
                        </div>
                    </div>
                    <!-- Icono para indicar expansión -->
                    <span id="icon-cine-conjuro" class="accordion-icon text-2xl font-bold text-black transform">
                        +
                    </span>
                </div>

                <!-- Acordeón Body (Inicialmente oculto) -->
                <div id="details-cine-conjuro" class="accordion-body hidden border-t-2 border-black p-4">
                    <div class="space-y-2 text-sm mb-4">
                        <p><strong class="font-medium">Creado por:</strong> Juan Pérez</p>
                        <p><strong class="font-medium">Ubicación:</strong> Multiplex Plaza</p>
                        <p><strong class="font-medium">Hora:</strong> 8:00 PM</p>
                        <p><strong class="font-medium">Personas:</strong> 2/5</p>
                    </div>

                    <h3 class="font-semibold mb-2 text-sm">Descripción completa:</h3>
                    <p class="text-gray-700 text-sm mb-4">
                        Busco gente para ir a ver la última de El Conjuro. ¡No importa si te asustas fácil! Quedamos 15 minutos antes en la entrada.
                    </p>
                    
                    <!-- Botón UNIRSE -->
                    <button class="w-full px-4 py-2 bg-yellow-400 font-bold text-md uppercase rounded-full border-2 border-black shadow-[3px_3px_0_0_#000] hover:bg-yellow-500 transition duration-150">
                        UNIRSE
                    </button>
                </div>
            </div>

        </div>

        <!-- Botón Crear Plan (se mantiene igual) -->
        <div class="mt-8 text-center">
            <button class="px-8 py-3 bg-yellow-400 font-bold rounded-full border-2 border-black shadow-[4px_4px_0_0_#000] hover:bg-yellow-500 transition duration-150">
                Crear plan
            </button>
        </div>
    </div>

    <script>
        /**
         * Alterna la visibilidad de los detalles de un plan (patrón acordeón).
         * También rota el icono para indicar el estado.
         * @param {string} planId El identificador del plan (e.g., 'iglesia-carmen').
         */
        function togglePlanDetails(planId) {
            const detailElement = document.getElementById(`details-${planId}`);
            const iconElement = document.getElementById(`icon-${planId}`);

            if (detailElement.classList.contains('hidden')) {
                // Abrir el acordeón
                detailElement.classList.remove('hidden');
                iconElement.classList.add('expanded');
                
                // Opcional: Cerrar otros acordeones si solo quieres que uno esté abierto a la vez
                closeOtherAccordions(planId); 
            } else {
                // Cerrar el acordeón
                detailElement.classList.add('hidden');
                iconElement.classList.remove('expanded');
            }
        }

        // Función auxiliar para cerrar todos los demás acordeones (si se desea un comportamiento de acordeón estricto)
        function closeOtherAccordions(currentId) {
            document.querySelectorAll('.accordion-body').forEach(body => {
                const id = body.id.replace('details-', '');
                if (id !== currentId && !body.classList.contains('hidden')) {
                    body.classList.add('hidden');
                    const otherIcon = document.getElementById(`icon-${id}`);
                    if (otherIcon) {
                        otherIcon.classList.remove('expanded');
                    }
                }
            });
        }
    </script>
</body>
</html>