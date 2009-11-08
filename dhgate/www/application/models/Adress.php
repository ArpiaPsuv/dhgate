<?php
class Adress extends Zend_Db_Table_Abstract {
	protected $_name = 'address';
	
	public function get($shipping = 0)
	{
		$select = $this->select()->from($this->_name)->where('user_id = ' . Zend_Auth::getInstance()->getIdentity()->id)
			->where('shipping = ' . $shipping);
		return  $this->fetchAll($select);
	}
}
