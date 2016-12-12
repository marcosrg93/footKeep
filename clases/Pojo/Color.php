<?php


class Color {
    
    private $idColor, $color, $descripcion;
    
    
    function __construct($idColor = null, $color = null, $descripcion = null) {
         $this->idcolor = $idColor;
         $this->color = $color;
         $this->descripcion = $descripcion;
     }
    function getIdColor() {
         return $this->idColor;
     }

     function getColor() {
         return $this->color;
     }

     function getDescripcion() {
         return $this->descripcion;
     }

     function setIdColor($idColor) {
         $this->idColor = $idColor;
     }

     function setColor($color) {
         $this->color = $color;
     }

     function setDescripcion($descripcion) {
         $this->descripcion = $descripcion;
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
        $this->idcolor = $array[0 + $inicio];
        $this->color = $array[1 + $inicio];
        $this->descripcion = $array[2 + $inicio];
    }
    
   

    
}