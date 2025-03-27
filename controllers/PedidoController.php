<?php

    namespace controllers;

    use helpers\Utils;

    class PedidoController{

        public function admin(){ // ✔

            Utils::isAdmin();
            require_once 'views/pedido/admin.php';

        }

        public function crear(){
            
            Utils::isIdentity();

            if(!isset($_SESSION['carrito']) || Utils::statsCarrito()['count'] == 0){
                header('Location: '.BASE_URL);
                exit;
            }

            require_once 'views/pedido/crear.php';
        }

        public function hacer(){

            Utils::isIdentity();

            if(!isset($_SESSION['carrito']) || Utils::statsCarrito()['count'] == 0){
                header('Location: '.BASE_URL);
                exit;
            }

            /* ME NIEGO A IMPLEMENTAR EL RESTO DE ESTA FUNCIONALIDAD */
            header('Location: '.BASE_URL.'pedido/listo');

        }

        public function listo(){ // ✔

            Utils::isIdentity();

            if(!isset($_SESSION['carrito']) || Utils::statsCarrito()['count'] == 0){
                header('Location: '.BASE_URL);
                exit;
            }

            Utils::deleteSession('carrito');
            Utils::deleteCookieCarrito();
            
            require_once 'views/pedido/listo.php';
        
        }

        public function ver(){ // ✔
            Utils::isAdmin();
            require_once 'views/pedido/ver.php';
        }

        public function confirmar(){
            Utils::isAdmin(); /* ME NIEGO A IMPLEMENTAR ESTA FUNCIONALIDAD */
        }
        public function eliminar(){
            Utils::isAdmin(); /* ME NIEGO A IMPLEMENTAR ESTA FUNCIONALIDAD */
        }
        
    }

?>