<?php

use helpers\Utils;
use models\Pedido;

if (isset($_SESSION['identity']) && $_SESSION['identity']['rol'] === 'admin' && !isset($_SESSION['admin_popup'])): ?>

    <script src="<?BASE_URL?>js/adminPopup.js"></script>

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
                <a href="<?=BASE_URL?>usuario/gestion" style="background-color: unset; border-radius: unset; box-shadow: unset;">
                    <button style="background-color: unset; padding: 0px;">
                        <img src="<?=BASE_URL?>assets/images/uploads/usuarios/<?=$_SESSION['identity']['imagen']?>?t=0" style="width: 45px; height: 45px; margin: 0px; border-radius: 50%">
                    </button>
                </a>

                <!-- Botón "Mis pedidos" (aparece sólo si tienen al menos 1 pedido en la BD) -->
                <?php if (count(Pedido::getByUsuario($_SESSION['identity']['id'])) > 0): ?>
                    <a href="<?=BASE_URL?>pedido/misPedidos">
                        <button class="boton">
                            <img src="<?=BASE_URL?>assets/images/pedido.svg">Mis Pedidos
                        </button>
                    </a>
                <?php endif; ?>
                
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
