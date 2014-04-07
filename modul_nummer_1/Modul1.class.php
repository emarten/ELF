<?php

	class Modul1 extends ELF_Software
	{
		public function init() {

			global $_ELF;



			$this->Session=new Cookie("UserSession");
			if (!$this->Session->get("uid")) {
				$this->Session->set("uid",md5( time().$_SERVER["REMOTE_ADDR"] ));

				$this->User=new User();
				$this->User->date=time();
				$this->User->uid=$this->Session->get("uid");
				$this->User->save();
			}
			else
			{
				$this->User=new User("`uid` = :uid",array("uid"=>$this->Session->get("uid")));
				if (!$this->User->_exists)
				{
					$this->User=new User();
					$this->User->date=time();
					$this->User->uid=$this->Session->get("uid");
					$this->User->save();
				}
			}
			
			$this->Template=$_ELF->loadTemplate(dirname(__FILE__)."/template/offline/index.php");
			
			#$this->Template->generateURL(__FILE__);
			#$this->Template->generate();
			#$this->Template->flush();
			

		}


	}