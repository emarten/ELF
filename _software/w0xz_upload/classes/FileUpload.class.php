<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FileUpload
 *
 * @author Eric
 */
class FileUpload extends DB {
	public $date="int|40", $user="varchar|30", $access="longtext", $fid="varchar|40", $name="mediumtext", $path="mediumtext", $size="double", $type="varchar", $status="int|5", $downloads="int|10", $last_download="int|40", $credits="int|40", $last_cron="int|40";
	public function __construct($file_post)
	{
		global $_ELF;
		parent::__construct();

		if (is_array($file_post))
		{

			$dir = $_ELF->_SOFTWARE->_includeDirectory."temp/".date("Y/m/d/H/");
			@mkdir($dir,0775,true);
			@chmod($dir,0775);
			$name=md5($file_post["name"].rand(1,9999).$_SERVER["REMOTE_ADDR"]).microtime(true);
			move_uploaded_file($file_post["tmp_name"], $dir.$name);

			$this->date=time();
			$this->user="public";
			$this->access="public";
			$this->fid=md5( $name );
			$this->name=$file_post["name"];
			$this->path=$dir.$name;
			$this->size=$file_post["size"];
			$this->type=$file_post["type"];
			$this->status=1;
			$this->downloads=0;
			$this->last_download=0;
			$this->credits=0; //
			$this->last_cron=time();

			$this->save();
		}
		else
		{
			$this->load("`fid` = :fid",array("fid"=>$file_post));
		}
		$this->link=$_ELF->_REQUEST->siteURL."dl/".$this->fid."/";
	}
}







?>
