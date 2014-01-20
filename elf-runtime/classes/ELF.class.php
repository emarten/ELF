<?php

class ELF
{
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
	public function start()
	{
		$this->_DEBUG=new DEBUG();
		$this->_DEBUG->add("Starting ELF in mode: ".$this->_config["mode"]);
		$this->_REQUEST=new RequestReader();
	}
	public function __call($method,$args)
	{
		call($this,$method,$args);
	}
	public function kill($msg)
	{
		$this->_DEBUG->add("<b style=\"color:red;\">".$msg."</b>");
		die ( $this->_DEBUG->flush("<hr><h1>"."KILLED"."</h1><hr />") );
	}

	public function shutdown()
	{
		if ($this->_config["tmp_clean"]){$this->tmp_clean();}
		$this->_stopTime=  microtime(true);
		$this->_runTime=($this->_stopTime - $this->_startTime);
		$this->_runTimeMS=substr( ($this->_runTime/1000)  , 0 , 4)."ms";
		if ($this->_config["debug_flush"]) {
			echo $this->_DEBUG->flush("<hr />"."<h1>DEBUG</h1>"."<hr />");
		}
	}

	public function __destruct() {
		echo ob_get_clean();
		flush();
	}



}