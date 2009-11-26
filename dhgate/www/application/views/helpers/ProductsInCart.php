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
		
		$cart = Cart::create();
	    $products =  $cart->getProducts();
		$category = new Product();
		$valute=new Valute();
		$html='';
		foreach ($products as $product){
			$album = new App_Album_Product($product['id']);
			$image = $album->getMainImage('s');
			if(!$image){
				$image="/application/public/img/product.gif";
			}
			$cat=$category->getParentCategory($product['id']);
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
					<p class="head_price">'.$valute->conversion($product['price'],2).'</p>
					<p class="head_quantity"><input coef="'.str_replace(',','.',$cat['coef']).'" class="count" category="'.$cat['id'].'" price="'.$valute->conversion($product['price'],0).'" product_id="'.$product['id'].'" type="text" value='.$product['count'].'></p>
					<p class="head_amount" product_id="'.$product['id'].'">'.$valute->conversion($product['count']*$product['price'],2).' </p>
					<p class="head_buttons"><span product_id="'.$product['id'].'"><input class="delete" product_id="'.$product['id'].'" type="submit" value="Delete"></p></span>
					</span>
					</div>';		
		}	
		return $html;
	}
	
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}
