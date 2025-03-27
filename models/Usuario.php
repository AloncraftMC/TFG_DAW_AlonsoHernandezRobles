<?php

    namespace models;

    use lib\BaseDatos;

    class Usuario{

        private int $id;
        private string $nombre;
        private string $apellidos;
        private string $email;
        private ?string $password;
        private ?string $rol;
        private ?string $imagen;
        private BaseDatos $baseDatos;
        
        public function __construct(){
        }

        /* GETTERS Y SETTERS */
        
        public function getId(): int{
            return $this->id;
        }

        public function getNombre(): string{
            return $this->nombre;
        }

        public function getApellidos(): string{
            return $this->apellidos;
        }

        public function getEmail(): string{
            return $this->email;
        }

        public function getPassword(): ?string{
            return $this->password;
        }

        public function getRol(): ?string{
            return $this->rol;
        }

        public function getImagen(): ?string{
            return $this->imagen;
        }

        public function setId(int $id): void{
            $this->id = $id;
        }
        
        public function setNombre(string $nombre): void{
            $this->nombre = $nombre;
        }

        public function setApellidos(string $apellidos): void{
            $this->apellidos = $apellidos;
        }

        public function setEmail(string $email): void{
            $this->email = $email;
        }

        public function setPassword(?string $password): void{
            $this->password = $password;
        }

        public function setRol(?string $rol): void{
            $this->rol = $rol;
        }

        public function setImagen(?string $imagen): void{
            $this->imagen = $imagen;
        }

        /* MÉTODOS DINÁMICOS */

        public function save(): bool{

            $this->baseDatos = new BaseDatos();
            
            $this->baseDatos->ejecutar("INSERT INTO usuarios VALUES(null, :nombre, :apellidos, :email, :password, :rol, null)", [
                ':nombre' => $this->nombre,
                ':apellidos' => $this->apellidos,
                ':email' => $this->email,
                ':password' => password_hash($this->password, PASSWORD_BCRYPT, ['cost' => 4]),
                ':rol' => $this->rol
            ]);

            $output = $this->baseDatos->getNumeroRegistros() == 1;

            $this->baseDatos->cerrarConexion();

            return $output;

        }

        public function login(): ?Usuario{

            $this->baseDatos = new BaseDatos();

            // Buscar el usuario en la base de datos
            
            $this->baseDatos->ejecutar("SELECT * FROM usuarios WHERE email = :email", [
                ':email' => $this->email,
            ]);

            // Si se encontró un usuario con ese email

            if($this->baseDatos->getNumeroRegistros() == 1){
                
                $usuario = $this->baseDatos->getSiguienteRegistro();

                // Verificar la contraseña
                
                if(password_verify($this->password, $usuario['password'])){

                    $this->setId($usuario['id']);
                    $this->setNombre($usuario['nombre']);
                    $this->setApellidos($usuario['apellidos']);
                    $this->setEmail($usuario['email']);
                    $this->setRol($usuario['rol']);
                    $this->setImagen($usuario['imagen']);

                    $this->baseDatos->cerrarConexion();

                    return $this;

                }

            }

            $this->baseDatos->cerrarConexion();

            return null;

        }

        public function update(): bool {

            $this->baseDatos = new BaseDatos();

            if(!$this->password || strlen($this->password) == 0) $this->password = null;
            
            if(!isset($this->rol)) $this->rol = 'user';
            
            if(!isset($this->imagen)) $this->imagen = Usuario::getById($this->id)->getImagen();

            if($this->password !== null) {
                
                // Si se ha introducido una nueva contraseña, se actualiza el campo 'password'

                $query = "UPDATE usuarios 
                          SET nombre = :nombre, apellidos = :apellidos, email = :email, password = :password, rol = :rol, imagen = :imagen
                          WHERE id = :id";

                $params = [
                    ':nombre' => $this->nombre,
                    ':apellidos' => $this->apellidos,
                    ':email' => $this->email,
                    ':password' => password_hash($this->password, PASSWORD_BCRYPT, ['cost' => 4]),
                    ':rol' => $this->rol,
                    ':imagen' => $this->imagen,
                    ':id' => $this->id
                ];

            }else {

                // Si no se ha introducido una nueva contraseña, se actualizan los demás campos sin tocar 'password'

                $query = "UPDATE usuarios 
                          SET nombre = :nombre, apellidos = :apellidos, email = :email, rol = :rol, imagen = :imagen
                          WHERE id = :id";

                $params = [
                    ':nombre' => $this->nombre,
                    ':apellidos' => $this->apellidos,
                    ':email' => $this->email,
                    ':rol' => $this->rol,
                    ':imagen' => $this->imagen,
                    ':id' => $this->id
                ];

            }
        
            $this->baseDatos->ejecutar($query, $params);
        
            $output = $this->baseDatos->getNumeroRegistros() == 1;

            $this->baseDatos->cerrarConexion();

            return $output;

        }

        public function delete(): bool {

            $this->baseDatos = new BaseDatos();

            $this->baseDatos->ejecutar("SELECT MAX(id) AS id FROM usuarios");

            $maxId = $this->baseDatos->getSiguienteRegistro();
            $maxId = $maxId ? $maxId['id'] : null;

            $this->baseDatos->ejecutar("DELETE FROM usuarios WHERE id = :id", [
                ':id' => $this->id
            ]);

            $output = $this->baseDatos->getNumeroRegistros() == 1;

            if ($output && $this->id == $maxId) {
                
                $this->baseDatos->ejecutar("SELECT MAX(id) AS id FROM usuarios");

                $nuevoMaxId = $this->baseDatos->getSiguienteRegistro();
                $nuevoMaxId = $nuevoMaxId ? $nuevoMaxId['id'] : 0;

                $nuevoAutoIncrement = $nuevoMaxId + 1; // Si la tabla está vacía, empieza en 1

                $this->baseDatos->ejecutar("ALTER TABLE usuarios AUTO_INCREMENT = :id", [
                    ':id' => $nuevoAutoIncrement
                ]);

            }

            $this->baseDatos->cerrarConexion();

            return $output;

        }

        /* MÉTODOS ESTÁTICOS */

        public static function getById(int $id): ?Usuario {

            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("SELECT * FROM usuarios WHERE id = :id", [
                ':id' => $id
            ]);

            if($baseDatos->getNumeroRegistros() == 1){

                $registro = $baseDatos->getSiguienteRegistro();

                $usuario = new Usuario();
                
                $usuario->setId($registro['id']);
                $usuario->setNombre($registro['nombre']);
                $usuario->setApellidos($registro['apellidos']);
                $usuario->setEmail($registro['email']);
                $usuario->setRol($registro['rol']);
                $usuario->setImagen($registro['imagen']);

                $baseDatos->cerrarConexion();

                return $usuario;

            }

            $baseDatos->cerrarConexion();

            return null;

        }

        public static function getByEmail(string $email): ?Usuario {

            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("SELECT * FROM usuarios WHERE email = :email", [
                ':email' => $email
            ]);

            if($baseDatos->getNumeroRegistros() == 1){

                $registro = $baseDatos->getSiguienteRegistro();

                $usuario = new Usuario();

                $usuario->setId($registro['id']);
                $usuario->setNombre($registro['nombre']);
                $usuario->setApellidos($registro['apellidos']);
                $usuario->setEmail($registro['email']);
                $usuario->setRol($registro['rol']);
                $usuario->setImagen($registro['imagen']);

                $baseDatos->cerrarConexion();

                return $usuario;

            }

            $baseDatos->cerrarConexion();

            return null;

        }

        public static function getAll(): array {

            $baseDatos = new BaseDatos();
            
            $baseDatos->ejecutar("SELECT * FROM usuarios");
        
            $registros = $baseDatos->getRegistros();

            $usuarios = [];
        
            foreach ($registros as $registro) {

                $usuario = new Usuario();

                $usuario->setId($registro['id']);
                $usuario->setNombre($registro['nombre']);
                $usuario->setApellidos($registro['apellidos']);
                $usuario->setEmail($registro['email']);
                $usuario->setRol($registro['rol']);
                $usuario->setImagen($registro['imagen']);
        
                $usuarios[] = $usuario;
                
            }

            $baseDatos->cerrarConexion();
        
            return $usuarios;
            
        }
        
    }

?>