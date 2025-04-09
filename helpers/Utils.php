<?php

    namespace helpers;

    use lib\BaseDatos;
    use models\Producto;
    use models\Usuario;

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

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

            if(isset($_SESSION['carrito']) && isset($_SESSION['identity'])){

                $carritos = [];

                if(isset($_COOKIE['carrito'])){

                    $carritos = json_decode($_COOKIE['carrito'], true);

                }

                $email = $_SESSION['identity']['email'];

                $carritos[$email] = $_SESSION['carrito'];

                setcookie('carrito', json_encode($carritos), time() + 60*60*24*3, '/');

            }

        }

        // Método para cargar la cookie del carrito

        public static function loadCookieCarrito(): void{

            if(isset($_COOKIE['carrito']) && isset($_SESSION['identity'])){
        
                $carritos = json_decode($_COOKIE['carrito'], true);
        
                $email = $_SESSION['identity']['email'];
        
                if(isset($carritos[$email])){
        
                    $_SESSION['carrito'] = $carritos[$email];
        
                }
        
            }
        
        }        

        // Método para eliminar la cookie del carrito

        public static function deleteCookieCarrito(): void {
            
            if(isset($_COOKIE['carrito']) && isset($_SESSION['identity'])){

                $carritos = json_decode($_COOKIE['carrito'], true);

                $email = $_SESSION['identity']['email'];

                if(isset($carritos[$email])) unset($carritos[$email]);

                if(!empty($carritos)){

                    setcookie('carrito', json_encode($carritos), time() + 60*60*24*3, '/');

                }else{

                    setcookie('carrito', '', time() - 3600, '/');

                }

            }

        }

        // Método para eliminar la cookie del carrito de un usuario en específico

        public static function deleteCookieCarritoByEmail($email): void {
            
            if(isset($_COOKIE['carrito'])){

                $carritos = json_decode($_COOKIE['carrito'], true);

                if(isset($carritos[$email])) unset($carritos[$email]);

                if(!empty($carritos)){

                    setcookie('carrito', json_encode($carritos), time() + 60*60*24*3, '/');

                }else{

                    setcookie('carrito', '', time() - 3600, '/');

                }

            }

        }

        // Método para cargar la cookie de recordar al usuario

        public static function loadRememberCookie(): void{

            if (isset($_COOKIE['recuerdame'])) {
                
                $email = $_COOKIE['recuerdame'];
                
                $usuario = Usuario::getByEmail($email);
                
                if ($usuario) {

                    $_SESSION['identity'] = [
                        'id' => $usuario->getId(),
                        'nombre' => $usuario->getNombre(),
                        'apellidos' => $usuario->getApellidos(),
                        'email' => $usuario->getEmail(),
                        'rol' => $usuario->getRol(),
                        'color' => $usuario->getColor(),
                        'imagen' => $usuario->getImagen()
                    ];
            
                    if ($usuario->getRol() == 'admin') $_SESSION['admin'] = true;

                }

            }

        }
        
        // Método para comprobar si el usuario puede valorar un producto

        public static function usuarioPuedeValorarProducto(int $usuarioId, int $productoId): bool{

            // Se tienen que dar dos condiciones para que el usuario pueda valorar el producto:

            $baseDatos = new BaseDatos();

            // 1. El usuario ha comprado el producto al menos una vez y el pedido está enviado

            $baseDatos->ejecutar("SELECT *
                                  FROM lineas_pedidos lp
                                  INNER JOIN pedidos p ON lp.pedido_id = p.id
                                  WHERE p.usuario_id = :usuario_id
                                  AND lp.producto_id = :producto_id
                                  AND p.estado = 'Enviado'
                                  LIMIT 1", [
                ':usuario_id' => $usuarioId,
                ':producto_id' => $productoId
            ]);

            if ($baseDatos->getNumeroRegistros() == 0) {

                $baseDatos->cerrarConexion();
                return false;

            }

            // 2. El usuario no ha valorado el producto

            $baseDatos->ejecutar("SELECT *
                                  FROM valoraciones
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

        // Método para comprobar si el usuario ha comprado más de una vez el mismo producto

        public static function existenMasComprasDeProducto(int $productoId, int $usuarioId, int $pedidoExcluirId) : bool {

            $baseDatos = new BaseDatos();
        
            $baseDatos->ejecutar("SELECT COUNT(*) as total 
                                  FROM lineas_pedidos lp
                                  JOIN pedidos p ON lp.pedido_id = p.id
                                  WHERE lp.producto_id = :producto_id
                                  AND p.usuario_id = :usuario_id
                                  AND p.id != :pedido_id", [
                ':producto_id' => $productoId,
                ':usuario_id' => $usuarioId,
                ':pedido_id' => $pedidoExcluirId
            ]);
    
            $registro = $baseDatos->getSiguienteRegistro();
            
            $hayMasCompras = ($registro['total'] > 0);
        
            $baseDatos->cerrarConexion();
        
            return $hayMasCompras;
            
        }
        
        // Método para enviar un correo

        public static function enviarCorreo(Usuario $usuario, string $asunto, string $html, array $variables = [], array $imagenes = []): void{

            $mail = new PHPMailer(true);

            try {

                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = MAIL_USERNAME;
                $mail->Password   = MAIL_PASSWORD;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;
                $mail->CharSet    = 'UTF-8';

                $mail->setFrom(MAIL_USERNAME, mb_encode_mimeheader('Tienda de Señales de Tráfico', 'UTF-8'));
                $mail->addAddress($usuario->getEmail(), $usuario->getNombre());  // Destinatario

                $mail->Subject = $asunto;
                $mail->isHTML(true);

                $body = file_get_contents($html);

                $body = str_replace('{{BASE_URL}}', BASE_URL, $body);
                $body = str_replace('{{ANIO}}', date('Y'), $body);

                foreach($variables as $variable => $valor){
                    $body = str_replace('{{' . $variable . '}}', htmlspecialchars($valor), $body);
                }

                foreach($imagenes as $imagen){
                    $mail->addEmbeddedImage($imagen['ruta'], $imagen['cid'], $imagen['nombre']);
                }
                
                $mail->Body = $body;

                $mail->send();

            } catch (Exception $e) {

                echo "Error al enviar el correo: {$mail->ErrorInfo}";
                
                $ruta = __DIR__ . '/../logs/error.log';
            
                if(!file_exists(dirname($ruta))) mkdir(dirname($ruta), 0777, true);
            
                $contenido = date('Y-m-d H:i:s') . ' - Error al enviar el correo: ' . $mail->ErrorInfo . ' | Exception: ' . $e->getMessage() . "\n";
            
                file_put_contents($ruta, $contenido, FILE_APPEND | LOCK_EX);

            }            

        }

    }

?>