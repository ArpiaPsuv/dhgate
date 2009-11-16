<?php
class Order extends Zend_Db_Table_Abstract {
	protected $_name = 'order';
	protected $_confirmed = false;
	protected $_shipping;
	protected $_payment = 0;


	
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
		$_SESSION['shipping'] =(int) $method_id;
		$this->_shipping = (int) $method_id;	
	}

	
	
	public function setPaymentMethod($method_id)
	{
		$_SESSION['payment'] =(int) $method_id;
		$this->_payment = (int) $method_id;	
	}
	
	
	
	public function updatePayment()
	{
	
		$data=array(
			'payment'=>$_SESSION['payment'],
			'status'=>'new'
		);
		$this->update($data,"id = {$_SESSION['order_id']}");
	
	}	
	
	public function getShippingMethods()
	{
		$select= $this->getAdapter()->select()->from('shipping_method');
		return $this->getAdapter()->fetchAll($select);
	}
	
	public function getPaymentMethods()
	{
		$select= $this->getAdapter()->select()->from('payment_method');
		return $this->getAdapter()->fetchAll($select);
	}
	
	
	public function confirm()
	{
		//сохранить в базу;
		
		$cart= new Cart();
		
		$address = new Adress();
		$shipping_address=$address->get(1);
		
		
		
		$data = array(
		//'cart_id'=>'',
		'user_id'=>Zend_Auth::getInstance()->getIdentity()->id,
		'address'=>$shipping_address['0']['id'],
		'shipping'=>$this->_shipping,
		'payment'=>$_SESSION['payment'],
		'date'=>date('Y-m-d'),
		'status'=>'confirmed',
		);
		
		
		///доделать обновление карзины....
		$_SESSION['order_id']=$id =$this->insert($data);
		$cart->setOrder($id);
		
		
		
		//cart id
		//payment id -
		//sipping id
		//user id
		//date
		// status (confirmed)
		
		
	
		
	}
	
	public  function track($mail,$number)
	{
		$select = $this->getAdapter()->select();
		$select	->from("order as o")
				->from("user as u")
				->where("u.mail = '$mail'")
				->where("o.user_id = u.id")
				->where("o.id = $number");
		$result = $this->getAdapter()->fetchRow($select);
		if($result){
			return $result['status'];
		}else{
			return false;
		}
		
	}
	
}
