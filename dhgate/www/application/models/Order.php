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
	
	public function getGrandTotal($order_id = 0) 
	{
		
		$shipping = new Shipping();
		$region = new Region();
		
		
				
		$cart= Cart::create();
		$products = $cart->getProducts($order_id);
		$sub_price=0;
		
		$product_table = new Product();
		$arr=array();
		foreach ($products as $product) {
			$sub_price+=$product['price']*$product['count'];
			$category = $product_table->getParentCategory($product['id']);
			if(isset($arr[$category['id']])){
				$arr[$category['id']]['count']+= $product['count'];
			}else{
				$arr[$category['id']]['count']=(int)$product['count'];
				$arr[$category['id']]['coef']=$category['coef'];
			}
		}
		$order= $this->getOrder($order_id);
	
		$shipping_coef=$shipping->get($order['shipping']);
		$address = new Adress();
		$region_id =  $address->getAddres($order['address_shipping']);
		$region_coef=$region->getRegion($region_id['region']);
		
		
		
		////
	
		$shipping_price=0;
		foreach ($arr as $key => $value) {
			$shipping_price+=($value['count']*0.1+1)*30*$value['coef']*$region_coef['coef']*$shipping_coef['coef'];
		}
		return (round($shipping_price*100)/100)+$sub_price;
		
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
	
	public function getOrders($status = 0)
	{
		if($status == 0){
			return $this->fetchAll();
		}
	}
	
	public function updatePayment()
	{
	
		$data=array(
			'payment'=>$_SESSION['payment'],
			'status'=>'new'
		);
		$this->update($data,"id = {$_SESSION['order_id']}");
	
	}	
	

	
	public function getPaymentMethods()
	{
		$select= $this->getAdapter()->select()->from('payment_method');
		return $this->getAdapter()->fetchAll($select);
	}
	
	public function setStatus($id,$status)
	{
	
		$data=array(
			'status'=>$status
		);
		return $this->update($data,"id = $id");
	
	}	
	
	public function confirm()
	{
		//сохранить в базу;
		
		$cart= new Cart();
		
		
		
		
		
		$data = array(
		//'cart_id'=>'',
		'user_id'=>Zend_Auth::getInstance()->getIdentity()->id,
		'address_shipping'=>$_SESSION['shipping_address'],
		'address_billing'=>$_SESSION['billing_address'],
		'shipping'=>$this->_shipping,
		'payment'=>0,//$_SESSION['payment'],
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
	
	public function getOrder($order_id)
	{
		return $this->find($order_id)->current();
	}
	
	public function getProducts($order_id)
	{
		$cart = new Cart();
		
		return $cart->getProducts($order_id);
	
	}
}
