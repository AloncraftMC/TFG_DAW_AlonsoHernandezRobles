document.querySelector('input[name="imagen"]').addEventListener('change', function() {

    const imagen = this.files[0];
    const imagenPreview = document.querySelector('#imagen-preview');
    const btnEliminar = document.querySelector('#eliminar-imagen');
    
    if (imagen) {

        const extension = imagen.name.split('.').pop().toLowerCase();
        const extensionesValidas = ['jpg', 'jpeg', 'png', 'svg'];
        
        if (extensionesValidas.includes(extension)) {

            const reader = new FileReader();
            document.getElementById('error-imagen').style.display = 'none';

            reader.onload = function() {

                imagenPreview.src = reader.result;
                imagenPreview.style.display = 'block';
                imagenPreview.style.marginTop = '30px';
                btnEliminar.style.display = 'block';
                btnEliminar.style.marginTop = '20px';
            
            }

            reader.readAsDataURL(imagen);

        } else {

            imagenPreview.src = '#';
            imagenPreview.style.display = 'none';
            imagenPreview.style.marginTop = '0px';
            btnEliminar.style.display = 'none';
            btnEliminar.style.marginTop = '00px';
            document.getElementById('error-imagen').style.display = 'block';
            this.value = '';

        }

    } else {

        imagenPreview.src = '#';
        imagenPreview.style.display = 'none';
        btnEliminar.style.display = 'none';

    }

});

document.querySelector('#eliminar-imagen').addEventListener('click', function() {

    const inputImagen = document.querySelector('input[name="imagen"]');
    const imagenPreview = document.querySelector('#imagen-preview');

    this.style.display = 'none';
    imagenPreview.src = '#';
    imagenPreview.style.display = 'none';
    inputImagen.value = ''; // Elimina la imagen del input
    
});