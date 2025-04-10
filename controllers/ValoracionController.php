<?php

    namespace controllers;

    use helpers\Utils;
    use models\Producto;
    use models\Valoracion;
    use models\Usuario;

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

                if($valoracion->getUsuarioId() == $_SESSION['identity']['id'] || $_SESSION['identity']['rol'] == 'admin'){
 
                    // 1. Eliminamos la valoración (y punto y final)

                    if($valoracion->delete()){

                        if($_SESSION['identity']['rol'] == 'admin' && $_SESSION['identity']['id'] != $valoracion->getUsuarioId()){

                            $usuario = Usuario::getById($valoracion->getUsuarioId());

                            Utils::enviarCorreo($usuario, "Valoración eliminada", BASE_URL."mails/valoracion/eliminar.html", [
                                "USERNAME" => $usuario->getNombre(),
                                "PRODUCTO_ID" => $valoracion->getProductoId(),
                                "PRODUCTO_NOMBRE" => Producto::getById($valoracion->getProductoId())->getNombre(),
                                "VALORACION" => str_repeat('⭐', $valoracion->getPuntuacion()),
                                "COMENTARIO" => $valoracion->getComentario(),
                                "FECHA" => date('d/m/Y', strtotime($valoracion->getFecha())),
                                "HORA" => date('H:i:s', strtotime($valoracion->getFecha())),
                                "COMENTARIO" => $valoracion->getComentario(),
                            ], [
                                [
                                    'ruta' => __DIR__ . '/../assets/images/uploads/usuarios/' . $usuario->getImagen(),
                                    'cid' => 'user',
                                    'nombre' => $usuario->getNombre() . ' ' . $usuario->getApellidos()
                                ]
                            ]);

                        }

                        $_SESSION['delete'] = "complete";
                        header('Location:'.BASE_URL.'producto/ver&id='.$valoracion->getProductoId().'#complete');
                        exit;

                    }else{

                        $_SESSION['delete'] = "failed_eliminar";
                        header('Location:'.BASE_URL.'producto/ver&id='.$valoracion->getProductoId().'#failed');
                        exit;

                    }

                }else{

                    header("Location:".BASE_URL);
                    exit;

                }

            }else{

                header('Location:'.BASE_URL);
                exit;

            }

        }

    }

?>