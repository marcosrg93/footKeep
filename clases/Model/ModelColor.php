<?php

class ModelColor extends Model {
    
    
    
   function obtenerNotas($idNota){
        $gestor = new GestorNota();
        $gestor->get($idNota);
        
        
        
    }