<?php
$mime = 'video/mp4';
$archivo = '../../v';
if(isset($_GET['mime']) && isset($_GET['archivo'])){
    $mime = $_GET['mime'];
    $archivo = $_GET['archivo'];
}
header('Content-type: ' . $mime);
readfile($archivo);