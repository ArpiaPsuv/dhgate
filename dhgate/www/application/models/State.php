<?php
class State extends Zend_Db_Table_Abstract 
{
	protected  $_name = 'state';
	
	public function getState($id)
	{
		return $this->find($id)->current();
	}
}