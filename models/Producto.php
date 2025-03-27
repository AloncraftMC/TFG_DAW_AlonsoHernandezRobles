<?php

    namespace models;

    use lib\BaseDatos;

    class Producto{

        private int $id;
        private int $categoriaId;
        private string $nombre;
        private string $descripcion;
        private float $precio;
        private int $stock;
        private string $oferta;
        private string $fecha;
        private string $imagen;
        private BaseDatos $baseDatos;

        public function __construct(){
        }

        /* GETTERS Y SETTERS */

        public function getId(): int{
            return $this->id;
        }

        public function getCategoriaId(): int{
            return $this->categoriaId;
        }

        public function getNombre(): string{
            return $this->nombre;
        }

        public function getDescripcion(): string{
            return $this->descripcion;
        }

        public function getPrecio(): float{
            return $this->precio;
        }

        public function getStock(): int{
            return $this->stock;
        }

        public function getOferta(): string{
            return $this->oferta;
        }

        public function getFecha(): string{
            return $this->fecha;
        }

        public function getImagen(): string{
            return $this->imagen;
        }

        public function setId(int $id): void{
            $this->id = $id;
        }

        public function setCategoriaId(int $categoriaId): void{
            $this->categoriaId = $categoriaId;
        }

        public function setNombre(string $nombre): void{
            $this->nombre = $nombre;
        }

        public function setDescripcion(string $descripcion): void{
            $this->descripcion = $descripcion;
        }

        public function setPrecio(float $precio): void{
            $this->precio = $precio;
        }

        public function setStock(int $stock): void{
            $this->stock = $stock;
        }

        public function setOferta(string $oferta): void{
            $this->oferta = $oferta;
        }

        public function setFecha(string $fecha): void{
            $this->fecha = $fecha;
        }

        public function setImagen(string $imagen): void{
            $this->imagen = $imagen;
        }

        /* MÉTODOS DINÁMICOS */

        public function save(): bool {

            $this->baseDatos = new BaseDatos();

            $this->baseDatos->ejecutar("INSERT INTO productos VALUES(null, :categoria_id, :nombre, :descripcion, :precio, :stock, :oferta, :fecha, null)", [
                ':categoria_id' => $this->categoriaId,
                ':nombre' => $this->nombre,
                ':descripcion' => $this->descripcion,
                ':precio' => $this->precio,
                ':stock' => $this->stock,
                ':oferta' => $this->oferta,
                ':fecha' => $this->fecha
            ]);
        
            if ($this->baseDatos->getNumeroRegistros() == 1) $this->setId($this->baseDatos->getUltimoId());
        
            $output = $this->baseDatos->getNumeroRegistros() == 1;

            $this->baseDatos->cerrarConexion();

            return $output;
            
        }
        

        public function update(): bool {

            $this->baseDatos = new BaseDatos();

            if (!isset($this->imagen)) {

                $this->baseDatos->ejecutar("SELECT imagen FROM productos WHERE id = :id", [
                    ':id' => $this->id
                ]);
        
                $registro = $this->baseDatos->getSiguienteRegistro();
                $this->imagen = $registro['imagen'];

            }

            $this->baseDatos->ejecutar("UPDATE productos SET categoria_id = :categoria_id, nombre = :nombre, descripcion = :descripcion, precio = :precio, stock = :stock, oferta = :oferta, fecha = :fecha, imagen = :imagen WHERE id = :id", [
                ':categoria_id' => $this->categoriaId,
                ':nombre' => $this->nombre,
                ':descripcion' => $this->descripcion,
                ':precio' => $this->precio,
                ':stock' => $this->stock,
                ':oferta' => $this->oferta,
                ':fecha' => $this->fecha,
                ':imagen' => $this->imagen,
                ':id' => $this->id
            ]);
            
            $output = $this->baseDatos->getNumeroRegistros() == 1;

            $this->baseDatos->cerrarConexion();

            return $output;

        }

        public function delete(): bool {

            $this->baseDatos = new BaseDatos();

            $this->baseDatos->ejecutar("SELECT MAX(id) AS id FROM productos");

            $maxId = $this->baseDatos->getSiguienteRegistro();
            $maxId = $maxId ? $maxId['id'] : null;

            $this->baseDatos->ejecutar("DELETE FROM productos WHERE id = :id", [
                ':id' => $this->id
            ]);

            $output = $this->baseDatos->getNumeroRegistros() == 1;

            if ($output && $this->id == $maxId) {
                
                $this->baseDatos->ejecutar("SELECT MAX(id) AS id FROM productos");

                $nuevoMaxId = $this->baseDatos->getSiguienteRegistro();
                $nuevoMaxId = $nuevoMaxId ? $nuevoMaxId['id'] : 0;

                $nuevoAutoIncrement = $nuevoMaxId + 1; // Si la tabla está vacía, empieza en 1

                $this->baseDatos->ejecutar("ALTER TABLE productos AUTO_INCREMENT = :id", [
                    ':id' => $nuevoAutoIncrement
                ]);

            }

            $this->baseDatos->cerrarConexion();

            return $output;
            
        }

        /* MÉTODOS ESTÁTICOS */

        public static function getById(int $id): ?Producto {

            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("SELECT * FROM productos WHERE id = :id", [
                ':id' => $id
            ]);
        
            if ($baseDatos->getNumeroRegistros() == 1) {
        
                $registro = $baseDatos->getSiguienteRegistro();
        
                $producto = new Producto();
        
                $producto->setId($registro['id']);
                $producto->setCategoriaId($registro['categoria_id']);
                $producto->setNombre($registro['nombre']);
                $producto->setDescripcion($registro['descripcion']);
                $producto->setPrecio($registro['precio']);
                $producto->setStock($registro['stock']);
                $producto->setOferta($registro['oferta']);
                $producto->setFecha($registro['fecha']);
                $producto->setImagen($registro['imagen']);
        
                $baseDatos->cerrarConexion();

                return $producto;
        
            }

            $baseDatos->cerrarConexion();
        
            return null;

        }

        public static function getByCategoria(int $categoriaId): array {

            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("SELECT * FROM productos WHERE categoria_id = :categoria_id", [
                ':categoria_id' => $categoriaId
            ]);
        
            $registros = $baseDatos->getRegistros();
        
            $productos = [];
        
            foreach ($registros as $registro) {
        
                $producto = new Producto();
        
                $producto->setId($registro['id']);
                $producto->setCategoriaId($registro['categoria_id']);
                $producto->setNombre($registro['nombre']);
                $producto->setDescripcion($registro['descripcion']);
                $producto->setPrecio($registro['precio']);
                $producto->setStock($registro['stock']);
                $producto->setOferta($registro['oferta']);
                $producto->setFecha($registro['fecha']);
                $producto->setImagen($registro['imagen']);
        
                array_push($productos, $producto);
                
            }

            $baseDatos->cerrarConexion();
        
            return $productos;

        }

        public static function getAll(): array{

            $baseDatos = new BaseDatos();
            
            $baseDatos->ejecutar("SELECT * FROM productos");
        
            $registros = $baseDatos->getRegistros();

            $productos = [];
        
            foreach ($registros as $registro) {

                $producto = new Producto();

                $producto->setId($registro['id']);
                $producto->setCategoriaId($registro['categoria_id']);
                $producto->setNombre($registro['nombre']);
                $producto->setDescripcion($registro['descripcion']);
                $producto->setPrecio($registro['precio']);
                $producto->setStock($registro['stock']);
                $producto->setOferta($registro['oferta']);
                $producto->setFecha($registro['fecha']);
                $producto->setImagen($registro['imagen']);
        
                array_push($productos, $producto);
                
            }

            $baseDatos->cerrarConexion();
        
            return $productos;

        }
        
    }

?>