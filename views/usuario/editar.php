<?php
    /**
     * Vista para la edición de un usuario por parte de un administrador.
     * Se muestra un formulario con los datos del usuario a editar.
     * Tiene el administrador la posibilidad de otorgar o quitar privilegios de administrador al usuario.
     * También puede cambiar la imagen de perfil del usuario, entre otros.
     */
?>

<?php use helpers\Utils; ?>

<h1 style="margin-bottom: 0px">Editar Usuario</h1>

<?php
    use models\Usuario;
    $usuario = Usuario::getById($_GET['id']);
?>

<h3><?=$usuario->getNombre()?> <?=$usuario->getApellidos()?></h3>

<form method="post" action="<?=BASE_URL?>usuario/editar&id=<?=$_GET['id']?>" enctype="multipart/form-data">
    
    <div class="form-group">

        <label for="nombre" id="nombre">Nombre</label>
        <input type="text" name="nombre" value="<?= isset($_SESSION['form_data']['nombre']) ? $_SESSION['form_data']['nombre'] : $usuario->getNombre() ?>">

        <?php if(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'failed_nombre'): ?>

            <small class="error">El nombre, de al menos 2 caracteres, solo puede contener letras, números y espacios.</small>
            <?php Utils::deleteSession('gestion'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">

        <label for="apellidos" id="apellidos">Apellidos</label>
        <input type="text" name="apellidos" value="<?= isset($_SESSION['form_data']['apellidos']) ? $_SESSION['form_data']['apellidos'] : $usuario->getApellidos() ?>">

        <?php if(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'failed_apellidos'): ?>

            <small class="error">Los apellidos, de al menos 2 caracteres, solo pueden contener letras, números y espacios.</small>
            <?php Utils::deleteSession('gestion'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">

        <label for="email" id="email">Email</label>
        <input type="email" name="email" value="<?= isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : $usuario->getEmail() ?>">

        <?php if(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'failed_email'): ?>

            <small class="error">Introduce un email válido.</small>
            <?php Utils::deleteSession('gestion'); ?>

        <?php elseif(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'failed_email_exists'): ?>

            <small class="error">Este email ya está registrado.</small>
            <?php Utils::deleteSession('gestion'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">

        <label for="password" id="password">Contraseña</label>
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

        <label for="color" id="color">Color</label>
        <input type="color" name="color" value="<?= isset($_SESSION['form_data']['color']) ? $_SESSION['form_data']['color'] : $usuario->getColor() ?>" id="color-input" style="width: 98.8%; height: 45px; padding: 7px; cursor: pointer;">

        <?php if(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'failed_color'): ?>

            <small class="error">Este color no es válido.</small>
            <?php Utils::deleteSession('gestion'); ?>

        <?php endif; ?>

    </div>

    <script src="<?=BASE_URL?>js/previsualizarColores.js?t=<?=time()?>"></script>

    <div class="form-group">

        <label for="imagen" id="imagen">Imagen</label>
        <input type="file" name="imagen" style="cursor: pointer;">

        <?php if(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'failed_imagen'): ?>

            <small class="error">La imagen debe ser jpg, png o svg.</small>
            <?php Utils::deleteSession('gestion'); ?>

        <?php endif; ?>
        
        <div id="error-imagen" style="display: none; margin-top: 0px;">
            <small class="error">La imagen debe ser jpg, png o svg.</small>
        </div>

        <div style="margin-top: 30px; display: flex; flex-direction: column; justify-content: center; align-items: center; width: 100%;">
            <img id="imagen-preview" src="<?=BASE_URL?>assets/images/uploads/usuarios/<?=$usuario->getImagen()?>?t=<?=time()?>" alt="Vista previa de la imagen" style="display: block; min-height: 100px; min-width: 100px; max-height: 100px; max-width: 100px; border-radius: 50%; margin-bottom: 15px;">
            <button id="eliminar-imagen" type="button" class="delete-image" style="width: 200px;">
                Eliminar imagen
            </button>
        </div>

        <script>const src = '<?=BASE_URL?>assets/images/uploads/usuarios/<?=$usuario->getImagen()?>?t=0';</script>
        <script src="<?=BASE_URL?>js/subirImagenEditar.js?t=<?=time()?>"></script>
        <script src="<?=BASE_URL?>js/validarFormularioEditar.js?t=<?=time()?>"></script>
        
    </div>

    <button type="submit">Guardar Cambios</button>

</form>

<?php if(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'nothing'): ?>

    <strong class="yellow" id="nothing">No se ha modificado ningún dato.</strong>

<?php elseif(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'failed'): ?>

    <strong class="red" id="failed">Edición de datos fallida, introduce bien los datos.</strong>

<?php endif; ?>

<?php Utils::deleteSession('gestion'); ?>
<?php Utils::deleteSession('form_data'); ?>