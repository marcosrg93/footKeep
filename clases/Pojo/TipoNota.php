<?php


class tipoNota {
     private $idTipoNota,$tipo,$titulo,$texto,$url,$video,$orden;
     
     function __construct($idTipoNota = null , $tipo = null, $titulo = null , $texto = null, $url = null,$video = null, $orden = null) {
         $this->idTipoNota = $idTipoNota;
         $this->tipo = $tipo;
         $this->titulo = $titulo;
         $this->texto = $texto;
         $this->url = $url;
         $this->video = $video;
         $this->orden = $orden;
     }
     function getIdTipoNota() {
         return $this->idTipoNota;
     }

     function getTipo() {
         return $this->tipo;
     }

     function getTitulo() {
         return $this->titulo;
     }

     function getTexto() {
         return $this->texto;
     }

     function getUrl() {
         return $this->url;
     }
     
     function getVideo() {
         return $this->video;
     }

     function getOrden() {
         return $this->orden;
     }

     function setIdTipoNota($idTipoNota) {
         $this->idTipoNota = $idTipoNota;
     }

     function setTipo($tipo) {
         $this->tipo = $tipo;
     }

     function setTitulo($titulo) {
         $this->titulo = $titulo;
     }

     function setTexto($texto) {
         $this->texto = $texto;
     }

     function setUrl($url) {
         $this->url = $url;
     }
      function setVideo($video) {
         $this->video = $video;
     }
      function setOrden($orden) {
         $this->orden = $orden;
     }
  
     



      function __toString() {
        $r = '';
        foreach($this as $key => $valor) {
            $r .= "$key => $valor - ";
        }
        return $r;
    }
    
    function read(ObjectReader $reader = null){
        if($reader===null){
            $reader = 'Request';
        }
        foreach($this as $key => $valor) {
            $this->$key = $reader::read($key);
        }
    }
    
    function get(){
        $nuevoArray = array();
        foreach($this as $key => $valor) {
            $nuevoArray[$key] = $valor;
        }
        return $nuevoArray;
    }
    
 
    function set(array $array, $inicio = 0) {
        $this->idTipoNota = $array[0 + $inicio];
        $this->tipo = $array[1 + $inicio];
        $this->titulo = $array[2 + $inicio];
        $this->texto = $array[3 + $inicio];
        $this->url = $array[4 + $inicio];
        $this->video = $array[5 + $inicio];
        $this->orden = $array[6 + $inicio];
    }
   
    
}
