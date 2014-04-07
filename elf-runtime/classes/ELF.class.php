<?php
/**
 * The ELF Class is the magic heart, beating in our elf. Don't change it or use it reasonless.
 * @author Eric Marten
 */
class ELF
{
	/**
	 * This method is called when $_ELF is set. From this point on you can use debugging and request-stuff
	 */
	public function start()
	{

		#$this->_REQUEST=new RequestReader();
		#require_once($this->_init["inc"]."classes/ELF_Software.class.php"); // Funktioniert doch mit dem Autoloader

		set_include_path(dirname($this->_config["software"][0]));
		chdir(dirname($this->_config["software"][0]));
		require_once(basename($this->_config["software"][0]));

		$this->_SOFTWARE=new $this->_config["software"][1]();
		$this->_SOFTWARE->_software_init($this->_REQUEST->mode);

	}

	/*
	 * This kills the elf.. But it debugs before :)
	 * @parameter string $msg The kill message
	 */
	public function kill($msg)
	{
		$this->_DEBUG->add("<b style=\"color:red;\">".$msg."</b>");
		$this->_DEBUG->add(print_r($this,true));
		die ( $msg );#$this->_DEBUG->flush("<hr><h1>"."KILLED"."</h1><hr />") );
	}

	/**
	 * Shutdown is called before inc.php ends - after this ELF is useless.. it unsets itself! Every code should be executed as software!
	 */
	public function shutdown()
	{
		global $_ELF;

		$temp=  get_declared_classes();
		while ($temp[0]!="ELF")
		{
			array_shift($temp);
		}
		$this->_loadedClasses=$temp;
		$this->_includeDirectory=  get_include_path();
		$this->_loadedFiles=get_included_files();

		if ($this->_config["tmp_clean"]){$this->tmp_clean();}
		$this->_stopTime=  microtime(true);
		$this->_runTime=($this->_stopTime - $this->_startTime);
		$this->_runTimeMS=substr( ($this->_runTime/1000)  , 0 , 4)."ms";
		$_ELF->_DEBUG->add("Put ELF to sleep");
		if ($this->_config["debug_flush"]) {
			echo $this->_DEBUG->flush("<hr />"."<h1>DEBUG</h1>"."<hr />");
		}
		unset($_ELF);
	}



	/**
	 * Constructor Class
	 * @author Eric Marten
	 * @param array $data Data is fed by inc.php please do not make a new ELF elsewhere!
	 */
	public function __construct()
	{


	}
	public function pre_start($data)
	{


		$this->_config=array();
		$this->_classes=array();

		foreach ($data as $key => $val) { $this->_config[$key]=$val; }
		$this->_init=$data["_init"];


		$this->_startTime=microtime(true);
		ob_start();
		$this->_instance=date("d.m.Y-H.i.s").substr(microtime(true),strlen(time()))."_".md5(microtime(true).rand(1,9999));

		$this->_DEBUG=new DEBUG();
		$this->_DEBUG->add("Starting ELF in mode: ".$this->_config["mode"]);

		$this->_REQUEST=new RequestReader();

		$dir=$this->_config["data"]."/config/";
		$od=opendir($dir);
		$config_file=false;
		$config=array();
		while ($rd=readdir($od) AND !$config_file)
		{
			if (substr($rd,0,1)!=".")
			{
				include($dir.$rd);
				foreach ($config["alias"] as $a)
				{
					#if (fnmatch($a, $this->_REQUEST->getSiteURL()))
					if (fnmatch($a, $_SERVER["SERVER_NAME"].$this->_REQUEST->getBaseDirectory() ))
					{
						$config_file=$dir.$rd;
					}
				}
			}
		}
		closedir($od);
		$config=array();

		if ($config_file)
		{
			include($config_file);
			foreach ($config as $key => $value)
			{
				$this->_config[$key]=$value;
			}
		}
		else {
			$this->kill("No Config");
		}


		if (!isset($this->_DB) AND isset($this->_config["DB"]))
		{
			$type="mysql";

			if (isset($this->_config["DB"]["type"])) { $type=$this->_config["DB"]["type"]; }
			if (isset($this->_config["DB"]["prefix"])) { $prefix=$this->_config["DB"]["prefix"]; } else { $prefix=""; }

			if ($type=="mysql")
			{
				$arr=array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
			}
			else {
				$arr=array();
			}

			$status="unknown";
			if (isset($this->_config["status"]))
			{
				$status=$this->_config["status"];
			}

			$this->_DB=new PDO($type.":host=".$this->_config["DB"]["host"].";dbname=".$this->_config["DB"]["name"],$this->_config["DB"]["user"],$this->_config["DB"]["pass"],$arr);

			$this->_DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			define("DB_HOST",$this->_config["DB"]["host"]);
			define("DB_TYPE",$this->_config["DB"]["type"]);
			define("DB_NAME",$this->_config["DB"]["name"]);
			define("DB_USER",$this->_config["DB"]["user"]);
			define("DB_PASS",$this->_config["DB"]["pass"]);
			define("DB_PREFIX",$prefix);
			$this->_config["DB"]=array("data"=>"*secured*");#["pass"]='***';

			if ($status=="unknown" OR !$status)
			{
				$sql=$this->_DB->prepare("SHOW TABLES");
				$sql->execute();
				$all=$sql->fetchAll();
				$save=array();
				foreach ($all as $key => $val)
				{
					array_push($save,$val[0]);
				}
				unset($all);
				$this->_config["DB"]["_tables"]=$save;
			}

			$this->_config["DB"]["status"]=$status;


		}


		unset($data["_init"]);

	}
	public function __call($method,$args)
	{
		return call($this,$method,$args);
	}
	public function __destruct() {
		echo ob_get_clean();
		flush();
	}



}
