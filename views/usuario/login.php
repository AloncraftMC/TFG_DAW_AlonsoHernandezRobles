<?php use helpers\Utils; ?>

<h1>Iniciar Sesión</h1>

<form method="post" action="<?=BASE_URL?>usuario/entrar">

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" required value="<?= isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : '' ?>">
    </div>

    <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" name="password" required value="<?= isset($_SESSION['form_data']['password']) ? $_SESSION['form_data']['password'] : '' ?>">
    </div>

    <!-- Casilla para recordar el usuario con una cookie que dura 7 días -->
    <div class="form-group checkbox-group">
        <input type="checkbox" id="remember" name="remember" <?= (isset($_SESSION['form_data']) && isset($_SESSION['form_data']['remember']) && $_SESSION['form_data']['remember']) ? 'checked' : '' ?>>
        <label for="remember" style="font-weight: normal; margin-top: 5px"><span style="font-weight: bold">Recordar usuario</span> durante 7 días</span></label>
    </div>

    <button type="submit">Iniciar Sesión</button>

</form>

<?php if(isset($_SESSION['login']) && $_SESSION['login'] == 'failed'): ?>

    <strong class="red">Login fallido, introduce bien los datos.</strong>

<?php endif; ?>

<?php Utils::deleteSession('login'); ?>
<?php Utils::deleteSession('form_data'); ?>