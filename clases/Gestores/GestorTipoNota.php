<?php

class GestorTipoNota{
    
    const TABLA = 'tipoNota';
    private $db;

    function __construct() {
        $this->db = new DataBase();
    }

    private static function _getCampos(TipoNota $objeto) {
        $campos = $objeto->get();
        return $campos;
    }

    function addImagen(TipoNota $objeto){
        //$sql = "INSERT INTO tipoNota (idTipoNota, tipo, titulo, texto, url) VALUES ('','".$objeto->getTipo()."','".$objeto->getTitulo()."','".$objeto->getTexto()."','".$objeto->getUrl()."')";
        //$sql = "INSERT INTO tipoNota (idTipoNota, tipo, titulo, texto, url) VALUES ('', :tipo, :titulo, :texto, '".$objeto->getUrl()."')";
        $sql = "INSERT INTO tipoNota (idTipoNota, tipo, titulo, texto, url, video,orden) VALUES ('', :tipo, :titulo, :texto, :url, :video, :orden)";
        $parametros = array(
            'tipo' => $objeto->getTipo(),
            'titulo' => $objeto->getTitulo(),
            'texto' => $objeto->getTexto(),
            'url' =>  array($objeto->getUrl(), PDO::PARAM_LOB),
            //'url' =>  $objeto->getUrl()
        );
        $this->db->send($sql, $parametros);
        //$this->db->send($sql);
        //exit();
    }

    function editImagen(TipoNota $objeto){
       
       //UPDATE `tipoNota` SET `titulo`='otro',`texto`='otro' WHERE `idTipoNota`= 80
       // $sql ="UPDATE `tipoNota` SET `titulo`='".$objeto->getTitulo()."',`texto`='".$objeto->getTexto()."',`url`='".$objeto->getUrl()."' WHERE idTipoNota=".$objeto->getIdTipoNota()."";
      //  $sql = "INSERT INTO `tipoNota`(`idTipoNota`, `tipo`, `titulo`, `texto`, `url`) VALUES ('','".$objeto->getTipo()."','".$objeto->getTitulo()."','".$objeto->getTexto()."','".$objeto->getUrl()."')";
       $sql ="UPDATE `tipoNota` SET `titulo`= :titulo, `texto`= :texto, `url`= :url  WHERE idTipoNota=".$objeto->getIdTipoNota()."";
       
        $parametros = array(
            'titulo' => $objeto->getTitulo(),
            'texto' => $objeto->getTexto(),
            'url' =>  array($objeto->getUrl(), PDO::PARAM_LOB),
            
        );
        $this->db->send($sql, $parametros);
     
     
        $this->db->send($sql);
    }


    function add(TipoNota $objeto) {
        return $this->db->insertParameters(self::TABLA, self::_getCampos($objeto), false);
    }
    
    function delete($id) {
        
        return $this->db->deleteParameters(self::TABLA, array('idTipoNota' => $id));
    }


    function getLastId(){
        return $this->db->getId();
    }


    function  getTipoNotas($idNotas){
        //echo '</br>Miramos idTipoNota.------------------------------</br>';
        // echo '<hr>'.$idNotas['idTipoNota'].'<hr>';
           $respuesta = array();
           foreach($idNotas as $nota){
             // echo '</br>'.$nota->getIdTipoNota().'</br>';
            $this->db->getCursorParameters(self::TABLA, '*', array('idTipoNota' => $nota->getIdTipoNota()));
           if ($fila = $this->db->getRow()) {
               $objeto = new TipoNota();
               $objeto->set($fila);
               $respuesta[] = $objeto;
         }
       }
           return $respuesta;
    }

    function get($id) {
        $this->db->getCursorParameters(self::TABLA, '*', array('idTipoNota' => $id));
        if ($fila = $this->db->getRow()) {
            $objeto = new TipoNota();
            $objeto->set($fila);
            return $objeto;
        }
    }

    function getList() {
        $this->db->getCursorParameters(self::TABLA);
        $respuesta = array();
        while ($fila = $this->db->getRow()) {
            $objeto = new TipoNota();
            $objeto->set($fila);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }

    function save(TipoNota $objeto) {
        $campos = $this->_getCampos($objeto);
        return $this->db->updateParameters(self::TABLA, $this->_getCampos($objeto), array('idTipoNota' => $objeto->getIdTipoNota()));
    }
    /* update solo con parametros especifocos */
    
    function updateTipoNotasEspecial(TipoNota $objeto) {
        $campos = $this->_getCampos($objeto);
        unset($campos['url']);
        unset($campos['tipo']);
         unset($campos['video']);
        return $this->db->updateParameters(self::TABLA, $campos, array('idTipoNota' => $objeto->getIdTipoNota()));
    }
    
    
    

}