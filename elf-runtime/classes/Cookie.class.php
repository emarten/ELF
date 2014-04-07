<?php

	class Cookie {

		public function __construct($identifier)
		{
			$this->_identifier=$identifier;
			foreach ($_COOKIE as $key => $val)
			{
				if (substr($key,0,strlen($this->_identifier))==$this->_identifier)
				{
					$nkey=substr($key,strlen($this->_identifier));
					$this->$nkey=$val;
				}
			}
		}

		public function set($name,$value,$expire=0)
		{
			global $_ELF;
			setcookie($this->_identifier.$name,$value,$expire,$_ELF->_REQUEST->baseDirectory);
			$_COOKIE[$this->_identifier.$name]=$value;
			$this->$name=$value;
			return $value;
		}

		public function get($name)
		{
			if (isset($this->$name)) { return $this->$name; }
			else
			{
				return false;
			}
		}

		public function bool($key)
		{
			if (isset($this->$key)){
				if ($this->$key) { return true; }
				else { return false; }
			}	else { return false; }
		}
		
		public function destroy()
		{
			global $_ELF;
			#$this->_identifier=$identifier;
			foreach ($_COOKIE as $key => $val)
			{
				if (substr($key,0,strlen($this->_identifier))==$this->_identifier)
				{
					setcookie($key, $val, time()-3600, $_ELF->_REQUEST->baseDirectory);
					unset($_COOKIE[$key]);
					
					$nkey=substr($key,strlen($this->_identifier));
					unset($this->$nkey);
				}
			}
		}
		
		
	}

/*
  			$this->_COOKIE=$_ELF->cookie("default_cookie_mod1");
			$this->_COOKIE->set("test",time());
			$this->test=$_ELF->cookie("user_cookie_mod1");
			if (!$this->test->get("user")) { $this->test->set("user","UserID".md5(time())); }
 */
