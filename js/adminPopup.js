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
    popup.style.width = "600px";
    popup.style.maxWidth = "90%";
    popup.style.borderRadius = "20px";

    popup.innerHTML = `
        <h1 style="color: red;">ATENCIÓN</h1>
        <h3 style="padding-bottom: 10px; padding-left: 40px; padding-right: 40px">Hay algunas consideraciones a tener en cuenta como usuario con rol administrador:</h3>
        <ul style="text-align: left;">
            <li style="padding: 5px"><b>Si eliminas una categoría</b> se eliminarán todos los productos que pertenezcan a dicha categoría y:</li>
            <ul style="text-align: left; padding-left: 20px;">
                <li style="padding: 5px">Se eliminarán todas las valoraciones que pertenezcan a dicho producto.</li>
                <li style="padding: 5px">Se eliminarán todos los pedidos que se compongan únicamente de dicho producto.</li>
            </ul>
            <li style="padding: 5px"><b>Si eliminas un producto</b>, se eliminarán todas las valoraciones que pertenezcan a dicho producto y todos los pedidos que se compongan únicamente de dicho producto.</li>
            <li style="padding: 5px"><b>Si eliminas un pedido</b>, se eliminarán todas las valoraciones del usuario que tengan los productos de dicho pedido y, si para cada producto, éste no figura en otro pedido del mismo usuario a partir del cual el mismo haya hecho una valoración.</li>
            <li style="padding: 5px"><b>Si eliminas un usuario</b>, se eliminarán todas las valoraciones y los pedidos que haya realizado dicho usuario.</li>
        </ul>
        <button id="removeOverlay" style="margin-top: 10px; margin-bottom: 20px; padding: 0px 15px; background: red; color: white; border: none; border-radius: 15px; cursor: pointer;"><h3>Entendido</h2></button>
    `;

    popup.querySelector("#removeOverlay").onclick = function() {
        document.body.removeChild(overlay);
    };

    overlay.appendChild(popup);
    document.body.appendChild(overlay);

};