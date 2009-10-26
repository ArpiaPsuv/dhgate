<?php
class User extends Zend_Db_Table_Abstract
{
	protected $_name = 'user';

	public  function getUser($user_id)
	{
		return $this->find($user_id)->current();
	}

	public function checkLogin($login)
	{
		$validator = new App_Validate_NoDbRecordExists('user','login');
		return $validator->isValid($login);
	}

	public function checkMail($mail)
	{
		 
		$validator = new App_Validate_NoDbRecordExists('user','mail');
		return $validator->isValid($mail);

	}

	public function passRecover($mail)
	{
		$select =$this->select();
		$select->where('mail = ?',$mail)->limit(1);
		if ($row = $this->fetchRow($select)){
			$newPass= $this->passRandom(7);
			$row->pass=md5($newPass);
			$row->save();
			return $newPass;
		}else{
			return false;
		}
	}
	public function passRandom($length)
	{
		$data='QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm1234567890';
		$password='';
		for ($i = 0; $i < $length; $i++) {
			$password .=$data[rand(1,strlen($data))];
		}
		return $password;
	}
}