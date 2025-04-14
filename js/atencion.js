/**
 * @file atencion.js
 * @description Hace aparecer el aviso de atención en las páginas de información cuando se hace click
 * en el botón de "Atención".
 */

const avisoBtn = document.getElementById('avisoBtn');
const aviso = document.getElementById('aviso');

avisoBtn.addEventListener('click', () => {
    aviso.style.display = 'block'; 
    avisoBtn.style.display = 'none'; 
});