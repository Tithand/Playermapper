<!DOCTYPE HTML>
<?php
include_once('config/config.php');

$map = $_GET["map"];
$debug= $_GET["debug"];

#GRID - used for dbugging and position map to identify true center
$grid_color = "transparent";
$grid_count = 100;
$grid_x_size = 10;
$grid_y_size = 10;
$grid_x_pos = 0;
$grid_y_pos = 0;

#AZEROTH

#NORTHREND

$grid_count = 100;
$grid_x_size = 10;
$grid_y_size = 10;
$grid_x_pos = 0;
$grid_y_pos = 0;

#OUTLANDS
$map_back = "#150016";
$map_x_size = 900;
$map_y_size = 900;
$map_x_pos = 200;
$map_y_pos = 50;

if ($debug){
  $grid_color = "#fff";
}

?>

<head>
  <style>
  body{background:<?php echo $map_back; ?>; color:white; font-family:Arial;}
  #outland {top:<?php echo $map_y_pos; ?>px; left:<?php echo $map_x_pos; ?>px; width:<?php echo $map_x_size; ?>px; height:<?php echo $map_y_size; ?>px; position:absolute; background:url("images/3x/outland.jpg") no-repeat; background-position:0px 0px; background-size:100% 100%; z-index:-1;}
  #azeroth {top:<?php echo $map_y_pos; ?>px; left:<?php echo $map_x_pos; ?>px; width:<?php echo $map_x_size; ?>px; height:<?php echo $map_y_size; ?>px; position:absolute; background:url("images/3x/azeroth.jpg") no-repeat; background-position:0px 0px; background-size:100% 100%; z-index:-1;}
  #northrend{top:<?php echo $map_y_pos; ?>px; left:<?php echo $map_x_pos; ?>px; width:<?php echo $map_x_size; ?>px; height:<?php echo $map_y_size; ?>px; position:absolute; background:url("images/3x/northrend.jpg") no-repeat; background-position:0px 0px; background-size:100% 100%; z-index:-1}
  .footprint{width:5px; height:5px; position:absolute; background:white; left:0px; top:0px; border:1px solid black; border-radius:25px; box-shadow:0px 0px 2px 1px #000; z-index:2;}
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

if ($map == "outland"){
  echo '<div id="outland"></div>';
  echo '<div id="footprint"></div>';
}
else {
  echo '<div id="azeroth"></div>';
}

$result = $DB->core->query('SELECT name, race, gender, level, position_x, position_y, map from '.$config->table.' where name="Tygrae"');
while($char = $result->fetch_assoc())
{
  $cur_x = $char["position_x"] - 1865;
  $cur_y = $char["position_y"] - 8115;
  $x_pos = round($cur_x * 0.075842);
  $y_pos = round($cur_y * 0.075842);
  $char_x = 405 - $y_pos;
  $char_y = 365 - $x_pos;
  echo '<div class="footprint" style="left:'.$char_x.'px; top:'.$char_y.'px;"></div>';
}

//table headers are not necessary, uonly need them for debug cursor position tracking
if ($debug){
  echo '<table class="grid">';
  echo '<th>';
  for ($h=$grid_y_start+1; $h<$grid_count; $h++){
    echo '<th>';
  }
  for ($c=$grid_y_start+1; $c<$grid_count; $c++){
    echo '<tr>';
    echo '<td>';
    for ($r=$grid_x_start; $r<$grid_count-1; $r++){
      $hr = $r+1;
      echo '<td>';
    }
  }
  echo '</table>';
}


?>
