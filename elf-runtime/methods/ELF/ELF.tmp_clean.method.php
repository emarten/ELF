<?php
		$od=opendir($_ELF->_config["tmp"]);
		while ($rd=readdir($od))
		{
			if ($rd!="." AND $rd!="..")
			{
				if (filemtime($_ELF->_config["tmp"].$rd)<=  (time()-$_ELF->_config["tmp_age"]) )
				{
					unlink($_ELF->_config["tmp"].$rd);
				}
			}
		}
		closedir($od);