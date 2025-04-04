<?php

    namespace controllers;

    use helpers\Utils;
    use models\Valoracion;

    class ValoracionController{

        public function guardar(){

            Utils::isIdentity();

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $usuarioId = $_SESSION['identity']['id'];
                $productoId = isset($_POST['producto_id']) ? $_POST['producto_id'] : false;
                $puntuacion = isset($_POST['puntuacion']) ? $_POST['puntuacion'] : false;
                $comentario = isset($_POST['comentario']) ? $_POST['comentario'] : false;
                $fecha = date('Y-m-d H:i:s');

                $_SESSION['form_data'] = [
                    'puntuacion' => $puntuacion,
                    'comentario' => $comentario
                ];

                if($usuarioId && $productoId && $puntuacion){

                    if($puntuacion < 1 || $puntuacion > 5){

                        $_SESSION['create'] = "failed_puntuacion";
                        header('Location:'.BASE_URL.'producto/ver&id='.$productoId.'#failed_puntuacion');
                        exit;

                    }

                    $valoracion = new Valoracion();
                    
                    $valoracion->setUsuarioId($usuarioId);
                    $valoracion->setProductoId($productoId);
                    $valoracion->setPuntuacion($puntuacion);
                    $valoracion->setComentario($comentario);
                    $valoracion->setFecha($fecha);

                    if($valoracion->save()){

                        Utils::deleteSession('form_data');

                        $_SESSION['create'] = "complete";
                        header('Location:'.BASE_URL.'producto/ver&id='.$productoId.'#complete');
                        exit;

                    }else{

                        $_SESSION['create'] = "failed_valoracion";
                        header('Location:'.BASE_URL.'producto/ver&id='.$productoId.'#failed_valoracion');
                        exit;

                    }

                }else{
                    
                    $_SESSION['create'] = "failed_valoracion";
                    header('Location:'.BASE_URL.'producto/ver&id='.$productoId.'#failed_valoracion');
                    exit;

                }

            }else{

                header('Location:'.BASE_URL);
                exit;

            }

        }

        public function eliminar(){

            Utils::isIdentity();

            if($_GET['id']){

                $id = $_GET['id']; 
                
                $valoracion = Valoracion::getById($id);

                if(!$valoracion){

                    $_SESSION['delete'] = "failed_noexiste";
                    header('Location:'.BASE_URL.'producto/ver&id='.$id.'#failed_noexiste');
                    exit;

                }

                if($valoracion->delete()){

                    $_SESSION['delete'] = "complete";
                    header('Location:'.BASE_URL.'producto/ver&id='.$id.'#complete');
                    exit;

                }else{

                    $_SESSION['delete'] = "failed_eliminar";
                    header('Location:'.BASE_URL.'producto/ver&id='.$id.'#failed_eliminar');
                    exit;

                }

            }else{

                header('Location:'.BASE_URL);
                exit;

            }

        }

    }

?>