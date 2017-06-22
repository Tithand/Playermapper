<?php

#TODO - list multiple realms for servers running different types

$config = (object) array(
#WEB
'host'     => "192.168.1.12",
#DATABASE
'port'  => "3306",
'user'  => "db_user",
'pass'  => 'db_pass',
'base'  => "characters",
'table' => "characters",
//revision will determine what map to load
'revision' => "3x",
);

$con = new mysqli($config->host, $config->user, $config->pass, $config->base, $config->port);
if ($con->connect_error){
  die("There was a problem connecting to the database:" . $con->connect_error);
} 

$result = $con->query('SELECT name, gender, class, race, level from '.$config->table.'');

if ($result->num_rows > 0)
{
  while($row = $result->fetch_assoc())
  {
    echo $row["name"];
    echo "<br>";
  }
}
else
{
  echo "no users online";
}

?>
