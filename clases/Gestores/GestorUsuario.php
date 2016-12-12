<?php

class Gestorusuario {
    
    const TABLA = 'usuario';
    private $db;

    function __construct() {
        $this->db = new DataBase();
    }

    private static function _getCampos(Usuario $objeto) {
        $campos = $objeto->get();
        return $campos;
    }

    function add(Usuario $objeto) {
        return $this->db->insertParameters(self::TABLA, self::_getCampos($objeto), false);
    }
    
    function delete($id) {
        return $this->db->deleteParameters(self::TABLA, array('idUsuario' => $id));
    }

    function get($id) {
        $this->db->getCursorParameters(self::TABLA, '*', array('email' => $id));
        if ($fila = $this->db->getRow()) {
            $objeto = new Usuario();
            $objeto->set($fila);
            return $objeto;
        }
    }

    function getList() {
        $this->db->getCursorParameters(self::TABLA);
        $respuesta = array();
        while ($fila = $this->db->getRow()) {
            $objeto = new Usuario();
            $objeto->set($fila);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }

    function save(Usuario $objeto, $correopk) {
        $campos = $this->_getCampos($objeto);
        unset($campos['falta']);
        if($objeto->getPassword() === null || $objeto->getPassword() === ''){
            unset($campos['password']);
        }
        return $this->db->updateParameters(self::TABLA, $campos, array('email' => $correopk));
        //return $this->db->updateParameters(self::TABLA, $this->_getCampos($objeto), array('email' => $correopk));
    }
    
    function saveUsuario(Usuario $objeto, $correopk) {
        $campos = $this->_getCampos($objeto);
        unset($campos['tipo']);
        unset($campos['falta']);
        if($objeto->getPassword() === null || $objeto->getPassword() === ''){
            unset($campos['password']);
        }
        return $this->db->updateParameters(self::TABLA, $campos, array('email' => $correopk));
    }

}