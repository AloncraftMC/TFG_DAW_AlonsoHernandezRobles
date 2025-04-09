document.addEventListener('DOMContentLoaded', () => {

    const botonAdmin = document.getElementById('adminToggle');

    const botonGestion = document.getElementById('mqGestion');
    const botonMisPedidos = document.getElementById('mqMisPedidos');
    const botonCarrito = document.getElementById('mqCarrito');
    const botonLogout = document.getElementById('mqLogout');
    const separador = document.querySelector('.separador');

    const botonAdmin1 = document.querySelector('.mqAdmin1');
    const botonAdmin2 = document.querySelector('.mqAdmin2');
    const botonAdmin3 = document.querySelector('.mqAdmin3');
    const botonAdmin4 = document.querySelector('.mqAdmin4');

    let htmlBotonAdmin = botonAdmin.innerHTML;

    let modoSeleccionar = false;

    const checkWindowSize = () => {

        if (window.innerWidth > 700) {

            modoSeleccionar = false;
            
            botonAdmin.innerHTML = htmlBotonAdmin; // Restaurar el botón admin a su estado original (icono)

            // Si estamos en pantallas grandes, el toggle de admin no debe aparecer
            botonAdmin.style.display = 'none';

            // Aseguramos que los botones de administración están visibles

            botonAdmin1.style.display = 'block';
            botonAdmin2.style.display = 'block';
            botonAdmin3.style.display = 'block';
            botonAdmin4.style.display = 'block';

            // Aseguramos que los botones de usuario están visibles

            botonGestion.style.display = 'block';
            botonMisPedidos.style.display = 'block';
            botonCarrito.style.display = 'block';
            botonLogout.style.display = 'block';
            separador.style.display = 'block';

        } else {

            botonAdmin.style.display = 'block';

            if(modoSeleccionar) {
            
                botonAdmin.innerHTML = '&#x2716;'; // Cambiar el icono a una X (cerrar)

                botonAdmin1.style.display = 'block';
                botonAdmin2.style.display = 'block';
                botonAdmin3.style.display = 'block';
                botonAdmin4.style.display = 'block';

                botonGestion.style.display = 'none';
                botonMisPedidos.style.display = 'none';
                botonCarrito.style.display = 'none';
                botonLogout.style.display = 'none';
                separador.style.display = 'none';

            }else{

                botonAdmin.innerHTML = htmlBotonAdmin;

                botonAdmin1.style.display = 'none';
                botonAdmin2.style.display = 'none';
                botonAdmin3.style.display = 'none';
                botonAdmin4.style.display = 'none';

                botonGestion.style.display = 'block';
                botonMisPedidos.style.display = 'block';
                botonCarrito.style.display = 'block';
                botonLogout.style.display = 'block';
                separador.style.display = 'block';

            }

        }

    };

    // Llamamos a la función al cargar la página
    checkWindowSize();

    const toggleAdminButton = () => {

        modoSeleccionar = !modoSeleccionar;
        
        if(modoSeleccionar) {
            
            botonAdmin.innerHTML = '&#x2716;'; // Cambiar el icono a una X (cerrar)

            botonAdmin1.style.display = 'block';
            botonAdmin2.style.display = 'block';
            botonAdmin3.style.display = 'block';
            botonAdmin4.style.display = 'block';

            botonGestion.style.display = 'none';
            botonMisPedidos.style.display = 'none';
            botonCarrito.style.display = 'none';
            botonLogout.style.display = 'none';
            separador.style.display = 'none';

        }else{

            botonAdmin.innerHTML = htmlBotonAdmin;

            botonAdmin1.style.display = 'none';
            botonAdmin2.style.display = 'none';
            botonAdmin3.style.display = 'none';
            botonAdmin4.style.display = 'none';

            botonGestion.style.display = 'block';
            botonMisPedidos.style.display = 'block';
            botonCarrito.style.display = 'block';
            botonLogout.style.display = 'block';
            separador.style.display = 'block';

        }

    };

    // Añadimos el evento click al botón admin
    botonAdmin.addEventListener('click', toggleAdminButton);
    
    // Añadimos el evento resize para comprobar el tamaño de la ventana
    window.addEventListener('resize', checkWindowSize);

});
