const avisoBtn = document.getElementById('avisoBtn');
const aviso = document.getElementById('aviso');

avisoBtn.addEventListener('click', () => {
    aviso.style.display = 'block'; 
    avisoBtn.style.display = 'none'; 
});