<?php
class DEBUG
{
	public function __construct()
	{
		#$this->_MSG=array();
		global $_ELF;
		if ($_ELF->_config["debug"])
		{
			$this->file=$_ELF->_config["tmp"].$_ELF->_instance.".txt";
			touch($this->file);
			file_put_contents($this->file,"===================================\nInstance by ".$_SERVER["REMOTE_ADDR"]."\n".date("d.m.Y H:i:s")."\n===================================\n");
		}
	}
	public function add($add)
	{
		global $_ELF;
		if ($_ELF->_config["debug"])
		{
			$fp=fopen($this->file,"a");
			fwrite($fp,  $add."\n");
			fclose($fp);
		}
	}

	
	public function flush($pre="",$post="")
	{
		global $_ELF;
		if ($_ELF->_config["debug"])
		{
			ob_start();
			echo $pre;
			echo "<pre>";
			$fp=fopen($_ELF->_DEBUG->file,"r");
				while (!feof($fp))
				{
					echo fread($fp, 1024);
					flush();
				}
			fclose($fp);
			echo "-------------------------------------------------------------------\n";
			echo htmlspecialchars( print_r($_ELF,true) );
			echo "</pre>";
			echo $post;
			return "<div style=\"margin:20px; border:solid 1px black; padding:20px;\">".(ob_get_clean())."</div>";
		}
		else
		{
			return '';
		}
	}


}