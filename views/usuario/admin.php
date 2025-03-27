<h1>Administración de Usuarios</h1>

<!-- Botón de creación de usuario -->

<a href="<?=BASE_URL?>usuario/crear">
    <button class="boton more-margin">
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
        <th>Acciones</th>
    </tr>

    <?php foreach($usuarios as $usuario): ?>

        <tr id="<?=$usuario->getId()?>">

            <td><?=$usuario->getId()?></td>
            <td><?=$usuario->getNombre()?></td>
            <td><?=$usuario->getApellidos()?></td>
            <td><?=$usuario->getEmail()?></td>
            
            <!-- Si el rol es 'user', mostrar 'Usuario', si es 'admin', mostrar 'Administrador' -->
            <td><?=($usuario->getRol() === 'user') ? 'Usuario' : 'Administrador'?></td>

            <!-- Imagen del Usuario -->
            <td>
                <?php if($usuario->getImagen()): ?>
                    <img src="<?=BASE_URL?>assets/images/uploads/usuarios/<?=$usuario->getImagen()?>?t=<?=time()?>" alt="Imagen de perfil de <?=$usuario->getNombre()?>" style="max-width: 100px; max-height: 100px; border-radius: 50%;">
                <?php else: ?>
                    <span>No disponible</span>
                <?php endif; ?>
            </td>

            <td class="acciones-especial">
                
                <a class="forzar-azul" href="<?=BASE_URL?>usuario/gestion&id=<?=$usuario->getId()?>">
                    Editar
                </a>

                <div class="separador especial"></div>

                <a href="<?=BASE_URL?>usuario/eliminar&id=<?=$usuario->getId()?>">
                    Eliminar
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