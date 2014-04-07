<?php
#print_r($_FILES);
#[upload] => 
//Array ( [name] => 22cropped-portr-4.jpg 
//[type] => image/jpeg 
//[tmp_name] => /tmp/phpq7FN2x [error] => 0 [size] => 88466 )
//
//

$file=new FileUpload($_FILES["upload"]);
$this->_assign->download_link=$file->link;

if (isset($_POST["email"]))
{
	if (!empty($_POST["email"]))
	{
		if (substr_count($_POST["email"],"@")==1)
		{
			mail($_POST["email"],"Ihr Downloadlink für die Datei: ".$_FILES["upload"]["name"],"Ihr Downloadlink lautet: ".$file->link,"From:Upload by w0xz.de<upload@w0xz.de>");
		}
	}
}
