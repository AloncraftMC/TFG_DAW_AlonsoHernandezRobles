<?php

    namespace controllers;

    class ErrorController{

        public function index(): void{
            echo "<script>document.title = 'Página no encontrada';</script>";
            echo "<h1>La página que buscas no existe.</h1>";
            echo "<h1 style=\"font-size: 500%\">:(</h1>";
            echo "<a href='".BASE_URL."'><button class=\"boton\">Volver a la tienda</button></a>";
        }
        
    }

?>