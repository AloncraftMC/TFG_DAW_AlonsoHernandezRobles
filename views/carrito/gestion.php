<?php
    use helpers\Utils;
    use models\Producto;
?>

<!-- Si productos = 0, mostramos Carrito Vacío
 Si productos = 1, mostramos (1 producto)
 Si productos > 0, mostramos (x productos)"

 Todo esto respecto al siguiente h1
-->

<h1>Carrito <?php if (Utils::statsCarrito()['count'] == 0): ?>Vacío<?php elseif (Utils::statsCarrito()['totalCount'] == 1): ?>(1 producto)<?php else: ?>(<?= Utils::statsCarrito()['totalCount'] ?> productos)<?php endif; ?></h1>

<?php if (!isset($_SESSION['carrito']) || Utils::statsCarrito()['count'] == 0): ?>

    <h3>No hay productos en el carrito.</h3>

    <a href="<?= BASE_URL ?>" class="boton" style="text-decoration: none;">
        <button class="boton" style="display: flex; flex-direction: row; justify-content: center; align-items: center; margin: 0 auto;">
            <span>Empieza a comprar</span>
            <img src="<?= BASE_URL ?>assets/images/login.svg" alt="Tienda" style="margin-left: 5px; width: 25px; filter: invert(1);">
        </button>
    </a>

<?php else: ?>

    <a href="<?=BASE_URL?>carrito/clear" style="text-decoration: none;">
        <button class="boton more-margin btn-del" style="display: flex; justify-content: center; align-items: center; margin: 0 auto;">
            <img src="<?=BASE_URL?>assets/images/vaciar.svg" alt="Vaciar carrito" style="margin-right: 4px">Vaciar carrito
        </button>
    </a>

    <table class="tabla-carrito">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalCarrito = 0;
            foreach ($_SESSION['carrito'] as $indice => $producto):
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
                        <a href="<?= BASE_URL ?>carrito/down&index=<?= $indice ?>" class="boton boton-carrito boton-down">-</a>
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
                        <a href="<?= BASE_URL ?>carrito/delete&index=<?= $indice ?>" class="boton btn-delete">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="resumen-carrito" style="display: flex; flex-direction: column; justify-content: center; align-items: center; margin: 20px;">
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

<script src="<?=BASE_URL?>js/ajusteImagenesAdminProductos.js"></script>