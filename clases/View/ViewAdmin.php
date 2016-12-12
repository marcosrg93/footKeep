<?php

class ViewAdmin {

    private $modelo;

    function __construct(Model $modelo) {
        $this->modelo = $modelo;
    }

    function getModel() {
        return $this->modelo;
    }
    
    function getRender(){
         return $this->render;
    }
    

    function render() {
        $plantilla = './templates/materialize/';
        $this->getModel()->addData('plantilla', $plantilla);
        $archivos = $this->getModel()->getFiles();
        foreach($archivos as $placeholder => $archivo) {
            $this->getModel()->addData($placeholder, 
                Util::renderFile($plantilla . '/' . $archivo, $this->getModel()->getData()));
        }
        
        //Añadimos la estructura de la tabla
        $table = Util::renderFile($plantilla . '/admin/lista-usuarios.html', $this->getModel()->getData());
        $this->getModel()->addData('contenido', $table);
        //Vista de usuarios
        $this->renderUsuarios();
        
        return Util::renderFile($plantilla . '/admin/admin.html', $this->getModel()->getData());
    }
    
    
    //Devuelve la vista de las notas
    function renderUsuarios(){
        $base = './templates/materialize/admin';
        $datos = $this->getModel()->getData();
        //SELECT DISTINCT COUNT(`idUsuario`) FROM `nota` where `idUsuario` =2
       
      
        //Si tiene la lista de usuarios la muestra
        if(isset($datos['lista-Usuario'])){
            if(isset($datos['usuario'])){
              $sessionUser = $datos['usuario'];
                   $email =  $sessionUser->getEmail();
                   $nombre =   $sessionUser->getNombre();
             }
           
            $r = '';
          
            $lista= $datos['lista-Usuario'];
            $arrayTotal = array();
            // Util::renderFile($base . '/lista-usuarios.html', $this->getModel()->getData());
            foreach ($lista as $usuario) {
                
                 $arrayTotal = $this->getModel()->getNumNotas($usuario->getIdUsuario());
                 $total = count($arrayTotal);
 
                if($usuario->getEstado()==1){
                    $estado ="checked";
                }else{
                    $estado ="";
                }
              $r .= Util::renderFile( $base . '/usuario-table.html', 
                        array('id'=> $usuario->getIdUsuario(),'nombre'=>$usuario->getNombre(),'estado'=>$estado,
                        'email'=>$usuario->getEmail(),'totalNotas'=>$total));
            }
            Util::renderFile($base . '/usuario-table.html', $this->getModel()->getData());
            
            $this->getModel()->addData('usuario-table', $r);
            $this->getModel()->addData('usuario-email', $email);
            $this->getModel()->addData('usuario-nombre', $nombre);
            // $this->getModel()->addData('contenido', $r);
        }
       
    }
    
   
}
