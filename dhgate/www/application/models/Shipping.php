<?php
class Shipping extends Zend_Db_Table_Abstract {
	protected $_name = 'shipping';

	public function get($id)
	{
		return $this->find($id)->current();
	}
}
