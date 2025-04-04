function toggleSearchField() {
    const searchField = document.getElementById('searchInput');
    const searchButton = document.getElementById('buscar');
    const closeButton = document.getElementById('closeSearch');
    const titulo = document.getElementById('mqTiendaSeñalesTrafico');
    
    // Cambiar la visibilidad del campo de texto
    if (searchField.style.display === 'none' || searchField.style.display === '') {
        searchField.style.display = 'inline-block';
        searchButton.style.display = 'none'; // Escondemos el botón de búsqueda
        closeButton.style.display = 'inline-block'; // Mostramos el botón de cerrar
        // Solo ocultar el título si el ancho de la pantalla es mayor a 1080px
        if (window.innerWidth > 1080) {
            titulo.style.display = 'none'; // Escondemos el título de la tienda
        }
        searchField.focus();
    } else {
        searchField.style.display = 'none';
        searchButton.style.display = 'inline-block'; // Mostramos el botón de búsqueda
        closeButton.style.display = 'none'; // Escondemos el botón de cerrar
        if (window.innerWidth > 1080) {
            titulo.style.display = 'block'; // Mostramos el título de la tienda
        }
    }
}

// Ahora solo manejamos el clic en la cruz para cerrar el campo de búsqueda
document.getElementById('closeSearch').addEventListener('click', function() {
    const searchField = document.getElementById('searchInput');
    const searchButton = document.getElementById('buscar');
    const closeButton = document.getElementById('closeSearch');
    const titulo = document.getElementById('mqTiendaSeñalesTrafico');

    // Restaurar el estado original cuando se hace clic en la cruz
    searchField.style.display = 'none';
    searchButton.style.display = 'inline-block'; // Mostrar el botón de búsqueda
    closeButton.style.display = 'none'; // Escondemos el botón de cerrar
    if (window.innerWidth > 1080) {
        titulo.style.display = 'block'; // Mostrar el título de la tienda
    }
});

function handleSearch(event) {
    if (event.key === 'Enter') {
        const input = document.getElementById('searchInput');
        let query = input.value.trim();

        // Eliminar caracteres especiales (permitimos letras, números y espacios)
        query = query.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s]/g, "");

        // Eliminar cualquier '+' existente
        query = query.replace(/\+/g, "");

        // Volver a hacer trim por si quedaron espacios tras quitar caracteres
        query = query.trim();

        // Si después de limpiar la query sigue vacía o equivalente vacía, no hacemos nada
        if (query === "") return;

        // Reemplazar espacios internos por '+'
        query = query.replace(/\s+/g, "+");

        // Verificar que no quedó una string vacía, o compuesta solo por '+'
        if (/^\+*$/.test(query)) return;

        console.log("Buscando: " + query);

        window.location.href = BASE_URL + "producto/buscar&search=" + encodeURIComponent(query);
    }
}


// Asegúrate de agregar el evento al input para que se active el handleSearch
document.getElementById('searchInput').addEventListener('keyup', handleSearch);
