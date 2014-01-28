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
		$this->_DEBUG=new DEBUG();
		$this->_DEBUG->add("Starting ELF in mode: ".$this->_config["mode"]);
		$this->_REQUEST=new RequestReader();
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
		if ($this->_config["tmp_clean"]){$this->tmp_clean();}
		$this->_stopTime=  microtime(true);
		$this->_runTime=($this->_stopTime - $this->_startTime);
		$this->_runTimeMS=substr( ($this->_runTime/1000)  , 0 , 4)."ms";
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
	public function __construct($data)
	{
		$this->_startTime=microtime(true);
		ob_start();
		$this->_instance=date("d.m.Y-H.i.s").substr(microtime(true),strlen(time()))."_".md5(microtime(true).rand(1,9999));
		$this->_init=$data["_init"];
		unset($data["_init"]);
		$this->_config=array();
		$this->_classes=array();
		foreach ($data as $key => $val) { $this->_config[$key]=$val; }

	}
	public function __call($method,$args)
	{
		call($this,$method,$args);
	}
	public function __destruct() {
		echo ob_get_clean();
		flush();
	}



}
