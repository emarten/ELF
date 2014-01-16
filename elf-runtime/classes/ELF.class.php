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
	}
	public function __call($method,$args)
	{
		call($this,$method,$args);
	}
}