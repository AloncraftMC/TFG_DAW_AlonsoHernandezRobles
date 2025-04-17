<?php

    /**
     * Controlador de PayPal y las acciones correspondientes a las compras.
     * 
     * Contiene los métodos:
     * exito():     Recibe el éxito en la compra y guarda el pedido en la base de datos.
     * cancelar():  Recibe una cancelación en la compra y redirige a la página de creación de pedidos.
     */

    namespace controllers;

    use Exception;
    use helpers\Utils;
    use models\Usuario;
    use models\Producto;
    use models\Pedido;
    use models\LineaPedido;

    class PayPalController{
        
        /**
         * Método para recibir el éxito de la compra y redirigir a la página de listo.
         * Al principio, el token si envía por "?token", por eso redirigimos primero a la página de carga,
         * la cual tiene un script de JS que reemplaza el "?" por "&" y ya funciona correctamente.
         * Guarda el pedido en la base de datos y envía un correo al usuario con los detalles del pedido.
         */
        
        public function exito() {
            
            Utils::isIdentity();

            if(!isset($_SESSION['form_data'])) {
                header("Location:" . BASE_URL);
                exit;
            }
            
            if (!isset($_GET['token'])) {
                require_once 'views/paypal/cargando.php';
                exit;
            }
        
            $token = $_GET['token'];
            $client = new \GuzzleHttp\Client();
            $auth = base64_encode(PAYPAL_CLIENT_ID . ':' . PAYPAL_SECRET);
        
            try {
                // Capturamos el pago
                $response = $client->post('https://api-m.paypal.com/v2/checkout/orders/' . $token . '/capture', [
                    'headers' => [
                        'Authorization' => 'Basic ' . $auth,
                        'Content-Type'  => 'application/json',
                    ]
                ]);
        
                $data = json_decode($response->getBody(), true);
        
                // Comprobamos si el estado del pago es COMPLETED
                if (isset($data['status']) && $data['status'] == 'COMPLETED') {
        
                    // Sacamos los datos del pedido desde $_SESSION['form_data']
                    $usuarioId = $_SESSION['form_data']['usuarioId'];
                    $comunidad = $_SESSION['form_data']['comunidad'];
                    $provincia = $_SESSION['form_data']['provincia'];
                    $municipio = $_SESSION['form_data']['municipio'];
                    $poblacion = $_SESSION['form_data']['poblacion'];
                    $nucleo = $_SESSION['form_data']['nucleo'];
                    $codigoPostal = $_SESSION['form_data']['codigoPostal'];
                    $calle = $_SESSION['form_data']['calle'];
                    $direccion = $_SESSION['form_data']['direccion'];
                    $coste = $_SESSION['form_data']['coste'];
                    $estado = $_SESSION['form_data']['estado'];
                    $fecha = $_SESSION['form_data']['fecha'];
                    $hora = $_SESSION['form_data']['hora'];

                    $direccion = $calle . ' ' . $direccion;
        
                    // Insertamos el pedido
                    $pedido = new Pedido();

                    $pedido->setUsuarioId($usuarioId);
                    $pedido->setDireccion($direccion);
                    $pedido->setComunidad($comunidad);
                    $pedido->setProvincia($provincia);
                    $pedido->setMunicipio($municipio);
                    $pedido->setPoblacion($poblacion);
                    $pedido->setNucleo($nucleo);
                    $pedido->setCodigoPostal($codigoPostal);
                    $pedido->setCoste($coste);
                    $pedido->setEstado($estado);
                    $pedido->setFecha($fecha);
                    $pedido->setHora($hora);
        
                    if ($pedido->save()) {

                        Utils::deleteSession('form_data');

                        // Ahora creamos las líneas de pedido y las guardamos en la base de datos
                        
                        foreach($_SESSION['carrito'] as $elemento){

                            $producto = Producto::getById($elemento['id_producto']);
                            $unidades = $elemento['unidades'];

                            $linea = new LineaPedido();

                            $linea->setPedidoId($pedido->getId());
                            $linea->setProductoId($producto->getId());
                            $linea->setUnidades($unidades);
                            
                            $linea->save();
                            
                            // Actualizamos el stock del producto en la base de datos

                            $producto = Producto::getById($producto->getId());
                            
                            $producto->setStock($producto->getStock() - $unidades);
                            $producto->update();

                        }
        
                        $_SESSION['create'] = 'complete';
                        $_SESSION['pedido'] = $pedido->getId();

                        $usuario = Usuario::getById($pedido->getUsuarioId());

                        Utils::enviarCorreo($usuario, "Pedido realizado", BASE_URL . "mails/pedido/hacer.html", [
                            'ID' => $pedido->getId(),
                            'USERNAME' => $usuario->getNombre(),
                            'PRODUCTOS' => Utils::statsCarrito()['totalCount'],
                            'FECHA' => $pedido->getFecha(),
                            'HORA' => $pedido->getHora(),
                            'QUERY' => urlencode('C. '.$pedido->getDireccion().' '.$pedido->getCodigoPostal().' '.$pedido->getMunicipio().' '.$pedido->getProvincia()),
                            'DIRECCION' => $pedido->getDireccion().', '.$pedido->getPoblacion().' ('.$pedido->getCodigoPostal().') - '.$pedido->getProvincia(),
                            'COSTE' => $pedido->getCoste(),
                        ]);

                        Utils::deleteSession('carrito');
                        Utils::deleteCookieCarrito();
                        
                        header("Location:" . BASE_URL . "pedido/listo");
                        exit;
        
                    } else {

                        $_SESSION['create'] = 'failed';
                        header("Location:" . BASE_URL . "pedido/crear#failed");
                        exit;
                    
                    }
        
                } else {

                    $_SESSION['create'] = 'failed';
                    header("Location:" . BASE_URL . "pedido/crear#failed");
                    exit;
                
                }
        
            } catch (Exception $e) {

                $_SESSION['create'] = 'failed';
                header("Location:" . BASE_URL . "pedido/crear#failed");
                exit;
            
            }
        
        }       
        
        /**
         * Método para redirigir al usuario a la página de creación de pedidos con la flag de cancelación.
         */

        public function cancelar(){

            Utils::isIdentity();

            $_SESSION['create'] = 'canceled';
            header("Location:" . BASE_URL . "pedido/crear#canceled");
            exit;

        }

    }

?>