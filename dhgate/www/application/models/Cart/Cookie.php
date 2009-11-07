<?php
class Cart_Cookie  extends Cart{
	
	public function __construct(){}
	public function add($product_id, $count)
	{
		if($this->inCart($product_id)){
			return $this->updateCount($product_id, $count);
		} else {
			setcookie("p#".$product_id , $count, mktime(0,0,0,01,25,2050),'/');
			return $this->getCount();
		}
	}
	
	public function getProducts($order_id = 0)
	{
		$productTable = new Product();
		$products = array();
		$i =0;
		foreach($_COOKIE as $key => $value)
		{
			$arr = explode('#', $key);
			if($arr[0] == 'p'){
				array_push($products,$productTable->find($arr[1])->current()->toArray());
				$products[$i]['count'] = $value;
				$i++;
			}
		}
		return $products;
	}
	
	public function updateCount($product_id , $count)
	{
		if($this->inCart($product_id)){
			$count = $_COOKIE['p#'.$product_id] + $count;
			if($count>0){
				setcookie("p#".$product_id , $count, mktime(0,0,0,01,25,2050),'/');
				return $count;
			} else {
				$this->deleteProduct($product_id);
				return 0;
			}
		} else {
			return false;
		}
	}
	
	public function deleteProduct($product_id)
	{
		if($this->inCart($product_id)){
			setcookie("p#".$product_id , 0, mktime(0,0,0,01,25,2001),'/');
    		unset($_COOKIE["p#".$product_id]);
		}
	}
	
	public function getCount($order_id = 0)
	{
		$count = 0;
		foreach($_COOKIE as $key => $value)
		{
			$arr = explode('#', $key);
			if($arr[0] == 'p'){
				$count+= $value;
			}
		}
		return $count;
	}
	public function getProductCount($product_id){
		if(key_exists("p#$product_id", $_COOKIE)){
			return $_COOKIE["p#$product_id"];
		} else {
			return 0;
		}
	}
}