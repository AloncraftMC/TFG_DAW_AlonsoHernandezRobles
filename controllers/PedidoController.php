<?php

    namespace controllers;

    use Exception;
    use helpers\Utils;
    use models\Pedido;
    use models\LineaPedido;
    use models\Producto;
    use PayPalCheckoutSdk\Core\PayPalHttpClient;
    use PayPalCheckoutSdk\Core\SandboxEnvironment;
    use PayPalCheckoutSdk\Core\ProductionEnvironment;
    use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
    use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

    require_once __DIR__ . '/../vendor/autoload.php'; // Para asegurarte de que las dependencias de Composer se carguen correctamente
    
    class PedidoController{

        public function admin(){ // ✔

            Utils::isAdmin();
            
            $pedidosPorPagina = ITEMS_PER_PAGE;

            // Aqui seteamos el numero de pagina, y abajo redirigimos a 1 o la última página si la página es menor que 1 o mayor que el total de páginas

            $_SESSION['pag'] = isset($_GET['pag']) ? (int)$_GET['pag'] : 1;

            $pedidos = Pedido::getAll();

            $totalPag = max(1, ceil(count($pedidos) / $pedidosPorPagina));
            $pedidos = array_slice($pedidos, ($_SESSION['pag'] - 1) * $pedidosPorPagina, $pedidosPorPagina);

            if($totalPag == 0) $totalPag = 1;

            // Ahora redirigimos a la primera o última página si la página es menor que 1 o mayor que el total de páginas
            
            if($_SESSION['pag'] < 1){
                header("Location:" . BASE_URL . "pedido/admin&pag=1");
                exit;
            }
            
            if($_SESSION['pag'] > $totalPag){
                header("Location:" . BASE_URL . "pedido/admin&pag=" . $totalPag);
                exit;
            }

            require_once 'views/pedido/admin.php';

        }

        public function crear(){ // ✔
            
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
                $comunidad = isset($_POST['comunidad']) ? htmlspecialchars(trim($_POST['comunidad'])) : '';
                $provincia = isset($_POST['provincia']) ? htmlspecialchars(trim($_POST['provincia'])) : '';
                $municipio = isset($_POST['municipio']) ? htmlspecialchars(trim($_POST['municipio'])) : '';
                $poblacion = isset($_POST['poblacion']) ? htmlspecialchars(trim($_POST['poblacion'])) : '';
                $nucleo = isset($_POST['nucleo']) ? htmlspecialchars(trim($_POST['nucleo'])) : '';
                $codigoPostal = isset($_POST['codigoPostal']) ? htmlspecialchars(trim($_POST['codigoPostal'])) : '';
                $calle = isset($_POST['calle']) ? htmlspecialchars(trim($_POST['calle'])) : '';
                $direccion = isset($_POST['direccion']) ? htmlspecialchars(trim($_POST['direccion'])) : '';
                $coste = Utils::statsCarrito()['total'];
                $estado = "Pendiente";
                $fecha = date('Y-m-d');
                $hora = date('H:i:s');

                $_SESSION['form_data'] = [
                    'comunidad' => $comunidad,
                    'provincia' => $provincia,
                    'municipio' => $municipio,
                    'poblacion' => $poblacion,
                    'nucleo' => $nucleo,
                    'codigoPostal' => $codigoPostal,
                    'calle' => $calle,
                    'direccion' => $direccion
                ];
                
                if($comunidad && $provincia && $municipio && $poblacion && $nucleo && $codigoPostal && $calle && $direccion){
        
                    // Validar comunidad (no está vacía)
                    if(strlen($comunidad) == 0){
                        $_SESSION['create'] = 'failed';
                        header("Location:" . BASE_URL . "pedido/crear#failed");
                        exit;
                    }
                    
                    // Validar provincia (no está vacía)
                    if(strlen($provincia) == 0){
                        $_SESSION['create'] = 'failed';
                        header("Location:" . BASE_URL . "pedido/crear#failed");
                        exit;
                    }

                    // Validar municipio (no está vacía)
                    if(strlen($municipio) == 0){
                        $_SESSION['create'] = 'failed';
                        header("Location:" . BASE_URL . "pedido/crear#failed");
                        exit;
                    }

                    // Validar población (no está vacía)
                    if(strlen($poblacion) == 0){
                        $_SESSION['create'] = 'failed';
                        header("Location:" . BASE_URL . "pedido/crear#failed");
                        exit;
                    }

                    // Validar núcleo (no está vacía)
                    if(strlen($nucleo) == 0){
                        $_SESSION['create'] = 'failed';
                        header("Location:" . BASE_URL . "pedido/crear#failed");
                        exit;
                    }

                    // Validar código postal (no está vacío)
                    if(strlen($codigoPostal) == 0){
                        $_SESSION['create'] = 'failed';
                        header("Location:" . BASE_URL . "pedido/crear#failed");
                        exit;
                    }

                    // Validar calle (no está vacía)
                    if(strlen($calle) == 0){
                        $_SESSION['create'] = 'failed';
                        header("Location:" . BASE_URL . "pedido/crear#failed");
                        exit;
                    }

                    // Validar dirección (no está vacía)
                    if(strlen($direccion) == 0){
                        $_SESSION['create'] = 'failed';
                        header("Location:" . BASE_URL . "pedido/crear#failed");
                        exit;
                    }

                    // Unificamos la dirección completa en una sola variable

                    $direccion = $calle . ' ' . $direccion;

                    $pedido = new Pedido();

                    $pedido->setUsuarioId($usuarioId);
                    $pedido->setComunidad($comunidad);
                    $pedido->setProvincia($provincia);
                    $pedido->setMunicipio($municipio);
                    $pedido->setPoblacion($poblacion);
                    $pedido->setNucleo($nucleo);
                    $pedido->setCodigoPostal($codigoPostal);
                    $pedido->setDireccion($direccion);
                    $pedido->setCoste($coste);
                    $pedido->setEstado($estado);
                    $pedido->setFecha($fecha);
                    $pedido->setHora($hora);
                    
                    if ($pedido->save()) {

                        // AQUI PayPal

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

                        Utils::deleteSession('carrito');
                        Utils::deleteCookieCarrito();
                        
                        header("Location:" . BASE_URL . "pedido/listo");
                        exit;
                    
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
            exit;

        }

        public function listo(){ // ✔

            Utils::isIdentity();

            if(!isset($_SESSION['create']) || $_SESSION['create'] != 'complete'){
                header('Location: '.BASE_URL);
                exit;
            }
            
            Utils::deleteSession('create');

            require_once 'views/pedido/listo.php';
        
        }

        public function ver(){

            Utils::isIdentity();

            if(!isset($_GET['id'])){
                header('Location: '.BASE_URL);
                exit;
            }

            $pedido = new Pedido();
            $pedido = Pedido::getById($_GET['id']);

            // Comprobamos que el pedido existe y que pertenece al usuario logueado
            // Si no, redirigimos a la página principal
            // Pero si el usuario actual es admin, se le permite ver cualquier pedido

            if($pedido == null || ($pedido->getUsuarioId() != $_SESSION['identity']['id'] && $_SESSION['identity']['rol'] != 'admin')){
                header('Location: '.BASE_URL);
                exit;
            }

            require_once 'views/pedido/ver.php';

        }

        public function misPedidos(){

            Utils::isIdentity();

            if(count(Pedido::getByUsuario($_SESSION['identity']['id'])) == 0){
                header('Location: '.BASE_URL);
                exit;
            }
            
            $pedidosPorPagina = ITEMS_PER_PAGE;

            // Aqui seteamos el numero de pagina, y abajo redirigimos a 1 o la última página si la página es menor que 1 o mayor que el total de páginas

            $_SESSION['pag'] = isset($_GET['pag']) ? (int)$_GET['pag'] : 1;

            $pedidos = Pedido::getByUsuario($_SESSION['identity']['id']);

            $totalPag = max(1, ceil(count($pedidos) / $pedidosPorPagina));
            $pedidos = array_slice($pedidos, ($_SESSION['pag'] - 1) * $pedidosPorPagina, $pedidosPorPagina);

            if($totalPag == 0) $totalPag = 1;

            // Ahora redirigimos a la primera o última página si la página es menor que 1 o mayor que el total de páginas
            
            if($_SESSION['pag'] < 1){
                header("Location:" . BASE_URL . "pedido/misPedidos&pag=1");
                exit;
            }
            
            if($_SESSION['pag'] > $totalPag){
                header("Location:" . BASE_URL . "pedido/misPedidos&pag=" . $totalPag);
                exit;
            }
            
            require_once 'views/pedido/mis-pedidos.php';
        
        }

        public function confirmar(){

            Utils::isAdmin();

            if(!isset($_GET['id'])){
                header('Location: '.BASE_URL);
                exit;
            }

            $pedido = new Pedido();
            $pedido = Pedido::getById($_GET['id']);

            $pedido->setEstado('Confirmado');
            $pedido->update();

            header('Location: '.BASE_URL.'pedido/admin&pag='.$_SESSION['pag'] . "#".$pedido->getId());
            exit;

        }

        public function eliminar(){
            
            Utils::isAdmin();

            if(isset($_GET['id'])){

                $id = $_GET['id'];

                $pedido = Pedido::getById($id);

                if(!$pedido){

                    header("Location:" . BASE_URL . "pedido/admin" . (isset($_SESSION['pag']) ? "&pag=" . $_SESSION['pag'] : ""));
                    exit;

                }

                // Eliminamos las líneas de pedido asociadas al pedido

                $lineas = LineaPedido::getByPedido($pedido->getId());

                foreach($lineas as $linea){
                    $linea->delete();
                }

                if($pedido->delete()){
                    
                    $_SESSION['delete'] = "complete";
                    // Aqui enviar correo al usuario que ha hecho el pedido para informarle de la cancelación del mismo
                }else{
                    
                    $_SESSION['delete'] = "failed";

                }

                header("Location:" . BASE_URL . "pedido/admin" . (isset($_SESSION['pag']) ? "&pag=" . $_SESSION['pag'] : ""));
                exit;

            }else{

                header("Location:" . BASE_URL);
                exit;

            }

        }
        
    }

?>