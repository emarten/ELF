<?php
  $_ELF=array(
    'init'=>__FILE__
  );
  
  include(dirname(__FILE__)."/elf-runtime/inc.php");

  echo "<hr />";  
  echo "<pre>".print_r($_ELF,true)."</pre>";
 
