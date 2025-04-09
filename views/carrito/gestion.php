<?php
    use helpers\Utils;
    use models\Producto;
?>

<h1 class="mqCarritoGestionTitulo">Carrito <?php if (Utils::statsCarrito()['count'] == 0): ?>Vacío<?php elseif (Utils::statsCarrito()['totalCount'] == 1): ?>(1 producto)<?php else: ?>(<?= Utils::statsCarrito()['totalCount'] ?> productos)<?php endif; ?></h1>

<?php if (!isset($_SESSION['carrito']) || Utils::statsCarrito()['count'] == 0): ?>

    <h3>No hay productos en el carrito.</h3>

    <a href="<?= BASE_URL ?>" class="boton" style="text-decoration: none;">
        <button class="boton" style="display: flex; flex-direction: row; justify-content: center; align-items: center; margin: 0 auto;">
            <span>Empieza a comprar</span>
            <img src="<?= BASE_URL ?>assets/images/login.svg" alt="Tienda" style="margin-left: 5px; width: 25px; filter: invert(1);">
        </button>
    </a>

<?php else: ?>

    <a href="<?=BASE_URL?>carrito/clear" style="text-decoration: none;" onclick="return confirm('¿Estás seguro de que quieres vaciar el carrito?\nEsta acción no se puede deshacer.')">
        <button class="boton more-margin btn-del" style="display: flex; justify-content: center; align-items: center; margin: 0 auto;">
            <img src="<?=BASE_URL?>assets/images/vaciar.svg" alt="Vaciar carrito" style="margin-right: 4px">Vaciar carrito
        </button>
    </a>

    <div class="paginacion">

        <?php if($totalPag > 1): ?>

            <a href="<?=BASE_URL?>carrito/gestion&pag=1" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/doubleleft.png" alt="Primera página" style="width: 10px; padding: 5px;">
                </button>
            </a>

            <a href="<?=BASE_URL?>carrito/gestion&pag=<?= ($_SESSION['pag'] > 1) ? $_SESSION['pag'] - 1 : 1 ?>" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/left.svg" alt="Página anterior">
                </button>
            </a>

            <h1>Pág.
                <form style="padding: 0px; background-color: unset; display: inline;" action="<?= BASE_URL ?>carrito/gestion" method="GET">
                    <input type="number" name="pag" min="1" max="<?= $totalPag ?>" class="quantity-input" value="<?= $_SESSION['pag'] ?>" style="width: 60px; height: 40px; font-size: 30px; padding: 5px; margin: 0px;" required>
                    <input type="submit" value="Ir" style="display: none;">
                </form>
            </h1>

            <a href="<?=BASE_URL?>carrito/gestion&pag=<?= ($_SESSION['pag'] < $totalPag) ? $_SESSION['pag'] + 1 : $totalPag ?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/right.svg" alt="Página siguiente">
                </button>
            </a>

            <a href="<?=BASE_URL?>carrito/gestion&pag=<?=$totalPag?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/doubleright.png" alt="Última página" style="width: 10px; padding: 5px;">
                </button>
            </a>

        <?php endif; ?>

    </div>

    <table class="tabla-carrito">
        <thead>
            <tr>
                <th>Imagen</th>
                <th class="mqCarritoGestionProductoTH">Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalCarrito = 0;
            foreach ($productos as $indice => $producto):
                $prod = Producto::getById($producto['id_producto']); // Obtiene la información del producto
                $precioTotal = $prod->getPrecio() * (1 - $prod->getOferta() / 100) * $producto['unidades'];
                $totalCarrito += $precioTotal;
            ?>
                <tr id="<?= $indice ?>">
                    <td>
                        <?php if ($prod->getImagen() != null): ?>
                            <a href="<?= BASE_URL ?>producto/ver&id=<?= $prod->getId() ?>"><img src="<?= BASE_URL ?>assets/images/uploads/productos/<?= $prod->getImagen() ?>" alt="<?= $prod->getNombre() ?>"></a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= BASE_URL ?>producto/ver&id=<?= $prod->getId() ?>" class="enlace-producto" style="font-size: 120%;"><?= $prod->getNombre() ?></a>
                    </td>
                    <td style="min-width: 200px; height: 100px;">
                        <a href="<?= BASE_URL ?>carrito/down&index=<?= $indice ?>" class="boton boton-carrito boton-down" <?= ($producto['unidades'] == 1) ? 'onclick="return confirm(\'¿Estás seguro de que quieres eliminar el producto ' . $prod->getNombre() . ' (1 unidad)?\nEsta acción no se puede deshacer.\')"' : '' ?>>-</a>
                        <h2 style="display: inline"><?= $producto['unidades'] ?></h2>
                        <a href="<?= BASE_URL ?>carrito/up&index=<?= $indice ?>" class="boton boton-carrito boton-up">+</a>
                    </td>
                    <td style="min-width: 70px">
                        <span style="font-size: 125%">
                            <?php if ($prod->getOferta() > 0): ?>
                                <span style="color: red; text-decoration: line-through; font-size: 60%;"><?= $prod->getPrecio() ?> €</span>
                                <br>
                                <span style="color: rgb(0, 0, 0); font-weight: bold;"><?= round($prod->getPrecio() * (1 - $prod->getOferta() / 100), 2) ?> €</span>
                                <br>
                                <span style="font-size: 80%; opacity: 0.5">(-<?= $prod->getOferta() ?>%)</span>
                            <?php else: ?>
                                <span style="color: rgb(0, 0, 0); font-weight: bold;"><?= $prod->getPrecio() ?> €</span>
                            <?php endif; ?>
                        </span>
                    </td>
                    <td style="min-width: 100px">
                        <span style="font-size: 175%">
                            <?= $precioTotal ?> €
                        </span>
                    </td>
                    <td class="acciones-especial">
                        <a href="<?= BASE_URL ?>carrito/delete&index=<?= $indice ?>" class="boton btn-delete" onclick="return confirm('¿Estás seguro de que quieres eliminar el producto <?= $prod->getNombre() ?> (<?= $producto['unidades'] ?> unidad<?= ($producto['unidades'] > 1) ? 'es' : '' ?>)?\nEsta acción no se puede deshacer.')">
                            <img src="<?= BASE_URL ?>assets/images/vaciar.svg" alt="Eliminar producto" class="ver" style="background-color: rgb(200, 0, 0);">
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="paginacion" style="margin-bottom: 0px;">

        <?php if($totalPag > 1): ?>

            <a href="<?=BASE_URL?>carrito/gestion&pag=1" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/doubleleft.png" alt="Primera página" style="width: 10px; padding: 5px;">
                </button>
            </a>

            <a href="<?=BASE_URL?>carrito/gestion&pag=<?= ($_SESSION['pag'] > 1) ? $_SESSION['pag'] - 1 : 1 ?>" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/left.svg" alt="Página anterior">
                </button>
            </a>

            <h1>Pág.
                <form style="padding: 0px; background-color: unset; display: inline;" action="<?= BASE_URL ?>carrito/gestion" method="GET">
                    <input type="number" name="pag" min="1" max="<?= $totalPag ?>" class="quantity-input" value="<?= $_SESSION['pag'] ?>" style="width: 60px; height: 40px; font-size: 30px; padding: 5px; margin: 0px;" required>
                    <input type="submit" value="Ir" style="display: none;">
                </form>
            </h1>

            <a href="<?=BASE_URL?>carrito/gestion&pag=<?= ($_SESSION['pag'] < $totalPag) ? $_SESSION['pag'] + 1 : $totalPag ?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/right.svg" alt="Página siguiente">
                </button>
            </a>

            <a href="<?=BASE_URL?>carrito/gestion&pag=<?=$totalPag?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/doubleright.png" alt="Última página" style="width: 10px; padding: 5px;">
                </button>
            </a>

        <?php endif; ?>

    </div>

    <div class="resumen-carrito" style="display: flex; flex-direction: column; justify-content: center; align-items: center; margin-top: 0px; margin-bottom: 25px">
        <h2 style="color: green; font-size: 200%"><span style="color: black; font-weight: normal;">Total:</span> <?= $totalCarrito ?> €</h2>

        <!-- Botón para proceder a la compra -->
        <a href="<?= BASE_URL ?>pedido/crear" class="hacer-pedido">
            <button class="boton" class="pedido-azul">
                <img src="<?= BASE_URL ?>assets/images/caja.svg" alt="Realizar pedido">
                <span>Hacer pedido</span>
            </button>
        </a>
    </div>

<?php endif; ?>

<?php if(isset($_SESSION['carritoResultado']) && $_SESSION['carritoResultado'] == 'failed_stock'): ?>

    <strong class="red" id="failed_stock">No tenemos el stock solicitado para este producto.</strong>

    <strong class="red" style="font-size: 95%; margin-top: 10px;">Stock disponible: <?=Producto::getById($_SESSION['idProductoNoMas'])->getStock()?> unidades.</strong>
    <strong style="font-size: 95%; margin-top: 10px;">
    
        <?php

        if (isset($_SESSION['carrito'])) {
            $cantidadEnCarrito = 0;

            foreach ($_SESSION['carrito'] as $indice => $elemento) {

                $producto = Producto::getById($_SESSION['idProductoNoMas']);

                if ($elemento['id_producto'] == $producto->getId()) {

                    $cantidadEnCarrito = $elemento['unidades'];
                    break;

                }

            }

            // Si es 0 no mostramos nada, pero si es mayor que 0 mostramos la cantidad en el carrito
            if ($cantidadEnCarrito > 0) {
                echo " Cantidad en carrito: $cantidadEnCarrito unidades.";
            }

        }

        ?>

    </strong>

<?php endif; ?>

<?php Utils::deleteSession('carritoResultado'); ?>
<?php Utils::deleteSession('productoNoMas'); ?>

<script src="<?=BASE_URL?>js/ajusteImagenesTabla.js"></script>
<script src="<?=BASE_URL?>js/actualizarPaginacion.js"></script>