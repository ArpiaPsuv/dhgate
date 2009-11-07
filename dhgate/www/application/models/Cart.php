<?php
class Cart extends Zend_Db_Table_Abstract
{
	protected $_name = 'cart';
	protected $_userId;
	
	public function __construct($user_id)
	{
		parent::__construct();
		$this->_userId = $user_id; 
	}
	
	public static function create()
	{
		if(Zend_Auth::getInstance()->hasIdentity()){
			return new Cart(Zend_Auth::getInstance()->getIdentity()->id);
		} else {
			return new Cart_Cookie();
		} 
	}
	
	public function add($product_id,  $count)
	{
		if($this->inCart($product_id)){
			 $this->updateCount($product_id, $this->inCart($product_id));
		} else {
			 $this->insert(array('product_id'=>(int) $product_id, 'count' => (int) $count , 'user_id'=>$this->_userId));
		}
		return $this->getCount();
	}
	
	public function inCart($product_id)
	{
		$select = $this->select()->from($this->_name, 'count')->where('product_id = ?', (int) $product_id);
		$row = $this->fetchRow($select);
		if($row){
			return $row->count;
		} else {
			return false;
		}
		
	}
	
	public function getProducts($order_id = 0)
	{
		$products = array();
		$select = $this->getAdapter()->select()->from(array('c'=>$this->_name), array('count'=>'c.count'))
			->join(array('p'=>'product'),'c.product_id = p.id')
			->where('c.user_id = ' . $this->_userId)
			->where('c.order_id = ' . $order_id);
		return $this->getAdapter()->fetchAll($select);
	}
	
	public function updateCount($product_id, $count)
	{
		if($this->inCart($product_id)){
			$select = $this->select()->from($this->_name)
				->where('product_id = ?', (int) $product_id)
				->where('user_id = ?' , $this->_userId);
			$product =  $this->fetchRow($select);
			$count = $product['count']+(int)$count;
			if($count >0){
				$this->update(array('count' => $count ), "product_id =  $product_id AND user_id = {$this->_userId}");
				return $count;
			} else {
				return 0;
			}
			
		} else {
			return false;
		}
	}
	
	public function deleteProduct($product_id)
	{
		return $this->delete("product_id =  $product_id AND user_id = {$this->_userId}");
	}
	
	public function getCount($order_id = 0)
	{
		$select = $this->select()->from($this->_name,array('count'=>'sum(count)'))
			->where('user_id=?', $this->_userId)
			->where('order_id=?', $order_id);
		$result =  $this->fetchAll($select);
		return $result[0]['count'];
	}
}
