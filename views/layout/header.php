<?php

use helpers\Utils;

if (isset($_SESSION['identity']) && $_SESSION['identity']['rol'] === 'admin' && !isset($_SESSION['admin_popup'])): ?>

    <script>
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
    </script>

    <?php $_SESSION['admin_popup'] = true; ?>

<?php endif; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($titulo) ? $titulo : 'Tienda de Señales de Tráfico'; ?></title>
    <!-- Le añado lo del time() para que no se quede en cache -->
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/style.css?v=<?=time()?>" type="text/css">
    <link rel="icon" type="image/svg+xml" href="<?=BASE_URL?>assets/images/logo.svg">
</head>
<body>
    <header>
        <div class="header-izquierda">
            <a href="<?=BASE_URL?>"><img src="<?=BASE_URL?>assets/images/logo.svg" alt="logo"></a>
            <a href="<?=BASE_URL?>"><h1>Tienda de Señales de Tráfico</h1></a>
        </div>
        
        <div class="header-derecha">
            <?php 
                $controlador_actual = $_GET['controller'] ?? null;
                $accion_actual = $_GET['action'] ?? null;
            ?>
            
            <!-- Si no hay sesión iniciada se muestran los botones de Registrarse e Iniciar Sesión -->
            <?php if (!isset($_SESSION['identity'])): ?>
                <a href="<?=BASE_URL?>usuario/registrarse"><button class="boton">
                    <img src="<?=BASE_URL?>assets/images/registrarse.svg">Registrarse
                </button></a>
                <a href="<?=BASE_URL?>usuario/login"><button class="boton">
                    <img src="<?=BASE_URL?>assets/images/login.svg">Iniciar Sesión
                </button></a>
            <?php else: ?>
                <?php 
                    // Se extrae el rol del usuario de la sesión
                    $rol = $_SESSION['identity']['rol'] ?? null;
                ?>
                
                <!-- Si el usuario es admin, se muestran los botones adicionales -->
                <?php if($rol === 'admin'): ?>
                    <a href="<?=BASE_URL?>categoria/admin">
                        <button class="boton">
                            <img src="<?=BASE_URL?>assets/images/categoria.svg">Categorías
                        </button>
                    </a>
                    <a href="<?=BASE_URL?>producto/admin">
                        <button class="boton">
                            <img src="<?=BASE_URL?>assets/images/producto.svg">Productos
                        </button>
                    </a>
                    <a href="<?=BASE_URL?>pedido/admin" style="opacity: 0.5; pointer-events: none;" title="Esta funcionalidad no está disponible.">
                        <button class="boton" style="opacity: 0.5;">
                            <img src="<?=BASE_URL?>assets/images/pedido.svg">Pedidos
                        </button>
                    </a>
                    <!-- Botón de administración de usuarios para admin -->
                    <a href="<?=BASE_URL?>usuario/admin">
                        <button class="boton">
                            <img src="<?=BASE_URL?>assets/images/usuarios.svg">Usuarios
                        </button>
                    </a>
                    <div class="separador"></div>
                <?php endif; ?>

                <!-- Botón para gestionar datos personales (aparece para todos los usuarios) -->
                <a href="<?=BASE_URL?>usuario/gestion">
                    <button class="boton">
                        <img src="<?=BASE_URL?>assets/images/usuario.svg"> <?= $_SESSION['identity']['nombre'] ?>
                    </button>
                </a>
                
                <!-- Botón del carrito -->
                <a href="<?=BASE_URL?>carrito/gestion">
                    <button class="boton">
                        <img src="<?=BASE_URL?>assets/images/carrito.svg">Carrito (<?=isset($_SESSION['carrito']) ? Utils::statsCarrito()['totalCount'] : 0 ?>)
                    </button>
                </a>

                <!-- Botón para cerrar sesión -->
                <a href="<?=BASE_URL?>usuario/salir"><button class="boton">
                    <img src="<?=BASE_URL?>assets/images/logout.svg">Cerrar Sesión
                </button></a>
            <?php endif; ?>
        </div>
    </header>
    <main>
