document.querySelector('input[name="imagen"]').addEventListener('change', function () {

    const imagen = this.files[0];
    const preview = document.querySelector('#imagen-preview');
    const btnEliminar = document.querySelector('#eliminar-imagen');
    const errorImagen = document.getElementById('error-imagen');

    if (imagen) {

        const extension = imagen.name.split('.').pop().toLowerCase();
        const extensionesValidas = ['jpg', 'jpeg', 'png', 'svg'];

        if (extensionesValidas.includes(extension)) {

            const reader = new FileReader();
            errorImagen.style.display = 'none';

            reader.onload = function () {
                preview.src = reader.result;
                preview.style.display = 'block';
                btnEliminar.style.display = 'block';
            }

            reader.readAsDataURL(imagen);

        } else {
            preview.src = src;
            preview.style.display = 'block';
            btnEliminar.style.display = 'none';
            btnEliminar.style.marginTop = '0px';
            errorImagen.style.display = 'block';
            this.value = '';
        }

    } else {
        preview.src = src;
        preview.style.display = 'block';
        btnEliminar.style.display = 'none';
        errorImagen.style.display = 'none';
    }

});

document.querySelector('#eliminar-imagen').addEventListener('click', function () {

    const inputImagen = document.querySelector('input[name="imagen"]');
    const preview = document.querySelector('#imagen-preview');

    preview.src = src;
    preview.style.display = 'block';
    inputImagen.value = '';
    this.style.display = 'none';

});
