<?php
/**
 * Description of DB
 *
 * @author e.marten
 */
class DB {

	public function __construct()
	{
		global $_ELF;
		if (!isset($_ELF->_DB))
		{
			$_ELF->kill("Your module needs a mysql connection, but there's no in your elf");
		}

		$_table=array(
		    "name"=>  get_called_class(),
		    "columns"=>array(),
			"types"=>array()
		);
		foreach ($this as $key => $val)
		{
			array_push($_table["columns"],$key);
			array_push($_table["types"],$val);
		}

		$this->_table=$_table;
		$this->_exists=false;


		if ($_ELF->_config["DB"]["status"]=="unknown" || !$_ELF->_config["DB"]["status"])
		{
			if (!in_array(DB_PREFIX.get_called_class(),$_ELF->_config["DB"]["_tables"]))
			{
				$this->createTable();
			}
			else
			{
				$sql="SHOW COLUMNS FROM ".DB_PREFIX.  get_called_class();
				$sql=$_ELF->_DB->prepare($sql);
				$sql->execute();
				$temp=$sql->fetchAll();
				$cols=array();
				array_shift($temp);
				foreach ($temp as $t)
				{
					array_push($cols,$t[0]);
				}
				$cols=json_encode($cols);
				$cols2=json_encode($this->_table["columns"]);
				if ($cols != $cols2)
				{
					$this->dropTable();
					$this->createTable();
				}
			}#
		}



	}

	private function createTable()
	{
		global $_ELF;
				$sql="CREATE TABLE IF NOT EXISTS `".DB_PREFIX.$this->_table["name"]."` (
  `id` int(44) NOT NULL AUTO_INCREMENT";
				foreach ($this->_table["columns"] as $key=>$col)
				{
					$type=$this->_table["types"][$key];
					$type=explode("|",$type);
					if (empty($type[0])) { $type[0]="longtext"; }
					if (!isset($type[1])) {
						if ($type[0]=="longtext" || $type[0]=="mediumtext")
						{
							$type[1]="";
						}
						elseif ($type[0]=="double")
						{
							$type[1]="";
						}
						else
						{
							$type[1]="(255)";
						}
					} else { $type[1]="(".$type[1].")"; }
					$sql.=",\n"."`".$col."` ".$type[0].$type[1]." NOT NULL";
				}
				$sql.=",\n"."PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabelle ".  get_called_class()." since ".date("d.m.Y")." (".$_ELF->_config["DB"]["status"].")"."' AUTO_INCREMENT=1 ;";

				$sql=$_ELF->_DB->prepare($sql);
				$sql->execute();
				array_push($_ELF->_config["DB"]["_tables"],DB_PREFIX.get_called_class());
	}

	private function dropTable()
	{
		global $_ELF;
		$sql="DROP TABLE `".DB_PREFIX.$this->_table["name"]."`";
		$sql=$_ELF->_DB->prepare($sql);
		$sql->execute();
	}

	public function save()
	{
		global $_ELF;
		if (!$this->_exists)
		{
		
			$arr=array();
			$str="";
			$vstr="";
			foreach ($this->_table["columns"] as $name)
			{
				$arr["INSR".$name]=$this->$name;
				if (empty($arr["INSR".$name]))
				{
					$arr["INSR".$name]="";
				}
				if (!empty($str))
				{
					$str.=" , ";
					$vstr.=" , ";
				}
				else {
				#	$str=" id , ";
				#	$vstr=" NULL , ";
				}
				$str.="`".$name."`";
				$vstr.=":INSR".$name."";
			}

			$this->_exists=true;
			$sql="INSERT INTO `".DB_PREFIX.$this->_table["name"]."` (".$str.") VALUES ( ".$vstr." );";
			$sql=$_ELF->_DB->prepare($sql);
			$sql->execute($arr);
		}
		else
		{
			$arr=array();
			$str="";
			$vstr="";
			foreach ($this->_table["columns"] as $name)
			{
				if (!empty($str)) { $str.=","; }
				$str.=" `".$name."` = '".$this->$name."' ";
			}
			$sql="UPDATE `".DB_PREFIX.$this->_table["name"]."` SET".$str."WHERE `id` = '".$this->id."';";
			#mail("w0xz.eric@gmail.com","db sql syntax debug",$sql);
			
			$sql=$_ELF->_DB->prepare($sql);
			$sql->execute($arr);
		}
	}

	public function load($where="",$arr=array())
	{
		global $_ELF;
		if (!empty($where))
		{
			$where=" AND ".$where;
		}
	#	echo "SELECT * FROM `".DB_PREFIX.$this->_table["name"]."` WHERE `id` != '0'".$where;
		$sql=$_ELF->_DB->prepare("SELECT * FROM `".DB_PREFIX.$this->_table["name"]."` WHERE `id` != '0'".$where);
		$sql->execute($arr);
		$one=$sql->fetch(PDO::FETCH_ASSOC);
		if (isset($one["id"]))
		{
			foreach ($one as $key => $val)
			{
				$this->$key=$val;
			}
			$this->_exists=true;
		}
		else
		{
			$this->_exists=false;
		}
		#unset($this->_table);
	}
}
