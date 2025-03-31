<?php
    use helpers\Utils;
?>

<h1>Pedido</h1>

<form action="<?=BASE_URL?>pedido/hacer" method="POST">

    <div class="form-group">

        <label for="provincia">Provincia</label>
        <select name="provincia" required>

            <option value="Álava" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Álava' ? 'selected' : ''?>>Álava</option>
            <option value="Albacete" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Albacete' ? 'selected' : ''?>>Albacete</option>
            <option value="Alicante" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Alicante' ? 'selected' : ''?>>Alicante</option>
            <option value="Almería" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Almería' ? 'selected' : ''?>>Almería</option>
            <option value="Asturias" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Asturias' ? 'selected' : ''?>>Asturias</option>
            <option value="Ávila" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Ávila' ? 'selected' : ''?>>Ávila</option>
            <option value="Badajoz" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Badajoz' ? 'selected' : ''?>>Badajoz</option>
            <option value="Barcelona" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Barcelona' ? 'selected' : ''?>>Barcelona</option>
            <option value="Burgos" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Burgos' ? 'selected' : ''?>>Burgos</option>
            <option value="Cáceres" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Cáceres' ? 'selected' : ''?>>Cáceres</option>
            <option value="Cádiz" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Cádiz' ? 'selected' : ''?>>Cádiz</option>
            <option value="Cantabria" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Cantabria' ? 'selected' : ''?>>Cantabria</option>
            <option value="Castellón" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Castellón' ? 'selected' : ''?>>Castellón</option>
            <option value="Ceuta" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Ceuta' ? 'selected' : ''?>>Ceuta</option>
            <option value="Ciudad Real" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Ciudad Real' ? 'selected' : ''?>>Ciudad Real</option>
            <option value="Córdoba" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Córdoba' ? 'selected' : ''?>>Córdoba</option>
            <option value="La Coruña" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'La Coruña' ? 'selected' : ''?>>La Coruña</option>
            <option value="Cuenca" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Cuenca' ? 'selected' : ''?>>Cuenca</option>
            <option value="Gerona" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Gerona' ? 'selected' : ''?>>Gerona</option>
            <option value="Granada" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Granada' ? 'selected' : ''?>>Granada</option>
            <option value="Guadalajara" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Guadalajara' ? 'selected' : ''?>>Guadalajara</option>
            <option value="Guipúzcoa" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Guipúzcoa' ? 'selected' : ''?>>Guipúzcoa</option>
            <option value="Huelva" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Huelva' ? 'selected' : ''?>>Huelva</option>
            <option value="Huesca" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Huesca' ? 'selected' : ''?>>Huesca</option>
            <option value="Baleares" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Islas Baleares' ? 'selected' : ''?>>Islas Baleares</option>
            <option value="Jaén" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Jaén' ? 'selected' : ''?>>Jaén</option>
            <option value="Las Palmas" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Las Palmas' ? 'selected' : ''?>>Las Palmas</option>
            <option value="León" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'León' ? 'selected' : ''?>>León</option>
            <option value="Lérida" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Lérida' ? 'selected' : ''?>>Lérida</option>
            <option value="Lugo" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Lugo' ? 'selected' : ''?>>Lugo</option>
            <option value="Madrid" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Madrid' ? 'selected' : ''?>>Madrid</option>
            <option value="Málaga" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Málaga' ? 'selected' : ''?>>Málaga</option>
            <option value="Melilla" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Melilla' ? 'selected' : ''?>>Melilla</option>
            <option value="Murcia" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Murcia' ? 'selected' : ''?>>Murcia</option>
            <option value="Navarra" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Navarra' ? 'selected' : ''?>>Navarra</option>
            <option value="Orense" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Orense' ? 'selected' : ''?>>Orense</option>
            <option value="Palencia" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Palencia' ? 'selected' : ''?>>Palencia</option>
            <option value="Las Palmas" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Las Palmas' ? 'selected' : ''?>>Las Palmas</option>
            <option value="Pontevedra" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Pontevedra' ? 'selected' : ''?>>Pontevedra</option>
            <option value="La Rioja" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'La Rioja' ? 'selected' : ''?>>La Rioja</option>
            <option value="Salamanca" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Salamanca' ? 'selected' : ''?>>Salamanca</option>
            <option value="Segovia" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Segovia' ? 'selected' : ''?>>Segovia</option>
            <option value="Sevilla" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Sevilla' ? 'selected' : ''?>>Sevilla</option>
            <option value="Soria" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Soria' ? 'selected' : ''?>>Soria</option>
            <option value="Tarragona" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Tarragona' ? 'selected' : ''?>>Tarragona</option>
            <option value="Santa Cruz de Tenerife" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Santa Cruz de Tenerife' ? 'selected' : ''?>>Santa Cruz de Tenerife</option>
            <option value="Teruel" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Teruel' ? 'selected' : ''?>>Teruel</option>
            <option value="Toledo" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Toledo' ? 'selected' : ''?>>Toledo</option>
            <option value="Valencia" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Valencia' ? 'selected' : ''?>>Valencia</option>
            <option value="Valladolid" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Valladolid' ? 'selected' : ''?>>Valladolid</option>
            <option value="Vizcaya" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Vizcaya' ? 'selected' : ''?>>Vizcaya</option>
            <option value="Zamora" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Zamora' ? 'selected' : ''?>>Zamora</option>
            <option value="Zaragoza" <?=isset($_SESSION['form_data']['provincia']) && $_SESSION['form_data']['provincia'] == 'Zaragoza' ? 'selected' : ''?>>Zaragoza</option>

        </select>

    </div>
    
    <div class="form-group">

        <label for="localidad" id="localidad">Localidad</label>
        <input type="text" name="localidad" required value="<?=isset($_SESSION['form_data']['localidad']) ? $_SESSION['form_data']['localidad'] : ''?>">

        <?php if(isset($_SESSION['create']) && $_SESSION['create'] == 'failed_localidad'): ?>

            <small class="error">La localidad debe tener al menos 2 caracteres.</small>
            <?php Utils::deleteSession('create'); ?>

        <?php endif; ?>

    </div>

    <div class="form-group">

        <label for="direccion" id="direccion">Dirección</label>
        <input type="text" name="direccion" required value="<?=isset($_SESSION['form_data']['direccion']) ? $_SESSION['form_data']['direccion'] : ''?>">

        <?php if(isset($_SESSION['create']) && $_SESSION['create'] == 'failed_direccion'): ?>

            <small class="error">La dirección debe tener al menos 2 caracteres.</small>
            <?php Utils::deleteSession('create'); ?>

        <?php endif; ?>

    </div>
    
    <button type="submit">Ir a la pasarela de pago</button>

</form>

<?php if(isset($_SESSION['create']) && $_SESSION['create'] == 'failed'): ?>

    <strong class="red" id="failed">Creación fallida, introduce bien los datos.</strong>

<?php endif; ?>

<?php Utils::deleteSession('create'); ?>