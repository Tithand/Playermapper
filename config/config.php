<?php

# TODO Notes:
#- list multiple realms for servers running different types
#- caching, json generated local file
#- add other expansions

$config = (object) array(
###############################################################################################
# DATABASE
###############################################################################################
# recommend using a read-only account to read your database
#
'host'  => "127.0.0.1",
'port'  => "3306",
'user'  => "db_user",
'pass'  => 'db_pass',
'base'  => "characters",
'table' => "characters",
###############################################################################################

###############################################################################################
# EXPANSION
###############################################################################################
# What expansion map to load !!!Currently only working for wrath(3x) and lower expansions!!!
# 1 = Classic
# 3 = Burning Crusade & Wrath of the Lich King
# 4 = Cataclysm
# 5 = Mists of Pandaria
# 7 = Warlords of Draenor & Legion
#
'expansion' => 3,
###############################################################################################

###############################################################################################
# LIVE TRACKING
###############################################################################################
# Track player positions live.
# Please read the README.md instructions on installing the new table and code change
# disabled by default. Disabled will only track players on logging out
#
'live_track' => 0,

###############################################################################################
# MAP PLAYER DETAILS
###############################################################################################
# Show GM players that are online - disabled by default
# Show offline players - disabled by default !!Use cautiously
# Show player details while hovering over the player on map
#
'show_online_GMs'      => 0,
'show_offline_players' => 0,
'show_player_details'  => 1,
###############################################################################################

);

$DB = new mysqli($config->host, $config->user, $config->pass, $config->base, $config->port);

if ($DB->connect_error){
  die("There was a problem connecting to the database:" . $DB->connect_error);
}

$git_hash = file_get_contents('.git/refs/heads/master');
$version = substr($git_hash,0,7);
?>
