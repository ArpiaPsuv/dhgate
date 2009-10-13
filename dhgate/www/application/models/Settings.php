<?php
class Settings extends Zend_Db_Table_Abstract {
	protected $_name = 'settings';
	
	public function getValute($valute = null)
	{
		if($valute === null)
		{
			$select = $this->select()->from($this->_name, array('usd' => 'usd', 'gbp'=>'gbp', 'eur'=>'eur'))
				->where('id = 1');
			return $this->fetchAll($select);
		} else {
			$select = $this->select()->from($this->_name, array($valute => $valute))->where('id = 1');
			$result = $this->fetchAll($select);
			return $result[0][$valute];
		}
	}
	
	public function getField($name = null)
	{
		switch($name)
		{
			case 'about' : break;
			case 'help' : break; 
			case 'contact' : break; 
			case 'privacy' : break;
			case 'terms' : break;
			case 'info' : break;
			case 'window' : break;
			case 'title' : break;
			case 'buy' : break;
			case 'payment' : break;
			default: return false; break;
		}
		$select = $this->select()->from($this->_name, array($name => $name))->where('id = 1');
		$result = $this->fetchAll($select);
		return $result[0][$name];
	}
}
