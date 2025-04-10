<h1 class="mqAdminTitulo">Administración de Categorías</h1>

<a href="<?=BASE_URL?>categoria/crear" style="text-decoration: none; margin: 10px">
    <button class="boton more-margin" style="display: flex; justify-content: center; align-items: center; margin: 0 auto;">
        <img src="<?=BASE_URL?>assets/images/crear.svg" alt="Crear categoría" style="margin-right: 4px">
        Crear Categoría
    </button>
</a>

<?php if(count($categorias) == 0): ?>

    <h3>No hay categorías.</h3>

<?php else: ?>

    <div class="paginacion" style="margin-top: 0px;">

        <?php if($totalPag > 1): ?>

            <a href="<?=BASE_URL?>categoria/admin&pag=1" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/doubleleft.png" alt="Primera página" style="width: 10px; padding: 5px;">
                </button>
            </a>

            <a href="<?=BASE_URL?>categoria/admin&pag=<?= ($_SESSION['pag'] > 1) ? $_SESSION['pag'] - 1 : 1 ?>" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/left.svg" alt="Página anterior">
                </button>
            </a>

            <h1><span class="mqAdminPag">Pág.</span>
                <form style="padding: 0px; background-color: unset; display: inline;" action="<?= BASE_URL ?>categoria/admin" method="GET">
                    <input type="number" name="pag" min="1" max="<?= $totalPag ?>" class="quantity-input" value="<?= $_SESSION['pag'] ?>" style="width: 60px; height: 40px; font-size: 30px; padding: 5px; margin: 0px;" required>
                    <input type="submit" value="Ir" style="display: none;">
                </form>
            </h1>

            <a href="<?=BASE_URL?>categoria/admin&pag=<?= ($_SESSION['pag'] < $totalPag) ? $_SESSION['pag'] + 1 : $totalPag ?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/right.svg" alt="Página siguiente">
                </button>
            </a>

            <a href="<?=BASE_URL?>categoria/admin&pag=<?=$totalPag?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
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
            <th>Acciones</th>
        </tr>

        <?php foreach($categorias as $categoria): ?>

            <tr id="<?=$categoria->getId()?>">

                <td><?=$categoria->getId()?></td>
                <td><?=$categoria->getNombre()?></td>

                <td class="acciones">
                    
                    <a href="<?=BASE_URL?>categoria/gestion&id=<?=$categoria->getId()?>">
                        <img src="<?=BASE_URL?>assets/images/editar.svg" alt="Editar categoría" class="ver" style="background-color: #2980B9">
                    </a>

                    <div class="separador"></div>

                    <a href="<?=BASE_URL?>categoria/eliminar&id=<?=$categoria->getId()?>" onclick="return confirm('¿Estás seguro de que quieres eliminar la categoría <?=$categoria->getNombre()?>?\nEsta acción no se puede deshacer.')">
                        <img src="<?=BASE_URL?>assets/images/vaciar.svg" alt="Eliminar categoría" class="ver" style="background-color: rgb(218, 0, 0);">
                    </a>

                </td>

            </tr>

        <?php endforeach; ?>

    </table>

    <div class="paginacion">

        <?php if($totalPag > 1): ?>

            <a href="<?=BASE_URL?>categoria/admin&pag=1" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/doubleleft.png" alt="Primera página" style="width: 10px; padding: 5px;">
                </button>
            </a>

            <a href="<?=BASE_URL?>categoria/admin&pag=<?= ($_SESSION['pag'] > 1) ? $_SESSION['pag'] - 1 : 1 ?>" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/left.svg" alt="Página anterior">
                </button>
            </a>

            <h1><span class="mqAdminPag">Pág.</span>
                <form style="padding: 0px; background-color: unset; display: inline;" action="<?= BASE_URL ?>categoria/admin" method="GET">
                    <input type="number" name="pag" min="1" max="<?= $totalPag ?>" class="quantity-input" value="<?= $_SESSION['pag'] ?>" style="width: 60px; height: 40px; font-size: 30px; padding: 5px; margin: 0px;" required>
                    <input type="submit" value="Ir" style="display: none;">
                </form>
            </h1>

            <a href="<?=BASE_URL?>categoria/admin&pag=<?= ($_SESSION['pag'] < $totalPag) ? $_SESSION['pag'] + 1 : $totalPag ?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/right.svg" alt="Página siguiente">
                </button>
            </a>

            <a href="<?=BASE_URL?>categoria/admin&pag=<?=$totalPag?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/doubleright.png" alt="Última página" style="width: 10px; padding: 5px;">
                </button>
            </a>

        <?php endif; ?>

    </div>

<?php endif; ?>

<script src="<?=BASE_URL?>js/actualizarPaginacion.js?t=<?=time()?>"></script>