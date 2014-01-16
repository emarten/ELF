<?php

  if (!isset($_ELF)){$_ELF=array();}
  
  $_ELF["_init"]=array();
  $_ELF["_init"]['script']=$_SERVER["SCRIPT_FILENAME"];
  
  function call($class,$method,$args)
  {
    echo "calls ".$method." on ".get_class($class);
    print_r($args);
  }
  
  function autoloading($class){
    global $_ELF;
    $locations=array(dirname(__FILE__)."/classes/");
    if (isset($_ELF))
    {
      if(is_object($_ELF))
      {
        foreach($_ELF->_classes as $location)
        {
          array_push($locations,$location);
        }
      }
    }
    $found=false;
    foreach($locations as $location)
    {
      if (file_exists($location))
      {
        include($location.$class.".class.php");
        $found=true;
      }
    }
    if (isset($_ELF->_DEBUG))
    {
      if ($found)
      {
        $_ELF->_DEBUG->add('Loading class: '.$class);
      }
      else
      {
        $_ELF->_DEBUG->add("No class found: ".$class);
      }
    }
  }
  spl_autoload_register("autoloading");
  
  $_ELF=new ELF($_ELF);
  $_ELF->start("hello","world");
  