<?php
/*id de cliente*/
/*568922011890-9cci3d4lp832trbjcv0t78t5dkfhlfm9.apps.googleusercontent.com*/
/*tu id secreto de ususario*/
/*wMTFyS1AnVsCUO4OHipAzC2E*/

/*para instalar las librerias

 -en el terminar:
    -composer require google/apiclient:^2.0
    -composer require phpmailer/phpmailer
en proceso.txt dentro de instrucciones esta todo

el archivo token.conf es una lplave que nos permiote enviar los correos pero solo desde la url de c9 
es la calve de acceso al correo
se crea al ejecutar la url
https://proyectonotas-marcosrg.c9users.io/Credenciales/guardarCredenciales.php
y darle a permitir permisos
*/

session_start();
require_once '../../vendor/autoload.php';
$cliente = new Google_Client();
$cliente->setApplicationName('keep');
$cliente->setClientId('966820955393-semeqsfeglkvng9j2a1oub9crm57ljt2.apps.googleusercontent.com');
$cliente->setClientSecret('WjLNq3p8XZPFLCbBmxdWf-dJ');
$cliente->setRedirectUri('https://keep-marcosrg.c9users.io/clases/Credenciales/generar/guardarCredenciales.php');
$cliente->setScopes('https://www.googleapis.com/auth/gmail.compose');
$cliente->setAccessType('offline');
if (isset($_GET['code'])) {
   $cliente->authenticate($_GET['code']);
   $_SESSION['token'] = $cliente->getAccessToken();
   $archivo = "token.conf";
   $fh = fopen($archivo, 'w') or die("error");
   fwrite($fh, json_encode($cliente->getAccessToken()));
   fclose($fh);
}
