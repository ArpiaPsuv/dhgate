<?php

class Payment extends Zend_Db_Table_Abstract {
	protected $_name = 'payment';

	public function get($id)
	{
		return $this->find($id)->current();
	}
}
