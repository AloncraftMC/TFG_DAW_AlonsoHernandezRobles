<?php
    use models\LineaPedido;
    use models\Pedido;
    use models\Usuario;
?>

<h1 class="mqAdminTitulo">Administración de Pedidos</h1>

<?php if(count(Pedido::getAll()) == 0): ?>

    <h3>No hay pedidos.</h3>

<?php else: ?>

    <div class="paginacion" style="margin-top: 0px;">

        <?php if($totalPag > 1): ?>

            <a href="<?=BASE_URL?>pedido/admin&pag=1" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/doubleleft.png" alt="Primera página" style="width: 10px; padding: 5px;">
                </button>
            </a>

            <a href="<?=BASE_URL?>pedido/admin&pag=<?= ($_SESSION['pag'] > 1) ? $_SESSION['pag'] - 1 : 1 ?>" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/left.svg" alt="Página anterior">
                </button>
            </a>

            <h1><span class="mqAdminPag">Pág.</span>
                <form style="padding: 0px; background-color: unset; display: inline;" action="<?= BASE_URL ?>pedido/admin" method="GET">
                    <input type="number" name="pag" min="1" max="<?= $totalPag ?>" class="quantity-input" value="<?= $_SESSION['pag'] ?>" style="width: 60px; height: 40px; font-size: 30px; padding: 5px; margin: 0px;" required>
                    <input type="submit" value="Ir" style="display: none;">
                </form>
            </h1>

            <a href="<?=BASE_URL?>pedido/admin&pag=<?= ($_SESSION['pag'] < $totalPag) ? $_SESSION['pag'] + 1 : $totalPag ?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/right.svg" alt="Página siguiente">
                </button>
            </a>

            <a href="<?=BASE_URL?>pedido/admin&pag=<?=$totalPag?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/doubleright.png" alt="Última página" style="width: 10px; padding: 5px;">
                </button>
            </a>

        <?php endif; ?>

    </div>

    <table class="tabla-pedidos">

        <tr>
            <th>ID</th>
            <th style="min-width: 100px">Nº Productos</th>
            <th>Usuario</th>
            <th>Dirección</th>
            <th>Ubicación</th>
            <th>Coste</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>

        <?php foreach($pedidos as $pedido): ?>

            <tr id="<?=$pedido->getId()?>">

                <td><?=$pedido->getId()?></td>

                <td class="num-productos">

                    <span class="largo">
                    <?php
                    
                        $numProductos = 0;
                        $lineas = LineaPedido::getByPedido($pedido->getId());

                        foreach($lineas as $linea){
                            $numProductos += $linea->getUnidades();
                        }
                        
                        echo $numProductos . ' producto' . (($numProductos > 1) ? 's' : '');
                    
                    ?>
                    </span>
                    <span class="corto">
                    <?php
                    
                        $numProductos = 0;
                        $lineas = LineaPedido::getByPedido($pedido->getId());

                        foreach($lineas as $linea){
                            $numProductos += $linea->getUnidades();
                        }
                        
                        echo $numProductos;

                    ?>
                    </span>

                </td>

                <td>
                    <a href="<?=BASE_URL?>usuario/admin&pag=<?= ceil(Usuario::getById($pedido->getUsuarioId())->getPosicion() / ITEMS_PER_PAGE) ?>&mark=<?=Usuario::getById($pedido->getUsuarioId())->getId()?>#<?=Usuario::getById($pedido->getUsuarioId())->getId()?>" class="enlace-basico" target="_blank">
                        <?=Usuario::getById($pedido->getUsuarioId())->getNombre()?> <?=Usuario::getById($pedido->getUsuarioId())->getApellidos()?>
                    </a>
                </td>

                <td><?=$pedido->getComunidad()?>, <?=$pedido->getProvincia()?>, <?=$pedido->getMunicipio()?>, <?=$pedido->getPoblacion()?>, <?=$pedido->getNucleo()?>, <?=$pedido->getCodigoPostal()?>, <?=$pedido->getDireccion()?></td>
                
                <td class="acciones-especial">
                    <a href="https://www.google.com/maps/search/?q=<?='C. '.$pedido->getDireccion().' '.$pedido->getCodigoPostal().' '.$pedido->getMunicipio().' '.$pedido->getProvincia()?>" target="_blank" class="enlace-basico">
                        <div>
                            <img src="<?=BASE_URL?>assets/images/maps.svg" alt="Ver Ubicación" class="ver">
                        </div>
                    </a>
                </td>
                
                <td><?=$pedido->getCoste()?> €</td>

                <td>
                    <?=date('d/m/Y', strtotime($pedido->getFecha()))?>
                    <div style="padding: 5px;"></div>
                    <?=date('H:i:s', strtotime($pedido->getHora()))?>
                </td>
                
                <td><?=$pedido->getEstado()?></td>

                <td class="acciones-especial" style="display: flex; flex-direction: row; justify-content: center; align-items: center; gap: 10px; margin: 0px; height: 100px">

                    <!-- Si el pedido está pendiente, que aparezca el botón de confirmar -->
                    <!-- Si el pedido está confirmado, que aparezca el botón de enviar -->
                    <!-- Si el pedido está enviado, que no aparezca nada -->

                    <?php if($pedido->getEstado() == 'Pendiente'): ?>

                        <a href="<?=BASE_URL?>pedido/confirmar&id=<?=$pedido->getId()?>">
                            <div>
                                <img src="<?=BASE_URL?>assets/images/confirmar.svg" alt="Confirmar pedido" class="ver" style="background-color: rgb(47, 158, 0);">
                            </div>
                        </a>

                    <?php elseif($pedido->getEstado() == 'Confirmado'): ?>

                        <a href="<?=BASE_URL?>pedido/enviar&id=<?=$pedido->getId()?>">
                            <div>
                                <img src="<?=BASE_URL?>assets/images/enviar.svg" alt="Confirmar pedido" class="ver" style="background-color: rgb(47, 158, 0);">
                            </div>
                        </a>

                    <?php endif; ?>

                    <a href="<?=BASE_URL?>pedido/ver&id=<?=$pedido->getId()?>">
                        <div>
                            <img src="<?=BASE_URL?>assets/images/ver.svg" alt="Ver pedido" class="ver" style="background-color: #2980B9">
                        </div>
                    </a>

                    <a href="<?=BASE_URL?>pedido/eliminar&id=<?=$pedido->getId()?>" onclick="return confirm('¿Estás seguro de que quieres eliminar el pedido con ID #<?=$pedido->getId()?>?\nEsta acción no se puede deshacer.')">
                        <div>
                            <img src="<?=BASE_URL?>assets/images/vaciar.svg" alt="Eliminar pedido" class="ver" style="background-color: rgb(218, 0, 0);">
                        </div>
                    </a>

                </td>

            </tr>

        <?php endforeach; ?>

    </table>

    <div class="paginacion">

        <?php if($totalPag > 1): ?>

            <a href="<?=BASE_URL?>pedido/admin&pag=1" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/doubleleft.png" alt="Primera página" style="width: 10px; padding: 5px;">
                </button>
            </a>

            <a href="<?=BASE_URL?>pedido/admin&pag=<?= ($_SESSION['pag'] > 1) ? $_SESSION['pag'] - 1 : 1 ?>" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/left.svg" alt="Página anterior">
                </button>
            </a>

            <h1><span class="mqAdminPag">Pág.</span>
                <form style="padding: 0px; background-color: unset; display: inline;" action="<?= BASE_URL ?>pedido/admin" method="GET">
                    <input type="number" name="pag" min="1" max="<?= $totalPag ?>" class="quantity-input" value="<?= $_SESSION['pag'] ?>" style="width: 60px; height: 40px; font-size: 30px; padding: 5px; margin: 0px;" required>
                    <input type="submit" value="Ir" style="display: none;">
                </form>
            </h1>

            <a href="<?=BASE_URL?>pedido/admin&pag=<?= ($_SESSION['pag'] < $totalPag) ? $_SESSION['pag'] + 1 : $totalPag ?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/right.svg" alt="Página siguiente">
                </button>
            </a>

            <a href="<?=BASE_URL?>pedido/admin&pag=<?=$totalPag?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/doubleright.png" alt="Última página" style="width: 10px; padding: 5px;">
                </button>
            </a>

        <?php endif; ?>

    </div>

<?php endif; ?>

<script src="<?=BASE_URL?>js/actualizarPaginacion.js?t=<?=time()?>"></script>