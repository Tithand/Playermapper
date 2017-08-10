<!DOCTYPE HTML>
<?php

$configpath = 'config/config.php';
$debugpath = 'ignore/config.php';
if (file_exists($configpath)){
  include_once($configpath);
}
else {
  if (file_exists($debugpath)){
    include_once($debugpath);
  }
  else {
    echo '<br><center>There was an error reading from the configuration file.<br>Did you rename config.php.dist to config.php and make the necessary changes?</center>';
    exit();
  }
}

$map = $_GET["map"];
$exp = $_GET["exp"]; //for debugging!!
if ($exp){
  $config->expansion = $exp;
}
$cache = $_GET["cache"]; //added to version control for cache busting static files for debugging (js/css/images/etc)
if (!$cache){$cache="";}

if (!$map){
  $map = "Azeroth";
}

$cachebust = $version->hash . $cache;

$map_json = $map;
$json = 'json/maps.json';
$map_defined = 0;
if (file_exists($json))
{
  $json = file_get_contents($json);
  $json = json_decode($json, TRUE);
  foreach ($json["maps"] as $name => $cont)
  {
    if ($cont["parent"]){
      $cont["name"] = $cont["parent"];
    }

    $maps[] = $cont["name"];

    if (($map == $cont["name"]) && (!$map_defined)){
      $map_defined = 1; //prevent duplicating
      $map_image = '<div class="map" id="'.strtolower($cont["name"]).'">';
      $map_size[0] = $cont["x_size"];
      $map_size[1] = $cont["y_size"];
      $head = '<head><style>
      body{background:url("images/swatch_'.strtolower($cont["name"]).'.jpg"); color:white; font-family:Muli; overflow:hidden;}
      #'.strtolower($cont["name"]).'{top:'.$cont["y_pos"].'px; left:'.$cont["x_pos"].'px; width:'.$cont["x_size"].'px; height:'.$cont["y_size"].'px; position:absolute; background:url("images/'.$config->expansion.'/'.strtolower($cont["name"]).'.jpg?v='.$cachebust.'") no-repeat; background-position:0px 0px; background-size:100% 100%;}
      </style>';
      $head .= '<script>function mapResetPos(){ $(".map").css({"top" : "'.$cont["y_pos"].'px", "left" : "'.$cont["x_pos"].'px"});}</script>';
    }
  }
  $cont = $json["maps"];
}

if (!in_array($map, $maps)){
  echo "<center><br>Error: No definition for that map name, did you spell it correctly?</center>";
  exit();
}

echo preg_replace('^  ^', '', $head);
?>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="javascripts/jquery-mousewheel-3.1.13/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="javascripts/playermapper.min.js?v=<?php echo $cachebust; ?>"></script>
<link rel="stylesheet" type='text/css' href="css/playermapper.min.css?v=<?php echo $cachebust; ?>">
<link rel="stylesheet" type='text/css' href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:200">
</head>
<body>
<?php

echo $map_image;

if ($map == "Azeroth")
{
  if ($config->expansion == 3){
    echo '<div id="dk_zone" style="top:259px; left:1416.43px"></div>';
  }
  else if ($config->expansion >= 4){ //DK zone was shifted with new Azeroth
    echo '<div id="dk_zone" style="top:258px; left:1414px; width:106px;"></div>';
  }
}

//zone boundaries and identification
$zone_json = $map;
if ($map == "Azeroth"){
  $zone_json = $config->expansion . '/Azeroth';
}
$json = 'json/'.strtolower($zone_json).'.json';
if (file_exists($json)){
  $json = file_get_contents($json);
  $json = json_decode($json, true);
  echo '<svg id="zone_matrix" style="width:'.$map_size[0].'px; height:'.$map_size[1].'px">';
  foreach ($json[0]["zone"] as $name => $zone){
    if ($zone["polygon"])
    {
      $zone_name = preg_replace("/[^A-Za-z0-9 ]/", "", $zone["name"]);
      echo '<defs><filter id="blur" x="0" y="0"><feGaussianBlur in="SourceGraphic" stdDeviation="2" /></filter></defs>';
      echo '<polygon class="zone-bind" name="'.strtolower($zone_name).'" id="zone_'.$zone["id"].'" filter="url(#blur)" onmouseover="zoneIdentity(\''.addslashes($map . " - " . $zone["name"]).'\')" onclick="zoneZoom(\'zone_'.$zone["id"].'\');" style="fill:'.$zone["color"].'" points="'.$zone["polygon"].'" />';
    }
  }
  echo '</svg>';
}

//All footprints are inside this div.
//The end of this div must be after the footprints, or the character matrix can not be adjusted from the map.
echo '<div id="char_matrix">';

$ap_gps = "";
if ($config->live_track){$ap_gps = "_gps";}

/*
$realm_dropdown = '<select class="field_dropdown">';
for ($d=0; $d<$n_realms; $d++){
  $realm_dropdown .= '<option>'.$realm_db[$d]->realm_name.'</option>';
}
$realm_dropdown .= '</select>';
*/

$p_total = $p_count = 0;
function footprint($char, $realm, $x, $y, $p_count)
{
  global $config, $race, $class;
  $special_class = "";
  if ($char[$realm]["wrath_zone"]){
    $special_class = " dk";
  }
  echo '<div class="fp'.$special_class.'" id="'.strtolower($char[$realm]["name"].'_'.$char[$realm]["realm_name"]).'" style="left:'.$x.'px; top:'.$y.'px;"><i class="fa fa-map-marker '.$race[$char[$realm]["race"]][1].'"></i>';
  if ($config->show_player_details){
    echo '<div class="fp_details"><b>'.$char[$realm]["name"].'</b> ['.$char[$realm]["realm_name"].']</br>'.$char[$realm]["level"].' '.$race[$char[$realm]["race"]][0].' '.$class[$char[$realm]["class"]][0].'</div>';
  }
  echo '<div class="fp_searchmarker" id="sm_'.$p_count.'" name="'.$char[$realm]["name"].' - '.$char[$realm]["realm_name"].'"></div>';
  echo '</div>';
}

for ($realm=0; $realm<$n_realms; $realm++)
{
  $table[$realm] = $DB[$realm]->query('SELECT name, race, gender, class, level, position_x, position_y, map, zone, instance_id from '.$realm_db[$realm]->table . $ap_gps.' WHERE name != ""');
  while($char[$realm] = $table[$realm]->fetch_assoc())
  {
    $p_total++;
    $char[$realm]["realm_name"] = $realm_db[$realm]->realm_name;

    if ($char[$realm]["zone"] == 4737) //Kezan
    {
      $char[$realm]["map"] = 1; //add footprint to Kalimdor
      $char[$realm]["cata_zone_0"] = 1;
    }
    else if ($char[$realm]["zone"] == 4720) //The Lost Isles
    {
      $char[$realm]["map"] = 1; //add footprint to Kalimdor
      $char[$realm]["cata_zone_1"] = 1;
    }

    if (($char[$realm]["map"] == 530) && ($char[$realm]["instance_id"] == 0))
    {
      if (($char[$realm]["zone"] == 4080) || //Isle of Quel'Danas
         ($char[$realm]["zone"] == 3487) || //Silvermoon City
         ($char[$realm]["zone"] == 3430) || //Eversong Woods
         ($char[$realm]["zone"] == 3433)) //Ghostlands
         {
           $char[$realm]["map"] = 0; //add footprint to Eastern Kingdoms
           $char[$realm]["tbc_zone_0"] = 1;
         }
      else if (($char[$realm]["zone"] == 3524) || //Azuremyst Isle
         ($char[$realm]["zone"] == 3557) || //Exodar
         ($char[$realm]["zone"] == 3525)) //Bloodmyst Isle
         {
           $char[$realm]["map"] = 1; //add footprint to Kalimdor
           $char[$realm]["tbc_zone_1"] = 1;
         }
    }
    else if ($char[$realm]["map"] == 609) //DK Starting area
    {
      $char[$realm]["map"] = 0; //add footprint to Eastern Kingdoms
      $char[$realm]["wrath_zone"] = 1;
    }
    else if ($char[$realm]["map"] == 860){ //The Wandering Isle
      $char[$realm]["map"] = 870; //add footprint to Pandaria
      $char[$realm]["mop_start"] = 1;
    }

    for ($i=0; $i<count($cont); $i++)
    {
      if ($cont[$i]["parent"]){$cont[$i]["name"] = $cont[$i]["parent"];}
      if (($map == $cont[$i]["name"]) && ($char[$realm]["map"] == $cont[$i]["map"]))
      {
        $cur_x = $char[$realm]["position_x"] - $cont[$i]["space_x"];
        $cur_y = $char[$realm]["position_y"] - $cont[$i]["space_y"];
        $x_pos = ceil($cur_x * $cont[$i]["grid_x"]);
        $y_pos = ceil($cur_y * $cont[$i]["grid_y"]);
        if ($char[$realm]["tbc_zone_0"])
        {
          $char_x = $cont[$i]["player_x_offset"] - $y_pos - 74;
          $char_y = $cont[$i]["player_y_offset"] - $x_pos + 66;
        }
        else if ($char[$realm]["tbc_zone_1"])
        {
          $char_x = $cont[$i]["player_x_offset"] - $y_pos - 578;
          $char_y = $cont[$i]["player_y_offset"] - $x_pos - 314;
        }
        else if ($char[$realm]["wrath_zone"])
        {
          $char_x = $cont[$i]["player_x_offset"] - $y_pos + 8;
          $char_y = $cont[$i]["player_y_offset"] - $x_pos;
        }
        else if ($char[$realm]["cata_zone_0"])
        { //TODO - currently static positioning until I figure out the grid sizing for the small islands
          $char_x = 735;
          $char_y = 530;
        }
        else if ($char[$realm]["cata_zone_1"])
        {
          $char_x = 690;
          $char_y = 502;
        }
        else if ($char[$realm]["mop_start"])
        {
          /*
          $cur_x = $char[$realm]["position_x"] - ($cont[$i]["space_x"] -240);
          $cur_y = $char[$realm]["position_y"] - ($cont[$i]["space_y"] -40);
          $x_pos = ceil($cur_x * ($cont[$i]["grid_x"]) -0.048102);
          $y_pos = ceil($cur_y * ($cont[$i]["grid_y"]) -0.048102);
          $char_x = $cont[$i]["player_x_offset"] - $y_pos - 195;
          $char_y = $cont[$i]["player_y_offset"] - $x_pos + 344;
          */
          $char_x = 140;
          $char_y = 736;
        }
        else
        {
          $char_x = $cont[$i]["player_x_offset"] - $y_pos;
          $char_y = $cont[$i]["player_y_offset"] - $x_pos;
        }
        $p_count++;
        footprint($char, $realm, $char_x, $char_y, $p_count);
      }
    }

  }
}

echo '</div>'; //The back map
echo '</div>'; //The div char_matrix has all footprints attached

echo '<div id="nav_menu">';

$ugly_url="?map=";
if ($config->rewrite_module){
  $ugly_url="";
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
<label><input type="checkbox" onclick="showCharMatrix()" checked />Show Players</label>
<br>
<label><input type="checkbox" onclick="showMapMatrix()" checked />Show Map</label>
<br>
<label><input type="checkbox" onclick="showMapZones()" />Show All Zones</label>';
if (($config->expansion >= 3) && ($map == "Azeroth")){
  echo '<br>
  <label><input type="checkbox" id="checkbox_dkstart" onclick="showDKZone()" checked />Show DK Start Area</label>';
}
if (!$config->show_all_realms){
  echo '<br><br>';
  echo 'Realm:<br>';
  echo $realm_dropdown;
}
echo '</div>';

echo '<div id="minimap">
<div id="minimap_title">'.$map.'</div>';
echo '<div class="mm_zone" id="mm_azeroth" onmouseover="zoneIdentity(\'Azeroth\')" onclick="location.href=\''.$ugly_url.'Azeroth\';"><img src="images/'.$config->expansion.'/minimap/azeroth.png?v='.$cachebust.'"></div>';
if ($config->expansion >= 2){
  echo '<div class="mm_zone" id="mm_outland" onmouseover="zoneIdentity(\'Outland\')" onclick="location.href=\''.$ugly_url.'Outland\';"><img src="images/'.$config->expansion.'/minimap/outland.png?v='.$cachebust.'"></div>';
}
if ($config->expansion >= 3){
  echo '<div class="mm_zone" id="mm_northrend" onmouseover="zoneIdentity(\'Northrend\')" onclick="location.href=\''.$ugly_url.'Northrend\';"><img src="images/'.$config->expansion.'/minimap/northrend.png?v='.$cachebust.'"></div>';
}
if ($config->expansion >= 4){
  echo '<div class="mm_zone" id="mm_deepholm" onmouseover="zoneIdentity(\'The Maelstorm [Deepholm]\')" onclick="location.href=\''.$ugly_url.'Deepholm\';"><img src="images/'.$config->expansion.'/minimap/deepholm.png?v='.$cachebust.'"></div>';
}
if ($config->expansion >= 5){
  echo '<div class="mm_zone" id="mm_pandaria" onmouseover="zoneIdentity(\'Pandaria\')" onclick="location.href=\''.$ugly_url.'Pandaria\';"><img src="images/'.$config->expansion.'/minimap/pandaria.png?v='.$cachebust.'"></div>';
}
if ($config->expansion >= 6){
  echo '<div class="mm_zone" id="mm_draenor" onmouseover="zoneIdentity(\'Draenor\')" onclick="location.href=\''.$ugly_url.'Draenor\';"><img src="images/'.$config->expansion.'/minimap/draenor.png?v='.$cachebust.'"></div>';
}
if ($config->expansion >= 7){
  echo '<div class="mm_zone" id="mm_brokenisles" onmouseover="zoneIdentity(\'Broken Isles\')" onclick="location.href=\''.$ugly_url.'BrokenIsles\';"><img src="images/'.$config->expansion.'/minimap/brokenisles.png?v='.$cachebust.'"></div>';
}
echo '<div id="minimap_details"><div style="float:left">'.$map.': <div id="map_count">0</div></div><div style="float:right; margin-right:15px;">Realm(s): '.$p_total.'</div>
</div>';

if (!$realm_db[0]->realm_name){
  echo '<br><center><i class="fa fa-warning"></i> There was an error reading from config/config.php</center>';
  exit();
}

echo '<div id="version">'.$version->hash.'</div>';
echo '<div id="expansion">'.$config->expansion.'</div>';
echo '<div id="console" class="scrollbar"><div id="console_title">Console</div>
<div id="console_data"></div></div>';
echo '<div id="help" onclick="openHelp()"><i class="fa fa-question-circle-o"></i>Tip: You can double click a zone to zoom in.</div>';
?>

<div id="search"><div id="search_cancel" onclick='search("cancel")'><i class="fa fa-close"></i></div><div id="search_btn" onclick='search("click")'><i class="fa fa-search"></i></div><input id="search_in" onkeydown="search(event)" placeholder="Search..." /></div>
</body>
