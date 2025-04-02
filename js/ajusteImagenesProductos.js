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

            if(img.width < 300) {
                img.style.width = "300px";
                img.style.height = "auto";
            }
            
        }

        if(aspectRatio > 2.7) {
            img.style.width = "300px";
            img.style.height = "auto";
        }

    }

});