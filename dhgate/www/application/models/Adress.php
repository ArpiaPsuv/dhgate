<?php
class Adress extends Zend_Db_Table_Abstract {
	protected $_name = 'address';
	
//	public function get($shipping = 0)
//	{
//		$select = $this->select()->from($this->_name)->where('user_id = ' . Zend_Auth::getInstance()->getIdentity()->id)
//			->where('shipping = ' . $shipping);
//		return  $this->fetchAll($select);
//	}
	public function addAddess($data,  $shipping = 0) 
	{
		
		$id = $this->insert($data);
		if($shipping){
			$_SESSION['shipping_address']=$id;
		}else{
			$_SESSION['billing_address']=$id;
			
		}
		
		return $id;
	}
	public function getLast()
	{
		return $this->fetchAll('last = 1 and user_id = '.Zend_Auth::getInstance()->getIdentity()->id);
	}
	
	public function updateAddess($data,$id) 
	{
		return $this->update($data,'id = '.$id);
	}
	
	public function getAddres($id)
	{
		return $this->find($id)->current();
	}
}
