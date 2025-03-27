<?php use helpers\Utils; ?>

<h1>Registrarse</h1>

<form method="post" action="<?=BASE_URL?>usuario/guardar" enctype="multipart/form-data">

    <div class="form-group">

        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" required value="<?= isset($_SESSION['form_data']['nombre']) ? $_SESSION['form_data']['nombre'] : '' ?>">

        <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'failed_nombre'): ?>

            <small class="error">El nombre, de al menos 2 caracteres, solo puede contener letras y espacios.</small>
            <?php Utils::deleteSession('register'); ?>

        <?php endif; ?>

    </div>


    <div class="form-group">

        <label for="apellidos">Apellidos</label>
        <input type="text" name="apellidos" required value="<?= isset($_SESSION['form_data']['apellidos']) ? $_SESSION['form_data']['apellidos'] : '' ?>">

        <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'failed_apellidos'): ?>

            <small class="error">Los apellidos, de al menos 2 caracteres, solo pueden contener letras y espacios.</small>
            <?php Utils::deleteSession('register'); ?>

        <?php endif; ?>

    </div>


    <div class="form-group">

        <label for="email">Email</label>
        <input type="email" name="email" required value="<?= isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : '' ?>">

        <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'failed_email'): ?>

            <small class="error">Introduce un email válido.</small>
            <?php Utils::deleteSession('register'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">

        <label for="password">Contraseña</label>
        <input type="password" name="password" required value="<?= isset($_SESSION['form_data']['password']) ? $_SESSION['form_data']['password'] : '' ?>">

        <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'failed_password'): ?>

            <small class="error">La contraseña debe tener mínimo 8 caracteres, una letra y un número.</small>
            <?php Utils::deleteSession('register'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">
        
        <label for="imagen">Imagen</label>
        <input type="file" name="imagen" required style="cursor: pointer;">

        <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'failed_imagen'): ?>

            <small class="error">La imagen debe ser jpg, png o svg.</small>
            <?php Utils::deleteSession('register'); ?>

        <?php endif; ?>

        <!-- Vista previa de la imagen -->
        <div style="margin-top: 0px; display: flex; justify-content: center; align-items: center; width: 100%;">
            <img id="imagen-preview" src="#" alt="Vista previa de la imagen" style="display: none; min-height: 100px; max-height: 100px; border-radius: 5px; max-width: 500px;">
            <button id="eliminar-imagen" type="button" class="delete-image">
                Eliminar imagen
            </button>
        </div>

        <div id="error-imagen" style="display: none;">
            <small class="error">La imagen debe ser jpg, png o svg.</small>
        </div>

        <script>

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

        </script>

    </div>

    <button type="submit">Registrarse</button>

</form>

<?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'complete'): ?>

    <strong class="green">Registro completado correctamente.</strong>

<?php elseif(isset($_SESSION['register']) && $_SESSION['register'] == 'failed'): ?>

    <strong class="red">Registro fallido, introduce bien los datos.</strong>

<?php endif; ?>

<?php Utils::deleteSession('register'); ?>
<?php Utils::deleteSession('form_data'); ?>