<?php

#TODO - list multiple realms for servers running different types

$config = (object) array(
#WEB
'host'  => "192.168.1.12",
#DATABASE
'port'  => "3306",
'user'  => "db_user", //recommend using a read-only db account
'pass'  => 'db_pass',
'base'  => "characters",
'table' => "characters",
'gps'   => "character_gps",
#REVISION - will determine what map to load
'revision' => "3x",
);

$DB = (object) array(
'core'=> new mysqli($config->host, $config->user, $config->pass, $config->base, $config->port),
'gps' => new mysqli($config->host, $config->user, $config->pass, $config->gps, $config->port),
);

if ($DB->core->connect_error){
  die("There was a problem connecting to the database:" . $DB->core->connect_error);
} 

?>
