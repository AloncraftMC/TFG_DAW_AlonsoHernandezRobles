<?php

    namespace controllers;

    use models\Usuario;
    use helpers\Utils;

    class UsuarioController{

        // Método para mostrar la vista de registrarse

        public function registrarse(): void{

            if(isset($_SESSION['identity'])){
                header("Location:" . BASE_URL);
                exit;
            }

            require_once 'views/usuario/registrarse.php';
        
        }

        // Método para guardar un usuario en la base de datos

        public function guardar(): void {

            Utils::isIdentity();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                // Recoger datos con trim() para evitar espacios adicionales

                $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : false;
                $apellidos = isset($_POST['apellidos']) ? trim($_POST['apellidos']) : false;
                $email = isset($_POST['email']) ? trim($_POST['email']) : false;
                $password = isset($_POST['password']) ? trim($_POST['password']) : false;
                $rol = isset($_POST['rol']) ? $_POST['rol'] : 'user';
                $imagen = isset($_FILES['imagen']) ? $_FILES['imagen'] : false;
                
                $_SESSION['form_data'] = [
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'email' => $email,
                    'password' => $password,
                    'rol' => $rol,
                    'imagen' => $imagen
                ];

                if ($nombre && $apellidos && $email && $password) {
        
                    // Validar nombre (solo letras y espacios, mínimo 2 caracteres)

                    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,}$/u", $nombre)) {
                        $_SESSION['register'] = "failed_nombre";
                        header("Location:" . BASE_URL . "usuario/" . (isset($_SESSION['admin']) ? 'crear' : 'registrarse'));
                        exit;
                    }
                    
                    // Validar apellidos (solo letras y espacios, mínimo 2 caracteres)
        
                    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,}$/u", $apellidos)) {
                        $_SESSION['register'] = "failed_apellidos";
                        header("Location:" . BASE_URL . "usuario/" . (isset($_SESSION['admin']) ? 'crear' : 'registrarse'));
                        exit;
                    }
        
                    // Validar email

                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $_SESSION['register'] = "failed_email";
                        header("Location:" . BASE_URL . "usuario/" . (isset($_SESSION['admin']) ? 'crear' : 'registrarse'));
                        exit;
                    }
        
                    // Validar contraseña (mínimo 8 caracteres, al menos una letra y un número)

                    if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $password)) {
                        $_SESSION['register'] = "failed_password";
                        header("Location:" . BASE_URL . "usuario/" . (isset($_SESSION['admin']) ? 'crear' : 'registrarse'));
                        exit;
                    }

                    // Validar imagen (jpeg, png, svg)

                    $permitidos = ['image/jpeg', 'image/png', 'image/svg+xml'];
                    if ($imagen && (!in_array($imagen['type'], $permitidos) || $imagen['error'] != UPLOAD_ERR_OK)) {
                        $_SESSION['register'] = 'failed_imagen';
                        header("Location:" . BASE_URL . "usuario/" . (isset($_SESSION['admin']) ? 'crear' : 'registrarse'));
                        exit;
                    }
        
                    // Crear objeto Usuario y guardar en BD

                    $usuario = new Usuario();
                    $usuario->setNombre($nombre);
                    $usuario->setApellidos($apellidos);
                    $usuario->setEmail($email);
                    $usuario->setPassword($password);
                    $usuario->setRol($rol);
        
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
                                header("Location:" . BASE_URL . "usuario/" . (isset($_SESSION['admin']) ? 'crear' : 'registrarse'));
                                exit;

                            }

                        }
        
                        $_SESSION['register'] = 'complete';
                        
                        if (isset($_SESSION['admin'])) {

                            $usuario = Usuario::getByEmail($email);

                            Utils::deleteSession('register');
                            header("Location:" . BASE_URL . "usuario/admin&pag=" . max(1, ceil(count(Usuario::getAll()) / ITEMS_PER_PAGE)) . "#" . $usuario->getId()); // Redirigir a la última página
                        
                        } else {

                            header("Location:" . BASE_URL . "usuario/registrarse");
                        
                        }
        
                    } else {
                        
                        $_SESSION['register'] = 'failed';
                        header("Location:" . BASE_URL . "usuario/" . (isset($_SESSION['admin']) ? 'crear' : 'registrarse'));
                        exit;

                    }
        
                } else {

                    $_SESSION['register'] = "failed";
                    header("Location:" . BASE_URL . "usuario/" . (isset($_SESSION['admin']) ? 'crear' : 'registrarse'));
                    exit;

                }

        
            } else {
                
                header("Location:" . BASE_URL);
                exit;

            }

        }

        // Método para mostrar la vista de iniciar sesión

        public function login(): void{

            // Si ya estamos identificados, nos redirige a la página principal
            
            if(isset($_SESSION['identity'])){

                header("Location:" . BASE_URL);

            }

            // Cargar cookies

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
                        'imagen' => $usuario->getImagen()
                    ];
            
                    if ($usuario->getRol() == 'admin') $_SESSION['admin'] = true;
            
                    header("Location:" . BASE_URL);
                    exit;

                }

            }

            require_once 'views/usuario/login.php';

        }

        // Método para iniciar sesión

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
                            'imagen' => $usuario->getImagen()
                        ];

                        // Remember es un checkbox. Si se ha marcado, se guarda una cookie con el email durante 7 días

                        if($remember){

                            setcookie('recuerdame', $email, time() + 60 * 60 * 24 * 7);

                        }else{

                            if(isset($_COOKIE['recuerdame'])){

                                setcookie('recuerdame', $email, time() - 1);

                            }

                        }

                        if ($usuario->getRol() == 'admin') $_SESSION['admin'] = true;

                        if(isset($_SESSION['redirect_after_login'])){
                            
                            $productoIdRedirect = $_SESSION['redirect_after_login'];
                            Utils::deleteSession('redirect_after_login');
                            
                            header("Location:" . BASE_URL . "producto/ver&id=" . $productoIdRedirect);
                            exit;
                        
                        }
                    
                        header("Location:" . BASE_URL);
                        exit;

                    }else{

                        $_SESSION['login'] = "failed";

                    }

                }else{

                    $_SESSION['login'] = "failed";

                }

            }else{
                
                header("Location:" . BASE_URL);
                exit;

            }
            
            header("Location:" . BASE_URL . "usuario/login");
            exit;

        }

        // Método para cerrar sesión

        public function salir(): void{
            
            Utils::isIdentity();

            Utils::deleteSession('identity');
            Utils::deleteSession('admin');
            Utils::deleteSession('admin_popup');
            Utils::deleteSession('carrito');
            Utils::deleteSession('gestion');
            Utils::deleteCookieCarrito();

            if (isset($_COOKIE['recuerdame'])) {
                setcookie('recuerdame', '', time() - 1);
            }

            header("Location:" . BASE_URL);

        }

        // Método para gestionar el usuario.
        // Si no hay ninguna id en el GET, se requiere la vista de gestión del usuario. (gestion.php)
        // Si hay una id en el GET, se muestra la vista de edición del usuario (acción de Admins). (editar.php)

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

        // Método para editar el usuario.
        // Al igual que el guardar, vamos a contemplar los casos del administrador y del propio usuario.

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
        
                $_SESSION['form_data'] = [
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'email' => $email,
                    'password' => $password,
                    'rol' => $rol,
                    'imagen' => $imagen
                ];
        
                // Determinar si estamos editando otro usuario o el usuario actual
                $id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['identity']['id'];
                $dummyUsuario = Usuario::getById($id);
        
                if ($nombre != $dummyUsuario->getNombre() || 
                    $apellidos != $dummyUsuario->getApellidos() || 
                    $email != $dummyUsuario->getEmail() || 
                    strlen($password) > 0 || 
                    $rol != $dummyUsuario->getRol() ||
                    ($imagen && $imagen['name'])
                ) {
        
                    // Validaciones
                    if ($nombre && !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,}$/u", $nombre)) {
                        $_SESSION['gestion'] = "failed_nombre";
                        header("Location:" . BASE_URL . "usuario/gestion" . (isset($_GET['id']) ? "&id=" . $_GET['id'] : ""));
                        exit;
                    }
        
                    if ($apellidos && !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,}$/u", $apellidos)) {
                        $_SESSION['gestion'] = "failed_apellidos";
                        header("Location:" . BASE_URL . "usuario/gestion" . (isset($_GET['id']) ? "&id=" . $_GET['id'] : ""));
                        exit;
                    }
        
                    if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $_SESSION['gestion'] = "failed_email";
                        header("Location:" . BASE_URL . "usuario/gestion" . (isset($_GET['id']) ? "&id=" . $_GET['id'] : ""));
                        exit;
                    }
        
                    if (strlen($password) > 0 && !preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $password)) {
                        $_SESSION['gestion'] = "failed_password";
                        header("Location:" . BASE_URL . "usuario/gestion" . (isset($_GET['id']) ? "&id=" . $_GET['id'] : ""));
                        exit;
                    }
        
                    // Validar imagen (jpeg, png, svg) y que no haya errores de subida
                    if ($imagen && $imagen['name']) {
                        
                        $permitidos = ['image/jpeg', 'image/png', 'image/svg+xml'];
                        
                        if (!in_array($imagen['type'], $permitidos) || $imagen['error'] != UPLOAD_ERR_OK) {
                            $_SESSION['gestion'] = 'failed_imagen';
                            header("Location:" . BASE_URL . "usuario/gestion" . (isset($_GET['id']) ? "&id=" . $_GET['id'] : ""));
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
                            header("Location:" . BASE_URL . "usuario/gestion" . (isset($_GET['id']) ? "&id=" . $_GET['id'] : ""));
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
                        }
        
                        if (isset($_GET['id'])) {

                            Utils::deleteSession('gestion');
                            header("Location:" . BASE_URL . "usuario/admin" . (isset($_SESSION['pag']) ? "&pag=" . $_SESSION['pag'] : "") . "#" . $id);
                            exit;

                        }else {
                        
                            header("Location:" . BASE_URL . "usuario/gestion");
                            exit;

                        }
                        
                    } else {

                        $_SESSION['gestion'] = "failed";

                        // Establecemos a 'nothing' en el extraño caso de que sólo se haya cambiado la imagen y además coincida en formato con la anterior
                        // Ejemplo: si la imagen es '1.jpg' y se sube una nueva '1.jpg', no se ha modificado nada

                        if($usuario->getImagen() == $dummyUsuario->getImagen() && !$imagenCambiada) $_SESSION['gestion'] = "nothing";

                        if($imagenCambiada) $_SESSION['gestion'] = "complete";

                        if (isset($_GET['id'])) {

                            Utils::deleteSession('gestion');
                            header("Location:" . BASE_URL . "usuario/admin" . (isset($_SESSION['pag']) ? "&pag=" . $_SESSION['pag'] : "") . "#" . $id);
                            exit;
    
                        }else {
                            
                            header("Location:" . BASE_URL . "usuario/gestion&id=" . $id);
                            exit;
    
                        }

                    }
                    
                } else {

                    $_SESSION['gestion'] = "nothing";

                }
        
                header("Location:" . BASE_URL . "usuario/gestion" . (isset($_GET['id']) ? "&id=" . $_GET['id'] : ""));
                exit;

            } else {

                header("Location:" . BASE_URL);
                exit;

            }

        }

        // Método para eliminar un usuario.
        // Si no hay id en el GET, se elimina el usuario con la sesión iniciada.
        // Si hay id en el GET, se elimina el usuario con ese id.

        // En el caso de que el propio admin elimine su cuenta, mediante la tabla, se le redirige a la página de inicio.

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
        
                if($usuario->delete()){
        
                    $_SESSION['delete'] = "complete";
        
                    // Borrar la imagen asociada al usuario (si existe)
                    $imagen = $usuario->getImagen();  // Asumiendo que el usuario tiene un método para obtener su imagen
                    $uploadDir = 'assets/images/uploads/usuarios/';
        
                    if ($imagen && is_file($uploadDir . $imagen)) {
                        unlink($uploadDir . $imagen);
                    }
        
                    if($_SESSION['identity']['id'] == $id){
        
                        Utils::deleteSession('identity');
                        Utils::deleteSession('admin');

                        header("Location:" . BASE_URL);
                        exit;
        
                    }
        
                }else{
        
                    $_SESSION['delete'] = "failed";
        
                }
        
                header("Location:" . BASE_URL . "usuario/admin" . (isset($_SESSION['pag']) ? "&pag=" . $_SESSION['pag'] : ""));
        
            }else{
        
                $usuario = new Usuario();
                $usuario->setId($_SESSION['identity']['id']);
        
                if($usuario->delete()){
        
                    $_SESSION['delete'] = "complete";
        
                    // Borrar la imagen asociada al usuario (si existe)
                    $imagen = $usuario->getImagen();  // Asumiendo que el usuario tiene un método para obtener su imagen
                    $uploadDir = 'assets/images/uploads/usuarios/';
        
                    if ($imagen && is_file($uploadDir . $imagen)) {
                        unlink($uploadDir . $imagen);
                    }
        
                    Utils::deleteSession('identity');
                    Utils::deleteSession('admin');
        
                }else{
        
                    $_SESSION['delete'] = "failed";
        
                }
        
                header("Location:" . BASE_URL);
        
            }
        
            exit;
        
        }        

        // Método para mostrar la vista de administración de usuarios

        public function admin(): void {
            
            Utils::isAdmin();

            $usuariosPorPagina = ITEMS_PER_PAGE;

            // Aqui seteamos el numero de pagina, y abajo redirigimos a 1 o la última página si la página es menor que 1 o mayor que el total de páginas

            $_SESSION['pag'] = isset($_GET['pag']) ? (int)$_GET['pag'] : 1;

            $usuarios = Usuario::getAll();

            $totalPag = max(1, ceil(count($usuarios) / $usuariosPorPagina));
            $usuarios = array_slice($usuarios, ($_SESSION['pag'] - 1) * $usuariosPorPagina, $usuariosPorPagina);

            // Ahora redirigimos a la primera o última página si la página es menor que 1 o mayor que el total de páginas

            if($_SESSION['pag'] < 1) header("Location:" . BASE_URL . "usuario/admin&pag=1");
            if($_SESSION['pag'] > $totalPag) header("Location:" . BASE_URL . "usuario/admin&pag=" . $totalPag);

            require_once 'views/usuario/admin.php';

        }

        // Método para crear un usuario

        public function crear(): void {

            Utils::isAdmin();
            require_once 'views/usuario/crear.php';

        }
        
    }

?>