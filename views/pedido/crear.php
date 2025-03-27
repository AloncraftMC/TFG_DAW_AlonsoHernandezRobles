<?php
    use helpers\Utils;
?>

<h1>Pedido</h1>

<form action="<?=BASE_URL?>pedido/hacer" method="POST">

    <div class="form-group">

        <label for="provincia">Provincia</label>
        <input type="text" name="provincia" required value="<?=isset($_SESSION['form_data']['provincia']) ? $_SESSION['form_data']['provincia'] : ''?>">

        <?php if(isset($_SESSION['create']) && $_SESSION['create'] == 'failed_provincia'): ?>
ç
            <small class="error">La provincia debe tener al menos 2 caracteres.</small>
            <?php Utils::deleteSession('create'); ?>

        <?php endif; ?>

    </div>
    
    <div class="form-group">

        <label for="localidad">Localidad</label>
        <input type="text" name="localidad" required value="<?=isset($_SESSION['form_data']['localidad']) ? $_SESSION['form_data']['localidad'] : ''?>">

        <?php if(isset($_SESSION['create']) && $_SESSION['create'] == 'failed_localidad'): ?>

            <small class="error">La localidad debe tener al menos 2 caracteres.</small>
            <?php Utils::deleteSession('create'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">

        <label for="direccion">Dirección</label>
        <input type="text" name="direccion" required value="<?=isset($_SESSION['form_data']['direccion']) ? $_SESSION['form_data']['direccion'] : ''?>">

        <?php if(isset($_SESSION['create']) && $_SESSION['create'] == 'failed_direccion'): ?>

            <small class="error">La dirección debe tener al menos 2 caracteres.</small>
            <?php Utils::deleteSession('create'); ?>

        <?php endif; ?>

    </div>
    
    <button type="submit">Confirmar Pedido</button>

</form>

<?php if(isset($_SESSION['create']) && $_SESSION['create'] == 'failed'): ?>

    <strong class="red">Creación fallida, introduce bien los datos.</strong>

<?php endif; ?>

<?php Utils::deleteSession('create'); ?>