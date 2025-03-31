<?php

    namespace controllers;

    use helpers\Utils;
    use models\Pedido;

    class PedidoController{

        public function admin(){ // ✔

            Utils::isAdmin();
            require_once 'views/pedido/admin.php';

        }

        public function crear(){
            
            Utils::isIdentity();

            if(!isset($_SESSION['carrito']) || Utils::statsCarrito()['count'] == 0){
                header('Location: '.BASE_URL);
                exit;
            }

            require_once 'views/pedido/crear.php';
        }

        public function hacer(){

            Utils::isIdentity();

            if(!isset($_SESSION['carrito']) || Utils::statsCarrito()['count'] == 0){
                header('Location: '.BASE_URL);
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $usuarioId = $_SESSION['identity']['id'];
                $provincia = isset($_POST['provincia']) ? htmlspecialchars(trim($_POST['provincia'])) : '';
                $localidad = isset($_POST['localidad']) ? htmlspecialchars(trim($_POST['localidad'])) : '';
                $direccion = isset($_POST['direccion']) ? htmlspecialchars(trim($_POST['direccion'])) : '';
                $coste = Utils::statsCarrito()['total'];
                $estado = "pendiente";
                $fecha = date('Y-m-d');
                $hora = date('H:i:s');

                $_SESSION['form_data'] = [
                    'provincia' => $provincia,
                    'localidad' => $localidad,
                    'direccion' => $direccion
                ];
                
                if($provincia && $localidad && $direccion){
        
                    // Validar localidad

                    if(strlen($localidad) < 2){

                        $_SESSION['create'] = 'failed_localidad';
                        header("Location:" . BASE_URL . "pedido/crear#localidad");
                        exit;

                    }

                    // Validar dirección

                    if(strlen($direccion) < 2){

                        $_SESSION['create'] = 'failed_direccion';
                        header("Location:" . BASE_URL . "pedido/crear#direccion");
                        exit;

                    }

                    $pedido = new Pedido();

                    $pedido->setUsuarioId($usuarioId);
                    $pedido->setProvincia($provincia);
                    $pedido->setLocalidad($localidad);
                    $pedido->setDireccion($direccion);
                    $pedido->setCoste($coste);
                    $pedido->setEstado($estado);
                    $pedido->setFecha($fecha);
                    $pedido->setHora($hora);
                    
                    if ($pedido->save()) {

                        Utils::deleteSession('form_data');

                        $id = $pedido->getId();

                        $_SESSION['create'] = 'complete';

                        Utils::deleteSession('carrito');
                        Utils::deleteCookieCarrito();
                        
                        header("Location:" . BASE_URL . "pedido/listo");
                        exit();
                    
                    }else{
                        
                        $_SESSION['create'] = 'failed';
                        header("Location:" . BASE_URL . "pedido/crear#failed");
                        exit;

                    }

                } else {
                    
                    $_SESSION['create'] = 'failed';
                    header("Location:" . BASE_URL . "pedido/crear#failed");
                    exit;

                }

            }else{

                header("Location:" . BASE_URL);
                exit;

            }

            header('Location: '.BASE_URL.'pedido/listo');

        }

        public function listo(){ // ✔

            Utils::isIdentity();

            if(!isset($_SESSION['carrito']) || Utils::statsCarrito()['count'] == 0){
                header('Location: '.BASE_URL);
                exit;
            }
            
            require_once 'views/pedido/listo.php';
        
        }

        public function ver(){ // ✔
            Utils::isAdmin();
            require_once 'views/pedido/ver.php';
        }

        public function misPedidos(){

            Utils::isIdentity();

            if(count(Pedido::getByUsuario($_SESSION['identity']['id'])) == 0){
                header('Location: '.BASE_URL);
                exit;
            }
            
            require_once 'views/pedido/mis-pedidos.php';
        
        }

        public function confirmar(){
            Utils::isAdmin(); /* ME NIEGO A IMPLEMENTAR ESTA FUNCIONALIDAD */
        }

        public function eliminar(){
            Utils::isAdmin(); /* ME NIEGO A IMPLEMENTAR ESTA FUNCIONALIDAD */
        }
        
    }

?>