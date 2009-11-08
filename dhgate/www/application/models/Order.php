<?php
class Order extends Zend_Db_Table_Abstract {
	protected $_name = 'order';
	protected $_confirmed = false;
	protected $_shipping;
	protected $_payment;
	
	public function __construct()
	{
		parent::__construct();
		if($this->_confirmed){
			
		} else {
			if(key_exists('shipping', $_SESSION)){
				$this->_shipping = $_SESSION['shipping'];
			}
		}
	}
	
	public function setShippingMethod($method_id)
	{
		$_SESSION['shipping'] = (int) $method_id;
		$this->_shipping = (int) $method_id;	
	}
	
	public  function confirm()
	{
		//сохранить в базу;
	}
}
