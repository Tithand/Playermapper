<?php
#Please give credit where credit is due when modifying this version control.
#read THANKS
$version =(object)array(
  'file' => '.git/refs/heads/master',
  'site' => 'https://github.com/CDawg/playermapper/',
  'hash' => 0
);
$git_hash = file_get_contents($version->file);
if (file_exists($version->file)) {
$version->hash = substr($git_hash,0,7);
echo '<!-- Playermapper: by CDawg [commit: '.$version->hash.'] '.$version->site.'
Configured for Expansion:'.$config->expansion.'.x -->
';
} else {
  $version->hash = date("Ymd");
}
?>
