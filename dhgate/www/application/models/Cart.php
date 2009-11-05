<?php
class Cart extends Zend_Db_Table_Abstract
{
	protected $_name = 'cart';
	/*

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
	}*/
	
//	
//	
//	Добавить в корзину
//	Удалить из корзины
//  Получить корзину
//	Получить товары из корзины
//	Получить кол-во товаров в корзине
	public function getTotalPrice()
	{
		$total_price=0;
		foreach ($this->getProducts() as $product) {
			$total_price+=$product['price']*$this->getProductCount($product['id']);
		}
		return $total_price;
	} 
	public function getUserId() 
	{
		if(Zend_Auth::getInstance()->hasIdentity()){
			return Zend_Auth::getInstance()->getIdentity()->id;
		}else{
			return 0;
		}
	}
	
	public function getCount()
	{
		$cart=$this->getCart();
		$count=0;
		foreach ($cart as $product){
			$count+=$product['count'];
		}
		return $count;
	}
	public function getProductCount($productId = 0)
	{
		$cart=$this->getCart();
		foreach ($cart as $product){
		if($product['product_id'] == $productId){
				return $product['count'];
				break;
			}	
		}
		
	}
	
	public function getProduct($productId)
	{
		$select = $this->getAdapter()->select();
		$select->from(array('p' => 'product'));
		$select->Where('p.id  = ?',$productId)
		->limit(1);
		return $this->getAdapter()->fetchRow($select);		
	}
	
	
	public function isProductInCart($productId)
	{
		$isProduct=false;
		$cart = $this->getCart();
		foreach ($cart as $product) {
			if($product['product_id'] == $productId){
				$isProduct=true;
			}
		}
		return $isProduct;
	}
	
	public function addProduct($productId,$count)
	{
		$userId=$this->getUserId();
		$cart = $this->getCart();
		$isProduct=$this->isProductInCart($productId);
		if($userId){
			if($isProduct){
				$this->update(array('count'=>$count), "user_id = $userId and product_id = $productId");
			}else{
				$this->insert(array('user_id' => $userId, 'product_id'=>$productId, 'count'=>$count));
			}
		}else{
			if($isProduct){
				for ($i = 0; $i < count($cart); $i++) {
					if($cart[$i]['product_id'] == $productId){
						$cart[$i]['count']=	$count;
						break;
					}
				}
								
			}else{
				array_push($cart, array('product_id' => $productId, 'count'=>$count));
			}
			$_SESSION['cart']=$cart;
		}
	}
	
	public function getCart() 
	{
		$cart=array();
		$userId=$this->getUserId();
		if($userId){
			$select = $this->select();
			$select->from($this->_name)
			->where('user_id = ?',$userId)
			->where('active = 1');
			$i=0;
			foreach ($this->fetchAll($select) as $row) {
				$cart[$i] = array(
					'product_id' => $row->product_id,
					'count' =>$row->count
					);
				$i++;
			}
		}else{
			if(!isset($_COOKIE['session_id'])){
				Zend_Session::rememberMe(3600*24*7);
				setcookie("session_id", Zend_Session::getId(), time()+3600*24*7,'/');
			}else{
				if($_COOKIE['session_id'] != Zend_Session::getId()){
					Zend_Session::rememberMe(3600*24*7);
					setcookie("session_id", Zend_Session::getId(), time()+3600*24*7,'/');
				}
			}
			
			if(isset($_SESSION['cart'])){
				$cart = $_SESSION['cart'] ;	
			}
		}	
		return $cart;	
	}
	
	public function getProducts()
	{
		$cart=$this->getCart();
		$select = $this->getAdapter()->select();
		$select->from(array('p' => 'product'));
		foreach ($cart as $product) 
		{
			$select->orWhere('p.id  = ?',$product['product_id']);
		}
		if($this->getCount() == 0){
			return array();
		}else{
			return $this->getAdapter()->fetchAll($select);		
		}
		
	} 
	
	public function clearCartInSession() 
	{
		unset($_SESSION['cart']);
	}
	
	public function clearCart()
	{
		$userId=$this->getUserId();
		if($userId){
			$this->delete("user_id = $userId and active = 1");
		}else{
			unset($_SESSION['cart']);
		}
	}
	
	public function saveCartFromSession()
	{
			$userId=$this->getUserId();
			$cart = $this->getCart();
			
			$cartSession=array();
			if(isset($_SESSION['cart'])){
				$cartSession = $_SESSION['cart'] ;	
			}

			foreach ($cartSession as $productSession) {
				$isProduct=false;
				$productId=$productSession['product_id'];
				$count=$productSession['count'];
				foreach ($cart as $product) {
					if($product['product_id'] == $productId){
						$isProduct= true;
						break;
					}
				}
				if($isProduct){
					$this->update(array('count'=>$count), "user_id = $userId and product_id = $productId");
				}else{
					$this->insert(array('user_id' => $userId, 'product_id'=>$productId, 'count'=>$count));
				}			
			}
			$this->clearCartInSession();
	}
	
	public function deleteProduct($productId) 
	{
		$userId=$this->getUserId();
		if($userId){
			$this->delete("(user_id = $userId) AND (product_id = $productId) AND (active = 1)");
		} else {
			
			$old_cart=$this->getCart();
			$cart=array();	
		
			foreach ($old_cart as $product){
				if($product['product_id']!=$productId){
					array_push($cart, array('product_id' => $product['product_id'], 'count'=>$product['count']));
				}
			}
			$_SESSION['cart']=$cart ;	
			
		}
	}
	
	

//	public function deleteItem($category_id = null, $item_id = null)
//	{
//		if(Zend_Auth::getInstance()->hasIdentity())
//		{
//			parent::delete(Zend_Auth::getInstance()->getIdentity()->id, $item_id );
//		} else {
//			setcookie("p_".$item_id , 0, mktime(0,0,0,01,25,2008),'/');
//			unset($_COOKIE["p_".$item_id]);
//		}
//	}
	
	public function updateCount($productId=0,$count=0) 
	{
		if($count<1){
			$this->deleteProduct($productId);
		}else{
			$this->addProduct($productId, $count);
		}
	}
}
