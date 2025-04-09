<h1 class="mqAdminTitulo">Administración de Usuarios</h1>

<!-- Botón de creación de usuario -->

<a href="<?=BASE_URL?>usuario/crear" style="text-decoration: none; margin: 10px">
    <button class="boton more-margin" style="display: flex; justify-content: center; align-items: center; margin: 0 auto;">
        <img src="<?=BASE_URL?>assets/images/crear.svg" alt="Crear usuario" style="margin-right: 4px">
        Crear Usuario
    </button>
</a>

<div class="paginacion" style="margin-top: 0px;">

    <?php if($totalPag > 1): ?>

        <a href="<?=BASE_URL?>usuario/admin&pag=1" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
            <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                <img src="<?=BASE_URL?>assets/images/doubleleft.png" alt="Primera página" style="width: 10px; padding: 5px;">
            </button>
        </a>

        <a href="<?=BASE_URL?>usuario/admin&pag=<?= ($_SESSION['pag'] > 1) ? $_SESSION['pag'] - 1 : 1 ?>" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
            <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                <img src="<?=BASE_URL?>assets/images/left.svg" alt="Página anterior">
            </button>
        </a>

        <h1>Pág.
            <form style="padding: 0px; background-color: unset; display: inline;" action="<?= BASE_URL ?>usuario/admin" method="GET">
                <input type="number" name="pag" min="1" max="<?= $totalPag ?>" class="quantity-input" value="<?= $_SESSION['pag'] ?>" style="width: 60px; height: 40px; font-size: 30px; padding: 5px; margin: 0px;" required>
                <input type="submit" value="Ir" style="display: none;">
            </form>
        </h1>

        <a href="<?=BASE_URL?>usuario/admin&pag=<?= ($_SESSION['pag'] < $totalPag) ? $_SESSION['pag'] + 1 : $totalPag ?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
            <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                <img src="<?=BASE_URL?>assets/images/right.svg" alt="Página siguiente">
            </button>
        </a>

        <a href="<?=BASE_URL?>usuario/admin&pag=<?=$totalPag?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
            <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                <img src="<?=BASE_URL?>assets/images/doubleright.png" alt="Última página" style="width: 10px; padding: 5px;">
            </button>
        </a>

    <?php endif; ?>

</div>

<table>

    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Email</th>
        <th>Rol</th>
        <th>Imagen</th>
        <th>Color</th>
        <th>Acciones</th>
    </tr>

    <?php foreach($usuarios as $usuario): ?>

        <tr id="<?=$usuario->getId()?>" style="<?=isset($_GET['mark']) && $_GET['mark'] == $usuario->getId() ? 'border: 2px solid var(--color-1); background-color: var(--color-4);' : ''?>">

            <td><?=$usuario->getId()?></td>
            <td><?=$usuario->getNombre()?></td>
            <td><?=$usuario->getApellidos()?></td>
            <td><?=$usuario->getEmail()?></td>
            
            <!-- Si el rol es 'user', mostrar 'Usuario', si es 'admin', mostrar 'Administrador' -->
            <td><?=($usuario->getRol() === 'user') ? 'Usuario' : 'Administrador'?></td>

            <!-- Imagen del Usuario -->
            <td>
                <?php if($usuario->getImagen()): ?>
                    <img src="<?=BASE_URL?>assets/images/uploads/usuarios/<?=$usuario->getImagen()?>?t=<?=time()?>" alt="Imagen de perfil de <?=$usuario->getNombre()?>" style="max-width: 100px; max-height: 100px; width: 100px; height: 100px; border-radius: 50%;">
                <?php else: ?>
                    <span>No disponible</span>
                <?php endif; ?>
            </td>

            <!-- Color del Usuario -->
            <td style="background-color: <?=($usuario->getColor() == '#000000' || $usuario->getColor() == '#ffffff') ? "unset" : $usuario->getColor()?>; width: 50px; height: 50px;">
                
                <?php
                    $color = $usuario->getColor();

                    // Verificar si el color es blanco o negro para asignar un color de texto por defecto
                    if ($color == '#000000' || $color == '#ffffff') {
                        $textColor = 'black'; // Texto negro para los colores extremos
                    } else {
                        // Eliminar el "#" y calcular la luminosidad
                        $hex = ltrim($color, '#');
                        $r = hexdec(substr($hex, 0, 2));
                        $g = hexdec(substr($hex, 2, 2));
                        $b = hexdec(substr($hex, 4, 2));

                        // Calcular la luminosidad
                        $luminosity = 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;

                        // Decidir el color del texto según la luminosidad
                        $textColor = $luminosity > 128 ? 'black' : 'white';
                    }
                ?>
            
                <?php if($usuario->getColor() == '#000000' || $usuario->getColor() == '#ffffff'): ?>
                    <span>No</span>
                <?php else: ?>
                    <span style="color: <?= $textColor; ?>"><?= strtoupper($color) ?></span>
                <?php endif; ?>
            </td>

            <td class="acciones" style="display: flex; flex-direction: row; justify-content: center; align-items: center; gap: 10px; margin: 0px; height: 105px">
                
                <a class="forzar-azul" href="<?=BASE_URL?>usuario/gestion&id=<?=$usuario->getId()?>">
                    <img src="<?=BASE_URL?>assets/images/editar.svg" alt="Editar usuario" class="ver" style="background-color: #2980B9">
                </a>

                <a href="<?=BASE_URL?>usuario/eliminar&id=<?=$usuario->getId()?>" onclick="return confirm('¿Estás seguro de que quieres eliminar el usuario <?=$usuario->getNombre()?>?\nEsta acción no se puede deshacer.')">
                    <img src="<?=BASE_URL?>assets/images/vaciar.svg" alt="Eliminar usuario" class="ver" style="background-color: rgb(218, 0, 0);">
                </a>

            </td>

        </tr>

    <?php endforeach; ?>

</table>

<div class="paginacion">

    <?php if($totalPag > 1): ?>

        <a href="<?=BASE_URL?>usuario/admin&pag=1" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
            <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                <img src="<?=BASE_URL?>assets/images/doubleleft.png" alt="Primera página" style="width: 10px; padding: 5px;">
            </button>
        </a>

        <a href="<?=BASE_URL?>usuario/admin&pag=<?= ($_SESSION['pag'] > 1) ? $_SESSION['pag'] - 1 : 1 ?>" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
            <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                <img src="<?=BASE_URL?>assets/images/left.svg" alt="Página anterior">
            </button>
        </a>

        <h1>Pág.
            <form style="padding: 0px; background-color: unset; display: inline;" action="<?= BASE_URL ?>usuario/admin" method="GET">
                <input type="number" name="pag" min="1" max="<?= $totalPag ?>" class="quantity-input" value="<?= $_SESSION['pag'] ?>" style="width: 60px; height: 40px; font-size: 30px; padding: 5px; margin: 0px;" required>
                <input type="submit" value="Ir" style="display: none;">
            </form>
        </h1>

        <a href="<?=BASE_URL?>usuario/admin&pag=<?= ($_SESSION['pag'] < $totalPag) ? $_SESSION['pag'] + 1 : $totalPag ?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
            <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                <img src="<?=BASE_URL?>assets/images/right.svg" alt="Página siguiente">
            </button>
        </a>

        <a href="<?=BASE_URL?>usuario/admin&pag=<?=$totalPag?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
            <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                <img src="<?=BASE_URL?>assets/images/doubleright.png" alt="Última página" style="width: 10px; padding: 5px;">
            </button>
        </a>

    <?php endif; ?>

</div>

<script src="<?=BASE_URL?>js/actualizarPaginacion.js"></script>