<?php
    /**
     * Vista para crear un pedido.
     * Hace uso de la API de Geolocalización para obtener los datos de la dirección.
     */
?>

<?php
    use helpers\Utils;
?>

<h1 class="mqAdminTitulo">Pedido (<?= Utils::statsCarrito()['totalCount'] ?> producto<?= (Utils::statsCarrito()['totalCount'] > 1) ? 's' : '' ?>)</h1>

<form action="<?=BASE_URL?>pedido/hacer" method="POST">

    <div class="form-group">
        <label for="comunidad">Comunidad Autónoma</label>
        <select name="comunidad" id="comunidad" required>
            <option value="">Selecciona una comunidad</option>
            <?php if(isset($_SESSION['form_data']['comunidad'])): ?>
                <option value="<?= $_SESSION['form_data']['comunidad'] ?>" selected><?= $_SESSION['form_data']['comunidad'] ?></option>
            <?php endif; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="provincia">Provincia</label>
        <select name="provincia" id="provincia" required <?= (isset($_SESSION['form_data']['provincia'])) ? '' : 'disabled' ?>>
            <option value="">Selecciona una provincia</option>
            <?php if(isset($_SESSION['form_data']['provincia'])): ?>
                <option value="<?= $_SESSION['form_data']['provincia'] ?>" selected><?= $_SESSION['form_data']['provincia'] ?></option>
            <?php endif; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="municipio">Municipio</label>
        <select name="municipio" id="municipio" required <?= (isset($_SESSION['form_data']['municipio'])) ? '' : 'disabled' ?>>
            <option value="">Selecciona un municipio</option>
            <?php if(isset($_SESSION['form_data']['municipio'])): ?>
                <option value="<?= $_SESSION['form_data']['municipio'] ?>" selected><?= $_SESSION['form_data']['municipio'] ?></option>
            <?php endif; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="poblacion">Población</label>
        <select name="poblacion" id="poblacion" required <?= (isset($_SESSION['form_data']['poblacion'])) ? '' : 'disabled' ?>>
            <option value="">Selecciona una población</option>
            <?php if(isset($_SESSION['form_data']['poblacion'])): ?>
                <option value="<?= $_SESSION['form_data']['poblacion'] ?>" selected><?= $_SESSION['form_data']['poblacion'] ?></option>
            <?php endif; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="nucleo">Núcleo</label>
        <select name="nucleo" id="nucleo" required <?= (isset($_SESSION['form_data']['nucleo'])) ? '' : 'disabled' ?>>
            <option value="">Selecciona un núcleo</option>
            <?php if(isset($_SESSION['form_data']['nucleo'])): ?>
                <option value="<?= $_SESSION['form_data']['nucleo'] ?>" selected><?= $_SESSION['form_data']['nucleo'] ?></option>
            <?php endif; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="codigoPostal">Código Postal</label>
        <select name="codigoPostal" id="codigoPostal" required <?= (isset($_SESSION['form_data']['codigoPostal'])) ? '' : 'disabled' ?>>
            <option value="">Selecciona un código postal</option>
            <?php if(isset($_SESSION['form_data']['codigoPostal'])): ?>
                <option value="<?= $_SESSION['form_data']['codigoPostal'] ?>" selected><?= $_SESSION['form_data']['codigoPostal'] ?></option>
            <?php endif; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="calle">Dirección 1</label>
        <select name="calle" id="calle" required <?= (isset($_SESSION['form_data']['calle'])) ? '' : 'disabled' ?>>
            <option value="">Selecciona una calle</option>
            <?php if(isset($_SESSION['form_data']['calle'])): ?>
                <option value="<?= $_SESSION['form_data']['calle'] ?>" selected><?= $_SESSION['form_data']['calle'] ?></option>
            <?php endif; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="direccion">Dirección 2</label>
        <input type="text" name="direccion" id="direccion" placeholder="Número, Piso, Puerta..." required value="<?= (isset($_SESSION['form_data']['direccion'])) ? $_SESSION['form_data']['direccion'] : '' ?>" <?= (isset($_SESSION['form_data']['direccion'])) ? '' : 'disabled' ?>>
    </div>

    <button type="submit">Ir a la pasarela de pago</button>

</form>

<?php if(isset($_SESSION['create']) && $_SESSION['create'] == 'failed'): ?>

    <strong class="red mqAdminTitulo" id="failed">Habido un error en la creación del pedido.</strong>

<?php elseif(isset($_SESSION['create']) && $_SESSION['create'] == 'canceled'): ?>

    <strong class="red mqAdminTitulo" id="canceled">El pago ha sido cancelado.</strong>

<?php endif; ?>

<?php Utils::deleteSession('form_data'); ?>
<?php Utils::deleteSession('create'); ?>

<script src="<?=BASE_URL?>js/extraerDatosGeoAPI.js?t=<?=time()?>"></script>