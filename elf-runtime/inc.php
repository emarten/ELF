<?php

	if (!isset($_ELF)){$_ELF=array();}

	$_ELF["_init"]=array();
	$_ELF["_init"]['script']=$_SERVER["SCRIPT_FILENAME"];
	$_ELF["_init"]["inc"]=dirname(__FILE__)."/";
	if (!isset($_ELF["mode"])) { $_ELF["mode"]="standalone"; }
	if (!isset($_ELF["tmp_age"])) { $_ELF["tmp_age"]="600"; }
	if (!isset($_ELF["debug"])) { $_ELF["debug"]=false; }
	if (!isset($_ELF["tmp_clean"])) { if ($_ELF["debug"]) { $bool=true; } else { $bool=false; } $_ELF["tmp_clean"]=$bool; }

	#if (!isset($_ELF["shutdown"])) { $_ELF["shutdown"]="\$_ELF->shutdown();"; }

	if (!isset($_ELF["debug_flush"])) { $_ELF["debug_flush"]=false; }



	function call($class,$method,$args)
	{
		global $_ELF;
		$class=get_class($class);
		$_ELF->_DEBUG->add($class."->".$method."(".print_r($args,true).");");
		$method_code=file_get_contents($_ELF->_init["inc"]."methods/".$class."/".$class.".".$method.".method.php");
		$pre_php=explode("<?php",$method_code);
		$vars=str_replace("\n","",trim($pre_php[0]));
		$vars=explode(";",$vars);
		$var_index=0;
		foreach ($vars as $var)
		{
			$var=trim($var);
			if (!empty($var))
			{
				$var.=";";
				$name=explode("=",$var);
				$name[1]=substr($var,strlen($name[0])+1 );
				if ($name[0]==$var)
				{
					$name[0]=explode(";",$name[0]);
					$name[0]=$name[0][0];
					// necessary
					if (!isset($args[$var_index]))
					{
						$_ELF->kill($class."->".$method.'() expected variable '.($var_index+1)." not set.");
					}
				}
				else {
					// optional
					$wert=substr($name[1],0,strlen($name[1])-1);
					#echo $wert;
				}
				if (isset($args[$var_index]))
				{
					$wert="\$args[\$var_index]";
				}
				eval($name[0]."=".$wert.";");
				$var_index++;
			}
		}

		eval("?>".substr($method_code,strlen($pre_php[0])));
	}

	function autoloading($class)
	{
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
		if ($class!="ELF" AND $class!="DEBUG")
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
	$_ELF->start($_ELF->_config["mode"]);
	$_ELF->test('');

	$_ELF->shutdown();

	