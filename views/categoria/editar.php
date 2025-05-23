<?php
    /**
     * Vista para editar una categoría.
     * Muestra un formulario con el nombre de la categoría y un botón para guardar los cambios.
     * Si se produce un error, se muestra un mensaje de error.
     */
?>

<?php use helpers\Utils; ?>

<h1 style="margin-bottom: 0px">Editar Categoría</h1>

<?php
    use models\Categoria;
    $usuario = Categoria::getById($_GET['id']);
?>

<h3><?=$categoria->getNombre()?></h3>

<form method="post" action="<?=BASE_URL?>categoria/editar&id=<?=$_GET['id']?>">
    
    <div class="form-group">

        <label for="nombre" id="nombre">Nombre</label>
        <input type="text" name="nombre" value="<?= isset($_SESSION['form_data']['nombre']) ? $_SESSION['form_data']['nombre'] : $categoria->getNombre() ?>">

        <?php if(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'failed_nombre'): ?>

            <small class="error">El nombre, de al menos 2 caracteres, solo puede contener letras y espacios.</small>
            <?php Utils::deleteSession('gestion'); ?>

        <?php endif; ?>

        <script src="<?=BASE_URL?>js/validarFormularioEditar.js?t=<?=time()?>"></script>

    </div>

    <button type="submit">Guardar Cambios</button>

</form>

<?php if(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'nothing'): ?>

    <strong class="yellow mqAdminTitulo" id="nothing">No se ha modificado ningún dato.</strong>

<?php elseif(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'failed'): ?>

    <strong class="red mqAdminTitulo" id="failed">Edición de datos fallida, introduce bien los datos.</strong>

<?php endif; ?>

<?php Utils::deleteSession('gestion'); ?>
<?php Utils::deleteSession('form_data'); ?>