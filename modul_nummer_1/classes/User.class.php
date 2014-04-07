<?php

class User extends DB
{
	public $date, $uid, $user, $mail, $pass, $status, $level;
	public function __construct($find="",$arr=array())
	{
		parent::__construct();
		if (!empty($find))
		{
			$this->load($find,$arr);
		}
	}
}