<?php

class AutoLoad {

    static $clases = array (
        //grupos
        'Controller' => 'Controller',
        'Gestor' => 'Gestores',
        'Model' => 'Model',
        'View' => 'View',
        //concretos
        'Constantes' => 'Bd',
        'DataBase' => 'Bd',
        'FrontController' => 'Controller',
        'Route' => 'Routes',
        'Router' => 'Routes',
        'Util' => 'Util',
        'Util' => 'FileUpload',
        'ObjectReader' => 'web',
        'Request' => 'web',
        'Session' => 'web',
        //buscar resto aquí
        'Tablas' => 'Pojo',
        'Resto' => 'Util'
    );

    static function load($clase) {
        $primeraPalabra = self::getWord($clase, 0);
        $ruta = '.';
        if(isset(self::$clases[$clase])) {
            $ruta = self::$clases[$clase];
        } else if(isset(self::$clases[$primeraPalabra])) {
            $ruta = self::$clases[$primeraPalabra];
        }
        $archivo = './clases/' . $ruta . '/' . $clase . '.php';
        $archivoAlternativo1 = './clases/' . self::$clases['Tablas'] . '/' . $clase . '.php';
        $archivoAlternativo2 = './clases/' . self::$clases['Resto'] . '/' . $clase . '.php';
        if(file_exists($archivo)){
            require_once $archivo;
        } else if(file_exists($archivoAlternativo1)){
            require_once $archivoAlternativo1;
        } else if(file_exists($archivoAlternativo2)){
            require_once $archivoAlternativo2;
        }
    }
    
    private static function getWord($string, $number) {
        $palabras = self::getWordNumber($string);
        if($number < $palabras) {
            $partes = self::splitCamelCaseWord($string);
            return $partes[$number];
        }
        return '';
    }

    private static function getWordNumber($string) {
        $partes = self::splitCamelCaseWord($string);
        return count($partes);
    }

    private static function splitCamelCaseWord($word) {
        $expreg = '/(?<=[a-z])(?=[A-Z])|(?<=[A-Z])(?=[A-Z][a-z])/x';
        return preg_split($expreg, $word);
    }
}

spl_autoload_register('AutoLoad::load');