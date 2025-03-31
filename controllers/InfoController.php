<?php

    namespace controllers;

    class InfoController{

        public function politicaPrivacidad(): void{
            require_once "views/info/politica-privacidad.php";
        }

        public function condicionesUso(): void{
            require_once "views/info/condiciones-uso.php";
        }

        public function sobreNosotros(): void{
            require_once "views/info/sobre-nosotros.php";
        }

    }

?>