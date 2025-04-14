<?php
    /**
     * Vista de carga de Paypal.
     */
?>

<h1>Cargando...</h1>

<script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/lineSpinner.js"></script>

<l-line-spinner
  size="100"
  stroke="10"
  speed="1"
  color="black" 
></l-line-spinner>

<script src="<?=BASE_URL?>js/actualizarToken.js?t=<?=time()?>"></script>