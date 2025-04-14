<?php

    /**
     * Modelo de las líneas de los pedidos.
     * 
     * Contiene los métodos:
     * save():          Guarda una línea de pedido en la base de datos.
     * delete():        Elimina una línea de pedido de la base de datos.
     * getByPedido():   Devuelve todas las líneas de un pedido de la base de datos por su id.
     * getByProducto(): Devuelve todas las líneas de un producto de la base de datos por su id.
     */

    namespace models;

    use lib\BaseDatos;

    class LineaPedido{

        private int $id;
        private int $pedidoId;
        private int $productoId;
        private int $unidades;

        /* GETTERS Y SETTERS */

        public function getId(): int{
            return $this->id;
        }

        public function getPedidoId(): int{
            return $this->pedidoId;
        }

        public function getProductoId(): int{
            return $this->productoId;
        }

        public function getUnidades(): int{
            return $this->unidades;
        }

        public function setId(int $id): void{
            $this->id = $id;
        }

        public function setPedidoId(int $pedidoId): void{
            $this->pedidoId = $pedidoId;
        }

        public function setProductoId(int $productoId): void{
            $this->productoId = $productoId;
        }

        public function setUnidades(string $unidades): void{
            $this->unidades = $unidades;
        }

        /* MÉTODOS DINÁMICOS */

        public function save(): bool{

            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("INSERT INTO lineas_pedidos(pedido_id, producto_id, unidades) VALUES(:pedido_id, :producto_id, :unidades)", [
                ':pedido_id' => $this->pedidoId,
                ':producto_id' => $this->productoId,
                ':unidades' => $this->unidades
            ]);

            if ($baseDatos->getNumeroRegistros() == 1) $this->setId($baseDatos->getUltimoId());
        
            $output = $baseDatos->getNumeroRegistros() == 1;

            $baseDatos->cerrarConexion();

            return $output;

        }

        public function delete(): bool {

            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("SELECT MAX(id) AS id FROM lineas_pedidos");

            $maxId = $baseDatos->getSiguienteRegistro();
            $maxId = $maxId ? $maxId['id'] : null;

            $baseDatos->ejecutar("DELETE FROM lineas_pedidos WHERE id = :id", [
                ':id' => $this->id
            ]);

            $output = $baseDatos->getNumeroRegistros() == 1;

            if ($output && $this->id == $maxId) {
                
                $baseDatos->ejecutar("SELECT MAX(id) AS id FROM lineas_pedidos");

                $nuevoMaxId = $baseDatos->getSiguienteRegistro();
                $nuevoMaxId = $nuevoMaxId ? $nuevoMaxId['id'] : 0;

                $nuevoAutoIncrement = $nuevoMaxId + 1; // Si la tabla está vacía, empieza en 1

                $baseDatos->ejecutar("ALTER TABLE lineas_pedidos AUTO_INCREMENT = $nuevoAutoIncrement");

            }

            $baseDatos->cerrarConexion();

            return $output;
            
        }

        /* MÉTODOS ESTÁTICOS */

        public static function getByPedido(int $pedidoId): array{

            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("SELECT * FROM lineas_pedidos WHERE pedido_id = :pedido_id", [
                ':pedido_id' => $pedidoId
            ]);

            $registros = $baseDatos->getRegistros();

            $lineas = [];

            foreach ($registros as $registro) {

                $linea = new LineaPedido();

                $linea->setId($registro['id']);
                $linea->setPedidoId($registro['pedido_id']);
                $linea->setProductoId($registro['producto_id']);
                $linea->setUnidades($registro['unidades']);

                array_push($lineas, $linea);
                
            }

            return $lineas;

        }

        public static function getByProducto(int $productoId): array{

            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("SELECT * FROM lineas_pedidos WHERE producto_id = :producto_id", [
                ':producto_id' => $productoId
            ]);

            $registros = $baseDatos->getRegistros();

            $lineas = [];

            foreach ($registros as $registro) {

                $linea = new LineaPedido();

                $linea->setId($registro['id']);
                $linea->setPedidoId($registro['pedido_id']);
                $linea->setProductoId($registro['producto_id']);
                $linea->setUnidades($registro['unidades']);

                array_push($lineas, $linea);
                
            }

            return $lineas;

        }

    }