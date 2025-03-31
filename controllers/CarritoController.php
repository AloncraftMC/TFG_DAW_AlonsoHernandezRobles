<?php

    namespace controllers;

    use helpers\Utils;
    use models\Producto;

    class CarritoController {

        public function gestion() {
            Utils::isIdentity();
            require_once 'views/carrito/gestion.php';
        }

        public function add() {
            
            if (!isset($_SESSION['identity'])) {
                $_SESSION['redirect_after_login'] = $_POST['producto_id'];
                header('Location: ' . BASE_URL . 'usuario/login');
                exit;
            }
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $producto_id = isset($_POST['producto_id']) ? (int) $_POST['producto_id'] : false;
                $cantidad = isset($_POST['cantidad']) ? (int) $_POST['cantidad'] : 1;

                if ($producto_id && $cantidad > 0) {

                    $producto = Producto::getById($producto_id);

                    if ($producto) {

                        $stockDisponible = $producto->getStock();
                        $cantidadEnCarrito = 0;

                        // Verificamos si ya hay unidades de este producto en el carrito
                        if (isset($_SESSION['carrito'])) {

                            foreach ($_SESSION['carrito'] as $indice => $elemento) {

                                if ($elemento['id_producto'] == $producto_id) {

                                    $cantidadEnCarrito = $elemento['unidades'];
                                    break;

                                }

                            }

                        }

                        // Stock dinámico: comprobamos si la suma no supera el stock disponible
                        if ($cantidadEnCarrito + $cantidad <= $stockDisponible) {

                            if (!isset($_SESSION['carrito'])) $_SESSION['carrito'] = [];
                        
                            $encontrado = false;

                            foreach ($_SESSION['carrito'] as $indice => $elemento) {

                                if ($elemento['id_producto'] == $producto_id) {

                                    $_SESSION['carrito'][$indice]['unidades'] += $cantidad;
                                    $encontrado = true;
                                    break;

                                }

                            }

                            if (!$encontrado) {

                                $_SESSION['carrito'][] = [
                                    'id_producto' => $producto_id,
                                    'unidades' => $cantidad
                                ];

                            }

                            $_SESSION['cantidadAnadida'] = $cantidad;
                            $_SESSION['carritoResultado'] = 'complete';

                            // Guardamos la cookie del carrito

                            Utils::saveCookieCarrito();

                        } else {

                            $_SESSION['carritoResultado'] = 'failed_stock';
                        }


                    } else {

                        $_SESSION['carritoResultado'] = 'failed';

                    }

                    Utils::saveCookieCarrito();
                    header('Location: ' . BASE_URL . ($producto_id ? 'producto/ver&id=' . $producto_id . "#carrito" : ''));
                    exit;

                } else {

                    $_SESSION['carritoResultado'] = 'failed';
                    header('Location: ' . BASE_URL);
                    exit;

                }

            } else {

                header('Location: ' . BASE_URL);
                exit;

            }

        }

        public function delete() {

            Utils::isIdentity();

            if ($_SERVER['REQUEST_METHOD'] === 'GET') {

                // Obtener el índice del producto que se quiere eliminar del carrito

                $indice = isset($_GET['index']) ? (int) $_GET['index'] : false;
        
                if ($indice !== false && isset($_SESSION['carrito'][$indice])) {

                    // Eliminar el producto del carrito

                    unset($_SESSION['carrito'][$indice]);

                    // Si el carrito está vacío, eliminamos la sesión del carrito

                    if (count($_SESSION['carrito']) == 0) {
                        Utils::deleteSession('carrito');
                        Utils::deleteCookieCarrito();
                    }

                }
        
                Utils::saveCookieCarrito();
                header('Location: ' . BASE_URL . 'carrito/gestion');
                exit;

            } else {

                header('Location: ' . BASE_URL);
                exit;

            }

        }

        public function clear() {

            Utils::isIdentity();

            if ($_SERVER['REQUEST_METHOD'] === 'GET') {

                Utils::deleteSession('carrito');
                Utils::deleteCookieCarrito();

                header('Location: ' . BASE_URL . 'carrito/gestion');
                exit;

            } else {

                header('Location: ' . BASE_URL);
                exit;

            }

        }

        public function up() {

            Utils::isIdentity();

            if ($_SERVER['REQUEST_METHOD'] === 'GET') {

                $indice = isset($_GET['index']) ? (int) $_GET['index'] : false;

                if ($indice !== false && isset($_SESSION['carrito'][$indice])) {

                    $producto_id = $_SESSION['carrito'][$indice]['id_producto'];
                    $producto = Producto::getById($producto_id);
                    $stockDisponible = $producto->getStock();
                    $cantidadEnCarrito = $_SESSION['carrito'][$indice]['unidades'];

                    if ($cantidadEnCarrito < $stockDisponible) {

                        $_SESSION['carrito'][$indice]['unidades']++;

                    }else{

                        $_SESSION['carritoResultado'] = 'failed_stock';

                    }

                }

                Utils::saveCookieCarrito();
                header('Location: ' . BASE_URL . 'carrito/gestion' . ($indice ? '#' . $indice : ''));
                exit;

            } else {

                header('Location: ' . BASE_URL);
                exit;

            }

        }

        public function down() {

            Utils::isIdentity();

            if ($_SERVER['REQUEST_METHOD'] === 'GET') {

                $indice = isset($_GET['index']) ? (int) $_GET['index'] : false;

                if ($indice !== false && isset($_SESSION['carrito'][$indice])) {

                    $_SESSION['carrito'][$indice]['unidades']--;

                    if ($_SESSION['carrito'][$indice]['unidades'] <= 0) {

                        unset($_SESSION['carrito'][$indice]);

                        if (count($_SESSION['carrito']) == 0) {
                            Utils::deleteSession('carrito');
                            Utils::deleteCookieCarrito();
                        }

                    }

                }

                Utils::saveCookieCarrito();
                header('Location: ' . BASE_URL . 'carrito/gestion' . ($indice && $_SESSION['carrito'][$indice]['unidades'] > 0 ? '#' . $indice : ''));
                exit;

            } else {

                header('Location: ' . BASE_URL);
                exit;

            }

        }

    }

?>