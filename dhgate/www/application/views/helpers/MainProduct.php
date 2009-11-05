<?php
/**
 *
 * @author viknet
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * MainProduct helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_MainProduct {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 *  
	 */
	public function mainProduct() {
		
		$products= new Product();
		$mainProducts = $products->fetchAll('main = 1');
		
		
		
		$html='';
			
		foreach ($mainProducts as $product) {
			$category =$products->getCategory($product->id);
			///image
			//Zend_Debug::dump($category);
			$html.='<div class="product"><img src="/application/public/images/product/'.$product->id.'/index.png"	alt="">';
			$html.='<a href="/product/index/id/'.$product->id.'">'.$product->title.'</a>';
			if($_SESSION['admin']){
				$html.='<p><a href="/product/mainpage/id/'.$product->id.'">Remove from the Main</a></p>';			
				$html.='<p><a href="/product/delete/id/'.$product->id.'">Delete Product</a></p>';
			}
	
			
			//$html.='<p>Hard Cases for iPhone</p>';
			//$html.='<p>TG01 Quadband Phones</p>';
			$html.='<div class="more_products"><a href="/catalog/category/id/'.$category[0]['id'].'">More '.$category[0]['title'].' Wholesale »</a></div>';
			$html.='<p>&nbsp;</p>';
			$html.='</div>';
		}
		
//	
//		for ($i = 0; $i < 8; $i++) {
//			$html.='<div class="product"><img src="/application/public/img/hp1_0300.jpg"	alt="">';
//			$html.='<a href="#">i9+ Sciphone Phones</a>';
//			$html.='<p>Hard Cases for iPhone</p>';
//			$html.='<p>TG01 Quadband Phones</p>';
//			$html.='<div class="more_products"><a href="#">More Phones Wholesale »</a></div>';
//			$html.='</div>';	
//		}
		
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
