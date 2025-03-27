document.addEventListener("DOMContentLoaded", function() {

    document.querySelectorAll('.paginacion form').forEach(function(form) {

        form.addEventListener('submit', function(event) {

            event.preventDefault();

            var pagina = form.querySelector('input[name="pag"]').value;
            var currentUrl = window.location.href;

            currentUrl = currentUrl.replace(/([&?])pag=\d+/, '');
            window.location.href = currentUrl + '&pag=' + pagina;
            
        });

    });
    
});