<?php

class Router {

    private $rutas = array();

    function __construct() {
        $this->rutas['index'] = new Route('Model', 'View', 'Controller');
        //Ruta 
        $this->rutas['usuario'] = new Route ('ModelUsuario', 'View', 'ControllerUsuario');
        //Ruta que muestra las notas
        $this->rutas['notas'] = new Route ('ModelNotas', 'View', 'ControllerNotas');

     //   $this->rutas['tipoNota'] = new Route ('ModelNotas', 'ViewNotas', 'ControllerNotas');
        
         $this->rutas['admin'] = new Route ('ModelUsuario', 'ViewAdmin', 'ControllerUsuario');
        
       
    }

    function getRoute($ruta) {
        if (!isset($this->rutas[$ruta])) {
            return $this->rutas['index'];
        }
        return $this->rutas[$ruta];
    }

}