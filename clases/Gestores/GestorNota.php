<?php

class GestorNota{
    
    const TABLA = 'nota';
    private $db;

    function __construct() {
        $this->db = new DataBase();
    }

    private static function _getCampos(Nota $objeto) {
        $campos = $objeto->get();
        return $campos;
    }

    function add(Nota $objeto) {
        return $this->db->insertParameters(self::TABLA, self::_getCampos($objeto), false);
    }
    
    function delete($id) {
        return $this->db->deleteParameters(self::TABLA, array('idTipoNota' => $id));
    }

    function get($id) {
        $this->db->getCursorParameters(self::TABLA, '*', array('idNota' => $id));
        if ($fila = $this->db->getRow()) {
            $objeto = new Nota();
            $objeto->set($fila);
            return $objeto;
        }
    }

    function getList() {
        $this->db->getCursorParameters(self::TABLA);
        $respuesta = array();
        while ($fila = $this->db->getRow()) {
            $objeto = new Nota();
            $objeto->set($fila);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }
    //nos devuelve las notas del usuario especifico
     function getNotasUsuario($idUsuario) {
         
        $this->db->getCursorParameters(self::TABLA,'*', array('idUsuario' => $idUsuario));
        $respuesta = array();
        while ($fila = $this->db->getRow()) {
            $objeto = new Nota();
            $objeto->set($fila);
            $respuesta[] = $objeto;
            
    
        }
        // foreach($respuesta as $resul => $valor){
        //     echo 'columna '.$resul.' valor '.$valor.'<br>';
        // }
        
        // echo 'luis';
        // echo 'respuesta BD'.$respuesta;
        
        
        return $respuesta;
    }


    //  function getNotasUsuarioV2($idUsuario) {
    //     $this->db->getCursorParameters(self::TABLA, '*', array('idUsuario' => $idUsuario));
    //     $respuesta = array();
    //     if ($fila = $this->db->getRow()) {
    //         $objeto = new Nota();
    //         $objeto->set($fila);
    //         $respuesta[] = $objeto;
    //     }
    //     foreach($respuesta as $resul => $valor){
    //         echo 'columna '.$resul.' valor '.$valor.'<br>';
    //      }
    //       return $respuesta;
    // }

    function save(Nota $objeto) {
        $campos = $this->_getCampos($objeto);
        return $this->db->updateParameters(self::TABLA, $this->_getCampos($objeto), array('idNota' => $idNota));
    }
    
   function updateColor(Nota $objeto) {
       echo'NOTAAAA';
       var_dump($objeto);
        $campos = $this->_getCampos($objeto);
        unset($campos['idUsuario']);
        unset($campos['idNota']);
        unset($campos['fCreacion']);
        return $this->db->updateParameters(self::TABLA, $campos, array('idTipoNota' => $objeto->getIdTipoNota()));
    }

}