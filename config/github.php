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
  echo '<!-- Playermapper: by CDawg commit: '.$version->hash.' Configured for Expansion:'.$config->expansion.'.x -->';
  echo '<a id="version" target="_blank" href="'.$version->site.'">'.$version->hash.'</a>';
}
?>
