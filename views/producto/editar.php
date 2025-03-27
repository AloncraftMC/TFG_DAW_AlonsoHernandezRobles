<?php
    use helpers\Utils;
    use models\Categoria;
?>

<h1 style="margin-bottom: 0px">Editar Producto</h1>

<?php
    use models\Producto;
    $usuario = Producto::getById($_GET['id']);
?>

<h3><?=$producto->getNombre()?></h3>

<form method="post" action="<?=BASE_URL?>producto/editar&id=<?=$_GET['id']?>" enctype="multipart/form-data">

    <!-- Si en $_SESSION['form_data'] hay un valor para la categoría, lo ponemos de opción en el select. Si no está seteado, mostramos la categoría actual del producto -->

    <div class="form-group">

        <label for="categoria">Categoría</label>
        <select name="categoria" required>

            <?php $categorias = Categoria::getAll(); ?>

            <?php foreach($categorias as $categoria): ?>

                <option value="<?=$categoria->getId()?>" <?=isset($_SESSION['form_data']['categoria']) && $_SESSION['form_data']['categoria'] == $categoria->getId() ? 'selected' : ($producto->getCategoriaId() == $categoria->getId() ? 'selected' : '')?>>
                    <?=$categoria->getNombre()?>
                </option>

            <?php endforeach; ?>

        </select>

    </div>
    
    <div class="form-group">

        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" required value="<?=isset($_SESSION['form_data']['nombre']) ? $_SESSION['form_data']['nombre'] : $producto->getNombre()?>">

        <?php if(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'failed_nombre'): ?>

            <small class="error">El nombre debe tener al menos 2 caracteres.</small>
            <?php Utils::deleteSession('gestion'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion"><?=isset($_SESSION['form_data']['descripcion']) ? $_SESSION['form_data']['descripcion'] : $producto->getDescripcion()?></textarea>

    </div>

    <div class="form-group">

        <label for="precio">Precio</label>
        <input type="number" name="precio" required value="<?=isset($_SESSION['form_data']['precio']) ? $_SESSION['form_data']['precio'] : $producto->getPrecio()?>" min="0.01" step="0.01">

        <?php if(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'failed_precio'): ?>

            <small class="error">El precio debe ser mayor que 0.</small>
            <?php Utils::deleteSession('gestion'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">

        <label for="stock">Stock</label>
        <input type="number" name="stock" required value="<?=isset($_SESSION['form_data']['stock']) ? $_SESSION['form_data']['stock'] : $producto->getStock()?>" min="0">

        <?php if(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'failed_stock'): ?>

            <small class="error">El stock debe ser mayor o igual que 0.</small>
            <?php Utils::deleteSession('gestion'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">

        <!-- Si la oferta es 0, no se muestra en el input. Si no, se muestra el valor de la oferta actual del producto -->

        <label for="oferta">Oferta</label>
        <input type="number" name="oferta" value="<?=isset($_SESSION['form_data']['oferta']) ? $_SESSION['form_data']['oferta'] : ($producto->getOferta() == 0 ? '' : $producto->getOferta())?>" min="1" max="99" placeholder="% de descuento">
        
        <?php if(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'failed_oferta'): ?>

            <small class="error">La oferta debe estar entre 1% y 99%.</small>
            <?php Utils::deleteSession('gestion'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">

        <label for="imagen">Imagen</label>
        <input type="file" name="imagen" style="cursor: pointer;">

        <?php if(isset($_SESSION['gestion']) && $_SESSION['gestion'] == 'failed_imagen'): ?>

            <small class="error">La imagen debe ser jpg, png o svg.</small>
            <?php Utils::deleteSession('gestion'); ?>

        <?php endif; ?>

        <!-- Mensaje de error antes de la vista previa -->
        <div id="error-imagen" style="display: none; margin-top: 10px;">
            <small class="error">La imagen debe ser jpg, png o svg.</small>
        </div>

        <!-- Mostramos una vista previa de la imagen actual o nueva (subida) antes de enviar el formulario -->
        <div style="margin-top: 30px; display: flex; flex-direction: column; justify-content: center; align-items: center; width: 100%;">
            <img id="imagen-preview" src="<?=BASE_URL?>assets/images/uploads/productos/<?=$producto->getImagen()?>" alt="Vista previa de la imagen" style="display: block; min-height: 100px; max-height: 100px; border-radius: 5px; margin-bottom: 15px; max-width: 500px;">
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