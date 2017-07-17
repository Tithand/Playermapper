<!DOCTYPE HTML>
<?php
include_once('ignore/config.php');

$map = $_GET["map"];
$cache = $_GET["cache"]; //added to version control for cache busting static files for debugging (js/css/images/etc)
if (!$cache){$cache="";}

if (!$map){
  $map = "Azeroth";
}

if ($map == "Outland"){
  $map_back = "#150016";
  $map_x_size = 900;
  $map_y_size = 900;
  $map_x_pos = 200;
  $map_y_pos = 0;
}
else if ($map == "Northrend"){
  $map_back = "#243c59";
  $map_x_size = 1000;
  $map_y_size = 800;
  $map_x_pos = 200;
  $map_y_pos = 0;
}
else{ //default - Azeroth
  $map_back = "#09232c";
  $map_x_size = 1250;
  $map_y_size = 900;
  $map_x_pos = 20;
  $map_y_pos = 0;
}

$cachebust = $version->hash . $cache;

//Notes: will have to use a background-position of map image for a css hack for the character matrix
?>

<head>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="javascripts/jquery-mousewheel-3.1.13/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="javascripts/jquery-mousewheel-3.1.13/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="javascripts/playermapper.min.js?v=<?php echo $cachebust; ?>"></script>
<link rel="stylesheet" type='text/css' href="css/playermapper.min.css?v=<?php echo $cachebust; ?>">
<link rel="stylesheet" type='text/css' href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<?php echo '<script>
function mapResetPos(){
  $(".map").css({"top" : "'.$map_y_pos.'px", "left" : "'.$map_x_pos.'px"});
}
</script>';
?>
<style>
body{background:<?php echo $map_back; ?>; color:white; font-family:Arial; overflow:hidden;}
#northrend{top:<?php echo $map_y_pos; ?>px; left:<?php echo $map_x_pos; ?>px; width:<?php echo $map_x_size; ?>px; height:<?php echo $map_y_size; ?>px; position:absolute; background:url("images/<?php echo $config->expansion; ?>/northrend.jpg?v=<?php echo $cachebust; ?>") no-repeat; background-position:0px 0px; background-size:100% 100%; z-index:-1}
#azeroth {top:<?php echo $map_y_pos; ?>px; left:<?php echo $map_x_pos; ?>px; width:<?php echo $map_x_size; ?>px; height:<?php echo $map_y_size; ?>px; position:absolute; background:url("images/<?php echo $config->expansion; ?>/azeroth.jpg?v=<?php echo $cachebust; ?>") no-repeat; background-position:0px 0px; background-size:100% 100%; z-index:-1;}
#outland{top:<?php echo $map_y_pos; ?>px; left:<?php echo $map_x_pos; ?>px; width:<?php echo $map_x_size; ?>px; height:<?php echo $map_y_size; ?>px; position:absolute; background:url("images/<?php echo $config->expansion; ?>/outland.jpg?v=<?php echo $cachebust; ?>") no-repeat; background-position:0px 0px; background-size:100% 100%; z-index:-1;}
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

for ($realm=0; $realm<$n_realms; $realm++)
{
  //$result = $DB->query('SELECT name, race, gender, class, level, position_x, position_y, map from '.$config->table . $ap_gps.' WHERE online >= 1 AND name != ""');
  //$table[$realm] = $DB[$realm]->query('SELECT name, race, gender, class, level, position_x, position_y, map from '.$config->table . $ap_gps.' WHERE name = "Tygrae"');
  $table[$realm] = $DB[$realm]->query('SELECT name, race, gender, class, level, position_x, position_y, map from '.$realm_db[$realm]->table . $ap_gps.' WHERE name = "Tygrae"');
  while($char[$realm] = $table[$realm]->fetch_assoc())
  {
    $char[$realm]["realm_name"] = $realm_db[$realm]->realm_name;
    if ($map == "Outland") //530
    {
      /*
      $cur_x = $char["position_x"] - 1565;
      $cur_y = $char["position_y"] - 8115;
      $x_pos = ceil($cur_x * 0.075842);
      $y_pos = ceil($cur_y * 0.078882);
      $char_x = 400 - $y_pos;
      $char_y = 333 - $x_pos;
      */
      $cur_x = $char[$realm]["position_x"] - 1425;
      $cur_y = $char[$realm]["position_y"] - 8015;
      $x_pos = ceil($cur_x * 0.079842);
      $y_pos = ceil($cur_y * 0.078882);
      $char_x = 180 - $y_pos;
      $char_y = 320 - $x_pos;
    }
    else if ($map == "Northrend") //601
    {
      $cur_x = $char[$realm]["position_x"] - 1565;
      $cur_y = $char[$realm]["position_y"] - 8115;
      $x_pos = ceil($cur_x * 0.075842);
      $y_pos = ceil($cur_y * 0.078882);
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
        $x_pos = ceil($cur_x * 0.031142);
        $y_pos = ceil($cur_y * 0.027482);
        $char_x = 129 - $y_pos;
        $char_y = 408 - $x_pos;
      }
      else //Eastern Kingdoms
      {
        $cur_x = $char["position_x"] - 1865;
        $cur_y = $char["position_y"] - 7985;
        $x_pos = ceil($cur_x * 0.028142);
        $y_pos = ceil($cur_y * 0.025882);
        $char_x = 912 - $y_pos;
        $char_y = 338 - $x_pos;
      }
      */
      if ($char[$realm]["map"] == 1) //Kalimdor
      {
        $cur_x = $char[$realm]["position_x"] - 1565;
        $cur_y = $char[$realm]["position_y"] - 8115;
        $x_pos = ceil($cur_x * 0.031142);
        $y_pos = ceil($cur_y * 0.027482);
        $char_x = 36 - $y_pos;
        $char_y = 402 - $x_pos;
      }
      else //Eastern Kingdoms
      {
        $cur_x = $char[$realm]["position_x"] - 1865;
        $cur_y = $char[$realm]["position_y"] - 7985;
        $x_pos = ceil($cur_x * 0.028142);
        $y_pos = ceil($cur_y * 0.025882);
        $char_x = 812 - $y_pos;
        $char_y = 327 - $x_pos;
      }
    }
    //echo '<div class="footprint '.$race[$char["race"]][1].'" style="left:'.$char_x.'px; top:'.$char_y.'px;">';
    echo '<div class="footprint" style="left:'.$char_x.'px; top:'.$char_y.'px;"><i class="fa fa-map-marker '.$race[$char[$realm]["race"]][1].'"></i>';
    if ($config->show_player_details){
      echo '<div class="details">'.$char[$realm]["name"].' ['.$char[$realm]["realm_name"].']</br>'.$char[$realm]["level"].' '.$race[$char[$realm]["race"]][0].' '.$class[$char[$realm]["class"]][0].'</div>';
    }
    echo '</div>';
  }
}

echo '</div>'; //The back map
echo '</div>'; //The div char_matrix has all footprints attached
echo '<div id="nav_menu">';

$ugly_url="?map=";
if ($config->rewrite_module){
  $ugly_url="";
}

if ($map == "Outland"){
  echo '<div id="nav_right" class="nav_button_flash" onclick="location.href=\''.$ugly_url.'Azeroth\';"><i class="fa fa-chevron-up"></i><br>Azeroth</div>';
}
else if ($map == "Northrend"){
  echo '<div id="nav_bot" class="nav_button_flash" onclick="location.href=\''.$ugly_url.'Azeroth\';">Azeroth<br><i class="fa fa-chevron-down"></i></div>';
}
else {
  echo '<div id="nav_top" class="nav_button_flash" onclick="location.href=\''.$ugly_url.'Northrend\';"><i class="fa fa-chevron-up"></i><br>Northrend</div>';
  echo '<div id="nav_left" class="nav_button_flash" onclick="location.href=\''.$ugly_url.'Outland\';"><i class="fa fa-chevron-up"></i><br>Outland</div>';
}

echo '<center>
<div id="nav_title">'.$map.'</div>
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
<div class="nav_div"></div>
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
</div>';

if ($version->hash){
  echo '<a id="version" target="_blank" href="'.$version->site.'">'.$version->hash.'</a>';
}

?>
