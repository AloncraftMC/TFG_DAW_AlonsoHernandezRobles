<?php

    namespace helpers;

    use lib\BaseDatos;
    use models\Producto;

    class Utils{

        // Método para eliminar sesiones

        public static function deleteSession(string $nombre): void{

            if(isset($_SESSION[$nombre])){

                $_SESSION[$nombre] = null;
                unset($_SESSION[$nombre]);

            }

        }

        // Método para comprobar si el usuario es administrador

        public static function isAdmin(): void{

            if(!isset($_SESSION['identity']) || $_SESSION['identity']['rol'] !== 'admin'){

                header('Location:'.BASE_URL);
                exit;

            }

        }

        // Método para comprobar si el usuario está identificado

        public static function isIdentity(): void{
            
            if(!isset($_SESSION['identity'])){

                header('Location:'.BASE_URL);
                exit;

            }

        }

        // Método para mostrar estadísticas del carrito

        public static function statsCarrito(): array{

            $stats = array(
                'count' => 0,
                'totalCount' => 0,
                'total' => 0
            );

            if(isset($_SESSION['carrito'])){

                $stats['count'] = count($_SESSION['carrito']);

                foreach($_SESSION['carrito'] as $indice => $producto){

                    $stats['totalCount'] += $producto['unidades'];

                    $prod = Producto::getById($producto['id_producto']); // Obtiene la información del producto
                    $precioTotal = $prod->getPrecio() * (1 - $prod->getOferta() / 100) * $producto['unidades'];
                    $stats['total'] += $precioTotal;

                }

            }

            return $stats;

        }

        // Método para guardar la cookie del carrito. La cookie se guardará durante 3 días.

        public static function saveCookieCarrito(): void{

            if(isset($_SESSION['carrito'])){

                $carrito = json_encode($_SESSION['carrito']);
                setcookie('carrito', $carrito, time() + 60*60*24*3, '/');

            }

        }

        // Método para cargar la cookie del carrito

        public static function loadCookieCarrito(): void{

            if(isset($_COOKIE['carrito'])){

                $_SESSION['carrito'] = json_decode($_COOKIE['carrito'], true);

            }

        }

        // Método para eliminar la cookie del carrito

        public static function deleteCookieCarrito(): void {
            setcookie('carrito', '', time() - 3600, '/');
        }
        
        // Método para comprobar si el usuario puede valorar un producto

        public static function usuarioPuedeValorarProducto(int $usuarioId, int $productoId): bool{

            // Se tienen que dar dos condiciones para que el usuario pueda valorar el producto:

            $baseDatos = new BaseDatos();

            // 1. El usuario ha comprado el producto al menos una vez

            $baseDatos->ejecutar("SELECT * FROM lineas_pedidos lp
                                  INNER JOIN pedidos p ON lp.pedido_id = p.id
                                  WHERE p.usuario_id = :usuario_id
                                  AND lp.producto_id = :producto_id
                                  LIMIT 1", [
                ':usuario_id' => $usuarioId,
                ':producto_id' => $productoId
            ]);

            if ($baseDatos->getNumeroRegistros() == 0) {

                $baseDatos->cerrarConexion();
                return false;

            }

            // 2. El usuario no ha valorado el producto

            $baseDatos->ejecutar("SELECT * FROM valoraciones
                                  WHERE usuario_id = :usuario_id
                                  AND producto_id = :producto_id
                                  LIMIT 1", [
                ':usuario_id' => $usuarioId,
                ':producto_id' => $productoId
            ]);

            $output = $baseDatos->getNumeroRegistros() == 0;

            $baseDatos->cerrarConexion();

            return $output;

        }

    }

?>