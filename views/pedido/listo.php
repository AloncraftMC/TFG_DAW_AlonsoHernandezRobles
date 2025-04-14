<?php
    /**
     * Vista de pedido listo.
     */
?>

<h1 style="margin-bottom: 0px">¡Listo!</h1>

<h1 style="margin: 0px; margin-bottom: 20px; font-size: 300%;">✔️</h1>

<p style="font-size: large; margin-top: 4px;">Pedido pendiente a confirmar.</p>
<p style="font-size: large; margin-top: 0px;">En breve recibirás un correo electrónico con los detalles de tu pedido.</p>

<div class="container" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px 20px; width: unset">

    <a href="<?=BASE_URL?>pedido/ver&id=<?=$_SESSION['pedido']?>" style="width: 100%; text-decoration: none">
        <button class="boton verde" style="margin: 0px; display: flex; flex-direction: row; align-items: center; justify-content: center; height: 50px">
            <img src="<?=BASE_URL?>assets/images/pedido.svg" style="min-width: unset; min-height: unset; width: 25px; padding: 0px; margin-right: 10px; filter: invert(1)">
            <span>Ver pedido</span>
        </button>
    </a>

    <a href="<?=BASE_URL?>pedido/misPedidos" style="width: 100%; text-decoration: none">
        <button class="boton azul" style="margin: 0px; display: flex; flex-direction: row; align-items: center; justify-content: center; height: 50px">
            <img src="<?=BASE_URL?>assets/images/mispedidos.svg" style="min-width: unset; min-height: unset; width: 25px; padding: 0px; margin-right: 10px; filter: invert(1)">
            <span>Mis pedidos</span>
        </button>
    </a>

</div>

<a href="<?=BASE_URL?>producto/recomendados" style="width: 210px; margin-top: 20px; text-decoration: none">
    <button class="boton" style="margin: 0px; display: flex; flex-direction: row; align-items: center; justify-content: center; height: 50px">
        <img src="<?=BASE_URL?>assets/images/login.svg" style="min-width: unset; min-height: unset; width: 25px; padding: 0px; margin-right: 10px; filter: invert(1)">
        <span>Seguir comprando</span>
    </button>
</a>