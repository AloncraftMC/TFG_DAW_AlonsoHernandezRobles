<?php use helpers\Utils; ?>

<h1 style="margin-bottom: 0px">Editar Usuario</h1>

<?php
    use models\Usuario;
    $usuario = Usuario::getById($_GET['id']);
?>

<h3><?=$usuario->getNombre()?> <?=$usuario->getApellidos()?></h3>

<form method="post" action="<?=BASE_URL?>usuario/editar&id=<?=$_GET['id']?>" enctype="multipart/form-data">
    
    <div class="form-group">

        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" value="<?= isset($_SESSION['form_data']['nombre']) ? $_SESSION['form_data']['nombre'] : $usuario->getNombre() ?>">

        <?php if(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'failed_nombre'): ?>

            <small class="error">El nombre, de al menos 2 caracteres, solo puede contener letras y espacios.</small>
            <?php Utils::deleteSession('gestion'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">

        <label for="apellidos">Apellidos</label>
        <input type="text" name="apellidos" value="<?= isset($_SESSION['form_data']['apellidos']) ? $_SESSION['form_data']['apellidos'] : $usuario->getApellidos() ?>">

        <?php if(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'failed_apellidos'): ?>

            <small class="error">Los apellidos, de al menos 2 caracteres, solo pueden contener letras y espacios.</small>
            <?php Utils::deleteSession('gestion'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">

        <label for="email">Email</label>
        <input type="email" name="email" value="<?= isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : $usuario->getEmail() ?>">

        <?php if(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'failed_email'): ?>

            <small class="error">Introduce un email válido.</small>
            <?php Utils::deleteSession('gestion'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">

        <label for="password">Contraseña</label>
        <input type="password" name="password" value="<?= isset($_SESSION['form_data']['password']) ? $_SESSION['form_data']['password'] : '' ?>">

        <?php if(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'failed_password'): ?>

            <small class="error">La contraseña debe tener mínimo 8 caracteres, una letra y un número.</small>
            <?php Utils::deleteSession('gestion'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">
        
        <label for="rol">Rol</label>
            
        <select name="rol">

            <option value="user" <?= (isset($_SESSION['form_data']['rol']) && $_SESSION['form_data']['rol'] == 'user') ? 'selected' : ($usuario->getRol() == 'user' ? 'selected' : '') ?>>Usuario</option>
            <option value="admin" <?= (isset($_SESSION['form_data']['rol']) && $_SESSION['form_data']['rol'] == 'admin') ? 'selected' : ($usuario->getRol() == 'admin' ? 'selected' : '') ?>>Administrador</option>
        
        </select>
    </div>

    <div class="form-group">

        <label for="imagen">Imagen</label>
        <input type="file" name="imagen" style="cursor: pointer;">

        <?php if(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'failed_imagen'): ?>

            <small class="error">La imagen debe ser jpg, png o svg.</small>
            <?php Utils::deleteSession('gestion'); ?>

        <?php endif; ?>
        
        <div id="error-imagen" style="display: none; margin-top: 10px;">
            <small class="error">La imagen debe ser jpg, png o svg.</small>
        </div>

        <div style="margin-top: 30px; display: flex; flex-direction: column; justify-content: center; align-items: center; width: 100%;">
            <img id="imagen-preview" src="<?=BASE_URL?>assets/images/uploads/usuarios/<?=$usuario->getImagen()?>?t=<?=time()?>" alt="Vista previa de la imagen" style="display: block; min-height: 100px; max-height: 100px; border-radius: 5px; margin-bottom: 15px; max-width: 500px;">
            <button id="eliminar-imagen" type="button" class="delete-image">
                Eliminar imagen
            </button>
        </div>

        <script>

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
                        preview.src = '<?=BASE_URL?>assets/images/uploads/usuarios/<?=$usuario->getImagen()?>';
                        preview.style.display = 'block';
                        btnEliminar.style.display = 'none'; // Ahora sí, ocultamos el botón
                        this.value = ''; // Limpiar el input

                    }

                } else {

                    preview.src = '<?=BASE_URL?>assets/images/uploads/usuarios/<?=$usuario->getImagen()?>';
                    preview.style.display = 'block';
                    errorImagen.style.display = 'none';

                }

            });

            document.querySelector('#eliminar-imagen').addEventListener('click', function () {

                const inputImagen = document.querySelector('input[name="imagen"]');
                const preview = document.querySelector('#imagen-preview');

                preview.src = '<?=BASE_URL?>assets/images/uploads/usuarios/<?=$usuario->getImagen()?>';
                preview.style.display = 'block';
                inputImagen.value = ''; // Elimina la imagen del input
                this.style.display = 'none';
                
            });

        </script>
        
    </div>

    <button type="submit">Guardar Cambios</button>

</form>

<?php if(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'nothing'): ?>

    <strong class="yellow">No se ha modificado ningún dato.</strong>

<?php elseif(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'failed'): ?>

    <strong class="red">Edición de datos fallida, introduce bien los datos.</strong>

<?php endif; ?>

<?php Utils::deleteSession('gestion'); ?>
<?php Utils::deleteSession('form_data'); ?>