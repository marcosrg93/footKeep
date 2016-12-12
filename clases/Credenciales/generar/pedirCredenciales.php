<?php

session_start();
require_once '../../vendor/autoload.php';
$cliente = new Google_Client();
$cliente->setApplicationName('keep');
$cliente->setClientId('966820955393-semeqsfeglkvng9j2a1oub9crm57ljt2.apps.googleusercontent.com');
$cliente->setClientSecret('WjLNq3p8XZPFLCbBmxdWf-dJ');
$cliente->setRedirectUri('https://keep-marcosrg.c9users.io/clases/Credenciales/generar/guardarCredenciales.php');
$cliente->setScopes('https://www.googleapis.com/auth/gmail.compose');
$cliente->setAccessType('offline');
if (!$cliente->getAccessToken()) {
   $auth = $cliente->createAuthUrl();
   header("Location: $auth");
}
