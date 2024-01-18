<?php

function prevd( $object, $label = NULL){
  if ($label) echo "<div><span style=\"border:1px solid #ccc; font-size: 1.1em; font-family: monospace; font-weight:bold; color: #222; border-radius: 4px; padding:3px 10px; display:inline-block;margin-bottom: 10px;\">$label</span></div>";
  echo '<pre>';
  var_dump($object);
  echo '</pre><br>';
}