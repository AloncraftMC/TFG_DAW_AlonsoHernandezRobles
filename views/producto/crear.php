<?php
    use helpers\Utils;
    use models\Categoria;
?>

<h1>Crear Producto</h1>

<form method="post" action="<?=BASE_URL?>producto/guardar" enctype="multipart/form-data">

    <!-- Si en $_SESSION['form_data'] hay un valor para la categoría, lo ponemos de opción en el select -->

    <div class="form-group">

        <label for="categoria">Categoría</label>
        <select name="categoria" required>

            <?php $categorias = Categoria::getAll(); ?>

            <?php foreach($categorias as $categoria): ?>

                <option value="<?=$categoria->getId()?>" <?=isset($_SESSION['form_data']['categoria']) && $_SESSION['form_data']['categoria'] == $categoria->getId() ? 'selected' : ''?>>
                    <?=$categoria->getNombre()?>
                </option>

            <?php endforeach; ?>

        </select>

    </div>

    <div class="form-group">

        <label for="nombre" id="nombre">Nombre</label>
        <input type="text" name="nombre" required value="<?=isset($_SESSION['form_data']['nombre']) ? $_SESSION['form_data']['nombre'] : ''?>">

        <?php if(isset($_SESSION['create']) && $_SESSION['create'] == 'failed_nombre'): ?>

            <small class="error">El nombre debe tener al menos 2 caracteres.</small>
            <?php Utils::deleteSession('create'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion"><?=isset($_SESSION['form_data']['descripcion']) ? $_SESSION['form_data']['descripcion'] : ''?></textarea>

    </div>

    <div class="form-group">

        <label for="precio" id="precio">Precio</label>
        <input type="number" name="precio" required value="<?=isset($_SESSION['form_data']['precio']) ? $_SESSION['form_data']['precio'] : ''?>" min="0.01" step="0.01">

        <?php if(isset($_SESSION['create']) && $_SESSION['create'] == 'failed_precio'): ?>

            <small class="error">El precio debe ser mayor que 0.</small>
            <?php Utils::deleteSession('create'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">

        <label for="stock" id="stock">Stock</label>
        <input type="number" name="stock" required value="<?=isset($_SESSION['form_data']['stock']) ? $_SESSION['form_data']['stock'] : ''?>" min="0">

        <?php if(isset($_SESSION['create']) && $_SESSION['create'] == 'failed_stock'): ?>

            <small class="error">El stock debe ser mayor o igual que 0.</small>
            <?php Utils::deleteSession('create'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">

        <label for="oferta" id="oferta">Oferta</label>
        <input type="number" name="oferta" value="<?=isset($_SESSION['form_data']['oferta']) ? $_SESSION['form_data']['oferta'] : ''?>" placeholder="% de descuento" min="1" max="99">

        <?php if(isset($_SESSION['create']) && $_SESSION['create'] == 'failed_oferta'): ?>

            <small class="error">La oferta debe estar entre 1% y 99%.</small>
            <?php Utils::deleteSession('create'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">

        <label for="imagen" id="imagen">Imagen</label>
        <input type="file" name="imagen" required style="cursor: pointer;">

        <?php if(isset($_SESSION['create']) && $_SESSION['create'] == 'failed_imagen'): ?>

            <small class="error">La imagen debe ser jpg, png o svg.</small>
            <?php Utils::deleteSession('create'); ?>

        <?php endif; ?>

        <!-- Mostramos una vista previa de la imagen antes de enviar el formulario -->

        <div style="margin-top: 0px; display: flex; justify-content: center; align-items: center; width: 100%;">
            <img id="imagen-preview" src="#" alt="Vista previa de la imagen" style="display: none; min-height: 100px; max-height: 100px; border-radius: 5px; max-width: 500px;">
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

    <button type="submit">Crear Producto</button>

</form>

<?php if(isset($_SESSION['create']) && $_SESSION['create'] == 'failed'): ?>

    <strong class="red mqAdminTitulo" id="failed">Creación fallida, introduce bien los datos.</strong>

<?php endif; ?>

<?php Utils::deleteSession('create'); ?>
<?php Utils::deleteSession('form_data'); ?>