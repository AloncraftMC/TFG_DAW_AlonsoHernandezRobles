<?php
    /**
     * Vista para registrarse.
     * Contiene un formulario para ingresar los datos.
     * Se valida la información ingresada y se muestra un mensaje de error si es necesario.
     * Se previsualiza la imagen seleccionada antes de enviarla.
     */
?>

<?php use helpers\Utils; ?>

<h1>Registrarse</h1>

<form method="post" action="<?=BASE_URL?>usuario/guardar" enctype="multipart/form-data">

    <div class="form-group">

        <label for="nombre" id="nombre">Nombre</label>
        <input type="text" name="nombre" required value="<?= isset($_SESSION['form_data']['nombre']) ? $_SESSION['form_data']['nombre'] : '' ?>">

        <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'failed_nombre'): ?>

            <small class="error">El nombre, de al menos 2 caracteres, solo puede contener letras, números y espacios.</small>
            <?php Utils::deleteSession('register'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">

        <label for="apellidos" id="apellidos">Apellidos</label>
        <input type="text" name="apellidos" required value="<?= isset($_SESSION['form_data']['apellidos']) ? $_SESSION['form_data']['apellidos'] : '' ?>">

        <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'failed_apellidos'): ?>

            <small class="error">Los apellidos, de al menos 2 caracteres, solo pueden contener letras, números y espacios.</small>
            <?php Utils::deleteSession('register'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">

        <label for="email" id="email">Email</label>
        <input type="email" name="email" required value="<?= isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : '' ?>">

        <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'failed_email'): ?>

            <small class="error">Introduce un email válido.</small>
            <?php Utils::deleteSession('register'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">

        <label for="password" id="password">Contraseña</label>
        <input type="password" name="password" required value="<?= isset($_SESSION['form_data']['password']) ? $_SESSION['form_data']['password'] : '' ?>">

        <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'failed_password'): ?>

            <small class="error">La contraseña debe tener mínimo 8 caracteres, una letra y un número.</small>
            <?php Utils::deleteSession('register'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">
        
        <label for="imagen" id="imagen">Imagen</label>
        <input type="file" name="imagen" required style="cursor: pointer;">

        <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'failed_imagen'): ?>

            <small class="error">La imagen debe ser jpg, png o svg.</small>
            <?php Utils::deleteSession('register'); ?>

        <?php endif; ?>

        <!-- Vista previa de la imagen -->
        <div style="margin-top: 0px; display: flex; justify-content: center; align-items: center; width: 100%;">
            <img id="imagen-preview" src="#" alt="Vista previa de la imagen" style="display: none; min-height: 100px; min-width: 100px; max-height: 100px; max-width: 100px; border-radius: 50%;">
            <button id="eliminar-imagen" type="button" class="delete-image" style="width: 200px;">
                Eliminar imagen
            </button>
        </div>

        <div id="error-imagen" style="display: none;">
            <small class="error">La imagen debe ser jpg, png o svg.</small>
        </div>

        <script src="<?=BASE_URL?>js/subirImagenCrear.js?t=<?=time()?>"></script>
        <script src="<?=BASE_URL?>js/validarFormularioCrear.js?t=<?=time()?>"></script>

    </div>

    <button type="submit">Registrarse</button>

</form>

<?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'complete'): ?>

    <strong class="green" id="complete">Registro completado correctamente.</strong>

<?php elseif(isset($_SESSION['register']) && $_SESSION['register'] == 'failed'): ?>

    <strong class="red" id="failed">Registro fallido, introduce bien los datos.</strong>

<?php endif; ?>

<?php Utils::deleteSession('register'); ?>
<?php Utils::deleteSession('form_data'); ?>