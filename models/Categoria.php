<?php

    namespace models;

    use lib\BaseDatos;

    class Categoria{

        private int $id;
        private string $nombre;
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

        public function setId(int $id): void{
            $this->id = $id;
        }

        public function setNombre(string $nombre): void{
            $this->nombre = $nombre;
        }

        /* MÉTODOS DINÁMICOS */

        public function save(): bool{

            $this->baseDatos = new BaseDatos();

            $this->baseDatos->ejecutar("INSERT INTO categorias VALUES(null, :nombre)", [
                ':nombre' => $this->nombre
            ]);

            $output = $this->baseDatos->getNumeroRegistros() == 1;
            
            $this->baseDatos->cerrarConexion();

            return $output;

        }

        public function update(): bool {

            $this->baseDatos = new BaseDatos();

            $this->baseDatos->ejecutar("UPDATE categorias SET nombre = :nombre WHERE id = :id", [
                ':nombre' => $this->nombre,
                ':id' => $this->id
            ]);

            $output = $this->baseDatos->getNumeroRegistros() == 1;
            
            $this->baseDatos->cerrarConexion();

            return $output;

        }

        public function delete(): bool{

            $this->baseDatos = new BaseDatos();

            $this->baseDatos->ejecutar("SELECT MAX(id) AS id FROM categorias");

            $maxId = $this->baseDatos->getSiguienteRegistro();
            $maxId = $maxId ? $maxId['id'] : null;

            $this->baseDatos->ejecutar("DELETE FROM categorias WHERE id = :id", [
                ':id' => $this->id
            ]);

            $output = $this->baseDatos->getNumeroRegistros() == 1;

            if ($output && $this->id == $maxId) {
                
                $this->baseDatos->ejecutar("SELECT MAX(id) AS id FROM categorias");

                $nuevoMaxId = $this->baseDatos->getSiguienteRegistro();
                $nuevoMaxId = $nuevoMaxId ? $nuevoMaxId['id'] : 0; // Si no hay registros, se pone 0

                $nuevoAutoIncrement = $nuevoMaxId + 1; // Si la tabla está vacía, empieza en 1
        
                $this->baseDatos->ejecutar("ALTER TABLE categorias AUTO_INCREMENT = :id", [
                    ':id' => $nuevoAutoIncrement
                ]);

            }
            
            $this->baseDatos->cerrarConexion();

            return $output;

        }

        /* MÉTODOS ESTÁTICOS */

        public static function getById(int $id): ?Categoria {

            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("SELECT * FROM categorias WHERE id = :id", [
                ':id' => $id
            ]);

            if($baseDatos->getNumeroRegistros() == 1){

                $registro = $baseDatos->getSiguienteRegistro();

                $categoria = new Categoria();

                $categoria->setId($registro['id']);
                $categoria->setNombre($registro['nombre']);

                $baseDatos->cerrarConexion();

                return $categoria;

            }

            $baseDatos->cerrarConexion();

            return null;

        }

        public static function getAll(): array {

            $baseDatos = new BaseDatos();
            
            $baseDatos->ejecutar("SELECT * FROM categorias");
        
            $registros = $baseDatos->getRegistros();

            $categorias = [];
        
            foreach ($registros as $registro) {

                $categoria = new Categoria();

                $categoria->setId($registro['id']);
                $categoria->setNombre($registro['nombre']);
        
                array_push($categorias, $categoria);
                
            }

            $baseDatos->cerrarConexion();
        
            return $categorias;
            
        }

        /* Método auxiliar */

        public static function getLastId(): int {

            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("SELECT MAX(id) AS id FROM categorias");

            $registro = $baseDatos->getSiguienteRegistro();

            $id = $registro['id'];

            $baseDatos->cerrarConexion();

            return $id;

        }

    }

?>