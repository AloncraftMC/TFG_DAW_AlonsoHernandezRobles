<?php

    /**
     * Clase para la conexión a la base de datos
     * 
     * Contiene los métodos:
     * __construct():           Inicializa la conexión.
     * ejecutar():              Ejecuta una consulta SQL.
     * getSiguienteRegistro():  Obtiene el siguiente registro de la consulta.
     * getRegistros():          Obtiene todos los registros de la consulta.
     * getNumeroRegistros():    Obtiene el número de registros de la consulta.
     * getUltimoId():           Obtiene el último ID insertado.
     * cerrarConexion():        Cierra la conexión a la base de datos.
     * __destruct():            Destructor de la clase.
     */

    namespace lib;

    use PDO;
    use PDOException;
    use PDOStatement;

    class BaseDatos{

        private string $servidor;
        private string $usuario;
        private string $contrasena;
        private string $nombre;

        private ?PDO $conexion;
        private ?PDOStatement $resultado;

        /**
         * Constructor de la clase BaseDatos.
         */

        public function __construct(){
        
            try{

                $this->servidor = DB_HOST;
                $this->usuario = DB_USER;
                $this->contrasena = DB_PASSWORD;
                $this->nombre = DB_NAME;

                $this->conexion = new PDO("mysql:host=$this->servidor;dbname=$this->nombre;charset=utf8mb4", $this->usuario, $this->contrasena);

                $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            }catch(PDOException $e){

                echo "<h1>Error de conexión: " . $e->getMessage() . "</h1>";

            }
        
        }

        /**
         * Método para ejecutar una consulta SQL con parámetros opcionales para evitar inyecciones SQL.
         */

        public function ejecutar(string $sql, array $parametros = []): void{

            try{

                $this->resultado = $this->conexion->prepare($sql);
                $this->resultado->execute($parametros);

            }catch(PDOException $e){

                echo "<h1>Error al ejecutar la consulta: " . $e->getMessage() . "</h1>";

            }

        }

        /*
        * Métodos para obtener resultados de la base de datos
        */

        public function getSiguienteRegistro(): ?array{
            return $this->resultado->fetch();
        }

        public function getRegistros(): array{
            return $this->resultado->fetchAll();
        }

        public function getNumeroRegistros(): int{
            return $this->resultado->rowCount();
        }

        public function getUltimoId(): string{
            return $this->conexion->lastInsertId();
        }

        /* Cierre de la conexión con la base de datos */

        public function cerrarConexion(): void {
            $this->conexion = null;
            $this->resultado = null;
        }
    
        public function __destruct() {
            $this->cerrarConexion();
        }

    }

?>