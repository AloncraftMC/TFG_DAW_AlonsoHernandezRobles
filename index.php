<?php

    // Búffer de salida para evitar errores de cabecera
    
    ob_start();

    // Inicio la sesión

    session_start();
    
    // Importar controlador de error, modelo de usuario y utilidades

    use controllers\ErrorController;
    use helpers\Utils;
    use models\Categoria;
    use models\Producto;
    use models\Usuario;

    // Autoload y Configuración

    require_once 'autoload.php';
    require_once 'config.php';

    // Cookies de recuérdame y carrito

    Utils::loadRememberCookie();
    Utils::loadCookieCarrito();
    
    // Verificar si el usuario está en la sesión y actualizar sus datos desde la base de datos

    if (isset($_SESSION['identity']) && isset($_SESSION['identity']['id'])) {

        $usuario = Usuario::getById($_SESSION['identity']['id']);

        if ($usuario) {

            $_SESSION['identity'] = [
                'id' => $usuario->getId(),
                'nombre' => $usuario->getNombre(),
                'apellidos' => $usuario->getApellidos(),
                'email' => $usuario->getEmail(),
                'rol' => $usuario->getRol(),
                'imagen' => $usuario->getImagen(),
                'color' => $usuario->getColor(),
            ];

            if($usuario->getRol() == 'admin') $_SESSION['admin'] = true;

        }
        
    }

    // Genero el título de la página

    $titulo = "Tienda de Señales de Tráfico";

    if (isset($_GET['controller'])) {

        $controller = $_GET['controller'];
        $action = $_GET['action'] ?? 'index';
        $id = $_GET['id'] ?? null;

        $producto = $id ? Producto::getById($id) : null;
        $categoria = $id ? Categoria::getById($id) : null;
        $usuario = $id ? Usuario::getById($id) : null;

        $nombreProducto = $producto ? $producto->getNombre() : null;
        $nombreCategoria = $categoria ? $categoria->getNombre() : null;
        $nombreUsuario = $usuario ? $usuario->getNombre() : null;
        
        $titulos = [
            'carrito' => [
                'gestion' => 'Carrito' . (isset($_SESSION['carrito']) ? ' (' . Utils::statsCarrito()['totalCount'] . ' producto' . (Utils::statsCarrito()['totalCount'] > 1 ? 's' : '') . ')' : ' de compras')
            ],
            'categoria' => [
                'admin' => 'Administrar Categorías',
                'crear' => 'Crear Categoría',
                'gestion' => 'Editar ' . $nombreCategoria
            ],
            'info' => [
                'condicionesUso' => 'Condiciones de Uso',
                'politicaPrivacidad' => 'Política de Privacidad',
                'sobreNosotros' => 'Sobre Nosotros'
            ],
            'pedido' => [
                'admin' => 'Administrar Pedidos',
                'crear' => 'Realizar Pedido',
                'listo' => 'Pedido Solicitado',
                'misPedidos' => 'Mis Pedidos - ' . (isset($_SESSION['identity']) ? $_SESSION['identity']['nombre'] : 'Usuario'),
                'ver' => 'Detalles del Pedido (#' . (isset($id) ? $id : '') . ')',
            ],
            'producto' => [
                'admin' => 'Administrar Productos',
                'buscar' => 'Búsqueda: ' . (isset($_GET['search']) ? $_GET['search'] : 'Producto') . '',
                'crear' => 'Crear Producto',
                'gestion' => 'Editar ' . $nombreProducto,
                'recomendados' => 'Tienda de Señales de Tráfico',
                'ver' => $nombreProducto,
            ],
            'usuario' => [
                'admin' => 'Administrar Usuarios',
                'crear' => 'Crear Usuario',
                'editar' => 'Editar ' . $nombreUsuario,
                'gestion' => 'Perfil de Usuario - ' . (isset($_SESSION['identity']) ? $_SESSION['identity']['nombre'] : 'Usuario'),
                'login' => 'Iniciar Sesión',
                'registrarse' => 'Registrarse',
            ],
        ];

        // Asignar título si existe en la matriz, si no, generar uno genérico
        
        if (isset($titulos[$controller][$action])) {

            $titulo = $titulos[$controller][$action];
        
        } else {
        
            $titulo = ucfirst($controller) . " - " . ucfirst($action);
        
        }
    
    }

    // Requiero el header

    require_once 'views/layout/header.php';

    // 1. Si existe el controlador en la URL, se ejecuta ese
    // 2. Si no existe el controlador en la URL, ejecutamos el controlador por defecto
    // 3. Si el controlador no existe, mostramos un error

    if(isset($_GET['controller'])){

        $nombre_controlador = 'controllers\\' . ucfirst($_GET['controller']) . 'Controller';

    }elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
        
        $nombre_controlador = 'controllers\\' . CONTROLLER_DEFAULT . 'Controller';
        
    }else{  // Realmente este else no es necesario, pero quizá lo hace más claro el código

        (new ErrorController())->index();

    }

    // Compruebo si existe la clase
    
    if(class_exists($nombre_controlador)){

        $controlador = new $nombre_controlador();

        // 1. Si existe la acción en la URL, se ejecuta esa
        // 2. Si no existe la acción en la URL, ejecutamos la acción por defecto
        // 3. Si la acción no existe, mostramos un error

        if(isset($_GET['action']) && method_exists($controlador, $_GET['action'])){

            $action = $_GET['action'];
            $controlador->$action();

        }elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
        
            $action_default = ACTION_DEFAULT;
            $controlador->$action_default();
            
        }else{

            (new ErrorController())->index();

        }

    }else{

        (new ErrorController())->index();

    }

    // Requiero el footer
    
    require_once 'views/layout/footer.php';

    // Actualizo colores de interfaz en base al campo "color" de la tabla "usuarios"

    if (isset($_SESSION['identity']) && isset($_SESSION['identity']['color'])) {
        
        if($_SESSION['identity']['color'] != '#000000' && $_SESSION['identity']['color'] != '#ffffff'){

            $color = $_SESSION['identity']['color']; // Color base del usuario
            echo '
            <style>
                :root {
                    --color-1: ' . $color . ';
                }
            </style>
            <script src="' . BASE_URL . 'js/generarPaletaColores.js?t='.time().'"></script>
            ';

        }

    }

    // Finalmente limpio el búffer de salida y lo envío al navegador
    
    ob_end_flush();

?>