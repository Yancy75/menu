<?php

switch ($_REQUEST['accion']){
    case 0:inicio();
           break;
    case 1:inicioad();
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

function inicioad(){
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
           $aux=recaudador_card(($opendi."/".$carp[$i]),  ($ruta."/".$carp[$i]));
           $capsula[$carp[$i]]=$aux[0];
           }/* recorremos todas las carpetas por separado y creamos los mini caruseles*/
          /*  for($j=0 ; $j < $num; $j++ ){
           if(isset($aux[2])){$globo=$aux[2];}
             $aux=completo(($opendi."/".$carp[$j]),  ($ruta."/".$carp[$j]), $globo);
              if(is_array($aux)){$arch = array_merge($arch, $aux[0]); $micro = array_merge($micro, $aux[1]);}
          }*//* recorremos todas las carpetas*/
     }
    $capsula['ztodo']=$arch;
    $autobot['ztodo']=$micro;
    $capsula2[0]=$capsula;
    $capsula2[1]=$autobot;
    echo json_encode($capsula2, JSON_UNESCAPED_UNICODE);
}

function recaudador($dir, $ruta){/*esto es para lo minis caruceles por separados */
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
       $pos = strpos($archivo,","); /*aqui es donde hago los separados o los mini carousel */
      if ($pos === false) {/*esta separacion es para saber si tengo o no el precio si pos es falso no tengo el precio*/
            array_push($arch,'<div class="carousel-item" alt="'.$globo.'" ><img class="w-100" src="'.$ruta . '/' . $archivo.'"><div class="carousel-caption animated fadeIn delay-1s"><div class="torcido"><h3>'.strtoupper(substr($archivo, 0, strpos($archivo,'.'))).'</h3><p><i>(No incluye impuestos)</i></p></div></div></div>');
       } else {
            $a= explode(",", $archivo);
            array_push($arch,'<div class="carousel-item" alt="'.$globo.'" ><img class="w-100" src="'.$ruta . '/' . $archivo.'"><div class="carousel-caption animated fadeIn delay-1s"><div class="torcido"><h3>'.strtoupper(substr($archivo, 0, strpos($archivo,','))).'</h3><h3>RD$ '.substr($a[1], 0, strpos($a[1],'.')).' </h3><p><i>(No incluye impuestos)</i></p></div></div></div>');
       }
      array_push($micro,'<li id="li'.$globo.'" data-target="#muestra" data-bs-slide-to="'.$globo.'"  class="span2" ondblclick="toma('.$globo.')"><a class="thumbnail" id="carousel-selector-'.$globo.'"><img src="'.$ruta . '/mini/' . $archivo.'"></a></li>');
      $globo++;
    }
    }/*final del recorrido */
    if(count($carp)>0){
       return([$carp,$arch, $micro]);
     }else{return([$arch, $micro]);}
}
/* para las tarjetas*/
function recaudador_card($dir, $ruta){
  $globo=0;$tarjeta="";
  $carp = array(); $arch = array();
  $directorio = opendir($dir); //ruta actual
  /*aqui vamos preguntando por el directorio */
    $carpeta=$dir.'/mini';
      if (!file_exists($carpeta)) {mkdir($carpeta, 0777, true);}
  /*aqui vamos*/
  $ruta1 = substr($ruta, strpos($ruta, '/')+2);
  $titulo=strtoupper($ruta1);
  $ruta1 =str_replace(' ', '', $ruta1);

  while ($archivo = readdir($directorio)){if(!is_dir($dir . '/' . $archivo) && $archivo!="." && $archivo!=".."){$imagen = "'".$ruta . "/" . $archivo."'";break;}}/* busca la primera imagen */
  $tarjeta = '<div class="accordion-item"><h2 class="accordion-header" id="'.$ruta1.'cabesa" style="background-image: url('.$imagen.');background-size: cover; background-position: center;"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#'.$ruta1.'" aria-expanded="false" aria-controls="'.$ruta1.'">';
  $tarjeta .= ''.$titulo.'</button></h2>';
  $tarjeta .='<div id="'.$ruta1.'" class="accordion-collapse collapse" aria-labelledby="'.$ruta1.'cabesa"><div class="accordion-body">';
  $tarjeta .='  <div class="accordion-body">';
  $directorio = opendir($dir); // vuelvo a poner el directorio al inicio
  while ($archivo = readdir($directorio)){
   if(!is_dir($dir . '/' . $archivo) && $archivo!="." && $archivo!=".."){
   if (!file_exists('../'.$ruta.'/mini/'.$archivo)) {creador($archivo, $ruta, $carpeta);} /*enviamos el archivo despues de validar*/
     $pos = strpos($archivo,","); /*aqui es donde hago los separados o los mini carousel */
          $modalid= str_replace(' ','', substr($archivo, 0, $pos));/* haces  los modal id*/
          $imagen = "'".$ruta . "/" . $archivo."'";
     if ($pos === false) {
           $pos = strpos($archivo,".");
          $modalid= str_replace(' ','', substr($archivo, 0, $pos));/* haces  los modal id*/
          $tarjeta.='<div class="card mb-4" ><div class="row g-0"><div class="col-md-4" class="img-fluid rounded-start" data-bs-toggle="modal" data-bs-target="#'.$modalid.'Modal" style="cursor: pointer; background-image: url('.$imagen.'); background-size: cover; background-position: center; min-height: 212px;"></div>';
          $tarjeta.='<div class="col-md-8"><div class="card-body"><h5 class="card-title">'.strtoupper(substr($archivo, 0, strpos($archivo,'.'))).'</h5><p class="card-text" style="font-weight: 700; font-size: 1.8em; color: blue; margin: 10px;">¡AGOTADO!</p><p class="card-text"><small class="text-muted">(No incluye impuestos)</small></p>';
          $tarjeta.='</div></div></div></div>';
          $tarjeta.='<div class="modal fade" id="'.$modalid.'Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog modal-xl modal-dialog-centered"><div class="modal-content">';
          $tarjeta.='<div class="modal-header"><h5 class="modal-title" id="exampleModalLabel">'.strtoupper(substr($archivo, 0, strpos($archivo,'.'))).'</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body">';
          $tarjeta.='<img src="'.$ruta . '/' . $archivo.'"  alt="..." class="img-fluid"  ></div></div></div></div>';
     } else {
          $a= explode(",", $archivo);
          $modalid= str_replace(' ','', substr($archivo, 0, $pos));/* haces  los modal id*/
          $nombre = strtoupper(substr($archivo, 0, strpos($archivo,',')));
          $idj="'".$modalid.$globo."'";
          $tarjeta.= '<div class="card mb-4"><div class="row g-0"><div class="col-md-4" class="img-fluid rounded-start" data-bs-toggle="modal" data-bs-target="#'.$modalid.'Modal" style="cursor: pointer; background-image: url('.$imagen.'); background-size: cover; background-position: center; min-height: 212px;"></div><div class="col-md-8"><div class="card-body"><h5 class="card-title">'.$nombre.'</h5><p class="card-text">';
          $tarjeta.='<div class="botov"><p class="card-text" style="font-weight: 700; font-size: 1.8em; color: blue; margin: 10px;">RD$ '.substr($a[1], 0, strpos($a[1],'.')).' </p> <div type="button" class="btn btn-labeled btn-primary botome" id="'.$modalid.$globo.'"  alt="'.$nombre.'" alt2="'.substr($a[1], 0, strpos($a[1],'.')).'"  alt3="'.$ruta . "/mini/" . $archivo.'"  onclick="imagen('.$idj.')">';
          $tarjeta.='<span class="btn-label"><i class="fa fa-cutlery" aria-hidden="true"></i></span>Agrega a tu Menu</div></div><p class="card-text"><small class="text-muted">(No incluye impuestos)</small></p>';
          $tarjeta.='</div></div></div></div>';
          $tarjeta.='<div class="modal fade" id="'.$modalid.'Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog modal-xl modal-dialog-centered"><div class="modal-content">';
          $tarjeta.='<div class="modal-header"><h5 class="modal-title" id="exampleModalLabel">'.$nombre.'</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body">';
          $tarjeta.='<img src="'.$ruta . '/' . $archivo.'"  alt="..." class="img-fluid"></div></div></div></div>';
      }
      $globo++;
      }
  }/*final del recorrido */
  $tarjeta.='</div></div></div>';
   array_push($arch, $tarjeta);
  return($arch);
}


function completo($dir, $ruta, $globo){/* recorremos completo para el carrucel mas grande*/
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
       array_push($micro,'<li id="li'.$globo.'" data-target="#muestra" data-bs-slide-to="'.$globo.'" class="span2" ondblclick="toma('.$globo.')" alt="todo"><a class="thumbnail" id="carousel-selector-'.$globo.'"><img src="'.$ruta . '/mini/' . $archivo.'"></a></li>');
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
