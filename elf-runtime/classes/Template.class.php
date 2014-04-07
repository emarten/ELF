<?php

/**
 * Description of Template
 *
 * @author e.marten
 */
class Template {
	public function __construct($file) {
		global $_ELF;
		$this->assign=new stdClass();
		foreach ($_ELF->_SOFTWARE->_assign as $key => $val)
		{
			$this->assign->$key=$val;
		}


		
		if ($_ELF->_REQUEST->mode=="api")
		{
			$rem=array("softwareURL","siteURL");
			foreach ($rem as $r) { unset($this->assign->$r); }

			header("Content-Type: text/plain; charset=utf-8");
			echo json_encode($_ELF->_SOFTWARE->_assign->API);
			exit;
		}
		else {
		
			ob_start();
			include($file);
			$this->code=  ob_get_clean();
			#file_get_contents($file);
			$this->themeURL=str_replace($_SERVER["DOCUMENT_ROOT"]."/",
				  $_ELF->_REQUEST->protocol."://".$_SERVER["SERVER_NAME"]."".$_ELF->_REQUEST->getPortString()."/"
				  ,dirname($file)."/");

			$this->variables();

			$this->flush();
		}
		

	}

	public function generate()
	{
		global $_ELF;
		while (substr_count($this->code,"\${")>=1 OR substr_count($this->code,"\::{")>=1)
		{
			$this->execute();
		}
		unset($this->assign);
	}
	private function execute()
	{
		global $_ELF;
		$temp=explode("\${",$this->code);
		for ($x=1;$x<sizeof($temp);$x++)
		{
			$line=explode("}",$temp[$x]);
			$name=$line[0];
			$line="\${".$name."}";
			$this->code=str_replace($line,$this->assign->$name,$this->code);
		}
		$temp=explode("::{",$this->code);
		for ($x=1;$x<sizeof($temp);$x++)
		{
			$line=explode("}::",$temp[$x]);
			$name=$line[0];
			$cmd=explode(":",$name);
			$var=substr($name,strlen($cmd[0])+1);
			$cmd=$cmd[0];
			$line="::{".$name."}::";
			$this->code=str_replace($line,$this->$cmd($var),$this->code);
		}
	}
	public function flush()
	{
		global $_ELF;
		$this->generate();
		echo $this->code;
	}

	private function title($title)
	{
		global $_ELF;
		return "<title>".$title."</title>";
	}
	private function css($link)
	{
		global $_ELF;
		return "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$link."\" />";
	}
	
	private function favicon($icon)
	{
		return "<link rel=\"shortcut icon\" href=\"".$icon."\" type=\"image/x-icon\" />";
	}

	private function variables()
	{
		global $_ELF;
		$this->assign->themeURL=$this->themeURL;
		$this->assign->jQuery='<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script>'."";
		$this->assign->bootstrap='<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />'."\n".'<script type="text/javascript" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>';
	}
	
	private function load($file)
	{
		global $_ELF;
		ob_start();
		include($file);
		return ob_get_clean();
	}
}
