<?php
    /**
     * Vista para crear una nueva categoría.
     * Muestra un formulario para ingresar el nombre de la categoría.
     * Valida el nombre y muestra mensajes de error si es necesario.
     */
?>

<?php use helpers\Utils; ?>

<h1>Crear Categoría</h1>

<form method="post" action="<?=BASE_URL?>categoria/guardar">

    <div class="form-group">

        <label for="nombre" id="nombre">Nombre</label>
        <input type="text" name="nombre" required value="<?=isset($_SESSION['form_data']['nombre']) ? $_SESSION['form_data']['nombre'] : ''?>">

        <?php if(isset($_SESSION['create']) && $_SESSION['create'] == 'failed_nombre'): ?>

            <small class="error">El nombre, de al menos 2 caracteres, solo puede contener letras y espacios.</small>
            <?php Utils::deleteSession('create'); ?>

        <?php endif; ?>

        <script src="<?=BASE_URL?>js/validarFormularioCrear.js?t=<?=time()?>"></script>

    </div>

    <button type="submit">Crear Categoría</button>

</form>

<?php if(isset($_SESSION['create']) && $_SESSION['create'] == 'failed'): ?>

    <strong class="red mqAdminTitulo" id="failed">Creación fallida, introduce bien los datos.</strong>

<?php endif; ?>

<?php Utils::deleteSession('create'); ?>
<?php Utils::deleteSession('form_data'); ?>