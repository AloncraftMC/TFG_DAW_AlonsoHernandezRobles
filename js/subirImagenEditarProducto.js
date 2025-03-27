document.querySelector('input[name="imagen"]').addEventListener('change', function () {

    const file = this.files[0];
    const preview = document.querySelector('#imagen-preview');
    const errorImagen = document.getElementById('error-imagen');
    const btnEliminar = document.querySelector('#eliminar-imagen');

    if (file) {

        const allowedTypes = ["image/jpeg", "image/jpg", "image/png", "image/svg+xml"];

        if (allowedTypes.includes(file.type)) {

            const reader = new FileReader();

            reader.onload = function () {
                errorImagen.style.display = 'none'; // Ocultar error antes de mostrar la imagen
                preview.src = reader.result;
                preview.style.display = 'block';
                btnEliminar.style.display = 'block';
            };

            reader.readAsDataURL(file);

        } else {

            errorImagen.style.display = 'block'; // Mostrar error antes de ocultar la imagen
            preview.src = '<?=BASE_URL?>assets/images/uploads/productos/<?=$producto->getImagen()?>';
            preview.style.display = 'block';
            btnEliminar.style.display = 'none'; // Ahora sí, ocultamos el botón
            this.value = ''; // Limpiar el input

        }

    } else {

        preview.src = '<?=BASE_URL?>assets/images/uploads/productos/<?=$producto->getImagen()?>';
        preview.style.display = 'block';
        errorImagen.style.display = 'none';

    }

});

document.querySelector('#eliminar-imagen').addEventListener('click', function () {

    const inputImagen = document.querySelector('input[name="imagen"]');
    const preview = document.querySelector('#imagen-preview');

    preview.src = '<?=BASE_URL?>assets/images/uploads/productos/<?=$producto->getImagen()?>';
    preview.style.display = 'block';
    inputImagen.value = ''; // Elimina la imagen del input
    this.style.display = 'none';
    
});