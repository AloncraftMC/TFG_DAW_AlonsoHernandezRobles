<?php
    use helpers\Utils;
?>

<h1>Pedido (<?= Utils::statsCarrito()['totalCount'] ?> producto<?= (Utils::statsCarrito()['totalCount'] > 1) ? 's' : '' ?>)</h1>

<form action="<?=BASE_URL?>pedido/hacer" method="POST">

    <div class="form-group">
        <label for="comunidad">Comunidad Autónoma</label>
        <select name="comunidad" id="comunidad" required>
            <option value="">Selecciona una comunidad</option>
        </select>
    </div>

    <div class="form-group">
        <label for="provincia">Provincia</label>
        <select name="provincia" id="provincia" required disabled>
            <option value="">Selecciona una provincia</option>
        </select>
    </div>

    <div class="form-group">
        <label for="municipio">Municipio</label>
        <select name="municipio" id="municipio" required disabled>
            <option value="">Selecciona un municipio</option>
        </select>
    </div>

    <div class="form-group">
        <label for="poblacion">Población</label>
        <select name="poblacion" id="poblacion" required disabled>
            <option value="">Selecciona una población</option>
        </select>
    </div>

    <div class="form-group">
        <label for="nucleo">Núcleo</label>
        <select name="nucleo" id="nucleo" required disabled>
            <option value="">Selecciona un núcleo</option>
        </select>
    </div>

    <div class="form-group">
        <label for="codigoPostal">Código Postal</label>
        <select name="codigoPostal" id="codigoPostal" required disabled>
            <option value="">Selecciona un código postal</option>
        </select>
    </div>

    <div class="form-group">
        <label for="calle">Dirección 1</label>
        <select name="calle" id="calle" required disabled>
            <option value="">Selecciona una calle</option>
        </select>
    </div>

    <div class="form-group">
        <label for="direccion">Dirección 2</label>
        <input type="text" name="direccion" id="direccion" placeholder="Número, Piso, Puerta..." required disabled>
    </div>

    <button type="submit">Ir a la pasarela de pago</button>

</form>

<?php if(isset($_SESSION['create']) && $_SESSION['create'] == 'failed'): ?>

    <strong class="red" id="failed">Habido un error en la creación del pedido.</strong>

<?php elseif(isset($_SESSION['create']) && $_SESSION['create'] == 'canceled'): ?>

    <strong class="red" id="canceled">El pago ha sido cancelado.</strong>

<?php endif; ?>

<?php Utils::deleteSession('create'); ?>

<script>const BASE_URL = '<?=BASE_URL?>';</script>
<script src="<?=BASE_URL?>js/extraerDatosGeoAPI.js"></script>