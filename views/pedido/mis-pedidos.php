<?php
    use models\LineaPedido;
?>

<h1>Mis Pedidos</h1>

<div class="paginacion" style="margin-top: 0px;">

    <?php if($totalPag > 1): ?>

        <a href="<?=BASE_URL?>pedido/misPedidos&pag=1" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
            <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                <img src="<?=BASE_URL?>assets/images/doubleleft.png" alt="Primera página" style="width: 10px; padding: 5px;">
            </button>
        </a>

        <a href="<?=BASE_URL?>pedido/misPedidos&pag=<?= ($_SESSION['pag'] > 1) ? $_SESSION['pag'] - 1 : 1 ?>" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
            <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                <img src="<?=BASE_URL?>assets/images/left.svg" alt="Página anterior">
            </button>
        </a>

        <h1>Pág.
            <form style="padding: 0px; background-color: unset; display: inline;" action="<?= BASE_URL ?>pedido/misPedidos" method="GET">
                <input type="number" name="pag" min="1" max="<?= $totalPag ?>" class="quantity-input" value="<?= $_SESSION['pag'] ?>" style="width: 60px; height: 40px; font-size: 30px; padding: 5px; margin: 0px;" required>
                <input type="submit" value="Ir" style="display: none;">
            </form>
        </h1>

        <a href="<?=BASE_URL?>pedido/misPedidos&pag=<?= ($_SESSION['pag'] < $totalPag) ? $_SESSION['pag'] + 1 : $totalPag ?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
            <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                <img src="<?=BASE_URL?>assets/images/right.svg" alt="Página siguiente">
            </button>
        </a>

        <a href="<?=BASE_URL?>pedido/misPedidos&pag=<?=$totalPag?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
            <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                <img src="<?=BASE_URL?>assets/images/doubleright.png" alt="Última página" style="width: 10px; padding: 5px;">
            </button>
        </a>

    <?php endif; ?>

</div>

<table>

    <tr>
        <th>Fecha</th>
        <th>Nº Productos</th>
        <th>Comunidad</th>
        <th>Provincia</th>
        <th>Municipio</th>
        <th>Población</th>
        <th>Núcleo</th>
        <th>Código Postal</th>
        <th>Dirección</th>
        <th>Coste</th>
        <th>Estado</th>
        <th>Ver</th>
    </tr>

    <?php foreach($pedidos as $pedido): ?>

        <tr id="<?=$pedido->getId()?>">

            <td>
                <?=date('d/m/Y', strtotime($pedido->getFecha()))?>
                <div style="padding: 5px;"></div>
                <?=date('H:i:s', strtotime($pedido->getHora()))?>
            </td>

            <td style="font-size: 150%">

                <?php
                
                    $numProductos = 0;
                    $lineas = LineaPedido::getByPedido($pedido->getId());

                    foreach($lineas as $linea){
                        $numProductos += $linea->getUnidades();
                    }
                    
                    echo $numProductos . ' producto' . (($numProductos > 1) ? 's' : '');
                
                ?>

            </td>

            <td><?=$pedido->getComunidad()?></td>
            <td><?=$pedido->getProvincia()?></td>
            <td><?=$pedido->getMunicipio()?></td>
            <td><?=$pedido->getPoblacion()?></td>
            <td><?=$pedido->getNucleo()?></td>
            <td><?=$pedido->getCodigoPostal()?></td>
            <td><?=$pedido->getDireccion()?></td>
            <td style="font-size: 200%;"><?=$pedido->getCoste()?> €</td>
            
            <td style="font-size: 125%;">
                <?php if($pedido->getEstado() == 'Pendiente'): ?>
                    <span style="color: brown;"><?=$pedido->getEstado()?></span>
                <?php elseif($pedido->getEstado() == 'Confirmado'): ?>
                    <span style="color: green;"><?=$pedido->getEstado()?></span>
                <?php endif; ?>
            </td>

            <td class="acciones-especial">

                <a href="<?=BASE_URL?>pedido/ver&id=<?=$pedido->getId()?>" style="color: blue;">
                    <div>
                        <img src="<?=BASE_URL?>assets/images/ver.svg" alt="Ver pedido" class="ver">
                    </div>
                </a>

            </td>

        </tr>

    <?php endforeach; ?>

</table>

<div class="paginacion">

    <?php if($totalPag > 1): ?>

        <a href="<?=BASE_URL?>pedido/misPedidos&pag=1" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
            <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                <img src="<?=BASE_URL?>assets/images/doubleleft.png" alt="Primera página" style="width: 10px; padding: 5px;">
            </button>
        </a>

        <a href="<?=BASE_URL?>pedido/misPedidos&pag=<?= ($_SESSION['pag'] > 1) ? $_SESSION['pag'] - 1 : 1 ?>" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
            <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                <img src="<?=BASE_URL?>assets/images/left.svg" alt="Página anterior">
            </button>
        </a>

        <h1>Pág.
            <form style="padding: 0px; background-color: unset; display: inline;" action="<?= BASE_URL ?>pedido/misPedidos" method="GET">
                <input type="number" name="pag" min="1" max="<?= $totalPag ?>" class="quantity-input" value="<?= $_SESSION['pag'] ?>" style="width: 60px; height: 40px; font-size: 30px; padding: 5px; margin: 0px;" required>
                <input type="submit" value="Ir" style="display: none;">
            </form>
        </h1>

        <a href="<?=BASE_URL?>pedido/misPedidos&pag=<?= ($_SESSION['pag'] < $totalPag) ? $_SESSION['pag'] + 1 : $totalPag ?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
            <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                <img src="<?=BASE_URL?>assets/images/right.svg" alt="Página siguiente">
            </button>
        </a>

        <a href="<?=BASE_URL?>pedido/misPedidos&pag=<?=$totalPag?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
            <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                <img src="<?=BASE_URL?>assets/images/doubleright.png" alt="Última página" style="width: 10px; padding: 5px;">
            </button>
        </a>

    <?php endif; ?>

</div>

<script src="<?=BASE_URL?>js/actualizarPaginacion.js"></script>