<?php
    use helpers\Utils;
    use models\Producto;
    use models\Categoria;
    use models\Usuario;
    use models\Valoracion;

    $todas = Valoracion::getByProducto($producto->getId());
?>

<div class="container ver-producto">
    
    <img src="<?=BASE_URL?>assets/images/uploads/productos/<?=$producto->getImagen()?>" alt="<?=$producto->getNombre()?>">

    <script src="<?=BASE_URL?>js/ajusteImagenesProductos.js?t=<?=time()?>"></script>

    <div class="product-info">
        
        <h1><?=$producto->getNombre()?></h1>

        <div style="padding: 1px; background-color: lightgray;"></div>

        <div class="product-info-more">
            
            <ul>

                <?php if(count($todas) > 0){

                    echo '<li style="list-style: none; margin: 0px;">';

                    $suma = 0;

                    // Sumar todas las puntuaciones
                    foreach($todas as $valoracion) {
                        $suma += $valoracion->getPuntuacion();
                    }

                    // Calcular la puntuación promedio
                    $puntuacion = $suma / count($todas);

                    // Mostrar las estrellas, redondeando la puntuación al entero más cercano
                    $estrellas = round($puntuacion);

                    for($i = 1; $i <= $estrellas; $i++) {
                        echo '⭐';
                    }

                    // Mostrar la puntuación redondeada a dos decimales, pero sin mostrar el cero extra si es innecesario
                    $puntuacion_formateada = number_format($puntuacion, 2);
                    $puntuacion_formateada = rtrim($puntuacion_formateada, '0'); // Elimina los ceros al final

                    // Si el segundo decimal es 0, elimina el punto
                    if (substr($puntuacion_formateada, -1) === '.') {
                        $puntuacion_formateada = substr($puntuacion_formateada, 0, -1);
                    }

                    echo ' (' . $puntuacion_formateada . ')</li>';

                }?>

                <li><h2>Categoría: <span class="value"><?=Categoria::getById($producto->getCategoriaId())->getNombre()?></span></h2></li>

                <?php if ($producto->getOferta() > 0): ?>
                    <li>
                        <h2>Precio: 
                            <span class="value">
                                <span style="color: red; text-decoration: line-through; font-size: 80%;"><?=$producto->getPrecio()?> €</span>
                                <span style="color: rgb(0, 0, 0); font-weight: bold;"><?=round($producto->getPrecio() * (1 - $producto->getOferta() / 100), 2)?> €</span>
                                <span style="font-size: 80%; opacity: 0.5">(-<?=$producto->getOferta()?>%)</span>
                            </span>
                        </h2>
                    </li>
                <?php else: ?>
                    <li>
                        <h2>Precio: <span class="value" style="font-weight: bold;"><?=$producto->getPrecio()?> €</span></h2>
                    </li>
                <?php endif; ?>

                <li>
                    <h2>Descripción: <span class="value desc"><?=(strlen($producto->getDescripcion()) > 0) ? $producto->getDescripcion() : 'Sin descripción'?></span></h2>
                </li>

            </ul>
        
        </div>

    </div>

</div>

<!-- Este div aparece si stock es mayor que 0, si no, aparece un mensaje en rojo "Producto agotado" -->

<?php if ($producto->getStock() > 0): ?>

    <div class="add-to-cart" id="carrito">
        <form action="<?=BASE_URL?>carrito/add" method="POST" style="max-width: unset;">
            <input type="hidden" name="productoId" value="<?=$producto->getId()?>">
            <label for="cantidad"><h2 style="margin-top: 40px; font-weight: normal;">Cantidad: </h2></label>
            <input type="number" name="cantidad" min="1" value="1" class="quantity-input">
            <button type="submit" class="boton" style="display: flex; align-items: center; justify-content: center;">
                <img src="<?=BASE_URL?>assets/images/añadir.svg" alt="Añadir al carrito" style="margin-right: 4px;">
                <span>Añadir al carrito</span>
            </button>
        </form>
    </div>

<?php else: ?>

    <strong class="yellow mqAdminTitulo">Este producto está agotado.</strong>

<?php endif; ?>

<?php if(isset($_SESSION['carritoResultado']) && $_SESSION['carritoResultado'] == 'failed_stock'): ?>

    <strong class="red mqAdminTitulo">No tenemos el stock solicitado para este producto.</strong>
    <strong class="red" style="font-size: 95%; margin-top: 10px;">Stock disponible: <?=$producto->getStock()?> unidades.</strong>
    <strong style="font-size: 95%; margin-top: 10px;">
        
        <?php

        if (isset($_SESSION['carrito'])) {
            $cantidadEnCarrito = 0;

            foreach ($_SESSION['carrito'] as $indice => $elemento) {

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

<?php elseif(isset($_SESSION['carritoResultado']) && $_SESSION['carritoResultado'] == 'complete'): ?>

    <strong class="green mqAdminTitulo">¡Producto añadido al carrito!</strong>
    <strong class="green" style="font-size: 95%; margin-top: 10px;">(+<?=$_SESSION['cantidadAnadida']?> unidad<?=$_SESSION['cantidadAnadida'] > 1 ? 'es' : ''?>)</strong>

    <a href="<?=BASE_URL?>carrito/gestion" class="boton ver-carrito" style="margin-top: 20px; margin-bottom: 20px;">
        <button>
            <img src="<?=BASE_URL?>assets/images/carrito.svg" alt="Ver carrito" style="filter: invert(1);">
            <span>Ver carrito</span>
        </button>
    </a>

<?php elseif(isset($_SESSION['carritoResultado']) && $_SESSION['carritoResultado'] == 'failed'): ?>

    <strong class="red mqAdminTitulo" id="failed">Error al añadir el producto al carrito.</strong>

<?php endif; ?>

<?php Utils::deleteSession('carritoResultado'); ?>
<?php Utils::deleteSession('cantidadAnadida'); ?>

<div class="separador-2"></div>

<?php if(isset($_SESSION['identity']) && Utils::usuarioPuedeValorarProducto($_SESSION['identity']['id'], $producto->getId())): ?>

<form action="<?=BASE_URL?>valoracion/guardar" method="POST" class="form-comentario">

    <span>Has comprado este producto.</span>

    <h2 style="margin-top: 0px; margin-bottom: 20px;">Valóralo como:</h2>

    <div style="display: flex; flex-direction: column; align-items: center;">
        <img src="<?=BASE_URL?>assets/images/uploads/usuarios/<?=$_SESSION['identity']['imagen']?>" alt="<?=$_SESSION['identity']['nombre']?>" style="border-radius: 50%; width: 100px; height: 100px;">
        <h3><?=$_SESSION['identity']['nombre']?> <?=$_SESSION['identity']['apellidos']?></h3>
    </div>

    <div class="form-group">

        <label for="puntuacion">Puntuación</label>
        <select name="puntuacion" id="puntuacion" required>
            <option value="" disabled <?=isset($_SESSION['form_data']['puntuacion']) ? '' : 'selected'?>>Selecciona una puntuación</option>
            <option value="5" <?=isset($_SESSION['form_data']['puntuacion']) && $_SESSION['form_data']['puntuacion'] == 5 ? 'selected' : ''?>>⭐⭐⭐⭐⭐</option>
            <option value="4" <?=isset($_SESSION['form_data']['puntuacion']) && $_SESSION['form_data']['puntuacion'] == 4 ? 'selected' : ''?>>⭐⭐⭐⭐</option>
            <option value="3" <?=isset($_SESSION['form_data']['puntuacion']) && $_SESSION['form_data']['puntuacion'] == 3 ? 'selected' : ''?>>⭐⭐⭐</option>
            <option value="2" <?=isset($_SESSION['form_data']['puntuacion']) && $_SESSION['form_data']['puntuacion'] == 2 ? 'selected' : ''?>>⭐⭐</option>
            <option value="1" <?=isset($_SESSION['form_data']['puntuacion']) && $_SESSION['form_data']['puntuacion'] == 1 ? 'selected' : ''?>>⭐</option>
        </select>

        <?php if(isset($_SESSION['create']) && $_SESSION['create'] == 'failed_puntuacion'): ?>

            <small class="error">La puntuación que has introducido no es válida</small>
            <?php Utils::deleteSession('create'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">

        <label for="comentario">Comentario</label>
        <textarea name="comentario" id="comentario" cols="30" rows="10" placeholder="Escribe tu comentario aquí... (opcional)" required><?=isset($_SESSION['form_data']['comentario']) ? $_SESSION['form_data']['comentario'] : ''?></textarea>

    </div>

    <input type="hidden" name="producto_id" value="<?=$producto->getId()?>">

    <button type="submit" class="boton">Enviar</button>

</form>

<?php endif;?>

<h1>Comentarios <?= (count($todas) > 0) ? '('.count($todas).')' : ''?></h1>

<!-- Si el usuario actual ha comprado el producto, mostramos el formulario para añadir una valoración -->

<?php if(isset($_SESSION['create']) && $_SESSION['create'] == 'complete'): ?>

    <strong class="green mqAdminTitulo" id="complete" style="margin-top: 0px">¡Comentario enviado!</strong>
    <strong class="green" style="font-size: 95%; margin-top: 10px; margin-bottom: 20px;">Gracias por tu valoración.</strong>

<?php elseif(isset($_SESSION['create']) && $_SESSION['create'] == 'failed_valoracion'): ?>

    <strong class="red mqAdminTitulo" id="failed" style="margin-bottom: 20px">Error al enviar el comentario.</strong>

<?php endif; ?>

<?php if(isset($_SESSION['delete']) && $_SESSION['delete'] == 'complete'): ?>

    <strong class="green mqAdminTitulo" id="complete" style="margin-top: 0px; margin-bottom: 20px;">¡Comentario eliminado!</strong>

<?php elseif(isset($_SESSION['delete']) && $_SESSION['delete'] == 'failed'): ?>

    <strong class="red mqAdminTitulo" id="failed">Error al eliminar el comentario.</strong>

<?php endif; ?>

<?php if($valoraciones == null): ?>

    <strong style="margin-top: 0px; margin-bottom: 20px; font-size: 120%; color: gray;" class="mqAdminTitulo">Aún no hay comentarios acerca de este producto.</strong>

<?php else: ?>

    <?php foreach($valoraciones as $valoracion): ?>

        <div class="container comentario">

            <div class="superior">

                <div class="izquierda">

                    <img src="<?=BASE_URL?>assets/images/uploads/usuarios/<?=Usuario::getById($valoracion->getUsuarioId())->getImagen()?>" alt="<?=Usuario::getById($valoracion->getUsuarioId())->getNombre()?>">

                    <div class="nombre-y-puntuacion">
                        
                        <h2><?=Usuario::getById($valoracion->getUsuarioId())->getNombre()?> <?=Usuario::getById($valoracion->getUsuarioId())->getApellidos()?></h2>
                        <h1><?php for($i = 1; $i <= $valoracion->getPuntuacion(); $i++): ?>⭐<?php endfor; ?></h1>

                    </div>

                </div>

                <div class="derecha" style="display: flex; flex-direction: row; justify-content: end; align-items: center">

                    <?php if($valoracion->getUsuarioId() == $_SESSION['identity']['id'] || $_SESSION['identity']['rol'] == 'admin'): ?>
                        
                        <a href="<?=BASE_URL?>valoracion/eliminar&id=<?=$valoracion->getId()?>" class="oscurecer" style="margin-right: 30px; margin-top: -20px;" onclick="return confirm('¿Estás seguro de que quieres eliminar la valoración?\nEsta acción no se puede deshacer.')">
                            <button style="padding: 5px; width: 50px; height: 50px; background-color: rgb(218, 0, 0);">
                                <img src="<?=BASE_URL?>assets/images/vaciar.svg" style="width: 30px; min-height: unset; max-height: unset; padding: 0px;">
                            </button>
                        </a>
                        
                    <?php endif; ?>

                    <span class="morir">Comentó el día <?=date('d/m/Y', strtotime($valoracion->getFecha()))?> a las <?=date('H:i:s', strtotime($valoracion->getFecha()))?> horas.</span>
        
                </div>

            </div>

            <p class="comentario-texto">
                <?=$valoracion->getComentario()?>
            </p>

        </div>

    <?php endforeach; ?>

    <div class="paginacion" style="margin: 0px;">

        <?php if($totalPag > 1): ?>

            <a href="<?=BASE_URL?>producto/ver&id=<?=$producto->getId()?>&pag=1" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/doubleleft.png" alt="Primera página" style="width: 10px; padding: 5px;">
                </button>
            </a>

            <a href="<?=BASE_URL?>producto/ver&id=<?=$producto->getId()?>&pag=<?= ($_SESSION['pag'] > 1) ? $_SESSION['pag'] - 1 : 1 ?>" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/left.svg" alt="Página anterior">
                </button>
            </a>

            <h1>Pág.
                <form style="padding: 0px; background-color: unset; display: inline;" action="<?= BASE_URL ?>producto/ver&id=<?=$producto->getId()?>" method="GET">
                    <input type="number" name="pag" min="1" max="<?= $totalPag ?>" class="quantity-input" value="<?= $_SESSION['pag'] ?>" style="width: 60px; height: 40px; font-size: 30px; padding: 5px; margin: 0px;" required>
                    <input type="submit" value="Ir" style="display: none;">
                </form>
            </h1>

            <a href="<?=BASE_URL?>producto/ver&id=<?=$producto->getId()?>&pag=<?= ($_SESSION['pag'] < $totalPag) ? $_SESSION['pag'] + 1 : $totalPag ?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/right.svg" alt="Página siguiente">
                </button>
            </a>

            <a href="<?=BASE_URL?>producto/ver&id=<?=$producto->getId()?>&pag=<?=$totalPag?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/doubleright.png" alt="Última página" style="width: 10px; padding: 5px;">
                </button>
            </a>

        <?php endif; ?>

    </div>

<?php endif; ?>

<script src="<?=BASE_URL?>js/actualizarPaginacion.js?t=<?=time()?>"></script>

<?php Utils::deleteSession('carritoResultado'); ?>
<?php Utils::deleteSession('create'); ?>
<?php Utils::deleteSession('delete'); ?>