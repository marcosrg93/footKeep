<?php

class ControllerNotas extends Controller {
    
     function insertNotaTexto(){
       //Creamos los objetos 
        $nota = new Nota();
        $tipoNota = new TipoNota();
        //Leemos los datos del html
        $nota->read();
        $titulo=Request::read('titulo');
        $texto=Request::read('texto');
        
        //Rellenamos el objeto tipoNota
        $tipoNota->setTipo('texto');
        $tipoNota->setTitulo($titulo);
        $tipoNota->setTexto($texto); 
        
       
       //Insertamos el tipoNota en la bd y nos devuelve el id insertad
         $idTipoNota = $this->getModel()->insertTipoNota($tipoNota);
        
         //var_dump('ID TIPO NOTA: '.$idTipoNota.'</br>');
         
       //Obtenemos los datos de la cookie de session para obtener los datos del usuario
       //$getUser nos devuelve un objeto usuario con los valores del usuario
        $idUsuario =  $this->getSession()->getUser()->getIdUsuario();
         
       //Rellenamos la tabla de Notas
       
         $nota->setIdTipoNota($idTipoNota);
         $nota->setIdUsuario($idUsuario);
         $nota->setIdColor(1);
         
         $ResultadoNota = $this->getModel()->insertNota($nota);
        
          header('Location: index.php?ruta=notas&accion=refrescarNota');
       
     }
     
     
     //metodo para refrescar las notas del usuario
     function refrescarNota(){
       //  echo 'luis';
        $usuario =  $this->getSession()->getUser();
        //Obtenemos un array con las notas del usuario en la bd con todos sus campos mediante el idUsuario
        
        $notas = $this->getModel()->obtenerNotas($usuario->getIdUsuario());
   
        $tipoNotas = array();
        //Pasamos el array con todas las notas para sacar el tipo notas mediante el IdTipoNota
        $tipoNotas=$this->getModel()->obtenerTipoNota($notas);
   
        //obtenre el id color
     //  var_dump($notas);
    
     //  $color = new Color();
     //  $color = $notas[1];
     //   echo  $color->getIdColor().'------------------------------------------------';
     //  exit();
       
      
         
        //echo   date("d") . "/" . date("m") . "/" . date("Y");
        //Devuelve la plantilla de notas
        $this->getModel()->addData('lista-nota', $tipoNotas);
        $this->getModel()->addData('nota', $notas);
        $this->getModel()->addData('usuario', $usuario);
        
        
        
   
     }
     
     function insertNotaMultimedia(){
        $nota = new Nota();
        $tipoNota = new TipoNota();
        //Leemos los datos del html
        $nota->read();
        $titulo=Request::read('titulo');
        $texto=Request::read('texto');
        
        //Rellenamos el objeto tipoNota
        $tipoNota->setTipo('imagen');
        $tipoNota->setTitulo($titulo);
        $tipoNota->setTexto($texto); 
        //obtenemos la foto
        // Comprobamos si ha ocurrido un error.
        
        
        
           if (!isset($_FILES["imagen"]) || $_FILES["imagen"]["error"] > 0)
           {
               echo "Ha ocurrido un error.";
           }
           else
           {
               $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
               $limite_kb = 16384;
           
               if (in_array($_FILES['imagen']['type'], $permitidos) && $_FILES['imagen']['size'] <= $limite_kb * 1024)
               {
           
                   // Archivo temporal
                   $imagen_temporal = $_FILES['imagen']['tmp_name'];
           
                   // Tipo de archivo
                   $tipo = $_FILES['imagen']['type'];
           
                   // Leemos el contenido del archivo temporal en binario.
                   $fp = fopen($imagen_temporal, 'r+b');
                   $data = fread($fp, filesize($imagen_temporal));
                   fclose($fp);
                   
                   // Escapamos los caracteres para que se puedan almacenar en la base de datos correctamente.
                   //$data = mysql_escape_string($data);
           
                   // Insertamos en la base de datos.
                   $tipoNota->setUrl($data);
                   $resultado =  $this->getModel()->insertTipoNota($tipoNota);
                 
           
                   if ($resultado)
                   {
                       echo "El archivo ha sido copiado exitosamente.";
                   }
                   else
                   {
                       echo "Ocurrió algun error al copiar el archivo.";
                   }
               }
               else
               {
                   echo "Formato de archivo no permitido o excede el tamaño límite de $limite_kb Kbytes.";
               }
           }   
        
       
        
        
      
       
       // tenemos la notatipoimagen ahora insertamos la nota
       $idUsuario =  $this->getSession()->getUser()->getIdUsuario();
         
       //Rellenamos la tabla de Notas
       
         $nota->setIdTipoNota($resultado);
         $nota->setIdUsuario($idUsuario);
         $nota->setIdColor(1);
         
         
         $ResultadoNota = $this->getModel()->insertNota($nota);
         header('Location: index.php?ruta=notas&accion=refrescarNota');
        
     }
     function insertNotaVideo(){
       
       
        $file = new FileUpload('video');
        
        $file->setPolicy(FileUpload::REEMPLAZAR);
        
        //para crear el nombre del video idusuario+ fechaactual
        
        $idUsuario =  $this->getSession()->getUser()->getIdUsuario();
        $fechaActual= date("Y-m-d H:i:s"); 
        $nombre = $idUsuario.$fechaActual;
        $file->setName($nombre);
        
        
         if($file->upload()){
        
            //header('Location: index.php?ruta=notas&accion=refrescarNota&op=imagen&r=1');
            echo'Bien';
        } else {
            //echo $file->getTypeError();
            
            echo'Mal';
            //header('Location: index.php?ruta=notas&accion=refrescarNota&op=imagen&r=0');
           // header('Location: index.php?op=imagen&r=0');
        };
        
    //  echo  $file->getTypeError();
    //  exit();
        $nota = new Nota();
        $tipoNota = new TipoNota();
        //Leemos los datos del html
        $nota->read();
        $titulo=Request::read('titulo');
        $texto=Request::read('texto');
        
        //Rellenamos el objeto tipoNota
        $tipoNota->setTipo('video');
        $tipoNota->setTitulo($titulo);
        $tipoNota->setTexto($texto); 
        
        
        $tipoNota->setVideo($nombre);
        
        
        
        $resultado =  $this->getModel()->insertTipoNota($tipoNota);
       //tenemos que imprimir la nota
       $nota->setIdTipoNota($resultado);
       $nota->setIdUsuario($idUsuario);
       $nota->setIdColor(1);
       $ResultadoNota = $this->getModel()->insertNota($nota);
        header('Location: index.php?ruta=notas&accion=refrescarNota');
     }
     
    

      
     function eliminarnota(){
       $idTipoNota=Request::read('idTipoNota');
      
       $this->getModel()->delTipoNota($idTipoNota);
       
       $this->getModel()->deleteNota($idTipoNota);
       
       header('Location: index.php?ruta=notas&accion=refrescarNota');
     }
     function modificarNota(){
        $tipoNota = new TipoNota();
        //Leemos los datos del html
        $idTipoNota = Request::read('idTipoNota');
        $titulo=Request::read('titulo');
        $texto=Request::read('texto');
        echo'Datos recogidos';
        var_dump($idTipoNota);
        echo'</br>';
        var_dump($titulo);
        echo'</br>';
        var_dump($texto);
        // rellenamos la nota
        $tipoNota->setTipo('texto');
        $tipoNota->setTitulo($titulo);
        $tipoNota->setTexto($texto);
        $tipoNota->setIdTipoNota($idTipoNota);
       echo 'bien';
        var_dump($tipoNota);
        
  
        $resu = $this->getModel()->modificarNota($tipoNota);
        echo $resu.'resultadoFinal';
        header('Location: index.php?ruta=notas&accion=refrescarNota');
        
     }
     
     function modificarNotaImagen(){
      
        $tipoNota = new TipoNota();
        //Leemos los datos del html
        $idTipoNota = Request::read('idTipoNota');
        $titulo=Request::read('titulo');
        $texto=Request::read('texto');
         // rellenamos la nota
        $tipoNota->setTipo('texto');
        $tipoNota->setTitulo($titulo);
        $tipoNota->setTexto($texto);
        $tipoNota->setIdTipoNota($idTipoNota);
  
  
        if(empty($_FILES['foto']['name'])){
         
          $ress = $this->getModel()-> modificarNotaEspeci($tipoNota);
           header('Location: index.php?ruta=notas&accion=refrescarNota');
        }else{
         // Archivo temporal
       
                   // Archivo temporal
                   $imagen_temporal = $_FILES['foto']['tmp_name'];
           
                   // Tipo de archivo
                   $tipo = $_FILES['foto']['type'];
           
                   // Leemos el contenido del archivo temporal en binario.
                   $fp = fopen($imagen_temporal, 'r+b');
                   $data = fread($fp, filesize($imagen_temporal));
                   fclose($fp);
                   
                   // Escapamos los caracteres para que se puedan almacenar en la base de datos correctamente.
                   //$data = mysql_escape_string($data);
           
                   // Insertamos en la base de datos.
                   $tipoNota->setUrl($data);
        
       
        $resu = $this->getModel()->modificarNotaImagen($tipoNota);
        header('Location: index.php?ruta=notas&accion=refrescarNota');
        } 
      //  header('Location: index.php?ruta=notas&accion=refrescarNota');
     }
     
     
      function modificarNotaVideo(){
        
        $tipoNota = new TipoNota();
       //Leemos los datos del html
        $idTipoNota = Request::read('idTipoNota');
        $titulo=Request::read('titulo');
        $texto=Request::read('texto');
         // rellenamos la nota
        $tipoNota->setTipo('video');
        $tipoNota->setTitulo($titulo);
        $tipoNota->setTexto($texto);
        $tipoNota->setIdTipoNota($idTipoNota);
        
          if(empty($_FILES['video']['name'])){
        //hay que controlar tamaño de video
          
         $ress = $this->getModel()-> modificarNotaEspeci($tipoNota);
          header('Location: index.php?ruta=notas&accion=refrescarNota');
       
        // header('Location:index.php?ruta=notas&accion=refrescarNota');
        }else{
         $file = new FileUpload('video');
        
        $file->setPolicy(FileUpload::REEMPLAZAR);
        
        //para crear el nombre del video idusuario+ fechaactual
        
        $idUsuario =  $this->getSession()->getUser()->getIdUsuario();
        $fechaActual= date("Y-m-d H:i:s"); 
        $nombre = $idUsuario.$fechaActual;
        $file->setName($nombre);
        
         $file->upload();
     //   $file->getTypeError();
        //lo metemos en la nota
        $tipoNota->setVideo($nombre);
       
         $ress = $this->getModel()-> modificarNota($tipoNota);
          header('Location: index.php?ruta=notas&accion=refrescarNota');
        }
        
      
       
      }
      
      
      
      
      
     function updateColor(){
        $idcolor= Request::read('idcolor');
        $idTipoNota = Request::read('idTipoNota');
        // echo 'Color'.$idcolor;
        // echo 'ID'.$idTipoNota;
        $nota = new Nota();
        $nota->setIdColor($idcolor);
        $nota->setIdTipoNota($idTipoNota);
        // echo'LEE';
        // var_dump($nota);
      // $color = new Color();
      // $color->setIdColor($idcolor);
        $resu = $this->getModel()->modificarColor($nota);
        // var_dump($resu);
       header('Location: index.php?ruta=notas&accion=refrescarNota');
      
     }
      
}
    
  