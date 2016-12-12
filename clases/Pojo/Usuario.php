<?php

class Usuario {
    
    private $idUsuario,$email, $password, $falta, $tipo, $estado, $nombre;
    
    function __construct($idUsuario= null, $email = null, $password = null, $falta = null, $tipo = null, $estado = null, $nombre = null) {
        $this->idUsuario = $idUsuario;
        $this->email = $email;
        $this->password = $password;
        $this->falta = $falta;
        $this->tipo = $tipo;
        $this->estado = $estado;
        $this->nombre = $nombre;
    }
     function getIdUsuario() {
        return $this->idUsuario;
    }

    function getEmail() {
        return $this->email;
    }
    function getNombre() {
        return $this->nombre;
    }
    
    function getPassword() {
        return $this->password;
    }

    function getFalta() {
        return $this->falta;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getEstado() {
        return $this->estado;
    }

    function setEmail($email) {
        $this->email = $email;
    }
    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }
     function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    function setPassword($password) {
      
        $this->password = $password;
    }

    function setFalta($falta) {
        $this->falta = $falta;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setEstado($estado) {
        $this->estado = $estado;
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
        $this->idUsuario = $array[0 + $inicio];
        $this->email = $array[1 + $inicio];
        $this->password = $array[2 + $inicio];
        $this->falta = $array[3 + $inicio];
        $this->tipo = $array[4 + $inicio];
        $this->estado = $array[5 + $inicio];
        $this->nombre = $array[6 + $inicio];
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
    
    function isValid() {
        if($this->email === null || $this->password === null){
            return false;
        }
        return true;
    }

}