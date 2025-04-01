<?php use helpers\Utils; ?>

<h1>¡Listo!</h1>

<h1 style="margin: 0px; margin-bottom: 20px; font-size: 300%;">✔️</h1>

<p style="font-size: large; margin-top: 4px;">Pedido pendiente a confirmar.</p>
<p style="font-size: large; margin-top: 4px;">En breve recibirás un correo electrónico con los detalles de tu pedido.</p>

<div class="container" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px 20px; width: unset">

    <a href="<?=BASE_URL?>producto/recomendados" style="width: 100%">
        <button class="boton" style="margin: 0px; width: 100%">
            Seguir comprando
        </button>
    </a>

    <a href="<?=BASE_URL?>pedido/ver&id=<?=$_SESSION['pedido']?>" style="width: 100%">
        <button class="boton verde" style="margin: 0px;">
            Ver pedido
        </button>
    </a>

</div>

<?php Utils::deleteSession('pedido'); ?>