<?php

    namespace models;

    use lib\BaseDatos;

    class Valoracion{

        private int $id;
        private int $usuarioId;
        private int $productoId;
        private int $puntuacion;
        private string $comentario;
        private string $fecha;

        /* GETTERS Y SETTERS */
        
        public function getId(): int{
            return $this->id;
        }

        public function getUsuarioId(): int{
            return $this->usuarioId;
        }

        public function getProductoId(): int{
            return $this->productoId;
        }

        public function getPuntuacion(): int{
            return $this->puntuacion;
        }

        public function getComentario(): string{
            return $this->comentario;
        }

        public function getFecha(): string{
            return $this->fecha;
        }

        public function setId(int $id): void{
            $this->id = $id;
        }

        public function setUsuarioId(int $usuarioId): void{
            $this->usuarioId = $usuarioId;
        }

        public function setProductoId(int $productoId): void{
            $this->productoId = $productoId;
        }

        public function setPuntuacion(int $puntuacion): void{
            $this->puntuacion = $puntuacion;
        }

        public function setComentario(string $comentario): void{
            $this->comentario = $comentario;
        }

        public function setFecha(string $fecha): void{
            $this->fecha = $fecha;
        }

        /* MÉTODOS DINÁMICOS */

        public function save(): bool{

            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("INSERT INTO valoraciones VALUES (null, :usuario_id, :producto_id, :puntuacion, :comentario, :fecha)", [
                ':usuario_id' => $this->usuarioId,
                ':producto_id' => $this->productoId,
                ':puntuacion' => $this->puntuacion,
                ':comentario' => $this->comentario,
                ':fecha' => $this->fecha
            ]);

            $output = $baseDatos->getNumeroRegistros() == 1;
            
            $baseDatos->cerrarConexion();

            return $output;

        }

        public function update(): bool {

            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("UPDATE valoraciones SET puntuacion = :puntuacion, comentario = :comentario, fecha = :fecha WHERE id = :id", [
                ':puntuacion' => $this->puntuacion,
                ':comentario' => $this->comentario,
                ':fecha' => $this->fecha,
                ':id' => $this->id
            ]);

            $output = $baseDatos->getNumeroRegistros() == 1;
            
            $baseDatos->cerrarConexion();

            return $output;

        }

        public function delete(): bool{

            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("SELECT MAX(id) AS id FROM valoraciones");

            $maxId = $baseDatos->getSiguienteRegistro();
            $maxId = $maxId ? $maxId['id'] : null;

            $baseDatos->ejecutar("DELETE FROM valoraciones WHERE id = :id", [
                ':id' => $this->id
            ]);

            $output = $baseDatos->getNumeroRegistros() == 1;

            if ($output && $this->id == $maxId) {
                
                $baseDatos->ejecutar("SELECT MAX(id) AS id FROM valoraciones");

                $nuevoMaxId = $baseDatos->getSiguienteRegistro();
                $nuevoMaxId = $nuevoMaxId ? $nuevoMaxId['id'] : 0; // Si no hay registros, se pone 0

                $nuevoAutoIncrement = $nuevoMaxId + 1; // Si la tabla está vacía, empieza en 1
        
                $baseDatos->ejecutar("ALTER TABLE valoraciones AUTO_INCREMENT = $nuevoAutoIncrement");

            }
            
            $baseDatos->cerrarConexion();

            return $output;

        }

        /* MÉTODOS ESTÁTICOS */

        public static function getById(int $id): ?Valoracion {

            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("SELECT * FROM valoraciones WHERE id = :id", [
                ':id' => $id
            ]);

            if($baseDatos->getNumeroRegistros() == 1){

                $registro = $baseDatos->getSiguienteRegistro();

                $valoracion = new Valoracion();

                $valoracion->setId($registro['id']);
                $valoracion->setUsuarioId($registro['usuario_id']);
                $valoracion->setProductoId($registro['producto_id']);
                $valoracion->setPuntuacion($registro['puntuacion']);
                $valoracion->setComentario($registro['comentario']);
                $valoracion->setFecha($registro['fecha']);

                $baseDatos->cerrarConexion();

                return $valoracion;

            }

            $baseDatos->cerrarConexion();

            return null;

        }

        public static function getByProductoAndUsuario(int $productoId, int $usuarioId) : ?Valoracion {

            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("SELECT * FROM valoraciones WHERE producto_id = :producto_id AND usuario_id = :usuario_id", [
                ':producto_id' => $productoId,
                ':usuario_id' => $usuarioId
            ]);
        
            if($baseDatos->getNumeroRegistros() == 1){

                $registro = $baseDatos->getSiguienteRegistro();

                $valoracion = new Valoracion();

                $valoracion->setId($registro['id']);
                $valoracion->setUsuarioId($registro['usuario_id']);
                $valoracion->setProductoId($registro['producto_id']);
                $valoracion->setPuntuacion($registro['puntuacion']);
                $valoracion->setComentario($registro['comentario']);
                $valoracion->setFecha($registro['fecha']);

                $baseDatos->cerrarConexion();

                return $valoracion;

            }

            $baseDatos->cerrarConexion();

            return null;

        }

        public static function getByUsuario(int $usuarioId): array {

            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("SELECT * FROM valoraciones WHERE usuario_id = :usuario_id", [
                ':usuario_id' => $usuarioId
            ]);
        
            $registros = $baseDatos->getRegistros();
        
            $valoraciones = [];
        
            foreach ($registros as $registro) {
        
                $valoracion = new Valoracion();
        
                $valoracion->setId($registro['id']);
                $valoracion->setUsuarioId($registro['usuario_id']);
                $valoracion->setProductoId($registro['producto_id']);
                $valoracion->setPuntuacion($registro['puntuacion']);
                $valoracion->setComentario($registro['comentario']);
                $valoracion->setFecha($registro['fecha']);
        
                array_push($valoraciones, $valoracion);
                
            }

            $baseDatos->cerrarConexion();
        
            return $valoraciones;

        }

        public static function getByProducto(int $productoId): array {

            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("SELECT * FROM valoraciones WHERE producto_id = :producto_id", [
                ':producto_id' => $productoId
            ]);
        
            $registros = $baseDatos->getRegistros();
        
            $valoraciones = [];
        
            foreach ($registros as $registro) {
        
                $valoracion = new Valoracion();
        
                $valoracion->setId($registro['id']);
                $valoracion->setUsuarioId($registro['usuario_id']);
                $valoracion->setProductoId($registro['producto_id']);
                $valoracion->setPuntuacion($registro['puntuacion']);
                $valoracion->setComentario($registro['comentario']);
                $valoracion->setFecha($registro['fecha']);
        
                array_push($valoraciones, $valoracion);
                
            }

            $baseDatos->cerrarConexion();
        
            return $valoraciones;

        }

    }