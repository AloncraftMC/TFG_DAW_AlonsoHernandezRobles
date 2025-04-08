<?php
    use models\Producto;
    use models\Pedido;
    use models\LineaPedido;
    use models\Usuario;
    $pedido = Pedido::getById($_GET['id']);
?>

<h1 style="margin-bottom: 0px;">Pedido con ID: <?=$pedido->getId()?></h1>

<h3 style="margin-bottom: 0px;">

<?php if($pedido->getEstado() == 'Pendiente'): ?>
    <span style="color: brown;"><?=$pedido->getEstado()?></span>
<?php elseif($pedido->getEstado() == 'Confirmado'): ?>
    <span style="color: green;"><?=$pedido->getEstado()?></span>
<?php endif; ?>

</h3>

<h2>

<?php
                    
    $numProductos = 0;
    $lineas = LineaPedido::getByPedido($pedido->getId());

    foreach($lineas as $linea){
        $numProductos += $linea->getUnidades();
    }
    
    echo $numProductos . ' producto' . (($numProductos > 1) ? 's' : '');

?>

</h2>

<table class="tabla-carrito">
    <thead>
        <tr>
            <th>Imagen</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php

            foreach (LineaPedido::getByPedido($pedido->getId()) as $linea):
                $producto = Producto::getById($linea->getProductoId()); // Obtiene la información del producto
                $precioTotal = $producto->getPrecio() * (1 - $producto->getOferta() / 100) * $linea->getUnidades();
        
        ?>

            <tr id="<?= $linea->getId() ?>">
                <td>
                    <?php if ($producto->getImagen() != null): ?>
                        <a href="<?= BASE_URL ?>producto/ver&id=<?= $producto->getId() ?>"><img src="<?= BASE_URL ?>assets/images/uploads/productos/<?= $producto->getImagen() ?>" alt="<?= $producto->getNombre() ?>"></a>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= BASE_URL ?>producto/ver&id=<?= $producto->getId() ?>" class="enlace-producto" style="font-size: 120%;"><?= $producto->getNombre() ?></a>
                </td>
                <td>
                    <h1 style="font-weight: unset;"><?=$linea->getUnidades()?></h1>
                </td>
                <td style="min-width: 70px">
                    <span style="font-size: 125%">
                        <?php if ($producto->getOferta() > 0): ?>
                            <span style="color: red; text-decoration: line-through; font-size: 60%;"><?= $producto->getPrecio() ?> €</span>
                            <br>
                            <span style="color: rgb(0, 0, 0); font-weight: bold;"><?= round($producto->getPrecio() * (1 - $producto->getOferta() / 100), 2) ?> €</span>
                            <br>
                            <span style="font-size: 80%; opacity: 0.5">(-<?= $producto->getOferta() ?>%)</span>
                        <?php else: ?>
                            <span style="color: rgb(0, 0, 0); font-weight: bold;"><?= $producto->getPrecio() ?> €</span>
                        <?php endif; ?>
                    </span>
                </td>
                <td style="min-width: 100px">
                    <span style="font-size: 175%">
                        <?= $precioTotal ?> €
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>

    </tbody>
</table>

<div class="resumen-carrito" style="display: flex; flex-direction: column; justify-content: center; align-items: center; margin: 20px; margin-bottom: 0px">
    <h1 style="color: green; font-size: 200%"><span style="color: black; font-weight: normal;">Total*:</span> <?= $pedido->getCoste() ?> €</h1>
    <h5 style="width: 500px; margin-top: 0px; margin-bottom: 20px; text-align: center; color: gray">*Los precios y ofertas de los productos están sujetos a cambios. El coste del pedido es el que figura en el momento de la compra y no se verá afectado.</h5>
</div>

<div class="container" style="width: unset; margin-top: 0px">
    <h4 style="margin: 0px; text-align: center;">
        <span style="font-size: 130%">Realizado el <?=date('d/m/Y', strtotime($pedido->getFecha()))?> a las <?=$pedido->getHora()?></span>
        <?php if($_SESSION['identity']['rol'] == 'admin'): ?>
            <br>
            <span>por 
                <a href="<?=BASE_URL?>usuario/admin&pag=<?= ceil(Usuario::getById($pedido->getUsuarioId())->getPosicion() / ITEMS_PER_PAGE) ?>&mark=<?=Usuario::getById($pedido->getUsuarioId())->getId()?>#<?=Usuario::getById($pedido->getUsuarioId())->getId()?>" class="enlace-basico" target="_blank">
                    <?=Usuario::getById($pedido->getUsuarioId())->getNombre()?> <?=Usuario::getById($pedido->getUsuarioId())->getApellidos()?></a>

                <?php if($_SESSION['identity']['id'] == $pedido->getUsuarioId()): ?>
                    <span style="font-weight: normal;">(tú)</span>
                <?php endif; ?>
            </span>
        <?php endif; ?>
        <div class="separador-2" style="background-color: lightgray; margin: 10px 0px"></div>
        Envío a <a href="https://www.google.com/maps/search/?q=<?=urlencode('C. '.$pedido->getDireccion().' '.$pedido->getCodigoPostal().' '.$pedido->getMunicipio().' '.$pedido->getProvincia())?>" target="_blank" class="enlace-basico">
            <?=$pedido->getDireccion().', '.$pedido->getPoblacion().' ('.$pedido->getCodigoPostal().') - '.$pedido->getProvincia()?>
        </a>
    </h4>
</div>

<script src="<?=BASE_URL?>js/ajusteImagenesAdminProductos.js"></script>