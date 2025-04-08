<?php
    use models\Categoria;
    use models\Producto;

    $search = htmlspecialchars($_GET['search']);
?>

<script>
    document.getElementById("buscar").click();
    document.getElementById("searchInput").blur();
</script>

<h1>Productos Encontrados (<?= count($resultados) ?>)</h1>
<h2 style='margin-top: 0px; color: var(--color-10);'>Resultados para: "<?= $search ?>"</h2>

<?php if (empty($resultados)): ?>
    <h2 style="color: gray">No se encontraron productos que coincidan con tu búsqueda...</h2>
    <h1 style="font-size: 500%">:(</h1>
<?php else: ?>
    <!-- Paginación superior -->
    <?php if ($totalPag > 1): 
        $prev = ($_SESSION['pag'] > 1) ? $_SESSION['pag'] - 1 : 1;
        $next = ($_SESSION['pag'] < $totalPag) ? $_SESSION['pag'] + 1 : $totalPag;
    ?>
        <div class="paginacion" style="text-align: center; margin-bottom: 0px; margin-top: 0px;">
            <a href="<?=BASE_URL?>producto/buscar&search=<?= urlencode($search) ?>&pag=1" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/doubleleft.png" alt="Primera página" style="width: 10px; padding: 5px;">
                </button>
            </a>

            <a href="<?= BASE_URL ?>producto/buscar&search=<?= urlencode($search) ?>&pag=<?= $prev ?>" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
                <button class="boton <?= ($_SESSION['pag'] == 1) ? 'disabled' : '' ?>">
                    <img src="<?= BASE_URL ?>assets/images/left.svg" alt="Página anterior">
                </button>
            </a>

            <h1>Pág. 
                <form style="padding: 0px; background-color: unset; display: inline;" action="<?= BASE_URL ?>producto/buscar" method="GET">
                    <input type="hidden" name="search" value="<?= $search ?>">
                    <input type="number" name="pag" min="1" max="<?= $totalPag ?>" class="quantity-input" value="<?= $_SESSION['pag'] ?>" style="width: 60px; height: 40px; font-size: 30px; padding: 5px; margin: 0px;" required>
                </form>
            </h1>
            
            <a href="<?= BASE_URL ?>producto/buscar&search=<?= urlencode($search) ?>&pag=<?= $next ?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
                <button class="boton <?= ($_SESSION['pag'] == $totalPag) ? 'disabled' : '' ?>">
                    <img src="<?= BASE_URL ?>assets/images/right.svg" alt="Página siguiente">
                </button>
            </a>

            <a href="<?=BASE_URL?>producto/buscar&search=<?= urlencode($search) ?>&pag=<?=$totalPag?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/doubleright.png" alt="Última página" style="width: 10px; padding: 5px;">
                </button>
            </a>
        </div>
    <?php endif; ?>

    <!-- Tabla de productos -->
    <table style="width:100%;">
        <?php 
        // Dividir los productos en filas de 3
        $chunks = array_chunk($productos, 3);
        
        // Alternar colores de fila
        $bgColors = ["white", "#f2f2f2"];
        $rowIndex = 0;

        foreach ($chunks as $row):
            $bg = $bgColors[$rowIndex % 2];
        ?>
        <script src="<?=BASE_URL?>js/ajusteImagenesProductos.js"></script>

        <tr style="background-color: <?= $bg ?>;">
            <?php foreach ($row as $producto): ?>
            <td style="width: 33%; padding: 30px; vertical-align: top;">
                <div style="height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <a href="<?= BASE_URL ?>producto/ver&id=<?= $producto->getId() ?>">
                            <img style="max-height: 200px; min-height: 200px; margin-top: 20px;"
                                src="<?= BASE_URL ?>assets/images/uploads/productos/<?= $producto->getImagen() ?>" 
                                alt="<?= $producto->getNombre() ?>">
                        </a>

                        <a href="<?= BASE_URL ?>producto/ver&id=<?= $producto->getId() ?>" style="text-decoration: none; color: black;">
                            <h2 style="margin-bottom: 0px;"><?= $producto->getNombre() ?></h2>
                        </a>

                        <p style="margin: 4px; margin-bottom: 10px; color: gray;">
                            <?= Categoria::getById($producto->getCategoriaId())->getNombre() ?>
                        </p>

                        <?php if ($producto->getOferta() > 0): ?>
                        <h3 style="margin: 4px;">
                            <span style="color: red; text-decoration: line-through;"><?= $producto->getPrecio() ?> €</span>
                            <?php if ($producto->getStock() == 0): ?>
                                <span style="color: rgb(185, 185, 0); font-weight: bold; margin-left: 5px;">Agotado</span>
                            <?php endif; ?>
                        </h3>

                        <h1 style="margin: 4px;">
                            <?= round($producto->getPrecio() * (1 - $producto->getOferta() / 100), 2) ?> €
                            <span style="font-size: 70%; opacity: 0.3">(-<?= $producto->getOferta() ?>%)</span>
                        </h1>
                        
                        <?php else: ?>
                            <?php if ($producto->getStock() == 0): ?>
                                <h3 style="margin: 4px;">
                                    <span style="color: rgb(185, 185, 0); font-weight: bold;">Agotado</span>
                                </h3>
                            <?php endif; ?>

                            <h1 style="margin: 4px;">
                                <?= $producto->getPrecio() ?> €
                            </h1>
                        <?php endif; ?>
                    </div>

                    <div style="width: 100%;">
                        <a href="<?= BASE_URL ?>producto/ver&id=<?= $producto->getId() ?>" class="boton">
                            <button style="margin-top: 20px;">Ver Producto</button>
                        </a>
                    </div>
                </div>
            </td>
            <?php endforeach; ?>

            <?php 
            // Rellenar celdas vacías si la fila tiene menos de 3 elementos
            $faltantes = 3 - count($row);
            for ($i = 0; $i < $faltantes; $i++):
            ?>
                <td style="width: 33%; padding: 30px;"></td>
            <?php endfor; ?>
        </tr>
        <?php 
            $rowIndex++;
        endforeach; 
        ?>
    </table>

    <!-- Paginación inferior -->
    <?php if ($totalPag > 1): ?>
        <div class="paginacion" style="text-align: center; margin-top: 20px;">
            <a href="<?=BASE_URL?>producto/buscar&search=<?= urlencode($search) ?>&pag=1" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == 1) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/doubleleft.png" alt="Primera página" style="width: 10px; padding: 5px;">
                </button>
            </a>

            <a href="<?= BASE_URL ?>producto/buscar&search=<?= urlencode($search) ?>&pag=<?= $prev ?>" style="pointer-events: <?=($_SESSION['pag'] == 1) ? 'none' : 'auto'?>;">
                <button class="boton <?= ($_SESSION['pag'] == 1) ? 'disabled' : '' ?>">
                    <img src="<?= BASE_URL ?>assets/images/left.svg" alt="Página anterior">
                </button>
            </a>

            <h1>Pág. 
                <form style="padding: 0px; background-color: unset; display: inline;" action="<?= BASE_URL ?>producto/buscar" method="GET">
                    <input type="hidden" name="search" value="<?= $search ?>">
                    <input type="number" name="pag" min="1" max="<?= $totalPag ?>" class="quantity-input" value="<?= $_SESSION['pag'] ?>" style="width: 60px; height: 40px; font-size: 30px; padding: 5px; margin: 0px;" required>
                </form>
            </h1>
            
            <a href="<?= BASE_URL ?>producto/buscar&search=<?= urlencode($search) ?>&pag=<?= $next ?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
                <button class="boton <?= ($_SESSION['pag'] == $totalPag) ? 'disabled' : '' ?>">
                    <img src="<?= BASE_URL ?>assets/images/right.svg" alt="Página siguiente">
                </button>
            </a>

            <a href="<?=BASE_URL?>producto/buscar&search=<?= urlencode($search) ?>&pag=<?=$totalPag?>" style="pointer-events: <?=($_SESSION['pag'] == $totalPag) ? 'none' : 'auto'?>;">
                <button class="boton <?php if($_SESSION['pag'] == $totalPag) echo 'disabled' ?>">
                    <img src="<?=BASE_URL?>assets/images/doubleright.png" alt="Última página" style="width: 10px; padding: 5px;">
                </button>
            </a>
        </div>
    <?php endif; ?>
<?php endif; ?>

<script src="<?= BASE_URL ?>js/actualizarPaginacion.js"></script>