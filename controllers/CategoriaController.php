<?php

    namespace controllers;

    use models\Categoria;
    use models\Producto;
    use models\Valoracion;
    use models\LineaPedido;
    use models\Pedido;
    use helpers\Utils;

    class CategoriaController{

        public function admin(): void {
            
            Utils::isAdmin();
            
            $categoriasPorPagina = ITEMS_PER_PAGE;

            // Aqui seteamos el numero de pagina, y abajo redirigimos a 1 o la última página si la página es menor que 1 o mayor que el total de páginas

            $_SESSION['pag'] = isset($_GET['pag']) ? (int)$_GET['pag'] : 1;

            $categorias = Categoria::getAll();

            $totalPag = max(1, ceil(count($categorias) / $categoriasPorPagina));
            $categorias = array_slice($categorias, ($_SESSION['pag'] - 1) * $categoriasPorPagina, $categoriasPorPagina);

            if($totalPag == 0) $totalPag = 1;

            // Ahora redirigimos a la primera o última página si la página es menor que 1 o mayor que el total de páginas
            
            if($_SESSION['pag'] < 1){
                header("Location:" . BASE_URL . "categoria/admin&pag=1");
                exit;
            }
            
            if($_SESSION['pag'] > $totalPag){
                header("Location:" . BASE_URL . "categoria/admin&pag=" . $totalPag);
                exit;
            }

            require_once 'views/categoria/admin.php';

        }

        public function crear(): void {

            Utils::isAdmin();
            require_once 'views/categoria/crear.php';

        }

        public function guardar(): void {

            Utils::isAdmin();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                // Recoger datos con trim() para evitar espacios adicionales

                $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : false;

                $_SESSION['form_data'] = [
                    'nombre' => $nombre
                ];

                if ($nombre) {
        
                    // Validar nombre (solo letras y espacios, mínimo 2 caracteres)

                    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,}$/u", $nombre)) {

                        $_SESSION['create'] = "failed_nombre";
                        header("Location:" . BASE_URL . "categoria/crear#nombre");
                        exit;

                    }
                    
                    $categoria = new Categoria();
                    $categoria->setNombre($nombre);
        
                    $_SESSION['create'] = $categoria->save() ? 'complete' : 'failed';
        
                } else {

                    $_SESSION['create'] = "failed";

                }
                
                if($_SESSION['create'] == 'complete'){

                    $categoria->setId(Categoria::getLastId());

                    Utils::deleteSession('form_data');
                    header("Location:" . BASE_URL . "categoria/admin&pag=" . max(1, ceil(count(Categoria::getAll()) / ITEMS_PER_PAGE)) . "#" . $categoria->getId()); // Redirigimos a la última página
                    exit;

                }else{
                    
                    header("Location:" . BASE_URL . "categoria/crear#failed");
                    exit;

                }

            }else{

                header("Location:" . BASE_URL);
                exit;

            }
            
        }

        public function editar(): void {

            Utils::isAdmin();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
                // Recoger datos con trim() para evitar espacios adicionales

                $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : null;

                $_SESSION['form_data'] = [
                    'nombre' => $nombre
                ];

                $id = $_GET['id'];
                $dummyCategoria = Categoria::getById($id);
                
                if($nombre != $dummyCategoria->getNombre()){

                    // Validar nombre (solo letras y espacios, mínimo 2 caracteres)

                    if ($nombre && !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,}$/u", $nombre)) {
                        $_SESSION['gestion'] = "failed_nombre";
                        header("Location:" . BASE_URL . "categoria/gestion&id=" . $id . "#nombre");
                        exit;
                    }
                    
                    $categoria = new Categoria();
                    $categoria->setId($id);
                    $categoria->setNombre($nombre);

                    if($categoria->update()){

                        $_SESSION['gestion'] = "complete";

                        Utils::deleteSession('form_data');
                        
                        header("Location:" . BASE_URL . "categoria/admin" . (isset($_SESSION['pag']) ? "&pag=" . $_SESSION['pag'] : "") . "#" . $categoria->getId()); // Redirigimos a la última página
                        exit;

                    }
                    
                    $_SESSION['gestion'] = "failed";
                    header("Location:" . BASE_URL . "categoria/gestion&id=" . $id . "#failed");
                    exit;

                }
                
                $_SESSION['gestion'] = "nothing";
                header("Location:" . BASE_URL . "categoria/gestion&id=" . $id . "#nothing");
                exit;

            }

        }

        public function gestion(): void {

            Utils::isAdmin();

            if(isset($_GET['id'])){

                $id = $_GET['id'];

                $categoria = Categoria::getById($id);

                if($categoria){

                    require_once 'views/categoria/editar.php';

                }else{

                    header("Location:" . BASE_URL . "categoria/admin" . (isset($_SESSION['pag']) ? "&pag=" . $_SESSION['pag'] : ""));
                    exit;

                }

            }else{

                header("Location:" . BASE_URL . "categoria/admin" . (isset($_SESSION['pag']) ? "&pag=" . $_SESSION['pag'] : ""));
                exit;

            }

        }

        public function eliminar(): void {
            
            Utils::isAdmin();

            if(isset($_GET['id'])){

                $id = $_GET['id'];

                $categoria = Categoria::getById($id);
                
                if(!$categoria){

                    header("Location:" . BASE_URL . "categoria/admin" . (isset($_SESSION['pag']) ? "&pag=" . $_SESSION['pag'] : ""));
                    exit;

                }

                // CASCADA

                $productos = Producto::getByCategoria($categoria->getId());

                foreach($productos as $producto){

                    $valoraciones = Valoracion::getByProducto($producto->getId());

                    foreach($valoraciones as $valoracion){

                        // 1. Eliminamos todas las valoraciones de todos los productos asociados a la categoría

                        $valoracion->delete();

                    }

                    $lineas = LineaPedido::getByProducto($producto->getId());

                    foreach($lineas as $linea){

                        // 2. Eliminamos todas las líneas de pedido de todos los productos asociados a la categoría

                        $linea->delete();

                        // Bis. Eliminamos el pedido si es que ha quedado sin líneas de pedido

                        $pedido = Pedido::getById($linea->getPedidoId());

                        $lineasPedido = LineaPedido::getByPedido($pedido->getId());

                        if(count($lineasPedido) == 0){

                            $pedido->delete();

                        }

                    }

                    // 3. Eliminamos todos los productos asociados a la categoría

                    $producto->delete();

                }

                // 4. Eliminamos la categoría

                if($categoria->delete()){
                    
                    $_SESSION['delete'] = "complete";

                }else{
                    
                    $_SESSION['delete'] = "failed";

                }

                header("Location:" . BASE_URL . "categoria/admin" . (isset($_SESSION['pag']) ? "&pag=" . $_SESSION['pag'] : ""));
                exit;

            }else{

                header("Location:" . BASE_URL);
                exit;

            }

        }
        
    }

?>