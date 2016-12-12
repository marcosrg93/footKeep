<?php

class ControllerUsuario extends Controller {
   
    function doinsert() {
        $usuario = new Usuario();
        $usuario->read();
        $clave2 = Request::read('password2');
        $r = 0;
     
        if($usuario->isValid() && $usuario->getPassword() === $clave2) {
            
                if( $this->existUser($usuario->getEmail())){
                    header('Location: index.php?op=insert&r=' . $r . '&enviado=EmailRepe');
                }else {
                     $r = $this->getModel()->insertUsuario($usuario);
                     var_dump($r);
                    if($r===1){
               
                              $usuarioBD = $this->getModel()->getUsuario($usuario->getEmail());
                              var_dump($usuarioBD->getIdUsuario());
                              $enlace ='https://keep-marcosrg.c9users.io/index.php?ruta=usuario&accion=activacion&email='
                                 .$usuario->getEmail().'&param='.sha1($usuarioBD->getIdUsuario().Constantes::SECRET);
                              $enviado = Util::enviarCorreos($usuario->getEmail(),'Correo de Activacion',$enlace);
                              var_dump($enviado);
                             if($enviado){
                              header('Location: index.php?op=insert&r=' . $r . '&enviado='.$enviado);
                              exit();
                            }
                    }
                }
            
            
            
        }
        //header('Location: index.php?op=insert&r=' . $r);
        exit();
        
        
        /*var_dump($usuario);
        echo 'fin';
        exit();para que se pare y ver que pasa para ver el error*/
        
    }
    
    function dologin() {
        $usuarioWeb = new Usuario();
        $usuarioWeb->read();
        $usuarioBD = $this->getModel()->getUsuario($usuarioWeb->getEmail());
        $cont=Request::read('password');
        
        if($usuarioWeb->getEmail() === $usuarioBD->getEmail()){
            // echo '</br>';
            // echo 'Entro';
            // var_dump($usuarioWeb->getPassword());
            // echo '</br>';
            // var_dump($usuarioBD->getPassword());
            // echo '</br> Hashhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh </br>';
            //  var_dump(Util::verificarClave($usuarioWeb->getPassword(), $usuarioBD->getPassword()));
            if($usuarioBD->getEstado()==="1"){
                if(Util::verificarClave($usuarioWeb->getPassword(), $usuarioBD->getPassword())) {
                    
                    
                    
                    $this->getSession()->setUser($usuarioBD);
                    if($usuarioBD->getTipo()==="administrador"){
                        header('Location: index.php?ruta=admin&accion=verusuarios');
                        exit();  
                    }else{
                    header('Location: index.php?ruta=notas&accion=refrescarNota');
                    exit();
                    }
                }
            }else{
                 header('Location: index.php?op=login&r=0&NoActiva');
                 var_dump($usuarioBD->getEstado());
                 exit();
            }
        }
        $this->getSession()->destroy();
        header('Location: index.php?op=login&r=0');
        exit();
    }
    
    
    function cerrarCession(){
         $this->getSession()->destroy();
         header('Location: index.php');
    }
    
     function activacion(){
        $usuarioWeb = new Usuario();
        $usuarioWeb->read();
        //Obtenemos los datos desde la url
        $idWeb=Request::read('param');
         //Buscamos en la Bd el usuario por el email
        $usuarioBD = $this->getModel()->getUsuario($usuarioWeb->getEmail());
        var_dump($usuarioBD->getEstado());
        if($usuarioBD->getEstado()=== "0"){
            $cont=sha1($usuarioBD->getIdUsuario().Constantes::SECRET);
            var_dump($idBD);
            if($idWeb===$cont){
                //activamos
              
                $usuarioBD ->setEstado(1);
                
                var_dump($usuarioBD);
                echo "</br>Despues";
                var_dump($usuarioWeb->getEmail());
                $r = $this->getModel()->editUsuario($usuarioBD ,$usuarioWeb->getEmail());
               
                header('Location: index.php?op=login&r=1');
                exit();
            }else {
                     header('Location: index.php?op=login&r=0&Idmal');
            }
        }else {
                 header('Location: index.php?op=login&r=0&yaestaActivado');
        }
     }

     function existUser($email){
          $exist = false;
          $emailBD = $this->getModel()->getUsuario($email);
          if($emailBD === $email){
            $exist = true;
          }
          return $exist;
     }
     
     function editarusuariodatos(){
         
         $nombre=Request::read('nombre');
         $email=Request::read('email');
         $passwordActual=Request::read('passwordActual');
         $passwordNueva=Request::read('passwordNueva');
         $passwordNuevaCopia=Request::read('passwordNuevaCopia');
     
         $session = $this->getSession()->getUser();
          //buscamos el email porque el que llega puede estar cambiado
         $usuarioBD = $this->getModel()->getUsuario($session->getEmail());
   
        
            if(Util::verificarClave($passwordActual, $usuarioBD->getPassword())) {
               //contraseña correcta comprobamos que las nuevas sean iguales
               if($passwordNueva === $passwordNuevaCopia){
                  //encriptamos contraseña
                  $contrasena=Util::encriptar($passwordNueva);
                  $usuarioBD->setNombre($nombre);
                  $usuarioBD->setEmail($email);
                  $usuarioBD->setPassword($contrasena);
                  var_dump($usuarioBD);
                   
                   $res =  $this->getModel()->editUsuario($usuarioBD,$session->getEmail());
                   
                     //refrescar cooki usuario para que actualice los cambios
                    $this->getSession()->setUser($usuarioBD);
                    header('Location: index.php?ruta=notas&accion=refrescarNota');
                    
                  }else{
                      header('Location: index.php?ruta=notas&accion=refrescarNota#modal16');
                  }
              
              }
     }
     
     
     /*------------------------------zona de adminitrador----------------------*/
      function verusuarios(){
         $listaUsuarios = array();
        //Pasamos el array con todas las notas para sacar el tipo notas mediante el IdTipoNota
         $listaUsuarios=$this->getModel()->obtenerListaUsuarios();
         // var_dump($listaUsuarios);
         $session = $this->getSession()->getUser();
        //Pasamos el array con todas las notas para sacar el tipo notas mediante el IdTipoNota
         $usuario = $this->getModel()->getUsuario($session->getEmail());
        // var_dump($listaUsuarios);
         //Devuelve la plantilla de notas
         $this->getModel()->addData('usuario', $usuario);
         //Devuelve la plantilla de notas
         $this->getModel()->addData('lista-Usuario', $listaUsuarios);
      }
      
   
    function eliminarusuario(){
        $idUsuario = Request::read('idUsuario');
         //echo $idUsuario;
        $res = $this->getModel()->deleteUsuario($idUsuario);
        header('Location: index.php?ruta=admin&accion=verusuarios');
     }
     
     
     function cambiarEstado(){
         $emailUsuario = Request::read('email');
         $usuarioBD = $this->getModel()->getUsuario($emailUsuario);
         if($usuarioBD->getEstado()==1){
            $usuarioBD->setEstado(0);    
         }else if($usuarioBD->getEstado()== 0) {
             $usuarioBD->setEstado(1);
         }
         
         $r = $this->getModel()->editUsuario($usuarioBD ,$emailUsuario);
         header('Location: index.php?ruta=admin&accion=verusuarios');
         
     }

     function getSesionUsuario(){
         $session = $this->getSession();
        //Pasamos el array con todas las notas para sacar el tipo notas mediante el IdTipoNota
         $usuario = $this->getModel()->getUsuario($session->getEmail());
        // var_dump($listaUsuarios);
         //Devuelve la plantilla de notas
         $this->getModel()->addData('usuario', $usuario);
     }
     
     function editaradmin(){
         $nombre=Request::read('nombre');
         $email=Request::read('email');
         $passwordActual=Request::read('passwordActual');
         $passwordNueva=Request::read('passwordNueva');
         $passwordNuevaCopia=Request::read('passwordNuevaCopia');
         
         /*comprobamos que la contraseña  actual coincide*/
          $session = $this->getSession()->getUser();
          //buscamos el email porque el que llega puede estar cambiado
         $usuarioBD = $this->getModel()->getUsuario($session->getEmail());
   
            if(Util::verificarClave($passwordActual, $usuarioBD->getPassword())) {
               //contraseña correcta comprobamos que las nuevas sean iguales
               if($passwordNueva === $passwordNuevaCopia){
                  //encriptamos contraseña
                  $contrasena=Util::encriptar($passwordNueva);
                  $usuarioBD->setNombre($nombre);
                  $usuarioBD->setEmail($email);
                  $usuarioBD->setPassword($contrasena);
                   
                   $res =  $this->getModel()->editUsuario($usuarioBD,$session->getEmail());
                                //refrescar cooki admin para que actualice los cambios
                    $this->getSession()->setUser($usuarioBD);
                    header('Location: index.php?ruta=admin&accion=verusuarios');
                  }
              
              }
       
     }
     
     function insertaradmin(){
         $nombre=Request::read('nombre');
         $email=Request::read('email');
         $password=Request::read('password');
         $password2=Request::read('password2');
         $usuario = new Usuario();
         
         /*comprobamos que las contraseñas son iguales y insertamos el usuario*/
         if($password === $password2){
           $usuario->setNombre($nombre);
           $usuario->setEmail($email);
           $usuario->setPassword($passwordActual);
           $r = $this->getModel()->insertUsuarioAdmin($usuario);
         }
     }
     
}