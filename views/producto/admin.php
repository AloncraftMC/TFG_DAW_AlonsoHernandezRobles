<?php
    /**
     * Vista de administración de productos.
     * Si no hay productos, se muestra un mensaje informativo.
     * Si no hay categorías, no se puede crear un producto y se muestra un mensaje informativo.
     * Si hay productos, se muestran en una tabla con paginación.
     * Cada producto tiene un botón para ver, editar y eliminar.
     */
?>

<?php
    use helpers\Utils;
    use models\Categoria;
?>

<h1 class="mqAdminTitulo">Administración de Productos</h1>

<!-- Si no hay categorías, mostramos un mensaje informativo al hacer hover sobre el botón, que además sería disabled en ese caso -->

<?php if(count(Categoria::getAll()) == 0): ?>

    <a href="<?=BASE_URL?>producto/crear" title="Para crear productos, primero debes crear categorías." style="pointer-events: none; text-decoration: none; margin: 10px">

<?php else: ?>

    <a href="<?=BASE_URL?>producto/crear" style="text-decoration: none; margin: 10px">

<?php endif; ?>

    <button class="boton more-margin <?php if(count(Categoria::getAll()) == 0) echo 'disabled' ?> " style="display: flex; justify-content: center; align-items: center; margin: 0 auto;">
        <img src="<?=BASE_URL?>assets/images/crear.svg" alt="Crear producto" style="margin-right: 4px">
        Crear Producto
    </button>

</a>

<?php if(count($productos) == 0): ?>

    <h3>No hay productos.</h3>

    <?php if(count(Categoria::getAll()) == 0): ?>

        <h4>Para crear productos, primero debes crear categorías.</h4>

    <?php endif; ?>

<?php else: ?>

    <script src="<?=BASE_URL?>js/ajusteImagenesTabla.js?t=<?=time()?>"></script>

    <div class="paginacion" style="margin-top: 0px;">

        <?php if($totalPag > 1): ?>

            <a href="<?=BASE_URL?>producto/admin&pag=1" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/doubleleft.png" alt="Primera página" style="width: 10px; padding: 5px;">
                </button>
            </a>

            <a href="<?=BASE_URL?>producto/admin&pag=<?= ($_SESSION['pag'] > 1) ? $_SESSION['pag'] - 1 : 1 ?>" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/left.svg" alt="Página anterior">
                </button>
            </a>

            <h1><span class="mqAdminPag">Pág.</span>
                <form style="padding: 0px; background-color: unset; display: inline;" action="<?= BASE_URL ?>producto/admin" method="GET">
                    <input type="number" name="pag" min="1" max="<?= $totalPag ?>" class="quantity-input" value="<?= $_SESSION['pag'] ?>" style="width: 60px; height: 40px; font-size: 30px; padding: 5px; margin: 0px;" required>
                    <input type="submit" value="Ir" style="display: none;">
                </form>
            </h1>

            <a href="<?=BASE_URL?>producto/admin&pag=<?= ($_SESSION['pag'] < $totalPag) ? $_SESSION['pag'] + 1 : $totalPag ?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/right.svg" alt="Página siguiente">
                </button>
            </a>

            <a href="<?=BASE_URL?>producto/admin&pag=<?=$totalPag?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/doubleright.png" alt="Última página" style="width: 10px; padding: 5px;">
                </button>
            </a>

        <?php endif; ?>

    </div>

    <table class="tabla-productos">

        <tr>
            <th>ID</th>
            <th>Categoría</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Oferta</th>
            <th>Fecha</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>

        <?php foreach($productos as $producto): ?>

            <tr id="<?=$producto->getId()?>">

                <td><?=$producto->getId()?></td>

                <td><?=Categoria::getById($producto->getCategoriaId())->getNombre()?></td>

                <td><?=$producto->getNombre()?></td>

                <td style="max-width: 1500px; word-wrap: break-word; overflow-wrap: break-word; white-space: normal;">
                    <?=(strlen($producto->getDescripcion()) == 0) ? 'Sin descripción' : $producto->getDescripcion()?>
                </td>

                <td style="min-width: 60px;"><?=$producto->getPrecio()?> €</td>
                <td><?=$producto->getStock()?></td>

                <td><?php if($producto->getOferta() == 0) echo 'No'; else echo $producto->getOferta() . '%' ?></td>

                <td>

                    <?=date('d/m/Y', strtotime($producto->getFecha()))?>

                    <div style="padding: 5px;"></div>
                    
                    <?=date('H:i:s', strtotime($producto->getFecha()))?>

                </td>
                
                <td>
                    <img src="<?=BASE_URL?>assets/images/uploads/productos/<?=$producto->getImagen()?>?t=<?=time()?>" alt="<?=$producto->getNombre()?>">
                </td>

                <td class="acciones-especial" style="display: flex; flex-direction: row; justify-content: center; align-items: center; gap: 10px; margin: 0px; height: 120px">

                    <a href="<?=BASE_URL?>producto/ver&id=<?=$producto->getId()?>">
                        <img src="<?=BASE_URL?>assets/images/ver.svg" alt="Ver producto" class="ver" style="background-color: rgb(47, 158, 0);">
                    </a>
                    
                    <a href="<?=BASE_URL?>producto/gestion&id=<?=$producto->getId()?>">
                        <img src="<?=BASE_URL?>assets/images/editar.svg" alt="Editar producto" class="ver" style="background-color: #2980B9">
                    </a>

                    <a href="<?=BASE_URL?>producto/eliminar&id=<?=$producto->getId()?>" onclick="return confirm('¿Estás seguro de que quieres eliminar el producto <?=$producto->getNombre()?>?\nEsta acción no se puede deshacer.')">
                        <img src="<?=BASE_URL?>assets/images/vaciar.svg" alt="Eliminar producto" class="ver" style="background-color: rgb(218, 0, 0);">
                    </a>

                </td>

            </tr>

        <?php endforeach; ?>

    </table>

    <div class="paginacion">

        <?php if($totalPag > 1): ?>

            <a href="<?=BASE_URL?>producto/admin&pag=1" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/doubleleft.png" alt="Primera página" style="width: 10px; padding: 5px;">
                </button>
            </a>

            <a href="<?=BASE_URL?>producto/admin&pag=<?= ($_SESSION['pag'] > 1) ? $_SESSION['pag'] - 1 : 1 ?>" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/left.svg" alt="Página anterior">
                </button>
            </a>

            <h1><span class="mqAdminPag">Pág.</span>
                <form style="padding: 0px; background-color: unset; display: inline;" action="<?= BASE_URL ?>producto/admin" method="GET">
                    <input type="number" name="pag" min="1" max="<?= $totalPag ?>" class="quantity-input" value="<?= $_SESSION['pag'] ?>" style="width: 60px; height: 40px; font-size: 30px; padding: 5px; margin: 0px;" required>
                    <input type="submit" value="Ir" style="display: none;">
                </form>
            </h1>

            <a href="<?=BASE_URL?>producto/admin&pag=<?= ($_SESSION['pag'] < $totalPag) ? $_SESSION['pag'] + 1 : $totalPag ?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/right.svg" alt="Página siguiente">
                </button>
            </a>

            <a href="<?=BASE_URL?>producto/admin&pag=<?=$totalPag?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/doubleright.png" alt="Última página" style="width: 10px; padding: 5px;">
                </button>
            </a>

        <?php endif; ?>

    </div>

<?php endif; ?>

<?php Utils::deleteSession('create'); ?>

<script src="<?=BASE_URL?>js/actualizarPaginacion.js?t=<?=time()?>"></script>