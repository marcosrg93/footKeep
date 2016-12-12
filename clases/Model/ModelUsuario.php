<?php

class ModelUsuario extends Model {

    function insertUsuario(Usuario $usuario){
        date_default_timezone_set('Europe/Madrid');
        $usuario->setFalta(date('Y-m-d'));
        $usuario->setTipo('usuario');
        $usuario->setEstado(0);
        //var_dump($usuario->getPassword());
        $usuario->setPassword(Util::encriptar($usuario->getPassword()));
        //var_dump($usuario->getPassword());
        $gestor = new GestorUsuario();
        return $gestor->add($usuario);
    }
     function insertUsuarioAdmin(Usuario $usuario){
        date_default_timezone_set('Europe/Madrid');
        $usuario->setFalta(date('Y-m-d'));
        $usuario->setTipo('administrador');
        $usuario->setEstado(1);
        //var_dump($usuario->getPassword());
        $usuario->setPassword(Util::encriptar($usuario->getPassword()));
        //var_dump($usuario->getPassword());
        $gestor = new GestorUsuario();
        return $gestor->add($usuario);
    }
    
    function getList(){
        $gestor = new GestorUsuario();
        return $gestor->getList();
    }
    
    function deleteUsuario($id){
        $gestor=new GestorUsuario();
        return $gestor->delete($id);
    }
    
    function getUsuario($email){
        $gestor = new GestorUsuario();
        return $gestor->get($email);
    }
    
    function editUsuario(Usuario $usuario, $emailpk){
        $gestor = new GestorUsuario();
        return $gestor->saveUsuario($usuario, $emailpk);
    }
     /* para el admin*/
    function obtenerListaUsuarios(){
        $gestor = new GestorUsuario();
        return $gestor->getList();
    }
    
    function getNumNotas($idUsuario){
        $gestor = new GestorNota();
        return $gestor->getNotasUsuario($idUsuario);
    }
    
    
    
}