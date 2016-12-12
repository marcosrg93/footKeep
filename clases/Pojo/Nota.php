<?php


class Nota {
    private $idNota,$idUsuario,$idTipoNota,$idColor,$fCreacion;
    
    function __construct($idNota = null, $idUsuario = null, $idTipoNota= null, $idColor = null, $fCreacion = null) {
        $this->idNota = $idNota;
        $this->idUsuario = $idUsuario;
        $this->idTipoNota = $idTipoNota;
        $this->idColor = $idColor;
        $this->fCreacion = $fCreacion;
    }
  
    function getIdNota() {
        return $this->idNota;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getIdTipoNota() {
        return $this->idTipoNota;
    }

    function getIdColor() {
        return $this->idColor;
    }

    function getFCreacion() {
        return $this->fCreacion;
    }

    function setIdNota($idNota) {
        $this->idNota = $idNota;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    function setIdTipoNota($idTipoNota) {
        $this->idTipoNota = $idTipoNota;
    }

    function setIdColor($idColor) {
        $this->idColor = $idColor;
    }

    function setFCreacion($fCreacion) {
        $this->fCreacion = $fCreacion;
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
        $this->idNota = $array[0 + $inicio];
        $this->idUsuario = $array[1 + $inicio];
        $this->idTipoNota = $array[2 + $inicio];
        $this->idColor = $array[3 + $inicio];
        $this->fCreacion = $array[4 + $inicio];
    }
    
    function getJSON(){
        $json = '{';
        foreach($this as $key => $value){
            $json .= '"'.$key.'":"'.$value.'",';   
        }
        $json = substr($json, 0, -1);
        $json .= '}';
        return $json;
    }

    
}
