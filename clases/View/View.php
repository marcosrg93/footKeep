
<?php

class View {

    private $modelo;
    
   /* private vistas = array(
        "main" => array("")
        );*/

    function __construct(Model $modelo) {
        $this->modelo = $modelo;
    }

    function getModel() {
        return $this->modelo;
    }
    
    function getRender(){
         return $this->render;
    }
    

    function render2() {
        $plantilla = './templates/materialize';
        $this->getModel()->addData('plantilla', $plantilla);
        $data = $this->getModel()->getData();
        $vista = $data["vista"];
        
        $archivos = $this->getModel()->getFiles();
        foreach($archivos as $placeholder => $archivo) {
            $this->getModel()->addData($placeholder, 
                Util::renderFile($plantilla . '/' . $archivo, $this->getModel()->getData()));
        }
        //Vista de usuarios
        $this->renderNotas();
        
        return Util::renderFile($plantilla . '/index.html', $this->getModel()->getData());
    }
    
    function render() {
        $plantilla = './templates/materialize';
        $this->getModel()->addData('plantilla', $plantilla);
        $archivos = $this->getModel()->getFiles();
        foreach($archivos as $placeholder => $archivo) {
            $this->getModel()->addData($placeholder, 
                Util::renderFile($plantilla . '/' . $archivo, $this->getModel()->getData()));
        }
        
        
        //Vista de usuarios
        $this->renderNotas();
       
        
        return Util::renderFile($plantilla . '/index.html', $this->getModel()->getData());
    }
    
    
    //Devuelve la vista de las notas
    function renderNotas(){
        $datos = $this->getModel()->getData();
        
    
       
        //Si tiene la lista de usuarios la muestra
        if(isset($datos['lista-nota'])){
             if(isset($datos['nota'])){
             //Si tiene la lista de usuarios la muestra
             if(isset($datos['usuario'])){
                     $sessionUser = $datos['usuario'];
                     $email =  $sessionUser->getEmail();
                     $nombre =   $sessionUser->getNombre();
                     $hora =  date("Y-m-d");
            }
     
            
             $r = '';
            $lista= $datos['lista-nota'];
            $notas= $datos['nota'];
            $pos = 0;
            foreach ($lista as $tiponota) {
                  
             if($tiponota->getTipo() === 'texto'){
                 // falta 'idColor'=>$notas->getIdColor() para eso hace falta recorrer tmb el array $notas
                 $r .= Util::renderFile( 'templates/materialize/logged/lista-notas.html', 
                        array('idcolor'=>$notas[$pos]->getIdColor(),'titulo'=> $tiponota->getTitulo(),'texto'=>$tiponota->getTexto(), 'idtiponota'=>$tiponota->getIdTipoNota())); 
             }else if($tiponota->getTipo() === 'imagen'){
              $r .= Util::renderFile( 'templates/materialize/logged/lista-img.html', 
                        array('idcolor'=>$notas[$pos]->getIdColor(),'titulo'=> $tiponota->getTitulo(),'texto'=>$tiponota->getTexto(),
                        'url'=>'<img class="materialboxed" width="10"  src="data:image/jpeg;base64,'.base64_encode($tiponota->getUrl()).'" />',
                        'idtiponota'=>$tiponota->getIdTipoNota()));
             }
             else if($tiponota->getTipo() === 'video'){
              $r .= Util::renderFile( 'templates/materialize/logged/lista-video.html', 
                        array('idcolor'=>$notas[$pos]->getIdColor(),'titulo'=> $tiponota->getTitulo(),'texto'=>$tiponota->getTexto(),'idtiponota'=>$tiponota->getIdTipoNota(),'video'=>'
                                <source src="ver.php?mime=mp4&archivo=./videos/'.$tiponota->getVideo().'" type="video/mp4">' ));
             }
              $pos++;
            }
            
            
            $this->getModel()->addData('usuario-nombre', $nombre);
            $this->getModel()->addData('usuario-email', $email);
            $this->getModel()->addData('hora', $hora);
            $this->getModel()->addData('lista-nota', $r);
            $table = Util::renderFile('templates/materialize/logged/lista.html', $this->getModel()->getData());
            $this->getModel()->addData('contenido', $table);
         }
        }
        
    }
 
   
}