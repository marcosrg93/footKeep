<?php

class Controller {

    private $modelo, $sesion, $user = null;

    function __construct(Model $modelo) {
      
        $this->modelo = $modelo;
        $this->sesion = Session::getInstance('appNotas');
        if($this->sesion->isLogged()) {
            
            if($this->sesion->getUser()->getEmail()=='admin@admin'){
                //ADMIN
                $this->modelo->addData('titulo','Footkeep-Admin'); //Titulo de la pagina
                $this->modelo->addFile('archivo-notas', '/admin/admin.html');
                $this->modelo->addFile('contenido', 'admin/lista-usuarios.html');
                $this->modelo->addFile('archivo-acceso', '');
            }else{
                //USUARIO
                $this->modelo->addData('titulo','Footkeep'); //Titulo de la pagina
                $this->modelo->addFile('archivo-notas', 'logged/notas.html');
                $this->modelo->addFile('contenido', 'logged/lista.html');
                $this->modelo->addFile('nav-user', 'logged/nav-user.html');
                $this->modelo->addFile('fab-user', 'logged/fab-user.html');
                $this->modelo->addFile('archivo-acceso', '');
            }

        }else{
         $this->modelo->addData('titulo','Iniciar Sesión'); //Titulo de la pagina
         $this->modelo->addFile('archivo-acceso', 'login.html');
         $this->modelo->addFile('contenido', '');
         $this->modelo->addFile('nav-user', '');
         $this->modelo->addFile('fab-user', '');
         $this->modelo->addFile('archivo-notas', ''); 
        }
   
    }
    
    function getModel() {
        return $this->modelo;
    }
    
    function getSession() {
        return $this->sesion;
    }
    
    function getUser() {
        return $this->user;
    }
    

    /* acciones */

    function main() {
        $login = Request::read('op');
        $r = Request::read('r');
        
        if($login === 'login' && $r === '1'){                                                                                                                                                      
            $texto = Util::renderFile('templates/materialize/login.html', $this->modelo->getData());
            //$this->modelo->addFile('mensaje', 'mensaje-login.html');
        }
        $this->modelo->addData('contenido', '');
        
        /*si al ejecutar el programa existe el archivo centinela en el raiz entra*/
        $nombre_fichero = 'centinela';
        if(file_exists($nombre_fichero)){
            /*la app es nueva tenemos que crear un usuario administrador */
            
            $this->crearAdmin();
            /*contraseña :admin email:admin@admin*/
        }
        /* perfecto si existe centinela crea admin */
         if($this->sesion->isLogged()) {
              if($this->sesion->getUser()->getEmail()=='admin@admin'){
                 //https://keep-marcosrg.c9users.io/index.php?ruta=admin&accion=verusuarios
                 header('Location: index.php?ruta=admin&accion=verusuarios');
                 exit();
             }else {
                 header('Location: index.php?ruta=notas&accion=refrescarNota');
                 exit();
             }
           
         }
         
          if($op == 'imagen') {
            $this->modelo->addFile('archivo-mensaje', $this->carpeta . 'mensaje');
            if($r=='0') {
                $this->modelo->addData('mensaje', 'El archivo no se ha podido subir.');
            } else {
                $this->modelo->addData('mensaje', 'El archivo se ha subido correctamente.');
            }
        }
        
    }
    
    //Crea el usuario Admin para una primera instalación de la app
    function crearAdmin(){
        //Creamos el Usuario admin
        $usuario = new Usuario();
        $usuario->setNombre('admin');
        $usuario->setEmail('admin@admin');
        date_default_timezone_set('Europe/Madrid');
        $usuario->setFalta(date('Y-m-d'));
        $usuario->setTipo('administrador');
        $usuario->setEstado(1);
        //Encriptamos su contraseña
        $usuario->setPassword(Util::encriptar('admin'));
        $gestor = new GestorUsuario();
        $gestor->add($usuario);
        //Borramos el archivo centinela para que nos deje e entrar y no nos cree otro admin
        unlink('centinela');
    }
    
    
}