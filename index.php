<!DOCTYPE HTML>
<?php
include_once('ignore/config.php');
//include_once('config/character.php');

$map = $_GET["map"];
if (!$map){
  $map = "Azeroth";
}

#GRID - used for debugging and position map to identify true center
$grid_color = "transparent";
$grid_count = 100;
$grid_x_size = 10;
$grid_y_size = 10;
$grid_x_pos = 0;
$grid_y_pos = 0;

if ($map == "Outland")
{
  $map_back = "#150016";
  $map_x_size = 900;
  $map_y_size = 900;
  $map_x_pos = 200;
  $map_y_pos = 0;
}
else if ($map == "Northrend")
{
  $map_back = "#003043";
  $map_x_size = 1000;
  $map_y_size = 1000;
  $map_x_pos = 200;
  $map_y_pos = 0;
}
else
{
  //default - Azeroth
  $map_back = "#09232c";
  $map_x_size = 1250;
  $map_y_size = 900;
  $map_x_pos = 20;
  $map_y_pos = 0;
}

//will have to use a background-position of map for a css hack for the character matrix
?>

<head>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="javascripts/jquery-mousewheel-3.1.13/jquery.mousewheel.min.js"></script>
<link rel="stylesheet" type='text/css' href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<?php echo '<script>
function mapResetPos(){
  $(".map").css({"top" : "'.$map_y_pos.'px", "left" : "'.$map_x_pos.'px"});
}
</script>';
?>
<script>
var zoom = 100;
var zoom_max = 250;
var zoom_min = 25;
var map_x = map_y = map_drag_x = map_drag_y = 0;
$( function() {
  $("#nav_menu").draggable();
  $(".map").draggable({
    cursor:"move",
    drag: function(){
      var offset = $(this).offset();
      map_drag_x = offset.left;
      map_drag_y = offset.top;
    }
  });

  $(window).mousewheel(function(turn, delta)
  {
    if (delta == 1){
      if (zoom>zoom_max-5)return false;
      zoom+=5;
    }
    else {
      if (zoom<zoom_min+5)return false;
      console.log(zoom);
      zoom-=5;
    }
    $(".map").css("zoom", zoom + "%");
    $("#zoom_val").text(zoom+"%");
    return false;
  });

});

function mapShift(dir)
{
  if (dir == 1){
    map_y +=50;
    $('.map').css("top", map_y + map_drag_y);
  }
  else if (dir == 2){
    map_y -=50;
    $('.map').css("top", map_y + map_drag_y);
  }
  else if (dir == 3){
    map_x +=50;
    $('.map').css("left", map_x + map_drag_x);
  }
  else if (dir == 4){
    map_x -=50;
    $('.map').css("left", map_x + map_drag_x);
  }
  else {
    map_x = map_y = map_drag_x = map_drag_y = 0;
    mapResetPos();
  }
}

function mapZoom(zdir)
{
  if (zoom >= zoom_max)
  {
    zoom=zoom_max-1; //this is so that the zoom doesnt get stuck in max
    return;
  }
  if (zoom <= zoom_min){
    zoom=zoom_min+1;  //this is so that the zoom doesnt get stuck in min
    return
  }
  if (zdir == 2) zoom+=5;
  else if (zdir == 1) zoom-=5.0;
  else zoom=100;
  $(".map").css("zoom", zoom + "%");
  $("#zoom_val").text(zoom+"%");
}
</script>

<style>
body{background:<?php echo $map_back; ?>; color:white; font-family:Arial; overflow:hidden;}
.map{opacity:1.0; border:1px dashed transparent; border-radius:25px;}
#char_matrix{position:absolute;} /*Used to shift all character footprints and attach to map*/
#outland{top:<?php echo $map_y_pos; ?>px; left:<?php echo $map_x_pos; ?>px; width:<?php echo $map_x_size; ?>px; height:<?php echo $map_y_size; ?>px; position:absolute; background:url("images/<?php echo $config->expansion; ?>/outland.jpg?v=<?php echo $version; ?>") no-repeat; background-position:0px 0px; background-size:100% 100%; z-index:-1;}
#azeroth {top:<?php echo $map_y_pos; ?>px; left:<?php echo $map_x_pos; ?>px; width:<?php echo $map_x_size; ?>px; height:<?php echo $map_y_size; ?>px; position:absolute; background:url("images/<?php echo $config->expansion; ?>/azeroth.jpg?v=<?php echo $version; ?>") no-repeat; background-position:0px 0px; background-size:100% 100%; z-index:-1;}
#northrend{top:<?php echo $map_y_pos; ?>px; left:<?php echo $map_x_pos; ?>px; width:<?php echo $map_x_size; ?>px; height:<?php echo $map_y_size; ?>px; position:absolute; background:url("images/<?php echo $config->expansion; ?>/northrend.jpg?v=<?php echo $version; ?>") no-repeat; background-position:0px 0px; background-size:100% 100%; z-index:-1}

#nav_menu{top:50px; left:50px; width:150px; height:185px; position:fixed; padding-top:4px; background:#000; border:1px solid #dedede; font-size:11pt; opacity:0.4;}
.nav_button{border:1px solid #dedede; width:20px; height:20px; border-radius:4px; font-size:11pt; color:white; text-align:center; line-height:20px;}
.nav_button:hover{background:#74f7ff; border:1px solid #74f7ff; color:#000; box-shadow:0px 0px 1px 1px #fff; cursor:pointer;}
.nav_button:activate{background:#fff; border:1px solid #fff; color:#000;}
#nav_top{position:absolute; width:150px; background:#000; height:34px; margin-top:-45px; margin-left:-1px; border:1px solid #dedede; border-top-left-radius:6px; border-top-right-radius:6px; text-align:center;}
#nav_top:hover{background:#74f7ff; color:#000; cursor:pointer; box-shadow:0px 0px 1px 1px #fff;}
#nav_bot{position:absolute; width:150px; background:#000; height:34px; margin-top:190px; margin-left:-1px; border:1px solid #dedede; border-bottom-left-radius:6px; border-bottom-right-radius:6px; text-align:center;}
#nav_bot:hover{background:#74f7ff; color:#000; cursor:pointer; box-shadow:0px 0px 1px 1px #fff;}
#nav_left{position:absolute; width:150px; background:#000; height:34px; margin-top:53px; margin-left:-98px; border:1px solid #dedede; border-top-left-radius:6px; border-top-right-radius:6px; text-align:center; -ms-transform: rotate(270deg); -webkit-transform: rotate(270deg); transform: rotate(270deg);}
#nav_left:hover{background:#74f7ff; color:#000; cursor:pointer; box-shadow:0px 0px 1px 1px #fff;}
#nav_right{position:absolute; width:150px; background:#000; height:34px; margin-top:53px; margin-left:95px; border:1px solid #dedede; border-top-left-radius:6px; border-top-right-radius:6px; text-align:center; -ms-transform: rotate(90deg); -webkit-transform: rotate(90deg); transform: rotate(90deg);}
#nav_right:hover{background:#74f7ff; color:#000; cursor:pointer; box-shadow:0px 0px 1px 1px #fff;}

#version{position:fixed; top:100%; left:100%; margin-top:-20px; margin-left:-75px; font-size:8pt; color:#15487e;}#version:hover{color:#3dc5ff}
.footprint{position:absolute; left:0px; top:0px; text-shadow: 0px 0px 1px #FFF;}
.footprint i:hover{color:#FFF; zoom:1.4; margin-top:-3px; margin-left:-1px;}
.footprint:hover .details{display:inline; z-index:10;}
.details{display:none; white-space: nowrap; position:absolute; background:#000; border:1px solid white; border-radius:4px; margin-top:10px; margin-left:10px; padding:4px; font-size:10pt; font-family:Arial; z-index:10; opacity:0.7;}
.Alliance{color:#148bff;}
.Horde{color:#e60d31;}
.grid {position:absolute; top:<?php echo $grid_y_pos; ?>px; left:<?php echo $grid_x_pos; ?>px; border-collapse:collapse; opacity:0.1; font-family:Arial;}
.grid td,th{padding:0px; width:<?php echo $grid_x_size; ?>px; height:<?php echo $grid_y_size; ?>px; border:1px solid <?php echo $grid_color; ?>;}
.grid tr{padding:0px; width:<?php echo $grid_x_size; ?>px; height:<?php echo $grid_y_size; ?>px;}
.grid tr:hover{background-color:<?php echo $grid_color; ?>;}
.grid td, th{position: relative;}
.grid td:hover::after{background-color:<?php echo $grid_color; ?>; content:'\00a0'; height:5000px; left:0; position:absolute; top:-5000px; width:100%; cursor:pointer; z-index:-1;}
.grid td:hover .coord{display:inline;}
.coord{display:none; position:absolute; background:#4d4d4d; font-size:10pt; color:white; margin-top:-20px; margin-left:10px;}
</style>
</head>

<?php

if ($map == "Outland"){
  echo '<div class="map" id="outland">';
}
else if ($map == "Northrend"){
  echo '<div class="map" id="northrend">';
}
else {
  echo '<div class="map" id="azeroth">';
}

//All footprints are inside this div.
//The end of this div must be after the footprints, or the character matrix can not be adjusted from the map.
echo '<div id="char_matrix">';

$ap_gps = "";
if ($config->live_track){$ap_gps = "_gps";}

//$result = $DB->query('SELECT name, race, gender, class, level, position_x, position_y, map from '.$config->table . $ap_gps.' WHERE online >= 1 AND name != ""');
$result = $DB->query('SELECT name, race, gender, class, level, position_x, position_y, map from '.$config->table . $ap_gps.' WHERE name = "Tygrae"');
while($char = $result->fetch_assoc())
{
  if ($map == "Outland") //530
  {
    /*
    $cur_x = $char["position_x"] - 1565;
    $cur_y = $char["position_y"] - 8115;
    $x_pos = round($cur_x * 0.075842);
    $y_pos = round($cur_y * 0.078882);
    $char_x = 400 - $y_pos;
    $char_y = 333 - $x_pos;
    */
    $cur_x = $char["position_x"] - 1425;
    $cur_y = $char["position_y"] - 8015;
    $x_pos = round($cur_x * 0.079842);
    $y_pos = round($cur_y * 0.078882);
    $char_x = 180 - $y_pos;
    $char_y = 320 - $x_pos;
  }
  else if ($map == "Northrend") //601
  {
    $cur_x = $char["position_x"] - 1565;
    $cur_y = $char["position_y"] - 8115;
    $x_pos = round($cur_x * 0.075842);
    $y_pos = round($cur_y * 0.078882);
    $char_x = 400 - $y_pos;
    $char_y = 333 - $x_pos;
  }
  else
  { //Kalimdor
    /*
    if ($char["map"])
    {
      $cur_x = $char["position_x"] - 1565;
      $cur_y = $char["position_y"] - 8115;
      $x_pos = round($cur_x * 0.031142);
      $y_pos = round($cur_y * 0.027482);
      $char_x = 129 - $y_pos;
      $char_y = 408 - $x_pos;
    }
    else //Eastern Kingdoms
    {
      $cur_x = $char["position_x"] - 1865;
      $cur_y = $char["position_y"] - 7985;
      $x_pos = round($cur_x * 0.028142);
      $y_pos = round($cur_y * 0.025882);
      $char_x = 912 - $y_pos;
      $char_y = 338 - $x_pos;
    }
    */
    if ($char["map"] == 1) //Kalimdor
    {
      $cur_x = $char["position_x"] - 1565;
      $cur_y = $char["position_y"] - 8115;
      $x_pos = round($cur_x * 0.031142);
      $y_pos = round($cur_y * 0.027482);
      $char_x = 36 - $y_pos;
      $char_y = 402 - $x_pos;
    }
    else //Eastern Kingdoms
    {
      $cur_x = $char["position_x"] - 1865;
      $cur_y = $char["position_y"] - 7985;
      $x_pos = round($cur_x * 0.028142);
      $y_pos = round($cur_y * 0.025882);
      $char_x = 812 - $y_pos;
      $char_y = 327 - $x_pos;
    }
  }
  //echo '<div class="footprint '.$race[$char["race"]][1].'" style="left:'.$char_x.'px; top:'.$char_y.'px;">';
  echo '<div class="footprint" style="left:'.$char_x.'px; top:'.$char_y.'px;"><i class="fa fa-map-marker '.$race[$char["race"]][1].'"></i>';
  if ($config->show_player_details){
    echo '<div class="details">'.$char["name"].'</br>'.$char["level"].' '.$race[$char["race"]][0].' '.$class[$char["class"]][0].'</div>';
  }
  echo '</div>';
}

echo '</div>'; //The back map
echo '</div>'; //The div char_matrix has all footprints attached
echo '<div id="nav_menu">';

$ugly_url="?map=";
if ($config->rewrite_module){
  $ugly_url="";
}

if ($map == "Outland"){
  echo '<div id="nav_right" onclick="location.href=\''.$ugly_url.'Azeroth\';"><i class="fa fa-chevron-up"></i><br>Azeroth</div>';
}
else if ($map == "Northrend"){
  echo '<div id="nav_bot" onclick="location.href=\''.$ugly_url.'Azeroth\';">Azeroth<br><i class="fa fa-chevron-down"></i></div>';
}
else {
  echo '<div id="nav_top" onclick="location.href=\''.$ugly_url.'Northrend\';"><i class="fa fa-chevron-up"></i><br>Northrend</div>';
  echo '<div id="nav_left" onclick="location.href=\''.$ugly_url.'Outland\';"><i class="fa fa-chevron-up"></i><br>Outland</div>';
}

echo '<center>
'.$map.'
<br>
<table>
<tr>
<td><td><div class="nav_button" onclick="mapShift(1)"><i class="fa fa-chevron-up"></i></div><td>
<tr>
<td><div class="nav_button" onclick="mapShift(3)"><i class="fa fa-chevron-left"></i></div>
<td><div class="nav_button" onclick="mapShift(0)"><i class="fa fa-arrows-alt"></i></div>
<td><div class="nav_button" onclick="mapShift(4)"><i class="fa fa-chevron-right"></i></div>
<tr>
<td><td><div class="nav_button" onclick="mapShift(2)"><i class="fa fa-chevron-down"></i></div><td>
</table>
<table>
<td><div class="nav_button" onclick="mapZoom(2)"><i class="fa fa-search-plus"></i></div>
<td><div class="nav_button" onclick="mapZoom(0)" id="zoom_val" style="width:60px; font-size:11pt">100%</div>
<td><div class="nav_button" onclick="mapZoom(1)"><i class="fa fa-search-minus"></i></div>
</table>
</center>
<br>
<label><input type="checkbox" checked /> Show Characters</label>
<br>
<label><input type="checkbox" checked /> Show Map</label>
</div>

<a id="version" target="_blank" href="https://github.com/CDawg/playermapper/">'.$version.'</a>';

?>
