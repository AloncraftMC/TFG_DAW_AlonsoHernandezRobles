<?php

    /**
     * Controlador de las páginas de información.
     * 
     * Contiene los métodos:
     * politicaPrivacidad():    Muestra la política de privacidad.
     * condicionesUso():        Muestra las condiciones de uso.
     * sobreNosotros():         Muestra la página sobre nosotros.
     */

    namespace controllers;

    class InfoController{

        /**
         * Método para mostrar la vista de política de privacidad.
         */

        public function politicaPrivacidad(): void{
            require_once "views/info/politica-privacidad.php";
        }

        /**
         * Método para mostrar la vista de condiciones de uso.
         */

        public function condicionesUso(): void{
            require_once "views/info/condiciones-uso.php";
        }

        /**
         * Método para mostrar la vista de sobre nosotros.
         */

        public function sobreNosotros(): void{
            require_once "views/info/sobre-nosotros.php";
        }

    }

?>