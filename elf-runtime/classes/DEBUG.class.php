<?php
class DEBUG
{
	public function __construct()
	{
		#$this->_MSG=array();
		global $_ELF;
		$this->file=$_ELF->_config["tmp"].$_ELF->_instance.".txt";
		touch($this->file);
		file_put_contents($this->file,"===================================\nInstance by ".$_SERVER["REMOTE_ADDR"]."\n===================================\n");
	}
	public function add($add)
	{
		#array_push($this->_MSG,$add);
		$fp=fopen($this->file,"a");
		fwrite($fp,$add."\n");
		fclose($fp);
	}
}