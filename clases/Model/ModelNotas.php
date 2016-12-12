<?php

class ModelNotas extends Model {

    function insertNota(Nota $nota){
        date_default_timezone_set('Europe/Madrid');
        $nota->setFCreacion(date('Y-m-d'));
        $gestor = new GestorNota();
        return $gestor->add($nota);
    }
    
    function insertTipoNota(TipoNota $tipoNota){
        $gestorTipoNota = new GestorTipoNota();
        $gestorTipoNota->add($tipoNota);
        //$gestorTipoNota-> addImagen($tipoNota);
        return  $gestorTipoNota->getLastId();
    }

    function obtenerNotas($idUsuario){
        $gestor = new GestorNota();
        return $gestor->getNotasUsuario($idUsuario);
    }
    
    function obtenerTipoNota($notas){
         $gestor = new GestorTipoNota();
         return $gestor->getTipoNotas($notas);
        
    }

    function deleteNota($idTipoNota){
        $gestor=new GestorNota();
        $gestor->delete($idTipoNota);
    }
    
    function delTipoNota($idTipoNota){
        $gestor=new GestorTipoNota();
        $gestor->delete($idTipoNota);
    }
    function modificarNota(TipoNota $tipoNota){
         $gestorTipoNota = new GestorTipoNota();
         //$gestorTipoNota->save($tipoNota);
         return  $gestorTipoNota->save($tipoNota);
    }
    function modificarNotaImagen(TipoNota $tipoNota){
        //var_dump($tipoNota);
         $gestorTipoNota = new GestorTipoNota();
         //$gestorTipoNota->save($tipoNota);
         return  $gestorTipoNota->editImagen($tipoNota);
    }
    
    function modificarNotaEspeci(TipoNota $tipoNota){
         $gestorTipoNota = new GestorTipoNota();
         return  $gestorTipoNota->updateTipoNotasEspecial($tipoNota);
        
    }
    //para el color
    function modificarColor(Nota $color){
        $gestorColor = new GestorNota();
       
        return $gestorColor->updateColor($color);

    }
    
    
    
    
    
    
    
    
    /*----------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
    
    // function getList(){
    //     $gestor = new GestorNota();
    //     return $gestor->getList();
    // }
    
    
    
    
    // function getList(){
    //     $gestor = new GestorNota();
    //     return $gestor->getList();
    // }
    
    
    
    // function deleteUsuario($email){
    //     $gestor=new GestorUsuario();
    //     return $gestor->delete($email);
    // }
    
    // function getUsuario($email){
    //     $gestor = new GestorUsuario();
    //     return $gestor->get($email);
    // }
    
    // function editUsuario(Usuario $usuario, $emailpk){
    //     $gestor = new GestorUsuario();
    //     return $gestor->saveUsuario($usuario, $emailpk);
    // }
 
}