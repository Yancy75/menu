<?php

switch ($_REQUEST['accion']){
    case 0:
          inicio();
    break;
  }

function inicio(){
  $globo=0;
  $capsula = array();$carp = array(); $arch = array();$micro=array();$aux=array();$autobot=array();
  $opendi='../imagen';// valor por defecto
  $ruta='imagen';
  $num=0;
  $directorio = opendir($opendi); //ruta actual
  while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
  {if (is_dir($opendi . '/' . $archivo) && $archivo!="." && $archivo!="..")//verificamos si es o no un directorio
   {array_push($carp, $archivo);}}/*optenemos todas las carpetas*/
    $num=count($carp);
  if ($num>1){
        for($i=0 ; $i < $num; $i++ ){
           $aux=recaudador(($opendi."/".$carp[$i]),  ($ruta."/".$carp[$i]));
           $capsula[$carp[$i]]=$aux[0];
           $autobot[$carp[$i]]=$aux[1];}/* recorremos todas las carpetas*/
        for($j=0 ; $j < $num; $j++ ){
           if(isset($aux[2])){$globo=$aux[2];}
             $aux=completo(($opendi."/".$carp[$j]),  ($ruta."/".$carp[$j]), $globo);
              if(is_array($aux)){$arch = array_merge($arch, $aux[0]); $micro = array_merge($micro, $aux[1]);}
          }/* recorremos todas las carpetas*/
     }
    $capsula['ztodo']=$arch;$autobot['ztodo']=$micro;$capsula2[0]=$capsula;$capsula2[1]=$autobot;
    echo json_encode($capsula2, JSON_UNESCAPED_UNICODE);
}

function recaudador($dir, $ruta){
  $globo=0;
  $carp = array(); $arch = array();  $micro=array();
  $directorio = opendir($dir); //ruta actual
  /*aqui vamos preguntando por el directorio */
    $carpeta=$dir.'/mini';
      if (!file_exists($carpeta)) {mkdir($carpeta, 0777, true);}
  /*aqui vamos*/
    while ($archivo = readdir($directorio)){
     if(!is_dir($dir . '/' . $archivo) && $archivo!="." && $archivo!=".."){
     if (!file_exists('../'.$ruta.'/mini/'.$archivo)) {creador($archivo, $ruta, $carpeta);} /*enviamos el archivo despues de validar*/
       $pos = strpos($archivo,",");
       if ($pos === false) {
            array_push($arch,'<div class="carousel-item" alt="'.$globo.'" ><img class="w-100" src="'.$ruta . '/' . $archivo.'"><div class="carousel-caption animated fadeIn delay-1s"><div class="torcido"><h3>'.strtoupper(substr($archivo, 0, strpos($archivo,'.'))).'</h3><p><i>(No incluye impuestos)</i></p></div></div></div>');
       } else {
            $a= explode(",", $archivo);
            array_push($arch,'<div class="carousel-item" alt="'.$globo.'" ><img class="w-100" src="'.$ruta . '/' . $archivo.'"><div class="carousel-caption animated fadeIn delay-1s"><div class="torcido"><h3>'.strtoupper(substr($archivo, 0, strpos($archivo,','))).'</h3><h3>RD$ '.substr($a[1], 0, strpos($a[1],'.')).' </h3><p><i>(No incluye impuestos)</i></p></div></div></div>');
       }
      array_push($micro,'<li id="li'.$globo.'" data-target="#muestra" data-slide-to="'.$globo.'"  class="span2" ondblclick="toma('.$globo.')"><a class="thumbnail" id="carousel-selector-'.$globo.'"><img src="'.$ruta . '/mini/' . $archivo.'"></a></li>');
      $globo++;
    }
    }/*final del recorrido */
    if(count($carp)>0){
       return([$carp,$arch, $micro]);
     }else{return([$arch, $micro]);}
}

function completo($dir, $ruta, $globo){
  $carp = array(); $arch = array();  $micro=array();
  $directorio = opendir($dir);
    while ($archivo = readdir($directorio)){
     if(!is_dir($dir . '/' . $archivo) && $archivo!="." && $archivo!=".."){
       $pos = strpos($archivo,",");
       if ($pos === false) {
            array_push($arch,'<div class="carousel-item" alt="'.$globo.'" ><img class="w-100" src="'.$ruta . '/' . $archivo.'"><div class="carousel-caption animated fadeIn delay-1s"><div class="torcido"><h3>'.strtoupper(substr($archivo, 0, strpos($archivo,'.'))).'</h3><p><i>(No incluye impuestos)</i></p></div></div></div>');
       } else {
            $a= explode(",", $archivo);
            array_push($arch,'<div class="carousel-item" alt="'.$globo.'" ><img class="w-100" src="'.$ruta . '/' . $archivo.'"><div class="carousel-caption animated fadeIn delay-1s"><div class="torcido"><h3>'.strtoupper(substr($archivo, 0, strpos($archivo,','))).'</h3><h3>RD$ '.substr($a[1], 0, strpos($a[1],'.')).' </h3><p><i>(No incluye impuestos)</i></p></div></div></div>');
       }
       array_push($micro,'<li id="li'.$globo.'" data-target="#muestra" data-slide-to="'.$globo.'" class="span2" ondblclick="toma('.$globo.')" alt="todo"><a class="thumbnail" id="carousel-selector-'.$globo.'"><img src="'.$ruta . '/mini/' . $archivo.'"></a></li>');
      $globo++;}
    }
  return([$arch, $micro, $globo]);
}

function creador($archivo, $ruta, $carpeta){
   $ruta1 = '../'.$ruta.'/';
      list($ancho, $alto, $tipo, $atributo)=getimagesize($ruta1.$archivo);
      $tipo = strtolower(substr(strrchr($ruta1.$archivo,"."),1));
      $lienzo = imagecreatetruecolor(192, 108);
          if ($tipo=="jpg" || $tipo=="jpeg"){
            $original = imagecreatefromjpeg($ruta1.$archivo);
          }elseif ($tipo=="png"){
            $original = imagecreatefrompng($ruta1.$archivo);
          }elseif ($tipo=="gif"){
            $original = imagecreatefromgif($ruta1.$archivo);
          }elseif ($tipo=="bmp"){
            $original = imagecreatefromwbmp($ruta1.$archivo);
          }
       imagecopyresampled($lienzo, $original, 0, 0, 0, 0, 192, 108, $ancho, $alto);
       imagejpeg($lienzo,'../'.$ruta.'/mini/'.$archivo);
  }

?>