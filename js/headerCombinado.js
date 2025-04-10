document.addEventListener('DOMContentLoaded', () => {
    // Elementos del menú de administración
    const botonAdmin = document.getElementById('adminToggle');
    const botonGestion = document.getElementById('mqGestion');
    const botonMisPedidos = document.getElementById('mqMisPedidos');
    const botonCarrito = document.getElementById('mqCarrito');
    const botonLogout = document.getElementById('mqLogout');
    const separador = document.querySelector('.separador');
    const separadorNuevo = document.querySelector('.nuevoSeparador');
    const botonAdmin1 = document.querySelector('.mqAdmin1');
    const botonAdmin2 = document.querySelector('.mqAdmin2');
    const botonAdmin3 = document.querySelector('.mqAdmin3');
    const botonAdmin4 = document.querySelector('.mqAdmin4');
    let htmlBotonAdmin = botonAdmin ? botonAdmin.innerHTML : '';
    let modoSeleccionar = false;
    let estadoPrevioBuscador = null;

    // Elementos del buscador
    const searchField = document.getElementById('searchInput');
    const searchButton = document.getElementById('buscar');
    const closeButton = document.getElementById('closeSearch');
    const titulo = document.getElementById('mqTiendaSeñalesTrafico');

    // Función para manejar el buscador
    const toggleSearchField = () => {
        const isSearchVisible = searchField.style.display === 'inline-block';
        const isLargeScreen = window.innerWidth > 1080;
        
        if (!isSearchVisible && !isLargeScreen) {
            // Guardar estado solo en móviles (≤1080px)
            estadoPrevioBuscador = {
                botonesAdmin: [botonAdmin1, botonAdmin2, botonAdmin3, botonAdmin4].map(btn => btn ? btn.style.display : null),
                botonesUsuario: [botonGestion, botonMisPedidos, botonCarrito, botonLogout].map(btn => btn ? btn.style.display : null),
                separador: separador ? separador.style.display : null,
                separadorNuevo: separadorNuevo ? separadorNuevo.style.display : null,
                adminToggle: botonAdmin ? botonAdmin.style.display : null
            };
            
            // Ocultar elementos solo en móviles
            [botonAdmin1, botonAdmin2, botonAdmin3, botonAdmin4, 
             botonGestion, botonMisPedidos, botonCarrito, botonLogout].forEach(btn => {
                if (btn) btn.style.display = 'none';
            });
            
            if (separador) separador.style.display = 'none';
            if (separadorNuevo) separadorNuevo.style.display = 'none';
            if (botonAdmin) botonAdmin.style.display = 'none';
        } else if (isSearchVisible && !isLargeScreen && estadoPrevioBuscador) {
            // Restaurar estado solo en móviles (≤1080px)
            [botonAdmin1, botonAdmin2, botonAdmin3, botonAdmin4].forEach((btn, i) => {
                if (btn) btn.style.display = estadoPrevioBuscador.botonesAdmin[i];
            });
            
            [botonGestion, botonMisPedidos, botonCarrito, botonLogout].forEach((btn, i) => {
                if (btn) btn.style.display = estadoPrevioBuscador.botonesUsuario[i];
            });
            
            if (separador) separador.style.display = estadoPrevioBuscador.separador;
            if (separadorNuevo) separadorNuevo.style.display = estadoPrevioBuscador.separadorNuevo;
            if (botonAdmin) botonAdmin.style.display = estadoPrevioBuscador.adminToggle;
        }
        
        // Alternar visibilidad del buscador (siempre)
        searchField.style.display = isSearchVisible ? 'none' : 'inline-block';
        searchButton.style.display = isSearchVisible ? 'inline-block' : 'none';
        closeButton.style.display = isSearchVisible ? 'none' : 'inline-block';
        
        // Manejar el título
        if (titulo) {
            if (isLargeScreen) {
                // En desktop (>1080px): ocultar solo cuando el buscador está abierto
                titulo.style.display = isSearchVisible ? 'block' : 'none';
            } else {
                // En móvil (≤1080px): ocultar siempre
                titulo.style.display = 'none';
            }
        }
        
        // Enfocar el campo si se está mostrando
        if (!isSearchVisible) searchField.focus();
    };

    // Resto del código permanece igual...
    const handleSearch = (event) => {
        if (event.key === 'Enter') {
            let query = searchField.value.trim();
            query = query.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s-]/g, "");
            query = query.replace(/\+/g, "").trim();
            
            if (query === "" || /^\+*$/.test(query)) return;
            
            window.location.href = BASE_URL + "producto/buscar&search=" + encodeURIComponent(query.replace(/\s+/g, "+"));
        }
    };

    const checkWindowSize = () => {
        if (botonAdmin) {
            const isMediumScreen = window.innerWidth > 700;
            botonAdmin.style.display = isMediumScreen ? 'none' : 'block';
            
            if (isMediumScreen) {
                modoSeleccionar = false;
                if (htmlBotonAdmin) botonAdmin.innerHTML = htmlBotonAdmin;
                if (separadorNuevo) separadorNuevo.style.display = 'none';
                
                [botonAdmin1, botonAdmin2, botonAdmin3, botonAdmin4, 
                 botonGestion, botonMisPedidos, botonCarrito, botonLogout].forEach(btn => {
                    if (btn) btn.style.display = 'block';
                });
                
                if (separador) separador.style.display = 'block';
            } else {
                if (modoSeleccionar) {
                    botonAdmin.innerHTML = '&#x2716;';
                    if (separadorNuevo) separadorNuevo.style.display = 'block';
                    
                    [botonAdmin1, botonAdmin2, botonAdmin3, botonAdmin4].forEach(btn => {
                        if (btn) btn.style.display = 'block';
                    });
                    
                    [botonGestion, botonMisPedidos, botonCarrito, botonLogout].forEach(btn => {
                        if (btn) btn.style.display = 'none';
                    });
                    
                    if (separador) separador.style.display = 'none';
                } else {
                    botonAdmin.innerHTML = htmlBotonAdmin;
                    if (separadorNuevo) separadorNuevo.style.display = 'none';
                    
                    [botonAdmin1, botonAdmin2, botonAdmin3, botonAdmin4].forEach(btn => {
                        if (btn) btn.style.display = 'none';
                    });
                    
                    [botonGestion, botonMisPedidos, botonCarrito, botonLogout].forEach(btn => {
                        if (btn) btn.style.display = 'block';
                    });
                    
                    if (separador) separador.style.display = 'block';
                }
            }
        }

        if (titulo) {
            titulo.style.display = window.innerWidth > 1080 ? 'block' : 'none';
        }
    };

    const toggleAdminButton = () => {
        modoSeleccionar = !modoSeleccionar;
        checkWindowSize();
    };

    // Configuración de event listeners
    if (botonAdmin) botonAdmin.addEventListener('click', toggleAdminButton);
    if (searchButton) searchButton.addEventListener('click', toggleSearchField);
    if (closeButton) closeButton.addEventListener('click', toggleSearchField);
    if (searchField) searchField.addEventListener('keyup', handleSearch);

    // Inicialización
    searchField.style.display = 'none';
    closeButton.style.display = 'none';
    searchButton.style.display = 'inline-block';
    
    if (titulo) {
        titulo.style.display = window.innerWidth > 1080 ? 'block' : 'none';
    }
    
    checkWindowSize();
    window.addEventListener('resize', checkWindowSize);
});