/**
 * @file actualizarToken.js
 * @description Script para reemplazar "?" por "&" en la URL de PayPal y redirigir a la página de éxito
 */

document.addEventListener("DOMContentLoaded", function() {

    // Verificamos si los parámetros 'token' y 'PayerID' están en la URL

    const urlParams = new URLSearchParams(window.location.search);
    const token = urlParams.get('token');
    const payerId = urlParams.get('PayerID');

    // Si ambos parámetros están presentes, redirigimos con el formato deseado
    
    if (token && payerId) {

        // Construimos la nueva URL
        
        const newUrl = `${BASE_URL}/paypal/exito&token=${token}&PayerID=${payerId}`;
        window.location.href = newUrl;
    
    }else{
    
        window.location.href = `${BASE_URL}`;
    
    }

});
