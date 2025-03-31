document.addEventListener("DOMContentLoaded", function() {
            
    let carousel = document.getElementById("carousel");
    let start = document.getElementById("start");
    let prev = document.getElementById("prev");
    let next = document.getElementById("next");
    let end = document.getElementById("end");
    let activeCategory = document.querySelector(".carousel-item a[style*='background-color']");

    function updateButtons() {

        // Si estamos al inicio, desactivar los botones de inicio

        if (carousel.scrollLeft <= 0) {

            start.classList.add("disabled");
            start.style.pointerEvents = "none";
            start.style.backgroundColor = "rgb(200, 200, 200)";
            prev.classList.add("disabled");
            prev.style.pointerEvents = "none";
            prev.style.backgroundColor = "rgb(200, 200, 200)";

        } else {

            start.classList.remove("disabled");
            start.style.pointerEvents = "auto";
            start.style.backgroundColor = "var(--color-1)";
            prev.classList.remove("disabled");
            prev.style.pointerEvents = "auto";
            prev.style.backgroundColor = "var(--color-1)";

        }

        // Si estamos al final, desactivar los botones de fin

        if (carousel.scrollLeft >= carousel.scrollWidth - carousel.clientWidth - 1) {

            end.classList.add("disabled");
            end.style.pointerEvents = "none";
            end.style.backgroundColor = "rgb(200, 200, 200)";
            next.classList.add("disabled");
            next.style.pointerEvents = "none";
            next.style.backgroundColor = "rgb(200, 200, 200)";

        } else {

            end.classList.remove("disabled");
            end.style.pointerEvents = "auto";
            end.style.backgroundColor = "var(--color-1)";
            next.classList.remove("disabled");
            next.style.pointerEvents = "auto";
            next.style.backgroundColor = "var(--color-1)";

        }

    }

    updateButtons();

    if (activeCategory) {

        let offsetLeft = activeCategory.parentElement.offsetLeft;
        carousel.style.scrollBehavior = "auto";
        carousel.scrollLeft = offsetLeft - (carousel.offsetWidth / 2) + (activeCategory.parentElement.offsetWidth / 2);
    
    }

    start.addEventListener("click", function() {
        carousel.style.scrollBehavior = "smooth"; // Habilitar animación de scroll
        carousel.scrollLeft = 0;
    });

    prev.addEventListener("click", function() {
        carousel.style.scrollBehavior = "smooth"; // Habilitar animación de scroll
        carousel.scrollLeft -= 500; // Ajusta según el tamaño de los botones
    });

    next.addEventListener("click", function() {
        carousel.style.scrollBehavior = "smooth";
        carousel.scrollLeft += 500;
    });

    end.addEventListener("click", function() {
        carousel.style.scrollBehavior = "smooth";
        carousel.scrollLeft = carousel.scrollWidth - carousel.clientWidth;
    });

    carousel.addEventListener("scroll", updateButtons);

});