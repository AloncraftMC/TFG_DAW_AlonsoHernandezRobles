<?php

    /**
     * Controlador de los usuarios.
     * 
     * Contiene los métodos:
     * registrarse():       Requiere la vista de registrarse.
     * guardar():           Guarda un usuario en la base de datos.
     * login():             Requiere la vista de iniciar sesión.
     * entrar():            Inicia sesión.
     * salir():             Cierra sesión.
     * gestion():           Requiere la vista de gestión de usuarios.
     * editar():            Edita un usuario.
     * eliminar():          Elimina un usuario.
     * admin():             Requiere la vista de administración de usuarios.
     * crear():             Requiere la vista de creación de usuarios.
     */

    namespace controllers;

    use models\Usuario;
    use models\Pedido;
    use models\LineaPedido;
    use models\Valoracion;
    use helpers\Utils;

    class UsuarioController{

        /**
         * Método para mostrar la vista de registrarse
         */

        public function registrarse(): void{

            if(isset($_SESSION['identity'])){
                header("Location:" . BASE_URL);
                exit;
            }

            require_once 'views/usuario/registrarse.php';
        
        }

        /**
         * Método para guardar un usuario en la base de datos.
         * 
         * Recoge los datos del formulario y los valida. Si son correctos, guarda el usuario en la base de datos.
         * Si no son correctos, redirige a la vista de registrarse con un mensaje de error.
         */

        public function guardar(): void {

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                // Recoger datos con trim() para evitar espacios adicionales

                $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : false;
                $apellidos = isset($_POST['apellidos']) ? trim($_POST['apellidos']) : false;
                $email = isset($_POST['email']) ? trim($_POST['email']) : false;
                $password = isset($_POST['password']) ? trim($_POST['password']) : false;
                $rol = isset($_POST['rol']) ? $_POST['rol'] : 'user';
                $imagen = isset($_FILES['imagen']) ? $_FILES['imagen'] : false;
                $color = isset($_POST['color']) ? $_POST['color'] : "#000000";
                
                $_SESSION['form_data'] = [
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'email' => $email,
                    'password' => $password,
                    'rol' => $rol,
                    'imagen' => $imagen,
                    'color' => $color
                ];

                if ($nombre && $apellidos && $email && $password) {
        
                    // Validar nombre (solo letras, números y espacios, mínimo 2 caracteres)

                    if (!preg_match("/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{2,}$/u", $nombre)) {
                        $_SESSION['register'] = "failed_nombre";
                        header("Location:" . BASE_URL . "usuario/" . (isset($_SESSION['admin']) ? 'crear' : 'registrarse') . "#nombre");
                        exit;
                    }
                    
                    // Validar apellidos (solo letras, números y espacios, mínimo 2 caracteres)
        
                    if (!preg_match("/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{2,}$/u", $apellidos)) {
                        $_SESSION['register'] = "failed_apellidos";
                        header("Location:" . BASE_URL . "usuario/" . (isset($_SESSION['admin']) ? 'crear' : 'registrarse') . "#apellidos");
                        exit;
                    }
        
                    // Validar email

                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $_SESSION['register'] = "failed_email";
                        header("Location:" . BASE_URL . "usuario/" . (isset($_SESSION['admin']) ? 'crear' : 'registrarse') . "#email");
                        exit;
                    }

                    // Comprobar si el email ya existe en la base de datos
                    $usuarioExistente = Usuario::getByEmail($email);
                    if ($usuarioExistente) {
                        $_SESSION['register'] = "failed_email_exists";
                        header("Location:" . BASE_URL . "usuario/" . (isset($_SESSION['admin']) ? 'crear' : 'registrarse') . "#email");
                        exit;
                    }
        
                    // Validar contraseña (mínimo 8 caracteres, al menos una letra y un número)

                    if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $password)) {
                        $_SESSION['register'] = "failed_password";
                        header("Location:" . BASE_URL . "usuario/" . (isset($_SESSION['admin']) ? 'crear' : 'registrarse') . "#password");
                        exit;
                    }

                    // Validar imagen (jpeg, png, svg)

                    $permitidos = ['image/jpeg', 'image/png', 'image/svg+xml'];
                    if ($imagen && (!in_array($imagen['type'], $permitidos) || $imagen['error'] != UPLOAD_ERR_OK)) {
                        $_SESSION['register'] = 'failed_imagen';
                        header("Location:" . BASE_URL . "usuario/" . (isset($_SESSION['admin']) ? 'crear' : 'registrarse') . "#imagen");
                        exit;
                    }

                    // Validar color (hexadecimal)
                    if ($color && !preg_match('/^#[0-9A-Fa-f]{6}$/', $color)) {
                        $_SESSION['register'] = "failed_color";
                        header("Location:" . BASE_URL . "usuario/" . (isset($_SESSION['admin']) ? 'crear' : 'registrarse') . "#color");
                        exit;
                    }
        
                    // Crear objeto Usuario y guardar en BD

                    $usuario = new Usuario();
                    $usuario->setNombre($nombre);
                    $usuario->setApellidos($apellidos);
                    $usuario->setEmail($email);
                    $usuario->setPassword($password);
                    $usuario->setRol($rol);
                    $usuario->setColor($color);
        
                    if ($usuario->save()) {

                        Utils::deleteSession('form_data');
        
                        // Guardar la imagen si se ha subido

                        if ($imagen) {

                            $usuario = Usuario::getByEmail($email);
                            $usuario->setPassword('');

                            $id = $usuario->getId();
                            $ext = pathinfo($imagen['name'], PATHINFO_EXTENSION);
                            $nombreImagen = $id . '.' . $ext;
                            $uploadDir = 'assets/images/uploads/usuarios/';
        
                            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        
                            if (move_uploaded_file($imagen['tmp_name'], $uploadDir . $nombreImagen)) {

                                $usuario->setImagen($nombreImagen);
                                $usuario->update();

                            } else {

                                $_SESSION['register'] = 'failed_imagen';
                                header("Location:" . BASE_URL . "usuario/" . (isset($_SESSION['admin']) ? 'crear' : 'registrarse') . "#imagen");
                                exit;

                            }

                        }
        
                        $_SESSION['register'] = 'complete';
                        
                        if (isset($_SESSION['admin'])) {

                            $usuario = Usuario::getByEmail($email);

                            Utils::enviarCorreo($usuario, "Cuenta registrada", BASE_URL."mails/usuario/crear.html", [
                                "USERNAME" => $usuario->getNombre(),
                            ], [
                                [
                                    'ruta' => __DIR__ . '/../assets/images/uploads/usuarios/' . $usuario->getImagen(),
                                    'cid' => 'user',
                                    'nombre' => $usuario->getNombre() . ' ' . $usuario->getApellidos()
                                ]
                            ]);

                            Utils::deleteSession('register');
                            header("Location:" . BASE_URL . "usuario/admin&pag=" . max(1, ceil(count(Usuario::getAll()) / ITEMS_PER_PAGE)) . "#" . $usuario->getId()); // Redirigir a la última página
                            exit;
                        
                        } else {

                            $usuario = Usuario::getByEmail($email);
                            
                            Utils::enviarCorreo($usuario, "Cuenta registrada", BASE_URL."mails/usuario/registro.html", [
                                "USERNAME" => $usuario->getNombre(),
                            ], [
                                [
                                    'ruta' => __DIR__ . '/../assets/images/uploads/usuarios/' . $usuario->getImagen(),
                                    'cid' => 'user',
                                    'nombre' => $usuario->getNombre() . ' ' . $usuario->getApellidos()
                                ]
                            ]);

                            // Nuevo: iniciamos sesión

                            $_SESSION['identity'] = [
                                'id' => $usuario->getId(),
                                'nombre' => $usuario->getNombre(),
                                'apellidos' => $usuario->getApellidos(),
                                'email' => $usuario->getEmail(),
                                'rol' => $usuario->getRol(),
                                'color' => $usuario->getColor(),
                                'imagen' => $usuario->getImagen()
                            ];

                            if($usuario->getRol() == 'admin') $_SESSION['admin'] = true;

                            // Antiguo: header("Location:" . BASE_URL . "usuario/registrarse#complete");
                            header("Location:" . BASE_URL);
                            exit;
                        
                        }
        
                    } else {
                        echo "Aqui"; die;
                        $_SESSION['register'] = 'failed';
                        header("Location:" . BASE_URL . "usuario/" . (isset($_SESSION['admin']) ? 'crear' : 'registrarse') . "#failed");
                        exit;

                    }
        
                } else {
                    
                    $_SESSION['register'] = "failed";
                    header("Location:" . BASE_URL . "usuario/" . (isset($_SESSION['admin']) ? 'crear' : 'registrarse') . "#failed");
                    exit;

                }
                
            } else {
                
                header("Location:" . BASE_URL);
                exit;

            }

        }

        /**
         * Método para mostrar la vista de iniciar sesión.
         */

        public function login(): void{

            // Si ya estamos identificados, nos redirige a la página principal
            
            if(isset($_SESSION['identity'])){

                header("Location:" . BASE_URL);
                exit;

            }

            require_once 'views/usuario/login.php';

        }

        /**
         * Método para iniciar sesión. Si el usuario existe, se inicia sesión
         * y se redirige a la página principal. Si el usuario marca la opción del "recuérdame",
         * se guarda una cookie con el email durante 7 días.
         */

        public function entrar(): void{

            // Compruebo si se ha enviado el formulario
            
            if($_SERVER['REQUEST_METHOD'] === 'POST'){

                // Compruebo si se han enviado los datos necesarios

                $email = isset($_POST['email']) ? $_POST['email'] : false;
                $password = isset($_POST['password']) ? $_POST['password'] : false;
                $remember = isset($_POST['remember']);

                $_SESSION['form_data'] = [
                    'email' => $email,
                    'password' => $password,
                    'remember' => $remember
                ];

                // Si se han enviado los datos necesarios

                if($email && $password){

                    // Creo un objeto de la clase Usuario

                    $usuario = new Usuario();
                    $usuario->setEmail($email);
                    $usuario->setPassword($password);

                    // Compruebo si el usuario existe

                    $dummyUsuario = Usuario::getByEmail($email);

                    if(!$dummyUsuario){
                        
                        $_SESSION['login'] = "failed_unknown";
                        header("Location:" . BASE_URL . "usuario/login#failed_unknown");
                        exit;

                    }

                    $usuario = $usuario->login();

                    // Si el usuario existe

                    if($usuario){

                        Utils::deleteSession('form_data');

                        $_SESSION['identity'] = [
                            'id' => $usuario->getId(),
                            'nombre' => $usuario->getNombre(),
                            'apellidos' => $usuario->getApellidos(),
                            'email' => $usuario->getEmail(),
                            'rol' => $usuario->getRol(),
                            'color' => $usuario->getColor(),
                            'imagen' => $usuario->getImagen()
                        ];

                        // Remember es un checkbox. Si se ha marcado, se guarda una cookie con el email durante 7 días

                        if($remember){

                            setcookie('recuerdame', $email, (time() + 60 * 60 * 24 * 7), '/');

                        }else{

                            if(isset($_COOKIE['recuerdame'])){

                                setcookie('recuerdame', $email, time() - 1, '/');

                            }

                        }

                        if ($usuario->getRol() == 'admin') $_SESSION['admin'] = true;

                        if(isset($_SESSION['redirect_after_login'])){
                            
                            header("Location:" . BASE_URL . "carrito/add");
                            exit;
                        
                        }
                    
                        header("Location:" . BASE_URL);
                        exit;

                    }else{

                        $_SESSION['login'] = "failed_password";
                        header("Location:" . BASE_URL . "usuario/login#failed_password");
                        exit;

                    }

                }else{

                    $_SESSION['login'] = "failed";

                }

            }else{
                
                header("Location:" . BASE_URL);
                exit;

            }
            
            header("Location:" . BASE_URL . "usuario/login#failed");
            exit;

        }

        /**
         * Método para cerrar sesión 
         */

        public function salir(): void{
            
            Utils::isIdentity();

            Utils::deleteSession('identity');
            Utils::deleteSession('admin');
            Utils::deleteSession('admin_popup');
            Utils::deleteSession('carrito');
            Utils::deleteSession('gestion');

            if (isset($_COOKIE['recuerdame'])) {
                setcookie('recuerdame', '', time() - 1, '/');
            }

            header("Location:" . BASE_URL);
            exit;

        }

        /**
         * Método para gestionar el usuario.
         * Si no hay ninguna id en el GET, se requiere la vista de gestión del usuario. (gestion.php)
         * Si hay una id en el GET, se muestra la vista de edición del usuario (acción de Admins). (editar.php)
         */

        public function gestion(): void{

            Utils::isIdentity();
            
            if(isset($_GET['id'])){

                $id = $_GET['id'];

                Utils::isAdmin();

                if(Usuario::getById($id)){

                    require_once 'views/usuario/editar.php';

                }else{

                    require_once 'views/usuario/gestion.php';

                }

            }else{

                require_once 'views/usuario/gestion.php';

            }

        }

        /**
         * Método para editar el usuario.
         * Al igual que el guardar, vamos a contemplar los casos del administrador y del propio usuario.
         */

        public function editar(): void {

            Utils::isIdentity();
        
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                
                // Recoger datos con trim() para evitar espacios adicionales
                $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : null;
                $apellidos = isset($_POST['apellidos']) ? trim($_POST['apellidos']) : null;
                $email = isset($_POST['email']) ? trim($_POST['email']) : null;
                $password = isset($_POST['password']) ? trim($_POST['password']) : null;
                $rol = isset($_POST['rol']) ? $_POST['rol'] : $_SESSION['identity']['rol'];
                $imagen = isset($_FILES['imagen']) ? $_FILES['imagen'] : false;
                $color = isset($_POST['color']) ? $_POST['color'] : "#000000";
        
                $_SESSION['form_data'] = [
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'email' => $email,
                    'password' => $password,
                    'rol' => $rol,
                    'imagen' => $imagen,
                    'color' => $color
                ];
        
                // Determinar si estamos editando otro usuario o el usuario actual
                $id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['identity']['id'];
                $dummyUsuario = Usuario::getById($id);
                $passwordAlmacenada = $dummyUsuario->getPassword();

                $passwordNoModificada = (strlen($password) == 0 || password_verify($password, $passwordAlmacenada));
        
                if ($nombre != $dummyUsuario->getNombre() || 
                    $apellidos != $dummyUsuario->getApellidos() || 
                    $email != $dummyUsuario->getEmail() || 
                    !$passwordNoModificada || 
                    $rol != $dummyUsuario->getRol() ||
                    ($imagen && $imagen['name']) ||
                    $color != $dummyUsuario->getColor()
                ) {
        
                    // Validaciones
                    if ($nombre && !preg_match("/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{2,}$/u", $nombre)) {
                        $_SESSION['gestion'] = "failed_nombre";
                        header("Location:" . BASE_URL . "usuario/gestion" . (isset($_GET['id']) ? "&id=" . $_GET['id'] : "") . "#nombre");
                        exit;
                    }
        
                    if ($apellidos && !preg_match("/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{2,}$/u", $apellidos)) {
                        $_SESSION['gestion'] = "failed_apellidos";
                        header("Location:" . BASE_URL . "usuario/gestion" . (isset($_GET['id']) ? "&id=" . $_GET['id'] : "") . "#apellidos");
                        exit;
                    }
        
                    if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $_SESSION['gestion'] = "failed_email";
                        header("Location:" . BASE_URL . "usuario/gestion" . (isset($_GET['id']) ? "&id=" . $_GET['id'] : "") . "#email");
                        exit;
                    }

                    // Comprobar si el email ya existe en la base de datos (excepto si es el mismo usuario)
                    if ($email && $email != $dummyUsuario->getEmail()) {
                        $usuarioExistente = Usuario::getByEmail($email);
                        if ($usuarioExistente) {
                            $_SESSION['gestion'] = "failed_email_exists";
                            header("Location:" . BASE_URL . "usuario/gestion" . (isset($_GET['id']) ? "&id=" . $_GET['id'] : "") . "#email");
                            exit;
                        }
                    }
        
                    if (strlen($password) > 0 && !preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $password)) {
                        $_SESSION['gestion'] = "failed_password";
                        header("Location:" . BASE_URL . "usuario/gestion" . (isset($_GET['id']) ? "&id=" . $_GET['id'] : "") . "#password");
                        exit;
                    }

                    if ($color && !preg_match('/^#[0-9A-Fa-f]{6}$/', $color)) {
                        $_SESSION['gestion'] = "failed_color";
                        header("Location:" . BASE_URL . "usuario/gestion" . (isset($_GET['id']) ? "&id=" . $_GET['id'] : "") . "#color");
                        exit;
                    }
        
                    // Validar imagen (jpeg, png, svg) y que no haya errores de subida
                    if ($imagen && $imagen['name']) {
                        
                        $permitidos = ['image/jpeg', 'image/png', 'image/svg+xml'];
                        
                        if (!in_array($imagen['type'], $permitidos) || $imagen['error'] != UPLOAD_ERR_OK) {
                            $_SESSION['gestion'] = 'failed_imagen';
                            header("Location:" . BASE_URL . "usuario/gestion" . (isset($_GET['id']) ? "&id=" . $_GET['id'] : "") . "#imagen");
                            exit;
                        }

                    }
        
                    // Crear objeto Usuario y guardar en BD
                    $usuario = new Usuario();
                    $usuario->setId($id);
                    $usuario->setNombre($nombre);
                    $usuario->setApellidos($apellidos);
                    $usuario->setEmail($email);
                    $usuario->setPassword($password);
                    $usuario->setRol($rol);
                    $usuario->setColor($color);
        
                    // Manejo de la imagen de perfil
                    if ($imagen && $imagen['name']) {
        
                        // Eliminar imagen anterior
                        $imagenAnterior = $dummyUsuario->getImagen();
                        $uploadDir = 'assets/images/uploads/usuarios/';
        
                        if (is_file($uploadDir . $imagenAnterior)) unlink($uploadDir . $imagenAnterior);
                        
                        // Subir nueva imagen
                        $ext = pathinfo($imagen['name'], PATHINFO_EXTENSION);
                        $nombreImagen = $id . '.' . $ext;
        
                        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        
                        if (move_uploaded_file($imagen['tmp_name'], $uploadDir . $nombreImagen)) {

                            $usuario->setImagen($nombreImagen);
                            $imagenCambiada = true;

                        } else {

                            $_SESSION['gestion'] = 'failed';
                            header("Location:" . BASE_URL . "usuario/gestion" . (isset($_GET['id']) ? "&id=" . $_GET['id'] : "") . "#imagen");
                            exit;

                        }

                    }
        
                    if ($usuario->update()) {

                        $_SESSION['gestion'] = "complete";
                        Utils::deleteSession('form_data');
        
                        if ($_SESSION['identity']['id'] == $id) {
                            $_SESSION['identity']['nombre'] = $nombre;
                            $_SESSION['identity']['apellidos'] = $apellidos;
                            $_SESSION['identity']['email'] = $email;
                            $_SESSION['identity']['rol'] = $rol;
                            $_SESSION['identity']['imagen'] = $usuario->getImagen();
                            $_SESSION['identity']['color'] = $color;
                        }
        
                        if (isset($_GET['id'])) {

                            $usuario = Usuario::getById($id);
                            
                            Utils::enviarCorreo($usuario, "Cuenta editada", BASE_URL."mails/usuario/editar.html", [
                                "USERNAME" => $usuario->getNombre(),
                                "APELLIDOS" => $usuario->getApellidos(),
                                "EMAIL" => $usuario->getEmail(),
                                "COLOR" => $usuario->getColor(),
                            ], [
                                [
                                    'ruta' => __DIR__ . '/../assets/images/uploads/usuarios/' . $usuario->getImagen(),
                                    'cid' => 'user',
                                    'nombre' => $usuario->getNombre() . ' ' . $usuario->getApellidos()
                                ]
                            ]);
                            
                            Utils::deleteSession('gestion');
                            header("Location:" . BASE_URL . "usuario/admin" . (isset($_SESSION['pag']) ? "&pag=" . $_SESSION['pag'] : "") . "#" . $id);
                            exit;

                        }else {
                            
                            $usuario = Usuario::getById($usuario->getId());

                            Utils::enviarCorreo($usuario, "Cuenta editada", BASE_URL."mails/usuario/gestion.html", [
                                "USERNAME" => $usuario->getNombre(),
                                "APELLIDOS" => $usuario->getApellidos(),
                                "EMAIL" => $usuario->getEmail(),
                                "COLOR" => $usuario->getColor(),
                            ], [
                                [
                                    'ruta' => __DIR__ . '/../assets/images/uploads/usuarios/' . $usuario->getImagen(),
                                    'cid' => 'user',
                                    'nombre' => $usuario->getNombre() . ' ' . $usuario->getApellidos()
                                ]
                            ]);
                        
                            header("Location:" . BASE_URL . "usuario/gestion#complete");
                            exit;

                        }
                        
                    } else {

                        $_SESSION['gestion'] = "failed";

                        // Establecemos a 'nothing' en el extraño caso de que sólo se haya cambiado la imagen y además coincida en formato con la anterior
                        // Ejemplo: si la imagen es '1.jpg' y se sube una nueva '1.jpg', no se ha modificado nada

                        if($usuario->getImagen() == $dummyUsuario->getImagen() && !$imagenCambiada) $_SESSION['gestion'] = "nothing";

                        if($imagenCambiada) {
                            
                            $_SESSION['gestion'] = "complete";

                            $usuario = Usuario::getById($id);

                            Utils::enviarCorreo($usuario, "Cuenta editada", BASE_URL."mails/usuario/gestion.html", [
                                "USERNAME" => $usuario->getNombre(),
                                "APELLIDOS" => $usuario->getApellidos(),
                                "EMAIL" => $usuario->getEmail(),
                                "COLOR" => $usuario->getColor(),
                            ], [
                                [
                                    'ruta' => __DIR__ . '/../assets/images/uploads/usuarios/' . $usuario->getImagen(),
                                    'cid' => 'user',
                                    'nombre' => $usuario->getNombre() . ' ' . $usuario->getApellidos()
                                ]
                            ]);

                        }

                        if (isset($_GET['id'])) {

                            Utils::deleteSession('gestion');
                            header("Location:" . BASE_URL . "usuario/admin" . (isset($_SESSION['pag']) ? "&pag=" . $_SESSION['pag'] : "") . "#" . $id);
                            exit;
    
                        }else {
                            
                            header("Location:" . BASE_URL . "usuario/gestion" . (isset($_GET['id']) ? "&id=" . $_GET['id'] : "") . "#" . $_SESSION['gestion']);
                            exit;
    
                        }

                    }
                    
                } else {

                    $_SESSION['gestion'] = "nothing";

                }
        
                header("Location:" . BASE_URL . "usuario/gestion" . (isset($_GET['id']) ? "&id=" . $_GET['id'] : "") . "#nothing");
                exit;

            } else {

                header("Location:" . BASE_URL);
                exit;

            }

        }

        /**
         * Método para eliminar un usuario.
         * Si no hay id en el GET, se elimina el usuario con la sesión iniciada.
         * Si hay id en el GET, se elimina el usuario con ese id (acción de Admins).
         * En el caso de que el propio admin elimine su cuenta, mediante la tabla,
         * se le redirige a la página de inicio.
         * Obviamente tenemos que tener en cuenta la cascada, Si eliminas al usuario:
         * - Se eliminarán todas las valoraciones del usuario.
         * - Se eliminarán todos los pedidos del usuario y se enviará un correo por pedido al usuario de que
         *   su pedido ha sido eliminado.
         * Y también se enviará un correo al usuario de que su cuenta ha sido eliminada.
         * 
         * Nota: El código del proyecto es muy ineficiente a veces, este es simplemente un ejemplo de ello.
         */

        public function eliminar(): void {

            Utils::isIdentity();
        
            if(isset($_GET['id'])){
        
                Utils::isAdmin();
        
                $id = $_GET['id'];
        
                $usuario = Usuario::getById($id);
        
                if(!$usuario){
        
                    header("Location:" . BASE_URL . "usuario/admin" . (isset($_SESSION['pag']) ? "&pag=" . $_SESSION['pag'] : ""));
                    exit;
        
                }

                $valoraciones = Valoracion::getByUsuario($usuario->getId());

                foreach($valoraciones as $valoracion){

                    // 1. Eliminamos todas las valoraciones del usuario

                    $valoracion->delete();

                }

                $pedidos = Pedido::getByUsuario($id);

                foreach($pedidos as $pedido){

                    $lineas = LineaPedido::getByPedido($pedido->getId());
                    $numProductos = 0;

                    foreach($lineas as $linea){

                        $numProductos += $linea->getUnidades();

                        // Dentro. Eliminamos todas las líneas de pedido de todos los pedidos asociados al usuario

                        $linea->delete();

                    }

                    Utils::enviarCorreo($usuario, "Pedido eliminado", BASE_URL . "mails/pedido/eliminar.html", [
                        'ID' => $pedido->getId(),
                        'USERNAME' => $usuario->getNombre(),
                        'PRODUCTOS' => $numProductos,
                        'FECHA' => $pedido->getFecha(),
                        'HORA' => $pedido->getHora(),
                        'QUERY' => urlencode('C. '.$pedido->getDireccion().' '.$pedido->getCodigoPostal().' '.$pedido->getMunicipio().' '.$pedido->getProvincia()),
                        'DIRECCION' => $pedido->getDireccion().', '.$pedido->getPoblacion().' ('.$pedido->getCodigoPostal().') - '.$pedido->getProvincia(),
                        'RAZON' => "Tu cuenta ha sido eliminada, por lo que el pedido ha sido eliminado.",
                        'COSTE' => $pedido->getCoste(),
                    ]);

                    // 2. Eliminamos todos los pedidos asociados al usuario

                    $pedido->delete();

                }

                // 3. Eliminamos el usuario
        
                if($usuario->delete()){
        
                    $_SESSION['delete'] = "complete";

                    // Eliminar su hueco en la cookie del carrito

                    Utils::deleteCookieCarritoByEmail($usuario->getEmail());

                    // Enviar correo

                    Utils::enviarCorreo($usuario, "Cuenta eliminada", BASE_URL."mails/usuario/destruir.html", [
                        "USERNAME" => $usuario->getNombre(),
                    ], [
                        [
                            'ruta' => __DIR__ . '/../assets/images/uploads/usuarios/' . $usuario->getImagen(),
                            'cid' => 'user',
                            'nombre' => $usuario->getNombre() . ' ' . $usuario->getApellidos()
                        ]
                    ]);
        
                    // Borrar la imagen asociada al usuario (si existe)
                    $imagen = $usuario->getImagen();  // Asumiendo que el usuario tiene un método para obtener su imagen
                    $uploadDir = 'assets/images/uploads/usuarios/';
        
                    if ($imagen && is_file($uploadDir . $imagen)) {
                        unlink($uploadDir . $imagen);
                    }
        
                    if($_SESSION['identity']['id'] == $id){

                        header("Location:" . BASE_URL . "usuario/salir");
                        exit;
        
                    }
        
                }else{
        
                    $_SESSION['delete'] = "failed";
        
                }
        
                header("Location:" . BASE_URL . "usuario/admin" . (isset($_SESSION['pag']) ? "&pag=" . $_SESSION['pag'] : ""));
                exit;
        
            }else{

                $id = $_SESSION['identity']['id'];
        
                $usuario = Usuario::getById($id);

                if(!$usuario){
        
                    header("Location:" . BASE_URL);
                    exit;
        
                }
                
                // CASCADA

                $valoraciones = Valoracion::getByUsuario($id);

                foreach($valoraciones as $valoracion){

                    // 1. Eliminamos todas las valoraciones asociadas al usuario

                    $valoracion->delete();

                }

                $pedidos = Pedido::getByUsuario($usuario->getId());

                foreach($pedidos as $pedido){

                    $lineas = LineaPedido::getByPedido($pedido->getId());
                    $numProductos = 0;

                    foreach($lineas as $linea){

                        $numProductos += $linea->getUnidades();

                        // Dentro. Eliminamos todas las líneas de pedido de todos los pedidos asociados al usuario

                        $linea->delete();

                    }

                    Utils::enviarCorreo($usuario, "Pedido eliminado", BASE_URL . "mails/pedido/eliminar.html", [
                        'ID' => $pedido->getId(),
                        'USERNAME' => $usuario->getNombre(),
                        'PRODUCTOS' => $numProductos,
                        'FECHA' => $pedido->getFecha(),
                        'HORA' => $pedido->getHora(),
                        'QUERY' => urlencode('C. '.$pedido->getDireccion().' '.$pedido->getCodigoPostal().' '.$pedido->getMunicipio().' '.$pedido->getProvincia()),
                        'DIRECCION' => $pedido->getDireccion().', '.$pedido->getPoblacion().' ('.$pedido->getCodigoPostal().') - '.$pedido->getProvincia(),
                        'RAZON' => "Has eliminado tu cuenta, por lo que el pedido ha sido eliminado.",
                        'COSTE' => $pedido->getCoste(),
                    ]);

                    // 2. Eliminamos todos los pedidos asociados al usuario

                    $pedido->delete();

                }

                // 3. Eliminamos el usuario
        
                if($usuario->delete()){
        
                    $_SESSION['delete'] = "complete";

                    Utils::deleteCookieCarrito();

                    Utils::enviarCorreo($usuario, "Cuenta eliminada", BASE_URL."mails/usuario/eliminar.html", [
                        "USERNAME" => $usuario->getNombre(),
                    ], [
                        [
                            'ruta' => __DIR__ . '/../assets/images/uploads/usuarios/' . $usuario->getImagen(),
                            'cid' => 'user',
                            'nombre' => $usuario->getNombre() . ' ' . $usuario->getApellidos()
                        ]
                    ]);
        
                    // Borrar la imagen asociada al usuario (si existe)
                    $imagen = $usuario->getImagen();  // Asumiendo que el usuario tiene un método para obtener su imagen
                    $uploadDir = 'assets/images/uploads/usuarios/';
        
                    if ($imagen && is_file($uploadDir . $imagen)) {
                        unlink($uploadDir . $imagen);
                    }
        
                }else{
        
                    $_SESSION['delete'] = "failed";
        
                }
        
                header("Location:" . BASE_URL . "usuario/salir");
                exit;
        
            }
        
        }

        /**
         * Método para requerir la vista de adminsitración de usuarios mediante paginación.
         * Requiere ser administrador.
         */

        public function admin(): void {
            
            Utils::isAdmin();

            $usuariosPorPagina = ITEMS_PER_PAGE;

            // Aqui seteamos el numero de pagina, y abajo redirigimos a 1 o la última página si la página es menor que 1 o mayor que el total de páginas

            $_SESSION['pag'] = isset($_GET['pag']) ? (int)$_GET['pag'] : 1;

            $usuarios = Usuario::getAll();

            $totalPag = max(1, ceil(count($usuarios) / $usuariosPorPagina));
            $usuarios = array_slice($usuarios, ($_SESSION['pag'] - 1) * $usuariosPorPagina, $usuariosPorPagina);

            // Ahora redirigimos a la primera o última página si la página es menor que 1 o mayor que el total de páginas

            if($_SESSION['pag'] < 1){
                header("Location:" . BASE_URL . "usuario/admin&pag=1");
                exit;
            }
            
            if($_SESSION['pag'] > $totalPag){
                header("Location:" . BASE_URL . "usuario/admin&pag=" . $totalPag);
                exit;
            }

            require_once 'views/usuario/admin.php';

        }

        /**
         * Método para requerir la vista de creación de usuarios. Requiere ser administrador.
         */

        public function crear(): void {

            Utils::isAdmin();
            require_once 'views/usuario/crear.php';

        }
        
    }

?>