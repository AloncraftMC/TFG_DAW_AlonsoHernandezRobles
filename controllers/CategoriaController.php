<?php

    /**
     * Controlador de las categorías de los productos.
     * 
     * Contiene los métodos:
     * admin():     Requiere la vista de administración de categorías.
     * crear():     Requiere la vista de creación de categorías.
     * guardar():   Valida y guarda una categoría en la base de datos.
     * editar():    Valida y edita una categoría en la base de datos.
     * gestion():   Requiere la vista de edición de categorías.
     * eliminar():  Elimina una categoría de la base de datos.
     */

    namespace controllers;

    use models\Categoria;
    use models\Producto;
    use models\Usuario;
    use models\Valoracion;
    use models\LineaPedido;
    use models\Pedido;
    use helpers\Utils;

    class CategoriaController{

        /**
         * Método para requerir la vista de administración de categorías mediante paginación.
         * Si la página no es válida, se carga la más cercana al valor proporcionado.
         */

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

        /**
         * Método para requerir la vista de la creación de categorías. Requiere ser administrador.
         */

        public function crear(): void {

            Utils::isAdmin();
            require_once 'views/categoria/crear.php';

        }

        /**
         * Método para guardar una categoría en la base de datos, validando el nombre y manteniéndolo en
         * "caché" por si el usuario comete un error de escritura (que no debería, puesto que está
         * también todo validado en el cliente). Requiere ser administrador.
         */

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

                    if (!preg_match("/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{2,}$/u", $nombre)) {

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

        /**
         * Método para editar una categoría en la base de datos, validando el nombre y manteniéndolo en
         * "caché" por si el usuario comete un error de escritura (que no debería, puesto que está
         * también todo validado en el cliente). Requiere ser administrador.
         */

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

                    if ($nombre && !preg_match("/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{2,}$/u", $nombre)) {
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

        /**
         * Método para requerir la vista de edición de categorías. Requiere ser administrador.
         */

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

        /**
         * Método para eliminar una categoría de la base de datos. Requiere ser administrador.
         * También aplica lo siguiente en forma de cascada: Si eliminas la categoría
         * - Se eliminan todos los productos de esa categoría.
         *      - Por cada producto se eliminan todas sus valoraciones.
         *      - Por cada producto se eliminan las líneas de pedido en las que figuran los mismos.
         *          - Si el pedido queda sin líneas, se elimina el pedido y se notifica al usuario
         *             por correo.
         */

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
                    $numProductos = 0;

                    foreach($lineas as $linea){

                        // 0. Obtenemos el número de unidades de cada línea de pedido para el correo

                        $numProductos += $linea->getUnidades();

                        // 2. Eliminamos todas las líneas de pedido de todos los productos asociados a la categoría

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
                                'DIRECCION' => 'C. '.$pedido->getDireccion().', '.$pedido->getPoblacion().' ('.$pedido->getCodigoPostal().') - '.$pedido->getProvincia(),
                                'RAZON' => "La categoría (" . (strlen($categoria->getNombre()) > 30 ? substr($categoria->getNombre(), 0, 30) . '...' : $categoria->getNombre()) . ") del último producto (" . (strlen($producto->getNombre()) > 30 ? substr($producto->getNombre(), 0, 30) . '...' : $producto->getNombre()) . ") ha sido eliminada, por lo que el pedido ha sido eliminado.",
                                'COSTE' => $pedido->getCoste(),
                            ]);

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