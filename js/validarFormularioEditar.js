document.addEventListener('DOMContentLoaded', function() {

    const formulario = document.querySelector('form');
    const nombre = formulario.querySelector('input[name="nombre"]');
    const apellidos = formulario.querySelector('input[name="apellidos"]');
    const password = formulario.querySelector('input[name="password"]');

    const patronNombre = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{2,}$/u;
    const patronPassword = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

    function validarNombre() {
        if (!patronNombre.test(nombre.value.trim())) {
            nombre.setCustomValidity('El nombre debe tener al menos 2 caracteres y solo puede contener letras, números y espacios.');
        } else {
            nombre.setCustomValidity('');
        }
        nombre.reportValidity();
    }

    function validarApellidos() {
        if (!patronNombre.test(apellidos.value.trim())) {
            apellidos.setCustomValidity('Los apellidos deben tener al menos 2 caracteres y solo pueden contener letras, números y espacios.');
        } else {
            apellidos.setCustomValidity('');
        }
        apellidos.reportValidity();
    }

    function validarPassword() {
        if (password.value.trim() === '') {
            password.setCustomValidity('');
        } else if (!patronPassword.test(password.value.trim())) {
            password.setCustomValidity('La contraseña debe tener mínimo 8 caracteres, al menos una letra y un número.');
        } else {
            password.setCustomValidity('');
        }
        password.reportValidity();
    }

    nombre.addEventListener('input', validarNombre);
    apellidos.addEventListener('input', validarApellidos);
    password.addEventListener('input', validarPassword);

    formulario.addEventListener('submit', function(e) {
        validarNombre();
        validarApellidos();
        validarPassword();

        if (!formulario.checkValidity()) {
            e.preventDefault();
        }
    });
});
