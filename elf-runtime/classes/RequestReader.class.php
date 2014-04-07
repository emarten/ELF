<?php

class RequestReader
{
	public $mode="request";
	public function __construct()
	{
		#$this->getSiteURL();
		/*	getSiteURL includes:
			$this->getProtocol();
			$this->getHostname();
			$this->getBaseDirectory();
			$this->getPortString(); // Includes getPort()
		 */
		$this->getURL();

		if (!$this->checkTrailingSlash())
		{
			if (!$this->simulatedFile)
			{
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: ".$this->getURL()."/");
				echo "<h1>HTTP/1.1 301 Moved Permanently</h1>\nLocation: ".$this->getURL()."/\r\n";
				exit;
			}
		}


	}

	private function checkTrailingSlash()
	{
		$path=$this->getURLpath();
		if (substr($path,strlen($path)-1,1)=="/")
		{
			$this->simulatedFile=false;
			return true;
		}
		else
		{
			#substr($path,strlen($path)-3,1)=="." OR substr($path,strlen($path)-4,1)=="." OR substr($path,strlen($path)-5,1)=="." OR substr($path,strlen($path)-6,1)=="."
			if (substr_count( basename($path) , ".") >= 1)
			{
				$this->simulatedFile=true;
				return false;
			}
			else
			{
				$this->simulatedFile=false;
				return false;
			}
		}
	}

	public function getURL()
	{
		if (!isset($this->URL))
		{
			$path=$this->getURLpath();
			$this->URL=$this->getSiteURL().substr($path,1);
		}
		return $this->URL;
	}

	public function getURLpath()
	{
		if (!isset($this->URLpath))
		{
			$path=substr($_SERVER["REQUEST_URI"],strlen( $this->getBaseDirectory() ) );
			if (!empty($_SERVER["QUERY_STRING"])) { $path=substr($path,0,( strlen($path)-(strlen($_SERVER["QUERY_STRING"])+1) ) ); }

			if ($path=="/") { $path=""; }
			if (empty($path))
			{
				#$path="default";
			}

			$path="/".$path;

			if (substr($path,0,5)=="/api/")
			{
				$this->mode="api";
				$path=substr($path,4);
			}

			$this->URLpath=$path;

			while (substr($path,0,1)=="/")
			{
				$path=substr($path,1);
			}

			while (substr($path, strlen($path)-1,1 )=="/")
			{
				$path=substr($path,0,strlen($path)-1);
			}

			$this->URLname=$path;

		}
		return $this->URLpath;
	}
	public function getURLname()
	{
		if (!isset($this->URLname))
		{
			$this->getURLpath();
		}
		return $this->URLname;
	}
	public function getPort()
	{
		if (!isset($this->port))
		{
			$this->port=$_SERVER["SERVER_PORT"];
		}
		return $this->port;
	}

	public function getPortString()
	{
		if (!isset($this->portString))
		{
			$port=$this->getPort();
			$this->portString="";
			if ($port!=443 AND $port!=80)
			{
				$this->portString=":".$port;
			}
			unset($port);
		}
		return $this->portString;
	}

	public function getSiteURL()
	{
		if (!isset($this->siteURL))
		{
			$this->siteURL=$this->getProtocol()."://".$this->getHostname().$this->getPortString().$this->getBaseDirectory();
		}
		return $this->siteURL;
	}

	public function getBaseDirectory()
	{
		global $_ELF;

		if (!isset($this->baseDirectory))
		{
			$temp=str_replace($_SERVER["DOCUMENT_ROOT"],"/", dirname( $_ELF->_init["script"] ));

			$this->baseDirectory=$temp;
			unset($temp);

		}
		return $this->baseDirectory;
	}

	public function getHostname()
	{
		if (!isset($this->hostname))
		{
			$this->hostname=$_SERVER["SERVER_NAME"];
		}
		return $this->hostname;
	}
	public function getProtocol()
	{
		if (!isset($this->protocol))
		{
			$this->protocol="http";
			if (isset($_SERVER["HTTPS"]))
			{
				if ($_SERVER["HTTPS"])
				{
					$this->protocol.="s";
				}
			}
		}
		return $this->protocol;
	}
}
