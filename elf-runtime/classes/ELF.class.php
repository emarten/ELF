<?php

class ELF
{
	public function __construct($data)
	{
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
	}
	public function __call($method,$args)
	{
		call($this,$method,$args);
	}
	public function kill($msg)
	{
		$this->_DEBUG->add($msg);
		die ( $this->_DEBUG->flush("<hr><h1>"."KILLED"."</h1><hr />") );
	}
}