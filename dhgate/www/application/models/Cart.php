<?php
class Cart extends Connect
{
	protected $_name = 'cart';
	public function addToCart($category_id, $item_id, $count)
	{
		$row = parent::add($category_id, $item_id);
		$row->count = $count;
		$row->save();
	}

	public function getCart($user_id = null)
	{
		$cart = array();
		$i = 0;
		if($user_id === null){
			foreach($_COOKIE as $key=> $value){
				$arr = explode('#', $key);
				if(count($arr)>1 && $value>0){
					$cart[$i] = array('product_id' => $arr[1],'count' =>$value);
				}
				$i++;
			}
		} else {
			$select = $this->select()->from($this->_name,array('product_id'=> 'item_id','count'=>'count', 'id'=>'id'))->where('active = 1');
			$cart = $this->fetchAll($select);
		}
		return $cart;
	}

	public function getInfo($user_id = null)
	{
		$count = 0;
		$totalPrice = 0;
		foreach  ($this->getProducts($user_id) as $product){
			$count += $product['count'];
			$totalPrice += $product['product']['price'];
		}
		return array('count'=> $count, 'price'=>$totalPrice);
	}

	public function getProducts($user_id = null)
	{
		$cart = $this->getCart($user_id);
		$products = array();
		foreach($cart as $product)
		{
			$select = $this->getAdapter()->select()->from(array('p'=>'product'))->where('p.id = ' . $product['product_id']);
			$result = $this->getAdapter()->fetchAll($select);
			array_push($products, array('product' => $result[0], 'count'=>$product['count']));
		}
		return $products;
	}

	public function savecookie()
	{
		foreach ($this->getProducts() as  $product)
		{
			$this->insert(array('category_id' => Zend_Auth::getInstance()->getIdentity()->id, 'item_id'=>$product['product']['id'], 'count'=>$product['count']));
		}
	}


	public function deleteItem($category_id = null, $item_id = null)
	{
		if(Zend_Auth::getInstance()->hasIdentity())
		{
			parent::delete(Zend_Auth::getInstance()->getIdentity()->id, $item_id );
		} else {
			setcookie("p#".$item_id , 0, mktime(0,0,0,01,25,2008),'/');
			unset($_COOKIE["p#".$item_id]);
		}
	}

	public function updateCount($product_id , $count){
		if($count<1){
			$this->deleteItem(null, $product_id);
		}
		if(Zend_Auth::getInstance()->hasIdentity()){
			$user_id = Zend_Auth::getInstance()->getIdentity()->id;
			$this->update(array('count'=>$count), "category_id = $user_id and item_id = $product_id");
		} else {
			$this->add($product_id, $count);
		}
	}
	public function add($product_id , $count)
	{
		if($count<1){
			$this->deleteItem(null, $product_id);
		}
		
		if(Zend_Auth::getInstance()->hasIdentity())
		{
			$cart = new Cart();
			$cart->addToCart(Zend_Auth::getInstance()->getIdentity()->id, $product_id , $count);
		} else {
			setcookie("p#".$product_id, $count, mktime(0,0,0,01,25,2099),'/');
		}
	}
	
	public function setActive($id)
	{
		$row  = $this->find($id)->current();
		$row->active = '1';
		$row->save();
	}

	public function setInActive($id)
	{
		$row  = $this->find($id)->current();
		$row->active = '0';
		$row->save();
	}
}
