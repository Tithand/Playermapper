<?php
include('character.php');

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
# WEB
###############################################################################################
# Clean url feature. If you want enable this, please read!!!
# You must have the rewrite module on/enabled on your web server. (Apache/Nginx)
# Example: mywowsite.com/playermapper/outland  or  mywowsite.com/playermapper/azeroth
# rather than the ugly variables in the url. (www.mywowsite.com/playermapper?map=outland&ug=1)
# !!WARNING!! Enabling this feature without knowing what you are doing will throw your web
# into 500 internal server errors.
# If you want this feature, but don't have it enabled. please read here, I will not train you!
# apache -> http://httpd.apache.org/docs/current/mod/mod_rewrite.html
# or
# nginx -> http://nginx.org/en/docs/http/ngx_http_rewrite_module.html
###############################################################################################
'rewrite_module'  => 0,

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

$version =(object)array(
  'file' => '.git/refs/heads/master',
  'site' => 'https://github.com/CDawg/playermapper/',
  'hash' => 0
);
$git_hash = file_get_contents($version->file);
if (file_exists($version->file)) {
  $version->hash = substr($git_hash,0,7);
}

?>
