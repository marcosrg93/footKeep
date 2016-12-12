<?php

class Util {

   static function encriptar($cadena, $coste = 10) {
        $opciones = array(
            'cost' => $coste
        );
        return password_hash($cadena, PASSWORD_DEFAULT, $opciones);
    }
    
    static function verificarClave($claveSinEncriptar, $claveEncriptada){
      //  echo 'sin en'.$claveSinEncriptar.'encrip='.$claveEncriptada;
        return password_verify($claveSinEncriptar, $claveEncriptada);
    }
    
    
    static function renderFile($file, $data) {
        if (!file_exists($file)) {
            echo 'Error: ' . $file . '<br>';
            return '';
        }
        $contenido = file_get_contents($file);
        return self::renderText($contenido, $data);
    }

    static function renderText($text, $data) {
        foreach ($data as $indice => $dato) {
            $text = str_replace('{' . $indice . '}', $dato, $text);
        }
        return $text;
    }
    /* funcion para enviarlos correos*/
    static function enviarCorreos($destino,$asunto,$mensaje){
        require_once 'clases/vendor/autoload.php';
        $cliente = new Google_Client();
        $cliente->setApplicationName('EmailActiva');
        $cliente->setAccessToken(file_get_contents('clases/Credenciales/token.conf'));
        if ($cliente->getAccessToken()) {
            $service = new Google_Service_Gmail($cliente);
            try {
                $mail = new PHPMailer();
                $mail->CharSet = "UTF-8";
                $mail->From = constantes::CORREO;
                $mail->FromName = constantes::ALIAS;
                $mail->AddAddress($destino);
                $mail->AddReplyTo($origen, $alias);
                $mail->Subject = $asunto;
                $mail->Body = $mensaje;
                $mail->preSend();
                $mime = $mail->getSentMIMEMessage();
                $mime = rtrim(strtr(base64_encode($mime), '+/', '-_'), '=');
                $mensaje = new Google_Service_Gmail_Message();
                $mensaje->setRaw($mime);
                $service->users_messages->send('me', $mensaje);
                return true;
            } catch (Exception $e) {
                var_dump($e);
                return false;
            }
        } else {
            echo 'token';
            return false;
        }
            }
    }