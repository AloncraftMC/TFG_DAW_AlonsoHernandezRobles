<?php

    /**
     * Controlador de los productos.
     * 
     * Contiene los métodos:
     * recomendados():      Requiere la vista de productos recomendados/filtrados.
     * admin():             Requiere la vista de administración de productos.
     * crear():             Requiere la vista de creación de productos.
     * guardar():           Guarda un producto en la base de datos.
     * editar():            Edita un producto en la base de datos.
     * gestion():           Requiere la vista de edición de productos.
     * eliminar():          Elimina un producto de la base de datos.
     * ver():               Requiere la vista de un producto.
     * buscar():            Busca productos y requiere la vista de búsqueda.
     */

    namespace controllers;

    use helpers\Utils;
    use models\Producto;
    use models\Categoria;
    use models\LineaPedido;
    use models\Pedido;
    use models\Usuario;
    use models\Valoracion;

    class ProductoController{

        /**
         * Método para requerir la vista de productos recomendados/filtrados mediante paginación.
         */

        public function recomendados(){

            Utils::deleteSession('redirect_after_login');
            Utils::deleteSession('gestion');

            $productosPorPagina = PRODUCTS_PER_PAGE;

            $_SESSION['pag'] = isset($_GET['pag']) ? (int)$_GET['pag'] : 1;
            
            $productos = Producto::getAll();

            $totalPag = max(1, ceil(count($productos) / $productosPorPagina));
            $productos = array_slice($productos, ($_SESSION['pag'] - 1) * $productosPorPagina, $productosPorPagina);

            if($totalPag == 0) $totalPag = 1;

            // Ahora redirigimos a la primera o última página si la página es menor que 1 o mayor que el total de páginas
            
            if($_SESSION['pag'] < 1){
                header("Location:" . BASE_URL . "producto/recomendados" . (isset($_GET['categoria']) ? "&categoria=" . $_GET['categoria'] : "") . "&pag=1");
                exit;
            }
            
            if($_SESSION['pag'] > $totalPag){
                header("Location:" . BASE_URL . "producto/recomendados" . (isset($_GET['categoria']) ? "&categoria=" . $_GET['categoria'] : "") . "&pag=" . $totalPag);
                exit;
            }

            require_once 'views/producto/recomendados.php';
            
        }

        /**
         * Método para requerir la vista de administración de productos mediante paginación.
         */

        public function admin(): void {
            
            Utils::isAdmin();
            
            $productosPorPagina = ITEMS_PER_PAGE;

            // Aqui seteamos el numero de pagina, y abajo redirigimos a 1 o la última página si la página es menor que 1 o mayor que el total de páginas

            $_SESSION['pag'] = isset($_GET['pag']) ? (int)$_GET['pag'] : 1;

            $productos = Producto::getAll();

            $totalPag = max(1, ceil(count($productos) / $productosPorPagina));
            $productos = array_slice($productos, ($_SESSION['pag'] - 1) * $productosPorPagina, $productosPorPagina);

            if($totalPag == 0) $totalPag = 1;

            // Ahora redirigimos a la primera o última página si la página es menor que 1 o mayor que el total de páginas
            
            if($_SESSION['pag'] < 1){
                header("Location:" . BASE_URL . "producto/admin&pag=1");
                exit;
            }
            
            if($_SESSION['pag'] > $totalPag){
                header("Location:" . BASE_URL . "producto/admin&pag=" . $totalPag);
                exit;
            }

            require_once 'views/producto/admin.php';

        }

        /**
         * Método para requerir la vista de creación de productos.
         * Requiere que haya categorías creadas para poder crear un producto.
         */

        public function crear(): void {

            Utils::isAdmin();

            if(count(Categoria::getAll()) == 0){
                header("Location:" . BASE_URL . "producto/admin");
                exit;
            }
            
            require_once 'views/producto/crear.php';

        }

        /**
         * Método para guardar un producto en la base de datos.
         */

        public function guardar(): void {

            Utils::isAdmin();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                // Recoger datos (los obligatorios son categoría nombre, precio, stock, oferta e imagen)

                $categoriaId = isset($_POST['categoria']) ? (int)$_POST['categoria'] : null;
                $nombre = isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : false;
                $descripcion = isset($_POST['descripcion']) ? htmlspecialchars(trim($_POST['descripcion'])) : '';
                $precio = isset($_POST['precio']) ? (float)$_POST['precio'] : 0;
                $stock = isset($_POST['stock']) ? (int)$_POST['stock'] : 0;
                $oferta = isset($_POST['oferta']) ? (int)$_POST['oferta'] : 0;
                $fecha = date('Y-m-d H:i:s');
                $imagen = isset($_FILES['imagen']) ? $_FILES['imagen'] : false;

                $_SESSION['form_data'] = [
                    'categoria' => $categoriaId,
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
                    'precio' => $precio,
                    'stock' => $stock,
                    'oferta' => $oferta,
                    'imagen' => $imagen
                ];

                if($oferta == 0) $_SESSION['form_data']['oferta'] = '';
                if($stock == 0) $stock = -1;
                
                if($categoriaId && $nombre && $precio && $stock && $imagen){

                    if($stock == -1) $stock = 0;
        
                    // Validar nombre (mínimo 2 caracteres)

                    if(strlen($nombre) < 2){

                        $_SESSION['create'] = 'failed_nombre';
                        header("Location:" . BASE_URL . "producto/crear#nombre");
                        exit;

                    }

                    // Validar precio (mayor que 0)

                    if($precio <= 0){

                        $_SESSION['create'] = 'failed_precio';
                        header("Location:" . BASE_URL . "producto/crear#precio");
                        exit;

                    }

                    // Validar stock (mayor o igual que 0)

                    if($stock < 0){

                        $_SESSION['create'] = 'failed_stock';
                        header("Location:" . BASE_URL . "producto/crear#stock");
                        exit;

                    }

                    // Validar oferta (entre 1 y 99)

                    if($oferta && ($oferta < 1 || $oferta > 99)){

                        $_SESSION['create'] = 'failed_oferta';
                        header("Location:" . BASE_URL . "producto/crear#oferta");
                        exit;

                    }

                    // Validar imagen (jpeg, png, svg) y también que no haya errores al subir la imagen

                    $permitidos = ['image/jpeg', 'image/png', 'image/svg+xml'];

                    if(!in_array($_FILES['imagen']['type'], $permitidos) || $_FILES['imagen']['error'] != UPLOAD_ERR_OK){

                        $_SESSION['create'] = 'failed_imagen';
                        header("Location:" . BASE_URL . "producto/crear#imagen");
                        exit;

                    }

                    $producto = new Producto();

                    $producto->setCategoriaId($categoriaId);
                    $producto->setNombre($nombre);
                    $producto->setDescripcion($descripcion);
                    $producto->setPrecio($precio);
                    $producto->setStock($stock);
                    $producto->setOferta($oferta);
                    $producto->setFecha($fecha);
                    
                    if ($producto->save()) {

                        Utils::deleteSession('form_data');

                        $id = $producto->getId();
                        $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);

                        $nombreImagen = $id . '.' . $ext;
    
                        $uploadDir = 'assets/images/uploads/productos/';

                        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
    
                        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $nombreImagen)) {

                            $producto->setImagen($nombreImagen);
                            $producto->update();

                        } else {

                            $_SESSION['create'] = 'failed';
                            header("Location:" . BASE_URL . "producto/crear#failed");
                            exit;

                        }

                        $_SESSION['create'] = 'complete';
                        header("Location:" . BASE_URL . "producto/admin&pag=" . max(1, ceil(count(Producto::getAll()) / ITEMS_PER_PAGE)) . "#" . $id); // Redirigimos a la última página
                        exit;
                    
                    }else{
                        
                        $_SESSION['create'] = 'failed';
                        header("Location:" . BASE_URL . "producto/crear#failed");
                        exit;

                    }

                } else {
                    
                    $_SESSION['create'] = 'failed';
                    header("Location:" . BASE_URL . "producto/crear#failed");
                    exit;

                }

            }else{

                header("Location:" . BASE_URL);
                exit;

            }

        }

        /**
         * Método para editar un producto en la base de datos.
         */

        public function editar(): void {

            Utils::isAdmin();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                // Recoger datos (los obligatorios son categoría nombre, precio, stock, oferta e imagen)

                $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
                $categoriaId = isset($_POST['categoria']) ? (int)$_POST['categoria'] : null;
                $nombre = isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : false;
                $descripcion = isset($_POST['descripcion']) ? htmlspecialchars(trim($_POST['descripcion'])) : '';
                $precio = isset($_POST['precio']) ? (float)$_POST['precio'] : 0;
                $stock = isset($_POST['stock']) ? (int)$_POST['stock'] : 0;
                $oferta = isset($_POST['oferta']) ? (int)$_POST['oferta'] : 0;
                $fecha = date('Y-m-d H:i:s');
                $imagen = isset($_FILES['imagen']) ? $_FILES['imagen'] : false;

                $_SESSION['form_data'] = [
                    'categoria' => $categoriaId,
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
                    'precio' => $precio,
                    'stock' => $stock,
                    'oferta' => $oferta,
                    'imagen' => $imagen
                ];

                $dummyProducto = Producto::getById($id);

                if($oferta == 0) $_SESSION['form_data']['oferta'] = '';
                if($stock == 0) $stock = -1;
                
                if($id && ($nombre != $dummyProducto->getNombre() || $descripcion != $dummyProducto->getDescripcion() || $precio != $dummyProducto->getPrecio() || $stock != $dummyProducto->getStock() || $oferta != $dummyProducto->getOferta() || $categoriaId != $dummyProducto->getCategoriaId() || $imagen['name'])){

                    if($stock == -1) $stock = 0;
        
                    // Validar nombre (mínimo 2 caracteres)

                    if(strlen($nombre) < 2){

                        $_SESSION['gestion'] = 'failed_nombre';
                        header("Location:" . BASE_URL . "producto/gestion&id=" . $id . "#nombre");
                        exit;

                    }

                    // Validar precio (mayor que 0)

                    if($precio <= 0){

                        $_SESSION['gestion'] = 'failed_precio';
                        header("Location:" . BASE_URL . "producto/gestion&id=" . $id . "#precio");
                        exit;

                    }

                    // Validar stock (mayor o igual que 0)

                    if($stock < 0){

                        $_SESSION['gestion'] = 'failed_stock';
                        header("Location:" . BASE_URL . "producto/gestion&id=" . $id . "#stock");
                        exit;

                    }

                    // Validar oferta (entre 1 y 99)

                    if($oferta && ($oferta < 1 || $oferta > 99)){

                        $_SESSION['gestion'] = 'failed_oferta';
                        header("Location:" . BASE_URL . "producto/gestion&id=" . $id . "#oferta");
                        exit;

                    }

                    // Validar imagen (jpeg, png, svg) y también que no haya errores al subir la imagen

                    if($imagen && $imagen['name']){
                        
                        $permitidos = ['image/jpeg', 'image/png', 'image/svg+xml'];

                        if(!in_array($_FILES['imagen']['type'], $permitidos) || $_FILES['imagen']['error'] != UPLOAD_ERR_OK){

                            $_SESSION['gestion'] = 'failed_imagen';
                            header("Location:" . BASE_URL . "producto/gestion&id=" . $id . "#imagen");
                            exit;

                        }

                    }

                    $producto = new Producto();

                    $producto->setId($id);
                    $producto->setCategoriaId($categoriaId);
                    $producto->setNombre($nombre);
                    $producto->setDescripcion($descripcion);
                    $producto->setPrecio($precio);
                    $producto->setStock($stock);
                    $producto->setOferta($oferta);
                    $producto->setFecha($fecha);
                    
                    if($imagen && $imagen['name']){

                        // Eliminar imagen anterior

                        $imagen = $dummyProducto->getImagen();
                        $uploadDir = 'assets/images/uploads/productos/';

                        if (is_file($uploadDir . $imagen)) unlink($uploadDir . $imagen);

                        // Subir nueva imagen
                        
                        $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                        $nombreImagen = $id . '.' . $ext;
        
                        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        
                        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $nombreImagen)) {
        
                            $producto->setImagen($nombreImagen);
        
                        } else {
        
                            $_SESSION['gestion'] = 'failed';
                            header("Location:" . BASE_URL . "producto/gestion&id=" . $id . "#failed");
                            exit;
        
                        }

                    }

                    if ($producto->update()) {

                        Utils::deleteSession('form_data');

                        $_SESSION['gestion'] = 'complete';
                        header("Location:" . BASE_URL . "producto/admin" . (isset($_SESSION['pag']) ? "&pag=" . $_SESSION['pag'] : "") . "#" . $id);
                        exit;

                    }else{
                        
                        $_SESSION['gestion'] = 'failed';
                        header("Location:" . BASE_URL . "producto/gestion&id=" . $id . "#failed");
                        exit;

                    }

                } else {
                    
                    $_SESSION['gestion'] = 'nothing';
                    header("Location:" . BASE_URL . "producto/gestion&id=" . $id . "#nothing");
                    exit;

                }

            }else{

                header("Location:" . BASE_URL);
                exit;

            }

        }

        /**
         * Método para requerir la vista de edición de productos.
         */

        public function gestion(): void {

            Utils::isAdmin();

            if(isset($_GET['id'])){

                $id = $_GET['id'];

                $producto = Producto::getById($id);

                if(!$producto){

                    header("Location:" . BASE_URL . "producto/admin" . (isset($_SESSION['pag']) ? "&pag=" . $_SESSION['pag'] : ""));
                    exit;

                }

                require_once 'views/producto/editar.php';

            }else{

                header("Location:" . BASE_URL . "producto/admin" . (isset($_SESSION['pag']) ? "&pag=" . $_SESSION['pag'] : ""));
                exit;

            }

        }

        /**
         * Método para eliminar un producto de la base de datos. Requiere ser administrador.
         * También aplica lo siguiente en forma de cascada: Si eliminas el producto:
         * - Se eliminan todas las valoraciones de ese producto.
         * - Se eliminan las líneas del pedido en las que figuran los mismos.
         *      - Si el pedido queda sin líneas, se elimina el pedido y se notifica al usuario
         *       por correo.
         */

        public function eliminar(): void {

            Utils::isAdmin();

            if(isset($_GET['id'])){

                $id = $_GET['id'];

                $producto = Producto::getById($id);

                if(!$producto){

                    header("Location:" . BASE_URL . "producto/admin" . (isset($_SESSION['pag']) ? "&pag=" . $_SESSION['pag'] : ""));
                    exit;

                }

                // CASCADA

                $valoraciones = Valoracion::getByProducto($producto->getId());

                foreach($valoraciones as $valoracion){

                    // 1. Eliminamos todas las valoraciones asociadas al producto

                    $valoracion->delete();

                }

                $lineas = LineaPedido::getByProducto($producto->getId());
                $numProductos = 0;

                foreach($lineas as $linea){

                    // 0. Pillamos las unidades de la línea de pedido para enviarlas al correo

                    $numProductos += $linea->getUnidades();

                    // 2. Eliminamos todas las líneas de pedido asociadas al producto

                    $linea->delete();

                    // Bis. Eliminamos el pedido si es que ha quedado sin líneas de pedido

                    $pedido = Pedido::getById($linea->getPedidoId());

                    $lineasPedido = LineaPedido::getByPedido($pedido->getId());
                    
                    if(count($lineasPedido) == 0){

                        $usuario = Usuario::getById($pedido->getUsuarioId());

                        Utils::enviarCorreo($usuario, "Pedido eliminado", BASE_URL . "mails/pedido/eliminar.html", [
                            'ID' => $pedido->getId(),
                            'USERNAME' => $usuario->getNombre(),
                            'PRODUCTOS' => $numProductos,
                            'FECHA' => $pedido->getFecha(),
                            'HORA' => $pedido->getHora(),
                            'QUERY' => urlencode('C. '.$pedido->getDireccion().' '.$pedido->getCodigoPostal().' '.$pedido->getMunicipio().' '.$pedido->getProvincia()),
                            'DIRECCION' => $pedido->getDireccion().', '.$pedido->getPoblacion().' ('.$pedido->getCodigoPostal().') - '.$pedido->getProvincia(),
                            'RAZON' => "El último producto (" . (strlen($producto->getNombre()) > 30 ? substr($producto->getNombre(), 0, 30) . '...' : $producto->getNombre()) . ") ha sido eliminado, por lo que el pedido ha sido eliminado.",
                            'COSTE' => $pedido->getCoste(),
                        ]);

                        $pedido->delete();

                    }

                }

                // 3. Eliminamos el producto

                if($producto->delete()){
                    
                    $_SESSION['delete'] = "complete";

                    // Borramos la imagen del producto

                    $imagen = $producto->getImagen();
                    $uploadDir = 'assets/images/uploads/productos/';

                    if (is_file($uploadDir . $imagen)) unlink($uploadDir . $imagen);

                }else{
                    
                    $_SESSION['delete'] = "failed";

                }

                header("Location:" . BASE_URL . "producto/admin" . (isset($_SESSION['pag']) ? "&pag=" . $_SESSION['pag'] : ""));
                exit;

            }else{

                header("Location:" . BASE_URL);
                exit;

            }

        }

        /**
         * Método para requerir la vista de un producto con sus valoraciones mediante paginación.
         */

        public function ver(): void {

            if(!isset($_GET['id'])){

                header("Location:" . BASE_URL);
                exit;

            }

            $producto = Producto::getById($_GET['id']);

            if(!$producto){

                header("Location:" . BASE_URL);
                exit;

            }
            
            $valoracionesPorPagina = ITEMS_PER_PAGE;

            // Aqui seteamos el numero de pagina, y abajo redirigimos a 1 o la última página si la página es menor que 1 o mayor que el total de páginas

            $_SESSION['pag'] = isset($_GET['pag']) ? (int)$_GET['pag'] : 1;

            $valoraciones = Valoracion::getByProducto($producto->getId());

            $totalPag = max(1, ceil(count($valoraciones) / $valoracionesPorPagina));
            $valoraciones = array_slice($valoraciones, ($_SESSION['pag'] - 1) * $valoracionesPorPagina, $valoracionesPorPagina);

            if($totalPag == 0) $totalPag = 1;

            // Ahora redirigimos a la primera o última página si la página es menor que 1 o mayor que el total de páginas
            
            if($_SESSION['pag'] < 1){
                header("Location:" . BASE_URL . "producto/ver&pag=1");
                exit;
            }

            if($_SESSION['pag'] > $totalPag){
                header("Location:" . BASE_URL . "producto/ver&pag=" . $totalPag);
                exit;
            }

            require_once 'views/producto/ver.php';

        }

        /**
         * Método para buscar productos y requerir la vista de búsqueda mediante paginación.
         */

        public function buscar(): void {

            if(isset($_GET['search'])){

                $search = urldecode(htmlspecialchars(trim($_GET['search'])));

                $productosPorPagina = PRODUCTS_PER_PAGE;

                $_SESSION['pag'] = isset($_GET['pag']) ? (int)$_GET['pag'] : 1;
                
                $resultados = Producto::getByQuery($search);

                $totalPag = max(1, ceil(count($resultados) / $productosPorPagina));
                $productos = array_slice($resultados, ($_SESSION['pag'] - 1) * $productosPorPagina, $productosPorPagina);

                if($totalPag == 0) $totalPag = 1;

                // Ahora redirigimos a la primera o última página si la página es menor que 1 o mayor que el total de páginas
                
                if($_SESSION['pag'] < 1){
                    header("Location:" . BASE_URL . "producto/buscar&search=" . $search . "&pag=1");
                    exit;
                }
                
                if($_SESSION['pag'] > $totalPag){
                    header("Location:" . BASE_URL . "producto/buscar&search=" . $search . "&pag=" . $totalPag);
                    exit;
                }

                require_once 'views/producto/buscar.php';
                
            }else{

                header("Location:" . BASE_URL);
                exit;

            }

        }
        
    }

?>