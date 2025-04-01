<?php

    namespace models;

    use lib\BaseDatos;

    class Pedido{

        private int $id;
        private int $usuarioId;
        private string $provincia;
        private string $localidad;
        private string $direccion;
        private float $coste;
        private string $estado;
        private string $fecha;
        private string $hora;

        public function __construct(){
        }

        /* GETTERS Y SETTERS */

        public function getId(): int{
            return $this->id;
        }

        public function getUsuarioId(): int{
            return $this->usuarioId;
        }

        public function getProvincia(): string{
            return $this->provincia;
        }

        public function getLocalidad(): string{
            return $this->localidad;
        }

        public function getDireccion(): string{
            return $this->direccion;
        }

        public function getCoste(): float{
            return $this->coste;
        }

        public function getEstado(): string{
            return $this->estado;
        }

        public function getFecha(): string{
            return $this->fecha;
        }

        public function getHora(): string{
            return $this->hora;
        }

        public function setId(int $id): void{
            $this->id = $id;
        }

        public function setUsuarioId(int $usuarioId): void{
            $this->usuarioId = $usuarioId;
        }

        public function setProvincia(string $provincia): void{
            $this->provincia = $provincia;
        }

        public function setLocalidad(string $localidad): void{
            $this->localidad = $localidad;
        }

        public function setDireccion(string $direccion): void{
            $this->direccion = $direccion;
        }

        public function setCoste(float $coste): void{
            $this->coste = $coste;
        }

        public function setEstado(string $estado): void{
            $this->estado = $estado;
        }

        public function setFecha(string $fecha): void{
            $this->fecha = $fecha;
        }

        public function setHora(string $hora): void{
            $this->hora = $hora;
        }

        /* MÉTODOS DINÁMICOS */

        public function save(): bool{

            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("INSERT INTO pedidos(usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora) VALUES(:usuario_id, :provincia, :localidad, :direccion, :coste, :estado, :fecha, :hora)", [
                ':usuario_id' => $this->usuarioId,
                ':provincia' => $this->provincia,
                ':localidad' => $this->localidad,
                ':direccion' => $this->direccion,
                ':coste' => $this->coste,
                ':estado' => $this->estado,
                ':fecha' => $this->fecha,
                ':hora' => $this->hora
            ]);

            if ($baseDatos->getNumeroRegistros() == 1) $this->setId($baseDatos->getUltimoId());
        
            $output = $baseDatos->getNumeroRegistros() == 1;

            $baseDatos->cerrarConexion();

            return $output;

        }

        public function update(): bool{

            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("UPDATE pedidos SET usuario_id = :usuario_id, provincia = :provincia, localidad = :localidad, direccion = :direccion, coste = :coste, estado = :estado, fecha = :fecha, hora = :hora WHERE id = :id", [
                ':id' => $this->id,
                ':usuario_id' => $this->usuarioId,
                ':provincia' => $this->provincia,
                ':localidad' => $this->localidad,
                ':direccion' => $this->direccion,
                ':coste' => $this->coste,
                ':estado' => $this->estado,
                ':fecha' => $this->fecha,
                ':hora' => $this->hora
            ]);

            $output = $baseDatos->getNumeroRegistros() == 1;

            $baseDatos->cerrarConexion();

            return $output;

        }

        public function delete(): bool {

            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("SELECT MAX(id) AS id FROM pedidos");

            $maxId = $baseDatos->getSiguienteRegistro();
            $maxId = $maxId ? $maxId['id'] : null;

            $baseDatos->ejecutar("DELETE FROM pedidos WHERE id = :id", [
                ':id' => $this->id
            ]);

            $output = $baseDatos->getNumeroRegistros() == 1;

            if ($output && $this->id == $maxId) {
                
                $baseDatos->ejecutar("SELECT MAX(id) AS id FROM pedidos");

                $nuevoMaxId = $baseDatos->getSiguienteRegistro();
                $nuevoMaxId = $nuevoMaxId ? $nuevoMaxId['id'] : 0;

                $nuevoAutoIncrement = $nuevoMaxId + 1; // Si la tabla está vacía, empieza en 1

                $baseDatos->ejecutar("ALTER TABLE pedidos AUTO_INCREMENT = $nuevoAutoIncrement");

            }

            $baseDatos->cerrarConexion();

            return $output;
            
        }

        /* MÉTODOS ESTÁTICOS */

        public static function getById(int $id): ?Pedido{

            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("SELECT * FROM pedidos WHERE id = :id", [
                ':id' => $id
            ]);

            if($baseDatos->getNumeroRegistros() == 1){

                $registro = $baseDatos->getSiguienteRegistro();

                $pedido = new Pedido();

                $pedido->setId($registro['id']);
                $pedido->setUsuarioId($registro['usuario_id']);
                $pedido->setProvincia($registro['provincia']);
                $pedido->setLocalidad($registro['localidad']);
                $pedido->setDireccion($registro['direccion']);
                $pedido->setCoste($registro['coste']);
                $pedido->setEstado($registro['estado']);
                $pedido->setFecha($registro['fecha']);
                $pedido->setHora($registro['hora']);

                return $pedido;

            }
            
            $baseDatos->cerrarConexion();

            return null;

        }

        public static function getByUsuario(int $usuarioId): array{
            
            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("SELECT * FROM pedidos WHERE usuario_id = :usuario_id", [
                ':usuario_id' => $usuarioId
            ]);

            $registros = $baseDatos->getRegistros();

            $pedidos = [];

            foreach ($registros as $registro) {

                $pedido = new Pedido();

                $pedido->setId($registro['id']);
                $pedido->setUsuarioId($registro['usuario_id']);
                $pedido->setProvincia($registro['provincia']);
                $pedido->setLocalidad($registro['localidad']);
                $pedido->setDireccion($registro['direccion']);
                $pedido->setCoste($registro['coste']);
                $pedido->setEstado($registro['estado']);
                $pedido->setFecha($registro['fecha']);
                $pedido->setHora($registro['hora']);

                array_push($pedidos, $pedido);
                
            }

            return $pedidos;

        }

        public static function getAll(): array{
            
            $baseDatos = new BaseDatos();

            $baseDatos->ejecutar("SELECT * FROM pedidos");

            $registros = $baseDatos->getRegistros();

            $pedidos = [];

            foreach ($registros as $registro) {

                $pedido = new Pedido();

                $pedido->setId($registro['id']);
                $pedido->setUsuarioId($registro['usuario_id']);
                $pedido->setProvincia($registro['provincia']);
                $pedido->setLocalidad($registro['localidad']);
                $pedido->setDireccion($registro['direccion']);
                $pedido->setCoste($registro['coste']);
                $pedido->setEstado($registro['estado']);
                $pedido->setFecha($registro['fecha']);
                $pedido->setHora($registro['hora']);

                array_push($pedidos, $pedido);
                
            }

            $baseDatos->cerrarConexion();

            return $pedidos;

        }

    }