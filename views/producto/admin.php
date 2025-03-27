<?php use models\Categoria; ?>

<h1>Administración de Productos</h1>

<!-- Si no hay categorías, mostramos un mensaje informativo al hacer hover sobre el botón, que además sería disabled en ese caso -->

<?php if(count(Categoria::getAll()) == 0): ?>

    <a href="<?=BASE_URL?>producto/crear" title="Para crear productos, primero debes crear categorías." style="pointer-events: none;">

<?php else: ?>

    <a href="<?=BASE_URL?>producto/crear">

<?php endif; ?>

    <button class="boton more-margin <?php if(count(Categoria::getAll()) == 0) echo 'disabled' ?>">
        Crear Producto
    </button>

</a>

<?php if(count($productos) == 0): ?>

    <h3>No hay productos.</h3>

    <?php if(count(Categoria::getAll()) == 0): ?>

        <h4>Para crear productos, primero debes crear categorías.</h4>

    <?php endif; ?>

<?php else: ?>

    <script src="<?=BASE_URL?>js/ajusteImagenesAdminProductos.js"></script>

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

            <h1>Pág.
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

    <table>

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

                <td class="acciones-especial">

                    <a href="<?=BASE_URL?>producto/ver&id=<?=$producto->getId()?>">
                        Ver
                    </a>

                    <div class="separador"></div>
                    
                    <a href="<?=BASE_URL?>producto/gestion&id=<?=$producto->getId()?>">
                        Editar
                    </a>

                    <div class="separador"></div>

                    <a href="<?=BASE_URL?>producto/eliminar&id=<?=$producto->getId()?>">
                        Eliminar
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

            <h1>Pág.
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

<script src="<?=BASE_URL?>js/actualizarPaginacion.js"></script>