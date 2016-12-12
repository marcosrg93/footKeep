<?php

class GestorColor{
    
    const TABLA = 'color';
    private $db;

    function __construct() {
        $this->db = new DataBase();
    }

    private static function _getCampos(Color $objeto) {
        $campos = $objeto->get();
        return $campos;
    }

//para modificar el color
    function save(Color $objeto) {
        $campos = $this->_getCampos($objeto);
        return $this->db->updateParameters(self::TABLA, $this->_getCampos($objeto), array('idcolor' => $objeto->getIdTipoNota()));
    }
    
   

}