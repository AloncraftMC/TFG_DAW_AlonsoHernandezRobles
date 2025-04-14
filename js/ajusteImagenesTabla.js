/**
 * @file ajusteImagenesTabla.js
 * @description Ajusta las imágenes de productos en tablas. Aparece sobre todo en pedidos
 * y administración de productos.
 */

document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll("img").forEach(img => {
        
        if (img.complete) {
            applyStyles(img);
        } else {
            img.onload = () => applyStyles(img);
        }

    });

    function applyStyles(img) {
        
        let aspectRatio = img.naturalWidth / img.naturalHeight;

        if (aspectRatio > 2) {
            
            img.style.minHeight = "unset";
            img.style.maxHeight = "unset";

            img.style.width = img.naturalWidth / 2 + "px";
            img.style.height = img.naturalHeight / 2 + "px";

            if(img.width < 200) {
                img.style.width = "200px";
                img.style.height = "auto";
            }

            if(img.width > 300) {
                img.style.width = "300px";
                img.style.height = "auto";
            }
            
        }

        if(aspectRatio > 2.4) {
            img.style.width = "200px";
            img.style.height = "auto";
        }

    }

});