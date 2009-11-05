<?php
/**
 *
 * @author viknet
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * ProductsInCart helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_ProductsInCart {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 *  
	 */
	public function productsInCart() {
		// TODO Auto-generated Zend_View_Helper_ProductsInCart::productsInCart() helper 
		
		$cart = new Cart();
	    $products =  $cart->getProducts();
		
//		<?php foreach ($this->products as $product):
//<p>=$product['id']</p>
//<p>=$product['title']</p>
//<p>=$product['short_about']</p>
//<p>=$product['price']</p>
//<p>&nbsp;</p>
//
//?php endforeach;

		$html='';
		foreach ($products as $product){
			$count=$cart->getProductCount($product['id']);
			$album = new App_Album_Product($product['id']);
			$image = $album->getMainImage('s');
			if(!$image){
				$image="/application/public/img/product.gif";
			}
			
			$html.=	'
					<div class="item_at_cart">
					<span product="'.$product['id'].'">
					<div class="head_desc">
						<div class="small_img_cover"><img src="'.$image.'" alt=""></div>
						<div class="small_desc"><a href="/product/index/id/'.$product['id'].'">'.$product['title'].' / '.$product['short_about'].'</a></div>
						<div class="processing_time">
						<span class="bold">Processing Time : </span>
						The item(s) will be ready for shipment within <span class="bold"> '.$product['processing'].' working days</span> after payment is received.</div>
					</div>
					<p class="head_price">USD '.$product['price'].'</p>
					<p class="head_quantity"><input class="count" price="'.$product['price'].'" product_id="'.$product['id'].'" type="text" value='.$count.'></p>
					<p class="head_amount" product_id="'.$product['id'].'">USD  '.$count*$product['price'].' </p>
					<p class="head_buttons"><span product_id="'.$product['id'].'"><input class="delete" product_id="'.$product['id'].'" type="submit" value="Delete"></p></span>
					</span>
					</div>';
			
					
		}
			
						
						 
					
					
					
					
		return $html;
	}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}
