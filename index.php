<!DOCTYPE html5>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>galeria</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/maestro.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/logogastro.png" />
</head>
<style>
body{
  overflow:hidden;
}
.carga{
  position: fixed;
  top: 45%;
  left: 45%;
}
</style>
  <body style="overflow:hidden;" onLoad="setInterval('periodo()', 180000);" >
              <div id="main_area" style="margin:0px; padding: 0px; height: 100vh; /*position: absolute; top: 0;  left:0*/">
                  <!-- Slider -->
                    <div class="row" style="margin:0px; padding: 0px; box-shadow: 0px 3px 15px black; position:relative">
                          <div id="uso" style="position: absolute;  float: left;  top: 0px; z-index: 10;">
                             <ul class="usumenu" style="list-style: none;"><li><img class="thumbnail" src="img/logogastro.png"  ondblclick="inicio()" style="max-width: 150px; cursor:pointer;"></li></ul>
                           </div>
                        <div class="col-12" style="margin:0px; padding: 0px;">
                                  <div class="carousel slide carousel-fade" id="muestra" data-ride="carousel">
                                        <div class="carousel-inner">
                                            <div class="carga"><img class="thumbnail" src="img/loading.gif" style="max-width: 250px;"></div>

                                        </div><!-- Carousel navegacion -->
                                  </div><!-- final de carousel -->
                        </div>
                    </div><!--/Slider-->

                    <div class="row" id="slider-thumbs" >
                       <div class="col-12">
                          <div  align="center" id="menu" style="padding-top: 0.2em;">

                          </div>
                        </div>
                        <div class="col-lg-12 persiana" style="display: none; overflow: auto;">
                            <!-- Bottom switcher of slider -->
                            <ul class="thumbnails">

                            </ul>
                        </div>
                    </div>
            </div>



  </body>
</html>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript">
 var  bandera=false; var indice=new Array(); var aux=new Array(); var aux1=new Array();
  jQuery(document).ready(function($) {
    $('#muestra').carousel({interval: 40000, pause:false });
      tiempo();
    $('#muestra').on('slid.bs.carousel', function (e) {
        var id = $('#muestra div.active').attr("alt");
        $(".span2").removeClass("activa");
        $("#carousel-selector-"+id).parent().addClass("activa");
    });
});

function tiempo(){
            $.post("util/colector.php",{accion:0},function(data){//carga de combobox
              dato=JSON.parse(data);var i=0;
              aux=dato[0];aux1=dato[1];
         Object.keys(aux).forEach(function(e) {
            indice[i]=e;i++; /* Key del Array*/
            },aux);
             var h=indice.length;
             indice.sort();
             menu(indice, h);
             constructor(aux[indice[h-1]]);
             constructor2(aux1[indice[h-1]]);
             });//fin del get
  }//FIN FUNCION

function constructor(dato){
  $(".carousel-inner").html("");
  $.each(dato, function( i, val ) { $(".carousel-inner").append(val); });
     $( ".carousel-item:first-child" ).addClass( "active" );
}

function constructor2(dato){
  $(".thumbnails").html(""); $.each(dato, function( i, val ) { $(".thumbnails").append(val);});
    return true;}

function menu(indice, h){
    $("#menu").html("");
    var i=0;
    while (i < (h-1)) {$("#menu").append('<button class="btn btn-default filter-button" onclick="cambiador('+i+')" alt="'+i+'">'+indice[i].toUpperCase().substring(1)+'</button>');i++;}
     $("#menu").append('<button id="asensor" class="btn btn-default filter-button animated infinite tada delay-2s" onclick="movimiento()"><i class="fa fa-angle-double-up" aria-hidden="true"></i></button>');
    return true;
  }

function cambiador(i){
  bandera=true;constructor(aux[indice[i]]);constructor2(aux1[indice[i]]);
}

function movimiento(){
 $(".persiana").css("max-height", $(window).height()-250);
  $(".persiana").toggle(function(){
    if($("#asensor i").hasClass("fa-angle-double-up") && $("#asensor").hasClass("tada")){
      $("#asensor").html('<i class="fa fa-angle-double-down" aria-hidden="true"></i>');
      $("#asensor").removeClass("tada");
    }else{$("#asensor").html('<i class="fa fa-angle-double-up" aria-hidden="true"></i>'); $("#asensor").addClass("tada");}});
}

function periodo(){
  var valor=indice.length-1;
  if(bandera===true){bandera=false;
  }else{if($(".persiana").is(":visible") || $(".carousel-inner").is(":hover") || $(".thumbnails li").attr("alt")=== "todo"){
          bandera=false;}else{cambiador(valor);}}
 }

function inicio(){cambiador(indice.length-1);}

function toma(id){}
</script>
