<?php

class ELF_Software
{
	public $_assign;
	public function _software_init($mode)
	{
		global $_ELF;
		$this->_assign=new stdClass();
		$this->_assign->API=new stdClass();
		$this->_assign->siteURL=$_ELF->_REQUEST->siteURL;
		
		if (isset($_ELF->_config["assign"]))
		{
			if (is_array($_ELF->_config["assign"]))
			{
				foreach ($_ELF->_config["assign"] as $key => $val)
				{
					$this->_assign->$key=$val;
				}
			}
		}
		
		$this->mode=$mode;
		$_ELF->_DEBUG->add("Starting Software \"".$_ELF->_config["software"][1]."\"");
		$this->_includeDirectory=  get_include_path()."/";
		$this->generateURL($this->_includeDirectory);
		array_push( $_ELF->_classes , $this->_includeDirectory."classes/" );
		$this->init();
	}
	
	public function generateURL($file)
	{
		global $_ELF;
		$this->_assign->softwareURL=$_ELF->_REQUEST->protocol."://".$_SERVER["SERVER_NAME"].$_ELF->_REQUEST->portString.str_replace($_SERVER["DOCUMENT_ROOT"],"",$file."");
	}

}