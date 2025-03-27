window.onload = function() {

    const overlay = document.createElement("div");
    overlay.style.position = "fixed";
    overlay.style.top = "0";
    overlay.style.left = "0";
    overlay.style.width = "100%";
    overlay.style.height = "100%";
    overlay.style.background = "rgba(0,0,0,0.5)";
    overlay.style.zIndex = "999";

    const popup = document.createElement("div");
    popup.style.position = "fixed";
    popup.style.top = "50%";
    popup.style.left = "50%";
    popup.style.transform = "translate(-50%, -50%)";
    popup.style.background = "#fff";
    popup.style.padding = "20px";
    popup.style.boxShadow = "0 0 10px rgba(0,0,0,0.5)";
    popup.style.textAlign = "center";
    popup.style.width = "500px";
    popup.style.borderRadius = "8px";

    popup.innerHTML = `
        <h1 style="color: red;">ATENCIÓN</h1>
        <h3 style="padding-bottom: 10px">Hay algunas consideraciones a tener en cuenta como usuario con rol administrador:</h3>
        <ul style="text-align: left;">
            <li style="padding: 5px">Si eliminas una categoría, se eliminarán todos los productos que pertenezcan a dicha categoría.</li>
            <li style="padding: 5px">Si eliminas un usuario, se eliminarán todos los pedidos que haya realizado dicho usuario.</li>
            <li style="padding: 5px; color: gray">No se ha implementado la funcionalidad de pedidos, por lo que el punto anterior no es relevante.</li>
        </ul>
        <button id="removeOverlay" style="margin-top: 10px; margin-bottom: 20px; padding: 0px 15px; background: red; color: white; border: none; border-radius: 15px; cursor: pointer;"><h3>Entendido</h2></button>
    `;

    popup.querySelector("#removeOverlay").onclick = function() {
        document.body.removeChild(overlay);
    };

    overlay.appendChild(popup);
    document.body.appendChild(overlay);

};