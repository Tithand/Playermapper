#!/usr/bin/php
<?php
#Thrown together by - CDawg
error_reporting(E_ERROR | E_PARSE);

$file = strtolower($argv[1]);
if (!$file){
  echo "Error: Please specify a javascript filename\n";
  return;
}

echo "Warning! Be sure that all comments are stripped from javascript and place with /* comments */ \n";

$handle = fopen($file, "r");
if ($handle)
{
  $filterExt = preg_replace('^.js^', '', $file);
  echo "Minifying $file => $filterExt.min.js\n";
  while (($line = fgets($handle)) !== false)
  {
    $line = preg_replace("/(\r\n|\n|\r|\t)/i", '', $line);
    $line = preg_replace('^  ^', '', $line); //double line
    $line = preg_replace('^   ^', '', $line); //triple line
    $line = preg_replace('^if \(^', 'if(', $line);
    $line = preg_replace('^else \(^', 'else(', $line);
    //$line = preg_replace('^ \+ ^', '+', $line);
    $line = preg_replace('^\+ ^', '+', $line);
    $line = preg_replace('^ \+^', '+', $line);
    $line = preg_replace('^ = ^', '=', $line);
    $line = preg_replace('^ == ^', '==', $line);
    $line = preg_replace('^\*\/^', '*/
', $line);
    //$line = preg_replace('^function \(^', 'function(', $line);
    $newfile .= $line;

    file_put_contents(''.$filterExt.'.min.js', '/*! Playermapper - CDawg ['.date("Ymd").'] */
'.$newfile.'');
  }
  fclose($handle);
}
else {
  echo "Error: No javascript named '$file' to process!\n";
}

?>
